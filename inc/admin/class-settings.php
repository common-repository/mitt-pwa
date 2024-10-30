<?php

namespace MITTPWAWP\Inc\Admin;

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @author     Your Name or Your Company
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 */
class Settings
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
     * custom option and settings
     */
    public function mittpwawp_settings_init()
    {

        // Register a new setting for "mittpwafreewp" page.
        register_setting('mitt-pwa', 'mittpwawp_options');

        // Register a new section in the "mittpwafreewp" page.
        add_settings_section(
            'mittpwawp_section_general',
            __('General', 'mitt-pwa'),
            array($this,  'mittpwawp_section_general_callback'),
            'mitt-pwa'
        );

        // Register a new field in the "mittpwawp_section_general" section, inside the "mittpwafreewp" page.
        add_settings_field(
            'mittpwawp_field_intervall', 
            __('Time Intervall', 'mitt-pwa'),
            array($this, 'mittpwawp_field_intervall_cb'),
            'mitt-pwa',
            'mittpwawp_section_general',
            array(
                'label_for'         => 'mittpwawp_field_intervall',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

        // Register a new field in the "mittpwawp_section_general" section, inside the "mittpwafreewp" page.
        add_settings_field(
            'mittpwawp_field_intervall', 
            __('Time Intervall', 'mitt-pwa'),
            array($this,  'mittpwawp_field_intervall_cb'),
            'mitt-pwa',
            'mittpwawp_section_general',
            array(
                'label_for'         => 'mittpwawp_field_intervall',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'mittpwawp_field_pull_refresh', 
            __('Pull to Refresh', 'mitt-pwa'),
            array($this,  'mittpwawp_field_pull_refresh_cb'),
            'mitt-pwa',
            'mittpwawp_section_general',
            array(
                'label_for'         => 'mittpwawp_field_pull_refresh',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'mittpwawp_field_overwrite_serviceworker_file', 
            __('Overwrite Scope Service Worker File', 'mitt-pwa'),
            array($this,  'mittpwawp_field_overwrite_serviceworker_file_cb'),
            'mitt-pwa',
            'mittpwawp_section_general',
            array(
                'label_for'         => 'mittpwawp_field_overwrite_serviceworker_file',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );


  

        add_settings_field(
            'mittpwawp_field_scope_app_url', 
            __('Scope of the APP', 'mitt-pwa'),
            array($this,  'mittpwawp_field_scope_app_cb'),
            'mitt-pwa',
            'mittpwawp_section_general',
            array(
                'label_for'         => 'mittpwawp_field_scope_app',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );
    
        add_settings_field(
            'mittpwawp_field_debug_mode', 
            __('Debug Mode', 'mitt-pwa'),
            array($this,  'mittpwawp_field_debug_mode_cb'),
            'mitt-pwa',
            'mittpwawp_section_general',
            array(
                'label_for'         => 'mittpwawp_field_debug_mode_app',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'mittpwawp_field_unregister_service_worker', 
            __('Unregister Service Worker', 'mitt-pwa'),
            array($this,  'mittpwawp_field_unregister_service_worker_cb'),
            'mitt-pwa',
            'mittpwawp_section_general',
            array(
                'label_for'         => 'mittpwawp_unregister_service_worker_app',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );


        add_settings_section(
            'mittpwawp_section_cache',
            __('Cache', 'mitt-pwa'),
            array($this,  'mittpwawp_section_cache_callback'),
            'mitt-pwa'
        );

        add_settings_field(
            'mittpwawp_field_cache_first', 
            __('Cache First', 'mitt-pwa'),
            array($this,  'mittpwawp_field_cache_first_cb'),
            'mitt-pwa',
            'mittpwawp_section_cache',
            array(
                'label_for'         => 'mittpwawp_field_cache_first',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'mittpwawp_field_network_connection', 
            __('Cache First depend on Network Connection', 'mitt-pwa'),
            array($this, 'mittpwawp_field_network_connection_cb'),
            'mitt-pwa',
            'mittpwawp_section_cache',
            array(
                'label_for'         => 'mittpwawp_field_network_connection',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'mittpwawp_field_cdn', 
            __('CDN', 'mitt-pwa'),
            array($this,  'mittpwawp_field_cdn_cb'),
            'mitt-pwa',
            'mittpwawp_section_cache',
            array(
                'label_for'         => 'mittpwawp_field_cdn',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'mittpwawp_field_static_cache_list', 
            __('Static Cache', 'mitt-pwa'),
            array($this, 'mittpwawp_field_static_cache_list_cb'),
            'mitt-pwa',
            'mittpwawp_section_cache',
            array(
                'label_for'         => 'mittpwawp_field_static_cache_list',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'mittpwawp_field_cache_exceptions_list', 
            __('Cache Exceptions', 'mitt-pwa'),
            array($this, 'mittpwawp_field_cache_exceptions_list_cb'),
            'mitt-pwa',
            'mittpwawp_section_cache',
            array(
                'label_for'         => 'mittpwawp_field_cache_exceptions_list',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'mittpwawp_field_debug_fetch_request', 
            __('Debug Fetch Requests', 'mitt-pwa'),
            array($this, 'mittpwawp_field_debug_fetch_request_cb'),
            'mitt-pwa',
            'mittpwawp_section_cache',
            array(
                'label_for'         => 'mittpwawp_field_debug_fetch_request',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'mittpwawp_field_fetch_exceptions_list', 
            __('Fetch Exceptions', 'mitt-pwa'),
            array($this, 'mittpwawp_field_fetch_exceptions_list_cb'),
            'mitt-pwa',
            'mittpwawp_section_cache',
            array(
                'label_for'         => 'mittpwawp_field_fetch_exceptions_list',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

        add_settings_field(
            'mittpwawp_field_debug_fetch_exceptions', 
            __('Debug Fetch Exceptions', 'mitt-pwa'),
            array($this, 'mittpwawp_field_debug_fetch_exceptions_cb'),
            'mitt-pwa',
            'mittpwawp_section_cache',
            array(
                'label_for'         => 'mittpwawp_field_debug_fetch_exceptions',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );


        add_settings_section(
            'mittpwawp_section_manifest',
            __('Manifest', 'mitt-pwa'),
            array($this, 'mittpwawp_section_manifest_callback'),
            'mitt-pwa'
        );

        add_settings_field(
            'mittpwawp_field_app_short_name', 
            __('App Short Name', 'mitt-pwa'),
            array($this, 'mittpwawp_field_app_short_name_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_app_short_name',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

    
        add_settings_field(
            'mittpwawp_field_app_name', 
            __('App Name', 'mitt-pwa'),
            array($this, 'mittpwawp_field_app_name_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                'label_for'         => 'mittpwawp_field_app_name',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
                )
        );
        
        add_settings_field(
            'mittpwawp_field_start_url', 
            __('Start Url', 'mitt-pwa'),
            array($this, 'mittpwawp_field_start_url_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_start_url',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        add_settings_field(
            'mittpwawp_field_custom_start_url', 
            __('Custom Start Url', 'mitt-pwa'),
            array($this, 'mittpwawp_field_custom_start_url_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_custom_start_url',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        
        add_settings_field(
            'mittpwawp_field_app_id', 
            __('App Id', 'mitt-pwa'),
            array($this, 'mittpwawp_field_app_id_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                'label_for'         => 'mittpwawp_field_app_id',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );


        add_settings_field(
            'mittpwawp_field_app_description', 
            __('App Description', 'mitt-pwa'),
            array($this, 'mittpwawp_field_app_description_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_app_description',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        add_settings_field(
            'mittpwawp_field_use_app_shortcuts', 
            __('Use App Shortcuts', 'mitt-pwa'),
            array($this, 'mittpwawp_field_use_app_shortcuts_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_use_app_shortcuts',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        add_settings_field(
            'mittpwawp_field_app_shortcuts', 
            __('App Shortcut Items', 'mitt-pwa'),
            array($this, 'mittpwawp_field_app_shortcuts_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_app_shortcuts',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        add_settings_field(
            'mittpwawp_field_use_protocol_handler', 
            __('Use Protocol Handler', 'mitt-pwa'),
            array($this, 'mittpwawp_field_use_protocol_handler_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_use_protocol_handler',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        add_settings_field(
            'mittpwawp_field_protocol_handler_items', 
            __('Protocol Handler Items', 'mitt-pwa'),
            array($this, 'mittpwawp_field_protocol_handler_items_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_protocol_handler_items',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        add_settings_field(
            'mittpwawp_field_background_color', 
            __('Background Color', 'mitt-pwa'),
            array($this, 'mittpwawp_field_background_color_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_background_color',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        add_settings_field(
            'mittpwawp_field_theme_color', 
            __('Theme Color', 'mitt-pwa'),
            array($this, 'mittpwawp_field_theme_color_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_theme_color',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        add_settings_field(
            'mittpwawp_field_app_display', 
            __('App Display', 'mitt-pwa'),
            array($this, 'mittpwawp_field_app_display_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_app_display',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

    
    
        add_settings_field(
            'mittpwawp_field_use_svg_icon', 
            __('Use SVG Icon', 'mitt-pwa'),
            array($this,  'mittpwawp_field_use_svg_icon_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                'label_for'         => 'mittpwawp_field_use_svg_icon',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
                )
        );
        
        add_settings_field(
            'mittpwawp_field_use_folder_icons', 
            __('Use only folder for icons', 'mitt-pwa'),
            array($this,  'mittpwawp_field_use_folder_icons_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_use_folder_icons',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        add_settings_field(
            'mittpwawp_field_manifest_icon', 
            __('Manifest Icon', 'mitt-pwa'),
            array($this, 'mittpwawp_field_manifest_icon_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_manifest_icon',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        add_settings_field(
            'mittpwawp_field_manifest_icon_maskable', 
            __('Manifest Icon Maskable', 'mitt-pwa'),
            array($this, 'mittpwawp_field_manifest_icon_maskable_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_manifest_icon_maskable',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );


        add_settings_field(
            'mittpwawp_field_use_app_screenshots', 
            __('Use App Screenshots', 'mitt-pwa'),
            array($this, 'mittpwawp_field_use_app_screenshots_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                        'label_for'         => 'mittpwawp_field_use_app_screenshots',
                        'class'             => 'mittpwawp_row',
                        'mittpwawp_custom_data' => 'custom',
                    )
        );


        add_settings_field(
            'mittpwawp_field_screenshots', 
            __('App Screenshots', 'mitt-pwa'),
            array($this, 'mittpwawp_field_screenshots_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                        'label_for'         => 'mittpwawp_field_screenshots',
                        'class'             => 'mittpwawp_row',
                        'mittpwawp_custom_data' => 'custom',
                    )
        );

    
        add_settings_field(
            'mittpwawp_field_manifest_ios_icon', 
            __('iOS Icon', 'mitt-pwa'),
            array($this, 'mittpwawp_field_ios_icon_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_ios_icon',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );
    
        add_settings_field(
            'mittpwawp_field_manifest_ios_splashscreen', 
            __('iOS Splashscreen', 'mitt-pwa'),
            array($this, 'mittpwawp_field_ios_splashscreen_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_ios_splashscreen',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );

        add_settings_field(
            'mittpwawp_field_manifest_ios_statusbar', 
            __('iOS Status Bar', 'mitt-pwa'),
            array($this, 'mittpwawp_field_ios_statusbar_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_ios_statusbar',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );


        add_settings_field(
            'mittpwawp_field_install_ios', 
            __('Show Install Banner iOS', 'mitt-pwa'),
            array($this, 'mittpwawp_field_install_banner_ios_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_install_banner_ios',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );



        add_settings_field(
            'mittpwawp_field_ios_banner_popup_click', 
            __('iOS Banner Popup Click', 'mitt-pwa'),
            array($this, 'mittpwawp_field_ios_banner_popup_click_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_ios_banner_popup_click',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );



        add_settings_field(
            'mittpwawp_field_app_installation_button', 
            __('App Installation Button', 'mitt-pwa'),
            array($this, 'mittpwawp_field_app_installation_button_cb'),
            'mitt-pwa',
            'mittpwawp_section_manifest',
            array(
                    'label_for'         => 'mittpwawp_field_app_installation_button',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );


        add_settings_section(
            'mittpwawp_section_push_notification',
            __('Push Notification', 'mitt-pwa'),
            array($this, 'mittpwawp_section_push_notification_callback'),
            'mitt-pwa'
        );


        add_settings_field(
            'mittpwawp_field_push_messaging_cta', 
            __('', 'mitt-pwa'),
            array($this,'mittpwawp_field_push_messaging_cta_cb'),
            'mitt-pwa',
            'mittpwawp_section_push_notification'
        );

        


        add_settings_section(
            'mittpwawp_section_firebase_settings',
            __('Firebase Settings', 'mitt-pwa'),
            array($this, 'mittpwawp_section_firebase_settings_callback'),
            'mitt-pwa'
        );

        add_settings_field(
            'mittpwawp_field_firebase_cta', 
            __('', 'mitt-pwa'),
            array($this, 'mittpwawp_field_firebase_cta_cb'),
            'mitt-pwa',
            'mittpwawp_section_firebase_settings',
        );

      
        add_settings_section(
            'mittpwawp_section_sync',
            __('Sync', 'mitt-pwa'),
            array($this, 'mittpwawp_section_sync_callback'),
            'mitt-pwa'
        );
    
        add_settings_field(
            'mittpwawp_field_cta_page_sync', 
            __('', 'mitt-pwa'),
            array($this, 'mittpwawp_field_cta_page_sync_cb'),
            'mitt-pwa',
            'mittpwawp_section_sync',
           
        );

       
        add_settings_section(
            'mittpwawp_section_statistic',
            __('Statistic', 'mitt-pwa'),
            array($this,  'mittpwawp_section_statistic_callback'),
            'mitt-pwa'
        );


        add_settings_field(
            'mittpwawp_field_statistic_cb', 
            __('Statistic', 'mitt-pwa'),
            array($this,  'mittpwawp_field_statistic_cb'),
            'mitt-pwa',
            'mittpwawp_section_statistic',
            array(
                        'label_for'         => 'mittpwawp_field_statistic',
                        'class'             => 'mittpwawp_row',
                        'mittpwawp_custom_data' => 'custom',
                )
        );


        add_settings_section(
            'mittpwawp_section_update',
            __('Update', 'mitt-pwa'),
            array($this, 'mittpwawp_section_update_callback'),
            'mitt-pwa'
        );

        add_settings_field(
            'mittpwawp_field_update_key', 
            __('Update Key', 'mitt-pwa'),
            array($this, 'mittpwawp_field_update_key_cb'),
            'mitt-pwa',
            'mittpwawp_section_update',
            array(
                    'label_for'         => 'mittpwawp_field_update_key_list',
                    'class'             => 'mittpwawp_row',
                    'mittpwawp_custom_data' => 'custom',
                )
        );


        add_settings_section(
            'mittpwawp_section_changelog',
            __('Changelog', 'mitt-pwa'),
            array($this, 'mittpwawp_section_changelog_callback'),
            'mitt-pwa'
        );

        add_settings_field(
            'mittpwawp_field_changelog', 
            __('Changelog', 'mitt-pwa'),
            array($this, 'mittpwawp_render_xml_output_cb'),
            'mitt-pwa',
            'mittpwawp_section_changelog',
            array(
                'label_for'         => 'mittpwawp_field_changelog_list',
                'class'             => 'mittpwawp_row',
                'mittpwawp_custom_data' => 'custom',
            )
        );

     

        add_settings_field(
            'mittpwawp_field_active_tab', 
            __('', 'mitt-pwa'),
            array($this, 'mittpwawp_field_active_tab_cb'),
            'mitt-pwa',
            'mittpwawp_section_changelog', 
            array(
                        'label_for'         => 'mittpwawp_field_active_tab',
                        'class'             => 'mittpwawp_row',
                        'mittpwawp_custom_data' => 'custom',
                    )
        );
    }

    /**
     * Register our mittpwawp_settings_init to the admin_init action hook.
     */
    //add_action('admin_init', 'mittpwawp_settings_init');



    /**
     * Custom option and settings:
     *  - callback functions
     */


    /**
     * general section callback function.
     *
     * @param array $args  The settings array, defining title, id, callback.
     */
    public function mittpwawp_section_general_callback($args)
    {
        ?>
            <p id="<?php echo esc_attr($args['id']); ?>">
                <?php esc_html_e('General Settings', 'mitt-pwa'); ?>
            </p>
            <?php
    }

    public function mittpwawp_section_cache_callback($args)
    {
        ?>
        <p id="<?php echo esc_attr($args['id']); ?>">
            <?php esc_html_e('Cache Settings', 'mitt-pwa'); ?>
        </p>
        <?php
    }

    public function mittpwawp_section_manifest_callback($args)
    {
        ?>
        <p id="<?php echo esc_attr($args['id']); ?>">
            <?php esc_html_e('Manifest Settings', 'mitt-pwa'); ?>
        </p>
        <?php
    }

    public function mittpwawp_section_push_notification_callback($args)
    {
        ?>
        <p id="<?php echo esc_attr($args['id']); ?>">
            <?php esc_html_e('Push Notification Settings', 'mitt-pwa'); ?>
        </p>
        <?php
    }

    public function mittpwawp_section_firebase_settings_callback($args)
    {
        ?>
        <p id="<?php echo esc_attr($args['id']); ?>">
            <?php esc_html_e('Firebase Settings', 'mitt-pwa'); ?>
        </p>
    <?php
    }

    public function mittpwawp_section_sync_callback($args)
    {
        ?>
        <p id="<?php echo esc_attr($args['id']); ?>">
            <?php esc_html_e('Sync', 'mitt-pwa'); ?>
        </p>
        <?php
    }

    public function mittpwawp_section_statistic_callback($args)
    {
        ?>
        <p id="<?php echo esc_attr($args['id']); ?>">
            <?php esc_html_e('Statistic', 'mitt-pwa'); ?>
        </p>
            <?php
    }

    public function mittpwawp_section_update_callback($args)
    {
        ?>
        <p id="<?php echo esc_attr($args['id']); ?>">
            <?php esc_html_e('Update', 'mitt-pwa'); ?>
        </p>
        <?php
    }

    public function mittpwawp_section_changelog_callback($args)
    {
        ?>
        <p id="<?php echo esc_attr($args['id']); ?>">
            <?php esc_html_e('Changelog', 'mitt-pwa'); ?>
        </p>
        <?php
    }


    /**
     * intervall field callbakc function.
     *
     * WordPress has magic interaction with the following keys: label_for, class.
     * - the "label_for" key value is used for the "for" attribute of the <label>.
     * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
     * Note: you can add custom key value pairs to be used inside your callbacks.
     *
     * @param array $args
     */
    public function mittpwawp_field_intervall_cb($args)
    {
    ?>
        <p><strong>Time intervall for the Service Worker update the App automatically is available in
                        <a id="cta-pro" target="_blank" href="https://mittl-medien.de/product-wordpress-pwa">
                            miTT PWA Fire Push
                        </a>
                        Pro version.
                        </strong>
                        </p>
                    
        <p class="description">
        <?php esc_html_e('Time Intervall to update the Service Worker in the Background', 'mitt-pwa'); ?>
        </p>
        <?php
    }

    public function mittpwawp_field_pull_refresh_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <select
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
            name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]">
            <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
                <?php esc_html_e('Yes', 'mitt-pwa'); ?>
            </option>
            <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
                <?php esc_html_e('No', 'mitt-pwa'); ?>
            </option>
        </select>
        <p class="description">
            <?php esc_html_e('Pull to Refresh as know from Native Apps', 'mitt-pwa'); ?>

        </p>

        <?php
    }

    public function mittpwawp_field_overwrite_serviceworker_file_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <select
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
            name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]">
            <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
                <?php esc_html_e('No', 'mitt-pwa'); ?>
            </option>
            <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
                <?php esc_html_e('Yes', 'mitt-pwa'); ?>
            </option>
        </select>
        <p class="description">
            <?php esc_html_e('Overwrite Scope Service Worker File', 'mitt-pwa'); ?>
        </p>
        <?php
    }



    public function mittpwawp_field_scope_app_cb($args)
    {
        ?>
                <p><strong>Scope of the App is available in
                <a id="cta-pro" target="_blank" href="https://mittl-medien.de/product-wordpress-pwa">
                    miTT PWA Fire Push
                </a>
                Pro version.
                </strong>
                </p>
                <?php
    }

    public function mittpwawp_field_debug_mode_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <select
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
            name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]">
            <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
                <?php esc_html_e('No', 'mitt-pwa'); ?>
            </option>
            <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
                <?php esc_html_e('Yes', 'mitt-pwa'); ?>
            </option>
        </select>
        <p class="description">
            <?php esc_html_e('Debug shows console.log in the Browser Console', 'mitt-pwa'); ?>
        </p>
        <?php
        }

        public function mittpwawp_field_unregister_service_worker_cb($args)
        {
            $options = get_option('mittpwawp_options');
        ?>
        <select
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
            name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]">
            <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
                <?php esc_html_e('No', 'mitt-pwa'); ?>
            </option>
            <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
                <?php esc_html_e('Yes', 'mitt-pwa'); ?>
            </option>
        </select>
        <p class="description">
    <?php esc_html_e('Do only activated, if you would like to quit the app', 'mitt-pwa'); ?>

</p>
<?php
    }



    public function mittpwawp_field_cache_first_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <select
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
            name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]"
            class="mitt_pwa_select_showon">
            <option value="networkfirst" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'networkfirst', false)) : (''); ?>>
                <?php esc_html_e('Network First', 'mitt-pwa'); ?>
            </option>
            <option value="cachefirst" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'cachefirst', false)) : (''); ?>>
                <?php esc_html_e('Cache First', 'mitt-pwa'); ?>
            </option>
        </select>
        <p class="description">
            <?php esc_html_e('Cache or Network First', 'mitt-pwa'); ?>
        </p>
        <?php
    }

    public function mittpwawp_field_network_connection_cb($args)
    {
        ?>
        <p><strong>Cache first depends on the network connection is available in
            <a id="cta-pro" target="_blank" href="https://mittl-medien.de/product-wordpress-pwa">
                    miTT PWA Fire Push
                </a>
                Pro version.
                </strong>
        </p>
            
        <?php
    }

    public function mittpwawp_field_cdn_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<select
    id="<?php echo esc_attr($args['label_for']); ?>"
    data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
    name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]"
    class="">
    <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
        <?php esc_html_e('No', 'mitt-pwa'); ?>
    </option>
    <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
        <?php esc_html_e('Yes', 'mitt-pwa'); ?>
    </option>
</select>
<p class="description">
    <?php esc_html_e('Do you use a CDN?', 'mitt-pwa'); ?>
</p>
<?php
    }

    public function mittpwawp_field_static_cache_list_cb($args)
    { ?>
     <p><strong>Static Cache List is available in
        <a id="cta-pro" target="_blank" href="https://mittl-medien.de/product-wordpress-pwa">
            miTT PWA Fire Push
        </a>
        Pro version.
        </strong>
    </p>
     <?php
    }

    public function mittpwawp_field_cache_exceptions_list_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <code>mypath</code>
        <?php echo esc_html__('Put here the keyword, whiche url should be not cached in the browser for example login', 'mitt-pwa'); ?>
        </p>
        <div class="mittpwa_multiple_input">
            <?php
            $svg = $this->createMinusSvg();
            $allowed_html = $this->allowHtmlSvg();

            if(!isset($options['cache_exceptions']) || empty($options['cache_exceptions'])):  ?>
            <div class="mittPwaInputContainer"><input type="text" data-count="1" name="mittpwawp_options[cache_exceptions][1]"
                    id="mittpwawp_cache_exceptions_1"
                    class="cache_exceptions"
                        value="<?php echo(isset($options['cache_exceptions']['1']) ? esc_attr($options['cache_exceptions']['1']) : 'login'); ?>"><span
                        class="mittPwaRemove"><?php echo wp_kses($svg, $allowed_html); ?></span></div>
            <?php else: ?>
            <?php
        
        $count = 1;
        if(isset($options['cache_exceptions']) || !empty($options['cache_exceptions'])) {
            foreach ($options['cache_exceptions'] as $value) {
                    echo '<div class="mittPwaInputContainer"><input type="text" name="mittpwawp_options_cache_exceptions_[' . esc_attr($count) . '] id="mittpwawp_cache_exceptions_' . esc_attr($count) . '" 
                    class="cache_exceptions"  value="' . esc_attr($value) . '" data-count="' . esc_attr($count) . '"><span class="mittPwaRemove">' . wp_kses($svg, $allowed_html) . '</span></div>';
                $count++;
            }
        } ?>
    <?php endif; ?>

    <p class="description">
        <button class="mittPwaAddNew button button-primary">
            Add new
        </button>
    </p>
</div <?php
    }

    public function mittpwawp_field_debug_fetch_request_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<select
    id="<?php echo esc_attr($args['label_for']); ?>"
    data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
    name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]">
    <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
        <?php esc_html_e('No', 'mitt-pwa'); ?>
    </option>
    <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
        <?php esc_html_e('Yes', 'mitt-pwa'); ?>
    </option>
</select>
<p class="description">
    <?php esc_html_e('Debug Fetch Request', 'mitt-pwa'); ?>

</p>
<?php
    }

    public function mittpwawp_field_fetch_exceptions_list_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<code>keyword</code>
<?php echo esc_html__('put the only the keyword for the urls you would like to ignore from the service worker', 'mitt-pwa'); ?>

</p>
<div class="mittpwa_multiple_input">

    <?php
                    $svg = $this->createMinusSvg();
                    $allowed_html = $this->allowHtmlSvg();

            
        if(!isset($options['fetch_exceptions']) || empty($options['fetch_exceptions'])):  ?>
    <div class="mittPwaInputContainer"><input type="text" data-count="1" name="mittpwawp_options[fetch_exceptions][1]"
            id="<?php echo esc_attr('mittpwawp_fetch_exceptions_' . $count) ?>"
            class="fetch_exceptions"
            value="<?php echo(isset($options['fetch_exceptions']['1'])? esc_attr($options['fetch_exceptions']['1']) : '/mypath'); ?>"><span
            class="mittPwaRemove"><?php echo wp_kses($svg, $allowed_html); ?></span></div>
    <?php else: ?>
    <?php
        
        $count = 1;
        if(isset($options['fetch_exceptions']) || !empty($options['fetch_exceptions'])) {
            foreach ($options['fetch_exceptions'] as $value) {
                echo '<div class="mittPwaInputContainer"><input type="text" name="' . esc_attr('mittpwawp_options[fetch_exceptions][' . $count . ']') . '" id="' . esc_attr('mittpwawp_fetch_exceptions_' . $count) . '" class="fetch_exceptions"  value="' . esc_attr($value) . '" data-count="' .  esc_attr($count) .'"><span class="mittPwaRemove">' . wp_kses($svg, $allowed_html) . '</span></div>';
                $count++;
            }
        } ?>
    <?php endif; ?>

    <p class="description">
        <?php esc_html_e('the word contains in the path of the fetch request', 'mitt-pwa'); ?>
        <br><button class="mittPwaAddNew button button-primary">
            Add new
        </button>


    </p>
</div <?php
    }




    public function mittpwawp_field_debug_fetch_exceptions_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<select
    id="<?php echo esc_attr($args['label_for']); ?>"
    data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
    name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]">
    <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
        <?php esc_html_e('No', 'mitt-pwa'); ?>
    </option>
    <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
        <?php esc_html_e('Yes', 'mitt-pwa'); ?>
    </option>
</select>
<p class="description">
    <?php esc_html_e('Debug Fetch Exceptions', 'mitt-pwa'); ?>

</p>
<?php
    }
    /** Manifest
     * Section **/
    public function mittpwawp_field_app_short_name_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<input type="text" name="mittpwawp_options[app_short_name]" id="mittpwawp_options[app_short_name]" class=""
    value="<?php echo(isset($options['app_short_name'])? esc_attr($options['app_short_name']) : 'App Short Name'); ?>">
<p class="description">
    <?php esc_html_e('', 'mitt-pwa'); ?>
</p>
</div <?php
    }



    public function mittpwawp_field_app_name_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<input type="text" name="mittpwawp_options[app_name]" id="mittpwawp_options[app_name]" class=""
    value="<?php echo(isset($options['app_name'])? esc_attr($options['app_name']) : 'App Name'); ?>">
<p class="description">
    <?php esc_html_e('', 'mitt-pwa'); ?>
</p>
</div <?php
    }

    public function mittpwawp_field_start_url_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<select name="mittpwawp_options[start_url]" class="mitt_pwa_select_showon">
    <?php
            echo '<option value="custom_start_url" ' . esc_html($selected) . '>' . 'Custom URL' . '</option>';
        //get pages dropdown
        $pages = get_pages();
        if ($pages) {
            foreach ($pages as $page) {
                $selected = '';
                if ($options['start_url'] == $page->ID) {
                    $selected = 'selected';
                }
                echo '<option value="' . esc_attr($page->ID) . '" ' . esc_attr($selected) . '>' . esc_html($page->post_title) . '</option>';
            }
        }
        ?>
</select>
</div> <?php
    }

    public function mittpwawp_field_custom_start_url_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <input type="text" name="mittpwawp_options[custom_start_url]" id="mittpwawp_options[custom_start_url]" class=""
            value="<?php echo(isset($options['custom_start_url'])? esc_attr($options['custom_start_url']) : '/'); ?>">
        <p class="description">
            <?php esc_html_e('Set your custom url /yourUrl', 'mitt-pwa'); ?>
        </p>
        </div <?php
    }


    public function mittpwawp_field_app_id_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <input type="text" name="mittpwawp_options[app_id]" id="mittpwawp_options[app_id]" class=""
            value="<?php echo(isset($options['app_id'])? esc_attr($options['app_id']) : 'App Id'); ?>">
        <p class="description">
            <?php esc_html_e('', 'mitt-pwa'); ?>
        </p>
        </div <?php
    }

    public function mittpwawp_field_app_description_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <input type="text" size="50" name="mittpwawp_options[app_description]" id="mittpwawp_options[app_description]" class=""
            value="<?php echo(isset($options['app_description'])? esc_attr($options['app_description']) : 'App Description'); ?>">
        <p class="description">
            <?php esc_html_e('', 'mitt-pwa'); ?>
        </p>
        </div <?php
    }

    public function mittpwawp_field_use_app_shortcuts_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <select
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
            name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]"
            class="mitt_pwa_select_showon">
            <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
                <?php esc_html_e('Yes', 'mitt-pwa'); ?>
            </option>
            <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
                <?php esc_html_e('No', 'mitt-pwa'); ?>
            </option>
        </select>
        <p class="description">
            <?php esc_html_e('', 'mitt-pwa'); ?>
        </p>
        <?php
    }


    public function mittpwawp_field_app_shortcuts_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>

</p>
<div class="mittpwa_multiple_input">

    <?php
                    $svg = $this->createMinusSvg();
                    $allowed_html = $this->allowHtmlSvg();

        ?>
    <?php $count = 0; ?>
    <?php if (isset($options['app_shortcut_items'])): ?>
    <?php foreach ((array)$options['app_shortcut_items'] as $value): ?>
    <?php //var_dump($value);?>
    <?php
        if(isset($options['app_shortcut_items'][$count]['app_screenshot_name']) || empty($options['app_shortcut_items'][$count]['app_screenshot_name'])):  ?>
    <div class="mittPwaInputContainer">
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[app_shortcut_items]['. $count . '][app_screenshot_name])') ?>">App Shortcut Name</label>
            <input type="text" data-count="<?php echo esc_attr($count); ?>"
                name="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_screenshot_name]') ?>"
                id="mittpwawp_appshortname" class="appshortcutitems"
                value="<?php echo(isset($options['app_shortcut_items'][$count]['app_screenshot_name'])?
                        esc_attr($options['app_shortcut_items'][$count]['app_screenshot_name']) : 'Name like Open News'); ?>">
        </div>
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_shortname]')?>">App
                Shortcut Short Name</label>
            <input type="text" data-count="<?php esc_attr($count); ?>"
                name="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_shortname]')?>"
                id="mittpwawp_appshortname" class="appshortcutitems"
                value="<?php echo(isset($options['app_shortcut_items'][$count]['app_shortcut_shortname'])? esc_attr($options['app_shortcut_items'][$count]['app_shortcut_shortname']) : 'Short Name'); ?>">
        </div>
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_description]') ?>">App Shortcut Description</label>
            <input type="text" data-count="<?php esc_attr($count) ?>"
                name="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_description]') ?>"
                id="mittpwawp_appshortname" class="appshortcutitems"
                value="<?php echo(isset($options['app_shortcut_items'][$count]['app_shortcut_description'])?
                        esc_attr($options['app_shortcut_items'][$count]['app_shortcut_description']) : 'Description'); ?>">
        </div>
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_page_item]') ?>">Page</label>
            <select
                name="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_page_item]') ?>">
                <?php
                    if($pages = get_pages()) {
                        if ($pages) {
                            foreach($pages as $page) {
                                echo esc_html('<option value="' . $page->ID . '" ' . selected($page->ID, $options['app_shortcut_items'][$count]['app_shortcut_page_item']) . '>' . $page->post_title . '</option>');
                            }
                        }
                    }
            ?>
            </select>

        </div>
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_icon]')?>">App Shortcut Icon</label>
            <input type="text"
                name="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_icon]')?>"
                id="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_icon]')?>"
                class="mittpwawp_options_app_shortcut_app_shortcut_icon" size="50" value="<?php echo esc_attr(isset($options['app_shortcut_items'][$count]['app_shortcut_icon'])) ?
        esc_attr($options['app_shortcut_items'][$count]['app_shortcut_icon'])
        : ''; ?>">
            <button class="button mittpwa_icon_upload" type="button">Select Icon</button>
        </div>
        <span class="mittPwaRemove"><?php if ($count === 1 || $count > 1) {
            echo wp_kses($svg, $allowed_html);
        }?></span>
    </div>
    <?php $count++; ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php else: ?>
    <div class="mittPwaInputContainer">
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' .  $count .'][app_shortcut_name]') ?>">App
                Shortcut Name</label>
            <input type="text" data-count="<?php echo esc_attr($count); ?>"
                name="<?php echo esc_attr('mittpwawp_oaptions[app_shortcut_items][' . $count . '][app_shortcut_name]') ?>"
                id="mittpwawp_appshortname" class="appshortcutitems"
                value="<?php echo(isset($options['app_shortcut_items'][$count]['app_shortcut_name'])?
            esc_attr($options['app_shortcut_items'][$count]['app_shortcut_name']) : 'Name like Open News'); ?>">
        </div>
        <div class="mittpwa_label_input">
            <label for="mittpwawp_options[app_shortcut_items][$count][app_shortcut_shortname]">App Shortcut Short
                Name</label>
            <input type="text" data-count="<?php echo esc_attr($count); ?>"
                name="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' .  $count . '][app_shortcut_shortname]') ?>"
                id="mittpwawp_appshortname" class="appshortcutitems"
                value="<?php echo(isset($options['app_shortcut_items'][$count]['app_shortcut_shortname'])? esc_attr($options['app_shortcut_items'][$count]['app_shortcut_shortname']) : 'Short Name'); ?>">
        </div>
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_description]' ) ?>">App
                Shortcut Description</label>
            <input type="text" data-count="<?php echo esc_attr($count); ?>"
                name="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' .  $count . '][app_shortcut_description]' ) ?>"
                id="mittpwawp_appshortname" class="appshortcutitems"
                value="<?php echo(isset($options['app_shortcut_items'][$count]['app_shortcut_description'])?
            esc_attr($options['app_shortcut_items'][$count]['app_shortcut_description']) : 'Description'); ?>">
        </div>
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' .  $count . '][app_shortcut_page_item]') ?>">App
                Shortcut Url</label>
            <select
                name="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_page_item]' ) ?>">
                <?php
            if($pages = get_pages()) {
                if ($pages) {
                    foreach($pages as $page) {
                
                        echo '<option value="' . esc_attr($page->ID) . '" ' . selected(esc_attr($page->ID), $options['app_shortcut_items'][esc_attr($count)]['app_shortcut_page_item']) . '>' . esc_html($page->post_title) . '</option>';
                    
                    }
                }
            }
        ?>
            </select>
        </div>
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_icon]') ?>">App Shortcut Icon</label>
            <input type="text"
                name="<?php echo esc_attr('mittpwawp_options[app_shortcut_items][' . $count . '][app_shortcut_icon]' ) ?>"
                id="<?php echo esc_attr('mittpwawp_options[app_shortcut_items]' . $count . '[app_shortcut_icon]' ) ?>"
                class="mittpwawp_options_app_shortcut_app_shortcut_icon" size="50" value="<?php echo isset($options['app_shortcut_items'][$count]['app_shortcut_icon']) ?
        esc_attr($options['app_shortcut_items'][$count]['app_shortcut_icon'])
        : ''; ?>">
            <button class="button mittpwa_icon_upload" type="button">Select Icon</button>
        </div>
    </div>


    <?php endif; ?>
    <?php //endif;?>
    <?php //var_dump($options['app_shortcut_items']);?>
    <p class="description">
        <?php esc_html_e('App Shortcut setting', 'mitt-pwa'); ?>
        <br><button class="mittPwaAddNewShortcutItems button button-primary">
            Add new
        </button>
    </p>
</div <?php
    }

    public function mittpwawp_field_use_protocol_handler_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<select
    id="<?php echo esc_attr($args['label_for']); ?>"
    data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
    name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]"
    class="mitt_pwa_select_showon">
    <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
        <?php esc_html_e('Yes', 'mitt-pwa'); ?>
    </option>
    <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
        <?php esc_html_e('No', 'mitt-pwa'); ?>
    </option>
</select>
<p class="description">
    <?php esc_html_e('', 'mitt-pwa'); ?>
</p>
<?php
    }

    public function mittpwawp_field_protocol_handler_items_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>

</p>
<div class="mittpwa_multiple_input">
    <?php
        $svg = $this->createMinusSvg();
        $allowed_html = $this->allowHtmlSvg();

        ?>
    <?php $count = 0; ?>
    <?php if (isset($options['protocol_handler_items'])): ?>
    <?php foreach ((array)($options['protocol_handler_items']) as $value): ?>
    <?php //$escValue = esc_attr($value);?>
    <?php
        if(isset($options['protocol_handler_items'][$count]['protocol_handler_protocol']) || empty($options['protocol_handler_items'][$count]['protocol_handler_protocol'])):  ?>
    <div class="mittPwaInputContainer">
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[protocol_handler_items][' .  $count . '][protocol_handler_protocol]' ) ?>">Protocol</label>
            <input type="text" data-count="<?php echo esc_attr($count); ?>"
                name="<?php echo esc_attr('mittpwawp_options[protocol_handler_items][' . $count . '][protocol_handler_protocol]' ) ?>"
                id="mittpwawp_appshortname" class="appprotocol_handleritems"
                value="<?php echo(isset($options['protocol_handler_items'][$count]['protocol_handler_protocol'])?
                        esc_attr($options['protocol_handler_items'][$count]['protocol_handler_protocol']) : esc_attr($value)); ?>">
        </div>
        <div class="mittpwa_label_input">
            <label for="<?php echo esc_attr('mittpwawp_options[protocol_handler_items][' . $count . '][protocol_handler_url]' ) ?>">Url</label>
            <input type="text" data-count="<?php echo esc_attr($count); ?>"
                name="<?php echo esc_attr('mittpwawp_options[protocol_handler_items][' . $count .'][protocol_handler_url]' ) ?>"
                id="mittpwawp_appshortname" class="appprotocol_handleritems"
                value="<?php echo(isset($options['protocol_handler_items'][$count]['protocol_handler_url'])? esc_attr($options['protocol_handler_items'][$count]['protocol_handler_url']) : esc_attr($value)); ?>">
        </div>
        <span class="mittPwaRemove"><?php if ($count === 1 || $count > 1) {
            echo wp_kses($svg, $allowed_html);
        }?></span>
    </div>
    <?php $count++; ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php else:?>
    <?php //if(isset($options['protocol_handler_items'][$count]['protocol_handler_protocol']) || empty($options['protocol_handler_items'][$count]['protocol_handler_protocol'])):?>
    <div class="mittPwaInputContainer">
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[protocol_handler_items][' . $count . '][protocol_handler_protocol]' ) ?>">Protocol</label>
            <input type="text" data-count="<?php echo esc_attr($count); ?>"
                name="<?php esc_attr('mittpwawp_options[protocol_handler_items][' . $count . '][protocol_handler_protocol]' ) ?>"
                id="mittpwawp_appshortname" class="appprotocol_handleritems"
                value="<?php echo(isset($options['protocol_handler_items'][$count]['protocol_handler_protocol'])?
                esc_attr($options['protocol_handler_items'][$count]['protocol_handler_protocol']) : 'web+blog'); ?>">
        </div>
        <div class="mittpwa_label_input">
            <label for="mittpwawp_options[protocol_handler_items][protocol_handler_url]">Url</label>
            <input type="text" data-count="<?php echo esc_attr($count); ?>"
                name="<?php esc_attr('mittpwawp_options[protocol_handler_items][' . $count . '][protocol_handler_url]' ) ?>"
                id="mittpwawp_appshortname" class="appprotocol_handleritems"
                value="<?php echo(isset($options['protocol_handler_items'][$count]['protocol_handler_url'])? esc_attr($options['protocol_handler_items'][$count]['protocol_handler_url']) : 'Url'); ?>">
        </div>
    </div>
    <?php endif; ?>
    <p class="description">
        <?php esc_html_e('Protocol Handler setting', 'mitt-pwa'); ?>
        <br><button class="mittPwaAddNewShortcutItems button button-primary">
            Add new
        </button>
    </p>
</div> <?php
    }


    // Form Field to set a background color
    public function mittpwawp_field_background_color_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<div class="mittPwaInputContainer">
    <div class="mittpwa_label_input">
        <label for="mittpwawp_options[background_color]">Background Color</label>
        <input type="text" name="mittpwawp_options[background_color]" id="mittpwawp_options[background_color]"
            class="color-picker"
            value="<?php echo(isset($options['background_color'])? esc_attr($options['background_color']) : '#707070'); ?>"
            data-default-color="#fff" />


    </div>
    <p class="description">
        <?php esc_html_e('Background Color setting', 'mitt-pwa'); ?>
    </p>
</div <?php
    }

    public function mittpwawp_field_theme_color_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<div class="mittPwaInputContainer">
    <div class="mittpwa_label_input">
        <label for="mittpwawp_options[theme_color]">Theme Color</label>
        <input type="text" name="mittpwawp_options[theme_color]" id="mittpwawp_options[theme_color]"
            class="color-picker"
            value="<?php echo(isset($options['theme_color'])? esc_attr($options['theme_color']) : '#707070'); ?>"
            data-default-color="#fff" />


    </div>
    <p class="description">
        <?php esc_html_e('Theme Color setting', 'mitt-pwa'); ?>
    </p>
</div <?php
    }


    public function mittpwawp_field_app_display_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<select
    id="<?php echo esc_attr($args['label_for']); ?>"
    data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
    name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]">
    <option value="standalone" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'standalone', false)) : (''); ?>>
        <?php esc_html_e('standalone', 'mitt-pwa'); ?>
    </option>
    <option value="fullscreen" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'fullscreen', false)) : (''); ?>>
        <?php esc_html_e('fullscreen', 'mitt-pwa'); ?>
    </option>
    <option value="minimal-ui" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'minimal-ui', false)) : (''); ?>>
        <?php esc_html_e('minimal-u', 'mitt-pwa'); ?>
    </option>
    <option value="browser" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'browser', false)) : (''); ?>>
        <?php esc_html_e('browser', 'mitt-pwa'); ?>
    </option>
