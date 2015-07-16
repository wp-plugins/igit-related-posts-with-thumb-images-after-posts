<?php require_once('get-the-image.php');
function igit_front_enqueue_style() {
	wp_enqueue_style( 'igit-front-style', IGIT_RPWT_CSS_URL.'/igit_front_style.css', false ); 
}
function igit_add_css_style()
{
    global $igit_rpwt, $wpdb, $post, $single, $WP_PLUGIN_URL;
    if (get_option('igit_rpwt')) {
        $igit_rpwt = get_option('igit_rpwt');
    }
    if ($igit_rpwt['related_post_style'] == '1') 
	{
?>
		<style type="text/css">
        #igit_rpwt_css {
            background:<?php echo "#".$igit_rpwt['bk_color'].";"; ?>
            font-size:12px; 
            font-style:normal; 
            color:<?php echo "#".$igit_rpwt['fonts_color']; ?> !important;
            margin-top:10px;
            margin-bottom:10px; 
            <?php if($igit_rpwt['display_thumb'] == '1'){ ?> height:<?php echo ($igit_rpwt['thumb_height'] + 130)."px;"; ?> <?php } ?>
        }
        #igit_title 
        {
            padding:2px 2px 2px 8px;
            text-align:center;
            font-size:<?php echo $igit_rpwt['fonts_size']."px;"; ?>
            font-family:<?php echo $igit_rpwt['fonts_family'].";"; ?>
            
        }
        #igit_rpwt_css h4{
            padding-bottom:10px;
            border-bottom:1px solid #dbdbdb;
		    margin-bottom: 10px !important;
            color:<?php echo "#".$igit_rpwt['fonts_color'].";"; ?>
        }
        #igit_title a
        {
            color:<?php echo "#".$igit_rpwt['fonts_color'].";"; ?>
            font-size:<?php echo $igit_rpwt['fonts_size']."px;"; ?>
            font-family:<?php echo $igit_rpwt['fonts_family'].";"; ?>
		    border-bottom: medium none;
        }
        #igit_title a:hover
        {
            border-bottom:1px solid #000000;
            text-decoration:none;
        }
        #igit_rpwt_thumb, #description 
        {
            margin-left:0px; 
            border:1px solid <?php echo "#".$igit_rpwt['img_border_color'].";"; ?> 
            padding: 3px;
        }
        .igit_relpost:hover
        {
            border-bottom:4px solid #808080;
            background-color:<?php echo "#".$igit_rpwt['bk_hover_color'].";"; ?>
        }
        #igit_rpwt_css h4
        {
            margin: 0 0 0px;
        }
        .igit_relpost {
            padding-top:7px;
            border-right-color-value:#DDDDDD;
            border-right-style-value:solid;
            border-right-width-value:1px;
            border-bottom:4px solid <?php echo "#".$igit_rpwt['bk_color'].";"; ?>
            float:left;
            <?php if($igit_rpwt['display_thumb'] == '1' && $igit_rpwt['display_title'] == '1'){	?> height:85%; <?php } ?>
            width:<?php echo floor(100 / $igit_rpwt['related_post_num']) . "%"; ?>;
        }
        #igit_rpwt_main_image {
            height:<?php echo ($igit_rpwt['thumb_height'] + 5) . "px"; ?>;
            line-height:15;
            padding-bottom:10px;
            padding-left:2px;
            padding-right:2px;
            padding-top:2px;
            text-align:center;
		    display: inline-block;
			width:100%;
        }
		#igit_rpwt_main_image > a {
   			 display: inline-block;
			 border-bottom: none !important;
		}
        </style>
