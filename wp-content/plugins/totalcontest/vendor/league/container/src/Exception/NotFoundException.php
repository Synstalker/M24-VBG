<?php

namespace TotalContestVendors\League\Container\Exception;
! defined( 'ABSPATH' ) && exit();


use TotalContestVendors\Interop\Container\Exception\NotFoundException as NotFoundExceptionInterface;
use InvalidArgumentException;

class NotFoundException extends InvalidArgumentException implements NotFoundExceptionInterface
{
}
