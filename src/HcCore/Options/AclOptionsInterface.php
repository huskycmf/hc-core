<?php
namespace HcCore\Options;

interface AclOptionsInterface
{
    /**
     * @param int $userRole
     * @return ModuleOptions
     */
    public function setDefaultUserRole($userRole);

    /**
     * @return int
     */
    public function getDefaultUserRole();
}
