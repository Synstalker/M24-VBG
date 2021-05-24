<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       localhost/wordpress/plugins/ev-forms
 * @since      1.0.0
 *
 * @package    Ev_Forms
 * @subpackage Ev_Forms/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ev_Forms
 * @subpackage Ev_Forms/admin
 * @author     Everltyic <integrations@everlytic.com>
 */
class Ev_Forms_Admin
{
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ev_Forms_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ev_Forms_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ev-forms-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Ev_Forms_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Ev_Forms_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ev-forms-admin.js', array('jquery'), $this->version, false);
    }

    public function add_plugin_admin_menu()
    {
        add_options_page(
            'Api Settings',
            'Everlytic Api',
            'manage_options',
            $this->plugin_name,
            array($this, 'display_plugin_setup_page')
        );

        add_menu_page(
            'My Forms',
            'Everlytic Forms',
            'manage_options',
            'everlytic',
            array($this, 'ev_forms_view_forms_page')
        );
    }

    public function add_action_links($links)
    {
        $settings_link = array(
            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);
    }

    public function display_plugin_setup_page()
    {
        include_once('partials/ev-forms-admin-display.php');
    }

    public function ev_forms_view_forms_page()
    {
        include_once('partials/ev-forms-form-list-display.php');
    }

    public function options_update()
    {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate_input'));
        add_option($this->plugin_name, null);
        register_setting($this->plugin_name . '-saved', $this->plugin_name . '-saved', array($this, 'save_short_code'));
    }

    public function validate_input($input)
    {
        if (empty($input) === false) {
            $args = array(
                'timeout' => 20,
                'headers' => array(
                    'Authorization' => 'Basic ' . base64_encode($input['api_username'] . ':' . $input['api_key'])
                )
            );

            $response = wp_remote_get('http://' . $input['api_url'] . '/api/2.0/lists?count=0', $args);

            if ($response === null || wp_remote_retrieve_response_code($response) !== 200) {
                add_settings_error($this->plugin_name, 400, 'The API details that you entered are incorrect');
                unset($input['api_username']);
                unset($input['api_key']);
            }
        }
        return $input;
    }

    public function apiError()
    {
        return '<div class="wrap">
                    <h4 style="margin-bottom:0px;">An error occurred while retrieving your subscription forms. 
                    Please check your API details on the <a href="options-general.php?page=' . $this->plugin_name . ' ">
                    API Settings</a> page and try again.</h4>
                </div>';
    }

    public function save_short_code($input)
    {
        if (isset($input['url'])) {
            $url = $input['url'];

            $data = array($this->getShortCode($url) => $url);

            $existingCodes = get_option($this->plugin_name . '-saved');
            if ($existingCodes !== false) {
                $data = array_merge($data, $existingCodes);
            }

            return $data;
        } else {
            return $input;
        }
    }

    /**
     * @param $url
     * @return string
     */
    private function getShortCode($url)
    {
        $shortCodeId = substr($url, (strpos($url, '==') - 10), 4);
        return 'short_evform_' . strtolower($shortCodeId);
    }
}
