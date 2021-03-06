<?php
/**
 * This is a highly intuitive function that gets images.  It first calls for custom field keys. If no 
 * custom field key is set, check for the_post_thumbnail().  If no post image, check for images 
 * attached to post. Check for image order if looking for attached images.  Scan the post for 
 * images if $image_scan = true.  Check for default image if $default_image = true. If an image 
 * is found, call IGIT_display_the_image() to format it.
 *
 * @since 0.1
 * @global $post The current post's DB object.
 * @param array $args Parameters for what image to get.
 * @return string|array The HTML for the image. | Image attributes in an array.
 */
function IGIT_get_the_image( $args = array() ) {
	global $post;

	/* Set the default arguments. */
	$defaults = array(
		'custom_key' => array( 'Thumbnail', 'thumbnail' ),
		'post_id' => $post->ID,
		'attachment' => true,
		'the_post_thumbnail' => true, // WP 2.9+ image function
		'default_size' => false, // Deprecated 0.5 in favor of $size
		'size' => 'thumbnail',
		'default_image' => true,
		'order_of_image' => 1,
		'link_to_post' => true,
		'image_class' => false,
		'image_scan' => true,
		'width' => false,
		'height' => false,
		'format' => 'img',
		'echo' => true
	);

	if (get_option('igit_rpwt')) {
        $igit_rpwt_temp = get_option('igit_rpwt');
	}
	
	/* Merge the input arguments and the defaults. */
	$args = wp_parse_args( $args, $defaults );

	/* If $default_size is given, overwrite $size. */
	if ( !empty( $args['default_size'] ) )
		$args['size'] = $args['default_size'];

	/* If $format is set to 'array', don't link to the post. */
	if ( 'array' == $args['format'] )
		$args['link_to_post'] = false;

	/* Extract the array to allow easy use of variables. */
	extract( $args );

	
	/* If there is no cached image, let's see if one exists. */
		/* If a custom field key (array) is defined, check for images by custom field. */
		if ( $custom_key )
			$image = IGIT_image_by_custom_field( $args );

		/* If no image found and $the_post_thumbnail is set to true, check for a post image (WP feature). */
		if ( !$image && $the_post_thumbnail )
			$image = IGIT_image_by_the_post_thumbnail( $args );

		/* If no image found and $attachment is set to true, check for an image by attachment. */
		if ( !$image && $attachment )
			$image = IGIT_image_by_attachment( $args );

		/* If no image found and $image_scan is set to true, scan the post for images. */
		if ( !$image && $image_scan )
			$image = IGIT_image_by_scan( $args );

		/* If no image found and a $default_image is set, get the default image. */
		if ( !$image && $default_image )
		{	
			$image = IGIT_image_by_default( $args ,$igit_rpwt_temp);
		}
			$imageurl = $image['url'];
		
            if (strlen(trim($imageurl)) == 0) {
                
				
				if($igit_rpwt_temp['default_no_image'] == "")
				$imageurl = WP_PLUGIN_URL . '/'.IGIT_RPWT_PLUGIN_FOLDER_NAME.'/images/noimage.gif'; // when no image found in post 
				else
				$imageurl = $igit_rpwt_temp['default_no_image']; // when no image found in post 
            }
			else
			{
				$bgurl = get_bloginfo('url');
				if(!strstr($imageurl,$bgurl)){
					
					if($igit_rpwt_temp['default_no_image'] == "")
					$imageurl = WP_PLUGIN_URL . '/'.IGIT_RPWT_PLUGIN_FOLDER_NAME.'/images/noimage.gif'; // when no image found in post 
					else
					$imageurl = $igit_rpwt_temp['default_no_image']; // when no image found in post 
				}
			}
            $imageurl = parse_url($imageurl, PHP_URL_PATH);	
			
		
		return $imageurl;
}

/* Internal Functions */

/**
 * Calls images by custom field key.  Script loops through multiple custom field keys.
 * If that particular key is found, $image is set and the loop breaks.  If an image is 
 * found, it is returned.
 *
 * @since 0.3
 * @param array $args
 * @return array|bool
 */