</select>
<p class="description">
    <?php esc_html_e('standalone is like the app like setting (recommended)', 'mitt-pwa'); ?>
</p>
<?php
    }




    public function mittpwawp_field_use_svg_icon_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <select
            id="<?php echo esc_attr($args['label_for']); ?>"
            data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
            name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]">
            <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
                <?php esc_html_e('Yes', 'mitt-pwa'); ?>
            </option>
            <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
                <?php esc_html_e('No', 'mitt-pwa'); ?>
            </option>
        </select>
        <p class="description">
            <?php esc_html_e('Please upload the icon to the /asset/icons/ folder', 'mitt-pwa'); ?>
        </p>
        <?php
    }

    public function mittpwawp_field_use_folder_icons_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<select
    id="<?php echo esc_attr($args['label_for']); ?>"
    data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
    name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]"
    class="mitt_pwa_select_showon_folder">
    <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
        <?php esc_html_e('Yes', 'mitt-pwa'); ?>
    </option>
    <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
        <?php esc_html_e('No', 'mitt-pwa'); ?>
    </option>
</select>
<p class="description">
    <?php esc_html_e('use only /asset/icons/ folder for icons - recommendation if you use all icons', 'mitt-pwa'); ?>
</p>
<?php
    }


    public function mittpwawp_field_manifest_icon_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>

