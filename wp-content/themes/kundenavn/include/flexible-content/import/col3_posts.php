<section class="flexible-inner-section bbh-inner-section col3-posts">
    <div class="grid-container">
        <div class="col3-container">
            <?php
            $featured_posts = get_sub_field('pick_posts');
            if( $featured_posts ): ?>
                <?php foreach( $featured_posts as $featured_post ):
                    setup_postdata($post);
                    $permalink = get_the_permalink($featured_post->ID);
                    $title = get_the_title($featured_post->ID );
                    $img = get_field('img', $featured_post->ID);
                    $writer_img = get_field('writer_img', $featured_post->ID);
                    $writer = get_field('writer', $featured_post->ID);
                    $reading_time = get_field( 'reading_time', $featured_post->ID);
                    $colorbackground = get_field('background_color', $featured_post->ID);
                    $colortext = get_field('text_color', $featured_post->ID);
                        ?>
                        <a class="mini-card" href="<?php echo $permalink?>">
                            <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" />
                            <div class="mini-card-inner" style="background-color:<?php echo $colorbackground;?>;">
                                <h4 style="color:<?php echo $colortext;?>"><?php echo esc_html( $title ); ?></h4>
                                <span style="color:<?php echo $colortext;?>">Artikler</span>
                                <span class="reading-time" style="color:<?php echo $colortext;?>">
                                    <?php echo $reading_time;?>
                                </span>
                                <div class="author-row">
                                    <img class="avatar" src="<?php echo esc_url($writer_img['url']); ?>" alt="<?php echo esc_attr($writer_img['alt']); ?>" />
                                    <span class="author-name" style="color:<?php echo $colortext;?>"><?php echo $writer;?></span>
                                </div>
                            </div>
                        </a>
                <?php endforeach; ?>
            <?php
               // Reset the global post object so that the rest of the page works correctly.
               wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
    </div>
</section>