function IGIT_image_by_custom_field( $args = array() ) {

	/* If $custom_key is a string, we want to split it by spaces into an array. */
	if ( !is_array( $args['custom_key'] ) )
		$args['custom_key'] = preg_split( '#\s+#', $args['custom_key'] );

	/* If $custom_key is set, loop through each custom field key, searching for values. */
	if ( isset( $args['custom_key'] ) ) {
		foreach ( $args['custom_key'] as $custom ) {
			$image = get_metadata( 'post', $args['post_id'], $custom, true );
			if ( $image )
				break;
		}
	}

	/* If a custom key value has been given for one of the keys, return the image URL. */
	if ( $image )
		return array( 'url' => $image );

	return false;
}

/**
 * Checks for images using a custom version of the WordPress 2.9+ get_the_post_thumbnail()
 * function.  If an image is found, return it and the $post_thumbnail_id.  The WordPress function's
 * other filters are later added in the IGIT_display_the_image() function.
 *
 * @since 0.4
 * @param array $args
 * @return array|bool
 */
function IGIT_image_by_the_post_thumbnail( $args = array() ) {
if ( function_exists( 'get_post_thumbnail_id' ) )
	{
	/* Check for a post image ID (set by WP as a custom field). */
	$post_thumbnail_id = get_post_thumbnail_id( $args['post_id'] );

	/* If no post image ID is found, return false. */
	if ( empty( $post_thumbnail_id ) )
		return false;

	/* Apply filters on post_thumbnail_size because this is a default WP filter used with its image feature. */
	$size = apply_filters( 'post_thumbnail_size', $args['size'] );

	/* Get the attachment image source.  This should return an array. */
	$image = wp_get_attachment_image_src( $post_thumbnail_id, $size );

	/* Get the attachment excerpt to use as alt text. */
	$alt = trim( strip_tags( get_post_field( 'post_excerpt', $post_thumbnail_id ) ) );

	/* Return both the image URL and the post thumbnail ID. */
	return array( 'url' => $image[0], 'post_thumbnail_id' => $post_thumbnail_id, 'alt' => $alt );
	}
}

/**
 * Check for attachment images.  Uses get_children() to check if the post has images 
 * attached.  If image attachments are found, loop through each.  The loop only breaks 
 * once $order_of_image is reached.
 *
 * @since 0.3
 * @param array $args
 * @return array|bool
 */
