<?php
namespace HcCore\Service;

use HcCore\Exception\InvalidArgumentException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Zend\Http\PhpEnvironment\Request;
use Zend\Http\PhpEnvironment\Response;
use Zf2Libs\Paginator\Doctrine\CollectionPaginator;
use Zf2Libs\Paginator\Doctrine\QueryPaginator;
use Zf2Libs\Paginator\DojoRestStore\Paginator;

class DojoRestStorePaginatorFactory
{
    /**
     * @var bool
     */
    protected $fetchJoinCollection;

    /**
     * @param bool $fetchJoinCollection
     */
    public function __construct($fetchJoinCollection = true)
    {
        $this->fetchJoinCollection = $fetchJoinCollection;
    }

    /**
     * @param Query | QueryBuilder | ArrayCollection $data
     * @param Request $request
     *
     * @param Response $response
     * @throws \HcCore\Exception\InvalidArgumentException
     * @return Paginator
     */
    public function getPaginator($data, Request $request, Response $response)
    {
        if ($data instanceof QueryBuilder ||
            $data instanceof Query) {
            $adapter = new QueryPaginator($data, $this->fetchJoinCollection);
        } else if ($data instanceof ArrayCollection) {
            $adapter = new CollectionPaginator($data);
        } else {
            throw new InvalidArgumentException("Could not create valid adapter");
        }

        return new Paginator($adapter,
                             $request->getHeaders(),
                             $response->getHeaders());
    }
}
