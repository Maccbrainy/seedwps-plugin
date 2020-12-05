<?php
/**
 * Testimonial Controller 
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Controllers;

use Inc\Api\AdminSettingsApi;
use \Inc\Controllers\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

class TestimonialController extends BaseController
{

	/**
	 * Stores a new instance of the AdminSettingsApi
	 * @var Class instance
	 */
	public $admin_settings_api;

	/**
	 * Testimonial Post Type Subpage array
	 * @var array
	 */
	public $subpages = array();

	/**
	 * Stores a new instance of the AdminCallbacks
	 * @var Class instance
	 */
	public $admin_callbacks;


	public function register()
	{
		//$this->activated() defined in the BaseController
		if ( ! $this->activated('testimonial_manager')) {

			return;
		}


		$this->admin_settings_api = new AdminSettingsApi();

		$this->admin_callbacks = new AdminCallbacks;


		add_action('init', array($this, 'testimonialCpt'));

		add_action('add_meta_boxes', array( $this, 'addMetaBoxes'));

		add_action('save_post', array( $this, 'saveMetaBox'));

		add_action('manage_testimonial_posts_columns', array( $this, 'setCustomColumns'));

		add_action('manage_testimonial_posts_custom_column', array( $this, 'setCustomColumnsData'), 10, 2);

		add_filter('manage_edit-testimonial_sortable_columns', array( $this, 'setCustomColumnsSortable'));


		$this->setShortCodePage();

		$this->admin_settings_api->AddAdminSubPages($this->subpages)->register();

		add_shortcode('testimonial-form', array($this, 'testimonial_Form'));

	}


	public function testimonial_Form()
	{
		//return HTML
		ob_start();

		$output ='';

		echo "<link href=\"$this->plugin_url/assets/dist/css/contactform.css\"></link>";

		require_once $this->plugin_path .'/templates/contact-form.php';

		$output.="<script src=\"$this->plugin_url/assets/dist/js/contactform.js\"></script>";

		// echo "<script src=\"$this->plugin_url/assets/dist/js/contactform.js\"><script>";
		echo $output;

		return ob_get_clean();
	}

	public function setShortCodePage()
	{
		/**
		 * Admin Testimonial ShortCode page array
		 * @var array
		 */
		$this->subpages = array(

			array(

				'parent_slug' => 'edit.php?post_type=testimonial',
				'page_title' => 'Short Codes',
				'menu_title' => 'Short Codes',
				'capability' => 'manage_options',
				'menu_slug' => 'seedwps_testimonial_shortcode',
				'callback' => array($this->admin_callbacks, 'testimonial_Index')

			)
		);
	}

	public function testimonialCpt()
	{

			$labels = array(
	        'name'                  => 'Testimonials',
	        'singular_name'         => 'Testimonial',
	        'menu_name'             => 'Testimonials'
	        // 'name_admin_bar'        => _x( 'Testimonial', 'Add New on Toolbar', 'textdomain' ),
	        // 'add_new'               => __( 'Add New', 'textdomain' ),
	        // 'add_new_item'          => __( 'Add New Testimonial', 'textdomain' ),
	        // 'new_item'              => __( 'New Testimonial', 'textdomain' ),
	        // 'edit_item'             => __( 'Edit Testimonial', 'textdomain' ),
	        // 'view_item'             => __( 'View Testimonial', 'textdomain' ),
	        // 'all_items'             => __( 'All Testimonials', 'textdomain' ),
	        // 'search_items'          => __( 'Search Testimonials', 'textdomain' ),
	        // 'parent_item_colon'     => __( 'Parent Testimonials:', 'textdomain' ),
	    );
	       
	 
	    $args = array(
	        'labels'             => $labels,
	        'public'             => true,
	        'publicly_queryable' => false, 
	        'show_ui'            => true,
	        'show_in_menu'       => true,
	        // 'query_var'          => true,
	        'capability_type'    => 'post',
	        'has_archive'        => false,
	        // 'hierarchical'       => false,
	        // 'menu_position'      => null,
	        'menu_icon'  		 => 'dashicons-testimonial',
	        'exclude_from_search'=> true,
	        'supports'           => array( 'title', 'editor', 'custom-fields')
	    );

	    register_post_type('testimonial', $args);

	}
	public function addMetaBoxes()
	{
		add_meta_box(
				'testimonial_author',
				'Testimonial Options',
				array($this, 'renderOptionBox'),
				'testimonial',
				'normal',
				'default'
		);
	}

	public function renderOptionBox($post)
	{
		
		wp_nonce_field('seedwps_testimonial', 'seedwps_testimonial_nonce');

		$data 		= get_post_meta( $post->ID, '_seedwps_testimonial_key', true );

			$name 		= isset($data['name']) ? $data['name']: '';

			$email 		= isset($data['email']) ? $data['email']: '';

			$approved 	= isset($data['approved']) ? $data['approved'] : false;

			$featured 	= isset($data['featured']) ? $data['featured'] : false;

		?>

		<p>
			<label class="meta-label" for="seedwps_testimonial_author">Testimonial Author</label>

			<input class="widefat" type="text" id="seedwps_testimonial_author" name="seedwps_testimonial_author" value="<?php echo esc_attr($name); ?>">
		</p>

		<p>
			<label class="meta-label" for="seedwps_testimonial_email">Author Email</label>

			<input class="widefat" type="text" id="seedwps_testimonial_email" name="seedwps_testimonial_email" value="<?php echo esc_attr($email); ?>">
		</p>

		<div class="meta-container mt-25 mb-12">

			<label class="meta-label text-left pr-10" for="seedwps_testimonial_approved">Approved</label>

			<div class="text-right inline">
				<div class="ui-toggle inline"><input type="checkbox" id="seedwps_testimonial_approved" name="seedwps_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
					<label for="seedwps_testimonial_approved"><div></div></label>
				</div>

			</div>

		</div>

		<div class="meta-container mt-25 mb-12">

			<label class="meta-label text-left pr-10" for="seedwps_testimonial_featured">Featured</label>

			<div class="text-right inline">
				<div class="ui-toggle inline"><input type="checkbox" id="seedwps_testimonial_featured" name="seedwps_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
					<label for="seedwps_testimonial_featured"><div></div></label>
				</div>
				
			</div>

		</div>

		<?php 
	}

	public function saveMetaBox($post_id)
	{
		if (! isset($_POST['seedwps_testimonial_nonce'])) {

			return $post_id;
		}

		$nonce = $_POST['seedwps_testimonial_nonce'];

		if (!wp_verify_nonce( $nonce, 'seedwps_testimonial')) {
			
			return $post_id;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {

			return $post_id;
		}

		if ( ! current_user_can('edit_post', $post_id)) {

			return $post_id;
		}

		$data = array(

			'name' 		=> sanitize_text_field($_POST['seedwps_testimonial_author']),

			'email' 	=> sanitize_text_field($_POST['seedwps_testimonial_email']),

			'approved' 	=> isset($_POST['seedwps_testimonial_approved']) ? 1: 0,

			'featured' 	=> isset($_POST['seedwps_testimonial_featured']) ? 1: 0,

		);

		update_post_meta($post_id, '_seedwps_testimonial_key', $data);
	}

	public function setCustomColumns($columns)
	{

		$title = $columns['title'];

		$date = $columns['date'];


		unset($columns['title'], $columns['date']);


		$columns['name'] = 'Author Name';

		$columns['title'] = $title;

		$columns['approved'] = 'Approved';

		$columns['featured'] = 'Featured';

		$columns['date'] = $date;


		return $columns;
	}

	public function setCustomColumnsData($column, $post_id)
	{

		$data 		= get_post_meta( $post_id, '_seedwps_testimonial_key', true );

			$name 		= isset($data['name']) ? $data['name']: '';

			$email 		= isset($data['email']) ? $data['email']: '';

			$approved 	= isset($data['approved']) && $data['approved'] === 1 ? '<strong>YES</strong>' : 'NO';

			$featured 	= isset($data['featured']) && $data['featured'] === 1 ? '<strong>YES</strong>' : 'NO';


			switch ($column) {

				case 'name':
					echo '<strong>'.$name.'<strong><br/><a href="mailto:'.$email.'">'.$email.'</a>';
					break;

				
				case 'approved':
					echo $approved;
					break;

				
				case 'featured':
					echo $featured;
					break;
			}
	}

	public function setCustomColumnsSortable($columns)
	{

		$columns['name'] = 'name';

		$columns['approved'] = 'approved';

		$columns['featured'] = 'featured';

		return $columns;
	}
}