<input type="text" name="mittpwawp_options[manifest_icon]" id="mittpwawp_options[manifest_icon]"
    class="mittpwawp_options_manifest_icon mitt_pwa_folder" size="50" value="<?php echo isset($options['manifest_icon']) ?
                        esc_attr($options['manifest_icon'])
                        : ''; ?>">
<button class="button mittpwa_icon_upload" type="button">Select Icon</button>
<p class="description">
    <?php esc_html_e('Icon with 512 x 512px', 'mitt-pwa'); ?>
</p>
<?php
    }

    public function mittpwawp_field_manifest_icon_maskable_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<input type="text" name="mittpwawp_options[manifest_icon_maskable]" id="mittpwawp_options[manifest_icon_maskable]"
    class="mittpwawp_options_manifest_icon mitt_pwa_folder" size="50" value="<?php echo isset($options['manifest_icon_maskable']) ?
                        esc_attr($options['manifest_icon_maskable'])
                        : ''; ?>">
<button class="button mittpwa_icon_upload" type="button">Select Icon</button>
<p class="description">
    <?php esc_html_e('Icon with 512 x 512px', 'mitt-pwa'); ?>
</p>
<?php
    }

    public function mittpwawp_field_install_banner_ios_cb($args)
    {
        ?>
        <p><strong>Install Banner for iOS is only available in the
            <a id="cta-pro" target="_blank" href="https://mittl-medien.de/product-wordpress-pwa">
                    miTT PWA Fire Push
            </a>
                Pro version.
            </strong>
        </p>
    <?php

    }

    public function mittpwawp_field_use_app_screenshots_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<select
    id="<?php echo esc_attr($args['label_for']); ?>"
    data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
    name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]"
    class="mitt_pwa_select_showon">
    <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
        <?php esc_html_e('Yes', 'mitt-pwa'); ?>
    </option>
    <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
        <?php esc_html_e('No', 'mitt-pwa'); ?>
    </option>
