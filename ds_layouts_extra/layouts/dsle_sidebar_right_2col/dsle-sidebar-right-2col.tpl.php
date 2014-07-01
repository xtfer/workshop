<?php

/**
 * @file
 * Template with a right sidebar and a main column.
 */
if ($main_left && $main_right) {
  $classes .= ' group-main-two-cols';
}
elseif ($main_left) {
  $classes .= ' group-main-one-col';
}
elseif ($main_right) {
  $classes .= ' group-main-one-col';
}
?>
<<?php print $layout_wrapper; print $layout_attributes; ?> class="dsle-sidebar-right-2col <?php print $classes;?> clearfix">

  <?php if (isset($title_suffix['contextual_links'])): ?>
  <?php print render($title_suffix['contextual_links']); ?>
  <?php endif; ?>

  <<?php print $header_wrapper; ?> class="group-header<?php print $header_classes; ?>">
    <?php print $header; ?>
  </<?php print $header_wrapper; ?>>

  <div class="group-main">

    <<?php print $main_header_wrapper; ?> class="group-main-header<?php print $main_header_classes; ?>">
      <?php print $main_header; ?>
    </<?php print $main_header_wrapper; ?>>

    <?php if ($main_left): ?>
      <<?php print $main_left_wrapper; ?> class="group-main-left<?php print $main_left_classes; ?>">
        <?php print $main_left; ?>
      </<?php print $main_left_wrapper; ?>>
    <?php endif; ?>

    <?php if ($main_right): ?>
      <<?php print $main_right_wrapper; ?> class="group-main-right<?php print $main_right_classes; ?>">
        <?php print $main_right; ?>
      </<?php print $main_right_wrapper; ?>>
    <?php endif; ?>

    <<?php print $main_footer_wrapper; ?> class="group-main-footer<?php print $main_footer_classes; ?>">
      <?php print $main_footer; ?>
    </<?php print $main_footer_wrapper; ?>>

  </div>

  <<?php print $right_wrapper; ?> class="group-right<?php print $right_classes; ?>">
    <?php print $right; ?>
  </<?php print $right_wrapper ?>>

  <<?php print $footer_wrapper; ?> class="group-footer<?php print $footer_classes; ?>">
    <?php print $footer; ?>
  </<?php print $footer_wrapper; ?>>

</<?php print $layout_wrapper ?>>

<?php if (!empty($drupal_render_children)): ?>
  <?php print $drupal_render_children ?>
<?php endif; ?>
