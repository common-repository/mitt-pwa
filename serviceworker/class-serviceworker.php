<?php
namespace MITTPWAWP\Serviceworker;

class Serviceworker
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
    // public function __construct($plugin_name, $version, $plugin_text_domain)
    // {

    //     $this->plugin_name = $plugin_name;
    //     $this->version = $version;
    //     $this->plugin_text_domain = $plugin_text_domain;

    // }
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */

    
    
    public function add_sw_inline_script()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Mittpwafirepushwp_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Mittpwafirepushwp_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        
        $settings = get_option('mittpwawp_options');
        $pwa_app_debug_mode = $settings['mittpwawp_field_debug_mode_app'];


        // echo '<pre>';
        // //var_dump($setting);
        // echo '<pre>';

        $pwa_app_custom_install_button = $settings['mittpwawp_field_app_installation_button'];
        $pwa_app_ios_install_banner = isset($settings['mittpwawp_field_install_banner_ios']);


        //TODO: language file
        $pwa_app_ios_install_banner_text = 'banner text exa';
        $pwa_app_ios_install_banner_button_text = 'Dismiss';
        $pwa_app_ios_install_banner_text_firstpart = 'Install the App go to ';
        $pwa_app_ios_install_banner_text_secondpart = 'and add to Homescreen';
        $pwa_app_ios_install_banner_additonal_popup_type = 'ios_install_banner';
        $pwa_app_ios_install_banner_additonal_popup_text1 = 'Unfortunately, this is not the right button to install the app. At the bottom there is a similar button.';
        $pwa_app_ios_install_banner_additonal_popup_text2 = 'Click on the "Share" button and find the function "Add to Home Screen" to install the Web App to your iOS Device.';
        //TODO: check if setting
       
      
        $pullRefresh = $settings['mittpwawp_field_pull_refresh'];

        $overwrite_serviceworker_file = $settings['mittpwawp_field_overwrite_serviceworker_file'];
        $swfile = '/serviceworker.js';
        $pwa_app_debug_mode = $settings['mittpwawp_field_debug_mode_app'];
        $scope_file_path = $overwrite_serviceworker_file === '1' ?  plugin_dir_url(__DIR__) . 'inc/frontend/js/' . $swfile : $swfile;
        $pwa_app_custom_install_button = $settings['mittpwawp_field_app_installation_button'];

        $registerServiceWorkerAsync = array();

        $registerServiceWorkerAsync[] = 'const waitingForActivateCustomInstallButton = async _ => { ';
        $registerServiceWorkerAsync[] = '   while (typeof pullRefreshSetting === "undefined") {';
        $registerServiceWorkerAsync[] = '     await new Promise(resolve => setTimeout(resolve, 1000));';
        $registerServiceWorkerAsync[] = '   }';
        $registerServiceWorkerAsync[] = '}';
        $registerServiceWorkerAsync[] = 'const activateButtons = async _ => {';
        $registerServiceWorkerAsync[] = ' await waitingForActivateCustomInstallButton()';
                    
        $registerServiceWorkerAsync[] = '   if ("' . esc_js($pwa_app_custom_install_button) . '" === "custom_install") activateCustomInstallButton("0") ';
        $registerServiceWorkerAsync[] = '   if ("' . esc_js($pwa_app_custom_install_button) . '" === "custom_standard_install_prompt") activateCustomInstallButton("1") ';
        $registerServiceWorkerAsync[] = '   if ("' . esc_js($pwa_app_custom_install_button) . '" === "no_install_prompt") preventInstallPrompt() ';
        $registerServiceWorkerAsync[] = '}';

        $registerServiceWorkerAsync[] = 'const waitingForActivateIosBanner = async _ => { ';
        $registerServiceWorkerAsync[] = '   while (typeof activateIosBanner === "undefined") {';
        $registerServiceWorkerAsync[] = '     await new Promise(resolve => setTimeout(resolve, 1000));';
        $registerServiceWorkerAsync[] = '   }';
        $registerServiceWorkerAsync[] = '}';

        $registerServiceWorkerAsync[] = 'let pullRefreshSetting = "' . esc_js($pullRefresh) . '"';
        $registerServiceWorkerAsync[] = '// Register a Serviceworker';
                
        $registerServiceWorkerAsync[] = 'window.addEventListener("load", async() => {';
        $registerServiceWorkerAsync[] = ' if ("serviceWorker" in window.navigator) {';
        $registerServiceWorkerAsync[] = '  try {';
        $registerServiceWorkerAsync[] = '   await activateButtons()';
        $registerServiceWorkerAsync[] = '   await window.navigator.serviceWorker.register("' . esc_js($scope_file_path) . '", {scope: "/", updateViaCache: "none"})';
        $registerServiceWorkerAsync[] = '   const registration = await navigator.serviceWorker.ready';
        $registerServiceWorkerAsync[] = '   if (' . esc_js($pwa_app_debug_mode) . ' === 1) console.log("Service Worker registration ✅",registration)';
        $registerServiceWorkerAsync[] = '  } catch (error) {';
        $registerServiceWorkerAsync[] = '   console.error(error)';
        $registerServiceWorkerAsync[] = '   }';
        $registerServiceWorkerAsync[] = '  }';
        $registerServiceWorkerAsync[] = '})';

        
        $addServiceWorker = implode("\n", $registerServiceWorkerAsync);
        ?>
