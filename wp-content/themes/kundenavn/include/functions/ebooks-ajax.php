<?php
add_action('wp_ajax_ebooks_ajax', 'ebooks_ajax'); // Change names according to your form
add_action('wp_ajax_nopriv_ebooks_ajax', 'ebooks_ajax'); // Change names according to your form
/*-------------- Function to execute -------------*/
function ebooks_ajax(){
    // check for nonce security
    $nonce = $_POST['security'];
    if ( ! wp_verify_nonce( $nonce, 'ebooks-ajax-nonce' ) ){
        die;
    }

    $args = array(
        'orderby' => 'ID',
        'order'  => 'ASC',
        'post_type' => array('cases'),
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'tax_query' => array(
            'relation' => 'AND',
        ),
    );

    // compare on all taxonomies
    $taxonomies = get_object_taxonomies('cases', 'cases', 'news', 'news','post');
    foreach($taxonomies as $tax) {
        $terms = get_terms($tax->name, 'hide_empty=0');
        if( isset( $_POST[$tax->name] ) && !empty( $_POST[$tax->name] )){
            $tax = array(
                'taxonomy' => $tax->name,
                'field' => 'term_id',
                'terms' => $_POST[$tax->name],
                'operator' => 'IN'
            );
            array_push($args['tax_query'], $tax);
        }
    }

    $the_query = new WP_Query( $args );

    ob_start();
    if( $the_query->have_posts() ) : ?>
        <div class="grid-container">
            <div class="mini-card-container"><?php
                while( $the_query->have_posts() ): $the_query->the_post(); ?>
                <?php
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
                            <span style="color:<?php echo $colortext;?>">E-bog</span>
                            <span style="color:<?php echo $colortext;?>" class="reading-time">
                                <?php echo $reading_time;?>
                            </span>
                            <div class="author-row">
                                <img class="avatar" src="<?php echo esc_url($writer_img['url']); ?>" alt="<?php echo esc_attr($writer_img['alt']); ?>" />
                                <span style="color:<?php echo $colortext;?>" class="author-name"><?php echo $writer;?></span>
                            </div>
                        </div>
                    </a>
                    <!-- INSERT YOUR MARKUP FOR EACH POST HERE -->
                <?php endwhile; ?>
            </div>
        </div>
        <?php
        wp_reset_postdata();
    else :
        echo '<div class="grid-container"><h4 class="no-matches">Der findes ingen E-bøger i den valgte kategori.</h4></div>';
    endif;
    //$cases = ob_get_clean(); // Save case markup in output buffer
    $news = ob_get_clean(); // Save person grid markup in output buffer

        $send = array(
            'news' => $news
    );


    wp_send_json($send); // Send json

    wp_die();
}
