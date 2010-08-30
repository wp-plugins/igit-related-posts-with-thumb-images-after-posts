<?php
function igit_add_css_style()
{
    global $igit_rpwt, $wpdb, $post, $single, $WP_PLUGIN_URL;
    if (get_option('igit_rpwt')) {
        $igit_rpwt = get_option('igit_rpwt');
    }
    /*if ($igit_rpwt['related_post_style'] == '1')
    {
    $cssfile ='igit-hori.css';
    }
    if ($igit_rpwt['related_post_style'] == '2')
    {
    $cssfile ='igit-vert.css';
    }*/
    //echo "<link rel='stylesheet' href='".IGIT_RPWT_CSS_URL."/".$cssfile."' type='text/css' media='screen' />";
    if ($igit_rpwt['related_post_style'] == '1') {
	//CSS for styles
?>
<style type="text/css">
#igit_rpwt_css {
background:<?php echo "#".$igit_rpwt['bk_color'].";"; ?>
font-family:verdana,arila,serif; 
font-size:12px; 
font-style:normal; 
color:<?php echo "#".$igit_rpwt['fonts_color']; ?> !important;
margin-top:10px;
margin-bottom:10px; 
<?php
if($igit_rpwt['display_thumb'] == '1')
				{
			?>
height:230px;
<?php
}
?>
}
#igit_title 
{
	padding:2px 2px 2px 8px;
	text-align:left;
}
#igit_rpwt_css h4{
color:<?php echo "#".$igit_rpwt['fonts_color'].";"; ?>
}
#igit_title a
{
	color:<?php echo "#".$igit_rpwt['fonts_color'].";"; ?>
}
#igit_rpwt_thumb, #description 
{
	margin-left:0px; 
	border:1px solid <?php echo "#".$igit_rpwt['img_border_color'].";"; ?> 
	padding: 0px;
}
.igit_relpost:hover
{
	background-color:<?php echo "#".$igit_rpwt['bk_hover_color'].";"; ?>
}
.igit_relpost {
border-right-color-ltr-source:physical;
border-right-color-rtl-source:physical;
border-right-color-value:#DDDDDD;
border-right-style-ltr-source:physical;
border-right-style-rtl-source:physical;
border-right-style-value:solid;
border-right-width-ltr-source:physical;
border-right-width-rtl-source:physical;
border-right-width-value:1px;
float:left;
<?php
if($igit_rpwt['display_thumb'] == '1')
				{
			?>
			height:85%;
			<?php
			}
			?>

width:<?php
        echo floor(100 / $igit_rpwt['related_post_num']) . "%";
?>;
}
#igit_rpwt_main_image {
height:100px;
line-height:15;
padding-bottom:10px;
padding-left:2px;
padding-right:2px;
padding-top:2px;
text-align:center;
}
</style>
   

<?php
    }
    if ($igit_rpwt['related_post_style'] == '2') {
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
}
#igit_title {
	padding:2px 2px 2px 0px;
	
}
#igit_title a
{
	color:<?php echo "#".$igit_rpwt['fonts_color'].";"; ?>
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
height:<?php
        echo ($igit_rpwt['thumb_height'] + 5) . "px";
?>;
line-height:15;
padding-bottom:10px;
padding-right:2px;
padding-top:2px;
text-align:left;
width:<?php
        echo ($igit_rpwt['thumb_width'] + 20) . "px";
?>;
}
#igit_rpwt_css ul
{
	margin:0;
}
#igit_rpwt_li 
{ 
	cursor:pointer; 
	list-style:none;
	border-bottom:1px solid #EBDDE2; 
	padding: 5px 5px 10px 10px !important;
}

