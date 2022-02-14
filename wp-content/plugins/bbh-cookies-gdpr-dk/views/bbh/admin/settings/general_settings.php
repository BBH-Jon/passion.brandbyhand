<?php
    $gdpr_default_content = new bbh_GDPR_Content();
    $option_name    = $gdpr_default_content->bbh_gdpr_get_option_name();
    $gdpr_options   = get_option( $option_name );
    $wpml_lang      = $gdpr_default_content->bbh_gdpr_get_wpml_lang();
    $gdpr_options   = is_array( $gdpr_options ) ? $gdpr_options : array();
    if ( isset( $_POST ) && isset( $_POST['bbh_gdpr_nonce'] ) ) :
        $nonce = sanitize_key( $_POST['bbh_gdpr_nonce'] );
        if ( ! wp_verify_nonce( $nonce, 'bbh_gdpr_nonce_field' ) ) :
            die( 'Security check' );
        else :
            if ( is_array( $_POST ) ) :
                if ( isset( $_POST['bbh_gdpr_floating_button_enable'] ) ) :
                    $value  = 1;
                else :
                    $value  = 0;
                endif;
                $gdpr_options['bbh_gdpr_floating_button_enable'] = $value;
                update_option( $option_name, $gdpr_options );
                $gdpr_options = get_option( $option_name );
                foreach ( $_POST as $form_key => $form_value ) :
                    if ( $form_key === 'bbh_gdpr_info_bar_content' ) :
                        $value  = apply_filters( 'the_content', wp_unslash( $form_value ) );
                        $gdpr_options[$form_key.$wpml_lang] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    elseif ( $form_key !== 'bbh_gdpr_floating_button_enable' ) :
                        $value  = sanitize_text_field( $form_value );
                        $gdpr_options[$form_key] = $value;
                        update_option( $option_name, $gdpr_options );
                        $gdpr_options = get_option( $option_name );
                    endif;
                endforeach;
            endif;
            ?>
                <script>
                    jQuery('#bbh-gdpr-setting-error-settings_updated').show();
                </script>
            <?php
        endif;
    endif;
