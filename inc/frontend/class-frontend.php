<?php

namespace MITTPWAWP\Inc\Frontend;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @author    Your Name or Your Company
 */
class Frontend
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The text domain of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_text_domain    The text domain of this plugin.
     */
    private $plugin_text_domain;

    /**
     * Initialize the class and set its properties.
     *
     * @since       1.0.0
     * @param       string $plugin_name        The name of this plugin.
     * @param       string $version            The version of this plugin.
     * @param       string $plugin_text_domain The text domain of this plugin.
     */
    public function __construct($plugin_name, $version, $plugin_text_domain)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->plugin_text_domain = $plugin_text_domain;

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
         * defined in Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/mittpwa.css', array(), $this->version, 'all');

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
         * defined in Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name . 'main', plugin_dir_url(__FILE__) . 'js/mittpwa_main.js', array( 'jquery' ), $this->version, false);
        
       
    }
    public function add_manifest_link()
    {

      
        $settings = get_option('mittpwawp_options');
        if ($settings === '') {
            return;
        }
       
        echo '<link rel="manifest" href="'. esc_url(plugin_dir_url(__FILE__)) . 'manifest/manifest.webmanifest">';

        echo '<meta name="mobile-web-app-capable" content="yes">';
        echo '<meta name="theme-color" content="'. esc_attr($settings['theme_color']) .'">';
       
    }

    public function add_appledata_head()
    {
        $settings = get_option('mittpwawp_options');
        if ($settings === '') {
            return;
        }

        $folder_path = plugin_dir_url(__DIR__) . 'assets/icons/';

        if ($settings['ios_icon'] !== '') {
            $icon_apple = $settings['ios_icon'];
        } elseif ($settings['mittpwawp_field_use_folder_icons'] === '1') {
            $icon_apple = $folder_path . 'apple-icon-180.png';
        }

        echo '<meta name="apple-mobile-web-app-capable" content="yes">';
        echo '<meta name="apple-mobile-web-app-status-bar-style" content="'. esc_attr($settings['mittpwawp_field_ios_statusbar']) .'">';
        echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url($icon_apple) . '">';




        if ($settings['mittpwawp_field_use_folder_icons'] === '1') {
            echo '<link href="'. esc_url($folder_path) .'apple-splash-2048-2732.jpg" rel="apple-touch-startup-image" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-2732-2048.jpg" rel="apple-touch-startup-image" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-1668-2388.jpg" rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-2388-1668.jpg" rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-1536-2048.jpg" rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-2048-1536.jpg" rel="apple-touch-startup-image" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-1668-2224.jpg" rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-2224-1668.jpg" rel="apple-touch-startup-image" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-1620-2160.jpg" rel="apple-touch-startup-image" media="(device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-2160-1620.jpg" rel="apple-touch-startup-image" media="(device-width: 810px) and (device-height: 1080px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-1284-2778.jpg" rel="apple-touch-startup-image" media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-2778-1284.jpg" rel="apple-touch-startup-image" media="(device-width: 428px) and (device-height: 926px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-2532-1170.jpg" rel="apple-touch-startup-image" media="(device-width: 390px) and (device-height: 844px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-1125-2436.jpg" rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-2436-1125.jpg" rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-1242-2688.jpg" rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-2688-1242.jpg" rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-828-1792.jpg" rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-1792-828.jpg" rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-1242-2208.jpg" rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-2208-1242.jpg" rel="apple-touch-startup-image" media="(device-width: 414px) and (device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-750-1334.jpg" rel="apple-touch-startup-image" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-1334-750.jpg" rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-640-1136.jpg" rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">';
            echo '<link href="'. esc_url($folder_path) .'apple-splash-1136-640.jpg" rel="apple-touch-startup-image" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)">';
        }

    }

}
