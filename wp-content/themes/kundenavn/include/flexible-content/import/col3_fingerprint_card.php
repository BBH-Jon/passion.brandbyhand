<section class="col3-fingerprint">
    <div class="content grid-container">
        <div class="grid-inner-container">
            <?php
            // check if the repeater field has rows of data
            if( have_rows('add_fingerprint_card') ):
                // loop through the rows of data
                while ( have_rows('add_fingerprint_card') ) : the_row();
                    $link = get_sub_field('link');
                    $img = get_sub_field('img');
                    $headline = get_sub_field('headline');
                    $text = get_sub_field('text');
                    ?>
                    <a class="card-container"target="<?php echo $link['target'] ?>" href="<?php echo $link['url'] ?>">
                        <div class="card">
                            <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" />
                            <h3><?php echo $headline;?></h3>
                            <div class="text">
                                <?php echo $text;?>
                            </div>
                        </div>
                    </a>
                    <?php
                endwhile;
            endif;
            ?>

        </div>
    </div>
</section>
