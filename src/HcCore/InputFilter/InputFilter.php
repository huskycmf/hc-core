<?php
namespace HcCore\InputFilter;

use Zend\InputFilter\InputFilter as BaseInputFilter;
use Zend\InputFilter\Exception;
use Zend\InputFilter\InputFilterInterface;

class InputFilter extends BaseInputFilter
{
    /**
     * Retrieve a value from a named input
     *
     * @param  string $name
     * @throws Exception\InvalidArgumentException
     * @return mixed
     */
    public function getValue($name)
    {
        if (!array_key_exists($name, $this->inputs)) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects a valid input name; "%s" was not found in the filter',
                __METHOD__,
                $name
            ));
        }
        $input = $this->inputs[$name];

        if ($input instanceof InputFilterInterface) {
            return $input->getValues();
        }

        return $input->getValue();
    }
}
