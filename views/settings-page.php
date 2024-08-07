<div class="wrap">
  <h1><?php echo esc_html( get_admin_page_title() );?></h1>
  <?php
    $activate_tab = isset( $_GET[ 'tab' ] ) ?  $_GET[ 'tab' ] : 'main_options';
  ?>
  <h2 class="nav-tab-wrapper">
    <a href="?page=pv_slider_admin&tab=main_options"  class="nav-tab" <?php echo $activate_tab == 'main_options' ? 'nav-tab-active' : ''; ?> >Main Options</a>
    <a href="?page=pv_slider_admin&tab=additional_options" class="nav-tab" <?php echo $activate_tab == 'additional_options' ? 'nav-tab-active' : ''; ?> >Additional Options</a>
  </h2>
  <form action="options.php" method="post">
    <?php
      if( $activate_tab == 'main_options' ){
        settings_fields( 'pv_slider_group' );
        do_settings_sections( 'pv_slider_page1' );
      }else{
        settings_fields( 'pv_slider_group' );
        do_settings_sections( 'pv_slider_page2' );
      }
      
      submit_button( 'Save Settings' );
    ?>
  </form>
</div>