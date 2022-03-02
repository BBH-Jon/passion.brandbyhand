
<?php
$writer_name = get_sub_field('writer_name');
$writer_img = get_sub_field('writer_img');
$social_medie = get_sub_field('social_medie');
$artcile = get_sub_field('artcile');
?>

<section class="flexible-inner-section bbh-inner-section article">
    <div class="grid-container">
        <div class="writer-info">
            <div class="author">
                <img class="avatar" src="<?php echo esc_url($writer_img['url']); ?>" alt="<?php echo esc_attr($writer_img['alt']); ?>" />
                <span class="author-name"><?php echo $writer_name;?></span>
            </div>
            <div class="social-media">
                <?php if($social_medie):?>
                    <i class="icon-linkedin"></i>
                    <i class="icon-facebook"></i>
                    <i class="icon-instagram"></i>
                    <i class="icon-twitter"></i>
                <?php endif;?>
                <?php if($social_medie == 'linkedin'):?>
                    <i class="icon-icon_linkedin"></i>
                <?php endif;?>
                <?php if($social_medie == 'facebook'):?>
                    <i class="icon-icon_facebook-square"></i>
                    <p>test</p>
                <?php endif;?>
                <?php if($social_medie == 'instagram'):?>
                    <i class="icon-icon_instagram"></i>
                <?php endif;?>
                <?php if($social_medie == 'twitter'):?>
                    <i class="icon-icon_envelope"></i>
                <?php endif;?>
            </div>
        </div>
        <div class="article-container">
            <?php echo $artcile;?>
        </div>
    </div>
</section>
