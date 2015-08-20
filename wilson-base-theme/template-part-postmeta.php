<?php global $wilson_settings; ?>
<?php if ($wilson_settings['show_postmeta'] != 0) : ?>
    <p class="text-right">
        <span class="glyphicon glyphicon-user"></span> <?php the_author_posts_link(); ?>
        <span class="glyphicon glyphicon-time"></span> <?php the_time('F jS, Y'); ?>
        <span class="glyphicon glyphicon-edit"></span> <?php edit_post_link(__('Edit', 'wbt')); ?>
    </p>
    <p class="text-right"><span class="glyphicon glyphicon-circle-arrow-right"></span> <?php _e('Posted In', 'wbt'); ?>
        : <?php the_category(', '); ?></p>
    <?php if (has_tag()) : ?>
        <p class="text-right"><span class="glyphicon glyphicon-tags"></span>
            <?php the_tags(); ?>
        </p>
    <?php endif; ?>
<?php endif; ?>