?>
<br />
<form action="?page=bbh-gdpr&amp;tab=general_settings" method="post" id="bbh_gdpr_tab_general_settings">
    <h2><?php _e('Modal General Settings','bbh-gdpr'); ?></h2>
    <hr />
    <?php wp_nonce_field( 'bbh_gdpr_nonce_field', 'bbh_gdpr_nonce' ); ?>
    <table class="form-table">
        <tbody>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_brand_colour"><?php _e('Brand Primary Colour','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input class="jscolor {hash:true} regular-text" name="bbh_gdpr_brand_colour" value="<?php echo isset( $gdpr_options['bbh_gdpr_brand_colour'] ) && $gdpr_options['bbh_gdpr_brand_colour'] ? $gdpr_options['bbh_gdpr_brand_colour'] : '0C4DA2'; ?>" >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_brand_secondary_colour"><?php _e('Brand Secondary Colour','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input class="jscolor {hash:true} regular-text" name="bbh_gdpr_brand_secondary_colour" value="<?php echo isset( $gdpr_options['bbh_gdpr_brand_secondary_colour'] ) && $gdpr_options['bbh_gdpr_brand_secondary_colour'] ? $gdpr_options['bbh_gdpr_brand_secondary_colour'] : '000000'; ?>" >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_company_logo"><?php _e('Modal Logo','bbh-gdpr'); ?></label>
                    <p class="description"><?php _e('Recommended size:','bbh-gdpr'); ?><br>130 x 50 <?php _e('pixels','bbh-gdpr'); ?></p>
                    <!--  .description -->
                </th>
                <td>
                    <?php
                        if ( function_exists( 'wp_enqueue_media' ) ) :
                            wp_enqueue_media();
                        else:
                            wp_enqueue_style('thickbox');
                            wp_enqueue_script('media-upload');
                            wp_enqueue_script('thickbox');
                        endif;
                    ?>
                    <?php
                    $plugin_dir = bbh_gdpr_get_plugin_directory_url();
                    $image_url = isset( $gdpr_options['bbh_gdpr_company_logo'] ) && $gdpr_options['bbh_gdpr_company_logo'] ? $gdpr_options['bbh_gdpr_company_logo'] : $plugin_dir.'dist/images/bbh-logo.png';
                    ?>
                    <span class="bbh_gdpr_company_logo_holder" style="background-image: url(<?php echo $image_url; ?>);"></span><br /><br />
                    <input class="regular-text code" type="text" name="bbh_gdpr_company_logo" value="<?php echo $image_url; ?>" required> <br /><br />
                    <a href="#" class="button bbh_gdpr_company_logo_upload">Upload Logo</a>
                    <script>
                        jQuery(document).ready(function($) {
                            $('.bbh_gdpr_company_logo_upload').click(function(e) {
                                e.preventDefault();

                                var custom_uploader = wp.media({
                                    title: 'GDPR Modal - Company Logo',
                                    button: {
                                        text: 'Upload Logo'
                                    },
                                    multiple: false  // Set this to true to allow multiple files to be selected
                                })
                                .on('select', function() {
                                    var attachment = custom_uploader.state().get('selection').first().toJSON();
                                    $('.bbh_gdpr_company_logo_holder').css('background-image', 'url('+attachment.url+')');
                                    $('input[name=bbh_gdpr_company_logo]').val(attachment.url);

                                })
                                .open();
                            });
                        });
                    </script>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_logo_position"><?php _e('Logo Position','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input name="bbh_gdpr_logo_position" type="radio" value="left" id="bbh_gdpr_logo_position_left" <?php echo isset( $gdpr_options['bbh_gdpr_logo_position'] ) ? ( $gdpr_options['bbh_gdpr_logo_position'] === 'left'  ? 'checked' : '' ) : 'checked'; ?> class="regular-text on-off"> <label for="bbh_gdpr_logo_position_left"><?php _e('Left','bbh-gdpr'); ?></label> <span class="separator"></span>
                    <input name="bbh_gdpr_logo_position" type="radio" value="center" id="bbh_gdpr_logo_position_center" <?php echo isset( $gdpr_options['bbh_gdpr_logo_position'] ) ? ( $gdpr_options['bbh_gdpr_logo_position'] === 'center'  ? 'checked' : '' ) : ''; ?> class="regular-text on-off"> <label for="bbh_gdpr_logo_position_center"><?php _e('Center','bbh-gdpr'); ?></label> <span class="separator"></span>
                    <input name="bbh_gdpr_logo_position" type="radio" value="right" id="bbh_gdpr_logo_position_right" <?php echo isset( $gdpr_options['bbh_gdpr_logo_position'] ) ? ( $gdpr_options['bbh_gdpr_logo_position'] === 'right'  ? 'checked' : '' ) : ''; ?> class="regular-text on-off"> <label for="bbh_gdpr_logo_position_right"><?php _e('Right','bbh-gdpr'); ?></label>

                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_modal_save_button_label"><?php _e('Save Settings - Button Label','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input name="bbh_gdpr_modal_save_button_label<?php echo $wpml_lang; ?>" type="text" id="bbh_gdpr_modal_save_button_label" value="<?php echo isset( $gdpr_options['bbh_gdpr_modal_save_button_label'.$wpml_lang] ) && $gdpr_options['bbh_gdpr_modal_save_button_label'.$wpml_lang] ? $gdpr_options['bbh_gdpr_modal_save_button_label'.$wpml_lang] : __('Save Changes','bbh-gdpr'); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_modal_allow_button_label"><?php _e('Enable All - Button Label','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input name="bbh_gdpr_modal_allow_button_label<?php echo $wpml_lang; ?>" type="text" id="bbh_gdpr_modal_allow_button_label" value="<?php echo isset( $gdpr_options['bbh_gdpr_modal_allow_button_label'.$wpml_lang] ) && $gdpr_options['bbh_gdpr_modal_allow_button_label'.$wpml_lang] ? $gdpr_options['bbh_gdpr_modal_allow_button_label'.$wpml_lang] : __('Enable all','bbh-gdpr'); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_modal_allow_button_label"><?php _e('Checkbox Labels','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input name="bbh_gdpr_modal_enabled_checkbox_label<?php echo $wpml_lang; ?>" type="text" id="bbh_gdpr_modal_enabled_checkbox_label" value="<?php echo isset( $gdpr_options['bbh_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ) && $gdpr_options['bbh_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ? $gdpr_options['bbh_gdpr_modal_enabled_checkbox_label'.$wpml_lang] : __('Enabled','bbh-gdpr'); ?>" class="regular-text"><br />
                    <input name="bbh_gdpr_modal_disabled_checkbox_label<?php echo $wpml_lang; ?>" type="text" id="bbh_gdpr_modal_disabled_checkbox_label" value="<?php echo isset( $gdpr_options['bbh_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ) && $gdpr_options['bbh_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ? $gdpr_options['bbh_gdpr_modal_disabled_checkbox_label'.$wpml_lang] : __('Disabled','bbh-gdpr'); ?>" class="regular-text">
                </td>

            </tr>



        </tbody>
    </table>
    <br />
    <hr />
    <h2><?php _e('Cookie Info Bar Settings','bbh-gdpr'); ?></h2>
    <hr />

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row" colspan="2" style="padding-bottom: 0;">
                    <label for="bbh_gdpr_info_bar_content"><?php _e('Infobar Content','bbh-gdpr'); ?></label>
                </th>
            </tr>
            <tr class="bbh_gdpr_table_form_holder">
                <th colspan="2" scope="row">
                    <?php
                        $content =  isset( $gdpr_options['bbh_gdpr_info_bar_content'.$wpml_lang] ) && $gdpr_options['bbh_gdpr_info_bar_content'.$wpml_lang] ? maybe_unserialize( $gdpr_options['bbh_gdpr_info_bar_content'.$wpml_lang] ) : false;
                        if ( ! $content ) :
                            $_content   = __("<p>We are using cookies to ensure our users get the best experience on this website.</p><p>You can read more about which cookies we are using or disable them off in [setting]settings[/setting].</p>","bbh-gdpr");
                            $content    = apply_filters( 'the_content', $_content );
                        endif;
                        ?>
                    <?php
                        $settings = array (
                            'media_buttons'     =>  false,
                            'editor_height'     =>  150,
                            'teeny'             =>  true
                        );
                        wp_editor( $content, 'bbh_gdpr_info_bar_content', $settings );
                    ?>
                    <p class="description"><?php _e('You can use the following shortcut to link the settings modal:<br><span><strong>[setting]</strong>settings<strong>[/setting]</strong></span>','bbh-gdpr'); ?></p>
                </th>
            </tr>
            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_infobar_accept_button_label"><?php _e('Accept - Button Label','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input name="bbh_gdpr_infobar_accept_button_label<?php echo $wpml_lang; ?>" type="text" id="bbh_gdpr_infobar_accept_button_label" value="<?php echo isset( $gdpr_options['bbh_gdpr_infobar_accept_button_label'.$wpml_lang] ) && $gdpr_options['bbh_gdpr_infobar_accept_button_label'.$wpml_lang] ? $gdpr_options['bbh_gdpr_infobar_accept_button_label'.$wpml_lang] : __('Accept','bbh-gdpr'); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_colour_scheme"><?php _e('Colour scheme','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e('Enable','bbh-gdpr'); ?></span></legend>
                            <input name="bbh_gdpr_colour_scheme" type="radio" <?php echo isset( $gdpr_options['bbh_gdpr_colour_scheme'] ) ? ( intval( $gdpr_options['bbh_gdpr_colour_scheme'] ) === 1  ? 'checked' : ( ! isset( $gdpr_options['bbh_gdpr_colour_scheme'] ) ? 'checked' : '' ) ) : 'checked'; ?> id="bbh_gdpr_colour_scheme_dark" value="1">
                            <label for="bbh_gdpr_colour_scheme_dark"><?php _e('Dark','bbh-gdpr'); ?></label> <br>

                            <input name="bbh_gdpr_colour_scheme" type="radio" <?php echo isset( $gdpr_options['bbh_gdpr_colour_scheme'] ) ? ( intval( $gdpr_options['bbh_gdpr_colour_scheme'] ) === 2  ? 'checked' : '' ) : ''; ?> id="bbh_gdpr_colour_scheme_light" value="2">
                            <label for="bbh_gdpr_colour_scheme_light"><?php _e('Light','bbh-gdpr'); ?></label>
                    </fieldset>
                </td>
            </tr>

        </tbody>
    </table>

    <br />
    <hr />
    <h2><?php _e('Change Settings - Floating Button','bbh-gdpr'); ?></h2>
    <hr />

    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_floating_button_enable"><?php _e('Enable Floating Button','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <fieldset>
                        <legend class="screen-reader-text"><span><?php _e('Enable','bbh-gdpr'); ?></span></legend>
                        <label for="bbh_gdpr_floating_button_enable">
                            <input name="bbh_gdpr_floating_button_enable" type="checkbox" <?php echo isset( $gdpr_options['bbh_gdpr_floating_button_enable'] ) ? ( intval( $gdpr_options['bbh_gdpr_floating_button_enable'] ) === 1  ? 'checked' : '' ) : ''; ?> id="bbh_gdpr_floating_button_enable" value="1">
                            <?php _e('Enable','bbh-gdpr'); ?></label>
                    </fieldset>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_floating_button_label"><?php _e('Button - Hover Label','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input name="bbh_gdpr_floating_button_label<?php echo $wpml_lang; ?>" type="text" id="bbh_gdpr_floating_button_label" value="<?php echo isset( $gdpr_options['bbh_gdpr_floating_button_label'.$wpml_lang] ) && $gdpr_options['bbh_gdpr_floating_button_label'.$wpml_lang] ? $gdpr_options['bbh_gdpr_floating_button_label'.$wpml_lang] : __('Change cookie settings','bbh-gdpr'); ?>" class="regular-text">
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_floating_button_position"><?php _e('Button - Custom Position (CSS)','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input name="bbh_gdpr_floating_button_position" type="text" id="bbh_gdpr_floating_button_position" value="<?php echo isset( $gdpr_options['bbh_gdpr_floating_button_position'] ) && $gdpr_options['bbh_gdpr_floating_button_position'] ? $gdpr_options['bbh_gdpr_floating_button_position'] : 'bottom: 20px; left: 20px;'; ?>" class="regular-text">
                    <p class="description" id="bbh_gdpr_floating_button_position-description"><?php _e('You can align the position eg.: <strong>top: 20px; right: 20px;</strong>','bbh-gdpr'); ?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_floating_button_background_colour"><?php _e('Button - Background Colour','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input class="jscolor {hash:true} regular-text" name="bbh_gdpr_floating_button_background_colour" value="<?php echo isset( $gdpr_options['bbh_gdpr_floating_button_background_colour'] ) && $gdpr_options['bbh_gdpr_floating_button_background_colour'] ? $gdpr_options['bbh_gdpr_floating_button_background_colour'] : '373737'; ?>" >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_floating_button_hover_background_colour"><?php _e('Button - Hover Background Colour','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input class="jscolor {hash:true} regular-text" name="bbh_gdpr_floating_button_hover_background_colour" value="<?php echo isset( $gdpr_options['bbh_gdpr_floating_button_hover_background_colour'] ) && $gdpr_options['bbh_gdpr_floating_button_hover_background_colour'] ? $gdpr_options['bbh_gdpr_floating_button_hover_background_colour'] : '000000'; ?>" >
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="bbh_gdpr_floating_button_font_colour"><?php _e('Button - Font Colour','bbh-gdpr'); ?></label>
                </th>
                <td>
                    <input class="jscolor {hash:true} regular-text" name="bbh_gdpr_floating_button_font_colour" value="<?php echo isset( $gdpr_options['bbh_gdpr_floating_button_font_colour'] ) && $gdpr_options['bbh_gdpr_floating_button_font_colour'] ? $gdpr_options['bbh_gdpr_floating_button_font_colour'] : 'ffffff'; ?>" >
                </td>
            </tr>

        </tbody>
    </table>

    <br />
    <hr />
    <br />
    <button type="submit" class="button button-primary"><?php _e('Save changes','bbh-gdpr'); ?></button>
</form>
