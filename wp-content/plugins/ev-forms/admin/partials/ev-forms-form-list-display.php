<?php if (!current_user_can('manage_options')) {
    return;
}
?>

<div class="wrap">
    <img src="https://www.everlytic.co.za/wp-content/uploads/2018/02/logo.png" style="width:200px; height: 39px; "/>
    <h1 style="font-weight: 600">Forms List</h1>
</div>

<?
$apiDetails = get_option($this->plugin_name);

if (isset($apiDetails['api_username']) === false || isset($apiDetails['api_key']) === false) {
    echo $this->apiError();
} else {
    $args = array(
        'timeout' => 20,
        'headers' => array('Authorization' => 'Basic ' . base64_encode($apiDetails['api_username'] . ':' . $apiDetails['api_key']))
    );

    $response = wp_remote_get('http://' . $apiDetails['api_url'] . '/api/3.0/forms', $args);

    if (isset($response->errors)) {
        echo $this->apiError();
    } else {
        $body = json_decode(wp_remote_retrieve_body($response));
        $forms = $body->data;

        $savedForms = get_option($this->plugin_name . '-saved') === false ? array() : get_option($this->plugin_name . '-saved');
        ?>
        <div class="wrap">
            <ul style="margin-top:32px;">
                <?
                foreach ($forms as $form) { ?>
                    <li>
                        <h3 style="margin-bottom:0px;"><? echo $form->form_name; ?> <br/></h3>
                        <p style="margin-top:0px;"><? echo $form->form_description; ?> </p>

                        <? $currentCode = $this->getShortCode($form->form_embed_url);

                        if (in_array($currentCode, array_keys($savedForms))) { ?>
                            <h4 style="margin-bottom:0px;"><? echo "Short Code: [" . $currentCode . ']'; ?> <br/>
                            </h4>
                        <? } else {
                            ?>
                            <div>
                                <input class="save-code" type="submit" name="submit" value="Create Shortcode"
                                       data-embed-url="<? echo $form->form_embed_url; ?>"/>
                            </div>
                        <? } ?>
                    </li>
                <? } ?>
            </ul>

            <form id="subs-form" name="everlytic_api_settings" method="post" action="options.php">
                <?
                settings_fields($this->plugin_name . '-saved');
                do_settings_sections($this->plugin_name . '-saved');
                ?>
            </form>
        </div>
    <? }
} ?>
