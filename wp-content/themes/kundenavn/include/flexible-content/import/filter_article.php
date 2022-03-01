<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
    <div class="grid-container">
        <div class="field-wrap">
            <?php
                $taxonomies = get_object_taxonomies('cases', 'cases', 'news', 'news','post', 'post');
                foreach($taxonomies as $tax) {
                    $terms = get_terms($tax->name, 'orderby=id&hide_empty=1');
                    echo '<div class="checkboxes">';
                    echo '<div class="checkbox">';
                        echo '<input id="resetform" type="radio" name="'.$tax->name.'" checked hidden>'; // ID of the category as the value of an option
                        echo '<label for="">Alle</label>';
                    echo '</div>';
                    foreach ( $terms as $term) :
                        echo '<div class="checkbox">';
                            echo '<input type="radio" value="'.$term->term_id.'" name="'.$tax->name.'" hidden>'; // ID of the category as the value of an option
                            echo '<label for="'.$tax->name.'">'.$term->name.'</label>';
                        echo '</div>';
                    endforeach;
                    echo '</div>'; // .checkboxes
                }
            ?>
        </div>
    </div>
    <?php // nonce security; ?>
    <input type="hidden" name="security" id="cases-ajax-nonce" value="<?php echo wp_create_nonce( 'cases-ajax-nonce' ) ?>"/><!-- "id'et" går igen i wp_create_nonce og igen i din ajax fil -->
<!-- The below input value must be called the same as your ajax function. -->
    <input type="hidden" name="action" value="cases_ajax">
</form>

<div id="response" class="cards">
                    <?php
                            wp_reset_query();
                            $args = array(
                                'orderby' => 'date',
                                'order'  => 'DESC',
                                'post_type' => array('post'),
                                //'posts_per_page' => 3,
                                'posts_per_page' => 6,
                                'post_status' => 'publish',
                             );
                             $loop = new WP_Query($args);
                             if($loop->have_posts()) {?>
                                 <div class="grid-container">
                                     <div class="mini-card-container"><?php
                                while($loop->have_posts()) : $loop->the_post();
                                $permalink = get_the_permalink();
                                $title = get_the_title();
                                $img = get_field('img');
                                $writer_img = get_field('writer_img');
                                $writer = get_field('writer');
                                $reading_time = get_field( 'reading_time');
                                $colorbackground = get_field('background_color');
                                $colortext = get_field('text_color');
                                    ?>
                                    <a class="mini-card" href="<?php echo $permalink?>">
                                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" />
                                        <div class="mini-card-inner" style="background-color:<?php echo $colorbackground;?>;">
                                            <h4 style="color:<?php echo $colortext;?>"><?php echo get_the_title(); ?></h4>
                                            <span style="color:<?php echo $colortext;?>">Artikel</span>
                                            <span class="reading-time" style="color:<?php echo $colortext;?>">
                                                <?php echo $reading_time;?>
                                            </span>
                                            <div class="author-row">
                                                <img class="avatar" src="<?php echo esc_url($writer_img['url']); ?>" alt="<?php echo esc_attr($writer_img['alt']); ?>" />
                                                <span class="author-name" style="color:<?php echo $colortext;?>"><?php echo $writer;?></span>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                endwhile;?>
                            </div>
                        </div><?php
                             }
                        wp_reset_postdata()
                    ?>
                </div>
