<?php get_header(); ?>

<div class="main-content">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<?php if ( have_posts() ) : ?>

				<header class="archive-header">
					<h1 class="archive-title">
						<?php

							the_post();

							printf( __( 'All posts by %s', 'wc_theme' ), get_the_author() );
						?>
					</h1>
					<?php if ( get_the_author_meta( 'description' ) ) : ?>
					<div class="author-description"><?php the_author_meta( 'description' ); ?></div>
					<?php endif; ?>
				</header><!-- .archive-header -->

				<?php

						rewind_posts();

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
