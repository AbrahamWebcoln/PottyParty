<?php
/*
  Plugin Name: Additional Tags
  Description: Create an additional tags author & publisher, team, testimonials, announcements.
  Version: 1.0
  Author: ThemeRex
  Author URI: http://themerex.net
 */

// Additional Tags
// Theme init
if (!function_exists('themerex_additional_tags')) {
    add_action( 'themerex_action_before_init_theme', 'themerex_additional_tags', 10 );
    function themerex_additional_tags() {

        if ( class_exists( 'woocommerce' ) ) {

            // Author tags
            if (!function_exists('themerex_book_author')) {
                function themerex_book_author()
                {

                    themerex_require_data('taxonomy', 'authors', array(
                            'post_type' => array('product'),
                            'hierarchical' => true,
                            'labels' => array(
                                'name' => _x('Authors', 'Taxonomy General Name', 'themerex'),
                                'singular_name' => _x('Author', 'Taxonomy Singular Name', 'themerex'),
                                'menu_name' => __('Author', 'themerex'),
                                'all_items' => __('All Authors', 'themerex'),
                                'parent_item' => __('Parent Author', 'themerex'),
                                'parent_item_colon' => __('Parent Author:', 'themerex'),
                                'new_item_name' => __('New Author Name', 'themerex'),
                                'add_new_item' => __('Add New Author', 'themerex'),
                                'edit_item' => __('Edit Author', 'themerex'),
                                'update_item' => __('Update Author', 'themerex'),
                                'separate_items_with_commas' => __('Separate authors with commas', 'themerex'),
                                'search_items' => __('Search authors', 'themerex'),
                                'add_or_remove_items' => __('Add or remove authors', 'themerex'),
                                'choose_from_most_used' => __('Choose from the most used authors', 'themerex'),
                            ),
                            'show_ui' => true,
                            'show_admin_column' => true,
                            'query_var' => true,
                            'rewrite' => array('slug' => 'authors')
                        )
                    );

                }
            }

            // Hook into the 'init' action
            add_action('init', 'themerex_book_author', 0);


            // Publisher tags

            if (!function_exists('themerex_book_publisher')) {
                function themerex_book_publisher() {

                    themerex_require_data('taxonomy', 'publisher', array(

                            'post_type' => array('product'),
                            'hierarchical' => true,
                            'labels' => array(
                                'name' => _x('Publishers', 'Taxonomy General Name', 'themerex'),
                                'singular_name' => _x('Publisher', 'Taxonomy Singular Name', 'themerex'),
                                'menu_name' => __('Publisher', 'themerex'),
                                'all_items' => __('All Publishers', 'themerex'),
                                'parent_item' => __('Parent Publisher', 'themerex'),
                                'parent_item_colon' => __('Parent Publisher:', 'themerex'),
                                'new_item_name' => __('New Publisher Name', 'themerex'),
                                'add_new_item' => __('Add New Publisher', 'themerex'),
                                'edit_item' => __('Edit Publisher', 'themerex'),
                                'update_item' => __('Update Publisher', 'themerex'),
                                'separate_items_with_commas' => __('Separate publishers with commas', 'themerex'),
                                'search_items' => __('Search publishers ', 'themerex'),
                                'add_or_remove_items' => __('Add or remove publishers ', 'themerex'),
                                'choose_from_most_used' => __('Choose from the most used publishers ', 'themerex'),
                            ),
                            'show_ui' => true,
                            'show_admin_column' => true,
                            'query_var' => true,
                            'rewrite' => array('slug' => 'publisher')
                        )
                    );
                }
            }

            // Hook into the 'init' action
            add_action( 'init', 'themerex_book_publisher', 0 );

        }

    }
}



/*********************************************************************************************************************/










// Team
// Theme init
if (!function_exists('themerex_team_theme_setup')) {
    add_action( 'themerex_action_before_init_theme', 'themerex_team_theme_setup' );
    function themerex_team_theme_setup() {

        // Add item in the admin menu
        add_action('admin_menu',							'themerex_team_add_meta_box');

        // Save data from meta box
        add_action('save_post',								'themerex_team_save_data');

        // Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
        add_filter('themerex_filter_get_blog_type',			'themerex_team_get_blog_type', 9, 2);
        add_filter('themerex_filter_get_blog_title',		'themerex_team_get_blog_title', 9, 2);
        add_filter('themerex_filter_get_current_taxonomy',	'themerex_team_get_current_taxonomy', 9, 2);
        add_filter('themerex_filter_is_taxonomy',			'themerex_team_is_taxonomy', 9, 2);
        add_filter('themerex_filter_get_stream_page_title',	'themerex_team_get_stream_page_title', 9, 2);
        add_filter('themerex_filter_get_stream_page_link',	'themerex_team_get_stream_page_link', 9, 2);
        add_filter('themerex_filter_get_stream_page_id',	'themerex_team_get_stream_page_id', 9, 2);
        add_filter('themerex_filter_query_add_filters',		'themerex_team_query_add_filters', 9, 2);
        add_filter('themerex_filter_detect_inheritance_key','themerex_team_detect_inheritance_key', 9, 1);

        // Extra column for team members lists
        if (themerex_get_theme_option('show_overriden_posts')=='yes') {
            add_filter('manage_edit-team_columns',			'themerex_post_add_options_column', 9);
            add_filter('manage_team_posts_custom_column',	'themerex_post_fill_options_column', 9, 2);
        }

        // Meta box fields
        global $THEMEREX_GLOBALS;
        $THEMEREX_GLOBALS['team_meta_box'] = array(
            'id' => 'team-meta-box',
            'title' => __('Team Member Details', 'themerex'),
            'page' => 'team',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                "team_member_position" => array(
                    "title" => __('Position',  'themerex'),
                    "desc" => __("Position of the team member", 'themerex'),
                    "class" => "team_member_position",
                    "std" => "",
                    "type" => "text"),
                "team_member_email" => array(
                    "title" => __("E-mail",  'themerex'),
                    "desc" => __("E-mail of the team member - need to take Gravatar (if registered)", 'themerex'),
                    "class" => "team_member_email",
                    "std" => "",
                    "type" => "text"),
                "team_member_link" => array(
                    "title" => __('Link to profile',  'themerex'),
                    "desc" => __("URL of the team member profile page (if not this page)", 'themerex'),
                    "class" => "team_member_link",
                    "std" => "",
                    "type" => "text"),
                "team_member_socials" => array(
                    "title" => __("Social links",  'themerex'),
                    "desc" => __("Links to the social profiles of the team member", 'themerex'),
                    "class" => "team_member_email",
                    "std" => "",
                    "type" => "social")
            )
        );

        // Prepare type "Team"
        themerex_require_data( 'post_type', 'team', array(
                'label'               => __( 'Team member', 'themerex' ),
                'description'         => __( 'Team Description', 'themerex' ),
                'labels'              => array(
                    'name'                => _x( 'Team', 'Post Type General Name', 'themerex' ),
                    'singular_name'       => _x( 'Team member', 'Post Type Singular Name', 'themerex' ),
                    'menu_name'           => __( 'Team', 'themerex' ),
                    'parent_item_colon'   => __( 'Parent Item:', 'themerex' ),
                    'all_items'           => __( 'All Team', 'themerex' ),
                    'view_item'           => __( 'View Item', 'themerex' ),
                    'add_new_item'        => __( 'Add New Team member', 'themerex' ),
                    'add_new'             => __( 'Add New', 'themerex' ),
                    'edit_item'           => __( 'Edit Item', 'themerex' ),
                    'update_item'         => __( 'Update Item', 'themerex' ),
                    'search_items'        => __( 'Search Item', 'themerex' ),
                    'not_found'           => __( 'Not found', 'themerex' ),
                    'not_found_in_trash'  => __( 'Not found in Trash', 'themerex' ),
                ),
                'supports'            => array( 'title', 'excerpt', 'editor', 'author', 'thumbnail', 'comments'),
                'hierarchical'        => false,
                'public'              => true,
                'show_ui'             => true,
                'menu_icon'			  => 'dashicons-admin-users',
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 25,
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'query_var'           => true,
                'capability_type'     => 'page',
                'rewrite'             => true
            )
        );

        // Prepare taxonomy for team
        themerex_require_data( 'taxonomy', 'team_group', array(
                'post_type'			=> array( 'team' ),
                'hierarchical'      => true,
                'labels'            => array(
                    'name'              => _x( 'Team Group', 'taxonomy general name', 'themerex' ),
                    'singular_name'     => _x( 'Group', 'taxonomy singular name', 'themerex' ),
                    'search_items'      => __( 'Search Groups', 'themerex' ),
                    'all_items'         => __( 'All Groups', 'themerex' ),
                    'parent_item'       => __( 'Parent Group', 'themerex' ),
                    'parent_item_colon' => __( 'Parent Group:', 'themerex' ),
                    'edit_item'         => __( 'Edit Group', 'themerex' ),
                    'update_item'       => __( 'Update Group', 'themerex' ),
                    'add_new_item'      => __( 'Add New Group', 'themerex' ),
                    'new_item_name'     => __( 'New Group Name', 'themerex' ),
                    'menu_name'         => __( 'Team Group', 'themerex' ),
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'team_group' ),
            )
        );
    }
}

