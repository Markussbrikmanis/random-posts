<?php
/**
 * Random post fetcher from API
 *
 * @package    Random_Posts
 * @subpackage Random_Posts/includes
 * @author     Markuss Brikmanis <markussbrikmanis@gmail.com>
 */

if(!class_exists('Random_Posts_API')){
	include 'class-random-posts-post.php';

	class Random_Posts_API {
		private $URL = "https://jsonplaceholder.typicode.com/posts";
		private $cleanPosts = array();
		private $allPosts = array();
		private $args = array();
		private $transient_key = 'random_posts_all_posts';

		public function __construct($args)
		{
			$this->args = $args;
			if(false === ($serialized_posts = get_transient($this->transient_key))){
				$this->fetchPosts();
			}else{
				$this->allPosts = unserialize($serialized_posts);
			}

			$this->sort();
			$this->remove();
			$this->createPostObjects();
		}

		/**
		 * Get All posts from API
		 */
		private function fetchPosts(){
			if(isset($this->URL)){
				$response = wp_remote_get($this->URL);

				if (is_wp_error($response)) {
					$error_message = $response->get_error_message();
					error_log(RANDOM_POSTS_NAME . 'Error: ' . $error_message);
				}
				
				$response_code = wp_remote_retrieve_response_code($response);
				if ($response_code !== 200) {
					$error_message = 'HTTP request failed with response code: ' . $response_code;
					error_log(RANDOM_POSTS_NAME . ' Error: ' . $error_message);		
				}
				
				$response_body = wp_remote_retrieve_body($response);
				$this->allPosts = json_decode($response_body, true);
				
				if (json_last_error() !== JSON_ERROR_NONE) {
					$error_message = 'JSON decoding error: ' . json_last_error_msg();
					error_log(RANDOM_POSTS_NAME . ' Error: ' . $error_message);	
				}

				set_transient($this->transient_key, serialize($this->allPosts), (!empty(get_option( 'rp_cache_expiry_time' ))) ? (60 * intval(get_option( 'rp_cache_expiry_time' ))) : (60 * 10));
			}
		}

		/**
		 * Sorting function to sort posts - ASC, DESC
		 */
		private function sort(){
			if(isset($this->args['order']) && isset($this->allPosts)){
				if($this->args['order'] === "desc"){
					usort($this->allPosts, function($a, $b) {
						return $b['id'] - $a['id'];
					});
				}else {
					usort($this->allPosts, function($a, $b) {
						return $a['id'] - $b['id'];
					});
				}
			}
		}

		/**
		 * Removing function that delete not needed posts based on count
		 */
		private function remove(){
			if(isset($this->args['count']) && isset($this->allPosts)){
				$elementsToRemove = count($this->allPosts) - intval($this->args['count']);
				
				if ($elementsToRemove > 0) {
					array_splice($this->allPosts, intval($this->args['count']), $elementsToRemove);
				}
			}
		}

		/**
		 * Create posts objects
		 */
		private function createPostObjects() {
			if(isset($this->allPosts)){
				foreach($this->allPosts as $post){
					array_push($this->cleanPosts, new Random_Posts_Post($post["userId"], $post["id"], $post["title"], $post["body"]));
				}
			}
		}

		public function getPosts(){
			return $this->cleanPosts;
		}
	}
}
