<?php get_header(); ?>

<div class="main-content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();

						// Include the page content template.
						get_template_part( 'content', 'page' );

						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
					endwhile;
				?>

			</div> <!-- end .col-sm-12 -->
		</div> <!-- end .row -->
	</div> <!-- end .container -->
</div> <!-- end .main-content -->

<?php
get_footer();
