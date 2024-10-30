<?php

namespace MITTPWAWP\Inc\Core;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @author     Your Name or Your Company
 */
class Internationalization_I18n
{

    /**
     * The text domain of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $text_domain    The text domain of the plugin.
     */
    private $text_domain;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_text_domain       The text domain of this plugin.
     */
    public function __construct($plugin_text_domain)
    {

        $this->text_domain = $plugin_text_domain;

    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {
        $domain = 'mitt-pwa';
        $locale = apply_filters('plugin_locale', get_locale(), $domain);
        $mofile = plugin_dir_path(dirname(__FILE__, 2)) . 'languages/' . $domain . '-' . $locale . '.mo';

        load_textdomain(
            // $this->text_domain,
            'mitt-pwa',
      
            //dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
            $mofile
        );

    }

}
