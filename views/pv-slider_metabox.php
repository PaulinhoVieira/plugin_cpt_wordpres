<?php
  $meta = get_post_meta( $post->ID );
  $link_text = get_post_meta( $post->ID, 'pv_slider_link_text', true );
  $link_url = get_post_meta( $post->ID, 'pv_slider_link_url', true );
?>

<table class="from-table pv-slider-metabox"> 
<input type="hidden" name="pv_slider_nonce" value="<?php echo wp_create_nonce("pv_slider_nonce"); ?>">
  <tr>
    <th>
      <label for="pv_slider_link_text"> Link Text </label>
    </th>
    <td>
      <input 
      type="text" 
      name="pv_slider_link_text"
      id="pv_slider_link_text"
      class="regular-text link-text"
      value="<?php echo ( isset( $link_text ) ) ? esc_html($link_text) : ''; ?>"
      required
      >
    </td>
  </tr>

  <tr>
    <th>
      <label for="pv_slider_link_url"> Link URL </label>
    </th>
    <td>
      <input 
      type="url" 
      name="pv_slider_link_url"
      id="pv_slider_link_url"
      class="regular-text link-url"
      value="<?php echo ( isset( $link_url ) ) ? esc_url($link_url) : ''; /*$meta['pv_slider_link_url'][0]*/?>"
      required
      >
    </td>
  </tr>
</table>