</select>
<p class="description">
    <?php esc_html_e('', 'mitt-pwa'); ?>
</p>
<?php
    }



    public function mittpwawp_field_screenshots_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
</p>
<div class="mittpwa_multiple_input">

    <?php
        $svg = $this->createMinusSvg();
        $allowed_html = $this->allowHtmlSvg();
        ?>
    <?php $count = 0; ?>
    <?php if (isset($options['screenshot'])): ?>
    <?php foreach ((array)$options['screenshot'] as $value): ?>
    <div class="mittPwaInputContainer">


        <?php
        if(isset($options['screenshot'][$count]['screenshot_image']) || empty($options['screenshot'][$count]['screenshot_image'])):  ?>

        <div class="mittpwa_label_input">
            <label for="mittpwawp_options[screenshot_image]">Screenshot Image</label>
            <input type="text" data-count="<?php echo esc_attr($count); ?>"
                name="<?php echo esc_attr('mittpwawp_options[screenshot][' . $count .'][screenshot_image]' ) ?>"
                id="<?php echo esc_attr('mittpwawp_options[screenshot][' . $count . '][screenshot_image]' ) ?>"
                class="mittpwawp_options_screenshot_image_1_shortcut_icon" size="50"
                value="<?php echo esc_html($value['screenshot_image'])  ?>">
            <button class="button mittpwa_icon_upload" type="button">Select Image</button>
            <span class="mittPwaRemove"><?php echo wp_kses($svg, $allowed_html);?></span>
        </div>

        <?php $count++; ?>
    </div>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php else: ?>
    <?php if(isset($options['screenshot'][$count]['screenshot_image']) || empty($options['screenshot'][$count]['screenshot_image'])):  ?>
    <div class="mittPwaInputContainer">


        <div class="mittpwa_label_input">
            <label for="mittpwawp_options[screenshot_image]">Screenshot Image</label>
            <input type="text" data-count="<?php echo esc_attr($count); ?>"
                name="<?php echo esc_attr('mittpwawp_options[screenshot][' .  $count . '][screenshot_image]' ) ?>"
                id="<?php echo esc_attr('mittpwawp_options[screenshot_image][' . $count . '][screenshot_image]' ) ?>"
                class="mittpwawp_options_screenshot_image_1_screenshot_image" size="50" value="<?php echo isset($options['screenshot_image']) ?
            esc_attr($options['screenshot_image'])
            : 'Select your Image'; ?>">
            <button class="button mittpwa_icon_upload" type="button">Select Image</button>
        </div>
    </div>


    <?php endif; ?>
    <?php endif; ?>

    <p class="description">
        <?php esc_html_e('Screenshots improve the Install Banner', 'mitt-pwa'); ?>
        <br><button class="mittPwaAddNewShortcutItems button button-primary">
            Add new
        </button>
    </p>
