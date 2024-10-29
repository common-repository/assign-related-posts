<?php
/*
Plugin Name: Assign Related Posts
Plugin URI: https://profiles.wordpress.org/arshdeveloper
Description: Assigns related posts to specific post.
Author: Arshad Hussain
Author URI: https://arshadportfolio.wordpress.com/
Text Domain: assign-related-posts
Version: 1.0.1
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// define some constant for plugin
define('ARP_PAGES_DIR', plugin_dir_path(__FILE__).'pages/');
require(ARP_PAGES_DIR.'/rps-functions.php');
include(ARP_PAGES_DIR.'frontend-show.php');

// add menu for plugin
add_action( 'admin_menu', 'arp_option_setting' );
function arp_option_setting() {
	add_options_page( 'Assign Related Post', 'Assign Related Post', 'manage_options', 'rps_settings', 'assign_related_post');
	
	// This is for saving value to DB
	register_setting( 'rps_settings', 'postlists' );
}

// Callback function from above code
function assign_related_post(){
	add_settings_section( 'rps_settings_page', __( 'General', 'rps' ), '__return_false', 'rps_settings' );
	add_settings_field( 'rps_select_post_types', __( 'Choose post type', 'rps' ), 'rps_select_post_types_settings', 'rps_settings', 'rps_settings_page' );
?>
	<div class="wrap" style="min-width:1000px">
		<form action="options.php" method="post">
			<?php
				settings_fields( 'rps_settings' );
				global $wpdb;
				submit_button();
			?>
			<div class="tabs"><?php do_settings_sections( 'rps_settings' ); ?></div>
			<?php submit_button(); ?>
		</form>
	</div>
<?php
}

add_action( 'add_meta_boxes', 'add_arp_metaboxes' );
function add_arp_metaboxes() {
	$post_types = get_option( 'postlists' );
	if(!empty($post_types)){ 
		foreach( $post_types as $post_type ) {
			add_meta_box('arp_metabox', 'Assign Related Post', 'arp_metabox', $post_type, 'normal', 'default');
		}
	}
}

function arp_js_css_files() {
	wp_enqueue_style( 'arp_css1', plugins_url('css/chosen.css',__FILE__ ));
	wp_enqueue_script( 'arp_js2', plugins_url('js/chosen.jquery.js',__FILE__ ));
	
	// Enable shortcodes in text widgets
	add_filter('widget_text','do_shortcode');
}
add_action( 'admin_init','arp_js_css_files');

function arp_js_css_files_frontend() {
	wp_enqueue_style( 'arp_css_frontend', plugins_url('css/arp-frontend.css',__FILE__ ));
}
add_action( 'init','arp_js_css_files_frontend');


function arp_metabox() {
	global $post;

	$post_type = get_post_type( $post->ID );
	$args = array(
				'posts_per_page' => -1,
				'exclude'		 => $post->ID,
				'post_type'		 => $post_type
			);

	$myposts = get_posts( $args );

	// Nonce name needed to verify where the data originated
	wp_nonce_field( 'my_arpmeta_noncename', 'arpmeta_noncename' );
	?>
	
	<select data-placeholder="Choose post..." class="chosen-select" multiple style="width:1000px;" tabindex="4" name="arp_title[]">
        <option value=""></option>
		<?php
			$savedARP = get_post_meta( $post->ID, 'arp_related_posts', true );
			$explodeARP = explode(',', $savedARP);
			
		?>
		<?php foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
		<option value="<?php echo $post->ID; ?>" <?php if(in_array($post->ID, $explodeARP)) { echo "selected"; } ?>><?php echo $post->post_title; ?></option>
		<?php endforeach; wp_reset_postdata(); ?>
    </select>
	
	<script type="text/javascript">
	var config = {
	  '.chosen-select'           : {}
	}
	for (var selector in config) {
	  jQuery(selector).chosen(config[selector]);
	}
	</script>

	<?php
}

// Save related post to DB
add_action( 'save_post', 'arp_save_related_post_now' );
function arp_save_related_post_now( $post_id ) {
	$relatedPostArr = isset( $_POST['arp_title'] ) ? (array) $_POST['arp_title'] : array();
	
	$imp_post = implode(',', $relatedPostArr);
	$imp_post = sanitize_text_field($imp_post);

	// Set if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

	// if our nonce isn't there, or we can't verify it, return
	if( !isset( $_POST['arpmeta_noncename'] ) || !wp_verify_nonce( $_POST['arpmeta_noncename'], 'my_arpmeta_noncename' ) ) return;

	// if our current user can't edit this post, return
	if( !current_user_can( 'edit_post' ) ) return;
	
	// Make sure your data is set before trying to save it
	if( isset( $imp_post ) ){
		update_post_meta( $post_id, 'arp_related_posts', $imp_post );
	}
}
?>