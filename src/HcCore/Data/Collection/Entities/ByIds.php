<?php
namespace HcCore\Data\Collection\Entities;

use HcCore\Data\DataMessagesInterface;
use HcCore\Entity\EntityInterface;
use HcCore\Service\Collection\IdsServiceInterface;
use Zend\I18n\Translator\Translator;
use Zend\InputFilter\Input;
use Zend\Validator\Callback as CallbackValidator;
use Zend\Http\PhpEnvironment\Request;
use Zf2Libs\Data\AbstractInputFilter;

class ByIds extends AbstractInputFilter implements ByIdsInterface, DataMessagesInterface
{
    /**
     * @var Translator
     */
    protected $translate;

    /**
     * @var array
     */
    protected $entities = array();

    /**
     * @var string
     */
    protected $inputName;

    /**
     * @param Request $request
     * @param IdsServiceInterface $idsCollection
     * @param Translator $translator
     * @param string $inputName
     */
    public function __construct(Request $request,
                                IdsServiceInterface $idsCollection,
                                Translator $translator,
                                $inputName='ids')
    {
        $entities = &$this->entities;
        $validate = function ($items) use ($idsCollection, &$entities){
            if (!is_array($items)) {
                $items = array((int)$items);
            }
            $entities = $idsCollection->fetch($items);
            return count($entities) == count($items);
        };

        $input = new Input($inputName);
        $input->setRequired(true);

        $input->getValidatorChain()
              ->attach(new CallbackValidator($validate));
        
        $this->add($input);

        $this->translate = $translator;

        $this->setData($request->getPost()->toArray());
    }

    /**
     * @return EntityInterface[]
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        $invalidInputs = $this->getInvalidInput();

        $messages = array();
        if (array_key_exists($this->inputName, $invalidInputs)) {
            $messages[$this->inputName] =
                $this->translate->translate('Could not delete requested entities');
        }

        return $messages;
    }
}
