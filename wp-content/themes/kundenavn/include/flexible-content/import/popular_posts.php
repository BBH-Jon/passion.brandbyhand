<section class="flexible-inner-section bbh-inner-section popular">
    <div class="grid-container-full">
        <div class="popular-container">
            <div class="popular-card">
                <h2>Populære indlæg</h2>
            </div>
            <?php
            $pick_popular_post = get_field('pick_popular_post', 'options');
            if( $pick_popular_post ): ?>
                <div  class="popular-inner-container">
                <?php foreach( $pick_popular_post as $popular_posts ):
                    $permalink = get_permalink( $popular_posts->ID );
                    $title = get_the_title( $popular_posts->ID );
                    $img = get_field('img', $popular_posts->ID );
                    $writer_img = get_field('writer_img', $popular_posts->ID );
                    $writer = get_field('writer', $popular_posts->ID );
                    $reading_time = get_field( 'reading_time', $popular_posts->ID );
                    ?>
                    <a class="mini-card" href="<?php echo $permalink?>">
                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" />
                        <div class="mini-card-inner">
                            <span>- Artikler</span>
                            <h4><?php echo $title;?></h4>
                            <span class="reading-time">
                                <?php echo $reading_time;?>
                            </span>
                            <div class="author-row">
                                <img class="avatar" src="<?php echo esc_url($writer_img['url']); ?>" alt="<?php echo esc_attr($writer_img['alt']); ?>" />
                                <span class="author-name"><?php echo $writer;?></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div class="popular-inner-container">
            <?php endif; ?>
        </div>
    </div>
</section>
