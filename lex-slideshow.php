<?php
/*
Plugin Name: Lex Slideshow
Plugin URI: http://lexkarate.com
Description: A Slideshow for LexKarate.com
Author: Andy Osuna
Author URI: http://andyosuna.com	
Version: 1.0
License: GPLv2
*/

//Register a Custom Post Type
//Ver 1.0
add_action('init','slide_init');
function slide_init(){
	$args=array(
		'labels'			 =>array(
			'name'			 	=>'Slides',
			'singular_name'	 	=>'Slide',
			'add_new'			=>'Add New','slide',
			'edit_item'		 	=>'Edit Slide',
			'new_item'			=>'New Slide',
			'view_item'			=>'View Slide',
			'search_items'		=>'Search Slides',
			'not_found'			=>'No Slides Found',
			'not_found_in_trash'=>'No Slides Found in Trash',
			'parent_item_colon'	=>'',
			'menu_name'			=>'Slides'
		),
		'public'			 =>true,
		'exclude_from_search'=>true,
		'show_in_menu'		 =>true,
		'rewrite'			 =>true,
		'has_archive'		 =>true,
		'hierarchical'		 =>false,
		'menu_position'		 =>20,
		'supports'			 =>array('title','editor','thumbnail')
	);
	register_post_type('slide',$args);
}
//Prevent 404 Errors
//Since Ver. 1.0
function lex_slideshow_rewrite_flush(){
	slide_init();
	flush_rewrite_rules();
}
register_activation_hook(__FILE__,'lex_slideshow_rewrite_flush');

//Add Image Size
//Since Ver. 1.0
function lex_slideshow_image(){
	add_image_size('lex-slideshow',1170,350,true);
}
add_action('init','lex_slideshow_image');

//Front-end Display
//Since Ver. 1.0
function lex_slideshow(){
	$slide_query=new WP_Query(array(
		'post_type'=>'slide',
		'posts_per_page'=>3
	));
	if ($slide_query->have_posts()):
		?>
		<div class="carousel-inner">
			<?php while($slide_query->have_posts()):
				$slide_query->the_post();
				?>
				<div class="item">
					<?php the_post_thumbnail('lex-slideshow');?>
				</div>
				<?php
			endwhile; ?>
		</div>
		<?php
	endif;
	wp_reset_postdata();
}

//Load JS
//Since Ver. 1.0
//function lex_slideshow_scripts(){
//	wp_enqueue_script('jquery');
//	$bootstrap_path='http://andyosuna.com/js/bootstrap.min.js';
//	wp_register_script('bootstrap_js',$bootstrap_path);
//	wp_enqueue_script('bootstrap_js');
//	$custom_path=plugins_url('custom.js',__FILE__);
//	wp_register_script('custom_js',$custom_path);
//	wp_enqueue_script('custom_js');
//}
//add_action('wp_enqueue_scripts','lex_slideshow_scripts');