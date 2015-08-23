<?php get_header(); ?>

<div class="main-content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<?php if ( have_posts() ) : ?>

				<header class="page-header">
					<h1 class="page-title">
						<?php
							if ( is_day() ) :
								printf( __( 'Daily Archives: %s', 'wc_theme' ), get_the_date() );

							elseif ( is_month() ) :
								printf( __( 'Monthly Archives: %s', 'wc_theme' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'wc_theme' ) ) );

							elseif ( is_year() ) :
								printf( __( 'Yearly Archives: %s', 'wc_theme' ), get_the_date( _x( 'Y', 'yearly archives date format', 'wc_theme' ) ) );

							else :
								_e( 'Archives', 'wc_theme' );

							endif;
						?>
					</h1>
				</header><!-- .page-header -->

				<?php

						while ( have_posts() ) : the_post();
							get_template_part( 'content', get_post_format() );

						endwhile;

						wc_theme_paging_nav();

					else :
						get_template_part( 'content', 'none' );

					endif;
				?>

			</div> <!-- end .col-sm-12 -->
		</div> <!-- end .row -->
	</div> <!-- end .container -->
</div> <!-- end .main-content -->

<?php
get_footer();
