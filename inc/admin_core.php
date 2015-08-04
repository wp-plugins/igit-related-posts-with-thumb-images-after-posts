<?php
function igit_admin_enqueue_style()
{
    wp_enqueue_style('my-style', IGIT_RPWT_CSS_URL.'/igit_style.css');
	if (isset($_GET['page']) && $_GET['page'] == 'igit-rpwt') {
		wp_enqueue_style('thickbox');
	}
	
}
function igit_admin_enqueue_script()
{
    wp_enqueue_script('jquery-form');
    wp_enqueue_script('jscolor', IGIT_RPWT_JS_URL.'/jscolor.js');
	if (isset($_GET['page']) && $_GET['page'] == 'igit-rpwt') {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_register_script('my-upload', IGIT_RPWT_JS_URL.'/my-script.js', array('jquery','media-upload','thickbox'));
		wp_enqueue_script('my-upload');
	}
	
}
function igit_plugin_menu()
{
    add_options_page('IGIT Related Posts With Thumbnail After Post - Plugin Options Page', 'IGIT Rel Post With Thumb', 'administrator', 'igit-rpwt', 'igit_rpwt_admin_options');
}
function igit_checked_post_style($value, $rel_style)
{
    $res_val = ($value == $rel_style) ? "selected='selected'" : "";
    return $res_val;
}

