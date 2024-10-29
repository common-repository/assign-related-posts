<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function rps_select_post_types_settings(){
	
	$args = array(
	   'public'   => true,
	   '_builtin' => true
	);

	$post_types = get_post_types( array( 'public'=>true, 'show_ui'=>true ), 'objects' );

	foreach ( $post_types as $type => $obj ) {
		
		$savedpost = get_option( 'postlists' );
		
		$exclude = array( 'attachment');
		
        if( TRUE === in_array( $type, $exclude ) )
        continue;
	
		if(!empty($savedpost)){
			if ( in_array( $type, $savedpost ) ) {
				$status = 'checked';
			} else {
				$status = '';
			}
		}
		
	?>
		<input type="checkbox" name="postlists[]" value="<?php echo $type; ?>" <?php echo $status; ?> /><?php echo $obj->label.'<br/>'; ?>
	<?php }
}