<?php
$pdf = get_field('pdf', 'option');
$text_1 = get_field('text_1', 'option');
$text_2 = get_field('text_2', 'option');
?>
<section class="flexible-inner-section bbh-inner-section single-bar">
    <div class="content grid-container">
        <div class="bar-container">
                <div class="item-1">
                    <h4 class="bold"><?php echo $text_1;?></h4>
                </div>
                <div class="item-2">
                    <h4><?php echo $text_2;?></h4>
                </div>
                <div class="item-3">
                    <a class="link" href="<?php echo $pdf['url']; ?>">Hen det lige nu <i class="icon-pil-cirkel"></i></a>
                </div>
        </div>
    </div>
</section>
