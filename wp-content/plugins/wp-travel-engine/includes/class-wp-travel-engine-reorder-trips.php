<?php
$wpte = new WPTE_Reorder_Trips();

class WPTE_Reorder_Trips {

    function __construct() {
        add_action('admin_init', array($this, 'wpte_refresh'));

        add_action('admin_init', array($this, 'wpte_update_options'));
        
        add_action('admin_init', array($this, 'wpte_load_script_css'));

        add_action('wp_ajax_update-menu-order', array($this, 'wpte_update_menu_order'));

        add_action('pre_get_posts', array($this, 'wpte_pre_get_posts'));
    }

    function wpte_load_script_css() {
        wp_enqueue_script('jquery-ui-sortable');
    }

    function wpte_refresh() {
        global $wpdb;
        $object = 'trip';
        $result = $wpdb->get_results("
			SELECT count(*) as cnt, max(menu_order) as max, min(menu_order) as min 
			FROM $wpdb->posts 
			WHERE post_type = '" . $object . "' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
		");

        $results = $wpdb->get_results("
			SELECT ID 
			FROM $wpdb->posts 
			WHERE post_type = '" . $object . "' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future') 
			ORDER BY menu_order ASC
		");
        foreach ($results as $key => $result) {
            $wpdb->update($wpdb->posts, array('menu_order' => $key + 1), array('ID' => $result->ID));
        }
    }

    function wpte_update_menu_order() {
        global $wpdb;

        parse_str($_POST['order'], $data);

        if (!is_array($data))
            return false;

        $id_arr = array();
        foreach ($data as $key => $values) {
            foreach ($values as $position => $id) {
                $id_arr[] = $id;
            }
        }

        $menu_order_arr = array();
        foreach ($id_arr as $key => $id) {
            $results = $wpdb->get_results("SELECT menu_order FROM $wpdb->posts WHERE ID = " . intval($id));
            foreach ($results as $result) {
                $menu_order_arr[] = $result->menu_order;
            }
        }

        sort($menu_order_arr);

        foreach ($data as $key => $values) {
            foreach ($values as $position => $id) {
                $wpdb->update($wpdb->posts, array('menu_order' => $menu_order_arr[$position]), array('ID' => intval($id)));
            }
        }
        $options = get_option( 'wp_travel_engine_settings', array() );
        if(!isset($options['reorder']['flag']))
        {
            $arr['reorder']['flag'] = '1';
            $flag = array_merge_recursive( $options, $arr );
            update_option ( 'wp_travel_engine_settings', $flag );
        }
    }

    function wpte_update_options() {
        global $wpdb;

        $object = 'trip';

        $results = $wpdb->get_results("
			SELECT count(*) as cnt, max(menu_order) as max, min(menu_order) as min 
			FROM $wpdb->posts 
			WHERE post_type = '" . $object . "' AND post_status IN ('publish', 'pending', 'draft', 'private', 'future')
		");
    }

    function wpte_previous_post_where($where) {
        global $post;

        $object = 'trip';
        if (empty($object))
            return $where;

        if (isset($post->post_type) && $post->post_type==$object) {
            $current_menu_order = $post->menu_order;
            $where = "WHERE p.menu_order > '" . $current_menu_order . "' AND p.post_type = '" . $post->post_type . "' AND p.post_status = 'publish'";
        }
        return $where;
    }

    function wpte_previous_post_sort($orderby) {
        global $post;

        $object = 'trip';
        if (empty($object))
            return $orderby;

        if (isset($post->post_type) && $post->post_type==$object) {
            $orderby = 'ORDER BY p.menu_order ASC LIMIT 1';
        }
        return $orderby;
    }

    function wpte_next_post_where($where) {
        global $post;

        $object = 'trip';
        if (empty($object))
            return $where;

        if (isset($post->post_type) && $post->post_type==$object) {
            $current_menu_order = $post->menu_order;
            $where = "WHERE p.menu_order < '" . $current_menu_order . "' AND p.post_type = '" . $post->post_type . "' AND p.post_status = 'publish'";
        }
        return $where;
    }

    function wpte_next_post_sort($orderby) {
        global $post;

        $object = 'trip';
        if (empty($object))
            return $orderby;

        if (isset($post->post_type) && $post->post_type==$object) {
            $orderby = 'ORDER BY p.menu_order DESC LIMIT 1';
        }
        return $orderby;
    }

    function wpte_pre_get_posts($wp_query) {
        $options = get_option( 'wp_travel_engine_settings', array() );
        if(!isset($options['reorder']['flag']))
            return;
        
        if (empty($object))
            return false;
        if (is_admin()) {

            if (isset($wp_query->query['post_type']) && !isset($_GET['orderby'])) {
                if ($wp_query->query['post_type'] ==  $object) {
                    $wp_query->set('orderby', 'menu_order');
                    $wp_query->set('order', 'ASC');
                }
            }
        } else {
            
            $active = false;

            if (isset($wp_query->query['post_type'])) {
                if (!is_array($wp_query->query['post_type'])) {
                    $wp_query->set('orderby', 'menu_order');
                    $wp_query->set('order', 'ASC');
                }
            } else {
                if ('trip' == $object) {
                    $active = true;
                }
            }

            // if (!$active)
            //     return false;

            if (isset($wp_query->query['suppress_filters'])) {
                if ($wp_query->get('orderby') == 'date')
                    $wp_query->set('orderby', 'menu_order');
                if ($wp_query->get('order') == 'DESC')
                    $wp_query->set('order', 'ASC');
            } else {
                if (isset($wp_query->query['post_type']) && !isset($_GET['orderby'])) {
                    if ($wp_query->query['post_type'] ==  $object) {
                        $wp_query->set('orderby', 'menu_order');
                        $wp_query->set('order', 'ASC');
                    }
                }
            }
        }
    }

    function get_wpte_options_object() {
        $object = 'trip';
        return $object;
    }

}
