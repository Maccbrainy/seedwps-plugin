<?php
/**
 * This plugin uses PSR-4 and OOP logic instead of procedural coding
 * Every function, hook and action is properly divided and organized
 * into related folders and files
 *
 * @package SeedwpsPlugin
 */

namespace Inc;

final class Init 
{
	/**
	 * Store all the classes inside an array
	 * @return  array full list of classes
	 */
	public static function getServices()
	{
		return [
			Base\Enqueue::class,
			Base\SettingsLinks::class,
			Controllers\DashboardController::class,
			Controllers\CustomPostTypeController::class,
			Controllers\CustomTaxonomyController::class,
			Controllers\TestimonialController::class,
			Controllers\PortfolioController::class,
			Controllers\TemplateController::class,
			Controllers\LoginController::class
		];
	}

	/**
	 * Loop through the classes, initialize them, and call the register() method if it exists
	 * @return 
	 */
	public static function registerServices()
	{
		foreach (self::getServices() as $class) {
			$method = self::instantiate($class);

			if (method_exists($method,'register')) {
				$method->register();
			}
		}
	}

	/**
	 * [Initialize the class]
	 * @param  [class] $class [class from the services array]
	 * @return [class instance]        [new instance of the class]
	 */
	public static function instantiate($class)
	{
		return new $class;
	}
}