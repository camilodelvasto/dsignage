<?php
/**
 * Display Categories: will create a list with the categorie on the "displaycategories" taxonomy.
 *
 */

if ( !class_exists( 'avia_sc_display_categories' ))
{
	class avia_sc_display_categories extends aviaShortcodeTemplate
	{

		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['name']		= __('Display Categories', 'avia_framework' );
			$this->config['tab']		= __('Content Elements', 'avia_framework' );
			$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-magazine.png";
			$this->config['order']		= -10;
			$this->config['target']		= 'avia-target-insert';
			$this->config['shortcode'] 	= 'av_display_categories';
			$this->config['tooltip'] 	= __('List all the display categories', 'avia_framework' );
			$this->config['drag-level'] = 3;
		}

		function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "")
		{
			
			$atts['class'] = $meta['el_class'];
			$atts['custom_markup'] = $meta['custom_markup'];

			$mag = new avia_display_categories($atts);
			return $mag->html();
			
		}

	}
}


if ( !class_exists( 'avia_display_categories' ) )
{
	class avia_display_categories
	{
		static  $displaycategories = 0;
		protected $atts;
		protected $entries;
		
		function __construct($atts = array())
		{
			self::$displaycategories += 1;
		}
		
		
		function html()
		{
			$terms = get_terms( 'displaycategories' );
			$output = "";
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			    $output .= "<ul class='display_categories_list'>";
			    foreach ( $terms as $term ) {
			    	$output .= '<li><a href="' . get_term_link( $term ) . '" title="' . sprintf( __( 'View all post filed under %s', 'my_localization_domain' ), $term->name ) . '">' . $term->name . ' ('. $term->count .')</a></li>';
			    }
			    $output .= "</ul>";
			}
			return $output;
		}
	}
}










