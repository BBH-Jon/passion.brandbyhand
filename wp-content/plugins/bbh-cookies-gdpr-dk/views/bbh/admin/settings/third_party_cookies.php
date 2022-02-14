<?php
    $gdpr_default_content = new bbh_GDPR_Content();
    $option_name    = $gdpr_default_content->bbh_gdpr_get_option_name();
    $gdpr_options   = get_option( $option_name );
    $wpml_lang      = $gdpr_default_content->bbh_gdpr_get_wpml_lang();
    $gdpr_options   = is_array( $gdpr_options ) ? $gdpr_options : array();
    $empty_scripts  = false;
    if ( isset( $_POST ) && isset( $_POST['bbh_gdpr_nonce'] ) ) :
        $nonce = sanitize_key( $_POST['bbh_gdpr_nonce'] );
        if ( ! wp_verify_nonce( $nonce, 'bbh_gdpr_nonce_field' ) ) :
            die( 'Security check' );
        else :
            if ( is_array( $_POST ) ) :
                if ( isset( $_POST['bbh_gdpr_third_party_cookies_enable'] ) && intval( $_POST['bbh_gdpr_third_party_cookies_enable'] ) === 1 ) :
                    $value  = 1;
                else :
                    $value  = 0;
                endif;
                if ( $value === 1 ) :
                    if ( ( isset( $_POST[ 'bbh_gdpr_third_party_header_scripts' ] ) && strlen( $_POST[ 'bbh_gdpr_third_party_header_scripts' ] ) == 0 ) && ( isset( $_POST[ 'bbh_gdpr_third_party_body_scripts' ] ) && strlen( $_POST[ 'bbh_gdpr_third_party_body_scripts' ] ) == 0 ) && ( isset( $_POST[ 'bbh_gdpr_third_party_footer_scripts' ] ) && strlen( $_POST[ 'bbh_gdpr_third_party_footer_scripts' ] ) == 0 ) ) :
                        $empty_scripts = true;
                    endif;
                endif;
                if ( ! $empty_scripts ) :
                    $gdpr_options['bbh_gdpr_third_party_cookies_enable'] = $value;
                    update_option( $option_name, $gdpr_options );
                    $gdpr_options = get_option( $option_name );
                    foreach ( $_POST as $form_key => $form_value ) :
                        if ( $form_key === 'bbh_gdpr_performance_cookies_tab_content' ) :
                            $value  = apply_filters( 'the_content', wp_unslash( $form_value ) );
                            $gdpr_options[$form_key.$wpml_lang]    = $value;
                            update_option( $option_name, $gdpr_options );
                            $gdpr_options               = get_option( $option_name );
                        elseif ( $form_key === 'bbh_gdpr_third_party_header_scripts' || $form_key === 'bbh_gdpr_third_party_body_scripts' || $form_key === 'bbh_gdpr_third_party_footer_scripts' ) :
                            $value                      = wp_unslash( $form_value );
                            $gdpr_options[$form_key]    = maybe_serialize( $value );
                            update_option( $option_name, $gdpr_options );
                            $gdpr_options               = get_option( $option_name );
                        elseif ( $form_key !== 'bbh_gdpr_third_party_cookies_enable' ) :
                            $value                      = sanitize_text_field( $form_value );
                            $gdpr_options[$form_key]    = $value;
                            update_option( $option_name, $gdpr_options );
                            $gdpr_options               = get_option( $option_name );
                        endif;
                    endforeach;
                endif;
            endif;
            ?>
            <?php if ( $empty_scripts ) : ?>
                <script>
                    jQuery('#bbh-gdpr-setting-error-settings_updated').hide();
                    jQuery('#bbh-gdpr-setting-error-settings_scripts_empty').show();
                </script>

            <?php else : ?>
                <script>
                    jQuery('#bbh-gdpr-setting-error-settings_scripts_empty').hide();
                    jQuery('#bbh-gdpr-setting-error-settings_updated').show();
                </script>
            <?php endif;
        endif;
    endif;
?>
<br />
<?php
    $nav_label  = isset( $gdpr_options['bbh_gdpr_performance_cookies_tab_title'.$wpml_lang] ) && $gdpr_options['bbh_gdpr_performance_cookies_tab_title'.$wpml_lang] ? $gdpr_options['bbh_gdpr_performance_cookies_tab_title'.$wpml_lang] : __('3rd Party Cookies','bbh-gdpr');
