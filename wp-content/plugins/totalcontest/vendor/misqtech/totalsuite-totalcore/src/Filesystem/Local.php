<?php

namespace TotalContestVendors\TotalCore\Filesystem;
! defined( 'ABSPATH' ) && exit();


use TotalContestVendors\TotalCore\Contracts\Filesystem\Base as FilesystemContract;

/**
 * Class Local
 * @package TotalContestVendors\TotalCore\Filesystem
 */
class Local extends \WP_Filesystem_Direct implements FilesystemContract {

}