if ( !function_exists( 'themerex_team_settings_theme_setup2' ) ) {
    add_action( 'themerex_action_before_init_theme', 'themerex_team_settings_theme_setup2', 3 );
    function themerex_team_settings_theme_setup2() {
        // Add post type 'team' and taxonomy 'team_group' into theme inheritance list
        themerex_add_theme_inheritance( array('team' => array(
                'stream_template' => 'team',
                'single_template' => 'single-team',
                'taxonomy' => array('team_group'),
                'taxonomy_tags' => array(),
                'post_type' => array('team'),
                'override' => 'post'
            ) )
        );
    }
}


// Add meta box
if (!function_exists('themerex_team_add_meta_box')) {
    //add_action('admin_menu', 'themerex_team_add_meta_box');
    function themerex_team_add_meta_box() {
        global $THEMEREX_GLOBALS;
        $mb = $THEMEREX_GLOBALS['team_meta_box'];
        add_meta_box($mb['id'], $mb['title'], 'themerex_team_show_meta_box', $mb['page'], $mb['context'], $mb['priority']);
    }
}

// Callback function to show fields in meta box
if (!function_exists('themerex_team_show_meta_box')) {
    function themerex_team_show_meta_box() {
        global $post, $THEMEREX_GLOBALS;

        // Use nonce for verification
        $data = get_post_meta($post->ID, 'team_data', true);
        $fields = $THEMEREX_GLOBALS['team_meta_box']['fields'];
        ?>
        <input type="hidden" name="meta_box_team_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)); ?>" />
        <table class="team_area">
            <?php
            foreach ($fields as $id=>$field) {
                $meta = isset($data[$id]) ? $data[$id] : '';
                ?>
                <tr class="team_field <?php echo esc_attr($field['class']); ?>" valign="top">
                    <td><label for="<?php echo esc_attr($id); ?>"><?php echo esc_attr($field['title']); ?></label></td>
                    <td>
                        <?php
                        if ($id == 'team_member_socials') {
                            $upload_info = wp_upload_dir();
                            $upload_url = $upload_info['baseurl'];
                            $social_list = themerex_get_theme_option('social_icons');
                            foreach ($social_list as $soc) {
                                $sn = basename($soc['icon']);
                                $sn = themerex_substr($sn, 0, themerex_strrpos($sn, '.'));
                                if (($pos=themerex_strrpos($sn, '_'))!==false)
                                    $sn = themerex_substr($sn, 0, $pos);
                                $link = isset($meta[$sn]) ? $meta[$sn] : '';
                                ?>
                                <label for="<?php echo esc_attr(($id).'_'.($sn)); ?>"><?php echo esc_attr(themerex_strtoproper($sn)); ?></label><br>
                                <input type="text" name="<?php echo esc_attr($id); ?>[<?php echo esc_attr($sn); ?>]" id="<?php echo esc_attr(($id).'_'.($sn)); ?>" value="<?php echo esc_attr($link); ?>" size="30" /><br>
                            <?php
                            }
                        } else {
                            ?>
                            <input type="text" name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($meta); ?>" size="30" />
                        <?php
                        }
                        ?>
                        <br><small><?php echo esc_attr($field['desc']); ?></small>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    <?php
    }
}


// Save data from meta box
if (!function_exists('themerex_team_save_data')) {
    //add_action('save_post', 'themerex_team_save_data');
    function themerex_team_save_data($post_id) {
        // verify nonce
        if (!isset($_POST['meta_box_team_nonce']) || !wp_verify_nonce($_POST['meta_box_team_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // check permissions
        if ($_POST['post_type']!='team' || !current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        global $THEMEREX_GLOBALS;

        $data = array();

        $fields = $THEMEREX_GLOBALS['team_meta_box']['fields'];

        // Post type specific data handling
        foreach ($fields as $id=>$field) {
            if (isset($_POST[$id])) {
                if (is_array($_POST[$id])) {
                    foreach ($_POST[$id] as $sn=>$link) {
                        $_POST[$id][$sn] = stripslashes($link);
                    }
                    $data[$id] = $_POST[$id];
                } else {
                    $data[$id] = stripslashes($_POST[$id]);
                }
            }
        }

        update_post_meta($post_id, 'team_data', $data);
    }
}



// Return true, if current page is team member page
if ( !function_exists( 'themerex_is_team_page' ) ) {
    function themerex_is_team_page() {
        return get_query_var('post_type')=='team' || is_tax('team_group');
    }
}

// Filter to detect current page inheritance key
if ( !function_exists( 'themerex_team_detect_inheritance_key' ) ) {
    //add_filter('themerex_filter_detect_inheritance_key',	'themerex_team_detect_inheritance_key', 9, 1);
    function themerex_team_detect_inheritance_key($key) {
        if (!empty($key)) return $key;
        return themerex_is_team_page() ? 'team' : '';
    }
}

// Filter to detect current page slug
if ( !function_exists( 'themerex_team_get_blog_type' ) ) {
    //add_filter('themerex_filter_get_blog_type',	'themerex_team_get_blog_type', 9, 2);
    function themerex_team_get_blog_type($page, $query=null) {
        if (!empty($page)) return $page;
        if ($query && $query->is_tax('team_group') || is_tax('team_group'))
            $page = 'team_category';
        else if ($query && $query->get('post_type')=='team' || get_query_var('post_type')=='team')
            $page = $query && $query->is_single() || is_single() ? 'team_item' : 'team';
        return $page;
    }
}

// Filter to detect current page title
if ( !function_exists( 'themerex_team_get_blog_title' ) ) {
    //add_filter('themerex_filter_get_blog_title',	'themerex_team_get_blog_title', 9, 2);
    function themerex_team_get_blog_title($title, $page) {
        if (!empty($title)) return $title;
        if ( themerex_strpos($page, 'team')!==false ) {
            if ( $page == 'team_category' ) {
                $term = get_term_by( 'slug', get_query_var( 'team_group' ), 'team_group', OBJECT);
                $title = $term->name;
            } else if ( $page == 'team_item' ) {
                $title = themerex_get_post_title();
            } else {
                $title = __('All team', 'themerex');
            }
        }

        return $title;
    }
}

// Filter to detect stream page title
if ( !function_exists( 'themerex_team_get_stream_page_title' ) ) {
    //add_filter('themerex_filter_get_stream_page_title',	'themerex_team_get_stream_page_title', 9, 2);
    function themerex_team_get_stream_page_title($title, $page) {
        if (!empty($title)) return $title;
        if (themerex_strpos($page, 'team')!==false) {
            if (($page_id = themerex_team_get_stream_page_id(0, $page)) > 0)
                $title = themerex_get_post_title($page_id);
            else
                $title = __('All team', 'themerex');
        }
        return $title;
    }
}

// Filter to detect stream page ID
if ( !function_exists( 'themerex_team_get_stream_page_id' ) ) {
    //add_filter('themerex_filter_get_stream_page_id',	'themerex_team_get_stream_page_id', 9, 2);
    function themerex_team_get_stream_page_id($id, $page) {
        if (!empty($id)) return $id;
        if (themerex_strpos($page, 'team')!==false) $id = themerex_get_template_page_id('team');
        return $id;
    }
}

// Filter to detect stream page URL
if ( !function_exists( 'themerex_team_get_stream_page_link' ) ) {
    //add_filter('themerex_filter_get_stream_page_link',	'themerex_team_get_stream_page_link', 9, 2);
    function themerex_team_get_stream_page_link($url, $page) {
        if (!empty($url)) return $url;
        if (themerex_strpos($page, 'team')!==false) {
            $id = themerex_get_template_page_id('team');
            if ($id) $url = get_permalink($id);
        }
        return $url;
    }
}

// Filter to detect current taxonomy
if ( !function_exists( 'themerex_team_get_current_taxonomy' ) ) {
    //add_filter('themerex_filter_get_current_taxonomy',	'themerex_team_get_current_taxonomy', 9, 2);
    function themerex_team_get_current_taxonomy($tax, $page) {
        if (!empty($tax)) return $tax;
        if ( themerex_strpos($page, 'team')!==false ) {
            $tax = 'team_group';
        }
        return $tax;
    }
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'themerex_team_is_taxonomy' ) ) {
    //add_filter('themerex_filter_is_taxonomy',	'themerex_team_is_taxonomy', 9, 2);
    function themerex_team_is_taxonomy($tax, $query=null) {
        if (!empty($tax))
            return $tax;
        else
            return $query && $query->get('team_group')!='' || is_tax('team_group') ? 'team_group' : '';
    }
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'themerex_team_query_add_filters' ) ) {
    //add_filter('themerex_filter_query_add_filters',	'themerex_team_query_add_filters', 9, 2);
    function themerex_team_query_add_filters($args, $filter) {
        if ($filter == 'team') {
            $args['post_type'] = 'team';
        }
        return $args;
    }
}


/*********************************************************************************************************************/












// Testimonial
// Theme init
if (!function_exists('themerex_testimonial_theme_setup')) {
    add_action( 'themerex_action_before_init_theme', 'themerex_testimonial_theme_setup' );
    function themerex_testimonial_theme_setup() {

        // Add item in the admin menu
        add_action('admin_menu',			'themerex_testimonial_add_meta_box');

        // Save data from meta box
        add_action('save_post',				'themerex_testimonial_save_data');

        // Meta box fields
        global $THEMEREX_GLOBALS;
        $THEMEREX_GLOBALS['testimonial_meta_box'] = array(
            'id' => 'testimonial-meta-box',
            'title' => __('Testimonial Details', 'themerex'),
            'page' => 'testimonial',
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                "testimonial_author" => array(
                    "title" => __('Testimonial author',  'themerex'),
                    "desc" => __("Name of the testimonial's author", 'themerex'),
                    "class" => "testimonial_author",
                    "std" => "",
                    "type" => "text"),
                "testimonial_email" => array(
                    "title" => __("Author's e-mail",  'themerex'),
                    "desc" => __("E-mail of the testimonial's author - need to take Gravatar (if registered)", 'themerex'),
                    "class" => "testimonial_email",
                    "std" => "",
                    "type" => "text"),
                "testimonial_link" => array(
                    "title" => __('Testimonial link',  'themerex'),
                    "desc" => __("URL of the testimonial source or author profile page", 'themerex'),
                    "class" => "testimonial_link",
                    "std" => "",
                    "type" => "text")
            )
        );

        // Prepare type "Testimonial"
        themerex_require_data( 'post_type', 'testimonial', array(
                'label'               => __( 'Testimonial', 'themerex' ),
                'description'         => __( 'Testimonial Description', 'themerex' ),
                'labels'              => array(
                    'name'                => _x( 'Testimonials', 'Post Type General Name', 'themerex' ),
                    'singular_name'       => _x( 'Testimonial', 'Post Type Singular Name', 'themerex' ),
                    'menu_name'           => __( 'Testimonials', 'themerex' ),
                    'parent_item_colon'   => __( 'Parent Item:', 'themerex' ),
                    'all_items'           => __( 'All Testimonials', 'themerex' ),
                    'view_item'           => __( 'View Item', 'themerex' ),
                    'add_new_item'        => __( 'Add New Testimonial', 'themerex' ),
                    'add_new'             => __( 'Add New', 'themerex' ),
                    'edit_item'           => __( 'Edit Item', 'themerex' ),
                    'update_item'         => __( 'Update Item', 'themerex' ),
                    'search_items'        => __( 'Search Item', 'themerex' ),
                    'not_found'           => __( 'Not found', 'themerex' ),
                    'not_found_in_trash'  => __( 'Not found in Trash', 'themerex' ),
                ),
                'supports'            => array( 'title', 'editor', 'author', 'thumbnail'),
                'hierarchical'        => false,
                'public'              => false,
                'show_ui'             => true,
                'menu_icon'			  => 'dashicons-cloud',
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 25,
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => true,
                'publicly_queryable'  => false,
                'capability_type'     => 'page',
            )
        );

        // Prepare taxonomy for testimonial
        themerex_require_data( 'taxonomy', 'testimonial_group', array(
                'post_type'			=> array( 'testimonial' ),
                'hierarchical'      => true,
                'labels'            => array(
                    'name'              => _x( 'Testimonials Group', 'taxonomy general name', 'themerex' ),
                    'singular_name'     => _x( 'Group', 'taxonomy singular name', 'themerex' ),
                    'search_items'      => __( 'Search Groups', 'themerex' ),
                    'all_items'         => __( 'All Groups', 'themerex' ),
                    'parent_item'       => __( 'Parent Group', 'themerex' ),
                    'parent_item_colon' => __( 'Parent Group:', 'themerex' ),
                    'edit_item'         => __( 'Edit Group', 'themerex' ),
                    'update_item'       => __( 'Update Group', 'themerex' ),
                    'add_new_item'      => __( 'Add New Group', 'themerex' ),
                    'new_item_name'     => __( 'New Group Name', 'themerex' ),
                    'menu_name'         => __( 'Testimonial Group', 'themerex' ),
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'testimonial_group' ),
            )
        );
    }
}


// Add meta box
if (!function_exists('themerex_testimonial_add_meta_box')) {
    //add_action('admin_menu', 'themerex_testimonial_add_meta_box');
    function themerex_testimonial_add_meta_box() {
        global $THEMEREX_GLOBALS;
        $mb = $THEMEREX_GLOBALS['testimonial_meta_box'];
        add_meta_box($mb['id'], $mb['title'], 'themerex_testimonial_show_meta_box', $mb['page'], $mb['context'], $mb['priority']);
    }
}

// Callback function to show fields in meta box
if (!function_exists('themerex_testimonial_show_meta_box')) {
    function themerex_testimonial_show_meta_box() {
        global $post, $THEMEREX_GLOBALS;

        // Use nonce for verification
        echo '<input type="hidden" name="meta_box_testimonial_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

        $data = get_post_meta($post->ID, 'testimonial_data', true);

        $fields = $THEMEREX_GLOBALS['testimonial_meta_box']['fields'];
        ?>
        <table class="testimonial_area">
            <?php
            foreach ($fields as $id=>$field) {
                $meta = isset($data[$id]) ? $data[$id] : '';
                ?>
                <tr class="testimonial_field <?php echo esc_attr($field['class']); ?>" valign="top">
                    <td><label for="<?php echo esc_attr($id); ?>"><?php echo esc_attr($field['title']); ?></label></td>
                    <td><input type="text" name="<?php echo esc_attr($id); ?>" id="<?php echo esc_attr($id); ?>" value="<?php echo esc_attr($meta); ?>" size="30" />
                        <br><small><?php echo esc_attr($field['desc']); ?></small></td>
                </tr>
            <?php
            }
            ?>
        </table>
    <?php
    }
}


// Save data from meta box
if (!function_exists('themerex_testimonial_save_data')) {
    //add_action('save_post', 'themerex_testimonial_save_data');
    function themerex_testimonial_save_data($post_id) {
        // verify nonce
        if (!isset($_POST['meta_box_testimonial_nonce']) || !wp_verify_nonce($_POST['meta_box_testimonial_nonce'], basename(__FILE__))) {
            return $post_id;
        }

        // check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        // check permissions
        if ($_POST['post_type']!='testimonial' || !current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        global $THEMEREX_GLOBALS;

        $data = array();

        $fields = $THEMEREX_GLOBALS['testimonial_meta_box']['fields'];

        // Post type specific data handling
        foreach ($fields as $id=>$field) {
            if (isset($_POST[$id]))
                $data[$id] = stripslashes($_POST[$id]);
        }

        update_post_meta($post_id, 'testimonial_data', $data);
    }
}



/*********************************************************************************************************************/









// attachment manipulations
// Theme init
if ( !function_exists( 'themerex_attachment_settings_theme_setup2' ) ) {
    add_action( 'themerex_action_before_init_theme', 'themerex_attachment_settings_theme_setup2', 3 );
    function themerex_attachment_settings_theme_setup2() {
        themerex_add_theme_inheritance( array('attachment' => array(
                'stream_template' => '',
                'single_template' => 'attachment',
                'taxonomy' => array(),
                'taxonomy_tags' => array(),
                'post_type' => array('attachment'),
                'override' => 'post'
            ) )
        );
    }
}

if (!function_exists('themerex_attachment_theme_setup')) {
    add_action( 'themerex_action_before_init_theme', 'themerex_attachment_theme_setup');
    function themerex_attachment_theme_setup() {

        // Add folders in ajax query
        add_filter('ajax_query_attachments_args',				'themerex_attachment_ajax_query_args');

        // Add folders in filters for js view
        add_filter('media_view_settings',						'themerex_attachment_view_filters');

        // Add folders list in js view compat area
        add_filter('attachment_fields_to_edit',					'themerex_attachment_view_compat');

        // Prepare media folders for save
        add_filter( 'attachment_fields_to_save',				'themerex_attachment_save_compat');

        // Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
        add_filter('themerex_filter_detect_inheritance_key',	'themerex_attachmnent_detect_inheritance_key', 9, 1);

        // Prepare taxonomy for attachment
        themerex_require_data( 'taxonomy', 'media_folder', array(
                'post_type'			=> array( 'attachment' ),
                'hierarchical' 		=> true,
                'labels' 			=> array(
                    'name'              => __('Media Folders', 'themerex'),
                    'singular_name'     => __('Media Folder', 'themerex'),
                    'search_items'      => __('Search Media Folders', 'themerex'),
                    'all_items'         => __('All Media Folders', 'themerex'),
                    'parent_item'       => __('Parent Media Folder', 'themerex'),
                    'parent_item_colon' => __('Parent Media Folder:', 'themerex'),
                    'edit_item'         => __('Edit Media Folder', 'themerex'),
                    'update_item'       => __('Update Media Folder', 'themerex'),
                    'add_new_item'      => __('Add New Media Folder', 'themerex'),
                    'new_item_name'     => __('New Media Folder Name', 'themerex'),
                    'menu_name'         => __('Media Folders', 'themerex'),
                ),
                'query_var'			=> true,
                'rewrite' 			=> true,
                'show_admin_column'	=> true
            )
        );
    }
}


// Add folders in ajax query
if (!function_exists('themerex_attachment_ajax_query_args')) {
    //add_filter('ajax_query_attachments_args', 'themerex_attachment_ajax_query_args');
    function themerex_attachment_ajax_query_args($query) {
        if (isset($query['post_mime_type'])) {
            $v = $query['post_mime_type'];
            if (themerex_substr($v, 0, 13)=='media_folder.') {
                unset($query['post_mime_type']);
                if (themerex_strlen($v) > 13)
                    $query['media_folder'] = themerex_substr($v, 13);
                else {
                    $list_ids = array();
                    $terms = themerex_get_terms_by_taxonomy('media_folder');
                    if (count($terms) > 0) {
                        foreach ($terms as $term) {
                            $list_ids[] = $term->term_id;
                        }
                    }
                    if (count($list_ids) > 0) {
                        $query['tax_query'] = array(
                            array(
                                'taxonomy' => 'media_folder',
                                'field' => 'id',
                                'terms' => $list_ids,
                                'operator' => 'NOT IN'
                            )
                        );
                    }
                }
            }
        }
        return $query;
    }
}

// Add folders in filters for js view
if (!function_exists('themerex_attachment_view_filters')) {
    //add_filter('media_view_settings', 'themerex_attachment_view_filters');
    function themerex_attachment_view_filters($settings, $post=null) {
        $taxes = array('media_folder');
        foreach ($taxes as $tax) {
            $terms = themerex_get_terms_by_taxonomy($tax);
            if (count($terms) > 0) {
                $settings['mimeTypes'][$tax.'.'] = __('Media without folders', 'themerex');
                $settings['mimeTypes'] = array_merge($settings['mimeTypes'], themerex_get_terms_hierarchical_list($terms, array(
                        'prefix_key' => 'media_folder.',
                        'prefix_level' => '-'
                    )
                ));
            }
        }
        return $settings;
    }
}

// Add folders list in js view compat area
if (!function_exists('themerex_attachment_view_compat')) {
    //add_filter('attachment_fields_to_edit', 'themerex_attachment_view_compat');
    function themerex_attachment_view_compat($form_fields, $post=null) {
        static $terms = null, $id = 0;
        if (isset($form_fields['media_folder'])) {
            $field = $form_fields['media_folder'];
            if (!$terms) {
                $terms = themerex_get_terms_by_taxonomy('media_folder', array(
                    'hide_empty' => false
                ));
                $terms = themerex_get_terms_hierarchical_list($terms, array(
                    'prefix_key' => 'media_folder.',
                    'prefix_level' => '-'
                ));
            }
            $values = array_map('trim', explode(',', $field['value']));
            $readonly = ''; //! $user_can_edit && ! empty( $field['taxonomy'] ) ? " readonly='readonly' " : '';
            $required = !empty($field['required']) ? '<span class="alignright"><abbr title="required" class="required">*</abbr></span>' : '';
            $aria_required = !empty($field['required']) ? " aria-required='true' " : '';
            $html = '';
            if (count($terms) > 0) {
                foreach ($terms as $slug=>$name) {
                    $id++;
                    $slug = themerex_substr($slug, 13);
                    $html .= ($html ? '<br />' : '') . '<input type="checkbox" class="text" id="media_folder_'.esc_attr($id).'" name="media_folder_' . esc_attr($slug) . '" value="' . esc_attr( $slug ) . '"' . (in_array($slug, $values) ? ' checked="checked"' : '' ) . ' ' . ($readonly) . ' ' . ($aria_required) . ' /><label for="media_folder_'.esc_attr($id).'"> ' . ($name) . '</label>';
                }
            }
            $form_fields['media_folder']['input'] = 'media_folder_input';
            $form_fields['media_folder']['media_folder_input'] = '<div class="media_folder_selector">' . ($html) . '</div>';
        }
        return $form_fields;
    }
}

// Prepare media folders for save
if (!function_exists('themerex_attachment_save_compat')) {
    //add_filter( 'attachment_fields_to_save', 'themerex_attachment_save_compat');
    function themerex_attachment_save_compat($post=null, $attachment_data=null) {
        if (!empty($post['ID']) && ($id = intval($post['ID'])) > 0) {
            $folders = array();
            $from_media_library = !empty($_REQUEST['tax_input']['media_folder']) && is_array($_REQUEST['tax_input']['media_folder']);
            // From AJAX query
            if (!$from_media_library) {
                foreach ($_REQUEST as $k => $v) {
                    if (themerex_substr($k, 0, 12)=='media_folder')
                        $folders[] = $v;
                }
            } else {
                if (count($folders)==0) {
                    if (!empty($_REQUEST['tax_input']['media_folder']) && is_array($_REQUEST['tax_input']['media_folder'])) {
                        foreach ($_REQUEST['tax_input']['media_folder'] as $k => $v) {
                            if ((int)$v > 0)
                                $folders[] = $v;
                        }
                    }
                }
            }
            if (count($folders) > 0) {
                foreach ($folders as $k=>$v) {
                    if ((int) $v > 0) {
                        $term = get_term_by('id', $v, 'media_folder');
                        $folders[$k] = $term->slug;
                    }
                }
            } else
                $folders = null;
            // Save folders list only from AJAX
            if (!$from_media_library)
                wp_set_object_terms( $id, $folders, 'media_folder', false );
        }
        return $post;
    }
}


// Filter to detect current page inheritance key
if ( !function_exists( 'themerex_attachmnent_detect_inheritance_key' ) ) {
    //add_filter('themerex_filter_detect_inheritance_key',	'themerex_attachmnent_detect_inheritance_key', 9, 1);
    function themerex_attachmnent_detect_inheritance_key($key) {
        if (!empty($key)) return $key;
        return is_attachment() ? 'attachment' : '';
    }
}



/*********************************************************************************************************************/









// Courses
// Theme init
if (!function_exists('themerex_courses_theme_setup')) {
    add_action( 'themerex_action_before_init_theme', 'themerex_courses_theme_setup' );
    function themerex_courses_theme_setup() {

        // Add post specific actions and filters
        global $THEMEREX_GLOBALS;
        if (isset($THEMEREX_GLOBALS['post_meta_box']) && $THEMEREX_GLOBALS['post_meta_box']['page']=='courses') {
            add_action('admin_enqueue_scripts',							'themerex_courses_admin_scripts');
            add_action('themerex_action_post_before_show_meta_box',		'themerex_courses_before_show_meta_box', 10, 2);
            add_action('themerex_action_post_after_show_meta_box',		'themerex_courses_after_show_meta_box', 10, 2);
            add_filter('themerex_filter_post_load_custom_options',		'themerex_courses_load_custom_options', 10, 3);
            add_filter('themerex_filter_post_save_custom_options',		'themerex_courses_save_custom_options', 10, 3);
            add_filter('themerex_filter_post_show_custom_field_option',	'themerex_courses_show_custom_field_option', 10, 4);
        }

        // Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
        add_filter('themerex_filter_get_blog_type',						'themerex_courses_get_blog_type', 9, 2);
        add_filter('themerex_filter_get_blog_title',					'themerex_courses_get_blog_title', 9, 2);
        add_filter('themerex_filter_get_current_taxonomy',				'themerex_courses_get_current_taxonomy', 9, 2);
        add_filter('themerex_filter_is_taxonomy',						'themerex_courses_is_taxonomy', 9, 2);
        add_filter('themerex_filter_get_period_links',					'themerex_courses_get_period_links', 9, 3);
        add_filter('themerex_filter_get_stream_page_title',				'themerex_courses_get_stream_page_title', 9, 2);
        add_filter('themerex_filter_get_stream_page_link',				'themerex_courses_get_stream_page_link', 9, 2);
        add_filter('themerex_filter_get_stream_page_id',				'themerex_courses_get_stream_page_id', 9, 2);
        add_filter('themerex_filter_query_add_filters',					'themerex_courses_query_add_filters', 9, 2);
        add_filter('themerex_filter_related_posts_args',				'themerex_courses_related_posts_args', 9, 2);
        add_filter('themerex_filter_related_posts_title',				'themerex_courses_related_posts_title', 9, 2);
        add_filter('themerex_filter_detect_inheritance_key',			'themerex_courses_detect_inheritance_key', 9, 1);
        add_filter('themerex_filter_list_post_types', 					'themerex_courses_list_post_types', 10, 1);
        add_filter('themerex_filter_post_date',		 					'themerex_courses_post_date', 9, 3);

        if (themerex_get_theme_option('show_courses_in_blog')=='yes') {
            // Advanced Calendar filters
            add_filter('themerex_filter_calendar_get_prev_month',		'themerex_courses_calendar_get_prev_month', 9, 2);
            add_filter('themerex_filter_calendar_get_next_month',		'themerex_courses_calendar_get_next_month', 9, 2);
            add_filter('themerex_filter_calendar_get_curr_month_posts',	'themerex_courses_calendar_get_curr_month_posts', 9, 2);
            // Add Main Query parameters
            add_filter( 'posts_join',									'themerex_courses_posts_join', 10, 2 );
            add_filter( 'getarchives_join',								'themerex_courses_getarchives_join', 10, 2 );
            add_filter( 'posts_where',									'themerex_courses_posts_where', 10, 2 );
            add_filter( 'getarchives_where',							'themerex_courses_getarchives_where', 10, 2 );
        }

        // Extra column for courses lists
        if (themerex_get_theme_option('show_overriden_posts')=='yes') {
            add_filter('manage_edit-courses_columns',			'themerex_post_add_options_column', 9);
            add_filter('manage_courses_posts_custom_column',	'themerex_post_fill_options_column', 9, 2);
        }

        // Prepare type "Courses"
        themerex_require_data( 'post_type', 'courses', array(
                'label'               => __( 'Announcement item', 'themerex' ),
                'description'         => __( 'Announcement Description', 'themerex' ),
                'labels'              => array(
                    'name'                => _x( 'Announcements', 'Post Type General Name', 'themerex' ),
                    'singular_name'       => _x( 'Announcement item', 'Post Type Singular Name', 'themerex' ),
                    'menu_name'           => __( 'Announcements', 'themerex' ),
                    'parent_item_colon'   => __( 'Parent Item:', 'themerex' ),
                    'all_items'           => __( 'All Announcements', 'themerex' ),
                    'view_item'           => __( 'View Item', 'themerex' ),
                    'add_new_item'        => __( 'Add New Announcement item', 'themerex' ),
                    'add_new'             => __( 'Add New', 'themerex' ),
                    'edit_item'           => __( 'Edit Item', 'themerex' ),
                    'update_item'         => __( 'Update Item', 'themerex' ),
                    'search_items'        => __( 'Search Item', 'themerex' ),
                    'not_found'           => __( 'Not found', 'themerex' ),
                    'not_found_in_trash'  => __( 'Not found in Trash', 'themerex' ),
                ),
                'supports'            => array( 'title', 'excerpt', 'editor', 'author', 'thumbnail', 'comments'),
                'hierarchical'        => false,
                'public'              => true,
                'show_ui'             => true,
                'menu_icon'			  => 'dashicons-format-chat',
                'show_in_menu'        => true,
                'show_in_nav_menus'   => true,
                'show_in_admin_bar'   => true,
                'menu_position'       => 25,
                'can_export'          => true,
                'has_archive'         => false,
                'exclude_from_search' => false,
                'publicly_queryable'  => true,
                'query_var'           => true,
                'capability_type'     => 'post',
                'rewrite'             => true
            )
        );

        // Prepare taxonomy for courses
        // Courses groups (categories)
        themerex_require_data( 'taxonomy', 'courses_group', array(
                'post_type'			=> array( 'courses' ),
                'hierarchical'      => true,
                'labels'            => array(
                    'name'              => _x( 'Announcements Groups', 'taxonomy general name', 'themerex' ),
                    'singular_name'     => _x( 'Announcements Group', 'taxonomy singular name', 'themerex' ),
                    'search_items'      => __( 'Search Groups', 'themerex' ),
                    'all_items'         => __( 'All Groups', 'themerex' ),
                    'parent_item'       => __( 'Parent Group', 'themerex' ),
                    'parent_item_colon' => __( 'Parent Group:', 'themerex' ),
                    'edit_item'         => __( 'Edit Group', 'themerex' ),
                    'update_item'       => __( 'Update Group', 'themerex' ),
                    'add_new_item'      => __( 'Add New Group', 'themerex' ),
                    'new_item_name'     => __( 'New Group Name', 'themerex' ),
                    'menu_name'         => __( 'Announcements Groups', 'themerex' ),
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'courses_group' ),
            )
        );

        // Courses tags
        themerex_require_data( 'taxonomy', 'courses_tag', array(
                'post_type'			=> array( 'courses' ),
                'hierarchical'      => false,
                'labels'            => array(
                    'name'              => _x( 'Announcements Tags', 'taxonomy general name', 'themerex' ),
                    'singular_name'     => _x( 'Announcements Tag', 'taxonomy singular name', 'themerex' ),
                    'search_items'      => __( 'Search Tags', 'themerex' ),
                    'all_items'         => __( 'All Tags', 'themerex' ),
                    'parent_item'       => __( 'Parent Tag', 'themerex' ),
                    'parent_item_colon' => __( 'Parent Tag:', 'themerex' ),
                    'edit_item'         => __( 'Edit Tag', 'themerex' ),
                    'update_item'       => __( 'Update Tag', 'themerex' ),
                    'add_new_item'      => __( 'Add New Tag', 'themerex' ),
                    'new_item_name'     => __( 'New Tag Name', 'themerex' ),
                    'menu_name'         => __( 'Announcements Tags', 'themerex' ),
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'courses_tag' ),
            )
        );
    }
}

if ( !function_exists( 'themerex_courses_settings_theme_setup2' ) ) {
    add_action( 'themerex_action_before_init_theme', 'themerex_courses_settings_theme_setup2', 3 );
    function themerex_courses_settings_theme_setup2() {

        // Add post type 'courses' and taxonomies 'courses_group' and 'courses_tag' into theme inheritance list
        themerex_add_theme_inheritance( array('courses' => array(
                'stream_template' => 'courses',
                'single_template' => 'single-courses',
                'taxonomy' => array('courses_group'),
                'taxonomy_tags' => array('courses_tag'),
                'post_type' => array('courses', 'lesson'),
                'override' => 'page'
            ) )
        );

        // Add WooCommerce specific options in the Theme Options
        global $THEMEREX_GLOBALS;

        themerex_array_insert_before($THEMEREX_GLOBALS['options'], 'partition_reviews', array(

                "partition_courses" => array(
                    "title" => __('Announcements', 'themerex'),
                    "icon" => "iconadmin-users",
                    "override" => "courses_group",
                    "type" => "partition"),

                "info_courses_1" => array(
                    "title" => __('Announcements settings', 'themerex'),
                    "desc" => __('Set up announcements posts behaviour in the blog.', 'themerex'),
                    "override" => "courses_group",
                    "type" => "info"),

                "show_courses_in_blog" => array(
                    "title" => __('Show announcements in the blog',  'themerex'),
                    "desc" => __("Show announcements in stream pages (blog, archives) or only in special pages", 'themerex'),
                    "divider" => false,
                    "std" => "yes",
                    "options" => $THEMEREX_GLOBALS['options_params']['list_yes_no'],
                    "type" => "switch"),

                "show_countdown" => array(
                    "title" => __('Show countdown',  'themerex'),
                    "desc" => __("Show countdown section with time to class start", 'themerex'),
                    "std" => "1",
                    "override" => "courses_group",
                    "style" => "horizontal",
                    "options" => array(
                        0 => __('Hide', 'themerex'),
                        1 => __('Type 1', 'themerex'),
                        2 => __('Type 2', 'themerex')
                    ),
                    "dir" => "horizontal",
                    "type" => "checklist")
            )
        );

    }
}


if (!function_exists('themerex_courses_after_theme_setup')) {
    add_action( 'themerex_action_after_init_theme', 'themerex_courses_after_theme_setup' );
    function themerex_courses_after_theme_setup() {
        // Update fields in the meta box
        global $THEMEREX_GLOBALS;
        if (isset($THEMEREX_GLOBALS['post_meta_box']) && $THEMEREX_GLOBALS['post_meta_box']['page']=='courses') {
            // Meta box fields
            $THEMEREX_GLOBALS['post_meta_box']['title'] = __('Announcement Options', 'themerex');
            $THEMEREX_GLOBALS['post_meta_box']['fields'] = array(
                "mb_partition_courses" => array(
                    "title" => __('Announcements', 'themerex'),
                    "override" => "page,post",
                    "divider" => false,
                    "icon" => "iconadmin-users-1",
                    "type" => "partition"),
                "mb_info_courses_1" => array(
                    "title" => __('Announcement details', 'themerex'),
                    "override" => "page,post",
                    "divider" => false,
                    "desc" => __('In this section you can put details for this announcement', 'themerex'),
                    "class" => "course_meta",
                    "type" => "info"),
                "date_start" => array(
                    "title" => __('Date start',  'themerex'),
                    "desc" => __("Class start date", 'themerex'),
                    "override" => "page,post",
                    "class" => "course_date",
                    "std" => date('Y-m-d'),
                    "format" => 'yy-mm-dd',
                    "type" => "date"),
                "date_end" => array(
                    "title" => __('Date end',  'themerex'),
                    "desc" => __("Class end date", 'themerex'),
                    "override" => "page,post",
                    "class" => "course_date",
                    "std" => date('Y-m-d', strtotime('+1 month')),
                    "format" => 'yy-mm-dd',
                    "divider" => false,
                    "type" => "date"),
                "shedule" => array(
                    "title" => __('Shedule time',  'themerex'),
                    "desc" => __("Class start days and time. For example: Mon, Wed, Fri 19:00-21:00", 'themerex'),
                    "override" => "page,post",
                    "class" => "course_time",
                    "std" => '',
                    "divider" => false,
                    "type" => "text"),
                "partition_reviews" => array(
                    "title" => __('Reviews', 'themerex'),
                    "override" => "page,post",
                    "divider" => false,
                    "icon" => "iconadmin-newspaper",
                    "type" => "partition"),
                "info_reviews_1" => array(
                    "title" => __('Reviews criterias for this announcement', 'themerex'),
                    "override" => "page,post",
                    "divider" => false,
                    "desc" => __('In this section you can put your reviews marks for this announcement', 'themerex'),
                    "class" => "reviews_meta",
                    "type" => "info"),
                "show_reviews" => array(
                    "title" => __('Show reviews block',  'themerex'),
                    "desc" => __("Show reviews block on single post page and average reviews rating after post's title in stream pages", 'themerex'),
                    "override" => "page,post",
                    "class" => "reviews_meta",
                    "std" => "inherit",
                    "divider" => false,
                    "style" => "horizontal",
                    "options" => themerex_get_list_yesno(),
                    "type" => "radio"),
                "reviews_marks" => array(
                    "title" => __('Reviews marks',  'themerex'),
                    "override" => "page,post",
                    "desc" => __("Marks for this review", 'themerex'),
                    "class" => "reviews_meta reviews_tab reviews_users",
                    "std" => "",
                    "options" => themerex_get_custom_option('reviews_criterias'),
                    "type" => "reviews")
            );
        }
    }
}


// Admin scripts
if (!function_exists('themerex_courses_admin_scripts')) {
    //add_action('admin_enqueue_scripts', 'themerex_courses_admin_scripts');
    function themerex_courses_admin_scripts() {
        global $THEMEREX_GLOBALS;
        if (isset($THEMEREX_GLOBALS['post_meta_box']) && $THEMEREX_GLOBALS['post_meta_box']['page']=='courses')
            themerex_enqueue_script( 'themerex-core-reviews-script', themerex_get_file_url('js/core.reviews.js'), array('jquery'), null, true );
    }
}


// Open reviews container before Theme options block
if (!function_exists('themerex_courses_before_show_meta_box')) {
//add_action('themerex_action_post_before_show_meta_box', 'themerex_courses_before_show_meta_box', 10, 2);
function themerex_courses_before_show_meta_box($post_type, $post_id) {
$max_level = max(5, (int) themerex_get_theme_option('reviews_max_level'));
?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            // Prepare global values for the review procedure
            THEMEREX_GLOBALS['reviews_levels']			= "<?php echo trim(themerex_get_theme_option('reviews_criterias_levels')); ?>";
            THEMEREX_GLOBALS['reviews_max_level'] 		= <?php echo (int) $max_level; ?>;
            THEMEREX_GLOBALS['reviews_allow_user_marks']= true;
        });
    </script>
<div class="reviews_area reviews_<?php echo esc_attr($max_level); ?>">
    <?php
    }
    }


    // Close reviews container after Theme options block
    if (!function_exists('themerex_courses_after_show_meta_box')) {
    //add_action('themerex_action_courses_after_show_meta_box', 'themerex_courses_after_show_meta_box', 10, 2);
    function themerex_courses_after_show_meta_box($post_type, $post_id) {
    ?>
</div>
<?php
}
}


// Load custom options filter - prepare reviews marks
if (!function_exists('themerex_courses_load_custom_options')) {
    //add_filter('themerex_filter_post_load_custom_options', 'themerex_courses_load_custom_options', 10, 3);
    function themerex_courses_load_custom_options($custom_options, $post_type, $post_id) {
        if (isset($custom_options['reviews_marks']))
            $custom_options['reviews_marks'] = themerex_reviews_marks_to_display($custom_options['reviews_marks']);
        return $custom_options;
    }
}

// Before show reviews field - add taxonomy specific criterias
if (!function_exists('themerex_courses_show_custom_field_option')) {
    //add_filter('themerex_filter_post_show_custom_field_option',	'themerex_courses_show_custom_field_option', 10, 4);
    function themerex_courses_show_custom_field_option($option, $id, $post_type, $post_id) {
        if ($id == 'reviews_marks') {
            $cat_list = themerex_get_terms_by_post_id(array(
                    'taxonomy' => 'courses_group',
                    'post_id' => $post_id
                )
            );
            if (!empty($cat_list['courses_group']->terms)) {
                foreach ($cat_list['courses_group']->terms as $cat) {
                    $term_id = (int) $cat->term_id;
                    $prop = themerex_taxonomy_get_inherited_property('courses_group', $term_id, 'reviews_criterias');
                    if (!empty($prop) && !themerex_is_inherit_option($prop)) {
                        $option['options'] = $prop;
                        break;
                    }
                }
            }
        }
        return $option;
    }
}

// Before save custom options - calc and save average rating
if (!function_exists('themerex_courses_save_custom_options')) {
    //add_filter('themerex_filter_post_save_custom_options',	'themerex_courses_save_custom_options', 10, 3);
    function themerex_courses_save_custom_options($custom_options, $post_type, $post_id) {
        if (isset($custom_options['reviews_marks'])) {
            if (($avg = themerex_reviews_get_average_rating($custom_options['reviews_marks'])) > 0)
                update_post_meta($post_id, 'reviews_avg', $avg);
        }
        if (isset($custom_options['teacher'])) {
            update_post_meta($post_id, 'teacher', $custom_options['teacher']);
        }
        if (isset($custom_options['date_start'])) {
            update_post_meta($post_id, 'date_start', $custom_options['date_start']);
        }
        if (isset($custom_options['date_end'])) {
            update_post_meta($post_id, 'date_end', $custom_options['date_end']);
        }
        return $custom_options;
    }
}




// Return true, if current page is single post page or category archive or blog stream page
if ( !function_exists( 'themerex_is_courses_page' ) ) {
    function themerex_is_courses_page() {
        return in_array(get_query_var('post_type'), array('courses', 'lesson')) || is_tax('courses_group') || is_tax('courses_tag') || (is_page() && themerex_get_template_page_id('courses')==get_the_ID());
    }
}

// Filter to detect current page inheritance key
if ( !function_exists( 'themerex_courses_detect_inheritance_key' ) ) {
    //add_filter('themerex_filter_detect_inheritance_key',	'themerex_courses_detect_inheritance_key', 9, 1);
    function themerex_courses_detect_inheritance_key($key) {
        if (!empty($key)) return $key;
        return themerex_is_courses_page() ? 'courses' : '';
    }
}

// Filter to detect current page slug
if ( !function_exists( 'themerex_courses_get_blog_type' ) ) {
    //add_filter('themerex_filter_get_blog_type',	'themerex_courses_get_blog_type', 9, 2);
    function themerex_courses_get_blog_type($page, $query=null) {
        if (!empty($page)) return $page;
        if ($query && $query->is_tax('courses_group') || is_tax('courses_group'))
            $page = 'courses_category';
        else if ($query && $query->is_tax('courses_tag') || is_tax('courses_tag'))
            $page = 'courses_tag';
        else if ($query && $query->get('post_type')=='courses' || get_query_var('post_type')=='courses')
            $page = $query && $query->is_single() || is_single() ? 'courses_item' : 'courses';
        else if ($query && $query->get('post_type')=='lesson' || get_query_var('post_type')=='lesson')
            $page = $query && $query->is_single() || is_single() ? 'courses_lesson' : 'courses';
        return $page;
    }
}

// Filter to detect current page title
if ( !function_exists( 'themerex_courses_get_blog_title' ) ) {
    //add_filter('themerex_filter_get_blog_title',	'themerex_courses_get_blog_title', 9, 2);
    function themerex_courses_get_blog_title($title, $page) {
        if (!empty($title)) return $title;
        if ( $page == 'archives_day' && get_post_type()=='courses' ) {
            $dt = strtotime(get_post_meta(get_the_ID(), 'date_start', true));
            $title = sprintf( __( 'Daily Archives: %s', 'themerex' ), themerex_get_date_translations(date( get_option('date_format'), $dt )) );
        } else if ( $page == 'archives_month' && get_post_type()=='courses' ) {
            $dt = strtotime(get_post_meta(get_the_ID(), 'date_start', true));
            $title = sprintf( __( 'Monthly Archives: %s', 'themerex' ), themerex_get_date_translations(date( 'F Y', $dt )) );
        } else if ( $page == 'archives_year' && get_post_type()=='courses' ) {
            $dt = strtotime(get_post_meta(get_the_ID(), 'date_start', true));
            $title = sprintf( __( 'Yearly Archives: %s', 'themerex' ), date( 'Y', $dt ) );
        } else if ( themerex_strpos($page, 'courses')!==false ) {
            if ( $page == 'courses_category' ) {
                $term = get_term_by( 'slug', get_query_var( 'courses_group' ), 'courses_group', OBJECT);
                $title = $term->name;
            } else if ( $page == 'courses_tag' ) {
                $term = get_term_by( 'slug', get_query_var( 'courses_tag' ), 'courses_tag', OBJECT);
                $title = __('Tag:', 'themerex') . ' ' . ($term->name);
            } else if ( $page == 'courses_item' || $page == 'courses_lesson' ) {
                $title = themerex_get_post_title();
            } else if (($page_id = themerex_get_template_page_id($page)) > 0) {
                $title = themerex_get_post_title($page_id);
            } else {
                $title = __('All announcements', 'themerex');
            }
        }
        return $title;
    }
}

// Filter to detect stream page title
if ( !function_exists( 'themerex_courses_get_stream_page_title' ) ) {
    //add_filter('themerex_filter_get_stream_page_title',	'themerex_courses_get_stream_page_title', 9, 2);
    function themerex_courses_get_stream_page_title($title, $page) {
        if (!empty($title)) return $title;
        if (themerex_strpos($page, 'courses')!==false) {
            if (($page_id = themerex_courses_get_stream_page_id(0, $page)) > 0)
                $title = themerex_get_post_title($page_id);
            else
                $title = __('All announcements', 'themerex');
        }
        return $title;
    }
}

// Filter to detect stream page ID
if ( !function_exists( 'themerex_courses_get_stream_page_id' ) ) {
    //add_filter('themerex_filter_get_stream_page_id',	'themerex_courses_get_stream_page_id', 9, 2);
    function themerex_courses_get_stream_page_id($id, $page) {
        if (!empty($id)) return $id;
        if (themerex_strpos($page, 'courses')!==false) $id = themerex_get_template_page_id('courses');
        return $id;
    }
}

// Filter to detect stream page URL
if ( !function_exists( 'themerex_courses_get_stream_page_link' ) ) {
    //add_filter('themerex_filter_get_stream_page_link', 'themerex_courses_get_stream_page_link', 9, 2);
    function themerex_courses_get_stream_page_link($url, $page) {
        if (!empty($url)) return $url;
        if (themerex_strpos($page, 'courses')!==false) {
            $id = themerex_get_template_page_id('courses');
            $url = get_permalink($id);
        }
        return $url;
    }
}

// Filter to detect taxonomy name (slug) for the current post, category, blog
if ( !function_exists( 'themerex_courses_get_current_taxonomy' ) ) {
    //add_filter('themerex_filter_get_current_taxonomy',	'themerex_courses_get_current_taxonomy', 9, 2);
    function themerex_courses_get_current_taxonomy($tax, $page) {
        if (!empty($tax)) return $tax;
        if ( themerex_strpos($page, 'courses')!==false ) {
            $tax = 'courses_group';
        }
        return $tax;
    }
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'themerex_courses_is_taxonomy' ) ) {
    //add_filter('themerex_filter_is_taxonomy',	'themerex_courses_is_taxonomy', 10, 2);
    function themerex_courses_is_taxonomy($tax, $query=null) {
        if (!empty($tax))
            return $tax;
        else
            return $query && $query->get('courses_group')!='' || is_tax('courses_group') ? 'courses_group' : '';
    }
}

