<?php

/**
 * Plugin Name: PV Slider
 * Plugin URI: https://www.wordpress.org/pv-slider
 * Description: My first plugin's mvc
 * Version: 1.0
 * Requires at least: 5.6
 * Author: Paulo Fernandes
 * Author URI: http://www.codigowp.net
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: pv-slider
 * Domain Path: /languages
 */
if ( !defined( 'ABSPATH' ) ) {
  exit;
}

if ( !class_exists( 'PV_Slider' ) ){
  class PV_Slider{
    function __construct(){
      $this->define_constants();

      add_action( 'admin_menu', array( $this, 'add_menu' ) );

      require_once(PV_SLIDER_PATH . 'post-types/class.pv-slider-cpt.php');
      $PV_Slider_Post_type = new PV_Slider_Post_type();

      require_once(PV_SLIDER_PATH . 'class.pv-slider-settings.php');
      $PV_slider_Settings = new PV_Slider_Settings();

      require_once(PV_SLIDER_PATH . 'shortcodes/class.pv-slider-shortcode.php');
      $PV_Slider_Shortcode = new PV_Slider_Shortcode();

      add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 999 );
      add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_scripts') );
    }

    public function define_constants(){
      define('PV_SLIDER_PATH', plugin_dir_path(__FILE__));
      define('PV_SLIDER_URL', plugin_dir_url(__FILE__));
      define('PV_SLIDER_VERSION', '1.0.0');
    }

    public static function activate(){
      //flush_rewrite_rules();
      update_option('rewrite_rules', '');
    }

    public static function deactivate(){
      flush_rewrite_rules();
    }

    public static function uninstall(){}

    public function add_menu(){
      add_menu_page(
        'PV Slider Options',
        'PV Slider',
        'manage_options',
        'pv_slider_admin',
        array( $this, 'pv_slider_settings_page' ),
        'dashicons-images-alt2'
      );

      add_submenu_page(
        'pv_slider_admin',
        'Manage Slides',
        'Manage Slides',
        'manage_options',
        'edit.php?post_type=pv-slider',
        null,
        null
      );

      add_submenu_page(
        'pv_slider_admin',
        'Add New Slider',
        'Add New Slider',
        'manage_options',
        'post-new.php?post_type=pv-slider',
        null,
        null
      );
    }
    public function pv_slider_settings_page(){
      if( ! current_user_can( 'manage_options' ) ){
        return;
      }
      if( isset( $_GET['settings-updated'] ) ){
        add_settings_error( 'pv_slider_options', 'pv_slider_message', 'Sttings Saved', 'success' );
      }
      settings_errors( 'pv_slider_options' );
      
      require ( PV_SLIDER_PATH . 'views/settings-page.php' );
    }

    public function register_scripts(){
      wp_register_script( 'pv-slider-main-jq', PV_SLIDER_URL . 'vendor/flexslider/jquery.flexslider-min.js', array( 'jquery' ), PV_SLIDER_VERSION, true );
      wp_register_script( 'pv-slider-options-js', PV_SLIDER_URL . 'vendor/flexslider/flexslider.js', array( 'jquery' ), PV_SLIDER_VERSION, true );
      wp_register_style( 'pv-slider-main-css', PV_SLIDER_URL . 'vendor/flexslider/flexslider.css', array(), PV_SLIDER_VERSION, 'all' );
      wp_register_style( 'pv-slider-style-css', PV_SLIDER_URL . 'assets/css/frontend.css', array(), PV_SLIDER_VERSION, 'all' );
    }

    public function register_admin_scripts(){
      global $typeNow;
      if( $typeNow == 'pv-slider' ){
        wp_enqueue_style( 'pv-slider-admin', PV_SLIDER_URL . 'assets/css/admin.css' );
      }
    }
    
  }
}

if (class_exists('PV_Slider')) {
  register_activation_hook(__FILE__, array('PV_Slider', 'activate'));
  register_deactivation_hook(__FILE__, array('PV_Slider', 'deactivate'));
  register_uninstall_hook(__FILE__, array('PV_Slider', 'uninstall'));

  $pv_slider = new PV_Slider();
}
