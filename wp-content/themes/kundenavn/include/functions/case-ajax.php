<?php
add_action('wp_ajax_cases_ajax', 'cases_ajax'); // Change names according to your form
add_action('wp_ajax_nopriv_cases_ajax', 'cases_ajax'); // Change names according to your form
/*-------------- Function to execute -------------*/
function cases_ajax(){
    // check for nonce security
    $nonce = $_POST['security'];
    if ( ! wp_verify_nonce( $nonce, 'cases-ajax-nonce' ) ){
        die;
    }

    $args = array(
        'orderby' => 'ID',
        'order'  => 'ASC',
        'post_type' => array('cases', 'news', 'post'),
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
                ?>
                    <a class="mini-card" href="<?php echo $permalink?>">
                        <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>" />
                        <div class="mini-card-inner">
                            <span>- Artikler</span>
                            <h4><?php echo get_the_title(); ?></h4>
                            <span class="reading-time">
                                <?php echo $reading_time;?>
                            </span>
                            <div class="author-row">
                                <img class="avatar" src="<?php echo esc_url($writer_img['url']); ?>" alt="<?php echo esc_attr($writer_img['alt']); ?>" />
                                <span class="author-name"><?php echo $writer;?></span>
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
        echo '<div class="grid-container"><h4 class="no-matches">Der findes ingen cases i den valgte kategori.</h4></div>';
    endif;
    //$cases = ob_get_clean(); // Save case markup in output buffer
    $news = ob_get_clean(); // Save person grid markup in output buffer

        $send = array(
            'news' => $news
    );


    wp_send_json($send); // Send json

    wp_die();
}
