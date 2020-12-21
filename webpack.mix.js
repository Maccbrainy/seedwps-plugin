/*
 * Seedwps-Plugin uses Laravel Mix
 *
 * Check the documentation at
 * https://laravel.com/docs/5.6/mix
 */

let mix = require( 'laravel-mix' );


// You can comment this line if you don't need jQuery
// mix.autoload({
// 	jquery: ['$', 'window.jQuery', 'jQuery'],
// });

mix.setPublicPath( './assets/dist' );

// Compile assets
mix.js( 'assets/src/scripts/seedwpsplugin.js', 'assets/dist/js' )
	.js( 'assets/src/scripts/portfolio-show.js', 'assets/dist/js' )
	.js( 'assets/src/scripts/portfolio-template.js', 'assets/dist/js' )
	.js( 'assets/src/scripts/checkpostboxbydefault.js', 'assets/dist/js' )
	.js( 'assets/src/scripts/portfoliologoupload.js', 'assets/dist/js' )
	.js( 'assets/src/scripts/contactform.js', 'assets/dist/js' )
	.sass( 'assets/src/sass/portfolio-show.scss', 'assets/dist/css' )
	.sass( 'assets/src/sass/portfolio-template.scss', 'assets/dist/css' )
	.sass( 'assets/src/sass/contactform.scss', 'assets/dist/css' )
	.sass( 'assets/src/sass/seedwpsplugin.scss', 'assets/dist/css' );

// Add versioning to assets in production environment
if ( mix.inProduction() ) {
	mix.version();
}
