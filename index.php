<?php add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );function enqueue_parent_styles() {   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );}
/*display the welcome message in the admin header. */
add_action('in_admin_header', 'bruce_welcome_message');
function bruce_welcome_message(){
/*get the current user's data*/
$user = wp_get_current_user();
$date = date('l jS F Y'); 
	
/**
 * WCAG 2.0 Attributes for Dropdown Menus
 *
 * Adjustments to menu attributes tot support WCAG 2.0 recommendations
 * for flyout and dropdown menus.
 *
 * @ref https://www.w3.org/WAI/tutorials/menus/flyout/
 */
function wcag_nav_menu_link_attributes( $atts, $item, $args, $depth ) {

    // Add [aria-haspopup] and [aria-expanded] to menu items that have children
    $item_has_children = in_array( 'menu-item-has-children', $item->classes );
    if ( $item_has_children ) {
        $atts['aria-haspopup'] = "true";
        $atts['aria-expanded'] = "false";
    }

    return $atts;
}
add_filter( 'nav_menu_link_attributes', 'wcag_nav_menu_link_attributes', 10, 4 );	
	

/*Display the message for the user*/
echo "<h1><strong>Hola!, {$user->display_name}. How are you today?</strong></h1> ";
echo "Today's Date is $date";

}




remove_action('wp_head', 'wp_generator');

add_shortcode('mytwitter', 'prowp_twitter');

function prowp_twitter(){
	return '<a href="http://www.twitter.com/webguync">@webguync</a>';
}

function my_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
	}
	add_action('login_head', 'my_custom_login');

function my_login_logo_url() {
return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
return 'Inspired-Musings.com';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function login_checked_remember_me() {
add_filter( 'login_footer', 'rememberme_checked' );
}
add_action( 'init', 'login_checked_remember_me' );

function rememberme_checked() {
echo "<script>document.getElementById('rememberme').checked = true;</script>";
}

function posts_test(){
	register_post_type('event',array(
	'public' => true,
		'labels'=> array(
		'name' => 'Events',
		'add_new_item' => 'Add New Event',
		'all_items' => 'All Events'	,
		'singular_name'=>'Event'	
		),
		'menu_icon'=> 'dashicons-calendar'
	));
}

add_action('init','posts_test');

add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );
 
function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
$user_id = get_current_user_id();
$current_user = wp_get_current_user();
$profile_url = get_edit_profile_url( $user_id );
 
if ( 0 != $user_id ) {
/* Add the "My Account" menu */
$avatar = get_avatar( $user_id, 28 );
$howdy = sprintf( __('Welcome, %1$s'), $current_user->display_name );
$class = empty( $avatar ) ? '' : 'with-avatar';
 
$wp_admin_bar->add_menu( array(
'id' => 'my-account',
'parent' => 'top-secondary',
'title' => $howdy . $avatar,
'href' => $profile_url,
'meta' => array(
'class' => $class,
),
) );
 
}
}