<?php
	}
	if ($igit_rpwt['related_post_style'] == '2') 
	{
?>
		<style type="text/css">
        #igit_rpwt_css 
        {
            background:<?php echo "#".$igit_rpwt['bk_color'].";"; ?> 
            font-family:verdana,arila,serif; 
            font-size:12px; 
            font-style:normal; 
            color:<?php echo "#".$igit_rpwt['fonts_color']; ?> !important;
            margin-top:10px;margin-bottom:10px;
        }
        #igit_rpwt_css h4{
            color:<?php echo "#".$igit_rpwt['fonts_color'].";"; ?>
            font-family:<?php echo $igit_rpwt['fonts_family'].";"; ?>
        }
        #igit_title {
            padding:2px 2px 2px 0px;
            font-family:<?php echo $igit_rpwt['fonts_family'].";"; ?>
            font-size:<?php echo $igit_rpwt['fonts_size']."px;"; ?>
        }
        #igit_title a
        {
            color:<?php echo "#".$igit_rpwt['fonts_color'].";"; ?>
            font-family:<?php echo $igit_rpwt['fonts_family'].";"; ?>
            font-size:<?php echo $igit_rpwt['fonts_size']."px;"; ?>
        }
        #igit_rpwt_thumb, #description 
        {
            margin-left:0px;
        }
        .igit_relpost:hover
        {
            background-color:<?php echo "#".$igit_rpwt['bk_hover_color'].";"; ?>
        }
        #igit_rpwt_main_image {
            float:left;
            height:<?php echo ($igit_rpwt['thumb_height'] + 5) . "px";	?>;
            line-height:15;
            padding-bottom:10px;
            padding-right:2px;
            padding-top:2px;
            text-align:left; 
            width:<?php	echo ($igit_rpwt['thumb_width'] + 20) . "px"; ?>;
        }
        #igit_rpwt_css ul
        {
            margin:0;
        }
        #igit_rpwt_li 
        { 
            cursor:pointer; 
            list-style:none;
		    clear: both;
            border-bottom:1px solid #EBDDE2; 
            padding: 5px 5px 10px 10px !important;
			height: <?php echo ($igit_rpwt['thumb_height'] + 15)."px;"; ?>
        }
        #igit_rpwt_li:hover
        {
            background:<?php echo "#".$igit_rpwt['bk_hover_color'].";"; ?>
        }
        </style>
<?php
	}
	if ($igit_rpwt['related_post_style'] == '3') 
	{
?>
		<style type="text/css">
        #igit_rpwt_css 
        {
            background:<?php echo "#".$igit_rpwt['bk_color'].";"; ?> 
            font-family:verdana,arila,serif; 
            font-size:12px; 
            font-style:normal; 
            color:<?php echo "#".$igit_rpwt['fonts_color']; ?> !important; 
            margin-top:10px;
            margin-bottom:10px;
        }
        #igit_rpwt_css h4{
            color:<?php echo "#".$igit_rpwt['fonts_color'].";"; ?>
        }
        #igit_title {
            padding:2px 2px 2px 0px;
            font-family:<?php echo $igit_rpwt['fonts_family'].";"; ?>
            font-size:<?php echo $igit_rpwt['fonts_size']."px;"; ?>
        }
        #igit_title a
        {
            color:<?php echo "#".$igit_rpwt['fonts_color'].";"; ?>
            font-family:<?php echo $igit_rpwt['fonts_family'].";"; ?>
            font-size:<?php echo $igit_rpwt['fonts_size']."px;"; ?>
        }
        #igit_rpwt_thumb, #description 
        {
            margin-left:0px;
        }
        .igit_relpost:hover
        {
            background-color:<?php echo "#".$igit_rpwt['bk_hover_color'].";"; ?>;
        }
        #igit_rpwt_li 
        { 
            padding: 0px 5px 0px 5px !important;
            margin-bottom:1.0em;
        }
        #igit_rpwt_li:hover
        {
            background:<?php echo "#".$igit_rpwt['bk_hover_color'].";"; ?>;
        }
        </style>
