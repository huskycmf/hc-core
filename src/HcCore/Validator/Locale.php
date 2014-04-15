<?php
namespace HcCore\Validator;

use Zend\Validator\AbstractValidator;

class Locale extends AbstractValidator
{
    const INVALID        = 'localeInvalid';

    protected $messageTemplates = array(
        self::INVALID        => "Invalid locale given"
    );

    /**
     * Defined by Zend\Validator\ValidatorInterface
     *
     * Returns true if and only if $value contains a valid locale
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->error(self::INVALID);
            return false;
        }

        if (!preg_match('/^[a-z]{2}(\-([a-zA-Z]{2}))?$/', $value)) {
            $this->error(self::INVALID);
            return false;
        }

        return true;
    }
}
