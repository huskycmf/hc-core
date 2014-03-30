<?php
namespace HcCore\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements AclOptionsInterface
{
    /**
     * @var int
     */
    protected $defaultUserRole;

    /**
     * @var bool
     */
    protected $includeValidatorLocalizedMessages = true;

    /**
     * @param boolean $includeValidatorLocalizedMessages
     * @return $this
     */
    public function setIncludeValidatorLocalizedMessages($includeValidatorLocalizedMessages)
    {
        $this->includeValidatorLocalizedMessages = (boolean)$includeValidatorLocalizedMessages;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIncludeValidatorLocalizedMessages()
    {
        return $this->includeValidatorLocalizedMessages;
    }

    /**
     * @param int $userRole
     * @return ModuleOptions
     */
    public function setDefaultUserRole($userRole)
    {
        $this->defaultUserRole = $userRole;
        return $this;
    }

    /**
     * @return int
     */
    public function getDefaultUserRole()
    {
        return $this->defaultUserRole;
    }
}
