<?php
namespace HcCore\Stdlib\Service\Response\Locale;

use Zend\I18n\Translator\Translator;
use Zf2Libs\Stdlib\Service\Response\Messages\Response;

class BindResponse extends Response
{
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return $this
     */
    public function localeDoesNotSupport()
    {
        $this->error($this->translator->translate('This locale does not support'));
        return $this;
    }
}