function IGIT_image_by_attachment( $args = array() ) {

	/* Get attachments for the inputted $post_id. */
	$attachments = get_children( array( 'post_parent' => $args['post_id'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) );

	/* If no attachments are found, check if the post itself is an attachment and grab its image. */
	if ( empty( $attachments ) && $args['size'] ) {
		if ( 'attachment' == get_post_type( $args['post_id'] ) ) {
			$image = wp_get_attachment_image_src( $args['post_id'], $args['size'] );
			$alt = trim( strip_tags( get_post_field( 'post_excerpt', $args['post_id'] ) ) );
		}
	}

	/* If no attachments or image is found, return false. */
	if ( empty( $attachments ) && empty( $image ) )
		return false;
	$i=0;
	/* Loop through each attachment. Once the $order_of_image (default is '1') is reached, break the loop. */
	foreach ( $attachments as $id => $attachment ) {
		if ( ++$i == $args['order_of_image'] ) {
			$image = wp_get_attachment_image_src( $id, $args['size'] );
			$alt = trim( strip_tags( get_post_field( 'post_excerpt', $id ) ) );
			break;
		}
	}

	/* Return the image URL. */
	return array( 'url' => $image[0], 'alt' => $alt );
}

/**
 * Scans the post for images within the content.  Not called by default with IGIT_get_the_image().
 * Shouldn't use if using large images within posts, better to use the other options.
 *
 * @since 0.3
 * @global $post The current post's DB object.
 * @param array $args
 * @return array|bool
 */
function IGIT_image_by_scan( $args = array() ) {

	/* Search the post's content for the <img /> tag and get its URL. */
	preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', get_post_field( 'post_content', $args['post_id'] ), $matches );
	/* If there is a match for the image, return its URL. */
	if ( isset( $matches ) && !empty($matches[1]) )
		return array( 'url' => $matches[1][0] );

	return false;
}

/**
 * Used for setting a default image.  The function simply returns the image URL it was
 * given in an array.  Not used with IGIT_get_the_image() by default.
 *
 * @since 0.3
 * @param array $args
 * @return array
 */
function IGIT_image_by_default( $args = array(),$igit_rpwt_temp ) {
	
	
	
	if($igit_rpwt_temp['default_no_image'] == "")
	return array( 'url' => WP_PLUGIN_URL . '/'.IGIT_RPWT_PLUGIN_FOLDER_NAME.'/images/noimage.gif' );
	else
	return array( 'url' => $igit_rpwt_temp['default_no_image'] );
	//$imageurl = $igit_rpwt_temp['default_no_image']; // when no image found in post 
//	return array( 'url' => $args['default_image'] );
	
}

/**
 * Formats an image with appropriate alt text and class.  Adds a link to the post if argument 
 * is set.  Should only be called if there is an image to display, but will handle it if not.
 *
 * @since 0.1
 * @param array $args
 * @param array $image Array of image info ($image, $classes, $alt, $caption).
 * @return string $image Formatted image (w/link to post if the option is set).
 */
function IGIT_display_the_image( $args = array(), $image = false ) {

	/* If there is no image URL, return false. */
	if ( empty( $image['url'] ) )
		return false;

	/* Extract the arguments for easy-to-use variables. */
	extract( $args );

	/* If there is alt text, set it.  Otherwise, default to the post title. */
	$image_alt = ( ( $image['alt'] ) ? $image['alt'] : apply_filters( 'the_title', get_post_field( 'post_title', $post_id ) ) );

	/* If there is a width or height, set them as HMTL-ready attributes. */
	$width = ( ( $width ) ? ' width="' . esc_attr( $width ) . '"' : '' );
	$height = ( ( $height ) ? ' height="' . esc_attr( $height ) . '"' : '' );

	/* Loop through the custom field keys and add them as classes. */
	if ( is_array( $custom_key ) ) {
		foreach ( $custom_key as $key )
			$classes[] = str_replace( ' ', '-', strtolower( $key ) );
	}

	/* Add the $size and any user-added $image_class to the class. */
	$classes[] = $size;
	$classes[] = $image_class;

	/* Join all the classes into a single string and make sure there are no duplicates. */
	$class = join( ' ', array_unique( $classes ) );

	/* If there is a $post_thumbnail_id, apply the WP filters normally associated with get_the_post_thumbnail(). */
	if ( $image['post_thumbnail_id'] )
		do_action( 'begin_fetch_post_thumbnail_html', $post_id, $image['post_thumbnail_id'], $size );

	/* Add the image attributes to the <img /> element. */
	$html = '<img src="' . $image['url'] . '" alt="' . esc_attr( strip_tags( $image_alt ) ) . '" class="' . esc_attr( $class ) . '"' . $width . $height . ' />';

	/* If $link_to_post is set to true, link the image to its post. */
	if ( $link_to_post )
		$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( apply_filters( 'the_title', get_post_field( 'post_title', $post_id ) ) ) . '">' . $html . '</a>';

	/* If there is a $post_thumbnail_id, apply the WP filters normally associated with get_the_post_thumbnail(). */
	if ( $image['post_thumbnail_id'] )
		do_action( 'end_fetch_post_thumbnail_html', $post_id, $image['post_thumbnail_id'], $size );

	/* If there is a $post_thumbnail_id, apply the WP filters normally associated with get_the_post_thumbnail(). */
	if ( $image['post_thumbnail_id'] )
		$html = apply_filters( 'post_thumbnail_html', $html, $post_id, $image['post_thumbnail_id'], $size, '' );

	return $html;
}

/**
 * Deletes the image cache for users that are using a persistent-caching plugin.
 *
 * @since 0.5
 */
function IGIT_get_the_image_delete_cache() {
	wp_cache_delete( 'get_the_image' );
}

/**
 * Get the image with a link to the post.  Use IGIT_get_the_image() instead.
 *
 * @since 0.1
 * @deprecated 0.3
 */
function IGIT_get_the_image_link( $deprecated = '', $deprecated_2 = '', $deprecated_3 = '' ) {
	IGIT_get_the_image();
}
?>