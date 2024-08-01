<?php
if(!class_exists( 'PV_Slider_Post_type' )){

  class PV_Slider_Post_type{

    function __construct(){
      add_action( 'init', array( $this, 'create_post_type' ) );
      add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
      add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
    }

    public function create_post_type(){

      register_post_type('pv-slider',
        array(
          'labels' => array(
            'name' => __('Sliders'),
            'singular_name' => __('Slider')
          ),
          'public' => true,
          'supports' => array('title', 'editor', 'thumbnail'),
          'hierarchical' => false,
          'show_ui' => true,
          'show_in_menu' => true,
          'menu_position' => 5,
          'show_in_admin_bar' => true,
          'show_in_nav_menus' => true,
          'can_export' => true,
          'has_archive' => true,
          'exclude_from_search' => false,
          'publicly_queryable' => true,
          'show_in_rest' => true,
          'menu_icon' => 'dashicons-images-alt2',
          //'register_meta_box_cb' => array( $this, 'add_meta_boxes' )
        )
      );
    }
    public function add_meta_boxes(){
      add_meta_box(
        'pv_slider_meta_box',
        'Link Options',
        array( $this, 'add_inner_meta_boxes' ),
        'pv-slider',
        'normal'/*'side'*/,
        'high'/*,
        array( 'foo' => 'bar' )*/
      );
    }
    public function add_inner_meta_boxes( $post/*, $test */){
      require_once( PV_SLIDER_PATH . 'views/pv-slider_metabox.php');
    }
    public function save_post($post_id){
      if( isset($_POST['action']) && $_POST['action'] == 'editpost' ){
        $old_link_text = get_post_meta( $post_id, 'pv_slider_link_text', true );
        $new_link_text = $_POST['pv_slider_link_text'];
        $old_link_url = get_post_meta( $post_id, 'pv_slider_link_url', true );
        $new_link_url = $_POST['pv_slider_link_url'];;

        update_post_meta($post_id, 'pv_slider_link_text', $new_link_text, $old_link_text);
        update_post_meta($post_id, 'pv_slider_link_url', $new_link_url, $old_link_url);
      }
    }
  }
}
