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
	 * Stores the custom page template
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

        //To telling WordPress to integrate the template into the template area
        add_filter( 'theme_page_templates', array($this, 'customTemplate') );

        //we intercept and inject our own custom template to be picked/tapped by wordpress
        add_filter( 'template_include', array($this, 'loadCustomTemplate') );

        add_action('wp_enqueue_scripts',array($this,'LoadCustomTemplateStylesAndScripts') );
    }
    
    public function customTemplate($default_templates)
    {
        $templates = array_merge($default_templates, $this->templates);
        
        return $templates;
    }

    public function loadCustomTemplate($template)
    {
        global $post;

        if(! $post){

            return $template;
        }


        //If is the single page, load custom template
        if(is_singular('portfolio')) {

            $file = $this->plugin_path . 'page-templates/single-portfolio-template-tpl.php';

            if(file_exists($file)){
            
                return $file;
            }
        }



        $template_name = get_post_meta( $post->ID, '_wp_page_template', true );
        
        if( ! isset($this->templates[$template_name] ) ) {

            return $template;
        }

        //stores the plugin directory path to our custom template defined
        $file = $this->plugin_path . $template_name;

        if(file_exists($file)){
            
            return $file;
        }

        return $template;
    }

    public function LoadCustomTemplateStylesAndScripts()
    {
        if(is_page_template('page-templates/portfolio-template-tpl.php')){

            wp_enqueue_style('portfolio_template_css', $this->plugin_url .'assets/dist/css/portfolio-template.css');

            wp_enqueue_script('portfolio_template_js', $this->plugin_url .'assets/dist/js/portfolio-template.js');
        }
    }

}