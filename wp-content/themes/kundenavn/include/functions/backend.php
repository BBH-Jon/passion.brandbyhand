<?php
/*======================================
=            Wysiwyg colors            =
======================================*/
// Recommended Colors for both MCE and ACF Color picker
function bbh_colors($type) {
    $bbh_customer_colors = array(
    '"#000000"' => '"Black"',
    '"#fefefe"' => '"White"',
    '"#D9D8D7"' => '"Gray"',
    '"#595047"' => '"Brown"',
    '"#403732"' => '"Dark Brown"',
    '"#BFB0A3"' => '"Sand"',
    '"#AF3E3E"' => '"Red"',
    '"#5C8E7D"' => '"Green"'
    );
    $colors = array();
    $colorpicker = array();

    foreach ($bbh_customer_colors as $color => $value) {
        $colors[] = str_replace("#", "", $color);
        $colors[] = $value;
        $colorpicker[] = str_replace('"', "'", $color);
    }

    $custom_colours = implode(', ', $colors);
    $custom_colourpicker = implode(', ', $colorpicker);

    if ($type === 'colorpicker') {
        return $custom_colourpicker;
    } else {
        return $custom_colours;
    }
}

function bbh_wysiwyg_colors($init) {

    $bbh_colors = bbh_colors('mce');

  // build colour grid default+custom colors
  $init['textcolor_map'] = '['.$bbh_colors.']';
  // change the number of rows in the grid if the number of colors changes
  $init['textcolor_rows'] = 3;
  $init['textcolor_cols'] = 3;

  return $init;
}
add_filter('tiny_mce_before_init', 'bbh_wysiwyg_colors');


//acf color picker
function my_acf_collor_pallete_script() {
    $bbh_colors = bbh_colors('colorpicker');
    ?>
    <script type="text/javascript">
    (function($){
        acf.add_filter('color_picker_args', function( args, $field ){
            // do something to args
            args.palettes = [<?php echo $bbh_colors; ?>];
            // return
            return args;
        });
    })(jQuery);
    </script>
    <?php
}

add_action('acf/input/admin_footer', 'my_acf_collor_pallete_script');

function my_acf_collor_pallete_css() {
    ?>
    <style>
        .acf-color_picker .wp-picker-input-wrap,
        .acf-color_picker .iris-picker .iris-slider,
        .acf-color_picker .iris-picker .iris-square{
            display:none !important;
        }
    </style>
    <?php
}

add_action('acf/input/admin_head', 'my_acf_collor_pallete_css');