// Filter to return breadcrumbs links to the parent period
if ( !function_exists( 'themerex_courses_get_period_links' ) ) {
    //add_filter('themerex_filter_get_period_links',	'themerex_courses_get_period_links', 9, 3);
    function themerex_courses_get_period_links($links, $page, $delimiter='') {
        if (!empty($links)) return $links;
        global $post;
        if (in_array($page, array('archives_day', 'archives_month')) && is_object($post) && get_post_type()=='courses') {
            $dt = strtotime(get_post_meta(get_the_ID(), 'date_start', true));
            $year  = date('Y', $dt);
            $month = date('m', $dt);
            $links = '<a class="breadcrumbs_item cat_parent" href="' . get_year_link( $year ) . '">' . ($year) . '</a>';
            if ($page == 'archives_day')
                $links .= (!empty($links) ? $delimiter : '') . '<a class="breadcrumbs_item cat_parent" href="' . get_month_link( $year, $month ) . '">' . trim(themerex_get_date_translations(date('F', $dt))) . '</a>';
        }
        return $links;
    }
}

// Add custom post type and/or taxonomies arguments to the query
if ( !function_exists( 'themerex_courses_query_add_filters' ) ) {
    //add_filter('themerex_filter_query_add_filters',	'themerex_courses_query_add_filters', 9, 2);
    function themerex_courses_query_add_filters($args, $filter) {
        if ($filter == 'courses') {
            $args['post_type'] = 'courses';
        }
        return $args;
    }
}

