<?php
namespace MITTPWAWP\Serviceworker;

class Manifest
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
    //  public function __construct($plugin_name, $version, $plugin_text_domain)
    //  {

    //     $this->plugin_name = $plugin_name;
    //    $this->version = $version;
    //      $this->plugin_text_domain = $plugin_text_domain;

    //  }
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    
    public function create_manifest()
    {

        //empty settings return
        $settings = get_option('mittpwawp_options');
        if ($settings === '') {
            return;
        }

        $pwa_app_short_name = isset($settings['app_short_name']) ? $settings['app_short_name'] : null;
        $pwa_app_name = isset($settings['app_name']) ? $settings['app_name'] : null;
        $pwa_app_theme_color = isset($settings['theme_color']) ? $settings['theme_color'] : null;
        $pwa_app_start_url_postid = isset($settings['start_url']) ? $settings['start_url'] : null;

        $pwa_app_start_url = $pwa_app_start_url_postid === 'custom_start_url' ? $settings['custom_start_url'] : get_permalink($pwa_app_start_url_postid);

        $scope_app_overwrite = isset($settings['mittpwawp_field_overwrite_scope_app']) ? $settings['mittpwawp_field_overwrite_scope_app'] : null;
        
        $scope_app_url_setting = isset($settings['scope_app_url']) ? $settings['scope_app_url'] : '/';
        if ($scope_app_url_setting !== '') {
            $scope_app_url = $scope_app_url_setting;
        }
       

        $scope_app = $scope_app_overwrite === '0' ? '/' : $scope_app_url;

        $pwa_app_id = $settings['app_id'] ?? null;
        $pwa_app_description = isset($settings['app_description']) ? $settings['app_description'] : null;

        //TODO: check if need to add
        $pwa_app_use_shortcuts = isset($settings['mittpwawp_field_use_app_shortcuts']);

        //TODO: check if is array
        $pwa_app_shortcut_items = isset($settings['app_shortcut_items']) ? (array)$settings['app_shortcut_items'] : array();

        $pwa_app_use_protocol_handler = isset($settings['mittpwawp_field_use_protocol_handler']);
        $pwa_app_use_protocol_handler_items= isset($settings['protocol_handler_items']) ? (array)$settings['protocol_handler_items'] : array();

        $pwa_app_bg_color = isset($settings['background_color']) ? $settings['background_color'] : null;
        $pwa_app_display = isset($settings['mittpwawp_field_app_display']) ? $settings['mittpwawp_field_app_display'] : null;
        //TODO: dedide how to handle icons from folder or from url -- both
        $use_icon_from_folder = isset($settings['mittpwawp_field_use_folder_icons']);
        $pwa_app_icons_path = plugin_dir_url(__DIR__) . 'assets/icons/';

       
        $pwa_app_icon_maskable = "{$pwa_app_icons_path}/manifest-icon-512.maskable.png";
        $pwa_app_icon = "{$pwa_app_icons_path}/manifest-icon-512.png";
        $pwa_app_icon_ios = "{$pwa_app_icons_path}/apple-icon-180.png";
        

    
        
        //if doens't use icon from folder
        if ($use_icon_from_folder === '0') {
            $pwa_app_icon_maskable = $settings['manifest_icon_maskable'];
            $pwa_app_icon = $settings['manifest_icon'];
            $pwa_app_icon_ios = $settings['ios_icon'];
            $pwa_app_splashscreen_ios = explode(',', $settings['ios_splashscreen']);
        }

        
        $pwa_app_use_icon_svg = isset($settings['mittpwawp_field_use_svg_icon']);
        $pwa_app_icon_svg = "{$pwa_app_icons_path}/manifest-icon.svg";

        $pwa_app_use_screenshot = isset($settings['mittpwawp_field_use_app_screenshots']);
        if (isset($settings['screenshot'])) {
            $pwa_app_screenshot = (array)$settings['screenshot'];
        }


        $dataManifestPwa = array();
        $dataManifestPwa['name'] = $pwa_app_name;
        $dataManifestPwa['short_name'] = $pwa_app_short_name;
        $dataManifestPwa['description'] = $pwa_app_description;
        $dataManifestPwa['theme_color'] = $pwa_app_theme_color;
        $dataManifestPwa['background_color'] = $pwa_app_bg_color;
        $dataManifestPwa['display'] = $pwa_app_display;
        $dataManifestPwa['start_url'] = $pwa_app_start_url;
        if ($pwa_app_id !== '' || $pwa_app_id !== null) {
            $dataManifestPwa['id'] = $pwa_app_id;
        }

        $dataManifestPwa['scope'] = $scope_app;
        $prepareShortcut = array();

        if ($pwa_app_use_shortcuts === '1') {
            foreach ($pwa_app_shortcut_items as $shortcut_data) {
               
                $url_id= $shortcut_data["app_shortcut_page_item"];
                $url = get_permalink($url_id);
                $shortcut_item =
                [
                    "name" => "{$shortcut_data['app_screenshot_name']}",
                    "short_name" => "{$shortcut_data['app_shortcut_shortname']}",
                    "description" => "{$shortcut_data['app_shortcut_description']}",
                    "url" => "{$url}",
                    "icons" => [
                            [
                                    "src" => "{$shortcut_data['app_shortcut_icon']}",
                                    "sizes" => "192x192"
                            ]
                    ]
                ];
                $prepareShortcut[] = $shortcut_item;
            }
            $dataManifestPwa ['shortcuts'] = $prepareShortcut;
        }

        if ($pwa_app_use_protocol_handler === '1') {
            foreach ($pwa_app_use_protocol_handler_items as $protocol_handler_data) {
                $protocol_handler_item =
                [
                    "protocol" => "{$protocol_handler_data['protocol_handler_protocol']}",
                    "url" => "{$protocol_handler_data['protocol_handler_url']}"
                ];
                $prepareProtocolHandler[] = $protocol_handler_item;
            }
            $dataManifestPwa ['protocol_handlers'] = $prepareProtocolHandler;
        }
   
        $dataManifestPwa['icons'] = [
                [
                "src"=> $pwa_app_icon,
                "sizes"=> "512x512",
                "type"=> "image/png",
                "purpose"=> "any"
                    
                    ],
                    [
                "src"=> $pwa_app_icon_maskable,
                "sizes"=> "512x512",
                "type"=> "image/png",
                "purpose"=> "maskable"
                    ]
                ];

        if ($pwa_app_use_icon_svg === '1') {
            $dataManifestPwa['icons'] = [
                [
            "src"=> $pwa_app_icon,
            "sizes"=> "512x512",
            "type"=> "image/png",
            "purpose"=> "any"
                    
            ],
            [
            "src"=> $pwa_app_icon_maskable,
            "sizes"=> "512x512",
            "type"=> "image/png",
            "purpose"=> "maskable"
            ],
            [
            "src"=> "$pwa_app_icon_svg",
            "sizes"=> "any",
            "type"=> "image/svg"
                ]
            ];
        }

        

        $prepareScreenshot = array();

        if ($pwa_app_use_screenshot === '1') {
            foreach ($pwa_app_screenshot as $image_data) {
                $imageSizes = getimagesize($image_data['screenshot_image']);
                $image_item = // Add the right-hand side of the assignment here.
                    [
                        "src" => "{$image_data['screenshot_image']}",
                        "sizes" => "{$imageSizes[0]}x{$imageSizes[1]}",
                        "type" => "image/{$imageSizes['mime']}"
                    ];
                $prepareScreenshot[] = $image_item;
            }
            $dataManifestPwa ['screenshots'] = $prepareScreenshot;
        }
        
        $newManifest = wp_json_encode($dataManifestPwa);

        $path = plugin_dir_path(__DIR__) . 'inc/frontend/manifest/';

        if (!file_exists($path)) {
            wp_mkdir_p($path);
        }
    
        $myFileJson = $path . "manifest.webmanifest";
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once ABSPATH . '/wp-admin/includes/file.php';
            WP_Filesystem();
        }
        
        if ($wp_filesystem) {
            $wp_filesystem->put_contents($myFileJson, $newManifest);
        }

    }

    public function settings_save()
    {
        $manifest = new Manifest();
        $manifest->create_manifest();
    }
}
