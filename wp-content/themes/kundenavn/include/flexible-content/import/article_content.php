
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
            <div id="fb-root" class="social-media">
                <?php if($social_medie):?>
                    <?php
                    echo do_shortcode('[social]');?>

                <?php endif;?>
            </div>
        </div>
        <div class="article-container">
            <?php echo $artcile;?>
        </div>
    </div>
</section>
