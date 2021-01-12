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
	 * Admin Subpage array
	 * @var array
	 */
	public $subpages = array();

	/**
	 * Stores a new instance of the portfolioCallbacks
	 * @var Class instance
	 */
	public $portfolio_callbacks;

	/**
	 * [portfolio post type array]
	 * @var array
	 */
	public $portfolio_post_type = array();


	public function register()
	{
		//$this->activated() defined in the BaseController
		if ( ! $this->activated('portfolio_manager')) {

			return;
		}
		
		$this->admin_settings_api = new AdminSettingsApi();

		$this->admin_callbacks = new AdminCallbacks();

		$this->portfolio_callbacks = new PortfolioCallbacks();

		$this->setSubpages();

		$this->activateRegisterSetting();

		$this->activateSettingsSection();

		$this->activateSettingsField();
		
		

		//Method chaining
		$this->admin_settings_api->AddAdminSubPages($this->subpages)->register();

		$this->storePortfolioPostType();

		add_shortcode('portfolio-slideshow', array($this, 'portfolioSlideshow'));

		if (! empty($this->portfolio_post_type)) {

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

		}
				
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
		$post_content = isset($post->post_content)? $post->post_content:'';

		if( ! has_shortcode( $post_content,'portfolio-slideshow')) return;

		wp_enqueue_style('portfolio_show_css', $this->plugin_url .'assets/dist/css/portfolio-show.css');

		wp_enqueue_script('portfolio_show_js', $this->plugin_url .'assets/dist/js/portfolio-show.js');
		
	}

	/*=========Portfolio SubPages==========*/

	public function setSubpages()
	{
		
		$this->subpages = array(
			 
			/**
			 * Portfolio Manager subpage array
			 * @var array
			 */
			array(

				'parent_slug' =>'edit.php?post_type=portfolio',
				'page_title' => 'Portfolio Settings',
				'menu_title' => 'Portfolio Settings',
				'capability' => 'manage_options',
				'menu_slug' => 'seedwps_portfolio_manager',
				'callback' => array($this->admin_callbacks, 'portfolioSettingsIndex')
			),

			/**
			 * Admin Portfolio Slider ShortCode subpage array
			 * @var array
			 */
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

	/*==================================
		Register settings
	====================================
	*/
	public function activateRegisterSetting()
	{		
		/**
		 * Seedwps plugin portfolio Settings array for description
		 * @var array
		 */
		$args = array(

			array(
				'option_group' => 'seedwps_plugin_portfolio_settings',
				'option_name' => 'seedwps_plugin_portfolio',
				'sanitize_callback' => array($this->portfolio_callbacks,'portfolioSanitize')
			)
		);

		$this->admin_settings_api->addSettings($args);
	}


	/*==================================
		Settings section
	====================================
	*/
	public function activateSettingsSection()
	{
		/**
		 *  Portfolio Settings Section array
		 * @var array
		 */
		$args = array(
			array(
				'id' 	=> 'seedwps_portfolio_index',
				'title' => 'Portfolio Manager Settings',
				'callback' => array($this->portfolio_callbacks, 'portfolioSectionManager'),
				'page'	=> 'seedwps_portfolio_manager'
			)
		);
		$this->admin_settings_api->addSections($args);
	}

	/*==================================
		Settings field
	====================================
	*/
	public function activateSettingsField()
	{
		/**
		 *  Portfolio Settings field array
		 * @var array
		 */
		$args = array(

			array(
				'id'	=>'description',
				'title' => 'Portfolio Description',
				'callback' => array($this->portfolio_callbacks, 'textField'),
				'page'  => 'seedwps_portfolio_manager',
				'section'  => 'seedwps_portfolio_index',
				'args' => array(
					'option_name' => 'seedwps_plugin_portfolio',
					'label_for'	=>'description',
					'placeholder' => 'Eg. Describe your portfolio here',
					'class' =>'regular-text',
					'array' =>'portfolio'
				)
			),
			array(
			
				'id' =>'hierarchical',
				'title' =>'Hierarchical',
				'callback' => array($this->portfolio_callbacks,'checkboxField'),
				'page' => 'seedwps_portfolio_manager',
				'section' => 'seedwps_portfolio_index',
				'args' => array(
					'option_name'	=> 'seedwps_plugin_portfolio',
					'label_for' 	=>'hierarchical',
					'class' 		=>'ui-toggle',
					'array'			=>'portfolio' 				
	 			)
			),
			array(
			
				'id' =>'public',
				'title' =>'Public',
				'callback' => array($this->portfolio_callbacks,'checkboxField'),
				'page' => 'seedwps_portfolio_manager',
				'section' => 'seedwps_portfolio_index',
				'args' => array(
					'option_name'	=> 'seedwps_plugin_portfolio',
					'label_for' 	=>'public',
					'class' 		=>'ui-toggle',
					'array'			=>'portfolio' 				
	 			)
			),
			array(
			
				'id' =>'show_in_rest',
				'title' =>'Show gutenberg block',
				'callback' => array($this->portfolio_callbacks,'checkboxField'),
				'page' => 'seedwps_portfolio_manager',
				'section' => 'seedwps_portfolio_index',
				'args' => array(
					'option_name'	=> 'seedwps_plugin_portfolio',
					'label_for' 	=>'show_in_rest',
					'class' 		=>'ui-toggle',
					'array'			=>'portfolio' 				
	 			)
			),
			array(
			
				'id' =>'has_archive',
				'title' =>'Has archive',
				'callback' => array($this->portfolio_callbacks,'checkboxField'),
				'page' => 'seedwps_portfolio_manager',
				'section' => 'seedwps_portfolio_index',
				'args' => array(
					'option_name'	=> 'seedwps_plugin_portfolio',
					'label_for' 	=>'has_archive',
					'class' 		=>'ui-toggle',
					'array'			=>'portfolio' 				
	 			)
			)
		);

		$this->admin_settings_api->addfields($args);
	}

	public function storePortfolioPostType()
	{
		/*if the seedwps_plugin_portfolio is empty in the database, return an empty array() otherwise proceed*/
		$options = ! get_option('seedwps_plugin_portfolio') ? array(): get_option('seedwps_plugin_portfolio');

		// foreach ($options as $option) {

			$this->portfolio_post_type[] = array(

				'post_type'             => 'portfolio',
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
				'label'                 => 'Portfolio',
				'description'           => isset($options['description'])?$options['description']:'',
				'supports'              => array('title','editor', 'thumbnail','post-formats','author','page-attributes','revisions','custom-fields','excerpt'),
				'taxonomies'            => array('category', 'post_tag'),
				'hierarchical'          => isset($options['hierarchical'])?: false,
				'public'                => isset($options['public'])?: false,
				'show_ui'               => true,
				'show_in_rest'          => isset($options['show_in_rest'])?: false,
				'show_in_menu'          => true,
				'menu_position'         => 5,
				'show_in_admin_bar'     => true,
				'show_in_nav_menus'     => true,
				'can_export'            => true,
				'has_archive'           => isset($options['has_archive'])?: false,
				'exclude_from_search'   => false,
				'publicly_queryable'    => true,
				'capability_type'       => 'post'
			);
		// }
		
	}
		
	public function registerPortfolioCTP()
	{
		foreach ($this->portfolio_post_type as $post_type) {
			
			register_post_type( $post_type['post_type'],
				array(
					'labels' => array(
						'name'                  => $post_type['name'],
						'singular_name'         => $post_type['singular_name'],
						'menu_name'             => $post_type['menu_name'],
						'name_admin_bar'        => $post_type['name_admin_bar'],
						'archives'              => $post_type['archives'],
						'attributes'            => $post_type['attributes'],
						'parent_item_colon'     => $post_type['parent_item_colon'],
						'all_items'             => $post_type['all_items'],
						'add_new_item'          => $post_type['add_new_item'],
						'add_new'               => $post_type['add_new'],
						'new_item'              => $post_type['new_item'],
						'edit_item'             => $post_type['edit_item'],
						'update_item'           => $post_type['update_item'],
						'view_item'             => $post_type['view_item'],
						'view_items'            => $post_type['view_items'],
						'search_items'          => $post_type['search_items'],
						'not_found'             => $post_type['not_found'],
						'not_found_in_trash'    => $post_type['not_found_in_trash'],
						'featured_image'        => $post_type['featured_image'],
						'set_featured_image'    => $post_type['set_featured_image'],
						'remove_featured_image' => $post_type['remove_featured_image'],
						'use_featured_image'    => $post_type['use_featured_image'],
						'insert_into_item'      => $post_type['insert_into_item'],
						'uploaded_to_this_item' => $post_type['uploaded_to_this_item'],
						'items_list'            => $post_type['items_list'],
						'items_list_navigation' => $post_type['items_list_navigation'],
						'filter_items_list'     => $post_type['filter_items_list']
					),
					'label'                     => $post_type['label'],
					'description'               => $post_type['description'],
					'supports'                  => $post_type['supports'],
					'taxonomies'                => $post_type['taxonomies'],
					'hierarchical'              => $post_type['hierarchical'],
					'public'                    => $post_type['public'],
					'show_ui'                   => $post_type['show_ui'],
					'show_in_rest'          	=> $post_type['show_in_rest'],
					'show_in_menu'              => $post_type['show_in_menu'],
					'menu_position'             => $post_type['menu_position'],
					'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
					'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
					'can_export'                => $post_type['can_export'],
					'has_archive'               => $post_type['has_archive'],
					'exclude_from_search'       => $post_type['exclude_from_search'],
					'publicly_queryable'        => $post_type['publicly_queryable'],
					'capability_type'           => $post_type['capability_type']
				)
			);
		}
	}

	public static function portfolio_logo_uploader_field( $name, $value='')
	{

	    $image = ' button">Upload Project Logo';
	    $image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
	    $display = 'none'; // display state of the "Remove image" button

	    if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {

	        // $image_attributes[0] - image URL
	        // $image_attributes[1] - image width
	        // $image_attributes[2] - image height

	        $image = '"><img src="' . $image_attributes[0] . '" style="max-width:50%;display:block;" />';

	    } 

	    return '
	    <div>
	        <a href="#" class="portfolio_upload_image_button' . $image . '</a>

	        <input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value. '" />
	        <a href="#" class="portfolio_remove_image_button" style="display:inline-block">Remove image</a>
	    </div>'; 

	}

	public static function portfolio_project_logo_display( $name, $value='')
	{

	    $image = '">No project logo';
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
			'Portfolio Table Options and Project Status',
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

			<label class="meta-label text-left pr-10" for="seedwps_portfolio_projectcompleted"><strong>Project Completed/Show in frontend portfolio gallery</strong></label>

			<div class="text-right inline">
				<div class="ui-toggle inline"><input type="checkbox" id="seedwps_portfolio_projectcompleted" name="seedwps_portfolio_projectcompleted" value="1" <?php echo $projectcompleted ? 'checked' : ''; ?>>
					<label for="seedwps_portfolio_projectcompleted"><div></div></label>
				</div>

			</div>

		</div>

		<div class="meta-container mt-25 mb-12">

			<label class="meta-label text-left pr-10" for="seedwps_portfolio_featured"><strong>Featured</strong></label>

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

	    	wp_enqueue_style('portfolio-admin-style', $this->plugin_url .'assets/dist/css/portfolio-admin-post.css');

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

			'featured' => isset($_POST['seedwps_portfolio_featured'])

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