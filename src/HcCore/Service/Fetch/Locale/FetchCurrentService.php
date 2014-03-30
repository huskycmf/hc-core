<?php
namespace HcCore\Service\Fetch\Locale;

use Doctrine\ORM\EntityManagerInterface;
use HcCore\Entity\Locale;
use Zend\Di\Di;

class FetchDefaultService
{
    /**
     * @var Di
     */
    protected $di;

    /**
     * @param Di $di
     */
    public function __construct(Di $di)
    {
        $this->di = $di;
    }

    /**
     * @return Locale
     */
    public function fetch()
    {
        $this->di->get('CurrentLocaleEntity');
    }
}