// Change query args to show related courses for teacher
if ( !function_exists( 'themerex_courses_related_posts_args' ) ) {
    //add_filter('themerex_filter_related_posts_args',	'themerex_courses_related_posts_args', 9, 2);
    function themerex_courses_related_posts_args($args, $post_data) {
        if ($post_data['post_type'] == 'team') {
            $args['post_type'] = 'courses';
            if (empty($args['meta_query'])) $args['meta_query'] = array();
            $args['meta_query']['relation'] = 'AND';
            $args['meta_query'][] = array(
                'meta_filter' => 'teacher',
                'key' => 'teacher',
                'value' => $post_data['post_id'],
                'compare' => '=',
                'type' => 'NUMERIC'
            );
            $args['meta_query'][] = array(
                'meta_filter' => 'date_start',
                'key' => 'date_start',
                'value' => date('Y-m-d'),
                'compare' => '<=',
                'type' => 'DATE'
            );
            $args['meta_query'][] = array(
                'meta_filter' => 'date_end',
                'key' => 'date_end',
                'value' => date('Y-m-d'),
                'compare' => '>=',
                'type' => 'DATE'
            );
            unset($args['post__not_in']);
            if (!empty($args['tax_query'])) {
                foreach ($args['tax_query'] as $k=>$v) {
                    if (!empty($v['taxonomy']) && themerex_strpos($v['taxonomy'], 'team')!==false) {
                        unset($args['tax_query'][$k]);
                    }
                }
            }
        } else if ($post_data['post_type'] == 'lesson') {
            $args['post_type'] = 'lesson';
            $parent_course = get_post_meta($post_data['post_id'], 'parent_course', true);
            if (empty($args['meta_query'])) $args['meta_query'] = array();
            $args['meta_query']['relation'] = 'AND';
            $args['meta_query'][] = array(
                'meta_filter' => 'lesson',
                'key' => 'parent_course',
                'value' => $parent_course,
                'compare' => '=',
                'type' => 'NUMERIC'
            );
            if (!empty($args['tax_query'])) {
                foreach ($args['tax_query'] as $k=>$v) {
                    if (!empty($v['taxonomy']) && themerex_strpos($v['taxonomy'], 'team')!==false) {
                        unset($args['tax_query'][$k]);
                    }
                }
            }
        }
        return $args;
    }
}

