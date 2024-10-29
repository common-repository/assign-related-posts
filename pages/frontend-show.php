<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	add_shortcode('assign-related-posts', 'arp_shortcode');
	function arp_shortcode($atts){
		ob_start();
		extract(shortcode_atts(array(
			'title' => 'Related Posts',
			'size' => 'thumbnail'
		), $atts));
	
		global $post;
		$savedPostIds = get_post_meta( $post->ID, 'arp_related_posts', true );
		if($savedPostIds != '') :
		$relatedPostIds = explode(',', $savedPostIds);
		?>
		<div class="arp-post-single-container">
			<div class="top-heading"><h2><?php echo $title; ?></h2></div>
			<ul>
				<?php
					foreach($relatedPostIds as $postId) {
					$postInfo = get_post($postId);
					setup_postdata($postInfo);
				?>
				<li>
					<a href="<?php echo get_permalink( $postId ); ?>">
						<?php echo get_the_post_thumbnail( $postId, $size); ?>
					</a>
					<div class="arp_title"><a href="<?php echo get_permalink( $postId ); ?>"><?php echo $postInfo->post_title; ?></a></div>
				</li>
				<?php } ?>
			</ul>
		</div>
		<?php endif; return ob_get_clean();?>
<?php } ?>