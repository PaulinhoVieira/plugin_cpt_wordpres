<?php

if( ! class_exists('PV_Slider_Settings')){
  class PV_Slider_Settings{
    
    public static $options;

    public function __construct(){
      self::$options = get_option( 'pv_slider_options' );
      add_action( 'admin_init', array( $this, 'admin_init' ) );
    }

    public function admin_init(){
      
      register_setting( 'pv_slider_group', 'pv_slider_options', array( $this, 'pv_slider_validate' ) );
      
      add_settings_section(
        'pv_slider_main_section',
        'How does it work?',
        null,
        'pv_slider_page1'
      );

      add_settings_section(
        'pv_slider_second_section',
        'Other Plugin Options',
        null,
        'pv_slider_page2'
      );

      add_settings_field(
        'pv_slider_shortcode',
        'Shortcode',
        array( $this, 'pv_slider_shortcode_callback' ),
        'pv_slider_page1',
        'pv_slider_main_section'
      );

      add_settings_field(
        'pv_slider_title',
        'Slider Title',
        array( $this, 'pv_slider_title_callback' ),
        'pv_slider_page2',
        'pv_slider_second_section',
        array(
          'label_for' => 'pv_slider_title'
          )
      );

      add_settings_field(
        'pv_slider_bullets',
        'Display Bullets',
        array( $this, 'pv_slider_bullets_callback' ),
        'pv_slider_page2',
        'pv_slider_second_section',
        array(
          'label_for' => 'pv_slider_bullets'
          )
      );

      add_settings_field(
        'pv_slider_style',
        'Slider Style',
        array( $this, 'pv_slider_style_callback' ),
        'pv_slider_page2',
        'pv_slider_second_section',
        array(
          'items' => array(
            'style-1',
            'style-2'
          ),
          'label_for' => 'pv_slider_style'
        )
      );
    }
  
    public function pv_slider_shortcode_callback(){
      ?>
      <spam>Use the shortcode [pv_slider] to display the slider in any page/post/widget</spam>
      <?php
    }

    public function pv_slider_title_callback( $args ){
      ?>
      <input 
      type="text"
      name="pv_slider_options[pv_slider_title]"
      id="pv_slider_title"
      value="<?php echo isset( self::$options[ 'pv_slider_title' ] ) ? esc_attr( self::$options[ 'pv_slider_title' ] ) : ''; ?>"
      />
      <?php
    }

    public function pv_slider_bullets_callback( $args ){
      ?>
      <input 
      type="checkbox"
      name="pv_slider_options[pv_slider_bullets]"
      id="pv_slider_bullets"
      value="1"
      <?php
      if( isset( self::$options[ 'pv_slider_bullets' ] ) ){
        checked( "1", self::$options[ 'pv_slider_bullets' ], true );
      } 
        
      ?>
      />
      <label for="pv_slider_bullets">whether to display bullets or not</label>
      <?php
    }

    public function pv_slider_style_callback( $args ){
      ?>
      <select
      name="pv_slider_options[pv_slider_style]"
      id="pv_slider_style"
      >
        <?php
        foreach( $args['items'] as $item ):
        ?>
        <option value="<?php echo esc_attr( $item ); ?>"
          <?php isset( self::$options[ 'pv_slider_style' ] ) ? selected( $item, self::$options[ 'pv_slider_style' ], true) : ''; ?>
          >
          <?php echo esc_html( ucfirst( $item ) ) ?>
        </option>
        <?php endforeach; ?>
      </select>
      <?php
    }

    public function pv_slider_validate( $input ){
      $new_input = array();
      foreach( $input as $key => $value){
        switch($key){ // exemplos de como sanitizar varios campos com tipos diferentes de entrada
          case 'pv_slider_title':
            if( empty( $value ) ){
              add_settings_error( 'pv_slider_options', 'pv_slider_message', 'the title fild can not be left empty!', 'error' );
              $value = 'please, type some text!';
            }
            $new_input[$key] = sanitize_text_field( $value );
          break;
          /*case 'pv_slider_url':
            $new_input[$key] = esc_url_raw( $value );
          break;
          case 'pv_slider_int':
            $new_input[$key] = absint( $value );
          break;*/
          default:
          $new_input[$key] = sanitize_text_field( $value );
          break;
        }
      }
      return $new_input;
    }
  }
}
