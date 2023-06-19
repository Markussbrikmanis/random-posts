<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://markussbrikmanis.lv
 * @since      1.0.0
 *
 * @package    Random_Posts
 * @subpackage Random_Posts/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Random_Posts
 * @subpackage Random_Posts/admin
 * @author     Markuss Brikmanis <markussbrikmanis@gmail.com>
 */
class Random_Posts_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Random_Posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Random_Posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/random-posts-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Random_Posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Random_Posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/random-posts-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add admin menu for plugin
	 */

	public function add_admin_menu(){
		add_menu_page('Random Posts Settings', 'Random Posts', 'manage_options', 'random-posts', array($this, 'admin_page_display'), 'dashicons-chart-pie', 60);
	}


	/**
	 * Admin page display
	 */
	public function admin_page_display(){
		include 'partials/random-posts-admin-display.php';
	}


	/**
	 * All hokks for admin_init
	 */
	public function admin_init() {
		$this->add_settings_section();
		$this->add_settings_fields();
		$this->save_fields();
	}


	/**
	 * Add settings sections for plugin options
	 */
	public function add_settings_section(){
		add_settings_section( 
			'rp-general-section', 
			__("General Settings","random_posts"), 
			function(){echo __("<p>These are general settings for Random Posts</p>","random_posts");},
			'rp-settings-page' 
		);

		add_settings_section( 
			'rp-perfm-section', 
			__("Performance settings","random_posts"), 
			function(){echo "";},
			'rp-settings-page' 
		);
	}

	/**
	 * Add settings fields
	 */
	public function add_settings_fields(){
		add_settings_field( 
			'rp_default_posts_value', 
			__('Default Posts count',"random_posts"),
			array($this, 'markup_text_fields_cb'),
			'rp-settings-page', 
			'rp-general-section',
			array('name' => 'rp_default_posts_value','value' => get_option("rp_default_posts_value"))
		);

		add_settings_field( 
			'rp_default_posts_ordering', 
			__('Default Posts ordering',"random_posts"), 
			array($this, 'markup_select_fields_cb'),
			'rp-settings-page', 
			'rp-general-section',
			array(
				'name' => 'rp_default_posts_ordering',
				'value' => get_option("rp_default_posts_ordering"),
				'options' => array(
					'asc' => __("Ascending","random_posts"),
					'desc' => __("Descending","random_posts"),
				)
			)
		);
		//for perfomance
		add_settings_field( 
			'rp_turnon_lazy_load', 
			__('Use lazyload for images?',"random_posts"),
			array($this, 'markup_select_fields_cb'),
			'rp-settings-page', 
			'rp-perfm-section',
			array(
				'name' => 'rp_turnon_lazy_load',
				'value' => get_option("rp_turnon_lazy_load"),
				'options' => array(
					'false' => __("No","random_posts"),
					'true' => __("Yes","random_posts"),
				)
			)
		);
		add_settings_field( 
			'rp_cache_expiry_time', 
			__('Posts Cache Expiry Time (minutes)',"random_posts"),
			array($this, 'markup_text_fields_cb'),
			'rp-settings-page', 
			'rp-perfm-section',
			array('name' => 'rp_cache_expiry_time','value' => get_option("rp_cache_expiry_time"))
		);

		add_settings_field( 
			'rp_lazy_load', 
			__('Lazy Load starting from (x) image',"random_posts"),
			array($this, 'markup_text_fields_cb'),
			'rp-settings-page', 
			'rp-perfm-section',
			array('name' => 'rp_lazy_load','value' => get_option("rp_lazy_load"))
		);
	}


	/**
	 * Save settings fields
	 */
	public function save_fields(){
		register_setting('rp-settings-page-options-group', 'rp_default_posts_value', array('sanitize_callback' => 'absint'));
		register_setting('rp-settings-page-options-group', 'rp_default_posts_ordering');
		register_setting('rp-settings-page-options-group', 'rp_cache_expiry_time', array('sanitize_callback' => 'absint'));
		register_setting('rp-settings-page-options-group', 'rp_lazy_load', array('sanitize_callback' => 'absint'));
		register_setting('rp-settings-page-options-group', 'rp_turnon_lazy_load');
	}


	/**
	 * Markup text fields
	 */
	public function markup_text_fields_cb($args) {
		if(!is_array($args)){
			return null;
		}

		$name = (isset($args['name'])) ? esc_html($args['name']) : '';
		$value = (isset($args['value'])) ? esc_html($args['value']) : '';

		?>

		<input type="text" class="field-<?php echo $name; ?>" name="<?php echo $name; ?>" value="<?php echo $value; ?>"/>

		<?php
	}

	/**
	 * Markup select fields
	 */
	public function markup_select_fields_cb($args) {
		if(!is_array($args)){
			return null;
		}

		$name = (isset($args['name'])) ? esc_html($args['name']) : '';
		$value = (isset($args['value'])) ? esc_html($args['value']) : '';
		$options = 
			(
				isset($args["options"])
				&&
				is_array($args["options"])
			)
				? $args['options'] 
				: array();


		?>

		<select class="field-<?php echo $name; ?>" name="<?php echo $name; ?>" />
			<?php
				foreach($options as $option_key => $option_label){
					echo "<option value='{$option_key}' ".selected($option_key,$value).">{$option_label}</option>";
				}
			?>
		</select>

		<?php
	}
}
