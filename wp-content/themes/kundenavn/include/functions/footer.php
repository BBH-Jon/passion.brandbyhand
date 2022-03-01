<?php
add_action( 'generate_after_footer_widgets','footer_contnet' );
function footer_contnet() { ?>
    <div class="footer-bottom-section">
        <div class="some-icons">
            <a href="https://www.linkedin.com/company/brand-by-hand/mycompany/"><i class="icon-icon_linkedin"></i></a>
            <a href="https://www.facebook.com/brandbyhand"><i class="icon-icon_facebook-square"></i></a>
            <a href="https://www.instagram.com/brandbyhand/"><i class="icon-icon_instagram"></i></a>
            <a href="https://twitter.com/brandbyhand"><i class="icon-icon_facebook-square"></i></a>
        </div>
        <div class="other-links">
            <a href="#">Privatlivspolitik*</a><span> | </span><a href="#">GDPR*</a>
        </div>
    </div>
<?php }
