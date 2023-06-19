<?php
/**
 * Plugin shortcode functionality
 *
 * @package    Random_Posts
 * @subpackage Random_Posts/includes
 * @author     Markuss Brikmanis <markussbrikmanis@gmail.com>
 */

if(!class_exists('Random_Posts_Shortcodes')){
	class Random_Posts_Shortcodes {
		private $plugin_name;
		private $version;

		public function __construct($plugin_name, $version)
		{
			$this->plugin_name = $plugin_name;
			$this->version = $version;

			$this->setup_hooks();
		}

		/**
		 * Setup action/filter hooks
		 */
		public function setup_hooks(){
			add_action ('wp_enqueue_scripts', array($this, 'register_style'));
			add_action ('wp_enqueue_scripts', array($this, 'register_scripts'));
		}

		

		/**
		 * Register style
		 */
		public function register_style(){
			wp_register_style( $this->plugin_name.'-shortcodes', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
			wp_register_style( $this->plugin_name.'-custom-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap' );
		}

		/**
		 * Register scripts
		 */
		public function register_scripts(){
			wp_register_script( $this->plugin_name.'-lazyload', 'https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.8.3/dist/lazyload.min.js');
		}

		/**
		 * Shortcode for random posts
		 */
		public function random_posts($atts){
			include 'class-random-posts-API.php';
			wp_enqueue_style( $this->plugin_name.'-shortcodes');
			wp_enqueue_style( $this->plugin_name.'-custom-fonts');
			wp_enqueue_script( $this->plugin_name.'-lazyload');

			$atts = shortcode_atts( 
				array(
					'count' => (!empty(get_option( 'rp_default_posts_value' ))) ? get_option( 'rp_default_posts_value' ) : get_option('posts_per_page'),
					'order' => (!empty(get_option( 'rp_default_posts_ordering' ))) ? get_option( 'rp_default_posts_ordering' ) : "asc"
				), 
				$atts, 
				'random_posts' 
			);

			$atts["count"] = preg_replace('/[^0-9]/', '', $atts["count"]);

			$atts["order"] = preg_replace('/[^a-zA-Z]/', '', $atts["order"]);

			$API = new Random_Posts_API($atts); //getposts
			$posts = $API->getPosts();

			ob_start();
			?>
			<div class="random-posts container p-0">
				<div class="random-posts-wrap d-flex flex-wrap p-0">
					<?php 
						foreach ($posts as $counter => $post) {
							include RANDOM_POSTS_BASE_DIR . 'templates/content-posts.php';
						}
					?>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}
	}
}
