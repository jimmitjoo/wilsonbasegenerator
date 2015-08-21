<?php
global $wilson_settings;
if ($wilson_settings['left_sidebar'] != 0) : ?>
    <div class="col-md-<?php echo $wilson_settings['left_sidebar_width']; ?> wbt-left">
        <?php dynamic_sidebar('Left Sidebar'); ?>
    </div>
<?php endif; ?>