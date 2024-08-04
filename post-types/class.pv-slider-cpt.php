<?php
if(!class_exists( 'PV_Slider_Post_type' )){

  class PV_Slider_Post_type{

    function __construct(){
      add_action( 'init', array( $this, 'create_post_type' ) );
      add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
      add_action( 'save_post', array( $this, 'save_post' ), 10, 2 );
      add_filter( 'manage_pv-slider_posts_columns', array( $this, 'pv_slider_cpt_columns' ) );
      add_action( 'manage_pv-slider_posts_custom_column', array( $this, 'pv_slider_custom_columns' ), 10, 2 );
      add_filter( 'manage_edit-pv-slider_sortable_columns', array( $this, 'pv_slider_sortable_columns' ) );
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

    public function pv_slider_cpt_columns( $columns ) {
      $columns['pv_slider_link_text'] = esc_html__( 'Link Text', 'pv-slider' );
      $columns['pv_slider_link_url'] = esc_html__( 'Link URL', 'pv-slider' );
      return $columns;
    }

    public function pv_slider_custom_columns( $columns, $post_id ) {
      switch($columns){
        case 'pv_slider_link_text':
          echo esc_html( get_post_meta( $post_id, 'pv_slider_link_text', true ) );
        break;
        case 'pv_slider_link_url':
          echo esc_url( get_post_meta( $post_id, 'pv_slider_link_url', true ) );
        break;
      }
    }

    public function pv_slider_sortable_columns( $columns ) {
      $columns['pv_slider_link_text'] = 'pv_slider_link_text';
      return $columns;
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
      if( isset( $_POST['pv_slider_nonce'] ) ){
        if( ! wp_verify_nonce( $_POST['pv_slider_nonce'], 'pv_slider_nonce' ) ){
          return;
        }
      }

      if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
        return;
      }

      if( isset( $_POST['post_type'] ) && $_POST['post_type'] === 'pv_sldier' ){
        if( ! current_user_can( 'edit_page', $post_id ) ){
          return;
        }elseif( ! current_user_can( 'edit_post', $post_id ) ){
          return;
        }
      }

      if( isset($_POST['action']) && $_POST['action'] == 'editpost' ){
        $old_link_text = get_post_meta( $post_id, 'pv_slider_link_text', true );
        $new_link_text = $_POST['pv_slider_link_text'];
        $old_link_url = get_post_meta( $post_id, 'pv_slider_link_url', true );
        $new_link_url =  $_POST['pv_slider_link_url'];

        if(empty( $new_link_text ) ){
          update_post_meta($post_id, 'pv_slider_link_text', 'add some text');
        }else{
          update_post_meta($post_id, 'pv_slider_link_text', sanitize_text_field($new_link_text), $old_link_text);
        }
        if( empty( $new_link_url ) ){
          update_post_meta($post_id, 'pv_slider_link_url', '#');
        }else{
          update_post_meta($post_id, 'pv_slider_link_url', esc_url_raw($new_link_url), $old_link_url);
        }
        
      }
    }
  }
}
