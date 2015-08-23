<?php
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'wc_theme_setup' ) ) :

// Theme setup

function wc_theme_setup() {

	load_theme_textdomain( 'wc_theme', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'wc_theme-full-width', 1038, 576, true );

	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'wc_theme' ),
		'secondary' => __( 'Secondary menu in left sidebar', 'wc_theme' ),
	) );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );

}
endif; // wc_theme_setup
add_action( 'after_setup_theme', 'wc_theme_setup' );

// End Theme setup

// Init widgets

function wc_theme_widgets_init() {
	require get_template_directory() . '/inc/widgets.php';
	register_widget( 'wc_theme_widget' );

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'wc_theme' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar.', 'wc_theme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'wc_theme_widgets_init' );

// End Init widgets

// Load Scripts & CSS

function wc_theme_assets() {
	wp_enqueue_style( 'buildCss', get_template_directory_uri() . '/build/build.min.css' );
	wp_enqueue_script( 'buildJs', get_template_directory_uri() . '/build/build.min.js' );
}
add_action( 'wp_enqueue_scripts', 'wc_theme_assets' );



if ( ! function_exists( 'wc_theme_the_attached_image' ) ) :

function wc_theme_the_attached_image() {
	$post                = get_post();

	$attachment_size     = apply_filters( 'wc_theme_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'wc_theme_list_authors' ) ) :

function wc_theme_list_authors() {
	$contributor_ids = get_users( array(
		'fields'  => 'ID',
		'orderby' => 'post_count',
		'order'   => 'DESC',
		'who'     => 'authors',
	) );

	foreach ( $contributor_ids as $contributor_id ) :
		$post_count = count_user_posts( $contributor_id );

		if ( ! $post_count ) {
			continue;
		}
	?>

	<div class="contributor">
		<div class="contributor-info">
			<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
			<div class="contributor-summary">
				<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
				<p class="contributor-bio">
					<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
				</p>
				<a class="button contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
					<?php printf( _n( '%d Article', '%d Articles', $post_count, 'wc_theme' ), $post_count ); ?>
				</a>
			</div><!-- .contributor-summary -->
		</div><!-- .contributor-info -->
	</div><!-- .contributor -->

	<?php
	endforeach;
}
endif;

function wc_theme_post_classes( $classes ) {
	if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'wc_theme_post_classes' );

function wc_theme_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'wc_theme' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'wc_theme_wp_title', 10, 2 );


require get_template_directory() . '/inc/template-tags.php';


//  Restyle wp-login

function remove_lostpassword_text ( $text ) {
     if ($text == 'Glömt lösenordet?'){$text = '';}
        return $text;
     }
add_filter( 'gettext', 'remove_lostpassword_text' );


// Change login logo url to current site
function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Your Site Name and Info';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

// Remove username hint in errors
add_filter('login_errors',create_function('$a', "return 'Användarnamnet eller lösenordet är inte korrekt.';"));
