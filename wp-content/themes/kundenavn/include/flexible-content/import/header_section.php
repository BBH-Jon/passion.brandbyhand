<?php

$or = get_sub_field('or');
$color = get_sub_field('color');
$headline_left = get_sub_field('headline_left');
$headline_right = get_sub_field('headline_right');
$img_right = get_sub_field('img_right');
$img_left = get_sub_field('img_left');

?>

<?php if ($or === 'img_right'): ?>
    <section style="background-color:<?php echo $color;?>" class="flexible-inner-section bbh-inner-section header-section <?php echo $or;?>">
        <div class="content grid-container">
            <div class="row">
                <div class="col-lg-6">
                    <?php echo $headline_left;?>
                </div>
                <div class="col-lg-6">
                    <img class="lazyload" src="<?php echo $img_right['url']; ?>" alt="">
                </div>
            </div>
        </div>
    </section>
<?php else: ?>
    <section style="background-color:<?php echo $color;?>" class="flexible-inner-section bbh-inner-section header-section <?php echo $or;?>">
        <div class="content grid-container">
            <div class="row">
                <div class="col-lg-6">
                    <img class="lazyload" src="<?php echo $img_left['url']; ?>" alt="">
                </div>
                <div class="col-lg-6">
                    <?php echo $headline_right;?>
                </div>
            </div>
        </div>
    </section>
<?php endif;?>