#igit_rpwt_li:hover{background:<?php echo "#".$igit_rpwt['bk_hover_color'].";"; ?>}
</style>
<?php
    }
    if ($igit_rpwt['related_post_style'] == '3') {
?>
 <style type="text/css">
#igit_rpwt_css {background:<?php echo "#".$igit_rpwt['bk_color'].";"; ?> font-family:verdana,arila,serif; font-size:12px; font-style:normal; color:<?php echo "#".$igit_rpwt['fonts_color']; ?> !important; margin-top:10px;margin-bottom:10px;}

#igit_rpwt_css h4{
color:<?php echo "#".$igit_rpwt['fonts_color'].";"; ?>
}
#igit_title {
	padding:2px 2px 2px 0px;
	
}
#igit_title a
{
	color:<?php echo "#".$igit_rpwt['fonts_color'].";"; ?>
}
#igit_rpwt_thumb, #description {margin-left:0px;}
.igit_relpost:hover
{
	background-color:<?php echo "#".$igit_rpwt['bk_hover_color'].";"; ?>;
}
#igit_rpwt_li { padding: 0px 5px 0px 5px !important;
margin-bottom:1.0em;
}
#igit_rpwt_li:hover{background:<?php echo "#".$igit_rpwt['bk_hover_color'].";"; ?>;}
</style>
<?php
    }
}
function igit_total_content($content)
{
    global $single;
    if (get_option('igit_rpwt')) {
        $igit_rpwt = get_option('igit_rpwt');
    }
    $output = igit_show_rel_post();
    if (is_single()) {
        return $content . $output;
    } else {
        return $content;
    }
}
function igit_show_rel_post()
{
    global $igit_rpwt, $wpdb, $post, $single, $WP_PLUGIN_URL;
    if (!defined('WP_PLUGIN_URL'))
        define('WP_PLUGIN_URL', WP_CONTENT_URL . '/plugins');
    $pluginDir = WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__));
    if (get_option('igit_rpwt')) {
        $igit_rpwt = get_option('igit_rpwt');
    }
    $limit           = (stripslashes($igit_rpwt['related_post_num']));
	if(!$limit)
		$limit = 4;
    $time_difference = get_settings('gmt_offset');
    $now             = gmdate("Y-m-d H:i:s", (time() + ($time_difference * 3600)));
    $pcont = preg_replace('/<img[^>]+./','', $post->post_content);

    $igit_search_str = addslashes($post->post_title . ' ' . $pcont);
   // $igit_search_str = addslashes($post->post_title . ' ' . $post->post_content);
    if (($post->ID != '') || ($igit_search_str != '')) {
        $sql = "SELECT DISTINCT ID,post_title,post_date,post_content," . "MATCH(post_title,post_content) AGAINST ('" . $igit_search_str . "' WITH QUERY EXPANSION) AS score " . "FROM " . $wpdb->posts . " WHERE " . "MATCH (post_title,post_content) AGAINST ('" . $igit_search_str . "'  WITH QUERY EXPANSION) " . "AND post_date <= '" . $now . "' " . "AND post_status = 'publish' AND post_password = '' " . "AND id != " . $post->ID . " AND post_type = 'post' ";
        $sql .= "ORDER BY RAND() LIMIT 0,".$limit;
		
        $result_counter = 0;
        $results        = $wpdb->get_results($sql);
			
		if(!$results)
		{
			$ptags = get_the_tags($post->ID);
			$cstr = "";
			$i=1;
			if($ptags)
			{
			
				foreach($ptags as $ptag)
				{
					if($i < count($ptags))
						$cstr .= " post_title LIKE '%".$ptag->name."%' OR ";
					else if($i == count($ptags))
						$cstr .= " post_title LIKE '%".$ptag->name."%'";
						
					$i++;
				}
				$tags_sql = "SELECT DISTINCT ID,post_title,post_date,post_content FROM " . $wpdb->posts . " WHERE (" .$cstr. ") AND (post_date <= '" . $now . "' " . "AND post_status = 'publish'  AND post_password = '' " . "AND ID != " . $post->ID . " AND post_type = 'post' )";
				$tags_sql .= "ORDER BY RAND() LIMIT 0,".$limit;
				$result_counter = 0;
				$results        = $wpdb->get_results($tags_sql);
			}
		
			if(!$result)
			{
				$random_sql = "SELECT DISTINCT ID, post_title, post_content, post_date,comment_count FROM " . $wpdb->posts . " WHERE post_status = 'publish' AND post_type = 'post' AND post_password = '' AND ID != $post->ID ORDER BY RAND() LIMIT 0,".$limit;
				$result_counter = 0;
				$results        = $wpdb->get_results($random_sql);
			}
			
		}
    } else {
        $results = false;
    }
    $output = '<div id="igit_rpwt_css" style= "border: 0pt none ; margin: 0pt; padding: 0pt; clear: both;">';
    if ($results) {
        //Setting css part for Image size
        $height = $igit_rpwt['thumb_height'] + 4;
		
		if($igit_rpwt['text_show'])
		{
			$output .= $igit_rpwt['text_show'];
		}
		else{
			$output .= '<h4>Related Posts :</h4>';
		}
        
        if ($igit_rpwt['related_post_style'] == '2') {
            $output .= '<ul class="wp_thumbie_ul_list" style="list-style-type: none;">';
        }
        if ($igit_rpwt['related_post_style'] == '3') {
            $output .= '<ul>';
        } //start of raw format tag
		$nodatacnt=0;	
        foreach ($results as $result) {
			
			$categories = get_the_category($result->ID);	
				
		
			$pstincat = false;	
            $title = trim(stripslashes($result->post_title));
            $image = ""; // Null Variable to verify for no impage found case
            preg_match_all('|<img.*?src=[\'"](.*?)[\'"].*?>|i', $result->post_content, $matches);
            if (isset($matches))
			{
                $image = $matches[1][0];
				$bgurl = get_bloginfo('url');
				if(!strstr($image,$bgurl)){
					$image = WP_PLUGIN_URL . '/igit-related-posts-with-thumb-images-after-posts/images/noimage.gif'; // when no image found in post 
				}
			}
            if (strlen(trim($image)) == 0) {
                $image = WP_PLUGIN_URL . '/igit-related-posts-with-thumb-images-after-posts/images/noimage.gif'; // when no image found in post 
            }
            $image = parse_url($image, PHP_URL_PATH);
			
			foreach ($categories as $cat) {	// Loop to check if post exists in excluded category

				$pstincat = (in_array($cat->cat_ID, (array) $igit_rpwt['exclude_cat_arr'])) ? true : false;

				if ($pstincat) break;	// End loop if post found in category

			}
			if (!$pstincat) {
            // Condition for Horizontal Related Posts
            if ($igit_rpwt['related_post_style'] == '1') {
			
                $output .= '<div class="igit_relpost">';
				if($igit_rpwt['display_thumb'] == '1')
				{
					$divlnk =  "onclick=location.href='".get_permalink($result->ID)."'; style=cursor:pointer;";
					$output .=  '<div id="igit_rpwt_main_image" '.$divlnk.'><a href="' . get_permalink($result->ID) . '" target="_top"><img id="igit_rpwt_thumb" src="' . WP_PLUGIN_URL . '/igit-related-posts-with-thumb-images-after-posts/timthumb.php?src=' . $image . '&w=' . $igit_rpwt['thumb_width'] . '&h=' . $igit_rpwt['thumb_height'] . '&zc=1"/></a></div>';
				}
				if(strlen($title) > 45)
				{
					$newtitle = substr($title, 0, 45) .'...';
				}
				else
				{	
					$newtitle = $title;
				}
				$output .= '<div id="igit_title"><a href="' . get_permalink($result->ID) . '" target="_top">' . $newtitle . '</a></div></div> ';
				$nodatacnt = 1;
            }
			
            // Condition for Verticle Related Posts
            if ($igit_rpwt['related_post_style'] == '2') {
				$divlnk =  "onclick=location.href='".get_permalink($result->ID)."'; style=cursor:pointer;";
                $output .= '<li id="igit_rpwt_li" style="height:' . $height . 'px;" '.$divlnk.'>';
				if($igit_rpwt['display_thumb'] == '1')
				{
					$output .= '<div id="igit_rpwt_main_image" ><a href="' . get_permalink($result->ID) . '" target="_top"><img id="igit_rpwt_thumb" src="' . WP_PLUGIN_URL . '/igit-related-posts-with-thumb-images-after-posts/timthumb.php?src=' . $image . '&w=' . $igit_rpwt['thumb_width'] . '&h=' . $igit_rpwt['thumb_height'] . '&zc=1"/></a></div>';
				}
				$output .= '<div id="igit_title"><a href="' . get_permalink($result->ID) . '" target="_top">' . $title . '</a></div></li>';
				$nodatacnt = 1;
            }
            // Condition for simple Related Posts
            if ($igit_rpwt['related_post_style'] == '3') {
				$divlnk =  "onclick=location.href='".get_permalink($result->ID)."'; style=cursor:pointer;";
                $output .= '<li id="igit_rpwt_li"'.$divlnk.'><div id="igit_rpwt_main_image"><a href="' . get_permalink($result->ID) . '" rel="bookmark" target="_top"></div><div id="igit_title">' . $title . '</div></a><div id="description">' . $post_text . '</div></li>';
				$nodatacnt = 1;
            }
            	$result_counter++;
           		 if ($result_counter == $limit)
           		     break; // End loop when related posts limit is reached
			} // End of $pstincat if condition
			
        } //end of foreach loop
		if($nodatacnt == 0)
		{
			$output = '<div id="crp_related">';
        $output .= ($crp_settings['blank_output']) ? ' ' : '<p>' . __('No related posts found', CRP_LOCAL_NAME) . '</p>';
		}
        if ($igit_rpwt['related_post_style'] == '2') {
            $output .= '</ul>';
        } //end of Verticle ul
        if ($igit_rpwt['related_post_style'] == '3') {
            $output .= '</ul>';
        } //end of raw format tag
    } else {
        $output = '<div id="crp_related">';
        $output .= ($crp_settings['blank_output']) ? ' ' : '<p>' . __('No related posts found', CRP_LOCAL_NAME) . '</p>';
    }
	
    $output .= '</div>';
    if ($igit_rpwt['igit_credit'] == "1")
        $output .= '<div style="font-size: 8px; float: left;width:100%;"><a href="http://www.hackingethics.com/">By HackingEthics</a></div>';
    return $output;
}
function igit_rpwt_posts()
{
	$output = igit_show_rel_post();
	echo $output;
}
?>
