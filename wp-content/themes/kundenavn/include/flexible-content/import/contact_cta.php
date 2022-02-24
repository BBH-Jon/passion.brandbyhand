
<?php
$content = get_sub_field('content');
$img = get_sub_field('img');
?>

<section class="flexible-inner-section bbh-inner-section contact-cta">
    <div class="grid-container">
        <div class="container">
            <img class="avatar" src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" />
            <div class="content">
                <?php echo $content;?>
            </div>
        </div>
    </div>
</section>
