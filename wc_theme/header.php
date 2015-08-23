<!DOCTYPE html>
<html lang="sv">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header id="masthead">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<?php bloginfo( 'name' ); ?>

					<nav id="primary-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
					</nav>

					<div class="search-box">
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>
		</div>
	</header><!-- end #masthead -->
