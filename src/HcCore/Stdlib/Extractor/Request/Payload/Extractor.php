<?php
namespace HcCore\Stdlib\Extractor\Request\Payload;

use Zend\Http\PhpEnvironment\Request;
use Zend\Json\Json;
use Zf2Libs\Stdlib\Extractor\ExtractorInterface;
use Zf2Libs\Stdlib\Extractor\Exception\InvalidArgumentException;

class Extractor implements ExtractorInterface
{
    /**
     * @var Json
     */
    protected $jsonService;

    public function __construct(Json $jsonService)
    {
        $this->jsonService = $jsonService;
    }

    /**
     * Extract values from an object
     *
     * @param object $request
     * @throws \Zf2Libs\Stdlib\Extractor\Exception\InvalidArgumentException
     * @return mixed
     */
    public function extract($request)
    {
        if (!$request instanceof Request) {
            throw new InvalidArgumentException("Expected Request object, invalid object given");
        }

        if (!in_array($request->getMethod(), array('POST', 'PUT', 'PATCH'))) {
            return array();
        }

        if ($request->getHeader('ContentType')->getFieldValue() == 'application/json' &&
            strlen($request->getContent()) > 0) {
            return (array)$this->jsonService->decode($request->getContent(), Json::TYPE_ARRAY);
        } else {
            return $request->getPost()->toArray();
        }
    }
}
