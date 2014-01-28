<?php
namespace HcCore\Controller\Exception;

use HcCore\Exception\ExceptionInterface;

class UnexpectedValueException extends \UnexpectedValueException implements ExceptionInterface {}
