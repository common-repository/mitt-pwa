<?php

namespace MITTPWAWP\Inc\Admin;

//use \MITTPWAWP\Serviceworker as Manifest;
//use MITTPWAWP\Serviceworker as Serviceworker;


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @author    Your Name or Your Company
 */
class Admin
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
    public $cache_key;
    public $cache_allowed;
    public $plugin_slug;

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
        $this->plugin_slug = plugin_basename(__DIR__);
        $this->version = $version;
        $this->plugin_text_domain = $plugin_text_domain;
        $this->cache_key = 'mittpwawp_custom_upd';
        $this->cache_allowed = false;


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
         * defined in Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/mittpwa-admin.css', array('wp-color-picker'), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        /*
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
        

        wp_enqueue_media();
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/mittpwa-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false);
    
    }


    public function mittpwa_sidebar_register_assets()
    {
        wp_register_script(
            'mittpwa-sidebar-js',
            plugins_url('mittpwa-sidebar.js', __FILE__),
            array(
                    'wp-plugins',
                    'wp-edit-post',
                    'wp-element',
                    'wp-components',
                    'wp-i18n',
                    'wp-data'
                )
        );
    }

    public function process_setting_form()
    {
        if (!isset($_POST['mittpwaadminform_nonce']) && !wp_verify_nonce(sanitize_text_field( wp_unslash($_POST['mittpwaadminform_nonce'])), 'mittpwaadminform_action')) {
            return;
        }
    }



    public function mittpwa_sidebar_register_meta()
    {
        register_post_meta('post', 'sidebar_plugin_meta_block_field', array(
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
        ));
    }
    //TODO: Rewrite this function after SVN is set up
    public function update_request()
    {
        $update_server_url = ''; // Replace with the URL of your update server endpoint after SVN is set up

        //$response = wp_remote_get($update_server_url);

        $remote = get_transient($this->cache_key);

        if(false === $remote || ! $this->cache_allowed) {

            $remote = wp_remote_get(
                $update_server_url,
                array(
                    'timeout' => 10,
                    'headers' => array(
                        'Accept' => 'application/json'
                    )
                )
            );

            if(
                is_wp_error($remote)
                || 200 !== wp_remote_retrieve_response_code($remote)
                || empty(wp_remote_retrieve_body($remote))
            ) {
                return false;
            }

            set_transient($this->cache_key, $remote, DAY_IN_SECONDS);

        }

        $remote = json_decode(wp_remote_retrieve_body($remote));

        return $remote;

    }

    public function info($false, $action, $args)
    {

        print_r($action);
        print_r($args);

        // do nothing if you're not getting plugin information right now
        if('plugin_information' !== $action) {
            return $res;
        }

        // do nothing if it is not our plugin
        if($this->plugin_slug !== $args->slug) {
            return $res;
        }

        // get updates
        $remote = $this->request();

        if(! $remote) {
            return $res;
        }

        $res = new stdClass();

        $res->name = $remote->name;
        $res->slug = $remote->slug;
        $res->version = $remote->version;
        $res->tested = $remote->tested;
        $res->requires = $remote->requires;
        $res->author = $remote->author;
        $res->author_profile = $remote->author_profile;
        $res->download_link = $remote->download_url;
        $res->trunk = $remote->download_url;
        $res->requires_php = $remote->requires_php;
        $res->last_updated = $remote->last_updated;

        $res->sections = array(
            'description' => $remote->sections->description,
            'installation' => $remote->sections->installation,
            'changelog' => $remote->sections->changelog
        );

        if(! empty($remote->banners)) {
            $res->banners = array(
                'low' => $remote->banners->low,
                'high' => $remote->banners->high
            );
        }

        return $res;


        
    }

    public function update($transient)
    {

        if (empty($transient->checked)) {
            return $transient;
        }

        $remote = $this->update_request();

        if(
            $remote
            && version_compare($this->version, $remote->version, '<')
            && version_compare($remote->requires, get_bloginfo('version'), '<=')
            && version_compare($remote->requires_php, PHP_VERSION, '<')
        ) {
            $res = new \stdClass();
            $res->slug = 'mittpwafreewp';
            $res->plugin      = "{$this->plugin_slug}/{$this->plugin_slug}.php";
            $res->new_version = $remote->version;
            $res->tested = $remote->tested;
            $res->package = $remote->download_url;

            $transient->response[ $res->plugin ] = $res;

        }

        return $transient;

    }


    public function purge($upgrader, $options)
    {

        if (
            $this->cache_allowed
            && 'update' === $options['action']
            && 'plugin' === $options[ 'type' ]
        ) {
            // just clean the cache when new plugin version is installed
            delete_transient($this->cache_key);
        }

    }

   

    public function mittpwawp_plugin_metadata($meta, $file)
    {
        if ($file === 'mitt-pwa/mitt-pwa.php') {
            $meta[] = '<a href="">Check for updates</a>'; //TODO: Add the URL of the update server - SVN endpoint
            $meta[] = $this->version;
           
        }

        return $meta;
    }





   

}