<?php
	}
}
function igit_total_content($content)
{
    global $single;
    if (get_option('igit_rpwt')) {
        $igit_rpwt = get_option('igit_rpwt');
    } //get_option('igit_rpwt')
    $output = igit_show_rel_post();
    if (is_single()) {
        return $content . $output;
    } //is_single()
    else {
        return $content;
    }
}
function igit_show_rel_post()
{
    global $igit_rpwt, $igit_rpwt_default, $wpdb, $post, $single, $WP_PLUGIN_URL;
    if (!defined('WP_PLUGIN_URL'))
        define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');
    $pluginDir = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
    if (get_option('igit_rpwt')) {
        $igit_rpwt_temp = get_option('igit_rpwt');
		
		
		/*if(!empty($igit_rpwt_temp['exclude_cat_arr'])){
			 $igit_rpwt_temp['exclude_cat_arr'] = $igit_rpwt_default['exclude_cat_arr'];
		}*/
		if (!array_key_exists('default_no_image', $igit_rpwt_temp)) {
            $igit_rpwt_temp['default_no_image'] = $igit_rpwt_default['default_no_image'];
        }
        if (!array_key_exists('no_related_post_text', $igit_rpwt_temp)) {
            $igit_rpwt_temp['no_related_post_text'] = $igit_rpwt_default['no_related_post_text'];
        } //!array_key_exists('no_related_post_text', $igit_rpwt_temp)
        if (!array_key_exists('display_title', $igit_rpwt_temp)) {
            $igit_rpwt_temp['display_title'] = $igit_rpwt_default['display_title'];
        } //!array_key_exists('display_title', $igit_rpwt_temp)
        if (!array_key_exists('fonts_family', $igit_rpwt_temp)) {
            $igit_rpwt_temp['fonts_family'] = $igit_rpwt_default['fonts_family'];
        } //!array_key_exists('fonts_family', $igit_rpwt_temp)
        if (!array_key_exists('fonts_size', $igit_rpwt_temp)) {
            $igit_rpwt_temp['fonts_size'] = $igit_rpwt_default['fonts_size'];
        } //!array_key_exists('fonts_size', $igit_rpwt_temp)
        if (!array_key_exists('display_full_title', $igit_rpwt_temp)) {
            $igit_rpwt_temp['display_full_title'] = $igit_rpwt_default['display_full_title'];
        } //!array_key_exists('display_full_title', $igit_rpwt_temp)
        if (!array_key_exists('title_characters', $igit_rpwt_temp)) {
            $igit_rpwt_temp['title_characters'] = $igit_rpwt_default['title_characters'];
        } //!array_key_exists('title_characters', $igit_rpwt_temp)
        if (!$igit_rpwt_temp['display_title']) {
            $igit_rpwt_temp['display_title'] = $igit_rpwt['display_title'];
            $igit_rpwt                       = $igit_rpwt_temp;
        } //!$igit_rpwt_temp['display_title']
        else {
            $igit_rpwt = $igit_rpwt_temp;
        }
    } //get_option('igit_rpwt')
    $limit = (stripslashes($igit_rpwt['related_post_num']));
    if (!$limit)
        $limit = 4;
    $time_difference = get_option('gmt_offset');
    $now             = gmdate("Y-m-d H:i:s", (time() + ($time_difference * 3600)));
    $pcont           = preg_replace('/<img[^>]+./', '', $post->post_content);
    $igit_search_str = addslashes($post->post_title . ' ' . $pcont);
    if ($post->ID != '') {
        $cats = get_the_category($post->ID);
        if ($cats) {
            foreach ($cats as $cat) {
                $cat_id_array[] = $cat->cat_ID;
            } //$cats as $cat
        } //$cats
        $ptags = get_the_tags($post->ID);
        $cstr  = "";
        $i     = 1;
        if ($ptags) {
            foreach ($ptags as $ptag) {
                $tag_id_array[] = get_tag_ID(trim($ptag->name));
                $i++;
            } //$ptags as $ptag
        } //$ptags
        if (isset($cat_id_array) && isset($tag_id_array)) 
		{
		    $resultstag = get_posts(array(
                'tag__in' => $tag_id_array,
                'post__not_in' => array(
                    $post->ID
                )
            ));
			
			/** Check if $cat_id_array values exists in exlude cate array, then remove that category from $cat_id_array. **/
			if(!empty($cat_id_array) && !empty($igit_rpwt_temp['exclude_cat_arr'])){
				for($f=0;$f<count($cat_id_array);$f++){
					
					if (in_array($cat_id_array[$f], $igit_rpwt_temp['exclude_cat_arr'])){
						// Remove from array
						unset($cat_id_array[$f]);
					}
				}
			}
				
			/**** Reset Index of $cat_id_array ****/
			$cat_id_array = array_values($cat_id_array);
			
			if(!empty($cat_id_array)){
				$resultscat = get_posts(array(
				'category__in' => $cat_id_array,
				'category__not_in' => $igit_rpwt_temp['exclude_cat_arr'],
				'post__not_in' => array(
					$post->ID
				 )
				));
			} else {
				$resultscat = get_posts(array(
				'category__not_in' => $igit_rpwt_temp['exclude_cat_arr'],
				'post__not_in' => array(
					$post->ID
				 )
				));
			}
	
			if ($resultscat && $resultstag) {
				$array1  = objectToArray($resultstag);
				$array2  = objectToArray($resultscat);
				$results = array_intersect($array1, $array2);
			} //$resultscat && $resultstag
			else {
				$resultscat = get_posts(array(
					'category__in' => $cat_id_array,
					'post__not_in' => array(
						$post->ID
					)
				));
				$results    = objectToArray($resultscat);
			}
		} //isset($cat_id_array) && isset($tag_id_array)
		else if (isset($cat_id_array) && !isset($tag_id_array)) {
		
			/*$resultscat = get_posts(array(
			'category__in' => $cat_id_array,
			'category__not_in' => $igit_rpwt_temp['exclude_cat_arr'],
			'post__not_in' => array(
				$post->ID
			 )
			));*/
			
			/** Check if $cat_id_array values exists in exlude cate array, then remove that category from $cat_id_array. **/
			if(!empty($cat_id_array) && !empty($igit_rpwt_temp['exclude_cat_arr'])){
				for($f=0;$f<count($cat_id_array);$f++){
					
					if (in_array($cat_id_array[$f], $igit_rpwt_temp['exclude_cat_arr'])){
						// Remove from array
						unset($cat_id_array[$f]);
					}
				}
			}
		
			/**** Reset Index of $cat_id_array ****/
			$cat_id_array = array_values($cat_id_array);
			
			if(!empty($cat_id_array)){
				$resultscat = get_posts(array(
				'category__in' => $cat_id_array,
				'category__not_in' => $igit_rpwt_temp['exclude_cat_arr'],
				'post__not_in' => array(
					$post->ID
				 )
				));
			} else {
				$resultscat = get_posts(array(
				'category__not_in' => $igit_rpwt_temp['exclude_cat_arr'],
				'post__not_in' => array(
					$post->ID
				 )
				));
			}
			
			
			
			if(!empty($resultscat)){
				 $results    = objectToArray($resultscat);
			}
			else{
				 $results = array();
			}
		
		
		} //isset($cat_id_array) && !isset($tag_id_array)
		else if (!isset($cat_id_array) && isset($tag_id_array)) {
			$resultstag = get_posts(array(
				'tag__in' => $tag_id_array,
				'category__not_in' => $igit_rpwt_temp['exclude_cat_arr'],
				'post__not_in' => array(
					$post->ID
				)
			));
			$results    = objectToArray($resultstag);
		} //!isset($cat_id_array) && isset($tag_id_array)
		else {
			$resultscat = get_posts(array(
				'category__not_in' => $igit_rpwt_temp['exclude_cat_arr'],
				'post__not_in' => array(
					$post->ID
				)
			));
			$results    = objectToArray($resultscat);
		}
	
		if (!$results) {
			$resultscat = get_posts(array(
				'orderby' => 'rand',
				'category__in' => $cat_id_array,
				'post__not_in' => array(
					$post->ID
				)
			));
			$results    = objectToArray($resultscat);
		} //!$results
	
		$output = '<div id="igit_rpwt_css">';
		if ($results) {
			
			//Setting css part for Image size
			$height = $igit_rpwt['thumb_height'] + 4;
			if ($igit_rpwt['text_show']) {
				$output .= $igit_rpwt['text_show'];
			} //$igit_rpwt['text_show']
			else {
				$output .= '<h4>Related Posts :</h4>';
			}
			if ($igit_rpwt['related_post_style'] == '2') {
				$output .= '<ul class="igit_thumb_ul_list">';
			} //$igit_rpwt['related_post_style'] == '2'
			if ($igit_rpwt['related_post_style'] == '3') {
				$output .= '<ul>';
			} //start of raw format tag
			$nodatacnt      = 0;
			$result_counter = 0;
			foreach ($results as $result) {
				$pstincat = false;
				$title    = trim(stripslashes($result['post_title']));
				$image    = ""; // Null Variable to verify for no impage found case
				preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $result['post_content'], $matches);
				if (isset($matches) && !empty($matches[1]) ) {
					$image = $matches[1][0];
					$bgurl = get_bloginfo('url');
					if (!strstr($image, $bgurl)) {
						if($igit_rpwt_temp['default_no_image'] == "")
						$image = WP_PLUGIN_URL . '/'.IGIT_RPWT_PLUGIN_FOLDER_NAME.'/images/noimage.gif'; // when no image found in post 
						else
						$image = $igit_rpwt_temp['default_no_image']; // when no image found in post 
					} //!strstr($image, $bgurl)
				} //isset($matches)
				if (strlen(trim($image)) == 0) {
					if($igit_rpwt_temp['default_no_image'] == "")
					$image = WP_PLUGIN_URL . '/'.IGIT_RPWT_PLUGIN_FOLDER_NAME.'/images/noimage.gif'; // when no image found in post 
					else
					$image = $igit_rpwt_temp['default_no_image']; // when no image found in post 
				} //strlen(trim($image)) == 0
				
			
				$image = parse_url($image, PHP_URL_PATH);
				// Condition for Horizontal Related Posts
				if ($igit_rpwt['related_post_style'] == '1') {
					$divlnk = "onclick=location.href='" . get_permalink($result['ID']) . "'; ";
					$output .= '<div class="igit_relpost" ' . $divlnk . '>';
					if ($igit_rpwt['display_thumb'] == '1') {
						$output .= '<div id="igit_rpwt_main_image" ' . $divlnk . '><a href="' . get_permalink($result['ID']) . '" target="_top"><img id="igit_rpwt_thumb" src="' . WP_PLUGIN_URL . '/'.IGIT_RPWT_PLUGIN_FOLDER_NAME.'/timthumb.php?src=' . IGIT_get_the_image(array(
							'post_id' => $result['ID']
						)) . '&w=' . $igit_rpwt['thumb_width'] . '&h=' . $igit_rpwt['thumb_height'] . '&zc=1"/></a></div>';
					} //$igit_rpwt['display_thumb'] == '1'
					if ($igit_rpwt['display_title'] == '1') {
						if (strlen($title) > 45) {
							$newtitle = substr($title, 0, 45) . '...';
						} //strlen($title) > 45
						else {
							$newtitle = $title;
						}
						$output .= '<div id="igit_title"><a href="' . get_permalink($result['ID']) . '" target="_top">' . $newtitle . '</a></div> ';
					} //$igit_rpwt['display_title'] == '1'
					$output .= '</div>';
					$nodatacnt = 1;
				} //$igit_rpwt['related_post_style'] == '1'
				// Condition for Verticle Related Posts
				if ($igit_rpwt['related_post_style'] == '2') {
					$divlnk = "onclick=location.href='" . get_permalink($result['ID']) . "'; ";
					$output .= '<li id="igit_rpwt_li"  ' . $divlnk . '>';
					if ($igit_rpwt['display_thumb'] == '1') {
						$output .= '<div id="igit_rpwt_main_image" ><a href="' . get_permalink($result['ID']) . '" target="_top"><img id="igit_rpwt_thumb" src="' . WP_PLUGIN_URL . '/'.IGIT_RPWT_PLUGIN_FOLDER_NAME.'/timthumb.php?src=' . IGIT_get_the_image(array(
							'post_id' => $result['ID']
						)) . '&w=' . $igit_rpwt['thumb_width'] . '&h=' . $igit_rpwt['thumb_height'] . '&zc=1"/></a></div>';
					} //$igit_rpwt['display_thumb'] == '1'
					$output .= '<div id="igit_title"><a href="' . get_permalink($result['ID']) . '" target="_top">' . $title . '</a></div></li>';
					$nodatacnt = 1;
				} //$igit_rpwt['related_post_style'] == '2'
				// Condition for simple Related Posts
				if ($igit_rpwt['related_post_style'] == '3') {
					$divlnk = "onclick=location.href='" . get_permalink($result['ID']) . "'; ";
					$output .= '<li id="igit_rpwt_li"' . $divlnk . '><div id="igit_rpwt_main_image"><a href="' . get_permalink($result['ID']) . '" rel="bookmark" target="_top"></div><div id="igit_title">' . $title . '</div></a><div id="description">' . $post_text . '</div></li>';
					$nodatacnt = 1;
				} //$igit_rpwt['related_post_style'] == '3'
				$result_counter++;
				if ($result_counter == $limit)
					break; // End loop when related posts limit is reached
			} //end of foreach loop
			if ($nodatacnt == 0) {
				$output = '<div id="crp_related">';
				$output .= ($crp_settings['blank_output']) ? ' ' : '<p>' . __($igit_rpwt['no_related_post_text'], CRP_LOCAL_NAME) . '</p>';
			} //$nodatacnt == 0
			if ($igit_rpwt['related_post_style'] == '2') {
				$output .= '</ul>';
			} //end of Verticle ul
			if ($igit_rpwt['related_post_style'] == '3') {
				$output .= '</ul>';
			} //end of raw format tag
		} //$results
		else {
			$output = '<div id="crp_related">';
			$output .= ($crp_settings['blank_output']) ? ' ' : '<p>' . __($igit_rpwt['no_related_post_text'], CRP_LOCAL_NAME) . '</p>';
		}
    } //($post->ID != '') || ($igit_search_str != '')
    else {
        $output = '<div id="crp_related">';
        $output .= ($crp_settings['blank_output']) ? ' ' : '<p>' . __($igit_rpwt['no_related_post_text'], CRP_LOCAL_NAME) . '</p>';
    }
    $output .= '</div>';
    return $output;
}
/**
 * get tag id from tag name
 * @param <type> $tag_name
 * @return <type>
 */
if (!function_exists("get_tag_ID")) {
    function get_tag_ID($tag_name)
    {
        $tag = get_term_by('name', $tag_name, 'post_tag');
        if ($tag) {
            return $tag->term_id;
        } //$tag
        else {
            return 0;
        }
    }
} //!function_exists("get_tag_ID")
function objectToArray($objecttemp)
{
    foreach ($objecttemp as $object) {
        if (!is_object($object) && !is_array($object)) {
            return $object;
        } //!is_object($object) && !is_array($object)
        if (is_object($object)) {
            $object = get_object_vars($object);
        } //is_object($object)
        $lastarray[] = $object;
        //return array_map( 'objectToArray', $object );
    } //$objecttemp as $object
    return $lastarray;
}
function igit_rpwt_posts()
{
    $output = igit_show_rel_post();
    echo $output;
}
?>