<script>
    <?php echo $addServiceWorker; ?>
</script>
<?php
    }

    protected function createJsArrayList($dataList, $fixed, $arrayKey = false)
    {

        $listArray = array();
        $prepareArray;
        
        if (is_array($fixed)) {
            $prepareArray = array_merge($listArray, $fixed);
        } else {
            $prepareArray = array();
            $prepareArray[] = $fixed;
        }
            
        $lastElement = end($dataList);
            
        foreach ($dataList as $item) {
            
            $element = trim($item);
            if ($element === "") {
                // no param data from plugin sent back
                $result = implode("\n", $prepareArray);
                return $result;
            }

            if ($element !== $lastElement) {
                $prepareArray[] = "'{$element}',";
            } else {
                $prepareArray[] = "'{$element}'";
            }
        }


        $result = implode("\n", $prepareArray);
        return $result;
    }




    public function update_serviceworker()
    {
        $settings = get_option('mittpwawp_options');
        if ($settings === '') {
            return;
        }



        //random string
        // Zufallsgenerator schütteln
        wp_rand((double) (int) microtime() * 1000000);
        $characterSet = "ABCDEFGHIKLMNPQRSTUVWXYZ123456789";
        $serviceworker_randomstring = "";
        
        for ($n=1;$n<=15; $n++) {
            $serviceworker_randomstring .= $characterSet[wp_rand(0, (strlen($characterSet)-1))];
        }
    
        $serviceworker_version = $serviceworker_randomstring;
        $pwa_app_cache_strategie_cache_first = isset($settings['mittpwawp_field_cache_first']);
        $pwa_app_cdn = isset($settings['mittpwawp_field_cdn']);
        $pwa_app_debug_mode = isset($settings['mittpwawp_field_debug_mode_app']);

        
        $pwa_app_static_cache = isset($settings['staticachepath']) ? (array)$settings['staticachepath'] : array();

        $pwa_app_cache_page_exceptions_setting = isset($settings['cache_exceptions']) ? $settings['cache_exceptions'] : '';


        if ($pwa_app_cache_page_exceptions_setting !== '') {
            $pwa_app_cache_page_exceptions = array($pwa_app_cache_page_exceptions_setting);
        }

        $pwa_app_fetch_request_exceptions = isset($settings['fetch_exceptions']) ? (array)$settings['fetch_exceptions'] : array();
        $counter = 1;
        $fetchRequestExceptions = '';
        foreach ($pwa_app_fetch_request_exceptions as $exception) {
            if ($counter === 1) {
                $path = "url.pathname.includes('{$exception}')";
            } else {
                $path = " || url.pathname.includes('{$exception}')";
            }
            $fetchRequestExceptions = $fetchRequestExceptions . $path;
            if ($fetchRequestExceptions === "url.pathname.includes('')") {
                $fetchRequestExceptions = "false";
            }
            $counter++;
        }


                

        $pwa_app_debug_fetch_requests = isset($settings['mittpwawp_field_debug_fetch_request']);
        $pwa_app_debug_fetch_request_exceptions = isset($settings['mittpwawp_field_debug_fetch_exceptions']);

        $pwa_app_start_url_postid = isset($settings['start_url']);
        $pwa_app_start_url = $pwa_app_start_url_postid === 'custom_start_url' ? $settings['custom_start_url'] : get_permalink($pwa_app_start_url_postid);

        //TODO: check if sync
        $periodicSyncPages = '';
        $periodicSyncImages = '';
         if (isset($settings['mittpwawp_field_register_page_sync']) && $settings['mittpwawp_field_register_page_sync'] === '1') {
             $pwa_app_page_sync_urls = isset($settings['page_sync_item']) ? (array)$settings['page_sync_item'] : array();
            $periodicSyncPages = $this->createJsArrayList($pwa_app_page_sync_urls, false);

        }
         if (isset($settings['mittpwawp_field_register_image_sync']) && $settings['mittpwawp_field_register_image_sync'] === '1') {
             $pwa_app_image_sync_urls = isset($settings['image_sync_item']) ? (array)$settings['image_sync_item'] : array();
            $periodicSyncImages = $this->createJsArrayList($pwa_app_image_sync_urls, false);

        }

        $path = '/' . 'inc/frontend/';

        $fixedStaticCache = array();
        $fixedStaticCache[] = "'{$path}offline.html',";
        $fixedStaticCache[] = "'{$path}js/mittpwapush_notification.js',";
        $fixedStaticCache[] = "'{$path}js/mittpwa_main.js',";
        $fixedStaticCache[] = "'{$path}css/mittpwa.css',";

        $fixedStaticCache[] = "'{$pwa_app_start_url}',";
        
            
        $staticFiles = $this->createJsArrayList(isset($settings['staticachepath']) ? (array)$settings['staticachepath'] : array(), $fixedStaticCache);

        $pwa_app_cache_page_exception_expression = array();
        $pwa_app_cache_page_exception_expression = "'wp-admin',";
    

        $cachePageExceptionsSettings = isset($settings['cache_exceptions']) ? (array)$settings['cache_exceptions'] : array();

        if ($cachePageExceptionsSettings !== '') {
            $cachePageExceptions = $this->createJsArrayList((array)($cachePageExceptionsSettings), $pwa_app_cache_page_exception_expression);
        } else {
            $cachePageExceptions = $pwa_app_cache_page_exception_expression;
        }

    
        

        $scope_file = isset($settings['mittpwawp_field_overwrite_serviceworker_file']);
        $scope_file_path = $scope_file === '1' ? plugin_dir_path(__DIR__) . 'inc/frontend/js/' : ABSPATH;

        $importScriptPathSW = $scope_file === '1' ? get_home_url() :  plugin_dir_url(__DIR__) . 'serviceworker/';

        $serviceWorkerFile = plugin_dir_path(__DIR__) . 'serviceworker/dist/serviceworker.js';

        ///Users/robertmittl/Developer/mittpwafreewp/serviceworker/dist/serviceworker.js

        $serviceWorker = "{$scope_file_path}serviceworker.js";
        
        global $wp_filesystem;

        if (empty($wp_filesystem)) {
            require_once(ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        $contentSW = $wp_filesystem->get_contents($serviceWorkerFile);

        // 		//add static files
        $searchFor = ["'{serviceworker_version}'",
                    "'{importScriptPathSW}'",
                    "'{serviceworker_randomstring}'",
                        "'{staticFiles}'",
                        "'{valueOfCacheFirst}'",
                        "'{valueOfCdn}'",
                        "'{valueOfDebugMode}'",
                        "'{cachePageExceptions}'",
                        "'{periodicSyncImages}'",
                        "'{periodicSyncPages}'",
                        "'{cachePageExceptions}'",
                        "'{valueOfDebugFetchRequest}'",
                        "'{valueOfDebugRequestException}'",
                        "'{fetchRequestExceptions}'"
                        ];


        if ($serviceworker_version === false) {
            $serviceworker_version = '0.00';
        };
            


        $replace = [wp_json_encode($serviceworker_version),
                    $importScriptPathSW,
                    wp_json_encode($serviceworker_randomstring),
                    $staticFiles,
                    wp_json_encode($pwa_app_cache_strategie_cache_first),
                    wp_json_encode($pwa_app_cdn),
                    wp_json_encode($pwa_app_debug_mode),
                    $cachePageExceptions,
                    $periodicSyncImages,
                    $periodicSyncPages,
                    $cachePageExceptions,
                    wp_json_encode($pwa_app_debug_fetch_requests),
                    wp_json_encode($pwa_app_debug_fetch_request_exceptions),
                    $fetchRequestExceptions
        ];

        $updatedData = str_replace($searchFor, $replace, $contentSW);
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once(ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        if ($wp_filesystem) {
            $wp_filesystem->put_contents(
                $serviceWorker,
                $updatedData
            );
        }
    }


    public function settings_save()
    {
        $serviceworker = new Serviceworker();
        $serviceworker->update_serviceworker();

    }
}

?>