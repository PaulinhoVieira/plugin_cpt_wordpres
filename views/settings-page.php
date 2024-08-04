<div class="wrap">
  <h1><?php echo esc_html( get_admin_page_title() );?></h1>
  <form action="options.php" method="post">
    <?php
      settings_fields( 'pv_slider_group' );
      do_settings_sections( 'pv_slider_page1' );
      do_settings_sections( 'pv_slider_page2' );
      submit_button( 'Save Settings' );
    ?>
  </form>
</div>