</div <?php
    }



    public function mittpwawp_field_ios_icon_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<input type="text" name="mittpwawp_options[ios_icon]" id="mittpwawp_options[ios_icon]"
    class="mittpwawp_options_ios_icon mitt_pwa_folder" size="50" value="<?php echo isset($options['ios_icon']) ?
                        esc_attr($options['ios_icon'])
                        : ''; ?>">
<button class="button mittpwa_icon_upload" type="button">Select Icon</button>
<p class="description">
    <?php esc_html_e('Icon with 180 x 180px', 'mitt-pwa'); ?>
</p>
<?php
    }

    public function mittpwawp_field_ios_splashscreen_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>

<input type="text" name="mittpwawp_options[ios_splashscreen]" multiple="multiple"
    id="mittpwawp_options[ios_splashscreen]" class="mittpwawp_options_ios_splashscreen mitt_pwa_folder" size="50" value="<?php echo isset($options['ios_splashscreen']) ?
                esc_attr($options['ios_splashscreen'])
                : ''; ?>">
<button class="button mittpwa_icons_upload" type="button">Select Image</button>
<p class="description">
    <?php esc_html_e('Genrate you iOS Splash Screen Images', 'mitt-pwa'); ?>
</p>
<?php
    }

    public function mittpwawp_field_ios_statusbar_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<select
    id="<?php echo esc_attr($args['label_for']); ?>"
    data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
    name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]">
    <option value="default" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'default', false)) : (''); ?>>
        <?php esc_html_e('default', 'mitt-pwa'); ?>
    </option>
    <option value="black" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'black', false)) : (''); ?>>
        <?php esc_html_e('black', 'mitt-pwa'); ?>
    </option>
    <option value="black-translucent" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'black-translucent', false)) : (''); ?>>
        <?php esc_html_e('black-translucent', 'mitt-pwa'); ?>
    </option>
