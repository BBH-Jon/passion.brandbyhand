<?php
add_action( 'generate_after_footer_widgets','footer_contnet' );
function footer_contnet() { ?>
    <div class="footer-bottom-section">
        <div class="some-icons">
            <a href="https://www.linkedin.com/company/brand-by-hand/mycompany/"><i class="icon-linkedin"></i></a>
            <a href="https://www.facebook.com/brandbyhand"><i class="icon-facebook"></i></a>
            <a href="https://www.instagram.com/brandbyhand/"><i class="icon-instagram"></i></a>
            <a href="https://twitter.com/brandbyhand"><i class="icon-twitter"></i></a>
        </div>
        <div class="other-links">
            <a href="#">Privatlivspolitik*</a><span> | </span><a href="#">GDPR*</a>
        </div>
    </div>
<?php }
