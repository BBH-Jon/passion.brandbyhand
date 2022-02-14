<?php
    $totalcols  = intval(get_sub_field('cols'));
    if ($totalcols > 4 && $totalcols <= 8) { $totalcols = 2; } elseif($totalcols > 8) { $totalcols = 3; }
    $cols       = intval(get_sub_field('cols'));
    $size       = get_sub_field('size');

    $bgselect   = get_sub_field('colors') ?: 'unset';
    $background = get_sub_field('background') ?: 'unset';
    $bgcolor    = get_sub_field('custom_color') ?: 'unset';

    if ($background && $bgselect == 'background' || $bgcolor ) {
        $withbg = "withbg"; } else { $withbg = "";
    }
    if ($background && $bgselect == 'background')   {
        $section_background = 'style="background-image: url('.$background['url'].');"';
    } else{
        $section_background = 'style="background-color:'.$bgcolor.';"';
    }

    $text       = get_sub_field('text');
    $mg         = get_sub_field('mg');
    $paddings    = get_sub_field('padding');
    if ($paddings === 'high') {
        $padding = 'highpadding';
    } elseif($paddings === 'low') {
        $padding = 'lowpadding';
    } else {
        $padding = '';
    }
    $rounded    = get_sub_field('rounded');

    $containerClass = $size == 'full' ? 'container-fluid' : 'grid-container';

    if (! function_exists('renderVariableContent')) {
        function renderVariableContent($group, $cols, $counter, $totalcols){
            $bg = isset($group['color']) ? 'style="background-color: '.$group['color'].';"' : null;
            if($group['color']) { $singlebg = "bg"; } else { $singlebg = ""; }

            if($cols <= 1) {
                $large = 12;
                $medium = 12;
            }
            elseif($cols <= 4) {
              $large = 12 / $totalcols;
              $medium = 6;
            }
            elseif($cols == 5) {
              if ($counter == 0) {
                $large = 8;
                $medium = 12;
              } else {
                $large = 4;
                $medium = 12;
              }
            }
            elseif($cols == 6) {
              if ($counter == 1) {
                $large = 8;
                $medium = 12;
              } else {
                $large = 4;
                $medium = 12;
              }
            }
            elseif($cols == 7) {
              if ($counter == 1) {
                $large = 9;
                $medium = 12;
              } else {
                $large = 3;
                $medium = 12;
              }
            }
            elseif($cols == 8) {
              if ($counter == 0) {
                $large = 9;
                $medium = 12;
              } else {
                $large = 3;
                $medium = 12;
              }
            }
            elseif($cols == 9) {
              if ($counter == 0) {
                $large = 6;
                $medium = 12;
              } else {
                $large = 3;
                $medium = 6;
              }
            }
            elseif($cols == 10) {
              if ($counter == 2) {
                $large = 6;
                $medium = 12;
              } else {
                $large = 3;
                $medium = 6;
              }
            }
            elseif($cols == 11) {
              if ($counter == 1) {
                $large = 6;
              } else {
                $large = 3;
              }
              $medium = 12;
            }
            ?>
            <div class="col-lg-<?php echo $large; ?> col-md-<?php echo $medium; ?> col-sm-12" >
              <div class="single <?php echo $singlebg; ?>" <?php echo $bg ?>>
                <?php echo $group['text'] ?>
              </div>
            </div>
            <?php
        }
    }
?>

<div class="flexible-inner-section bbh-inner-section variable-content <?php echo $withbg; ?> <?php if($mg == 'no') { echo 'variable-mg'; } ?> <?php echo $padding; ?> <?php if($rounded === 'Yes'): echo "rounded"; endif; ?>" <?php echo $section_background ?> >
    <div class="outer-wrap <?php echo $containerClass ?>">
        <h1>HEY ITS WORKING!</h1>
        <p>its still working yay!</p>
      <div class="row">
        <?php if($text): ?>
        <div class="top-text">
            <div class="col-sm-12">
              <?php echo $text ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="inner-wrap cols-<?php echo $cols?>">
            <?php
            $counter = 0;
            //For each col selected, we render the text from a col, called c1, c2, c3, c4
            for ( $i = 1; $i <= $totalcols; $i++ ) {
                $group = get_sub_field('c' . $i);
                renderVariableContent($group, $cols, $counter, $totalcols);
                $counter++;
            }
            ?>
        </div>
      </div>
    </div>
</div>