function igit_action_javascript()
{
?>
<script type="text/javascript" >
jQuery(document).ready(function($) {
    jQuery('#options_form').submit(function() {
        var i = parseInt(0);
		var j = parseInt(0);
        var exclude_category = [];
		var e = "";
        jQuery(':checkbox:checked').each(function(i) {
            if (jQuery(this).attr('name') == "post_category[]") {
				j = parseInt(j);
				e = "exclude_cat";
               	exclude_category[j] = jQuery(this).val();
				j++;
            }
            
            //val[i] = $(this).val();
        });
		
		
        /*alert(val);
        return false;*/
        tex_show = jQuery('#text_show').attr('value');
		def_no_image = jQuery('#default_no_image').attr('value');
        no_related_post_tex = jQuery('#no_related_post_text').attr('value');
        aut_show = jQuery('#auto_show:checked').val();
        rel_post_num = jQuery('#related_post_num').attr('value');
		dis_timthumb = jQuery('#disable_timthumb:checked').val();
		dis_hardcrop = jQuery('#disable_hardcrop:checked').val();
		
        dis_thumb = jQuery('#display_thumb:checked').val();
        dis_title = jQuery('#display_title:checked').val();
        dis_full_title = jQuery('#display_full_title:checked').val();
        tit_characters = jQuery('#title_characters').attr('value');
        if (!dis_thumb && !dis_title) {
            alert("Display Thumb and Display Title both can't be unchecked to show related posts.So at least select one from both.");
            return false;
        }
        thu_width = jQuery('#thumb_width').attr('value');
        thu_height = jQuery('#thumb_height').attr('value');
        rel_post_style = jQuery('#related_post_style').attr('value');
        igit_cre = jQuery('#igit_credit:checked').val();
		excludecatornot = e;


        bk_color_temp = jQuery('#bk_color').attr('value');
        bk_hover_color_temp = jQuery('#bk_hover_color').attr('value');
        fonts_family_temp = jQuery('#fonts_family').attr('value');
        fonts_color_temp = jQuery('#fonts_color').attr('value');
        fonts_size_temp = jQuery('#fonts_size').attr('value');
        img_border_color_temp = jQuery('#img_border_color').attr('value');
        exl_cat = exclude_category;
        if ((rel_post_style == 1) && rel_post_num > 5) {
            alert("if you select post style Horizontal then Related post number should be less then or equal to 5.");
            document.options_form.related_post_num.select();
            return false;
        }
        jQuery('#loading_img').show();
        var arv = exl_cat.toString();
        // This line converts js array to String 
        document.options_form.hid_exl_cat.value = arv;

        var data = {
            action: 'igit_save_ajax',
            text_show: tex_show,
			default_no_image: def_no_image,
            no_related_post_text: no_related_post_tex,
            auto_show: aut_show,
            related_post_num: rel_post_num,
			disable_timthumb: dis_timthumb,
            disable_hardcrop: dis_hardcrop,			
            display_thumb: dis_thumb,
            display_title: dis_title,
            display_full_title: dis_full_title,
            title_characters: tit_characters,
            thumb_width: thu_width,
            thumb_height: thu_height,
            related_post_style: rel_post_style,
            igit_credit: igit_cre,
			exclude_cat_or_not: excludecatornot,
			igit_credit: igit_cre,
            exclude_category: document.options_form.hid_exl_cat.value,
            bk_color: bk_color_temp,
            bk_hover_color: bk_hover_color_temp,
            fonts_family: fonts_family_temp,
            fonts_size: fonts_size_temp,
            fonts_color: fonts_color_temp,
            img_border_color: img_border_color_temp
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            jQuery('#loading_img').fadeOut(300, function() {
                jQuery('#igit_div_success').fadeIn(1000, function() {
                    jQuery('#igit_div_success').fadeOut(2000);
                });
            });

            $("#frm_fields").html(response);
            if (jscolor.binding) {
                jscolor.bind();
            }
        });
        return false;
    });
});
</script>
<?php
}
function igit_action_callback()
{
    global $wpdb; // this is how you get access to the database
    global $igit_rpwt;
	if(!isset($post_ID)){
		$post_ID = 0;
	}
	if($_POST['exclude_cat_or_not'] == "exclude_cat"){
		$exclude_cat_arr = explode(",",$_POST['exclude_category']);
		$exclude_cat_arr = array_values($exclude_cat_arr);
	}
	else{
		$exclude_cat_arr = "";
	}
	
	
	$text_show   = ($_POST['text_show'] == "") ? $igit_rpwt['text_show'] : $_POST['text_show'];
	$default_no_image   = ($_POST['default_no_image'] == "") ? $igit_rpwt['default_no_image'] : $_POST['default_no_image'];
	$no_related_post_text   = ($_POST['no_related_post_text'] == "") ? $igit_rpwt['no_related_post_text'] : $_POST['no_related_post_text'];
	$auto_show   = ($_POST['auto_show'] == "") ? 2 : $_POST['auto_show'];
    $related_post_num   = ($_POST['related_post_num'] == "") ? $igit_rpwt['related_post_num'] : $_POST['related_post_num'];
	
	$disable_timthumb      = ($_POST['disable_timthumb'] == "") ? 2 : $_POST['disable_timthumb'];
	$disable_hardcrop      = ($_POST['disable_hardcrop'] == "") ? 2 : $_POST['disable_hardcrop'];
	
    $display_thumb      = ($_POST['display_thumb'] == "") ? 2 : $_POST['display_thumb'];
	$display_title      = ($_POST['display_title'] == "") ? 2 : $_POST['display_title'];
	$display_full_title      = ($_POST['display_full_title'] == "") ? 2 : $_POST['display_full_title'];
	$title_characters      = ($_POST['title_characters'] == "") ? 2 : $_POST['title_characters'];
    $thumb_width        = ($_POST['thumb_width'] == "") ? $igit_rpwt['thumb_width'] : $_POST['thumb_width'];
    $thumb_height       = ($_POST['thumb_height'] == "") ? $igit_rpwt['thumb_height'] : $_POST['thumb_height'];
    $related_post_style = ($_POST['related_post_style'] == "") ? $igit_rpwt['related_post_style'] : $_POST['related_post_style'];
    //$igit_credit        = ($_POST['igit_credit'] == "") ? 2 : $_POST['igit_credit'];
	$bk_color = ($_POST['bk_color'] == "") ? $igit_rpwt['bk_color'] : $_POST['bk_color'];
	$bk_hover_color = ($_POST['bk_hover_color'] == "") ? $igit_rpwt['bk_hover_color'] : $_POST['bk_hover_color'];
	$fonts_family = ($_POST['fonts_family'] == "") ? $igit_rpwt['fonts_family'] : $_POST['fonts_family'];
	$fonts_size = ($_POST['fonts_size'] == "") ? $igit_rpwt['fonts_size'] : $_POST['fonts_size'];
	$fonts_color = ($_POST['fonts_color'] == "") ? $igit_rpwt['fonts_color'] : $_POST['fonts_color'];
	$img_border_color = ($_POST['img_border_color'] == "") ? $igit_rpwt['img_border_color'] : $_POST['img_border_color'];
    $igit_rpwt          = array(
		"text_show" => $text_show,
		"default_no_image" => $default_no_image,
		"no_related_post_text" => $no_related_post_text,
		"auto_show" => $auto_show,
        "related_post_num" => $related_post_num,
		"disable_timthumb" => $disable_timthumb,
		"disable_hardcrop" => $disable_hardcrop,		
        "display_thumb" => $display_thumb,
		"display_title" => $display_title,
		"display_full_title" => $display_full_title,
		"title_characters" => $title_characters,
        "thumb_width" => $thumb_width,
        "thumb_height" => $thumb_height,
        "related_post_style" => $related_post_style,
        /*"igit_credit" => $igit_credit,*/
        "exclude_cat_arr" => $exclude_cat_arr,
		"bk_color" => $bk_color,
		"bk_hover_color" => $bk_hover_color,
		"fonts_family" => $fonts_family,
		"fonts_size" => $fonts_size,
		"fonts_color" => $fonts_color,
		"img_border_color" => $img_border_color
    );
    update_option('igit_rpwt', $igit_rpwt);
    $igit_rpwt    = get_option('igit_rpwt');
	$exclude_cat_arr = $igit_rpwt['exclude_cat_arr'];
	$result = "";
    $result = $result . '<div class="updated fade below-h2" id="message"><p>Options updated.</p></div><table class="form-table"><tbody>';
	$auto_chckd_ajax = ($igit_rpwt['auto_show'] == "1") ? "checked=checked" : "";
	$result = $result . '<tr valign="top"><th scope="row"><label for="blogname">Automatically Show related Posts After Post :<strong>(Tick If Yes)</strong></label></th>
	<td style="vertical-align:middle;"><input type="checkbox" id="auto_show" name="auto_show" value="1" ' . $auto_chckd_ajax . '/>&nbsp;&nbsp;<strong>(Do not tick if you want to place related posts Manually.)</strong></td></tr><tr valign="top"><th scope="row"><label for="blogname">Manually Placing of Related Posts :</label></th>
	<td><code>&lt;?php if(function_exists(&#39;igit_rpwt_posts&#39;)) igit_rpwt_posts(); ?&gt;</code></td></tr><tr valign="top"><th scope="row"><label for="blogname">Heading Text :</label></th><td><input type="text" class="code" value="' . $igit_rpwt['text_show'] . '" id="text_show" name="text_show" maxlength="100" size="30"/></td></tr><tr valign="top"><th scope="row"><label for="blogname">Default No Image :</label></th><td><input type="text" class="code" value="' . $igit_rpwt['default_no_image'] . '" id="default_no_image" name="default_no_image"  size="30"/><input id="upload_no_image_button" type="button" value="Upload Image"/></td></tr><tr valign="top"><th scope="row"><label for="blogname">No Related Posts Text :</label></th><td><input type="text" class="code" value="' . $igit_rpwt['no_related_post_text'] . '" id="no_related_post_text" name="no_related_post_text" maxlength="100" size="30"/></td></tr><tr valign="top"><th scope="row"><label for="blogname">Select Categories To Exclude From Related Postsssds :</label> </th><td><div id="categories-all" class="tabs-panel" style="overflow:auto;height:140px;width:250px;"><ul id="categorychecklist" class="list:category categorychecklist form-no-clear">';
	$result1 = "";
	$result1 = $result1 .'</ul></div></td></tr><tr valign="top"><th scope="row"><label for="blogname">How Many Related Posts Want to Show?</label></th><td><input type="text" class="code" value="' . $igit_rpwt['related_post_num'] . '" id="related_post_num" name="related_post_num" maxlength="2" size="4"/><code>Dont\'t Enter Greater Then 4 to Get Good Results.</code></td></tr>';
    $chckdtim = ($igit_rpwt['disable_timthumb'] == "1") ? "checked=checked" : "";
	$result1 = $result1 . '<tr valign="top"><th scope="row"><label for="blogname">Disable Timthumb?</label></th><td><input type="checkbox" id="disable_timthumb" name="disable_timthumb" value="1" ' . $chckdtim . '/></td></tr>';
	
	$chckdcrop = ($igit_rpwt['disable_hardcrop'] == "1") ? "checked=checked" : "";
	$result1 = $result1 . '<tr valign="top"><th scope="row"><label for="blogname">Disable Hard Crop?</label></th><td><input type="checkbox" id="disable_hardcrop" name="disable_hardcrop" value="1" ' . $chckdcrop . '/><code>This setting will not work if Timthumb disabled in above option.</code></td></tr>';
	
	$chckd = ($igit_rpwt['display_thumb'] == "1") ? "checked=checked" : "";
    $result1 = $result1 . '<tr valign="top"><th scope="row"><label for="blogname">Display Thumb?</label></th><td><input type="checkbox" id="display_thumb" name="display_thumb" value="1" ' . $chckd . '/></td></tr>';
    $chckdtc = ($igit_rpwt['display_title'] == "1") ? "checked=checked" : "";
	$chckdfulltc = ($igit_rpwt['display_full_title'] == "1") ? "checked=checked" : "";
    $result1      = $result1 . '<tr valign="top"><th scope="row"><label for="blogname">Display Title?</label></th><td><input type="checkbox" id="display_title" name="display_title" value="1" ' . $chckdtc . '/><code>This setting will only work for Horizontal Style of related posts.</code></td></tr><tr valign="top"><th scope="row"><label for="blogname">Display Full Title?</label></th><td><input type="checkbox" id="display_full_title" name="display_full_title" value="1" ' . $chckdfulltc . '/></td></tr><tr valign="top"><th scope="row"><label for="blogname">How Many Characters want to show for Post Title?</label></th><td><input type="text" class="code" value="' . $igit_rpwt['title_characters'] . '" id="title_characters" name="title_characters" maxlength="3" size="4"/><code>It will work If "Display Full Title" option unchecked.</code></td></tr><th scope="row"><label for="blogname">Select Background Color </label></th><td><input class="color" value="' . $igit_rpwt['bk_color'] . '"  id="bk_color" name="bk_color" ></td></tr><tr valign="top"><th scope="row"><label for="blogname">Select On Hover Background Color: </label></th><td><input class="color" value="' . $igit_rpwt['bk_hover_color'] . '"  id="bk_hover_color" name="bk_hover_color" ></td></tr>';
   	$chkfont1 = igit_checked_post_style('Arial', $igit_rpwt['fonts_family']);
	$chkfont2 = igit_checked_post_style('Book Antiqua', $igit_rpwt['fonts_family']);
	$chkfont3 = igit_checked_post_style('Bookman Old Style', $igit_rpwt['fonts_family']);
	$chkfont4 = igit_checked_post_style('Calibri', $igit_rpwt['fonts_family']);
	$chkfont5 = igit_checked_post_style('Century Schoolbook', $igit_rpwt['fonts_family']);
	$chkfont6 = igit_checked_post_style('Courier New', $igit_rpwt['fonts_family']);
	$chkfont7 = igit_checked_post_style('Geneva', $igit_rpwt['fonts_family']);
	$chkfont8 = igit_checked_post_style('Georgia', $igit_rpwt['fonts_family']);
	$chkfont9 = igit_checked_post_style('Helvetica', $igit_rpwt['fonts_family']);
	$chkfont10 = igit_checked_post_style('Monotype Corsiva', $igit_rpwt['fonts_family']);
	$chkfont11 = igit_checked_post_style('Times New Roman', $igit_rpwt['fonts_family']);
	$chkfont12 = igit_checked_post_style('Trebuchet MS', $igit_rpwt['fonts_family']);
	$chkfont13 = igit_checked_post_style('Verdana', $igit_rpwt['fonts_family']);
    $result1       = $result1 . '<tr valign="top"><th scope="row"><label for="blogname">Select Fonts : </label></th><td><select id="fonts_family" name="fonts_family"><option value="Arial" ' . $chkfont1 . '>Arial</option><option value="Book Antiqua" ' . $chkfont2 . '>Book Antiqua</option><option value="Bookman Old Style" ' . $chkfont3 . '>Bookman Old Style</option><option value="Calibri" ' . $chkfont4 . '>Calibri</option><option value="Century Schoolbook" ' . $chkfont5 . '>Century Schoolbook</option><option value="Courier New" ' . $chkfont6 . '>Courier New</option><option value="Geneva" ' . $chkfont7 . '>Geneva</option><option value="Georgia" ' . $chkfont8 . '>Georgia</option><option value="Helvetica" ' . $chkfont9 . '>Helvetica</option><option value="Monotype Corsiva" ' . $chkfont10 . '>Monotype Corsiva</option><option value="Times New Roman" ' . $chkfont11 . '>Times New Roman</option><option value="Trebuchet MS" ' . $chkfont12 . '>Trebuchet MS</option><option value="Verdana" ' . $chkfont13 . '>Verdana</option></select></td></tr><tr valign="top"><th scope="row"><label for="blogname">Fonts Size: </label></th><td><input type="text" class="code"  value="' . $igit_rpwt['fonts_size'] . '"  id="fonts_size" name="fonts_size"  maxlength="2" size="4"><code>px</code></td></tr><tr valign="top"><th scope="row"><label for="blogname">Select Fonts Color: </label></th><td><input class="color" value="' . $igit_rpwt['fonts_color'] . '"  id="fonts_color" name="fonts_color" ></td></tr><tr valign="top"><th scope="row"><label for="blogname">Select Image Border Color: </label></th><td><input class="color" value="' . $igit_rpwt['img_border_color'] . '"  id="img_border_color" name="img_border_color" ></td></tr><tr valign="top"><th scope="row"><label for="blogname">Thumb Width :</label></th><td><input type="text" class="regular-text code" value="' . $igit_rpwt['thumb_width'] . '" id="thumb_width" name="thumb_width" />&nbsp;(In Pixels(px))</td></tr><tr valign="top"><th scope="row"><label for="blogname">Thumb Height :</label></th><td><input type="text" class="regular-text code" value="' . $igit_rpwt['thumb_height'] . '" id="thumb_height" name="thumb_height"/>&nbsp;(In Pixels(px))</td></tr>';
	$chk1 = igit_checked_post_style(1, $igit_rpwt['related_post_style']);
    $result1 = $result1 . '<tr valign="top"><th scope="row"><label for="blogname">Related Posts Style</label></th><td><select name="related_post_style" id="related_post_style"><option>--Select--</option><option value="1" ' . $chk1 . '>Horizontal Format</option>';
    $chk2 = igit_checked_post_style(2, $igit_rpwt['related_post_style']);
    $result1 = $result1 . '<option value="2" ' . $chk2 . '>Verticle Format</option>';
    $chk3 = igit_checked_post_style(3, $igit_rpwt['related_post_style']);
   // $chckd_credit = ($igit_rpwt['igit_credit'] == "1") ? "checked=checked" : "";
    $result1 = $result1 . '<option value="3" ' . $chk3 . '>Raw Format (<code>&lt;ul&gt; &lt;li&gt;</code>)</option></select></td></tr><tr valign="top"><th scope="row" colspan="2"></td></tr></tbody></table>';
    echo $result;
	wp_category_checklist_IGIT($post_ID, false,$exclude_cat_arr);
	echo $result1;
    die();
}
function igit_rpwt_admin_options()
{
    global $igit_rpwt,$igit_rpwt_default, $plgin_dir;
	if(!isset($post_ID)){
		$post_ID = 0;
	}
    if (isset($_POST['sb_submit'])) 
	{
        $igit_rpwt = array(
			"text_show" => $_POST['text_show'],
			"default_no_image" => $_POST['default_no_image'],
			"no_related_post_text" => $_POST['no_related_post_text'],
			"auto_show" => $_POST['auto_show'],
            "num_posts" => $_POST['related_post_num'],
			"dis_timthumb" => $_POST['disable_timthumb'],
			"dis_hardcrop" => $_POST['disable_hardcrop'],			
            "dis_thumb" => $_POST['display_thumb'],
			"dis_title" => $_POST['display_title'],
			"display_full_title" => $_POST['display_full_title'],
			"title_characters" => $_POST['title_characters'],
            "thumb_width" => $_POST['thumb_width'],
            "thumb_height" => $_POST['thumb_height'],
            "rel_post_style" => $_POST['related_post_style'],
            "bk_color" => $_POST['bk_color'],
            "bk_hover_color" => $_POST['bk_hover_color'],
			"fonts_family" => $_POST['fonts_family'],
			"fonts_size" => $_POST['fonts_size'],
            "fonts_color" => $_POST['fonts_color'],
            "img_border_color" => $_POST['img_border_color']
        );
        update_option('igit_rpwt', $igit_rpwt);
        $message_succ = '<div id="message" class="updated fade"><p>Option Saved!</p></div>';
    } else {
        $message_succ       = "";
        $igit_rpwt_new      = get_option('igit_rpwt');
		if($igit_rpwt_new)
		{
			if (!array_key_exists('default_no_image', $igit_rpwt_new)) {
				$igit_rpwt_new['default_no_image'] = $igit_rpwt_default['default_no_image'];
			
			}
			if (!array_key_exists('no_related_post_text', $igit_rpwt_new)) {
				$igit_rpwt_new['no_related_post_text'] = $igit_rpwt_default['no_related_post_text'];
			
			}
			if (!array_key_exists('disable_timthumb', $igit_rpwt_new)) {
				$igit_rpwt_new['disable_timthumb'] = $igit_rpwt_default['disable_timthumb'];
			
			}
			if (!array_key_exists('disable_hardcrop', $igit_rpwt_new)) {
				$igit_rpwt_new['disable_hardcrop'] = $igit_rpwt_default['disable_hardcrop'];
			
			}
			if (!array_key_exists('display_title', $igit_rpwt_new)) {
				$igit_rpwt_new['display_title'] = $igit_rpwt_default['display_title'];
			
			}
			if (!array_key_exists('fonts_family', $igit_rpwt_new)) {
				$igit_rpwt_new['fonts_family'] = $igit_rpwt_default['fonts_family'];
			
			}
			if (!array_key_exists('fonts_size', $igit_rpwt_new)) {
				$igit_rpwt_new['fonts_size'] = $igit_rpwt_default['fonts_size'];
			
			}
			if (!array_key_exists('display_full_title', $igit_rpwt_new)) {
				$igit_rpwt_new['display_full_title'] = $igit_rpwt_default['display_full_title'];
			
			}
			if (!array_key_exists('title_characters', $igit_rpwt_new)) {
				$igit_rpwt_new['title_characters'] = $igit_rpwt_default['title_characters'];
			
			}
		}
		$text_show   = ($igit_rpwt_new['text_show'] == "") ? $igit_rpwt['text_show'] : $igit_rpwt_new['text_show'];
		$default_no_image   = ($igit_rpwt_new['default_no_image'] == "") ? $igit_rpwt['default_no_image'] : $igit_rpwt_new['default_no_image'];
		$no_related_post_text   = ($igit_rpwt_new['no_related_post_text'] == "") ? $igit_rpwt['no_related_post_text'] : $igit_rpwt_new['no_related_post_text'];
		$auto_show   = ($igit_rpwt_new['auto_show'] == "") ? $igit_rpwt['auto_show'] : $igit_rpwt_new['auto_show'];
		$related_post_num   = ($igit_rpwt_new['related_post_num'] == "") ? $igit_rpwt['related_post_num'] : $igit_rpwt_new['related_post_num'];
		
		$disable_timthumb      = ($igit_rpwt_new['disable_timthumb'] == "") ? $igit_rpwt['disable_timthumb'] : $igit_rpwt_new['disable_timthumb'];
		$disable_hardcrop      = ($igit_rpwt_new['disable_hardcrop'] == "") ? $igit_rpwt['disable_hardcrop'] : $igit_rpwt_new['disable_hardcrop'];
		
		$display_thumb      = ($igit_rpwt_new['display_thumb'] == "") ? $igit_rpwt['display_thumb'] : $igit_rpwt_new['display_thumb'];
		$display_title      = ($igit_rpwt_new['display_title'] == "") ? $igit_rpwt['display_title'] : $igit_rpwt_new['display_title'];
		$display_full_title      = ($igit_rpwt_new['display_full_title'] == "") ? $igit_rpwt['display_full_title'] : $igit_rpwt_new['display_full_title'];
		$title_characters   = ($igit_rpwt_new['title_characters'] == "") ? $igit_rpwt['title_characters'] : $igit_rpwt_new['title_characters'];
		$thumb_width        = ($igit_rpwt_new['thumb_width'] == "") ? $igit_rpwt['thumb_width'] : $igit_rpwt_new['thumb_width'];
		$thumb_height       = ($igit_rpwt_new['thumb_height'] == "") ? $igit_rpwt['thumb_height'] : $igit_rpwt_new['thumb_height'];
		$related_post_style = ($igit_rpwt_new['related_post_style'] == "") ? $igit_rpwt['related_post_style'] : $igit_rpwt_new['related_post_style'];
		//$igit_credit        = ($igit_rpwt_new['igit_credit'] == "") ? $igit_rpwt['igit_credit'] : $igit_rpwt_new['igit_credit'];
		
		$bk_color        = ($igit_rpwt_new['bk_color'] == "") ? $igit_rpwt['bk_color'] : $igit_rpwt_new['bk_color'];
		$bk_hover_color        = ($igit_rpwt_new['bk_hover_color'] == "") ? $igit_rpwt['bk_hover_color'] : $igit_rpwt_new['bk_hover_color'];
		$fonts_family        = ($igit_rpwt_new['fonts_family'] == "") ? $igit_rpwt['fonts_family'] : $igit_rpwt_new['fonts_family'];
		$fonts_size        = ($igit_rpwt_new['fonts_size'] == "") ? $igit_rpwt['fonts_size'] : $igit_rpwt_new['fonts_size'];
		$fonts_color        = ($igit_rpwt_new['fonts_color'] == "") ? $igit_rpwt['fonts_color'] : $igit_rpwt_new['fonts_color'];
		$img_border_color        = ($igit_rpwt_new['img_border_color'] == "") ? $igit_rpwt['img_border_color'] : $igit_rpwt_new['img_border_color'];
		$exclude_cat_arr    = $igit_rpwt_new['exclude_cat_arr'];
		$igit_rpwt          = array(
		"text_show" => $text_show,
		"default_no_image" => $default_no_image,
		"no_related_post_text" => $no_related_post_text,
		"auto_show" => $auto_show,
		"related_post_num" => $related_post_num,
		"disable_timthumb" => $disable_timthumb,
		"disable_hardcrop" => $disable_hardcrop,
		"display_thumb" => $display_thumb,
		"display_title" => $display_title,
		"display_full_title" => $display_full_title,
		"title_characters" => $title_characters,
		"thumb_width" => $thumb_width,
		"thumb_height" => $thumb_height,
		"related_post_style" => $related_post_style,
		/*"igit_credit" => $igit_credit,*/
		"bk_color" => $bk_color,
		"bk_hover_color" => $bk_hover_color,
		"fonts_family" => $fonts_family,
		"fonts_size" => $fonts_size,
		"fonts_color" => $fonts_color,
		"img_border_color" => $img_border_color
		);
    }
    echo $message_succ . '<div class="wrap"><div id="icon-options-general" class="icon32"><br/></div><div style="width: 70%; float: left;"><form id="options_form" name="options_form" method="post" action=""><input type="hidden" id="hid_exl_cat" name="hid_exl_cat" value=""><h2 style="display:inline-block;float:left;">IGIT Related Posts With Thumb</h2><div style="padding-left: 10px;height: 22px;    padding-top: 16px;    padding-bottom: 10px;    border-bottom: 1px solid;"><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FHackingEthics&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=35&amp;appId=422733157774758" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:35px;" allowTransparency="true"></iframe></div><div id="siteads" class="igit_ads_block fade below-h2"><p><a href="http://php-freelancer.in/contact-me/" target="_blank" style="    text-decoration: none;">Want to Hire Website Developer, PHP Developer or Wordpress Developer? Hire us.</a></p></div><div id="frm_fields"><table class="form-table"><tbody>';
	$auto_chckd = ($igit_rpwt['auto_show'] == "1") ? "checked=checked" : "";
	echo $message_succ . '<tr valign="top"><th scope="row"><label for="blogname">Automatically Show related Posts After Post :<strong>(Tick If Yes)</strong></label></th><td style="vertical-align:middle;"><input type="checkbox" id="auto_show" name="auto_show" value="1" ' . $auto_chckd . '/>&nbsp;&nbsp;<strong>(Do not tick if you want to place related posts Manually.)</strong> </td></tr><tr valign="top"><th scope="row"><label for="blogname">Manually Placing of Related Posts :</label></th><td><code>&lt;?php if(function_exists(&#39;igit_rpwt_posts&#39;)) igit_rpwt_posts(); ?&gt;</code></td></tr><tr valign="top"><th scope="row"><label for="blogname">Heading Text :</label></th><td><input type="text" class="code" value="' . $igit_rpwt['text_show'] . '" id="text_show" name="text_show" maxlength="100" size="30"/></td></tr><tr valign="top"><th scope="row"><label for="blogname">Default No Image :</label></th><td><input type="text" class="code" value="' . $igit_rpwt['default_no_image'] . '" id="default_no_image" name="default_no_image"  size="30"/><input id="upload_no_image_button" type="button" value="Upload Image"/></td></tr><tr valign="top"><th scope="row"><label for="blogname">No Related Posts Text :</label></th><td><input type="text" class="code" value="' . $igit_rpwt['no_related_post_text'] . '" id="no_related_post_text" name="no_related_post_text" maxlength="100" size="30"/></td></tr><tr valign="top"><th scope="row"><label for="blogname">Select Categories To Exclude From Related Posts :</label> </th><td><div id="categories-all" class="tabs-panel" style="overflow:auto;height:140px;width:250px;"><ul id="categorychecklist" class="list:category categorychecklist form-no-clear">';
	echo $message_succ. wp_category_checklist_IGIT($post_ID, false,$exclude_cat_arr);
	echo $message_succ.'</ul></div><td></tr><tr valign="top"><th scope="row"><label for="blogname">How Many Related Posts Want to Show?</label></th><td><input type="text" class="code" value="' . $igit_rpwt['related_post_num'] . '" id="related_post_num" name="related_post_num" maxlength="2" size="4"/><code>Dont\'t Enter Greater Then 4 to Get Good Results.</code></td></tr>';
	
	$chckdtim = ($igit_rpwt['disable_timthumb'] == "1") ? "checked=checked" : "";
	echo $message_succ . '<tr valign="top"><th scope="row"><label for="blogname">Disable Timthumb?</label></th><td><input type="checkbox" id="disable_timthumb" name="disable_timthumb" value="1" ' . $chckdtim . '/></td></tr>';
	
	$chckdcrop = ($igit_rpwt['disable_hardcrop'] == "1") ? "checked=checked" : "";
	echo $message_succ . '<tr valign="top"><th scope="row"><label for="blogname">Disable Hard Crop?</label></th><td><input type="checkbox" id="disable_hardcrop" name="disable_hardcrop" value="1" ' . $chckdcrop . '/><code>This setting will not work if Timthumb disabled in above option.</code></td></tr>';
	
    $chckd = ($igit_rpwt['display_thumb'] == "1") ? "checked=checked" : "";
    echo $message_succ . '<tr valign="top"><th scope="row"><label for="blogname">Display Thumb?</label></th><td><input type="checkbox" id="display_thumb" name="display_thumb" value="1" ' . $chckd . '/></td></tr>';
    $chckdt = ($igit_rpwt['display_title'] == "1") ? "checked=checked" : "";
	$chckdfullt = ($igit_rpwt['display_full_title'] == "1") ? "checked=checked" : "";
    echo $message_succ . '<tr valign="top"><th scope="row"><label for="blogname">Display Title?</label></th><td><input type="checkbox" id="display_title" name="display_title" value="1" ' . $chckdt . '/><code>This setting will only work for Horizontal Style of related posts.</code></td></tr><tr valign="top"><th scope="row"><label for="blogname">Display Full Title?</label></th><td><input type="checkbox" id="display_full_title" name="display_full_title" value="1" ' . $chckdfullt . '/></td></tr><tr valign="top"><th scope="row"><label for="blogname">How Many Characters want to show for Post Title?</label></th><td><input type="text" class="code" value="' . $igit_rpwt['title_characters'] . '" id="title_characters" name="title_characters" maxlength="2" size="4"/><code>It will work If "Display Full Title" option unchecked.</code></td></tr><tr valign="top"><th scope="row"><label for="blogname">Select Background Color </label></th><td><input class="color" value="' . $igit_rpwt['bk_color'] . '"  id="bk_color" name="bk_color" ></td></tr><tr valign="top"><th scope="row"><label for="blogname">Select On Hover Background Color: </label></th><td><input class="color" value="' . $igit_rpwt['bk_hover_color'] . '"  id="bk_hover_color" name="bk_hover_color" ></td></tr>';
    $chkfont1 = igit_checked_post_style('Arial', $igit_rpwt['fonts_family']);
	$chkfont2 = igit_checked_post_style('Book Antiqua', $igit_rpwt['fonts_family']);
	$chkfont3 = igit_checked_post_style('Bookman Old Style', $igit_rpwt['fonts_family']);
	$chkfont4 = igit_checked_post_style('Calibri', $igit_rpwt['fonts_family']);
	$chkfont5 = igit_checked_post_style('Century Schoolbook', $igit_rpwt['fonts_family']);
	$chkfont6 = igit_checked_post_style('Courier New', $igit_rpwt['fonts_family']);
	$chkfont7 = igit_checked_post_style('Geneva', $igit_rpwt['fonts_family']);
	$chkfont8 = igit_checked_post_style('Georgia', $igit_rpwt['fonts_family']);
	$chkfont9 = igit_checked_post_style('Helvetica', $igit_rpwt['fonts_family']);
	$chkfont10 = igit_checked_post_style('Monotype Corsiva', $igit_rpwt['fonts_family']);
	$chkfont11 = igit_checked_post_style('Times New Roman', $igit_rpwt['fonts_family']);
	$chkfont12 = igit_checked_post_style('Trebuchet MS', $igit_rpwt['fonts_family']);
	$chkfont13 = igit_checked_post_style('Verdana', $igit_rpwt['fonts_family']);
    echo $message_succ . '<tr valign="top">
							<th scope="row"><label for="blogname">Select Fonts : </label></th>
							<td><select id="fonts_family" name="fonts_family">
							<option value="Arial" ' . $chkfont1 . '>Arial</option>
							<option value="Book Antiqua" ' . $chkfont2 . '>Book Antiqua</option>
							<option value="Bookman Old Style" ' . $chkfont3 . '>Bookman Old Style</option>
							<option value="Calibri" ' . $chkfont4 . '>Calibri</option>
							<option value="Century Schoolbook" ' . $chkfont5 . '>Century Schoolbook</option>
							<option value="Courier New" ' . $chkfont6 . '>Courier New</option>
							<option value="Geneva" ' . $chkfont7 . '>Geneva</option>
							<option value="Georgia" ' . $chkfont8 . '>Georgia</option>
							<option value="Helvetica" ' . $chkfont9 . '>Helvetica</option>
							<option value="Monotype Corsiva" ' . $chkfont10 . '>Monotype Corsiva</option>
							<option value="Times New Roman" ' . $chkfont11 . '>Times New Roman</option>
							<option value="Trebuchet MS" ' . $chkfont12 . '>Trebuchet MS</option>
							<option value="Verdana" ' . $chkfont13 . '>Verdana</option>
							</select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Fonts Size: </label></th>
					<td><input type="text" class="code"  value="' . $igit_rpwt['fonts_size'] . '"  id="fonts_size" name="fonts_size"  maxlength="2" size="4"><code>px</code></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Select Fonts Color: </label></th>
					<td><input class="color" value="' . $igit_rpwt['fonts_color'] . '"  id="fonts_color" name="fonts_color" ></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Select Image Border Color: </label></th>
					<td><input class="color" value="' . $igit_rpwt['img_border_color'] . '"  id="img_border_color" name="img_border_color" ></td>
				</tr>
                <tr valign="top">
				<th scope="row"><label for="blogname">Thumb Width :</label></th>
					<td><input type="text" class="regular-text code" value="' . $igit_rpwt['thumb_width'] . '" id="thumb_width" name="thumb_width" />&nbsp;(In Pixels(px))</td>
				</tr>
                <tr valign="top">
				<th scope="row"><label for="blogname">Thumb Height :</label></th>
					<td><input type="text" class="regular-text code" value="' . $igit_rpwt['thumb_height'] . '" id="thumb_height" name="thumb_height"/>&nbsp;(In Pixels(px))</td>
				</tr>';
    $chk1 = igit_checked_post_style(1, $igit_rpwt['related_post_style']);
    echo $message_succ . '<tr valign="top"><th scope="row"><label for="blogname">Related Posts Style</label></th><td><select name="related_post_style"  id="related_post_style"><option>--Select--</option><option value="1" ' . $chk1 . '>Horizontal Format</option>';
    $chk2 = igit_checked_post_style(2, $igit_rpwt['related_post_style']);
    echo $message_succ . '<option value="2" ' . $chk2 . '>Verticle Format</option>';
    $chk3         = igit_checked_post_style(3, $igit_rpwt['related_post_style']);
    $chckd_credit = ($igit_rpwt['igit_credit'] == "1") ? "checked=checked" : "";
    echo $message_succ . '<option value="3" ' . $chk3 . '>Raw Format (<code>&lt;ul&gt; &lt;li&gt;</code>)</option></select></td></tr><tr valign="top"><th scope="row" colspan="2"></td></tr></tbody></table></div><div style="float:left;width:250px;" align="center"><input type="submit" name="sb_submit" id="sb_submit" value="Update Options" /></div>&nbsp;&nbsp;&nbsp;&nbsp;<div id="loading_img" style="float:left;width:60px;padding-top:9px;display:none;" align="center"><img src="' . WP_PLUGIN_URL . '/'.IGIT_RPWT_PLUGIN_FOLDER_NAME.'/images/loader.gif"></div>&nbsp;&nbsp;&nbsp;&nbsp;<div class="flash igit_success" style="float:left;display:none;" id="igit_div_success">Options Saved.</div><br><br><br><br></form></div><div id="poststuffdata" class="metabox-holder has-right-sidebar" style="float: right; width: 24%;">
<div id="side-info-column" class="inner-sidebar"><div class="postbox"><h3 class="hndle"><span>About Plugin:</span></h3><div class="inside"><ul><li><a href="http://www.hackingethics.com/blog/wordpress-plugins/igit-related-posts-with-thumb-image-after-posts/" title="IGIT Related Posts With Thumb Homepage">Plugin Homepage</a></li><li><a href="http://www.hackingethics.com" title="Visit Hacking Ethics">Plugin Main Site</a></li><li><a href="http://www.hackingethics.com/blog/wordpress-plugins/igit-related-posts-with-thumb-image-after-posts/" title="Post Comment to get support">Support For Plugin</a></li><li><a href="http://www.hackingethics.com/blog/hire-php-developer-india-php-developer-india-php-freelancer-india-php-developer-ahmedabad/" title="Plugin Author Page">About the Author</a></li></ul></div></div></div><div class="inner-sidebar" id="side-info-column"><div class="postbox"><h3 class="hndle"><span>Support &amp; Donations</span></h3><div class="inside"><div id="smooth_sldr_donations"><ul><li><a href="#">Jack Pablo - $20</a></li><li><a href="#">Chris Brown - $50</a></li><li><a href="#">Willian Taylor - $30</a></li><li><a href="#"> Matthew Maks - $20</a></li></ul></div></div></div></div></div></div>';
}
function wp_category_checklist_IGIT($post_id = 0, $descendants_and_self = 0, $selected_cats = false, $popular_cats = false, $walker = null, $checked_ontop = true)
{
    if (empty($walker) || !is_a($walker, 'Walker'))
        $walker = new Walker_Category_Checklist;
    $descendants_and_self = (int) $descendants_and_self;
    $args                 = array();
    if (is_array($selected_cats))
        $args['selected_cats'] = $selected_cats;
    elseif ($post_id)
        $args['selected_cats'] = wp_get_post_categories($post_id);
    else
        $args['selected_cats'] = array();
    if (is_array($popular_cats))
        $args['popular_cats'] = $popular_cats;
    else
        $args['popular_cats'] = get_terms('category', array(
            'fields' => 'ids',
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => 10,
            'hierarchical' => false
        ));
    if ($descendants_and_self) {
        $categories = get_categories("child_of=$descendants_and_self&hierarchical=0&hide_empty=0");
        $self       = get_category($descendants_and_self);
        array_unshift($categories, $self);
    } //$descendants_and_self
    else {
        $categories = get_categories('get=all');
    }
    if ($checked_ontop) {
        // Post process $categories rather than adding an exclude to the get_terms() query to keep the query the same across all posts (for any query cache)
        $checked_categories = array();
        $keys               = array_keys($categories);
        foreach ($keys as $k) {
            if (in_array($categories[$k]->term_id, $args['selected_cats'])) {
                $checked_categories[] = $categories[$k];
                unset($categories[$k]);
            } //in_array($categories[$k]->term_id, $args['selected_cats'])
        } //$keys as $k
        // Put checked cats on top
        echo call_user_func_array(array(
            &$walker,
            'walk'
        ), array(
            $checked_categories,
            0,
            $args
        ));
    } //$checked_ontop
    // Then the rest of them
    echo call_user_func_array(array(
        &$walker,
        'walk'
    ), array(
        $categories,
        0,
        $args
    ));
}
?>