// Return related posts title
if ( !function_exists( 'themerex_courses_related_posts_title' ) ) {
    //add_filter('themerex_filter_related_posts_title',	'themerex_courses_related_posts_title', 9, 2);
    function themerex_courses_related_posts_title($title, $post_type) {
        if ($post_type == 'team')
            $title = __('Currently Teaching', 'themerex');
        else if ($post_type == 'courses')
            $title = __('Related Announcements', 'themerex');
        else if ($post_type == 'lesson')
            $title = __('Related Lessons', 'themerex');
        return $title;
    }
}

// Add custom post type into list
if ( !function_exists( 'themerex_courses_list_post_types' ) ) {
    //add_filter('themerex_filter_list_post_types', 	'themerex_courses_list_post_types', 10, 1);
    function themerex_courses_list_post_types($list) {
        $list['courses'] = __('Announcements', 'themerex');
        return $list;
    }
}


// Return previous month and year with published posts
if ( !function_exists( 'themerex_courses_calendar_get_prev_month' ) ) {
    //add_filter('themerex_filter_calendar_get_prev_month',	'themerex_courses_calendar_get_prev_month', 9, 2);
    function themerex_courses_calendar_get_prev_month($prev, $opt) {
        if (!empty($opt['posts_types']) && !in_array('courses', $opt['posts_types'])) return;
        if (!empty($prev['done']) && in_array('courses', $prev['done'])) return;
        $args = array(
            'post_type' => 'courses',
            'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
            'posts_per_page' => 1,
            'ignore_sticky_posts' => true,
            'orderby' => 'meta_value',
            'meta_key' => 'date_start',
            'order' => 'desc',
            'meta_query' => array(
                array(
                    'key' => 'date_start',
                    'value' => ($opt['year']).'-'.($opt['month']).'-01',
                    'compare' => '<',
                    'type' => 'DATE'
                )
            )
        );
        $q = new WP_Query($args);
        $month = $year = 0;
        if ($q->have_posts()) {
            while ($q->have_posts()) { $q->the_post();
                $dt = strtotime(get_post_meta(get_the_ID(), 'date_start', true));
                $year  = date('Y', $dt);
                $month = date('m', $dt);
            }
            wp_reset_postdata();
        }
        if (empty($prev) || ($year+$month>0 && ($prev['year']+$prev['month']==0 || ($prev['year']).($prev['month']) < ($year).($month)))) {
            $prev['year'] = $year;
            $prev['month'] = $month;
        }
        if (empty($prev['done'])) $prev['done'] = array();
        $prev['done'][] = 'courses';
        return $prev;
    }
}

