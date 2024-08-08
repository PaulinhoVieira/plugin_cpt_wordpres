<?php
if( ! class_exists( 'PV_Slider_Shortcode' ) ){
  class PV_Slider_Shortcode{
    public function __construct(){
      add_shortcode( 'pv_slider', array( $this, 'add_shortcode' ) );
    }

    public function add_shortcode( $atts = array(), $content = null, $tag = '' ){
      
      $atts = array_change_key_case( (array) $atts, CASE_LOWER );
      
      extract( shortcode_atts(
        array (
          'id' => '',
          'orderby' => 'date'
        ),
        $atts,
        $tag
      ) );

      if( !empty( $id ) ) {
        $id =  array_map( 'absint', explode( ',', $id ) );
      }


      ob_start();
      require( PV_SLIDER_PATH . 'views/pv-slider_shortcode.php' );
      return ob_get_clean();
    }
  }
}