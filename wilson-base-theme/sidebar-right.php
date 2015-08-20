<?php
global $wilson_settings;
if ($wilson_settings['right_sidebar'] != 0) : ?>
    <div class="col-md-<?php echo $wilson_settings['right_sidebar_width']; ?> wbt-right">
        <?php //get the right sidebar
        dynamic_sidebar('Right Sidebar'); ?>
    </div>
<?php endif; ?>