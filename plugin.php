<?php
namespace ElementorHelloWorld;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Include Widget Scripts
	 *
	 * Include necessary scripts for PL blocks to work
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function widget_scripts() {

		// Include Widgets Bundled Scripts 
		wp_enqueue_script( 'ep-front',  plugin_dir_url( __FILE__ ) . 'main.js');

	}

		/**
	 * Include Widget Styles
	 *
	 * Include PL blocks styles
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function widget_styles() {

		// Include Widgets Bundled Styles 
		wp_enqueue_style( 'ep-style',  plugin_dir_url( __FILE__ ) . 'style.css');

	}

		public function add_elementor_widget_categories( $elements_manager ) {

			$elements_manager->add_category(
				'plugin-sections',
				[
					'title' => __( 'Secciones', 'elementor-plugin' ),
					'icon' => 'fa fa-camera-retro',
				]
			);
		
		}
	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once( __DIR__ . '/src/widgets/hello-world/hello-world.php' );
		require_once( __DIR__ . '/src/widgets/inline-editing/inline-editing.php' );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		/*// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Hello_World() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Inline_Editing() );
		*/
	}



	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

		// Register widget scripts
		add_action( 'wp_head', [ $this, 'widget_scripts' ], 9 );

		// Register Widget Styles
		add_action( 'wp_enqueue_scripts', [ $this, 'widget_styles' ], 100 );
		
		// Add Categories
		add_action( 'elementor/elements/categories_registered', [ $this, 'add_elementor_widget_categories' ] );

		//Register Navigation Menu
		//add_action( 'after_setup_theme', 'register_stg_nav_menus' );
		
	}
}

// Instantiate Plugin Class
Plugin::instance();
