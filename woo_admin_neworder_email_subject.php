<?php


//Custom WooCommerce admin New Order Subject Line
//Display product categories in the subject line

add_filter('woocommerce_email_subject_new_order', 'woo_admin_neworder_email_subject', 1, 2);

function woo_admin_neworder_email_subject( $subject, $order ) {
    global $woocommerce;

    //get all items in the order, returns an associative array
    $order_items_arr =  $order->get_items() ;
    
    //loop through the assoc. array of order items assigning name + ID to usable variables
    foreach( $order_items_arr as $product ) {
            $prodct_name = $product['name']; //we don't actually do anything with this at the moment
            $prodct_id = $product['item_meta']['_product_id'][0];
            //get product categories by the product ID and add them as a string to a $categories array
            	$terms = wp_get_post_terms( $prodct_id, 'product_cat' );
				foreach ( $terms as $term ) $categories[] = $term->slug;
        }
    
    //Setup the subject variable as a list of order categories imploded and comma-separated
    $subject = "New Order: " . implode(", ", $categories);
    return ucwords($subject);
}
