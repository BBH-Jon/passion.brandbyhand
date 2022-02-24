<?php

$or = get_sub_field('or');
$color = get_sub_field('color');
$headline_left = get_sub_field('headline_left');
$headline_right = get_sub_field('headline_right');
$img_right = get_sub_field('img_right');
$img_left = get_sub_field('img_left');
$highligted_ord = get_sub_field('highligted_ord');
$headline_mid = get_sub_field('headline_mid');
$img_mid = get_sub_field('img_mid');

?>

<?php if ($or === 'img_right'): ?>
    <section style="background-color:<?php echo $color;?>" class="header-section <?php echo $or;?>">
        <div class="content grid-container">
            <div class="row">
                <div class="col-lg-6" id="h1_highlight">
                    <?php echo $headline_left;?>
                </div>
                <div class="col-lg-6">
                    <img class="lazyload" src="<?php echo $img_right['url']; ?>" alt="">
                </div>
            </div>
        </div>
    </section>
<?php elseif(($or === 'article')): ?>
    <section style="background-color:<?php echo $color;?>" class="header-section <?php echo $or;?>">
        <div class="content grid-container">
            <div class="article-header-inner" id="h1_highlight">
                <div class="headline">
                    <?php echo $headline_mid;?>
                </div>
                <div class="hero-img">
                    <img class="lazyload" src="<?php echo $img_mid['url']; ?>" alt="">
                </div>
            </div>
        </div>
    </section>
<?php elseif(($or === 'front_page')): ?>
    <section style="background-color:<?php echo $color;?>" class="header-section <?php echo $or;?>">
        <div class="content grid-container">
            <div class="row">
                <div class="col-lg-6" id="h1_highlight">
                    <?php echo $headline_left;?>
                </div>
                <div class="col-lg-6">
                    <img class="lazyload" src="<?php echo $img_right['url']; ?>" alt="">
                </div>
            </div>
        </div>
    </section>
<?php elseif($or === 'img_left'): ?>
    <section style="background-color:<?php echo $color;?>" class="flexible-inner-section bbh-inner-section header-section <?php echo $or;?>">
        <div class="content grid-container">
            <div class="row">
                <div class="col-lg-6">
                    <img class="lazyload" src="<?php echo $img_left['url']; ?>" alt="">
                </div>
                <div class="col-lg-6" id="h1_highlight">
                    <?php echo $headline_right;?>
                </div>
            </div>
        </div>
    </section>
<?php endif;?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script>
var h1 = $('#h1_highlight h1');
var str = '<?php echo $highligted_ord;?>';
h1.html(h1.text().replace(str, '<span class="highlight">'+str+'</span>'));
</script>

<style media="screen">
    .main-navigation{
        background-color: <?php echo $color;?>
    }
</style>
