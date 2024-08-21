<?php
if(!function_exists('pv_slider_options')){
  function pv_slider_options(){
    $show_bullets =  isset( PV_Slider_Settings::$options['pv_slider_bullets'] ) 
    && PV_Slider_Settings::$options['pv_slider_bullets'] == 1 ? true : false;

    wp_enqueue_script( 'pv-slider-options-js', PV_SLIDER_URL . 'vendor/flexslider/flexslider.js', array( 'jquery' ), PV_SLIDER_VERSION, true );
    wp_localize_script( 'pv-slider-options-js', 'SLIDER_OPTIONS', array(
      'controlNav' => $show_bullets
    ) );
  }
}
