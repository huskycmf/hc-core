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
     * @var string
     */
    protected $defaultLanguage;

    /**
     * @param string $defaultLanguage
     * @return ModuleOptions
     */
    public function setDefaultLanguage($defaultLanguage)
    {
        $this->defaultLanguage = $defaultLanguage;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultLanguage()
    {
        return $this->defaultLanguage;
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
