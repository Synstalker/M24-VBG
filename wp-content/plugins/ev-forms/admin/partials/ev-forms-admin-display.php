<?php
if (!current_user_can('manage_options')) {
    return;
}
?>

<div class="wrap">
    <img src="https://www.everlytic.co.za/wp-content/uploads/2018/02/logo.png" style="width:200px; height: 39px; "/>
    <h1 style="font-weight: 600"><?= esc_html(get_admin_page_title()); ?></h1>
</div>

<div class="wrap">
    <form action="options.php" name="everlytic_api_settings" method="post">

        <?php
        $options = get_option($this->plugin_name);

        $customerName = isset($options['customer_name']) === false ? '' : $options['customer_name'];
        $apiUsername = isset($options['api_username']) === false ? '' : $options['api_username'];
        $apiKey = isset($options['api_key']) === false ? '' : $options['api_key'];
        $apiUrl = isset($options['api_url']) === false ? '' : $options['api_url'];
        ?>

        <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
        ?>
        <p style="margin-top:0px;"> </p>
        <div>
            <table>
                <tr>
                    <td>
                        <label for="<?php echo $this->plugin_name; ?>-customer_name">Customer Name</label>
                    </td>
                    <td>
                        <input size='50' type='text' id="<?php echo $this->plugin_name; ?>-customer_name"
                               name="<?php echo $this->plugin_name; ?>[customer_name]"
                               value="<?php echo $customerName; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="<?php echo $this->plugin_name; ?>-api_username">API User Name</label>
                    </td>
                    <td>
                        <input size='50' type='text' id="<?php echo $this->plugin_name; ?>-api_username"
                               name="<?php echo $this->plugin_name; ?>[api_username]"
                               value="<?php echo $apiUsername; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="<?php echo $this->plugin_name; ?>-api_key">API Key</label>
                    </td>
                    <td>
                        <input size='50' type='text' id="<?php echo $this->plugin_name; ?>-api_key"
                               name="<?php echo $this->plugin_name; ?>[api_key]" value="<?php echo $apiKey; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="<?php echo $this->plugin_name; ?>-api_url">API URL</label>
                    </td>
                    <td>
                        <input size='50' type='text' id="<?php echo $this->plugin_name; ?>-api_url"
                               name="<?php echo $this->plugin_name; ?>[api_url]" value="<?php echo $apiUrl; ?>"/>
                    </td>
                </tr>
            </table>
        </div>
        <?php submit_button(); ?> <a href="<? echo admin_url('admin.php?page=everlytic'); ?>">View Subscription Forms</a>
    </form>
</div>