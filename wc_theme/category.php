<?php get_header(); ?>

<div class="main-content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<?php if ( have_posts() ) : ?>

				<header class="archive-header">
					<h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'wc_theme' ), single_cat_title( '', false ) ); ?></h1>

					<?php
						// Show an optional term description.
						$term_description = term_description();
						if ( ! empty( $term_description ) ) :
							printf( '<div class="taxonomy-description">%s</div>', $term_description );
						endif;
					?>
				</header><!-- .archive-header -->

				<?php
						// Start the Loop.
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
