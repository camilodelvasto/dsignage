<?php
/*
 * Register frontend javascripts:
 */
if(!function_exists('dsignage_register_frontend_scripts'))
{
	if(!is_admin()){
		add_action('wp_enqueue_scripts', 'dsignage_register_frontend_scripts');
	}

	function dsignage_register_frontend_scripts()
	{
		$template_url = get_template_directory_uri();
		$child_theme_url = get_stylesheet_directory_uri();

		//register js
		wp_enqueue_script( 'avia-compat', $template_url.'/js/avia-compat.js', array('jquery'), 2, false ); //needs to be loaded at the top to prevent bugs
		wp_enqueue_script( 'avia-default', $template_url.'/js/avia.js', array('jquery'), 3, true );
		wp_enqueue_script( 'avia-shortcodes', $template_url.'/js/shortcodes.js', array('jquery'), 3, true );
		wp_enqueue_script( 'avia-popup',  $template_url.'/js/aviapopup/jquery.magnific-popup.min.js', array('jquery'), 2, true);

		wp_enqueue_script( 'dsignage',  $child_theme_url.'/js/scripts.js', array('jquery'), 2, true);

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wp-mediaelement' );


		if ( is_singular() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }


		//register styles
		wp_register_style( 'avia-style' ,  $child_theme_url."/style.css", array(), 		'2', 'all' ); //register default style.css file. only include in childthemes. has no purpose in main theme
		wp_register_style( 'avia-custom',  $template_url."/css/custom.css", array(), 	'2', 'all' );
																						 
		wp_enqueue_style( 'avia-grid' ,   $template_url."/css/grid.css", array(), 		'2', 'all' );
		wp_enqueue_style( 'avia-base' ,   $template_url."/css/base.css", array(), 		'2', 'all' );
		wp_enqueue_style( 'avia-layout',  $template_url."/css/layout.css", array(), 	'2', 'all' );
		wp_enqueue_style( 'avia-scs',     $template_url."/css/shortcodes.css", array(), '2', 'all' );
		wp_enqueue_style( 'avia-popup-css', $template_url."/js/aviapopup/magnific-popup.css", array(), '1', 'screen' );
		wp_enqueue_style( 'avia-media'  , $template_url."/js/mediaelement/skin-1/mediaelementplayer.css", array(), '1', 'screen' );
		wp_enqueue_style( 'avia-print' ,  $template_url."/css/print.css", array(), '1', 'print' );
		
		
		if ( is_rtl() ) {
			wp_enqueue_style(  'avia-rtl',  $template_url."/css/rtl.css", array(), '1', 'all' );
		}
		

        global $avia;
		$safe_name = avia_backend_safe_string($avia->base_data['prefix']);
		$safe_name = apply_filters('avf_dynamic_stylesheet_filename', $safe_name);

        if( get_option('avia_stylesheet_exists'.$safe_name) == 'true' )
        {
            $avia_upload_dir = wp_upload_dir();
            if(is_ssl()) $avia_upload_dir['baseurl'] = str_replace("http://", "https://", $avia_upload_dir['baseurl']);

            $avia_dyn_stylesheet_url = $avia_upload_dir['baseurl'] . '/dynamic_avia/'.$safe_name.'.css';
			$version_number = get_option('avia_stylesheet_dynamic_version'.$safe_name);
			if(empty($version_number)) $version_number = '1';
            
            wp_enqueue_style( 'avia-dynamic', $avia_dyn_stylesheet_url, array(), $version_number, 'all' );
        }

		wp_enqueue_style( 'avia-custom');


		if($child_theme_url !=  $template_url)
		{
			wp_enqueue_style( 'avia-style');
		}

	}
}

function enfold_customization_admin_css() {
	echo "<style>
				a[href='#avia_sc_contact'] { display: none; }
			</style>";
}
add_action( 'admin_head', 'enfold_customization_admin_css' );