?>
<h2><?php echo $nav_label; ?></h2>
<hr />
<form action="?page=bbh-gdpr&amp;tab=third_party_cookies" method="post" id="bbh_gdpr_tab_third_party_cookies">
    <?php wp_nonce_field( 'bbh_gdpr_nonce_field', 'bbh_gdpr_nonce' ); ?>
    <table class="form-table <?php echo $empty_scripts ? 'bbh-gdpr-form-error' : ''; ?>">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_third_party_cookies_enable"><?php _e('Turn','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input name="bbh_gdpr_third_party_cookies_enable" type="radio" value="1" id="bbh_gdpr_third_party_cookies_enable_on" <?php echo isset( $gdpr_options['bbh_gdpr_third_party_cookies_enable'] ) ? ( intval( $gdpr_options['bbh_gdpr_third_party_cookies_enable'] ) === 1  ? 'checked' : '' ) : 'checked'; ?> class="regular-text on-off"> <label for="bbh_gdpr_third_party_cookies_enable_on"><?php _e('On','bbh-gdpr'); ?></label> <span class="separator"></span>
                    <input name="bbh_gdpr_third_party_cookies_enable" type="radio" value="0" id="bbh_gdpr_third_party_cookies_enable_off" <?php echo isset( $gdpr_options['bbh_gdpr_third_party_cookies_enable'] ) ? ( intval( $gdpr_options['bbh_gdpr_third_party_cookies_enable'] ) === 0  ? 'checked' : '' ) : 'checked'; ?> class="regular-text on-off"> <label for="bbh_gdpr_third_party_cookies_enable_off"><?php _e('Off','bbh-gdpr'); ?></label>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_performance_cookies_tab_title"><?php _e('Tab Title','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input name="bbh_gdpr_performance_cookies_tab_title<?php echo $wpml_lang; ?>" type="text" id="bbh_gdpr_performance_cookies_tab_title" value="<?php echo $nav_label; ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="bbh_gdpr_performance_cookies_tab_content"><?php _e('Tab Content','bbh-gdpr'); ?></label>
                </th>
            </tr>
            <tr class="bbh_gdpr_table_form_holder">
                <th colspan="2" scope="row">
                    <?php
                        $content =  isset( $gdpr_options['bbh_gdpr_performance_cookies_tab_content'.$wpml_lang] ) && $gdpr_options['bbh_gdpr_performance_cookies_tab_content'.$wpml_lang] ? wp_unslash( $gdpr_options['bbh_gdpr_performance_cookies_tab_content'.$wpml_lang] ) : false;
                        if ( ! $content ) :
                            $content    = $gdpr_default_content->bbh_gdpr_get_third_party_content();
                        endif;
                        ?>
                    <?php
                        $settings = array (
                            'media_buttons'     =>  false,
                            'editor_height'     =>  150,
                        );
                        wp_editor( $content, 'bbh_gdpr_performance_cookies_tab_content', $settings );
                    ?>
                </th>
            </tr>

            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <div class="alert script-error" style="display: none;"><?php _e('Please fill out at least one of these fields:','bbh-gdpr'); ?></div>
                </th>
            </tr>

            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="bbh_gdpr_third_party_header_scripts"><?php _e('The below script will be added to the page HEAD section if user enables this cookie.','bbh-gdpr'); ?></label>
                </th>
            </tr>
            <tr class="bbh_gdpr_third_party_header_scripts">
                <th scope="row" colspan="2">
                    <?php $content =  isset( $gdpr_options['bbh_gdpr_third_party_header_scripts'] ) && $gdpr_options['bbh_gdpr_third_party_header_scripts'] ? maybe_unserialize( $gdpr_options['bbh_gdpr_third_party_header_scripts'] ) : '';
                    ?>
                    <textarea name="bbh_gdpr_third_party_header_scripts" id="bbh_gdpr_third_party_header_scripts" class="large-text code" rows="13"><?php echo $content; ?></textarea>
                    <p class="description" id="bbh_gdpr_third_party_header_scripts-description"><?php _e('For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.','bbh-gdpr'); ?></p>
                </th>
            </tr>


            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="bbh_gdpr_third_party_body_scripts"><?php _e('The below script will be added right after the BODY section if user enables this cookie.','bbh-gdpr'); ?></label>
                </th>
            </tr>
            <tr class="bbh_gdpr_third_party_body_scripts">
                <th scope="row" colspan="2">
                    <?php $content =  isset( $gdpr_options['bbh_gdpr_third_party_body_scripts'] ) && $gdpr_options['bbh_gdpr_third_party_body_scripts'] ? maybe_unserialize( $gdpr_options['bbh_gdpr_third_party_body_scripts'] ) : '';
                    ?>
                    <textarea name="bbh_gdpr_third_party_body_scripts" id="bbh_gdpr_third_party_body_scripts" class="large-text code" rows="13"><?php echo $content; ?></textarea>
                    <p class="description" id="bbh_gdpr_third_party_body_scripts-description"><?php _e('For example, you can use it for Google Tag Manager script or any other 3rd party code snippets.','bbh-gdpr'); ?></p>
                </th>
            </tr>


            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="bbh_gdpr_third_party_footer_scripts"><?php _e('The below script will be added to the page FOOTER section if user enables this cookie.','bbh-gdpr'); ?></label>
                </th>
            </tr>
            <tr class="bbh_gdpr_third_party_footer_scripts">
                <th scope="row" colspan="2">
                    <?php $content =  isset( $gdpr_options['bbh_gdpr_third_party_footer_scripts'] ) && $gdpr_options['bbh_gdpr_third_party_footer_scripts'] ? maybe_unserialize( $gdpr_options['bbh_gdpr_third_party_footer_scripts'] ) : '';
                    ?>
                    <textarea name="bbh_gdpr_third_party_footer_scripts" id="bbh_gdpr_third_party_footer_scripts" class="large-text code" rows="13"><?php echo $content; ?></textarea>
                    <p class="description" id="bbh_gdpr_third_party_footer_scripts-description"><?php _e('For example, you can use it for Google Analytics script or any other 3rd party code snippets.','bbh-gdpr'); ?></p>
                </th>
            </tr>
        </tbody>
    </table>

    <hr />
    <br />
    <button type="submit" class="button button-primary"><?php _e('Save changes','bbh-gdpr'); ?></button>
</form>