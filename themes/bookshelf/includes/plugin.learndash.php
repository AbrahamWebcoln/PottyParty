<?php
/* LearnDash LMS support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('themerex_learndash_theme_setup')) {
	add_action( 'themerex_action_before_init_theme', 'themerex_learndash_theme_setup', 1 );
	function themerex_learndash_theme_setup() {

		if (themerex_exists_learndash()) {

			// Change slugs for courses and lessons to compatibility with built-in courses and lessons
			add_filter('learndash_post_args',					'themerex_learndash_post_args');

			// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
			add_filter('themerex_filter_get_blog_type',			'themerex_learndash_get_blog_type', 9, 2);
			add_filter('themerex_filter_get_blog_title',		'themerex_learndash_get_blog_title', 9, 2);
			add_filter('themerex_filter_get_current_taxonomy',	'themerex_learndash_get_current_taxonomy', 9, 2);
			add_filter('themerex_filter_is_taxonomy',			'themerex_learndash_is_taxonomy', 9, 2);
			add_filter('themerex_filter_get_stream_page_title',	'themerex_learndash_get_stream_page_title', 9, 2);
			add_filter('themerex_filter_get_stream_page_link',	'themerex_learndash_get_stream_page_link', 9, 2);
			add_filter('themerex_filter_get_stream_page_id',	'themerex_learndash_get_stream_page_id', 9, 2);
			add_filter('themerex_filter_query_add_filters',		'themerex_learndash_query_add_filters', 9, 2);
			add_filter('themerex_filter_detect_inheritance_key','themerex_learndash_detect_inheritance_key', 9, 1);

			add_action( 'themerex_action_add_styles',			'themerex_learndash_frontend_scripts' );

			// One-click importer support
			add_filter( 'themerex_filter_importer_options',		'themerex_learndash_importer_set_options' );

			// Get list post_types and taxonomies
			global $THEMEREX_GLOBALS;
			$THEMEREX_GLOBALS['learndash_post_types'] = array('sfwd-courses', 'sfwd-lessons', 'sfwd-quiz', 'sfwd-topic', 'sfwd-certificates', 'sfwd-transactions');
			$THEMEREX_GLOBALS['learndash_taxonomies'] = array('category');
		}

		if (is_admin()) {
			add_filter( 'themerex_filter_importer_required_plugins',	'themerex_learndash_importer_required_plugins', 10, 2 );
			add_filter( 'themerex_filter_required_plugins',				'themerex_learndash_required_plugins' );
		}
	}
}

if ( !function_exists( 'themerex_learndash_settings_theme_setup2' ) ) {
	add_action( 'themerex_action_before_init_theme', 'themerex_learndash_settings_theme_setup2', 3 );
	function themerex_learndash_settings_theme_setup2() {
		// Add LearnDash post type and taxonomy into theme inheritance list
		if (themerex_exists_learndash()) {
			global $THEMEREX_GLOBALS;
			// Get list post_types and taxonomies
			if (!empty(SFWD_CPT_Instance::$instances) && count(SFWD_CPT_Instance::$instances) > 0) {
				$post_types = array();
				foreach (SFWD_CPT_Instance::$instances as $pt=>$data)
					$post_types[] = $pt;
				if (count($post_types) > 0)
					$THEMEREX_GLOBALS['learndash_post_types'] = $post_types;
			}
			// Add in the inheritance list
			themerex_add_theme_inheritance( array('learndash' => array(
				'stream_template' => 'learndash',
				'single_template' => 'single-learndash',
				'taxonomy' => $THEMEREX_GLOBALS['learndash_taxonomies'],
				'taxonomy_tags' => array('post_tag'),
				'post_type' => $THEMEREX_GLOBALS['learndash_post_types'],
				'override' => 'post'
				) )
			);
		}
	}
}



// Check if ThemeREX Donations installed and activated
if ( !function_exists( 'themerex_exists_learndash' ) ) {
	function themerex_exists_learndash() {
		return class_exists('SFWD_LMS');
	}
}


// Return true, if current page is donations page
if ( !function_exists( 'themerex_is_learndash_page' ) ) {
	function themerex_is_learndash_page() {
		$is = false;
		if (themerex_exists_learndash()) {
			global $THEMEREX_GLOBALS;
			$is = in_array($THEMEREX_GLOBALS['page_template'], array('learndash', 'single-learndash'));
			if (!$is) {
				$is = !empty($THEMEREX_GLOBALS['pre_query'])
							? $THEMEREX_GLOBALS['pre_query']->is_single() && in_array($THEMEREX_GLOBALS['pre_query']->get('post_type'), $THEMEREX_GLOBALS['learndash_post_types'])
							: is_single() && in_array(get_query_var('post_type'), $THEMEREX_GLOBALS['learndash_post_types']);
			}
			if (!$is) {
				if (count($THEMEREX_GLOBALS['learndash_post_types']) > 0) {
					foreach ($THEMEREX_GLOBALS['learndash_post_types'] as $pt) {
						if (!empty($THEMEREX_GLOBALS['pre_query']) ? $THEMEREX_GLOBALS['pre_query']->is_post_type_archive($pt) : is_post_type_archive($pt)) {
							$is = true;
							break;
						}
					}
				}
			}
			if (!$is) {
				if (count($THEMEREX_GLOBALS['learndash_taxonomies']) > 0) {
					foreach ($THEMEREX_GLOBALS['learndash_taxonomies'] as $pt) {
						if (!empty($THEMEREX_GLOBALS['pre_query']) ? $THEMEREX_GLOBALS['pre_query']->is_tax($pt) : is_tax($pt)) {
							$is = true;
							break;
						}
					}
				}
			}
		}
		return $is;
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'themerex_learndash_required_plugins' ) ) {
    //add_filter('themerex_filter_required_plugins',	'themerex_learndash_required_plugins');
    function themerex_learndash_required_plugins($list=array()) {

//		$list[] = array(
//					'name' 		=> 'LearnDash LMS',
//					'slug' 		=> 'sfwd-lms',
//					'source'	=> themerex_get_file_dir('plugins/sfwd-lms.zip'),
//					'required' 	=> false
//					);

        return $list;
    }
}

// Filter to detect current page inheritance key
if ( !function_exists( 'themerex_learndash_detect_inheritance_key' ) ) {
	//add_filter('themerex_filter_detect_inheritance_key',	'themerex_learndash_detect_inheritance_key', 9, 1);
	function themerex_learndash_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return themerex_is_learndash_page() ? 'learndash' : '';
	}
}

// Filter to detect current page slug
if ( !function_exists( 'themerex_learndash_get_blog_type' ) ) {
	//add_filter('themerex_filter_get_blog_type',	'themerex_learndash_get_blog_type', 9, 2);
	function themerex_learndash_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;
		global $THEMEREX_GLOBALS;
		if (count($THEMEREX_GLOBALS['learndash_taxonomies']) > 0) {
			foreach ($THEMEREX_GLOBALS['learndash_taxonomies'] as $pt) {
				if ($query && $query->is_tax($pt) || is_tax($pt)) {
					$page = 'learndash_'.$pt;
					break;
				}
			}
		}
		if (empty($page)) {
			$pt = $query ? $query->get('post_type') : get_query_var('post_type');
			if (in_array($pt, $THEMEREX_GLOBALS['learndash_post_types'])) {
				$page = $query && $query->is_single() || is_single() ? 'learndash_item' : 'learndash';
			}
		}
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'themerex_learndash_get_blog_title' ) ) {
	//add_filter('themerex_filter_get_blog_title',	'themerex_learndash_get_blog_title', 9, 2);
	function themerex_learndash_get_blog_title($title, $page) {
		if (!empty($title)) return $title;
		if ( themerex_strpos($page, 'learndash')!==false ) {
			if ( $page == 'learndash_item' ) {
				$title = themerex_get_post_title();
			} else if ( themerex_strpos($page, 'learndash_')!==false ) {
				$parts = explode('_', $page);
				$term = get_term_by( 'slug', get_query_var( $parts[1] ), $parts[1], OBJECT);
				$title = $term->name;
			} else {
				$title = esc_html__('All Courses', 'themerex');
			}
		}

		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'themerex_learndash_get_stream_page_title' ) ) {
	//add_filter('themerex_filter_get_stream_page_title',	'themerex_learndash_get_stream_page_title', 9, 2);
	function themerex_learndash_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (themerex_strpos($page, 'learndash')!==false) {
			if (($page_id = themerex_learndash_get_stream_page_id(0, $page=='learndash' ? 'learndash' : $page)) > 0)
				$title = themerex_get_post_title($page_id);
			else
				$title = esc_html__('All Courses', 'themerex');				
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'themerex_learndash_get_stream_page_id' ) ) {
	//add_filter('themerex_filter_get_stream_page_id',	'themerex_learndash_get_stream_page_id', 9, 2);
	function themerex_learndash_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (themerex_strpos($page, 'learndash')!==false) $id = themerex_get_template_page_id('learndash');
		return $id;
	}
}

// Filter to detect stream page URL
if ( !function_exists( 'themerex_learndash_get_stream_page_link' ) ) {
	//add_filter('themerex_filter_get_stream_page_link',	'themerex_learndash_get_stream_page_link', 9, 2);
	function themerex_learndash_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (themerex_strpos($page, 'learndash')!==false) {
			$id = themerex_get_template_page_id('learndash');
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'themerex_learndash_get_current_taxonomy' ) ) {
	//add_filter('themerex_filter_get_current_taxonomy',	'themerex_learndash_get_current_taxonomy', 9, 2);
	function themerex_learndash_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( themerex_strpos($page, 'learndash')!==false ) {
			global $THEMEREX_GLOBALS;
			if (count($THEMEREX_GLOBALS['learndash_taxonomies']) > 0) {
				$tax = $THEMEREX_GLOBALS['learndash_taxonomies'][0];
			}
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'themerex_learndash_is_taxonomy' ) ) {
	//add_filter('themerex_filter_is_taxonomy',	'themerex_learndash_is_taxonomy', 9, 2);
	function themerex_learndash_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else {
			global $THEMEREX_GLOBALS;
			if (count($THEMEREX_GLOBALS['learndash_taxonomies']) > 0) {
				foreach ($THEMEREX_GLOBALS['learndash_taxonomies'] as $pt) {
					if ($query && ($query->get($pt)!='' || $query->is_tax($pt)) || is_tax($pt)) {
						$tax = $pt;
						break;
					}
				}
			}
			return $tax;
		}
	}
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'themerex_learndash_query_add_filters' ) ) {
	//add_filter('themerex_filter_query_add_filters',	'themerex_learndash_query_add_filters', 9, 2);
	function themerex_learndash_query_add_filters($args, $filter) {
		if ($filter == 'learndash') {
			//global $THEMEREX_GLOBALS;
			$args['post_type'] = 'sfwd-courses';	//$THEMEREX_GLOBALS['learndash_post_types'];
		}
		return $args;
	}
}



// Enqueue Learn Dash custom styles
if ( !function_exists( 'themerex_learndash_frontend_scripts' ) ) {
	//add_action( 'themerex_action_add_styles', 'themerex_learndash_frontend_scripts' );
	function themerex_learndash_frontend_scripts() {
		themerex_enqueue_style( 'learndash-style',  themerex_get_file_url('css/learndash-style.css'), array(), null );
	}
}



// Change slugs for courses and lessons to compatibility with built-in courses and lessons
if ( !function_exists( 'themerex_learndash_post_args' ) ) {
	//add_filter('learndash_post_args',	'themerex_learndash_post_args');
	function themerex_learndash_post_args($args) {
		if (is_array($args) && count($args)>0) {
			$cnt = 0;
			for ($i=0; $i<count($args); $i++) {
				if (!empty($args[$i]['post_type']) && !empty($args[$i]['slug_name'])) {
					if ($args[$i]['post_type']=='sfwd-courses' && $args[$i]['slug_name']=='courses') {
						$args[$i]['slug_name']='sfwd-courses';
						$cnt++;
					}
					if ($args[$i]['post_type']=='sfwd-lessons' && $args[$i]['slug_name']=='lessons') {
						$args[$i]['slug_name']='sfwd-lessons';
						$cnt++;
					}
					if ($cnt==2) break;
				}
			}
		}
		return $args;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check in the required plugins
if ( !function_exists( 'themerex_learndash_importer_required_plugins' ) ) {
	//add_filter( 'themerex_filter_importer_required_plugins',	'themerex_learndash_importer_required_plugins', 10, 2 );
	function themerex_learndash_importer_required_plugins($not_installed='', $importer=null) {
		if ($importer && in_array('learndash', $importer->options['required_plugins']) && !themerex_exists_learndash() )
			$not_installed .= '<br>LearnDash LMS';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'themerex_learndash_importer_set_options' ) ) {
	//add_filter( 'themerex_filter_importer_options',	'themerex_learndash_importer_set_options' );
	function themerex_learndash_importer_set_options($options=array()) {
		if (is_array($options)) {
			$options['additional_options'][] = 'sfwd_cpt_options';		// Add slugs to export options for this plugin
		}
		return $options;
	}
}
?>