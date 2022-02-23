<?php
function get_rating_value_count($meta_value)
{
    global $wpdb, $product;
    $ratings = $wpdb->get_var(
        $wpdb->prepare(
            "
				SELECT COUNT(*) FROM $wpdb->commentmeta
				LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
				WHERE meta_key = 'rating'
				AND comment_post_ID = %d
				AND comment_approved = '1'
				AND meta_value = $meta_value
					",
            $product->get_id()
        )
    );
    return $ratings;
}
