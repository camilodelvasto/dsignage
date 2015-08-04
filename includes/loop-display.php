<?php

global $avia_config, $post_loop_count, $post;


if(empty($post_loop_count)) $post_loop_count = 1;
$blog_style = !empty($avia_config['blog_style']) ? $avia_config['blog_style'] : avia_get_option('blog_style','multi-big');
if(is_single()) $blog_style = avia_get_option('single_post_style','single-big');

$initial_id = avia_get_the_ID();

// check if we got posts to display:
if (have_posts()) :

        echo '<div id="slideshow" data-loopcounter=0>';
        $identifier = $wp_query->post_count;



	while (have_posts()) : the_post();


    /*
     * get the current post id, the current post class and current post format
     */
    $url = "";
    $current_post = array();
    $current_post['post_loop_count']= $post_loop_count;
    $current_post['the_id']     = get_the_ID();
    $current_post['parity']     = $post_loop_count % 2 ? 'odd' : 'even';
    $current_post['last']       = count($wp_query->posts) == $post_loop_count ? " post-entry-last " : "";
    $current_post['post_type']  = get_post_type($current_post['the_id']);
    $current_post['post_class']     = "post-entry-".$current_post['the_id']." post-loop-".$post_loop_count." post-parity-".$current_post['parity'].$current_post['last']." ".$blog_style;
    $current_post['post_class'] .= ($current_post['post_type'] == "post") ? '' : ' post';
    $current_post['post_format']    = get_post_format() ? get_post_format() : 'standard';
    $current_post['post_layout']    = avia_layout_class('main', false);
    $blog_content = !empty($avia_config['blog_content']) ? $avia_config['blog_content'] : "content";
    $do_precompile = false;    

        //get the duration for this slide
        $post_custom_fields= pods('post', get_the_ID());
        $duration = $post_custom_fields->display('ds_duration');

    if(AviaHelper::builder_status($current_post['the_id']) && !is_singular($current_post['the_id']) && $current_post['post_type'] == 'post')
    {
        $do_precompile = true;
    }


	
    if(!empty($avia_config['preview_mode']) && !empty($avia_config['image_size']) && $avia_config['preview_mode'] == 'custom') $size = $avia_config['image_size'];
    $current_post['slider']     = get_the_post_thumbnail($current_post['the_id'], $size);
    
    if(is_single($initial_id) && get_post_meta( $current_post['the_id'], '_avia_hide_featured_image', true ) ) $current_post['slider'] = "";
    
    
    $current_post['title']      = get_the_title();
    $current_post['content']    = $blog_content == "content" ? get_the_content(__('Read more','avia_framework').'<span class="more-link-arrow">  &rarr;</span>') : get_the_excerpt();
    $current_post['content']    = $blog_content == "excerpt_read_more" ? $current_post['content'].'<div class="read-more-link"><a href="'.get_permalink().'" class="more-link">'.__('Read more','avia_framework').'<span class="more-link-arrow">  &rarr;</span></a></div>' : $current_post['content'];
    $current_post['before_content'] = "";

    /*
     * ...now apply a filter, based on the post type... (filter function is located in includes/helper-post-format.php)
     */
    $current_post   = apply_filters( 'post-format-'.$current_post['post_format'], $current_post );
    $with_slider    = empty($current_post['slider']) ? "" : "with-slider";
    /*
     * ... last apply the default wordpress filters to the content
     */
     
    
    $current_post['content'] = str_replace(']]>', ']]&gt;', apply_filters('the_content', $current_post['content'] ));

    /*
     * Now extract the variables so that $current_post['slider'] becomes $slider, $current_post['title'] becomes $title, etc
     */
    extract($current_post);

	/*
	 * render the html:
	 */

	echo "<div class='dsignage-slide' data-duration='".$duration."' data-identifier='".$identifier."'class='".implode(" ", get_post_class('post-entry post-entry-type-'.$post_format . " " . $post_class . " ".$with_slider))."' ".avia_markup_helper(array('context' => 'entry','echo'=>false)).">";

        //default link for preview images
        $link = !empty($url) ? $url : get_permalink();
        
        //preview image description
        $desc = get_post( get_post_thumbnail_id() );
        if(is_object($desc))  $desc = $desc -> post_excerpt;
		$featured_img_desc = ( $desc != "" ) ? $desc : the_title_attribute( 'echo=0' );

        //on single page replace the link with a fullscreen image
        if(is_singular())
        {
            $link = avia_image_by_id(get_post_thumbnail_id(), 'large', 'url');
        }


            // echo the post content
//            echo $content;

     // set up post data
     setup_postdata( $post );

     //check if we want to display breadcumb and title
     if( get_post_meta(get_the_ID(), 'header', true) != 'no') echo avia_title();
     
     //filter the content for content builder elements
     if($do_precompile) $content = apply_filters('avia_builder_precompile', get_post_meta(get_the_ID(), '_aviaLayoutBuilderCleanData', true));


     //check first builder element. if its a section or a fullwidth slider we dont need to create the default openeing divs here

     $first_el = isset(ShortcodeHelper::$tree[0]) ? ShortcodeHelper::$tree[0] : false;
     $last_el  = !empty(ShortcodeHelper::$tree)   ? end(ShortcodeHelper::$tree) : false;
     if(!$first_el || !in_array($first_el['tag'], AviaBuilder::$full_el ) )
     {
        echo avia_new_section(array('close'=>false,'main_container'=>true));
     }
    
    $content = apply_filters('the_content', $content);
    $content = apply_filters('avf_template_builder_content', $content);
    echo $content;

    //only close divs if the user didnt add fullwidth slider elements at the end. also skip sidebar if the last element is a slider
    if(!$last_el || !in_array($last_el['tag'], AviaBuilder::$full_el_no_section ) )
    {
        $cm = avia_section_close_markup();

        echo "</div>";
        echo "</div>$cm <!-- section close by builder template -->";

    }
    else
    {
        echo "<div><div>";
        
    }

echo avia_sc_section::$close_overlay;
echo '      </div><!--end builder template-->';
echo '</div><!-- close default .container_wrap element -->';
echo '</div>';
	$post_loop_count++;
        $identifier--;
	endwhile;
        echo '</div>';
	else:

?>

    <article class="entry">
        <header class="entry-content-header">
            <h1 class='post-title entry-title'><?php _e('Nothing Found', 'avia_framework'); ?></h1>
        </header>

        <p class="entry-content" <?php avia_markup_helper(array('context' => 'entry_content')); ?>><?php _e('Sorry, no posts matched your criteria', 'avia_framework'); ?></p>

        <footer class="entry-footer"></footer>
    </article>

<?php

	endif;

	if(empty($avia_config['remove_pagination'] ))
	{
		echo "<div class='{$blog_style}'>".avia_pagination('', 'nav')."</div>";
	}
?>
</div>