</select>
<p class="description">
    <?php esc_html_e('', 'mitt-pwa'); ?>
</p>
<?php
    }



    public function mittpwawp_field_ios_banner_popup_click_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <p><strong>Pop up for iOS Banner is only available in the
                <a id="cta-pro" target="_blank" href="https://mittl-medien.de/product-wordpress-pwa">
                    miTT PWA Fire Push
                </a>
                Pro version.
                </strong>
            </p>
        <?php
    }

    public function mittpwawp_field_ios_popup_click_menupage_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<select name="mittpwawp_options[ios_popup_click_menupage]">
    <?php
                $pages = get_pages();
        if ($pages) {
            foreach ($pages as $page) {
                $selected = '';
                if ($options['ios_popup_click_menupage'] == $page->ID) {
                    $selected = 'selected';
                }
                echo '<option value="' . esc_attr($page->ID) . '" ' . esc_attr($selected) . '>' . esc_html($page->post_title) . '</option>';
            }
        }
        ?>
</select>
<p class="description">
    <?php esc_html_e('', 'mitt-pwa'); ?>
</p>
<?php
    }

    public function mittpwawp_field_app_installation_button_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<select
    id="<?php echo esc_attr($args['label_for']); ?>"
    data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
    name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]">
    <option value="standard" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'standard_install_prompt)', false)) : (''); ?>>
        <?php esc_html_e('Standard (Install Prompt)', 'mitt-pwa'); ?>
    </option>
    <option value="custom_button_prevent_prompt" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'custom_button_prevent_prompt', false)) : (''); ?>>
        <?php esc_html_e('Custom Button + Prevent Install Prompt', 'mitt-pwa'); ?>
    </option>
    <option value="custom_button_install_prompt" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'custom_button_install_prompt', false)) : (''); ?>>
        <?php esc_html_e('Custom Button + Install Prompt', 'mitt-pwa'); ?>
    </option>
    <option value="prevent_install_prompt" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], 'prevent_install_prompt', false)) : (''); ?>>
        <?php esc_html_e('Prevent Install Prompt', 'mitt-pwa'); ?>
    </option>
</select>
<p class="description">
    <?php esc_html_e('', 'mitt-pwa'); ?>
</p>
<?php
    }

    /** Push Notification
     * Section **/
    public function mittpwawp_field_title_push_notification_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<input type="text" name="mittpwawp_options[title_push_notification]" id="mittpwawp_options[title_push_notification]"
    class=""
    value="<?php echo(isset($options['title_push_notification'])? esc_attr($options['title_push_notification']) : 'miTT PWA Fire Push'); ?>">
<p class="description">
    <?php esc_html_e('', 'mitt-pwa'); ?>
</p>
</div <?php
    }


    public function mittpwawp_field_push_messaging_cta_cb($args)
    {
        ?>
        <a id="cta-pro" target="_blank" href="https://mittl-medien.de/product-wordpress-pwa">
            <img src="<?php echo esc_url(plugins_url('../assets/images/push-notification.jpg', __DIR__));?>"
                alt="Push Notification Image">
        </a>
         <?php
    }


    /** Firebase
     * Section **/
    public function mittpwawp_field_firebase_cta_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <a id="cta-pro" target="_blank" href="https://mittl-medien.de/product-wordpress-pwa">
            <img src="<?php echo esc_url(plugins_url('../assets/images/firebase-settings.jpg', __DIR__));?>"
                alt="Push Notification Firebase">
        </a> 
        <?php
    }

   

    public function mittpwawp_field_cta_page_sync_cb($args)
   
    {
        $options = get_option('mittpwawp_options');
        ?>
            <a id="cta-pro" target="_blank" href="https://mittl-medien.de/product-wordpress-pwa">
                <img  src="<?php echo esc_url(plugins_url('../assets/images/page-image-sync.jpg', __DIR__));?>"
                    alt="Image Sync">
            </a> 
            <?php
    }


    public function mittpwawp_field_page_sync_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