// Return next month and year with published posts
if ( !function_exists( 'themerex_courses_calendar_get_next_month' ) ) {
    //add_filter('themerex_filter_calendar_get_next_month',	'themerex_courses_calendar_get_next_month', 9, 2);
    function themerex_courses_calendar_get_next_month($next, $opt) {
        if (!empty($opt['posts_types']) && !in_array('courses', $opt['posts_types'])) return;
        if (!empty($next['done']) && in_array('courses', $next['done'])) return;
        $args = array(
            'post_type' => 'courses',
            'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
            'posts_per_page' => 1,
            'ignore_sticky_posts' => true,
            'orderby' => 'meta_value',
            'meta_key' => 'date_start',
            'order' => 'asc',
            'meta_query' => array(
                array(
                    'key' => 'date_start',
                    'value' => ($opt['year']).'-'.($opt['month']).'-'.($opt['last_day']).' 23:59:59',
                    'compare' => '>',
                    'type' => 'DATE'
                )
            )
        );
        $q = new WP_Query($args);
        $month = $year = 0;
        if ($q->have_posts()) {
            while ($q->have_posts()) { $q->the_post();
                $dt = strtotime(get_post_meta(get_the_ID(), 'date_start', true));
                $year  = date('Y', $dt);
                $month = date('m', $dt);
            }
            wp_reset_postdata();
        }
        if (empty($next) || ($year+$month>0 && ($next['year']+$next['month']==0 || ($next['year']).($next['month']) > ($year).($month)))) {
            $next['year'] = $year;
            $next['month'] = $month;
        }
        if (empty($next['done'])) $next['done'] = array();
        $next['done'][] = 'courses';
        return $next;
    }
}

