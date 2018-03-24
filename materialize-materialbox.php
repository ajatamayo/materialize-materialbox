<?php
/**
 * Plugin Name: Materialize MaterialBox
 * Description: Display images as Materialize Material boxes. Material box is a material design implementation of the Lightbox plugin. When a user clicks on an image that can be enlarged, Material box centers the image and enlarges it in a smooth, non-jarring manner. To dismiss the image, the user can either click on the image again, scroll away, or press the ESC key.
 * Plugin URI:  https://github.com/ajatamayo/materialize-materialbox
 * Version:     1.0
 * Author:      AJ Tamayo
 * Author URI:  https://github.com/ajatamayo
 * License:     GPL
 * Text Domain: materialize-materialbox
 * Domain Path: /languages
 *
 */

add_action( 'plugins_loaded', array( Materialize_MaterialBox::get_instance(), 'plugin_setup' ) );

class Materialize_MaterialBox {
    protected static $instance = NULL;
    public $plugin_url = '';
    public $plugin_path = '';

    /**
     *
     * @since 1.0
     */
    public function __construct() {}

    /**
     *
     * @since 1.0
     */
    public function load_language( $domain ) {
        load_plugin_textdomain(
            $domain,
            FALSE,
            $this->plugin_path . '/languages'
        );
    }

    /**
     *
     * @since 1.0
     */
    public static function get_instance() {
        NULL === self::$instance and self::$instance = new self;
        return self::$instance;
    }

    /**
     *
     * @since 1.0
     */
    public function plugin_setup() {
        $this->plugin_url    = plugins_url( '/', __FILE__ );
        $this->plugin_path   = plugin_dir_path( __FILE__ );
        $this->load_language( 'materialize-materialbox' );

        // Add materialbox class to images upon insertion in the edit pane
        add_filter( 'get_image_tag_class', array( &$this, 'add_image_tag_class' ), 10, 4 );

        add_action( 'wp_enqueue_scripts', array( &$this, 'enqueue_scripts' ), 10 );
    }

    /**
     *
     * @since 1.0
     */
    function add_image_tag_class( $class, $id, $align, $size ) {
        $class .= ' materialboxed';
        return $class;
    }

    /**
     *
     * @since 1.0
     */
    function enqueue_scripts() {
        wp_enqueue_style( 'materialize-materialbox', $this->plugin_url . "public/styles/materialbox.css", array(), '1.0' );
        wp_enqueue_script( 'materialize-materialbox' );
        wp_enqueue_script( 'materialize-materialbox-init', $this->plugin_url . "public/js/init.js", array( 'materialize-materialbox' ), '1.0', true );
    }
}

?>
