<?php
function igit_plugin_menu()
{
    add_options_page('IGIT Related Posts With Thumbnail After Post - Plugin Options Page', 'IGIT Rel Post With Thumb', 'administrator', 'igit-rpwt', 'igit_rpwt_admin_options');
}
function igit_checked_post_style($value, $rel_style)
{
    $res_val = ($value == $rel_style) ? "selected='selected'" : "";
    return $res_val;
}
function igit_checked_other_select($value, $rel_style)
{
    $res_val = ($value == $rel_style) ? "selected='selected'" : "";
    return $res_val;
}
function igit_action_javascript()
{
?>
<script type="text/javascript" >
jQuery(document).ready(function ($) {
/********** Start IGIT Settings **************/
    jQuery('#options_form').submit(function () {
		var i = parseInt(0);
		var exclude_category = [];
		jQuery(':checkbox:checked').each(function(i){
		i = parseInt(i);
		if(jQuery(this).attr('name') == "post_category[]")
		{	
			
			exclude_category[i] = $(this).val();
		}
		i++;
		  //val[i] = $(this).val();
		});
		/*alert(val);
		return false;*/
		tex_show = jQuery('#text_show').attr('value');
		aut_show = jQuery('#auto_show:checked').val();
        rel_post_num = jQuery('#related_post_num').attr('value');
        dis_thumb = jQuery('#display_thumb:checked').val();
        thu_width = jQuery('#thumb_width').attr('value');
        thu_height = jQuery('#thumb_height').attr('value');
        rel_post_style = jQuery('#related_post_style').attr('value');
        igit_cre = jQuery('#igit_credit:checked').val();
		
		
		bk_color_temp = jQuery('#bk_color').attr('value');
		bk_hover_color_temp = jQuery('#bk_hover_color').attr('value');
		fonts_color_temp = jQuery('#fonts_color').attr('value');
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
		document.options_form.hid_exl_cat.value=arv;
		
        var data = {
            action: 'igit_save_ajax',
			text_show: tex_show,
			auto_show: aut_show,
            related_post_num: rel_post_num,
            display_thumb: dis_thumb,
            thumb_width: thu_width,
            thumb_height: thu_height,
            related_post_style: rel_post_style,
            igit_credit: igit_cre,
            exclude_category: document.options_form.hid_exl_cat.value,
            bk_color: bk_color_temp,
            bk_hover_color: bk_hover_color_temp,
            fonts_color: fonts_color_temp,
            img_border_color: img_border_color_temp
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function (response) {
            jQuery('#loading_img').fadeOut(300,function(){
				 jQuery('#igit_div_success').fadeIn(1000,function(){  jQuery('#igit_div_success').fadeOut(2000); });
			 });
			
            $("#frm_fields").html(response);
			if(jscolor.binding) {
			jscolor.bind();
		}
        });
        return false;
    });

/************End IGIT Settings ********/

/********** Start Tooltip Settings **************/
    jQuery('#options_form_igit_tooltip').submit(function () {
		var f = parseInt(0);
		
		igit_show_qt = jQuery('#igit_show_qtip:checked').val();
		if(!igit_show_qt || igit_show_qt == "" || igit_show_qt == "undefined")
		{
			igit_show_qt = "No";
		}
		igit_qtip_pos = jQuery('#igit_qtip_position').attr('value');
		igit_qtip_so = jQuery('#igit_qtip_solo').attr('value');
		igit_qtip_sh = jQuery('#igit_qtip_show').attr('value');
		
		igit_qtip_show_effect_ty = jQuery('#igit_qtip_show_effect_type').attr('value');
		igit_qtip_show_effect_len = jQuery('#igit_qtip_show_effect_length').attr('value');
		igit_hide_qt = jQuery('#igit_hide_qtip').attr('value');
		igit_qtip_hide_effect_ty = jQuery('#igit_qtip_hide_effect_type').attr('value');
		igit_qtip_hide_effect_len = jQuery('#igit_qtip_hide_effect_length').attr('value');
		
		igit_qtip_sty = jQuery('#igit_qtip_style').attr('value');
		igit_qtip_wid = jQuery('#igit_qtip_width').attr('value');
		igit_qtip_hei = jQuery('#igit_qtip_height').attr('value');
		igit_qtip_border_wid = jQuery('#igit_qtip_border_width').attr('value');
		igit_qtip_border_rad = jQuery('#igit_qtip_border_radius').attr('value');
		igit_qtip_content_ch = jQuery('#igit_qtip_content_char').attr('value');
		igit_qtip_content_ali = jQuery('#igit_qtip_content_align').attr('value');
      
        jQuery('#loading_img_igit_tooltip').show();
        var data_one = {
            action: 'igit_tooltip_save_ajax',
			igit_show_qtip: igit_show_qt,
			igit_qtip_position: igit_qtip_pos,
            igit_qtip_solo: igit_qtip_so,
            igit_qtip_show: igit_qtip_sh,
            igit_qtip_show_effect_type: igit_qtip_show_effect_ty,
            igit_qtip_show_effect_length: igit_qtip_show_effect_len,
            igit_hide_qtip: igit_hide_qt,
            igit_qtip_hide_effect_type: igit_qtip_hide_effect_ty,
            igit_qtip_hide_effect_length: igit_qtip_hide_effect_len,
            igit_qtip_style: igit_qtip_sty,
            igit_qtip_width: igit_qtip_wid,
            igit_qtip_height: igit_qtip_hei,
            igit_qtip_border_width: igit_qtip_border_wid,
            igit_qtip_border_radius: igit_qtip_border_rad,
            igit_qtip_content_char: igit_qtip_content_ch,
            igit_qtip_content_align: igit_qtip_content_ali
        };
		
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data_one, function (response) {
            jQuery('#loading_img_igit_tooltip').fadeOut(300,function(){
				 jQuery('#igit_div_success_igit_tooltip').fadeIn(1000,function(){  jQuery('#igit_div_success_igit_tooltip').fadeOut(2000); });
			 });
			
            $("#frm_fields_igit_tooltip").html(response);
			
        });
        return false;
    });

/************End Tooltip Settings ********/

	
});
</script>
<?php
}
function igit_tooltip_action_callback()
{
    global $wpdb; // this is how you get access to the database
    global $igit_rpwt_qtip;
	
	
	/******* IGIT RPWT ToolTip Settings ********/
		
		
		$igit_show_qtip   = ($_POST['igit_show_qtip'] == "") ? '' : $_POST['igit_show_qtip'];
		
		$igit_qtip_position   = ($_POST['igit_qtip_position'] == "") ? $igit_rpwt_qtip['igit_qtip_position'] : $_POST['igit_qtip_position'];
		
		$igit_qtip_solo   = ($_POST['igit_qtip_solo'] == "") ? $igit_rpwt_qtip['igit_qtip_solo'] : $_POST['igit_qtip_solo'];
		$igit_qtip_show   = ($_POST['igit_qtip_show'] == "") ? $igit_rpwt_qtip['igit_qtip_show'] : $_POST['igit_qtip_show'];
		$igit_qtip_show_effect_type   = ($_POST['igit_qtip_show_effect_type'] == "") ? $igit_rpwt_qtip['igit_qtip_show_effect_type'] : $_POST['igit_qtip_show_effect_type'];
		$igit_qtip_show_effect_length   = ($_POST['igit_qtip_show_effect_length'] == "") ? $igit_rpwt_qtip['igit_qtip_show_effect_length'] : $_POST['igit_qtip_show_effect_length'];
		$igit_hide_qtip   = ($_POST['igit_hide_qtip'] == "") ? $igit_rpwt_qtip['igit_hide_qtip'] : $_POST['igit_hide_qtip'];
		$igit_qtip_hide_effect_type   = ($_POST['igit_qtip_hide_effect_type'] == "") ? $igit_rpwt_qtip['igit_qtip_hide_effect_type'] : $_POST['igit_qtip_hide_effect_type'];
		$igit_qtip_hide_effect_length   = ($_POST['igit_qtip_hide_effect_length'] == "") ? $igit_rpwt_qtip['igit_qtip_hide_effect_length'] : $_POST['igit_qtip_hide_effect_length'];
		$igit_qtip_style   = ($_POST['igit_qtip_style'] == "") ? $igit_rpwt_qtip['igit_qtip_style'] : $_POST['igit_qtip_style'];
		$igit_qtip_border_width   = ($_POST['igit_qtip_border_width'] == "") ? $igit_rpwt_qtip['igit_qtip_border_width'] : $_POST['igit_qtip_border_width'];
		$igit_qtip_border_radius   = ($_POST['igit_qtip_border_radius'] == "") ? $igit_rpwt_qtip['igit_qtip_border_radius'] : $_POST['igit_qtip_border_radius'];
		$igit_qtip_width   = ($_POST['igit_qtip_width'] == "") ? $igit_rpwt_qtip['igit_qtip_width'] : $_POST['igit_qtip_width'];
		$igit_qtip_height   = ($_POST['igit_qtip_height'] == "") ? $igit_rpwt_qtip['igit_qtip_height'] : $_POST['igit_qtip_height'];
		$igit_qtip_content_char   = ($_POST['igit_qtip_content_char'] == "") ? $igit_rpwt_qtip['igit_qtip_content_char'] : $_POST['igit_qtip_content_char'];
		$igit_qtip_content_align   = ($_POST['igit_qtip_content_align'] == "") ? $igit_rpwt_qtip['igit_qtip_content_align'] : $_POST['igit_qtip_content_align'];
		
		/******* End IGIT RPWT ToolTip Settings ********/
	
	
    $igit_rpwt_qtip = array( "igit_show_qtip" => $igit_show_qtip,
					"igit_qtip_position" => $igit_qtip_position,
					"igit_qtip_solo" => $igit_qtip_solo,
					"igit_qtip_show" => $igit_qtip_show,
					"igit_qtip_show_effect_type" => $igit_qtip_show_effect_type,
					"igit_qtip_show_effect_length" => $igit_qtip_show_effect_length,
					"igit_hide_qtip" => $igit_hide_qtip,
					"igit_qtip_hide_effect_type" => $igit_qtip_hide_effect_type,
					"igit_qtip_style" => $igit_qtip_style,
					"igit_qtip_border_width" => $igit_qtip_border_width,
					"igit_qtip_border_radius" => $igit_qtip_border_radius,
					"igit_qtip_width" => $igit_qtip_width,
					"igit_qtip_height" => $igit_qtip_height,
					"igit_qtip_content_char" => $igit_qtip_content_char,
					"igit_qtip_content_align" => $igit_qtip_content_align);			
	
    update_option('igit_rpwt_qtip', $igit_rpwt_qtip);
    $igit_rpwt_qtip    = get_option('igit_rpwt_qtip');
	
    
			$auto_chckd_qtip = ($igit_rpwt_qtip['igit_show_qtip'] == "Yes") ? "checked=checked" : "";
	 echo '<div class="updated fade below-h2" id="message"><p>Options updated.</p></div><table class="form-table">
			<tbody><tr valign="top">
				<th scope="row" width="28%"><label for="blogname">Show Post Content in ToolTip? :<strong>(Tick If Yes)</strong></label></th>
					<td style="vertical-align:middle;"><input type="checkbox" id="igit_show_qtip" name="igit_show_qtip" value="Yes" ' . $auto_chckd_qtip . '/></td>
					
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Content Characters To Show :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_content_char'] . '" id="igit_qtip_content_char" name="igit_qtip_content_char" maxlength="4" size="4"/></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Tooltip position :</label></th>
					<td><select name="igit_qtip_position" id="igit_qtip_position"><option value="Top" '.igit_checked_other_select('Top',$igit_rpwt_qtip['igit_qtip_position']).'>Top</option><option value="Bottom" '.igit_checked_other_select('Bottom',$igit_rpwt_qtip['igit_qtip_position']).'>Bottom</option></select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Show One Tooltip at a time :</label></th>
					<td><select name="igit_qtip_solo" id="igit_qtip_solo"><option value="Yes" '.igit_checked_other_select('Yes',$igit_rpwt_qtip['igit_qtip_solo']).'>Yes</option><option value="No" '.igit_checked_other_select('No',$igit_rpwt_qtip['igit_qtip_solo']).'>No</option></select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Content Alignment :</label></th>
					<td>
					
					<select name="igit_qtip_content_align" id="igit_qtip_content_align"><option value="left" '.igit_checked_other_select('left',$igit_rpwt_qtip['igit_qtip_content_align']).'>Left</option><option value="center" '.igit_checked_other_select('center',$igit_rpwt_qtip['igit_qtip_content_align']).'>Center</option></option><option value="right" '.igit_checked_other_select('right',$igit_rpwt_qtip['igit_qtip_content_align']).'>Right</option></select>
					
					
				</tr>
				<tr valign="top">
				<th scope="row" colspan="2"><label for="blogname"><strong>&raquo; Tooltip Show Effects Settings :</strong></label></th>
					
				</tr>
				
				<tr valign="top">
				<th scope="row"><label for="blogname">Show Tooltip When :</label></th>
					<td><select name="igit_qtip_show" id="igit_qtip_show"><option value="mouseover" '.igit_checked_other_select('mouseover',$igit_rpwt_qtip['igit_qtip_show']).'>Mouse Over</option><option value="click" '.igit_checked_other_select('click',$igit_rpwt_qtip['igit_qtip_show']).'>Click</option></select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Show Type :</label></th>
					<td><select name="igit_qtip_show_effect_type" id="igit_qtip_show_effect_type"><option value="slide" '.igit_checked_other_select('slide',$igit_rpwt_qtip['igit_qtip_show_effect_type']).'>Slide</option><option value="fade" '.igit_checked_other_select('fade',$igit_rpwt_qtip['igit_qtip_show_effect_type']).'>Fade</option><option value="grow" '.igit_checked_other_select('grow',$igit_rpwt_qtip['igit_qtip_show_effect_type']).'>Grow</option></select></td>
				</tr>
				
				<tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Show Speed Length :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_show_effect_length'] . '" id="igit_qtip_show_effect_length" name="igit_qtip_show_effect_length" maxlength="4" size="4"/></td>
				</tr>
								
				<tr valign="top">
				<th scope="row" colspan="2"><label for="blogname"><strong>&raquo; Tooltip Hide Effects Settings :</strong></label></th>
					
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Show Tooltip When :</label></th>
					<td><select name="igit_hide_qtip" id="igit_hide_qtip"><option value="mouseout" '.igit_checked_other_select('mouseout',$igit_rpwt_qtip['igit_hide_qtip']).'>Mouse Out</option><option value="click" '.igit_checked_other_select('click',$igit_rpwt_qtip['igit_hide_qtip']).'>Click</option></select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Hide Type :</label></th>
					<td><select name="igit_qtip_hide_effect_type" id="igit_qtip_hide_effect_type"><option value="slide" '.igit_checked_other_select('slide',$igit_rpwt_qtip['igit_qtip_hide_effect_type']).'>Slide</option><option value="fade" '.igit_checked_other_select('fade',$igit_rpwt_qtip['igit_qtip_hide_effect_type']).'>Fade</option><option value="grow" '.igit_checked_other_select('grow',$igit_rpwt_qtip['igit_qtip_hide_effect_type']).'>Grow</option></select></td>
				</tr>
				
				<tr valign="top">
				<th scope="row" colspan="2"><label for="blogname"><strong>&raquo; Tooltip Styles Settings :</strong></label></th>
					
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Select Tooltip Color Theme :</label></th>
					<td><select name="igit_qtip_style" id="igit_qtip_style">
					<option value="light" '.igit_checked_other_select('light',$igit_rpwt_qtip['igit_qtip_style']).'>Light</option>
					<option value="dark" '.igit_checked_other_select('dark',$igit_rpwt_qtip['igit_qtip_style']).'>Dark</option>
					<option value="green" '.igit_checked_other_select('green',$igit_rpwt_qtip['igit_qtip_style']).'>Green</option>
					<option value="cream" '.igit_checked_other_select('cream',$igit_rpwt_qtip['igit_qtip_style']).'>Cream</option>
					<option value="red" '.igit_checked_other_select('red',$igit_rpwt_qtip['igit_qtip_style']).'>Red</option>
					<option value="blue" '.igit_checked_other_select('blue',$igit_rpwt_qtip['igit_qtip_style']).'>Blue</option>
					</select></td>
				</tr>
				 <tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Width :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_width'] . '" id="igit_qtip_width" name="igit_qtip_width"  maxlength="3" size="4"/>&nbsp;(In Pixels(px))</td>
				</tr>
                <tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Height :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_height'] . '" id="igit_qtip_height" name="igit_qtip_height" maxlength="3" size="4"/>&nbsp;(In Pixels(px))</td>
				</tr>
				 <tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Border Width :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_border_width'] . '" id="igit_qtip_border_width" name="igit_qtip_border_width"  maxlength="1" size="3"/>&nbsp;(In Pixels(px))</td>
				</tr>
                <tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Border Radius :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_border_radius'] . '" id="igit_qtip_border_radius" name="igit_qtip_border_radius" maxlength="1" size="3"/>&nbsp;(In Pixels(px))</td>
				</tr>
				
				<tr valign="top">
				<th scope="row"><label for="blogname">Donate Us :</label></th>
					<td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="kin.gandhi@yahoo.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="Hacking Ethics IGIT Related Posts Plugin">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></td>
				</tr>
				<tr valign="top">
				<th scope="row" colspan="2"></td>
				</tr>
				
				</tbody>
		</table>
				
				
				
				
				';
			
				
				
   
   
   
   
   // echo $result_tooltip;
	
    die();
}
function igit_action_callback()
{
    global $wpdb; // this is how you get access to the database
    global $igit_rpwt;
	
	$exclude_cat_arr = explode(",",$_POST['exclude_category']);
	
	$text_show   = ($_POST['text_show'] == "") ? $igit_rpwt['text_show'] : $_POST['text_show'];
	$auto_show   = ($_POST['auto_show'] == "") ? 2 : $_POST['auto_show'];
	
    $related_post_num   = ($_POST['related_post_num'] == "") ? $igit_rpwt['related_post_num'] : $_POST['related_post_num'];
    $display_thumb      = ($_POST['display_thumb'] == "") ? 2 : $_POST['display_thumb'];
    $thumb_width        = ($_POST['thumb_width'] == "") ? $igit_rpwt['thumb_width'] : $_POST['thumb_width'];
    $thumb_height       = ($_POST['thumb_height'] == "") ? $igit_rpwt['thumb_height'] : $_POST['thumb_height'];
    $related_post_style = ($_POST['related_post_style'] == "") ? $igit_rpwt['related_post_style'] : $_POST['related_post_style'];
    $igit_credit        = ($_POST['igit_credit'] == "") ? 2 : $_POST['igit_credit'];
	$bk_color = ($_POST['bk_color'] == "") ? $igit_rpwt['bk_color'] : $_POST['bk_color'];
	$bk_hover_color = ($_POST['bk_hover_color'] == "") ? $igit_rpwt['bk_hover_color'] : $_POST['bk_hover_color'];
	$fonts_color = ($_POST['fonts_color'] == "") ? $igit_rpwt['fonts_color'] : $_POST['fonts_color'];
	$img_border_color = ($_POST['img_border_color'] == "") ? $igit_rpwt['img_border_color'] : $_POST['img_border_color'];
    $igit_rpwt          = array(
		"text_show" => $text_show,
		"auto_show" => $auto_show,
        "related_post_num" => $related_post_num,
        "display_thumb" => $display_thumb,
        "thumb_width" => $thumb_width,
        "thumb_height" => $thumb_height,
        "related_post_style" => $related_post_style,
        "igit_credit" => $igit_credit,
        "exclude_cat_arr" => $exclude_cat_arr,
		"bk_color" => $bk_color,
		"bk_hover_color" => $bk_hover_color,
		"fonts_color" => $fonts_color,
		"img_border_color" => $img_border_color
    );
	
    update_option('igit_rpwt', $igit_rpwt);
    $igit_rpwt    = get_option('igit_rpwt');
	$exclude_cat_arr = $igit_rpwt['exclude_cat_arr'];
	
    $result       = $result . '<div class="updated fade below-h2" id="message"><p>Options updated.</p></div><table class="form-table">
			<tbody>';
			$auto_chckd_ajax = ($igit_rpwt['auto_show'] == "1") ? "checked=checked" : "";
	 $result       = $result . '<tr valign="top">
				<th scope="row"><label for="blogname">Automatically Show related Posts After Post :<strong>(Tick If Yes)</strong></label></th>
					<td style="vertical-align:middle;"><input type="checkbox" id="auto_show" name="auto_show" value="1" ' . $auto_chckd_ajax . '/>&nbsp;&nbsp;<strong>(Do not tick if you want to place related posts Manually.)</strong></td>
					
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Manually Placing of Related Posts :</label></th>
					<td><code>&lt;?php if(function_exists(&#39;igit_rpwt_posts&#39;)) igit_rpwt_posts(); ?&gt;</code></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Heading Text :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt['text_show'] . '" id="text_show" name="text_show" maxlength="100" size="30"/></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Select Categories To Exclude From Related Postsssds :</label> </th><td>
				
				
				<div id="categories-all" class="tabs-panel" style="overflow:auto;height:140px;width:250px;">

						<ul id="categorychecklist" class="list:category categorychecklist form-no-clear">';
			
				
				$result1       = $result1 .'</ul>
					</div>
			</td></tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">How Many Related Posts Want to Show?</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt['related_post_num'] . '" id="related_post_num" name="related_post_num" maxlength="2" size="4"/><code>Dont\'t Enter Greater Then 4 to Get Good Results.</code></td>
				</tr>';
    $chckd        = ($igit_rpwt['display_thumb'] == "1") ? "checked=checked" : "";
    //echo $text; 
    $result1      = $result1 . '<tr valign="top">
				<th scope="row"><label for="blogname">Display Thumb?</label></th>
					<td><input type="checkbox" id="display_thumb" name="display_thumb" value="1" ' . $chckd . '/></td>
				</tr>
				<th scope="row"><label for="blogname">Select Background Color </label></th>
					<td><input class="color" value="' . $igit_rpwt['bk_color'] . '"  id="bk_color" name="bk_color" ></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Select On Hover Background Color: </label></th>
					<td><input class="color" value="' . $igit_rpwt['bk_hover_color'] . '"  id="bk_hover_color" name="bk_hover_color" ></td>
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
    $chk1         = igit_checked_post_style(1, $igit_rpwt['related_post_style']);
    $result1       = $result1 . '<tr valign="top">
				<th scope="row"><label for="blogname">Related Posts Style</label></th>
					<td><select name="related_post_style" id="related_post_style"><option>--Select--</option>
					
	<option value="1" ' . $chk1 . '>Horizontal Format</option>
	';
    $chk2         = igit_checked_post_style(2, $igit_rpwt['related_post_style']);
    $result1       = $result1 . '<option value="2" ' . $chk2 . '>Verticle Format</option>
	';
    $chk3         = igit_checked_post_style(3, $igit_rpwt['related_post_style']);
    $chckd_credit = ($igit_rpwt['igit_credit'] == "1") ? "checked=checked" : "";
    $result1       = $result1 . '<option value="3" ' . $chk3 . '>Raw Format (<code>&lt;ul&gt; &lt;li&gt;</code>)</option></select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Give IGIT Plugin Credit?</label></th>
					<td><input type="checkbox" id="igit_credit" name="igit_credit" value="1" ' . $chckd_credit . '/></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Donate Us :</label></th>
					<td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="kin.gandhi@yahoo.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="Hacking Ethics IGIT Related Posts Plugin">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></td>
				</tr>
				<tr valign="top">
				<th scope="row" colspan="2"></td>
				</tr>
			</tbody>
		</table>
		';
    echo $result;
	wp_category_checklist_IGIT($post_ID, false,$exclude_cat_arr);
	echo $result1;
    die();
}
function igit_rpwt_admin_options()
{
    global $igit_rpwt, $plgin_dir, $igit_rpwt_qtip;
    if ($_POST['sb_submit']) {
	
        $igit_rpwt = array(
			"text_show" => $_POST['text_show'],
			"auto_show" => $_POST['auto_show'],
            "num_posts" => $_POST['related_post_num'],
            "dis_thumb" => $_POST['display_thumb'],
            "thumb_width" => $_POST['thumb_width'],
            "thumb_height" => $_POST['thumb_height'],
            "rel_post_style" => $_POST['related_post_style'],
            "bk_color" => $_POST['bk_color'],
            "bk_hover_color" => $_POST['bk_hover_color'],
            "fonts_color" => $_POST['fonts_color'],
            "img_border_color" => $_POST['img_border_color']
        );
        update_option('igit_rpwt', $igit_rpwt);
        $message_succ = '<div id="message" class="updated fade"><p>Option Saved!</p></div>';
    } else {
        $message_succ       = "";
		/******* IGIT RPWT Settings ********/
        $igit_rpwt_new      = get_option('igit_rpwt');
		$text_show   = ($igit_rpwt_new['text_show'] == "") ? $igit_rpwt['text_show'] : $igit_rpwt_new['text_show'];
		$auto_show   = ($igit_rpwt_new['auto_show'] == "") ? $igit_rpwt['auto_show'] : $igit_rpwt_new['auto_show'];
        $related_post_num   = ($igit_rpwt_new['related_post_num'] == "") ? $igit_rpwt['related_post_num'] : $igit_rpwt_new['related_post_num'];
        $display_thumb      = ($igit_rpwt_new['display_thumb'] == "") ? $igit_rpwt['display_thumb'] : $igit_rpwt_new['display_thumb'];
        $thumb_width        = ($igit_rpwt_new['thumb_width'] == "") ? $igit_rpwt['thumb_width'] : $igit_rpwt_new['thumb_width'];
        $thumb_height       = ($igit_rpwt_new['thumb_height'] == "") ? $igit_rpwt['thumb_height'] : $igit_rpwt_new['thumb_height'];
        $related_post_style = ($igit_rpwt_new['related_post_style'] == "") ? $igit_rpwt['related_post_style'] : $igit_rpwt_new['related_post_style'];
        $igit_credit        = ($igit_rpwt_new['igit_credit'] == "") ? $igit_rpwt['igit_credit'] : $igit_rpwt_new['igit_credit'];
		$bk_color        = ($igit_rpwt_new['bk_color'] == "") ? $igit_rpwt['bk_color'] : $igit_rpwt_new['bk_color'];
		$bk_hover_color        = ($igit_rpwt_new['bk_hover_color'] == "") ? $igit_rpwt['bk_hover_color'] : $igit_rpwt_new['bk_hover_color'];
		$fonts_color        = ($igit_rpwt_new['fonts_color'] == "") ? $igit_rpwt['fonts_color'] : $igit_rpwt_new['fonts_color'];
		$img_border_color        = ($igit_rpwt_new['img_border_color'] == "") ? $igit_rpwt['img_border_color'] : $igit_rpwt_new['img_border_color'];
		/******* End IGIT RPWT Settings ********/
		
		/******* IGIT RPWT ToolTip Settings ********/
		
		$igit_rpwt_qtip_new      = get_option('igit_rpwt_qtip');
		
		
		if($igit_rpwt_qtip_new['igit_show_qtip'] == "")
		{
			$igit_show_qtip = $igit_rpwt_qtip['igit_show_qtip'];
		}
		else if($igit_rpwt_qtip_new['igit_show_qtip'] == "No")
		{
			$igit_show_qtip = "";
		}
		
		//$igit_show_qtip   = ($igit_rpwt_qtip_new['igit_show_qtip'] == "") ? '' : $igit_rpwt_qtip_new['igit_show_qtip'];
		$igit_qtip_position   = ($igit_rpwt_qtip_new['igit_qtip_position'] == "") ? $igit_rpwt_qtip['igit_qtip_position'] : $igit_rpwt_qtip_new['igit_qtip_position'];
		
		$igit_qtip_solo   = ($igit_rpwt_qtip_new['igit_qtip_solo'] == "") ? $igit_rpwt_qtip['igit_qtip_solo'] : $igit_rpwt_qtip_new['igit_qtip_solo'];
		$igit_qtip_show   = ($igit_rpwt_qtip_new['igit_qtip_show'] == "") ? $igit_rpwt_qtip['igit_qtip_show'] : $igit_rpwt_qtip_new['igit_qtip_show'];
		$igit_qtip_show_effect_type   = ($igit_rpwt_qtip_new['igit_qtip_show_effect_type'] == "") ? $igit_rpwt_qtip['igit_qtip_show_effect_type'] : $igit_rpwt_qtip_new['igit_qtip_show_effect_type'];
		$igit_qtip_show_effect_length   = ($igit_rpwt_qtip_new['igit_qtip_show_effect_length'] == "") ? $igit_rpwt_qtip['igit_qtip_show_effect_length'] : $igit_rpwt_qtip_new['igit_qtip_show_effect_length'];
		$igit_hide_qtip   = ($igit_rpwt_qtip_new['igit_hide_qtip'] == "") ? $igit_rpwt_qtip['igit_hide_qtip'] : $igit_rpwt_qtip_new['igit_hide_qtip'];
		$igit_qtip_hide_effect_type   = ($igit_rpwt_qtip_new['igit_qtip_hide_effect_type'] == "") ? $igit_rpwt_qtip['igit_qtip_hide_effect_type'] : $igit_rpwt_qtip_new['igit_qtip_hide_effect_type'];
		$igit_qtip_hide_effect_length   = ($igit_rpwt_qtip_new['igit_qtip_hide_effect_length'] == "") ? $igit_rpwt_qtip['igit_qtip_hide_effect_length'] : $igit_rpwt_qtip_new['igit_qtip_hide_effect_length'];
		$igit_qtip_style   = ($igit_rpwt_qtip_new['igit_qtip_style'] == "") ? $igit_rpwt_qtip['igit_qtip_style'] : $igit_rpwt_qtip_new['igit_qtip_style'];
		$igit_qtip_border_width   = ($igit_rpwt_qtip_new['igit_qtip_border_width'] == "") ? $igit_rpwt_qtip['igit_qtip_border_width'] : $igit_rpwt_qtip_new['igit_qtip_border_width'];
		$igit_qtip_border_radius   = ($igit_rpwt_qtip_new['igit_qtip_border_radius'] == "") ? $igit_rpwt_qtip['igit_qtip_border_radius'] : $igit_rpwt_qtip_new['igit_qtip_border_radius'];
		$igit_qtip_width   = ($igit_rpwt_qtip_new['igit_qtip_width'] == "") ? $igit_rpwt_qtip['igit_qtip_width'] : $igit_rpwt_qtip_new['igit_qtip_width'];
		$igit_qtip_height   = ($igit_rpwt_qtip_new['igit_qtip_height'] == "") ? $igit_rpwt_qtip['igit_qtip_height'] : $igit_rpwt_qtip_new['igit_qtip_height'];
		$igit_qtip_content_char   = ($igit_rpwt_qtip_new['igit_qtip_content_char'] == "") ? $igit_rpwt_qtip['igit_qtip_content_char'] : $igit_rpwt_qtip_new['igit_qtip_content_char'];
		$igit_qtip_content_align   = ($igit_rpwt_qtip_new['igit_qtip_content_align'] == "") ? $igit_rpwt_qtip['igit_qtip_content_align'] : $igit_rpwt_qtip_new['igit_qtip_content_align'];
		
		/******* End IGIT RPWT ToolTip Settings ********/
		
		$exclude_cat_arr    = $igit_rpwt_new['exclude_cat_arr'];
		
        $igit_rpwt          = array(
		"text_show" => $text_show,
			"auto_show" => $auto_show,
            "related_post_num" => $related_post_num,
            "display_thumb" => $display_thumb,
            "thumb_width" => $thumb_width,
            "thumb_height" => $thumb_height,
            "related_post_style" => $related_post_style,
            "igit_credit" => $igit_credit,
            "bk_color" => $bk_color,
            "bk_hover_color" => $bk_hover_color,
            "fonts_color" => $fonts_color,
            "img_border_color" => $img_border_color
        );
		
		 $igit_rpwt_qtip          = array(
		"igit_show_qtip" => $igit_show_qtip,
			"igit_qtip_position" => $igit_qtip_position,
            "igit_qtip_solo" => $igit_qtip_solo,
            "igit_qtip_show" => $igit_qtip_show,
            "igit_qtip_show_effect_type" => $igit_qtip_show_effect_type,
            "igit_qtip_show_effect_length" => $igit_qtip_show_effect_length,
            "igit_hide_qtip" => $igit_hide_qtip,
            "igit_qtip_hide_effect_type" => $igit_qtip_hide_effect_type,
            "igit_qtip_style" => $igit_qtip_style,
            "igit_qtip_border_width" => $igit_qtip_border_width,
            "igit_qtip_border_radius" => $igit_qtip_border_radius,
            "igit_qtip_width" => $igit_qtip_width,
            "igit_qtip_height" => $igit_qtip_height,
            "igit_qtip_content_char" => $igit_qtip_content_char,
            "igit_qtip_content_align" => $igit_qtip_content_align
			
        );
		
    }
	
    echo $message_succ . '<div class="wrap"><div id="icon-options-general" class="icon32"><br/></div>
	<div style="width: 70%; float: left;">
 	
		<h2>IGIT Related Posts With Thumb</h2> 
		
		<div id="igit_rpwt_tabs">
    <ul>
        <li><a href="#fragment-1"><span>IGIT Settings</span></a></li>
        <li><a href="#fragment-2"><span>Tooltip</span></a></li>
       
    </ul>
    <div id="fragment-1">
	<form id="options_form" name="options_form" method="post" action="">
	<input type="hidden" id="hid_exl_cat" name="hid_exl_cat" value="">
		<div id="frm_fields">
        <table class="form-table">
			<tbody>';
			$auto_chckd = ($igit_rpwt['auto_show'] == "1") ? "checked=checked" : "";
				 echo $message_succ . '<tr valign="top">
				<th scope="row"><label for="blogname">Automatically Show related Posts After Post :<strong>(Tick If Yes)</strong></label></th>
					<td style="vertical-align:middle;"><input type="checkbox" id="auto_show" name="auto_show" value="1" ' . $auto_chckd . '/>&nbsp;&nbsp;<strong>(Do not tick if you want to place related posts Manually.)</strong> </td>
					
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Manually Placing of Related Posts :</label></th>
					<td><code>&lt;?php if(function_exists(&#39;igit_rpwt_posts&#39;)) igit_rpwt_posts(); ?&gt;</code></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Heading Text :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt['text_show'] . '" id="text_show" name="text_show" maxlength="100" size="30"/></td>
				</tr><tr valign="top">
				<th scope="row"><label for="blogname">Select Categories To Exclude From Related Posts :</label> </th><td>
				
				
				<div id="categories-all" class="tabs-panel" style="overflow:auto;height:140px;width:250px;">

						<ul id="categorychecklist" class="list:category categorychecklist form-no-clear">';
							 echo $message_succ. wp_category_checklist_IGIT($post_ID, false,$exclude_cat_arr);
				
				echo $message_succ.'</ul>
					</div>
			<td></tr><tr valign="top">
				<th scope="row"><label for="blogname">How Many Related Posts Want to Show?</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt['related_post_num'] . '" id="related_post_num" name="related_post_num" maxlength="2" size="4"/><code>Dont\'t Enter Greater Then 4 to Get Good Results.</code></td>
				</tr>';
    $chckd = ($igit_rpwt['display_thumb'] == "1") ? "checked=checked" : "";
    //echo $text; 
    echo $message_succ . '<tr valign="top">
				<th scope="row"><label for="blogname">Display Thumb?</label></th>
					<td><input type="checkbox" id="display_thumb" name="display_thumb" value="1" ' . $chckd . '/></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Select Background Color </label></th>
					<td><input class="color" value="' . $igit_rpwt['bk_color'] . '"  id="bk_color" name="bk_color" ></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Select On Hover Background Color: </label></th>
					<td><input class="color" value="' . $igit_rpwt['bk_hover_color'] . '"  id="bk_hover_color" name="bk_hover_color" ></td>
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
					<td><input type="text" class="code" value="' . $igit_rpwt['thumb_width'] . '" id="thumb_width" name="thumb_width"  maxlength="3" size="4"/>&nbsp;(In Pixels(px))</td>
				</tr>
                <tr valign="top">
				<th scope="row"><label for="blogname">Thumb Height :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt['thumb_height'] . '" id="thumb_height" name="thumb_height" maxlength="3" size="4"/>&nbsp;(In Pixels(px))</td>
				</tr>';
    $chk1 = igit_checked_post_style(1, $igit_rpwt['related_post_style']);
    echo $message_succ . '<tr valign="top">
				<th scope="row"><label for="blogname">Related Posts Style</label></th>
					<td>
					<select name="related_post_style"  id="related_post_style"><option>--Select--</option>
					
	<option value="1" ' . $chk1 . '>Horizontal Format</option>
	';
    $chk2 = igit_checked_post_style(2, $igit_rpwt['related_post_style']);
    echo $message_succ . '<option value="2" ' . $chk2 . '>Verticle Format</option>
	';
    $chk3         = igit_checked_post_style(3, $igit_rpwt['related_post_style']);
    $chckd_credit = ($igit_rpwt['igit_credit'] == "1") ? "checked=checked" : "";
    echo $message_succ . '<option value="3" ' . $chk3 . '>Raw Format (<code>&lt;ul&gt; &lt;li&gt;</code>)</option></select>
		</td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Give IGIT Plugin Credit?</label></th>
					<td><input type="checkbox" id="igit_credit" name="igit_credit" value="1" ' . $chckd_credit . '/></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Donate Us :</label></th>
					<td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="kin.gandhi@yahoo.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="Hacking Ethics IGIT Related Posts Plugin">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></td>
				</tr>
				
				
			</tbody>
		</table>
		
		</div>
		<div style="float:left;width:250px;" align="center"><input type="submit" name="sb_submit" id="sb_submit" value="Update Options" /></div>&nbsp;&nbsp;&nbsp;&nbsp;<div id="loading_img" style="float:left;width:60px;padding-top:9px;display:none;" align="center"><img src="' . WP_PLUGIN_URL . '/igit-related-posts-with-thumb-images-after-posts/images/loader.gif"></div>&nbsp;&nbsp;&nbsp;&nbsp;<div class="flash igit_success" style="float:left;display:none;" id="igit_div_success">
   Options Saved.</div>
		</form>
    </div>
    <div id="fragment-2">
	<form id="options_form_igit_tooltip" name="options_form_igit_tooltip" method="post" action="">
	<div id="frm_fields_igit_tooltip">
       ';
			$auto_chckd_qtip = ($igit_rpwt_qtip['igit_show_qtip'] == "Yes") ? "checked=checked" : "";
				 echo $message_succ_qtip . '<table class="form-table form_table_igit_tooltip">
			<tbody><tr valign="top">
				<th scope="row"  width="28%"><label for="blogname">Show Post Content in ToolTip? :<strong>(Tick If Yes)</strong></label></th>
					<td style="vertical-align:middle;"><input type="checkbox" id="igit_show_qtip" name="igit_show_qtip" value="Yes" ' . $auto_chckd_qtip . '/></td>
					
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Content Characters To Show :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_content_char'] . '" id="igit_qtip_content_char" name="igit_qtip_content_char" maxlength="4" size="4"/></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Tooltip position :</label></th>
					<td><select name="igit_qtip_position" id="igit_qtip_position"><option value="Top" '.igit_checked_other_select('Top',$igit_rpwt_qtip['igit_qtip_position']).'>Top</option><option value="Bottom" '.igit_checked_other_select('Bottom',$igit_rpwt_qtip['igit_qtip_position']).'>Bottom</option></select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Show One Tooltip at a time :</label></th>
					<td><select name="igit_qtip_solo" id="igit_qtip_solo"><option value="Yes" '.igit_checked_other_select('Yes',$igit_rpwt_qtip['igit_qtip_solo']).'>Yes</option><option value="No" '.igit_checked_other_select('No',$igit_rpwt_qtip['igit_qtip_solo']).'>No</option></select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Content Alignment :</label></th>
					<td><select name="igit_qtip_content_align" id="igit_qtip_content_align"><option value="left" '.igit_checked_other_select('left',$igit_rpwt_qtip['igit_qtip_content_align']).'>Left</option><option value="center" '.igit_checked_other_select('center',$igit_rpwt_qtip['igit_qtip_content_align']).'>Center</option></option><option value="right" '.igit_checked_other_select('right',$igit_rpwt_qtip['igit_qtip_content_align']).'>Right</option></select></td>
				</tr>
				<tr valign="top">
				<th scope="row" colspan="2"><label for="blogname"><strong>&raquo; Tooltip Show Effects Settings :</strong></label></th>
					
				</tr>
				
				<tr valign="top">
				<th scope="row"><label for="blogname">Show Tooltip When :</label></th>
					<td><select name="igit_qtip_show" id="igit_qtip_show"><option value="mouseover" '.igit_checked_other_select('mouseover',$igit_rpwt_qtip['igit_qtip_show']).'>Mouse Over</option><option value="click" '.igit_checked_other_select('click',$igit_rpwt_qtip['igit_qtip_show']).'>Click</option></select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Show Type :</label></th>
					<td><select name="igit_qtip_show_effect_type" id="igit_qtip_show_effect_type"><option value="slide" '.igit_checked_other_select('slide',$igit_rpwt_qtip['igit_qtip_show_effect_type']).'>Slide</option><option value="fade" '.igit_checked_other_select('fade',$igit_rpwt_qtip['igit_qtip_show_effect_type']).'>Fade</option><option value="grow" '.igit_checked_other_select('grow',$igit_rpwt_qtip['igit_qtip_show_effect_type']).'>Grow</option></select></td>
				</tr>
				
				<tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Show Speed Length :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_show_effect_length'] . '" id="igit_qtip_show_effect_length" name="igit_qtip_show_effect_length" maxlength="4" size="4"/></td>
				</tr>
								
				<tr valign="top">
				<th scope="row" colspan="2"><label for="blogname"><strong>&raquo; Tooltip Hide Effects Settings :</strong></label></th>
					
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Show Tooltip When :</label></th>
					<td><select name="igit_hide_qtip" id="igit_hide_qtip"><option value="mouseout" '.igit_checked_other_select('mouseout',$igit_rpwt_qtip['igit_hide_qtip']).'>Mouse Out</option><option value="click" '.igit_checked_other_select('click',$igit_rpwt_qtip['igit_hide_qtip']).'>Click</option></select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Hide Type :</label></th>
					<td><select name="igit_qtip_hide_effect_type" id="igit_qtip_hide_effect_type"><option value="slide" '.igit_checked_other_select('slide',$igit_rpwt_qtip['igit_qtip_hide_effect_type']).'>Slide</option><option value="fade" '.igit_checked_other_select('fade',$igit_rpwt_qtip['igit_qtip_hide_effect_type']).'>Fade</option><option value="grow" '.igit_checked_other_select('grow',$igit_rpwt_qtip['igit_qtip_hide_effect_type']).'>Grow</option></select></td>
				</tr>
				
				<tr valign="top">
				<th scope="row" colspan="2"><label for="blogname"><strong>&raquo; Tooltip Styles Settings :</strong></label></th>
					
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Select Tooltip Color Theme :</label></th>
					<td><select name="igit_qtip_style" id="igit_qtip_style">
					<option value="light" '.igit_checked_other_select('light',$igit_rpwt_qtip['igit_qtip_style']).'>Light</option>
					<option value="dark" '.igit_checked_other_select('dark',$igit_rpwt_qtip['igit_qtip_style']).'>Dark</option>
					<option value="green" '.igit_checked_other_select('green',$igit_rpwt_qtip['igit_qtip_style']).'>Green</option>
					<option value="cream" '.igit_checked_other_select('cream',$igit_rpwt_qtip['igit_qtip_style']).'>Cream</option>
					<option value="red" '.igit_checked_other_select('red',$igit_rpwt_qtip['igit_qtip_style']).'>Red</option>
					<option value="blue" '.igit_checked_other_select('blue',$igit_rpwt_qtip['igit_qtip_style']).'>Blue</option>
					</select></td>
				</tr>
				 <tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Width :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_width'] . '" id="igit_qtip_width" name="igit_qtip_width"  maxlength="3" size="4"/>&nbsp;(In Pixels(px))</td>
				</tr>
                <tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Height :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_height'] . '" id="igit_qtip_height" name="igit_qtip_height" maxlength="3" size="4"/>&nbsp;(In Pixels(px))</td>
				</tr>
				 <tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Border Width :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_border_width'] . '" id="igit_qtip_border_width" name="igit_qtip_border_width"  maxlength="1" size="3"/>&nbsp;(In Pixels(px))</td>
				</tr>
                <tr valign="top">
				<th scope="row"><label for="blogname">Tooltip Border Radius :</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt_qtip['igit_qtip_border_radius'] . '" id="igit_qtip_border_radius" name="igit_qtip_border_radius" maxlength="1" size="3"/>&nbsp;(In Pixels(px))</td>
				</tr>
				
				<tr valign="top">
				<th scope="row"><label for="blogname">Donate Us :</label></th>
					<td><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="kin.gandhi@yahoo.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="Hacking Ethics IGIT Related Posts Plugin">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></td>
				</tr>
				<tr valign="top">
				<th scope="row" colspan="2"></td>
				</tr>
				
				</tbody>
		</table>
		</div>
		<div style="float:left;width:250px;" align="center"><input type="submit" name="sb_submit_igit_tooltip" id="sb_submit_igit_tooltip" value="Update Options" /></div>&nbsp;&nbsp;&nbsp;&nbsp;<div id="loading_img_igit_tooltip" style="float:left;width:60px;padding-top:9px;display:none;" align="center"><img src="' . WP_PLUGIN_URL . '/igit-related-posts-with-thumb-images-after-posts/images/loader.gif"></div>&nbsp;&nbsp;&nbsp;&nbsp;<div class="flash igit_success" style="float:left;display:none;" id="igit_div_success_igit_tooltip">
   Options Saved.</div>
		</form>
    </div>
   
	</div>
		
		
		
	</div>
	<div id="poststuff" class="metabox-holder has-right-sidebar" style="float: right; width: 24%;"> 
   <div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>Donate To Support Plugin:</span></h3> 
			  <div class="inside" align="center">
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="kin.gandhi@yahoo.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="Hacking Ethics IGIT Related Posts Plugin">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
              </div> 
			</div> 
  </div>
<div id="side-info-column" class="inner-sidebar"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>About Plugin:</span></h3> 
			  <div class="inside">
                <ul>
                <li><a href="http://www.hackingethics.com/blog/wordpress-plugins/igit-related-posts-with-thumb-image-after-posts/" title="IGIT Related Posts With Thumb Homepage">Plugin Homepage</a></li>
                <li><a href="http://www.hackingethics.com" title="Visit Hacking Ethics">Plugin Main Site</a></li>
                <li><a href="http://www.hackingethics.com/blog/wordpress-plugins/igit-related-posts-with-thumb-image-after-posts/" title="Post Comment to get support">Support For Plugin</a></li>
                <li><a href="http://www.hackingethics.com/blog/hire-php-developer-india-php-developer-india-php-freelancer-india-php-developer-ahmedabad/" title="Plugin Author Page">About the Author</a></li>
               
                </ul> 
              </div> 
			</div> 
  </div>
  <div class="inner-sidebar" id="side-info-column"> 
			<div class="postbox"> 
			  <h3 class="hndle"><span>Support &amp; Donations</span></h3> 
			  <div class="inside">
                <div id="smooth_sldr_donations">
                 <ul>
                    <li><a href="#">Jack Pablo - $20</a></li>
                   
                 </ul>
					
                   
                </div>
              </div> 
			</div> 
     </div>
 </div>
</div>';
}
function wp_category_checklist_IGIT( $post_id = 0, $descendants_and_self = 0, $selected_cats = false, $popular_cats = false, $walker = null, $checked_ontop = true ) {
	if ( empty($walker) || !is_a($walker, 'Walker') )
		$walker = new Walker_Category_Checklist;

	$descendants_and_self = (int) $descendants_and_self;

	$args = array();

	if ( is_array( $selected_cats ) )
		$args['selected_cats'] = $selected_cats;
	elseif ( $post_id )
		$args['selected_cats'] = wp_get_post_categories($post_id);
	else
		$args['selected_cats'] = array();

	if ( is_array( $popular_cats ) )
		$args['popular_cats'] = $popular_cats;
	else
		$args['popular_cats'] = get_terms( 'category', array( 'fields' => 'ids', 'orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hierarchical' => false ) );

	if ( $descendants_and_self ) {
		$categories = get_categories( "child_of=$descendants_and_self&hierarchical=0&hide_empty=0" );
		$self = get_category( $descendants_and_self );
		array_unshift( $categories, $self );
	} else {
		$categories = get_categories('get=all');
	}

	if ( $checked_ontop ) {
		// Post process $categories rather than adding an exclude to the get_terms() query to keep the query the same across all posts (for any query cache)
		$checked_categories = array();
		$keys = array_keys( $categories );

		foreach( $keys as $k ) {
			if ( in_array( $categories[$k]->term_id, $args['selected_cats'] ) ) {
				$checked_categories[] = $categories[$k];
				unset( $categories[$k] );
			}
		}

		// Put checked cats on top
		echo call_user_func_array(array(&$walker, 'walk'), array($checked_categories, 0, $args));
	}
	// Then the rest of them
	echo call_user_func_array(array(&$walker, 'walk'), array($categories, 0, $args));
}
?>