<div class="mittpwa_multiple_input">
    <?php
        $svg = $this->createMinusSvg();
        $allowed_html = $this->allowHtmlSvg();
        ?>
    <?php $count = 0; ?>
    <?php if (isset($options['page_sync'])): ?>
    <?php foreach ((array)$options['page_sync'] as $value): ?>
    <?php
        if(isset($options['page_sync'][$count]['page_sync_interval']) || empty($options['page_sync'][$count]['page_sync'])):  ?>
    <div class="mittPwaInputContainer">
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[page_sync][' .  $count . '][page_sync_item]' ) ?>">Page</label>
            <select
                name="<?php echo esc_attr('mittpwawp_options[page_sync][' .  $count . '][page_sync_item]' ) ?>"
                data-count="<?php echo esc_attr($count); ?>">
                <?php
                if($pages = get_pages()) {
                    if ($pages) {
                        foreach($pages as $page) {
                            echo '<option value="' . esc_attr($page->ID) . '" ' . selected(esc_attr($page->ID), $options['page_sync'][$count]['page_sync_item']) . '>' . esc_html($page->post_title) . '</option>';
                        }
                    }
                }
            ?>
            </select>
        </div>
        <span class="mittPwaRemove"><?php if ($count === 1 || $count > 1) {
            echo wp_kses($svg, $allowed_html);
        } ?></span>
    </div>
    <?php $count++; ?>
    <?php endif; ?>
    <?php endforeach; ?>
    <?php else: ?>
    <?php if(isset($options['page_sync'][$count]['page_sync_page']) || empty($options['page_sync'][$count]['page_sync_page'])):  ?>
    <div class="mittPwaInputContainer">
        <div class="mittpwa_label_input">
            <label
                for="<?php echo esc_attr('mittpwawp_options[page_sync][' . $count . '][page_sync_item]')?>">Page</label>
            <select
                name="<?php echo esc_attr('mittpwawp_options[page_sync][' . $count . '][page_sync_item]')?>"
                data-count="<?php echo esc_attr($count); ?>>
                        <?php
        if($pages = get_pages()) {
            if ($pages) {
                foreach($pages as $page) {
                    echo '<option value="' . esc_attr($page->ID) . '" ' . selected(esc_attr($page->ID), $options['page_sync'][$count]['page_sync_item']) . '>' . esc_html($page->post_title) . '</option>';
                }
            }
        }
        ?>
                    </select>
                </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <p class="description">
            <?php esc_html_e('Pages will be sync in the background (chromium based feature)', 'mitt-pwa'); ?>
            <br><button class="mittPwaAddNewShortcutItems button button-primary">
                Add new
            </button>
        </p>
    </div <?php
    }

    public function mittpwawp_field_unregister_page_sync_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
    <select
        id="<?php echo esc_attr($args['label_for']); ?>"
        data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
        name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]"
        class="mitt_pwa_select_showon_sync_unregister">
        <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
            <?php esc_html_e('Yes', 'mitt-pwa'); ?>
        </option>
        <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
            <?php esc_html_e('No', 'mitt-pwa'); ?>
        </option>
    </select>
    <p class="description">
        <?php esc_html_e('', 'mitt-pwa'); ?>
    </p>
    <?php
    }


    public function mittpwawp_field_register_image_sync_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
    <select
        id="<?php echo esc_attr($args['label_for']); ?>"
        data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
        name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]"
        class="mitt_pwa_select_showon_sync_register">
        <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
            <?php esc_html_e('Yes', 'mitt-pwa'); ?>
        </option>
        <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
            <?php esc_html_e('No', 'mitt-pwa'); ?>
        </option>
    </select>
    <p class="description">
        <?php esc_html_e('', 'mitt-pwa'); ?>
    </p>
    <?php
    }

    public function mittpwawp_field_image_sync_interval_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
    <select
        id="<?php echo esc_attr($args['label_for']); ?>"
        data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
        name="mittpwawp_options[image_sync_interval]" class="">
        <option value="3" <?php echo isset($options['image_sync_interval']) ? (selected($options['image_sync_interval'], '3', false)) : (''); ?>>
            <?php esc_html_e('3h', 'mitt-pwa'); ?>
        </option>
        <option value="6" <?php echo isset($options['image_sync_interval']) ? (selected($options['image_sync_interval'], '6', false)) : (''); ?>>
            <?php esc_html_e('6h', 'mitt-pwa'); ?>
        </option>
        <option value="12" <?php echo isset($options['image_sync_interval']) ? (selected($options['image_sync_interval'], '12', false)) : (''); ?>>
            <?php esc_html_e('12h', 'mitt-pwa'); ?>
        </option>
        <option value="23" <?php echo isset($options['image_sync_interval']) ? (selected($options['image_sync_interval'], '23', false)) : (''); ?>>
            <?php esc_html_e('23h', 'mitt-pwa'); ?>
        </option>
    </select>
    <p class="description">
        <?php esc_html_e('', 'mitt-pwa'); ?>
    </p>
    <?php
    }


    public function mittpwawp_field_image_sync_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
    <div class="mittpwa_multiple_input">
        <?php
            $svg = $this->createMinusSvg();
            $allowed_html = $this->allowHtmlSvg();

        ?>
        <?php $count = 0; ?>
        <?php if (isset($options['image_sync'])): ?>
        <?php foreach ((array)$options['image_sync'] as $value): ?>
        <?php
        if(isset($options['image_sync'][$count]['image_sync_item']) || empty($options['image_sync_item'][$count]['image_sync'])):  ?>
        <div class="mittPwaInputContainer">
            <div class="mittpwa_label_input">
                <label
                    for="<?php echo esc_attr('mittpwawp_options[image_sync][' .  $count . '][image_sync_item]' ) ?>">Image</label>
                <input type="text"
                    name="<?php echo esc_attr('mittpwawp_options[image_sync][' . $count . '][image_sync_item]' ) ?>"
                    id="mittpwawp_options[image_sync_image]" 
                    class="mittpwawp_options_image_sync_image" size="50" value="<?php echo isset($options['image_sync'][$count]['image_sync_item']) ?
                esc_attr($options['image_sync'][$count]['image_sync_item'])
                : ''; ?>"
                    data-count="<?php echo esc_attr($count); ?>">
                <button class="button mittpwa_icon_upload" type="button">Select Image</button>
            </div>
            <span class="mittPwaRemove"><?php if ($count === 1 || $count > 1) {
                echo wp_kses($svg, $allowed_html);
            } ?></span>
        </div>
        <?php $count++; ?>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php else: ?>
        <?php if(isset($options['image_sync'][$count]['image_sync_item']) || empty($options['image_sync'][$count]['image_sync_item'])):  ?>
        <div class="mittPwaInputContainer">
            <div class="mittpwa_label_input">
                <label
                    for="<?php echo esc_attr('mittpwawp_options[image_sync][' . $count . '][image_sync_item]')?>">Image</label>
                <input type="text"
                    name="<?php echo esc_attr('mittpwawp_options[image_sync][' . $count . '][image_sync_item]');?>"
                    id="mittpwawp_options[image_sync_image]" class="mittpwawp_options_image_sync_image" size="50" value="<?php echo isset($options['image_sync'][$count]['image_sync_item']) ?
            esc_attr($options['image_sync'][$count]['image_sync_item'])
            : ''; ?>"
                    data-count="<?php echo esc_attr($count); ?>">
                <button class="button mittpwa_icon_upload" type="button">Select Image</button>

            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
        <p class="description">
            <?php esc_html_e('images will be sync in the background (chromium based feature)', 'mitt-pwa'); ?>
            <br><button class="mittPwaAddNewShortcutItems button button-primary">
                Add new
            </button>
        </p>
    </div <?php
    }

    public function mittpwawp_field_unregister_image_sync_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
    <select
        id="<?php echo esc_attr($args['label_for']); ?>"
        data-custom="<?php echo esc_attr($args['mittpwawp_custom_data']); ?>"
        name="mittpwawp_options[<?php echo esc_attr($args['label_for']); ?>]"
        class="mitt_pwa_select_showon_sync_unregister">
        <option value="2" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '2', false)) : (''); ?>>
            <?php esc_html_e('No', 'mitt-pwa'); ?>
        </option>
        <option value="1" <?php echo isset($options[ $args['label_for'] ]) ? (selected($options[ $args['label_for'] ], '1', false)) : (''); ?>>
            <?php esc_html_e('Yes', 'mitt-pwa'); ?>
        </option>
    </select>
    <p class="description">
        <?php esc_html_e('', 'mitt-pwa'); ?>
    </p>
    <?php
    }

    public function mittpwawp_field_statistic_cb($args)
    { 
        ?>
        <p><strong>Statistic is only available in the
                        <a id="cta-pro" target="_blank" href="https://mittl-medien.de/product-wordpress-pwa">
                            miTT PWA Fire Push
                        </a>
                        Pro version.
                        </strong>
        </p>
        <?php
    }


    /** Update Section **/

    public function mittpwawp_field_update_key_cb($args)
    {

        ?>
<p><strong>Update Key is only necessary in the
            <a id="cta-pro" target="_blank" href="https://mittl-medien.de/product-wordpress-pwa">
                    miTT PWA Fire Push
            </a>
                Pro version.
            </strong>
        </p> <?php
    }


    public function mittpwawp_render_xml_output_cb($args)
    {
        $url = "https://mittl-medien.de/wordpress/updates/mitt-pwa/changelog.xml";
        $response = wp_remote_get($url);
        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            $xmlChangelog = wp_remote_retrieve_body($response);
            $xml = simplexml_load_string($xmlChangelog);
            $html = array();
            foreach ($xml->changelog  as $item) {
                $html[] =  "<h3>Version {$item->version}</h3>";
                                        
                foreach ($item as $key => $value) {
                    if ($key === 'addition') {
                        $class = 'badge-success bg-success';
                        $changeType = "New Features";
                        $additonals =  $this->createList($item->addition->item);
                        $html[] = $this->createHtml($class, $changeType, $additonals);
                    }

                    if ($key === 'fix') {
                        $class = 'badge-dark bg-dark';
                        $changeType = 'Bug Fixes';
                        $fixis = $this->createList($item->fix->item);
                        $html[] = $this->createHtml($class, $changeType, $fixis);
                    }

                                        
                    if ($key === 'security') {
                        $class = 'badge-danger bg-danger';
                        $changeType = 'Security Fixes';
                        $securities = $this->createList($item->security->item);
                        $html[] = $this->createHtml($class, $changeType, $securities);
                    }

                    if ($key === 'language') {
                        $class = 'badge-jlanguage bg-jlanguage';
                        $changeType = 'Language';
                        $languages = $this->createList($item->language->item);
                        $html[] = $this->createHtml($class, $changeType, $languages);
                    }

                    if ($key === 'change') {
                        $class = 'badge-warning bg-warning';
                        $changeType = 'Changes';
                        $changes = $this->createList($item->change->item);
                        $html[] = $this->createHtml($class, $changeType, $changes);
                    }


                    if ($key === 'remove') {
                        $class = 'badge-light bg-secondary';
                        $changeType = 'Remove Features';
                        $removes = $this->createList($item->remove->item);
                        $html[] = $this->createHtml($class, $changeType, $removes);
                    }

                                        
                    if ($key === 'note') {
                        $class = 'badge-info bg-info';
                        $changeType = 'Notes';
                        $notes = $this->createList($item->note->item);
                        $html[] = $this->createHtml($class, $changeType, $notes);
                    }
                }
                    if (empty($item)) {
                        return;
                    }
                }

                $output = implode($html);
                $allowed_html = array(
                    'div' => array(
                    'class' => array(),
                    ),
                    'span' => array(
                        'class' => array(),
                    ),
                    'ul' => array(),
                    'li' => array(),
                    'h3' => array(),
                );
                echo wp_kses($output, $allowed_html);

        } else {
            echo 'Error: ' . esc_html($response->get_error_message());
            return;
        }

    }
    //changelog
    private function createList($input)
    {
        $list = array();
        foreach ($input as $li_item) {
            $list_element = "<li>{$li_item}</li>";
            array_push($list, $list_element);
        }
        return  implode(' ', $list);
    }

    private function createHtml($class, $changeType, $list)
    {
        $html = array();
        $html[] = "<div class='changelog'>";
        $html[] =     "<div class='changelog__item'>";
        $html[] =         "<div class='changelog__tag'>";
        $html[] =            " <span class='badge {$class}'>{$changeType}</span>";
        $html[] =        " </div>";
        $html[] =        " <div class='changelog__list'>";
        $html[] =            " <ul>";
        $html[] =            " $list";
        $html[] =            " </ul>";
        $html[] =         "</div>";
        $html[] =   "  </div>";
        $html[] = "</div>";
        return implode($html);

    }

    private function createMinusSvg()
    {
        $svg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                <title>minus</title>
                <path d="M0 13v6c0 0.552 0.448 1 1 1h30c0.552 0 1-0.448 1-1v-6c0-0.552-0.448-1-1-1h-30c-0.552 0-1 0.448-1 1z"></path>
                </svg>';
        return $svg;
    }

    private function allowHtmlSvg()
    {
        $allowed_html = array(
            'svg' => array(
                'version' => array(),
                'xmlns' => array(),
                'width' => array(),
                'height' => array(),
                'viewBox' => array(),
            ),
            'title' => array(),
            'path' => array(
                'd' => array(),
            ),
        );
        return $allowed_html;
    }

    public function mittpwawp_field_active_tab_cb($args)
    {
        $options = get_option('mittpwawp_options');
        ?>
        <input type="hidden" name="mittpwawp_options[active_tab]" id="active_tab" class=""
            value="<?php echo(isset($options['active_tab'])? esc_attr($options['active_tab']) : 'general'); ?>">
        </div <?php
    }


    public function mittpwawp_options_page()
    {
        add_menu_page(
            'miTT PWA 📲 (Progressive Web App) 🚀 ',
            'miTT PWA',
            'manage_options',
            'mitt-pwa',
            //callback function to display the options page
            array($this, 'mittpwawp_options_page_html'),
            'data:image/svg+xml;base64,' . base64_encode('<svg id="uuid-b07d2838-f62b-4360-98e4-f4dee875e1cb" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 173.5 232"><defs><style>.uuid-20658a14-22ab-4fc7-a1e1-318414975a6a,.uuid-42dd1688-9d36-4fa4-8fa0-c224136e470f{fill:#f8cc32;}.uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49{fill:#62b3d8;}.uuid-42dd1688-9d36-4fa4-8fa0-c224136e470f{fill-rule:evenodd;}</style></defs><g><path id="uuid-10a7bc13-79e6-4b81-91b0-ec08c6fc31f0" class="uuid-42dd1688-9d36-4fa4-8fa0-c224136e470f" d="M96.14,83.53l31.19-31.15-31.11-31.07,9.71-9.62c3.4-3.37,8.94-3.34,12.31,.05l34.45,34.68c3.37,3.39,3.35,8.92-.05,12.29l-34.72,34.4c-3.4,3.37-8.94,3.34-12.31-.05l-9.47-9.53"/><path class="uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49" d="M36.46,21.35h50.82v7.66c0,2.44-1.98,4.42-4.42,4.42H32.04v-7.66c0-2.44,1.98-4.42,4.42-4.42Z"/><path class="uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49" d="M22.65,71.42h50.82v7.66c0,2.44-1.98,4.42-4.42,4.42H18.23v-7.66c0-2.44,1.98-4.42,4.42-4.42Z"/><path class="uuid-20658a14-22ab-4fc7-a1e1-318414975a6a" d="M29.55,47.25h50.82v7.66c0,2.44-1.98,4.42-4.42,4.42H25.13v-7.66c0-2.44,1.98-4.42,4.42-4.42Z"/></g><path class="uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49" d="M140.47,166.04h-18.12c-4,0-7.25,3.24-7.25,7.25v39.85h9v-17.77h16.37v17.77h9v-47.09h-9Zm0,20.32h-16.37v-11.32h16.37v11.32Z"/><path class="uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49" d="M18.23,173.28v39.85h9v-17.77h18.12c4,0,7.25-3.24,7.25-7.25v-14.83c0-4-3.24-7.25-7.25-7.25H25.47c-4,0-7.25,3.24-7.25,7.25Zm25.37,13.07H27.23v-11.32h16.37v11.32Z"/><path class="uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49" d="M66.18,166.04h1.76v37.95h11.43v-37.95h9v37.95h11.43v-37.95h9v46.95H58.93v-39.7c0-4,3.24-7.25,7.25-7.25Z"/><path class="uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49" d="M68.27,154.31h-9.04v-26.76h-11.47v26.76h-9.04v-26.76h-11.47v26.76h-9.04v-28.17c0-4.21,3.41-7.63,7.63-7.63h42.42v35.8Z"/><path class="uuid-20658a14-22ab-4fc7-a1e1-318414975a6a" d="M88.37,118.52v35.8h-9.04v-35.8h9.04Z"/><path class="uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49" d="M131.32,116.09h-13.48v38.23h-9.04v-38.23h-13.48v-1.41c0-4.21,3.41-7.63,7.63-7.63h28.38v9.04Z"/><path class="uuid-bd2e5190-a970-49e5-9a21-aecd2989ac49" d="M150.21,116.09h-5.86v38.23h-9.04v-38.23h-13.48v-1.41c0-4.21,3.41-7.63,7.63-7.63h28.38v1.41c0,4.21-3.41,7.63-7.63,7.63Z"/><path class="uuid-20658a14-22ab-4fc7-a1e1-318414975a6a" d="M88.37,107.03v9.06h-9.04v-1.43c0-4.21,3.41-7.63,7.63-7.63h1.41Z"/></svg>'),
            90
        );
    }
    

    
    public function mittpwawp_options_page_html()
    {
        // check user capabilities
        if (! current_user_can('manage_options')) {
            return;
        }
       
        if (isset($_GET['settings-updated'])) {
            // add settings saved message with the class of "updated"
            add_settings_error('mittpwawp_messages', 'mittpwawp_message', __('Settings Saved', 'mitt-pwa'), 'updated');
        }


     
        // show error/update messages
        settings_errors('mittpwawp_messages');
        ?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <ul class="nav mittpwawp_nav_tabs">
        <li data-tab="general" class="mittpwawp_nav_tab"><a href="#general">General</a></li>
        <li data-tab="cache" class="mittpwawp_nav_tab"><a href="#cache">Cache</a></li>
        <li data-tab="manifest" class="mittpwawp_nav_tab"><a href="#manifest">Manifest</a></li>
        <li data-tab="pushNotification" class="mittpwawp_nav_tab"><a href="#pushNotification">Push Notification</a></li>
        <li data-tab="firebase" class="mittpwawp_nav_tab"><a href="#firebase">Firebase Setting</a></li>
        <li data-tab="sync" class="mittpwawp_nav_tab"><a href="#sync">Sync</a></li>
        <li data-tab="statistic" class="mittpwawp_nav_tab"><a href="#statistic">Statistic</a></li>
        <li data-tab="update" class="mittpwawp_nav_tab"><a href="#update">Update</a></li>
        <li data-tab="changelog" class="mittpwawp_nav_tab"><a href="#changelog">Changelog</a></li>
    </ul>


    <form class="mittpwaadminform" action="options.php" method="post">
        <?php wp_nonce_field('mittpwaadminform_action', 'mittpwaadminform_nonce');

            // output security fields for the registered setting "mittpwafreewp"
        settings_fields('mitt-pwa');
        // output setting sections and their fields
        // (sections are registered for "mittpwafreewp", each field is registered to a specific section)
        do_settings_sections('mitt-pwa');
        // output save settings button
        submit_button('Save Settings');

        // print_r(get_option('mittpwawp_options'));
        //TODO: comment out this
        echo '<pre>';
        //var_dump(get_option('mittpwawp_options'));
        echo '<pre>';
        ?>
    </form>
</div>
<?php
    }
}
?>