// Return current month published posts
if ( !function_exists( 'themerex_courses_calendar_get_curr_month_posts' ) ) {
    //add_filter('themerex_filter_calendar_get_curr_month_posts',	'themerex_courses_calendar_get_curr_month_posts', 9, 2);
    function themerex_courses_calendar_get_curr_month_posts($posts, $opt) {
        if (!empty($opt['posts_types']) && !in_array('courses', $opt['posts_types'])) return;
        if (!empty($posts['done']) && in_array('courses', $posts['done'])) return;
        $args = array(
            'post_type' => 'courses',
            'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish',
            'posts_per_page' => -1,
            'ignore_sticky_posts' => true,
            'orderby' => 'meta_value',
            'order' => 'asc',
            'meta_query' => array(
                array(
                    'key' => 'date_start',
                    'value' => array(($opt['year']).'-'.($opt['month']).'-01', ($opt['year']).'-'.($opt['month']).'-'.($opt['last_day']).' 23:59:59'),
                    'compare' => 'BETWEEN',
                    'type' => 'DATE'
                )
            )
        );
        $q = new WP_Query($args);
        if ($q->have_posts()) {
            if (empty($posts)) $posts = array();
            while ($q->have_posts()) { $q->the_post();
                $dt = strtotime(get_post_meta(get_the_ID(), 'date_start', true));
                $day = (int) date('d', $dt);
                $title = apply_filters('the_title', get_the_title());
                if (empty($posts[$day]))
                    $posts[$day] = array();
                if (empty($posts[$day]['link']) && count($opt['posts_types'])==1)
                    $posts[$day]['link'] = get_day_link($opt['year'], $opt['month'], $day);
                if (empty($posts[$day]['titles']))
                    $posts[$day]['titles'] = $title;
                else
                    $posts[$day]['titles'] = is_int($posts[$day]['titles']) ? $posts[$day]['titles']+1 : 2;
                if (empty($posts[$day]['posts'])) $posts[$day]['posts'] = array();
                $posts[$day]['posts'][] = array(
                    'post_id' => get_the_ID(),
                    'post_type' => get_post_type(),
                    'post_date' => date(get_option('date_format'), $dt),
                    'post_title' => $title,
                    'post_link' => get_permalink()
                );
            }
            wp_reset_postdata();
        }
        if (empty($posts['done'])) $posts['done'] = array();
        $posts['done'][] = 'courses';
        return $posts;
    }
}

