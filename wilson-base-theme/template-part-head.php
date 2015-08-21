<?php global $wilson_settings; ?>

<div class="container wbt-container">

<?php if ($wilson_settings['show_header'] != 0) : ?>

    <div class="row wbt-header">


        <div class="col-md-8 wbt-header-text">
                <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
                <h4><?php bloginfo( 'description' ); ?></h4>
        </div>

    </div>

<?php endif; ?>