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

$page = 'import';

$data = new TF_DFP_Data_Factory();
var_dump( $data->data );

?>
<div class="wrap <?php echo TF_DFP_NAME . '-page-' . $page;?>" id="<?php echo str_replace('_', '-', TF_DFP_NAME);?>-wrap">
    <h1 id="tf-dfp-title"><?php echo ucwords(str_replace('_',' ', $page)); ?> - 24 DFP</h1>
    <!--<form id="tf-dfp-admin-post" method="post">
        <div class="status-box notice notice-info" style="display: none;"></div>
    </form>-->
    <form id="tf-dfp-admin-post" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <input accept=".csv" type="file" id="config-import" class="form__input__file" />
        <label for="config-import">
            <figure>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                </svg>
            </figure>
            <span></span>
        </label>
        <input type="submit" name="btn_submit" value="Upload File" />
    </form>
    <div id="import_status"></div>
</div>
