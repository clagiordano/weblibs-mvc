<?php

namespace clagiordano\weblibs\mvc\exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class NotFoundException
 * @package clagiordano\weblibs\mvc\exceptions
 */
class NotFoundException extends Exception implements NotFoundExceptionInterface
{

}
