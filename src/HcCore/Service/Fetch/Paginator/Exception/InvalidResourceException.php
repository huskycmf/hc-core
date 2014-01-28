<?php
namespace HcCore\Service\Fetch\Paginator\Exception;

use HcCore\Exception\InvalidArgumentException;

class InvalidResourceException extends
    InvalidArgumentException implements InvalidResourceExceptionInterface {}
