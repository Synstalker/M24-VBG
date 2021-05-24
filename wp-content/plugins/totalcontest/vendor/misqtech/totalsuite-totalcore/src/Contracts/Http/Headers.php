<?php

namespace TotalContestVendors\TotalCore\Contracts\Http;
! defined( 'ABSPATH' ) && exit();


use TotalContestVendors\TotalCore\Contracts\Helpers\Arrayable;

/**
 * Interface Headers
 * @package TotalContestVendors\TotalCore\Contracts\Http
 */
interface Headers extends \ArrayAccess, Arrayable, \JsonSerializable {

}