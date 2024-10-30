<?php

namespace MITTPWAWP\Inc\Core;

use MITTPWAWP as NS;
use MITTPWAWP\Inc\Admin as Admin;
use MITTPWAWP\Inc\Admin as Settings;
use MITTPWAWP\Inc\Frontend as Frontend;
use MITTPWAWP\Serviceworker as Serviceworker;
use MITTPWAWP\Serviceworker as Manifest;
use MITTPWAWP\Inc\Admin as Updater;




/**
 * The core plugin class.
 * Defines internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @author     Your Name or Your Company
 */
class Init
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_base_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_basename;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */

    /**
     * The text domain of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $plugin_text_domain;
    protected $plugin_name;
    protected $version;
    
   
   
    /**
     * Initialize and define the core functionality of the plugin.
     */
    public function __construct()
    {

        $this->plugin_name = NS\PLUGIN_NAME;
        $this->version = NS\PLUGIN_VERSION;
        $this->plugin_basename = NS\PLUGIN_BASENAME;
        $this->plugin_text_domain = NS\PLUGIN_TEXT_DOMAIN;


        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();



    }

    /**
     * Loads the following required dependencies for this plugin.
     *
     * - Loader - Orchestrates the hooks of the plugin.
     * - Internationalization_I18n - Defines internationalization functionality.
     * - Admin - Defines all hooks for the admin area.
     * - Frontend - Defines all hooks for the public side of the site.
     *
     * @access    private
     */
    private function load_dependencies()
    {
        $this->loader = new Loader();

    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Internationalization_I18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @access    private
     */
    private function set_locale()
    {

        $plugin_i18n = new Internationalization_I18n($this->plugin_text_domain);

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @access    private
     */
    private function define_admin_hooks()
    {

        $plugin_admin = new Admin\Admin($this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        
        $this->loader->add_action('enqueue_block_editor_assets', $plugin_admin, 'mittpwa_sidebar_register_assets');
        $this->loader->add_action('init', $plugin_admin, 'mittpwa_sidebar_register_meta');
        $this->loader->add_action('update_option', $plugin_admin, 'process_setting_form');

        $plugin_manifest = new Serviceworker\Manifest($this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain());
        $this->loader->add_action('update_option', $plugin_manifest, 'settings_save');

        $plugin_serviceworker = new Serviceworker\Serviceworker($this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain());
        $this->loader->add_action('update_option', $plugin_serviceworker, 'settings_save');

        $plugin_admin_setting = new Admin\Settings($this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain());


        $this->loader->add_action('admin_init', $plugin_admin_setting, 'mittpwawp_settings_init');
        $this->loader->add_action('admin_menu', $plugin_admin_setting, 'mittpwawp_options_page');


       


    
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @access    private
     */
    private function define_public_hooks()
    {

        $plugin_public = new Frontend\Frontend($this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');

        $this->loader->add_action('wp_head', $plugin_public, 'add_manifest_link');
        $this->loader->add_action('wp_head', $plugin_public, 'add_appledata_head');

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        
        $plugin_public_sw = new Serviceworker\Serviceworker($this->get_plugin_name(), $this->get_version(), $this->get_plugin_text_domain());
   
        $this->loader->add_action('wp_head', $plugin_public_sw, 'add_sw_inline_script');


    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @return    Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Retrieve the text domain of the plugin.
     *
     * @since     1.0.0
     * @return    string    The text domain of the plugin.
     */
    public function get_plugin_text_domain()
    {
        return $this->plugin_text_domain;
    }

}
