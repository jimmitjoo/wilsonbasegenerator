<div class="wbt-footer">
    <?php
    global $wilson_settings;
    if ($wilson_settings['author_credits'] != 0) : ?>
        <div class="row wbt-author-credits">
            <p class="text-center"><a href="<?php global $developer_uri;
                echo esc_url($developer_uri); ?>">Developed <?php _e('by', 'wbt') ?> Wilson Creative</a></p>
        </div>
    <?php endif; ?>

    <?php get_template_part('template-part', 'footernav'); ?>
</div>

</div>
<!-- end main container -->

<?php wp_footer(); ?>
</body>
</html>