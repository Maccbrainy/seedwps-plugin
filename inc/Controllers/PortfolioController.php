<?php
/**
 * Portfolio Slider Controller 
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Controllers;

use Inc\Api\AdminSettingsApi;
use \Inc\Controllers\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\PortfolioCallbacks;

class PortfolioController extends BaseController
{
	/**
	 * Stores a new instance of the AdminSettingsApi
	 * @var Class instance
	 */
	public $admin_settings_api;

	/**
	 * Stores a new instance of the AdminCallbacks
	 * @var Class instance
	 */
	public $admin_callbacks;

	/**
	 * Admin Custom Post Type Subpage array
	 * @var array
	 */
	public $subpages = array();

	/**
	 * Stores a new instance of the portfolioCallbacks
	 * @var Class instance
	 */
	public $portfolio_callbacks;

	public $portfolio_cpt = array();


	public function register()
	{
		//$this->activated() defined in the BaseController
		if ( ! $this->activated('portfolio_manager')) {

			return;
		}
		
		$this->admin_settings_api = new AdminSettingsApi();

		$this->admin_callbacks = new AdminCallbacks();

		$this->portfolio_callbacks = new portfolioCallbacks();

		// $this->setSubpages();

		$this->setShortCodePage();

		// $this->activateRegisterSetting();

		// $this->activateSettingsSection();

		// $this->activateSettingsField();

		//Method chaining
		$this->admin_settings_api->AddAdminSubPages($this->subpages)->register();

		add_shortcode('portfolio-slideshow', array($this, 'portfolioSlideshow'));

		// $this->storeportfolioCpt();

		// if (! empty($this->portfolio_cpt)) {

			add_action('init', array($this, 'registerPortfolioCTP'));

			add_action('add_meta_boxes', array($this, 'addMetaBoxes'));

			add_action('add_meta_boxes', array($this, 'addMetaBoxesImage'));

			add_action('admin_enqueue_scripts', array($this,'load_projectlogo_scripts'));

			add_action('wp_enqueue_scripts',array($this,'loadScriptsforFrontend'));

			add_action('save_post', array($this, 'saveMetaBox'));

			add_action('save_post', array($this, 'saveMetaBoxImagePost'));

			add_action('manage_portfolio_posts_columns', array($this, 'setCustomColumns'));

			add_action('manage_portfolio_posts_custom_column', array( $this, 'setCustomColumnsData'), 8, 2);

			add_filter('manage_edit-portfolio_sortable_columns', array( $this, 'setCustomColumnsSortable'));

			


		// }
		

			
	}

	public function portfolioSlideshow()
	{
		// return HTML
		ob_start();

		require_once $this->plugin_path . '/templates/portfolio-show.php';

		return ob_get_clean();
	}

	public function loadScriptsforFrontend()
	{
		global $post;
		/**
		 * Check to return the scripts if the portfolio-slideshow shortcode is not being used
		 */
		if( ! has_shortcode( $post->post_content,'portfolio-slideshow')) return;

		wp_enqueue_style('portfolio_show_css', $this->plugin_url .'assets/dist/css/portfolio-show.css');

		wp_enqueue_script('portfolio_show_js', $this->plugin_url .'assets/dist/js/portfolio-show.js');
		
	}

	/*=========Admin SubPages==========*/

	// public function setSubpages()
	// {
	// 	/**
	// 	 * Admin Portfolio Slider Subpage array
	// 	 * @var array
	// 	 */
	// 	$this->subpages = array(

	// 		array(

	// 			'parent_slug' => 'seedwps_plugin',
	// 			'page_title' => 'portfolio Settings',
	// 			'menu_title' => 'portfolio Manager',
	// 			'capability' => 'manage_options',
	// 			'menu_slug' => 'seedwps_portfolio_manager',
	// 			'callback' => array($this->admin_callbacks, 'portfolio_Index')
	// 		)
	// 	);
	// }

	/*=========portfolio SubPages shortCode==========*/
	public function setShortCodePage()
	{
		/**
		 * Admin Portfolio Slider ShortCode page array
		 * @var array
		 */
		$this->subpages = array(

			array(

				'parent_slug' => 'edit.php?post_type=portfolio',
				'page_title' => 'Short Codes',
				'menu_title' => 'Short Codes',
				'capability' => 'manage_options',
				'menu_slug' => 'seedwps_portfolio_shortcode',
				'callback' => array($this->admin_callbacks, 'portfolioShortCode_Index')
			)
		);
	}
		

	public function registerPortfolioCTP()
	{
		$labels = array(
				'name'                  => 'Portfolio',
				'singular_name'         => 'Portfolio',
				'menu_name'             => 'Portfolio',
				'name_admin_bar'        => 'Portfolio',
				'archives'              => 'Portfolio Archives',
				'attributes'            => 'Portfolio Attributes',
				'parent_item_colon'     => 'Parent Portfolio',
				'all_items'             => 'All Portfolio',
				'add_new_item'          => 'Add New Portfolio',
				'add_new'               => 'Add New',
				'new_item'              => 'New Portfolio',
				'edit_item'             => 'Edit Portfolio',
				'update_item'           => 'Update Portfolio',
				'view_item'             => 'View Portfolio',
				'view_items'            => 'View Portfolio',
				'search_items'          => 'Search Portfolio',
				'not_found'             => 'No Portfolio Found',
				'not_found_in_trash'    => 'No Portfolio found in Trash',
				'featured_image'        => 'Featured Image',
				'set_featured_image'    => 'Set Featured Image',
				'remove_featured_image' => 'Remove Featured Image',
				'use_featured_image'    => 'Use Featured Image',
				'insert_into_item'      => 'Insert into Portfolio',
				'uploaded_to_this_item' => 'Upload to this Portfolio',
				'items_list'            => 'Portfolio List',
				'items_list_navigation' => 'Portfolio List Navigation',
				'filter_items_list'     => 'Filter Portfolio List',
		);
		
		$args = array(
			'labels' => $labels,
			'description'           => 'Portfolio Post Type',
			'supports'              => array('title','editor', 'thumbnail','post-formats','page-attributes','custom-fields','excerpt'),
			'taxonomies'            => array('post_tag'),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'show_in_rest'          => false,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post'
		);
		
		register_post_type( 'portfolio', $args);

	}

	public static function portfolio_logo_uploader_field( $name, $value='')
	{

	    $image = ' button">Upload Project Logo';
	    $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
	    $display = 'none'; // display state ot the "Remove image" button

	    if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

	        // $image_attributes[0] - image URL
	        // $image_attributes[1] - image width
	        // $image_attributes[2] - image height

	        $image = '"><img src="' . $image_attributes[0] . '" style="max-width:50%;display:block;" />';
	        $display = 'inline-block';

	    } 

	    return '
	    <div>
	        <a href="#" class="portfolio_upload_image_button' . $image . '</a>
	        <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
	        <a href="#" class="portfolio_remove_image_button" style="display:inline-block;display:' . $display . '">Remove image</a>
	    </div>';
	}

	public static function portfolio_project_logo_display( $name, $value='')
	{

	    $image = '">No Image';
	    $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
	    $display = 'none'; // display state ot the "Remove image" button

	    if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

	        $image = '"><img src="' . $image_attributes[0] . '" style="max-width:70%;display:inline-block;" />';
	    } 

	    return '
	    <div class="img-thumb">
	        <span class="portfolio_upload_image_button' . $image . '</span>
	    </div>';
	}


	public function addMetaBoxes()
	{
		add_meta_box(
			'portfolio_subtitle',
			'Portfolio Tab Options and Project Status',
			array($this, 'renderTabOptions'),
			'portfolio',
			'normal',
			'high'
		);
	}

	public function addMetaBoxesImage()
	{
		add_meta_box(
			'portfolio_tab_image',
			'Project logo',
			array($this, 'renderImage'),
			'portfolio',
			'normal',
			'high'
		);
	}

	public function renderTabOptions($post)
	{
		wp_nonce_field('seedwps_portfolio', 'seedwps_portfolio_nonce');

		$data = get_post_meta( $post->ID, '_seedwps_portfolio_key', true );

		$subtitle = isset($data['subtitle']) ? $data['subtitle'] : '';

		$projectcompleted = isset($data['projectcompleted']) ? $data['projectcompleted'] : false;

		$featured = isset($data['featured']) ? $data['featured'] : false;

		?>

		<p>
			<label for="seedwps_portfolio_subtitle">Portfolio subtitle</label>

			<input class="widefat" type="text" id="seedwps_portfolio_subtitle" name="seedwps_portfolio_subtitle" value="<?php echo esc_attr($subtitle); ?>" placeholder="Add Portfolio subtitle">
		</p>


		<div class="meta-container mt-25 mb-12">

			<label class="meta-label text-left pr-10" for="seedwps_portfolio_projectcompleted"><strong>Project Completed</strong></label>

			<div class="text-right inline">
				<div class="ui-toggle inline"><input type="checkbox" id="seedwps_portfolio_projectcompleted" name="seedwps_portfolio_projectcompleted" value="1" <?php echo $projectcompleted ? 'checked' : ''; ?>>
					<label for="seedwps_portfolio_projectcompleted"><div></div></label>
				</div>

			</div>

		</div>

		<div class="meta-container mt-25 mb-12">

			<label class="meta-label text-left pr-10" for="seedwps_portfolio_featured"><strong>Featured in front-end</strong></label>

			<div class="text-right inline">
				<div class="ui-toggle inline"><input type="checkbox" id="seedwps_portfolio_featured" name="seedwps_portfolio_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
					<label for="seedwps_portfolio_featured"><div></div></label>
				</div>
				
			</div>

		</div>

		<?php
	}

	public function renderImage($post)
	{
		$meta_logo_key = '_seedwps_portfolio_tabimage_key';
			$var = self::portfolio_logo_uploader_field( $meta_logo_key, get_post_meta($post->ID, $meta_logo_key, true) );

		echo $var;
	}

	public function load_projectlogo_scripts($hook)
	{
		$post_array = array('post-new.php', 'post.php');
			
			if ( ! in_array($hook, $post_array) ) return;

			if ( ! did_action( 'wp_enqueue_media' ) ) {
	        wp_enqueue_media();
	    	}

	    	wp_enqueue_script('projectlogo-scripts', $this->plugin_url .'assets/dist/js/portfoliologoupload.js');
	}
	

	public function saveMetaBox($post_id)
	{
		if (! isset($_POST['seedwps_portfolio_nonce'])) {
			
			return $post_id;
		}

		$nonce = $_POST['seedwps_portfolio_nonce'];

		if (! wp_verify_nonce($nonce, 'seedwps_portfolio')) {

			return $post_id;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {

			return $post_id;
		}

		if (! current_user_can('edit_post', $post_id)) {

			return $post_id;
		}

		$data = array(

			'subtitle' => sanitize_text_field($_POST['seedwps_portfolio_subtitle']),

			'projectcompleted' => isset($_POST['seedwps_portfolio_projectcompleted']),

			'featured' => isset($_POST['seedwps_portfolio_featured']),

		);

		update_post_meta($post_id, '_seedwps_portfolio_key', $data);

	}

	public function saveMetaBoxImagePost($post_id)
	{


		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {

			return $post_id;
		}

		if (! current_user_can('edit_post', $post_id)) {

			return $post_id;
		}

		$meta_logo_key = '_seedwps_portfolio_tabimage_key';

		$logodata = isset($_POST[$meta_logo_key]) ? $_POST[$meta_logo_key]: null;

    	update_post_meta( $post_id, $meta_logo_key, $logodata);

    	return $post_id;
	}

	public function setCustomColumns($columns)
	{


		$title 	= $columns['title'];

		$date 	= $columns['date'];


		unset($columns['title'], $columns['date']);



		$columns['subtitle'] = 'Project Subtitle';

		$columns['tabimage'] = 'Project Logo';

		$columns['title'] = $title;

		$columns['projectcompleted'] = 'Project Completed';

		$columns['featured'] = 'Featured';

		$columns['date'] = $date;


		return $columns;

	}

	public function setCustomColumnsData($column, $post_id)
	{

		$data 		= get_post_meta( $post_id, '_seedwps_portfolio_key', true );

		$subtitle 	= isset($data['subtitle']) ? $data['subtitle']: '';



		$meta_logo_key = '_seedwps_portfolio_tabimage_key';
		$tabimage = self::portfolio_project_logo_display( $meta_logo_key, get_post_meta($post_id, $meta_logo_key, true) );





		$projectcompleted = isset($data['projectcompleted']) && $data['projectcompleted'] ==1 ? '<strong>YES</strong>' : 'NO';

		$featured 	= isset($data['featured']) && $data['featured'] == 1 ? '<strong>YES</strong>' : 'NO';


		switch ($column) {

			case 'subtitle':
				echo '<strong>'.$subtitle.'<strong>';
				break;

			
			case 'tabimage':
				echo $tabimage;
				break;

			case 'projectcompleted':
				echo $projectcompleted;
				break;

			
			case 'featured':
				echo $featured;
				break;
		}
	}

	public function setCustomColumnsSortable($columns)
	{

		$columns['subtitle'] = 'subtitle';

		$columns['tabimage'] = 'tabimage';

		$columns['projectcompleted'] = 'projectcompleted';

		$columns['featured'] = 'featured';

		return $columns;
	}

}