<?php
! defined( 'ABSPATH' ) && exit();

/*
 * Plugin Name: TotalContest – Pro
 * Plugin URI: https://totalsuite.net/products/totalcontest/
 * Description: Yet another powerful contest plugin for WordPress.
 * Version: 2.2.1
 * Author: TotalSuite
 * Author URI: https://totalsuite.net/
 * Text Domain: totalcontest
 * Domain Path: languages
 * Requires at least: 4.8
 * Requires PHP: 5.6
 * Tested up to: 5.6.0
 *
 * @package TotalContest
 * @category Core
 * @author TotalSuite
 * @version 2.2.1
 */

// Root plugin file name
define( 'TOTALCONTEST_ROOT', __FILE__ );

// TotalContest environment
$environment = require dirname( __FILE__ ) . '/env.php';

// Include plugin setup
include_once dirname( __FILE__ ) . '/setup.php';

// Setup
new TotalContestSetup( $environment );
// Oh yeah, we're up and running!
