<?php

////////////////////////////////////////////////////////////////////
// Theme Information
////////////////////////////////////////////////////////////////////

$themename = "Wilson Base Theme";
$developer_uri = "http://wilsoncreative.se";
$shortname = "wbt";
$version = '1.71';
load_theme_textdomain('wbt', get_template_directory() . '/languages');

// include Theme-options.php for Admin Theme settings
include 'theme-options.php';


// Enqueue Styles
function wbt_theme_stylesheets()
{
    wp_register_style('build.css', get_template_directory_uri() . '/build/css/style.css', array(), '1', 'all');
    wp_enqueue_style('build.css');
    wp_enqueue_style('stylesheet', get_stylesheet_uri(), array(), '1', 'all');
}

add_action('wp_enqueue_scripts', 'wbt_theme_stylesheets');

//Editor Style
add_editor_style('css/editor-style.css');

// Register builded js
function wbt_theme_js()
{
    global $version;
    wp_enqueue_script('theme-js', get_template_directory_uri() . '/build/js/build.js', array(), $version, true);
}

add_action('wp_enqueue_scripts', 'wbt_theme_js');

// Add Title Tag Support with Regular Title Tag injection Fall back.
function wbt_title_tag()
{
    add_theme_support('title-tag');
}

add_action('after_setup_theme', 'wbt_title_tag');

if (!function_exists('_wp_render_title_tag')) {

    function wbt_render_title()
    {
        ?>
        <title><?php wp_title('|', true, 'right'); ?></title>
        <?php
    }

    add_action('wp_head', 'wbt_render_title');

}

// Register Custom Navigation Walker include custom menu widget to use walkerclass
require_once('lib/wp_bootstrap_navwalker.php');
require_once('lib/bootstrap-custom-menu-widget.php');


// Register Menus
register_nav_menus(
    array(
        'main_menu' => 'Main Menu',
        'footer_menu' => 'Footer Menu'
    )
);

// Register the Sidebar(s)
register_sidebar(
    array(
        'name' => 'Right Sidebar',
        'id' => 'right-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

register_sidebar(
    array(
        'name' => 'Left Sidebar',
        'id' => 'left-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

// Register hook and action to set Main content area col-md- width based on sidebar declarations
add_action('wbt_main_content_width_hook', 'wbt_main_content_width_columns');

function wbt_main_content_width_columns()
{

    global $wilson_settings;

    $columns = '12';

    if ($wilson_settings['right_sidebar'] != 0) {
        $columns = $columns - $wilson_settings['right_sidebar_width'];
    }

    if ($wilson_settings['left_sidebar'] != 0) {
        $columns = $columns - $wilson_settings['left_sidebar_width'];
    }

    echo $columns;
}

function wbt_main_content_width()
{
    do_action('wbt_main_content_width_hook');
}

// Add support for a featured image and the size
add_theme_support('post-thumbnails');
set_post_thumbnail_size(300, 300, true);


// Adds RSS feed links to for posts and comments.
add_theme_support('automatic-feed-links');


// Set Content Width
if (!isset($content_width)) $content_width = 800;

?>