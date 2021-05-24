<?php

/*
 * @author: Jared Rethman <jared.rethman@24.com>
 */

if ( !defined( 'ABSPATH' ) )
    die( '-1' );

if ( ! current_user_can( 'manage_dfp' ) )  {
    $current_user = wp_get_current_user();
    wp_die( __( '<div class="wrap"><h1>' . __('Permission error:', TF_DFP_NAME) . '</h1><div class="notice notice-error"><p>' . __('You do not have sufficient permissions to access this page. Please contact', TF_DFP_NAME) . ' <a href="mailto:24.COMOpenSourceDevTeam@ds.naspers.com?subject=DFP access request for - ' . site_url() . ' / by ' . $current_user->user_login . '">' . __(' We Admin', TF_DFP_NAME) . '</a>.</p></div></div>' ) );
}

global $tf_dfp, $tf_device_detect;
$page = $tf_dfp['pagenow'];

?>
<div class="wrap <?php echo TF_DFP_NAME . '-page-' . $page;?>" id="<?php echo str_replace('_', '-', TF_DFP_NAME);?>-wrap">
    <h1 id="tf-dfp-title"><?php echo ucwords(str_replace('_',' ', $page)); ?> - 24 DFP</h1>
    <form id="tf-dfp-admin-post" method="post">
        <!-- Submission Notices -->
        <div class="status-box notice notice-info" style="display: none;"></div>

        <?php
        require_once(  TF_DFP_CLASS_PATH . 'TF_DFP_Admin_Fields.php' );
        $fields = new TF_DFP_Admin_Fields();
        $fields->page_fields_render( $page );
        ?>
    </form>
</div>
