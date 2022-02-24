<?php
  $wysiwyg = get_sub_field('wysiwyg');
  $search_recipe = get_sub_field('search_recipe');
 ?>

 <section class="flexible-inner-section bbh-inner-section c3-all-before-after">
     <div class="grid-container">
         <div class="related-recipe-headline">
             <div class="textbox">
                 <h3><?php echo $wysiwyg ?></h3>
             </div>
             <div class="search-box">
                 <?php echo $search_recipe;?>
             </div>
         </div>
         <div class="flex-wrap">

             <form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
<div class="grid-container">
    <div class="field-wrap">
        <?php
            $taxonomies = get_object_taxonomies('post', 'post');
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
<input type="hidden" name="security" id="filter-ajax-nonce" value="<?php echo wp_create_nonce( 'filter-ajax-nonce' ) ?>"/><!-- "id'et" går igen i wp_create_nonce og igen i din ajax fil -->
<!-- The below input value must be called the same as your ajax function. -->
<input type="hidden" name="action" value="filter_ajax">
</form>

<div id="response">Dette indhold udskiftes når dit AJAX kald er komplet - evt. loop gennem din post type og vis alle posts her.</div>


         </div>
     </div>
 </section>
