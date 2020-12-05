<?php
/**
 * Template Controller
 * 
 * @package SeedwpsPlugin
 */
namespace Inc\Controllers;

use \Inc\Controllers\BaseController;

class TemplateController extends BaseController
{
    /**
	 * Stores the page template
	 * @var
	 */
   public $templates;

	public function register()
	{
		//$this->activated() defined in the BaseController
		if ( ! $this->activated('template_manager')) {

			return;
        }
        
        $this->templates = array(
            'page-templates/portfolio-template-tpl.php' => 'Portfolio Page Template'
        );

        //Tell WordPress to integrate the template into the template area
        add_filter( 'theme_page_templates', array($this, 'custom_template') );

    }
    
    public function custom_template($default_templates)
    {
        $templates = array_merge($default_templates, $this->templates);
        
        return $templates;
    }

}