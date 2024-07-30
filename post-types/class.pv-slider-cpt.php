<?php
if(!class_exists( 'PV_Slider_Post_type' )){

  class PV_Slider_Post_type{

    function __construct(){
      add_action( 'init', array( $this, 'create_post_type') );
    }

    public function create_post_type(){

      register_post_type('pv-slider',
        array(
          'labels' => array(
            'name' => __('Sliders'),
            'singular_name' => __('Slider')
          ),
          'public' => true,
          'has_archive' => true
        )
      );

    }
  }
}
