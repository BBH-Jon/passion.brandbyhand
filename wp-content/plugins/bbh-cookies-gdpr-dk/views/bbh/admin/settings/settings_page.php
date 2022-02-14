<div class="wrap" id="bbh_form_checker_wrap">
    <h1><?php _e('GDPR Cookie Compliance Plugin Settings','bbh-gdpr'); ?></h1>
    <div id="bbh-gdpr-setting-error-settings_updated" class="updated settings-error notice is-dismissible" style="display:none;">
        <p><strong><?php _e('Settings saved.','bbh-gdpr'); ?></strong></p>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"><?php _e('Dismiss this notice.','bbh-gdpr'); ?></span>
        </button>
    </div>

    <div id="bbh-gdpr-setting-error-settings_scripts_empty" class="error settings-error notice is-dismissible" style="display:none;">
        <p>
            <strong><?php _e('You need to insert the relevant script for the settings to be saved!','bbh-gdpr'); ?></strong>
        </p>
        <button type="button" class="notice-dismiss">
            <span class="screen-reader-text"><?php _e('Dismiss this notice.','bbh-gdpr'); ?></span>
        </button>
    </div>

    <h4><?php _e('General Data Protection Regulation (GDPR) is a <a href="http://www.eugdpr.org/" target="_blank">European regulation</a> to strengthen and unify the data protection of EU citizens.','bbh-gdpr'); ?><br> </h4>

    <?php
        $gdpr_default_content = new bbh_GDPR_Content();
        $current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : '';
        if( isset( $current_tab ) &&  $current_tab !== '' ) :
            $active_tab = $current_tab;
        else :
            $active_tab = "general_settings";
        endif; // end if

        ob_start();
        $view_cnt = new bbh_GDPR_View();
        echo $view_cnt->load( 'bbh.admin.settings.' . $active_tab , $data );
        $tab_data = ob_get_clean();

        $option_name    = $gdpr_default_content->bbh_gdpr_get_option_name();
        $modal_options  = get_option( $option_name );
        $wpml_lang      = $gdpr_default_content->bbh_gdpr_get_wpml_lang();
    ?>

    <h2 class="nav-tab-wrapper">
        <a href="?page=bbh-gdpr&amp;tab=general_settings" class="nav-tab <?php echo $active_tab == 'general_settings' ? 'nav-tab-active' : ''; ?>">
            <?php _e('General Settings','bbh-gdpr'); ?>
        </a>

        <?php
            $nav_label  = isset( $modal_options['bbh_gdpr_privacy_overview_tab_title'.$wpml_lang] ) && $modal_options['bbh_gdpr_privacy_overview_tab_title'.$wpml_lang] ? $modal_options['bbh_gdpr_privacy_overview_tab_title'.$wpml_lang] : __('Privacy Overview','bbh-gdpr');
        ?>
        <a href="?page=bbh-gdpr&amp;tab=privacy_overview" class="nav-tab <?php echo $active_tab == 'privacy_overview' ? 'nav-tab-active' : ''; ?>">
            <?php echo $nav_label; ?>
        </a>

        <?php
            $nav_label  = isset( $modal_options['bbh_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ) && $modal_options['bbh_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ? $modal_options['bbh_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] : __('Strictly Necessary Cookies','bbh-gdpr');
        ?>
        <a href="?page=bbh-gdpr&amp;tab=strictly_necessary_cookies" class="nav-tab <?php echo $active_tab == 'strictly_necessary_cookies' ? 'nav-tab-active' : ''; ?>">
            <?php echo $nav_label; ?>
        </a>

        <?php
            $nav_label  = isset( $modal_options['bbh_gdpr_performance_cookies_tab_title'.$wpml_lang] ) && $modal_options['bbh_gdpr_performance_cookies_tab_title'.$wpml_lang] ? $modal_options['bbh_gdpr_performance_cookies_tab_title'.$wpml_lang] : __('3rd Party Cookies','bbh-gdpr');
        ?>
        <a href="?page=bbh-gdpr&amp;tab=third_party_cookies" class="nav-tab <?php echo $active_tab == 'third_party_cookies' ? 'nav-tab-active' : ''; ?>">
            <?php echo $nav_label; ?>
        </a>

        <?php
            $nav_label  = isset( $modal_options['bbh_gdpr_advanced_cookies_tab_title'.$wpml_lang] ) && $modal_options['bbh_gdpr_advanced_cookies_tab_title'.$wpml_lang] ? $modal_options['bbh_gdpr_advanced_cookies_tab_title'.$wpml_lang] : __('Additional Cookies','bbh-gdpr');
        ?>
        <a href="?page=bbh-gdpr&amp;tab=advanced_cookies" class="nav-tab <?php echo $active_tab == 'advanced_cookies' ? 'nav-tab-active' : ''; ?>">
            <?php echo $nav_label; ?>
        </a>
        <?php
            $nav_label  = isset( $modal_options['bbh_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ) && $modal_options['bbh_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ? $modal_options['bbh_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] : __('Cookie Policy','bbh-gdpr');
        ?>
        <a href="?page=bbh-gdpr&amp;tab=cookie_policy" class="nav-tab <?php echo $active_tab == 'cookie_policy' ? 'nav-tab-active' : ''; ?>">
            <?php echo $nav_label; ?>
        </a>
    </h2>

    <div class="bbh-gdpr-form-container <?php echo $active_tab; ?>">
        <a href="https://www.brandbyhand.dk" target="blank" title="WordPress agency"><span class="bbh-logo"></span></a>
        <?php echo $tab_data; ?>
    </div>
    <!-- bbh-form-container -->
    <div class="bbh-gdpr-settings-branding">
        <hr />
        <?php _e('<p>This plugin was originally developed by <a href="https://www.mooveagency.com/" title="WordPress Agency" target="_blank">Moove</a>, but has been rewritten by <a href="https://www.brandbyhand.dk/" title="WordPress Agency" target="_blank"><span></span></a> - wordpress agency</p>', 'bbh-gdpr'); ?>
        <hr />
    </div>
    <!--  .bbh-gdpr-settings-branding -->
</div>
<!-- .wrap -->