// Pre query: Join tables into main query
if ( !function_exists( 'themerex_courses_posts_join' ) ) {
    // add_action( 'posts_join', 'themerex_courses_posts_join', 10, 2 );
    function themerex_courses_posts_join($join_sql, $query) {
        if (!is_admin() && $query->is_main_query()) {
            if ($query->is_day || $query->is_month || $query->is_year) {
                global $wpdb;
                $join_sql .= " LEFT JOIN " . esc_sql($wpdb->postmeta) . " AS _courses_meta ON " . esc_sql($wpdb->posts) . ".ID = _courses_meta.post_id AND  _courses_meta.meta_key = 'date_start'";
            }
        }
        return $join_sql;
    }
}

// Pre query: Join tables into archives widget query
if ( !function_exists( 'themerex_courses_getarchives_join' ) ) {
    // add_action( 'getarchives_join', 'themerex_courses_getarchives_join', 10, 2 );
    function themerex_courses_getarchives_join($join_sql, $r) {
        global $wpdb;
        $join_sql .= " LEFT JOIN " . esc_sql($wpdb->postmeta) . " AS _courses_meta ON " . esc_sql($wpdb->posts) . ".ID = _courses_meta.post_id AND  _courses_meta.meta_key = 'date_start'";
        return $join_sql;
    }
}

// Pre query: Where section into main query
if ( !function_exists( 'themerex_courses_posts_where' ) ) {
    // add_action( 'posts_where', 'themerex_courses_posts_where', 10, 2 );
    function themerex_courses_posts_where($where_sql, $query) {
        if (!is_admin() && $query->is_main_query()) {
            if ($query->is_day || $query->is_month || $query->is_year) {
                global $wpdb;
                $where_sql .= " OR (1=1";
                // Posts status
                if ((!isset($_REQUEST['preview']) || $_REQUEST['preview']!='true') && (!isset($_REQUEST['vc_editable']) || $_REQUEST['vc_editable']!='true')) {
                    if (current_user_can('read_private_pages') && current_user_can('read_private_posts'))
                        $where_sql .= " AND (" . esc_sql($wpdb->posts) . ".post_status='publish' OR " . esc_sql($wpdb->posts) . ".post_status='private')";
                    else
                        $where_sql .= " AND " . esc_sql($wpdb->posts) . ".post_status='publish'";
                }
                // Posts type and date
                $dt = $query->get('m');
                $y = $query->get('year');
                if (empty($y)) $y = (int) themerex_substr($dt, 0, 4);
                $where_sql .= " AND " . esc_sql($wpdb->posts) . ".post_type='courses' AND YEAR(_courses_meta.meta_value)=".esc_sql($y);
                if ($query->is_month || $query->is_day) {
                    $m = $query->get('monthnum');
                    if (empty($m)) $m = (int) themerex_substr($dt, 4, 2);
                    $where_sql .= " AND MONTH(_courses_meta.meta_value)=".esc_sql($m);
                }
                if ($query->is_day) {
                    $d = $query->get('day');
                    if (empty($d)) $d = (int) themerex_substr($dt, 6, 2);
                    $where_sql .= " AND DAYOFMONTH(_courses_meta.meta_value)=".esc_sql($d);
                }
                $where_sql .= ')';
            }
        }
        return $where_sql;
    }
}

// Pre query: Where section into archives widget query
if ( !function_exists( 'themerex_courses_getarchives_where' ) ) {
    // add_action( 'getarchives_where', 'themerex_courses_getarchives_where', 10, 2 );
    function themerex_courses_getarchives_where($where_sql, $r) {
        global $wpdb;
        // Posts type and date
        $where_sql .= " OR " . esc_sql($wpdb->posts) . ".post_type='courses'";
        return $where_sql;
    }
}

// Return courses start date instead post publish date
if ( !function_exists( 'themerex_courses_post_date' ) ) {
    //add_filter('themerex_filter_post_date', 'themerex_courses_post_date', 9, 3);
    function themerex_courses_post_date($post_date, $post_id, $post_type) {
        if ($post_type == 'courses') {
            $post_date = get_post_meta($post_id, 'date_start', true);
        }
        return $post_date;
    }
}
?>
