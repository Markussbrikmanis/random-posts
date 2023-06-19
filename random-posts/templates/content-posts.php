<?php 
/**
 * The template for displaying posts content
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

$lazyloadImg =  (!empty(get_option( 'rp_lazy_load' ))) ? intval(get_option( 'rp_lazy_load' )) : 3;
$lazyloadOn =  (!empty(get_option( 'rp_turnon_lazy_load' ))) ? filter_var(get_option( 'rp_turnon_lazy_load' ), FILTER_VALIDATE_BOOLEAN) : "false";

?>

<div class="random-posts-item col-md-4 p-2 post-<?php echo $post->getID(); ?>">
	<div class="random-post-image-container">
		<?php if(($counter + 1) > $lazyloadImg && $lazyloadOn) :?>
			<img class="random-post-post-img img-fluid lazyload" data-src="<?php echo esc_html($post->getImg());?>" alt="<?php echo esc_html($post->getTitle());?>">
		<?php else: ?>
			<img class="random-post-post-img img-fluid" src="<?php echo esc_html($post->getImg());?>" alt="<?php echo esc_html($post->getTitle());?>">
		<?php endif; ?>
	</div>
	<div class="random-post-content-container">
		<?php do_action("rp_posts_loop_before_title"); ?>
		<h2 class="random-post-post-title pt-2"><?php echo esc_html($post->getTitle());?></h2>
		<?php do_action("rp_posts_loop_after_title"); ?>
		<p class="random-post-post-content"><?php echo esc_html($post->getBody());?></p>
		<?php do_action("rp_posts_loop_after_content"); ?>
	</div>
</div>