<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       localhost/wordpress/plugins/ev-forms
 * @since      1.0.0
 *
 * @package    Ev_Forms
 * @subpackage Ev_Forms/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ev_Forms
 * @subpackage Ev_Forms/public
 * @author     Everltyic <integrations@everlytic.com>
 */
class Ev_Forms_Public
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
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ev-forms-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ev-forms-public.js', array('jquery'), $this->version, false);

    }

    public function return_form_url($atts, $content, $tag)
    {
        $savedForms = get_option($this->plugin_name . '-saved');

        return '<iframe src="' . $savedForms[$tag] . '" style="width: 440px;height: 100%;border: 0px;overflow-x: hidden; overflow-y: auto;" allowTransparency="true"></iframe>';
    }

    public function create_short_code()
    {
        $savedForms = get_option($this->plugin_name . '-saved');
        if (empty($savedForms) === false) {
            foreach ($savedForms as $shortCode => $url) {
                add_shortcode($shortCode, array($this, 'return_form_url'));
            }
        }
    }

}
