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
function igit_action_javascript()
{
?>
<script type="text/javascript" >
jQuery(document).ready(function ($) {
    jQuery('#options_form').submit(function () {
		aut_show = jQuery('#auto_show:checked').val();
        rel_post_num = jQuery('#related_post_num').attr('value');
        dis_thumb = jQuery('#display_thumb:checked').val();
        thu_width = jQuery('#thumb_width').attr('value');
        thu_height = jQuery('#thumb_height').attr('value');
        rel_post_style = jQuery('#related_post_style').attr('value');
        igit_cre = jQuery('#igit_credit:checked').val();
        if ((rel_post_style == 1) && rel_post_num > 5) {
            alert("if you select post style Horizontal then Related post number should be less then or equal to 5.");
            document.options_form.related_post_num.select();
            return false;
        }
        jQuery('#loading_img').show();
        var data = {
            action: 'igit_save_ajax',
			auto_show: aut_show,
            related_post_num: rel_post_num,
            display_thumb: dis_thumb,
            thumb_width: thu_width,
            thumb_height: thu_height,
            related_post_style: rel_post_style,
            igit_credit: igit_cre
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function (response) {
            jQuery('#loading_img').hide();
            $("#frm_fields").html(response);
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
	
	$auto_show   = ($_POST['auto_show'] == "") ? $igit_rpwt['auto_show'] : $_POST['auto_show'];
	
    $related_post_num   = ($_POST['related_post_num'] == "") ? $igit_rpwt['related_post_num'] : $_POST['related_post_num'];
    $display_thumb      = ($_POST['display_thumb'] == "") ? $igit_rpwt['display_thumb'] : $_POST['display_thumb'];
    $thumb_width        = ($_POST['thumb_width'] == "") ? $igit_rpwt['thumb_width'] : $_POST['thumb_width'];
    $thumb_height       = ($_POST['thumb_height'] == "") ? $igit_rpwt['thumb_height'] : $_POST['thumb_height'];
    $related_post_style = ($_POST['related_post_style'] == "") ? $igit_rpwt['related_post_style'] : $_POST['related_post_style'];
    $igit_credit        = ($_POST['igit_credit'] == "") ? $igit_rpwt['igit_credit'] : $_POST['igit_credit'];
    $igit_rpwt          = array(
		"auto_show" => $auto_show,
        "related_post_num" => $related_post_num,
        "display_thumb" => $display_thumb,
        "thumb_width" => $thumb_width,
        "thumb_height" => $thumb_height,
        "related_post_style" => $related_post_style,
        "igit_credit" => $igit_credit
    );
	
    update_option('igit_rpwt', $igit_rpwt);
    $igit_rpwt    = get_option('igit_rpwt');
    $result       = $result . '<div class="updated fade below-h2" id="message"><p>Options updated.</p></div><table class="form-table">
			<tbody>';
			$auto_chckd_ajax = ($igit_rpwt['auto_show'] == "1") ? "checked=checked" : "";
	 $result       = $result . '<tr valign="top">
				<th scope="row"><label for="blogname">Automatically Show related Posts After Post :<strong>(Tick If Yes)</strong></label></th>
					<td style="vertical-align:middle;"><input type="checkbox" id="auto_show" name="auto_show" value="1" ' . $auto_chckd_ajax . '/>&nbsp;&nbsp;<strong>(Do not tick if you want to place related posts Manually.)</strong></td>
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
				<th scope="row"><label for="blogname">Manually Placing of Related Posts :</label></th>
					<td><code>&lt;?php if(function_exists(&#39;igit_rpwt_posts&#39;)) igit_rpwt_posts(); ?&gt;</code></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">How Many Related Posts Want to Show?</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt['related_post_num'] . '" id="related_post_num" name="related_post_num" maxlength="2" size="4"/></td>
				</tr>';
    $chckd        = ($igit_rpwt['display_thumb'] == "1") ? "checked=checked" : "";
    //echo $text; 
    $result       = $result . '<tr valign="top">
				<th scope="row"><label for="blogname">Display Thumb?</label></th>
					<td><input type="checkbox" id="display_thumb" name="display_thumb" value="1" ' . $chckd . '/></td>
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
    $result       = $result . '<tr valign="top">
				<th scope="row"><label for="blogname">Related Posts Style</label></th>
					<td><select name="related_post_style" id="related_post_style"><option>--Select--</option>
					
	<option value="1" ' . $chk1 . '>Horizontal Format</option>
	';
    $chk2         = igit_checked_post_style(2, $igit_rpwt['related_post_style']);
    $result       = $result . '<option value="2" ' . $chk2 . '>Verticle Format</option>
	';
    $chk3         = igit_checked_post_style(3, $igit_rpwt['related_post_style']);
    $chckd_credit = ($igit_rpwt['igit_credit'] == "1") ? "checked=checked" : "";
    $result       = $result . '<option value="3" ' . $chk3 . '>Raw Format (<code>&lt;ul&gt; &lt;li&gt;</code>)</option></select></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">Give IGIT Plugin Credit?</label></th>
					<td><input type="checkbox" id="igit_credit" name="igit_credit" value="1" ' . $chckd_credit . '/></td>
				</tr>
				
				<tr valign="top">
				<th scope="row" colspan="2"></td>
				</tr>
			</tbody>
		</table>
		';
    echo $result;
    die();
}
function igit_rpwt_admin_options()
{
    global $igit_rpwt, $plgin_dir;
    if ($_POST['sb_submit']) {
        $igit_rpwt = array(
			"auto_show" => $_POST['auto_show'],
            "num_posts" => $_POST['related_post_num'],
            "dis_thumb" => $_POST['display_thumb'],
            "thumb_width" => $_POST['thumb_width'],
            "thumb_height" => $_POST['thumb_height'],
            "rel_post_style" => $_POST['related_post_style']
        );
        update_option('igit_rpwt', $igit_rpwt);
        $message_succ = '<div id="message" class="updated fade"><p>Option Saved!</p></div>';
    } else {
        $message_succ       = "";
        $igit_rpwt_new      = get_option('igit_rpwt');
		$auto_show   = ($igit_rpwt_new['auto_show'] == "") ? $igit_rpwt['auto_show'] : $igit_rpwt_new['auto_show'];
        $related_post_num   = ($igit_rpwt_new['related_post_num'] == "") ? $igit_rpwt['related_post_num'] : $igit_rpwt_new['related_post_num'];
        $display_thumb      = ($igit_rpwt_new['display_thumb'] == "") ? $igit_rpwt['display_thumb'] : $igit_rpwt_new['display_thumb'];
        $thumb_width        = ($igit_rpwt_new['thumb_width'] == "") ? $igit_rpwt['thumb_width'] : $igit_rpwt_new['thumb_width'];
        $thumb_height       = ($igit_rpwt_new['thumb_height'] == "") ? $igit_rpwt['thumb_height'] : $igit_rpwt_new['thumb_height'];
        $related_post_style = ($igit_rpwt_new['related_post_style'] == "") ? $igit_rpwt['related_post_style'] : $igit_rpwt_new['related_post_style'];
        $igit_credit        = ($igit_rpwt_new['igit_credit'] == "") ? $igit_rpwt['igit_credit'] : $igit_rpwt_new['igit_credit'];
        $igit_rpwt          = array(
			"auto_show" => $auto_show,
            "related_post_num" => $related_post_num,
            "display_thumb" => $display_thumb,
            "thumb_width" => $thumb_width,
            "thumb_height" => $thumb_height,
            "related_post_style" => $related_post_style,
            "igit_credit" => $igit_credit
        );
    }
    echo $message_succ . '<div class="wrap"><div id="icon-options-general" class="icon32"><br/></div>
 	<form id="options_form" name="options_form" method="post" action="">
		<h2>IGIT Related Posts With Thumb</h2> 
		<div id="frm_fields">
		<table class="form-table">
			<tbody>';
			$auto_chckd = ($igit_rpwt['auto_show'] == "1") ? "checked=checked" : "";
				 echo $message_succ . '<tr valign="top">
				<th scope="row"><label for="blogname">Automatically Show related Posts After Post :<strong>(Tick If Yes)</strong></label></th>
					<td style="vertical-align:middle;"><input type="checkbox" id="auto_show" name="auto_show" value="1" ' . $auto_chckd . '/>&nbsp;&nbsp;<strong>(Do not tick if you want to place related posts Manually.)</strong></td>
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
				<th scope="row"><label for="blogname">Manually Placing of Related Posts :</label></th>
					<td><code>&lt;?php if(function_exists(&#39;igit_rpwt_posts&#39;)) igit_rpwt_posts(); ?&gt;</code></td>
				</tr>
				<tr valign="top">
				<th scope="row"><label for="blogname">How Many Related Posts Want to Show?</label></th>
					<td><input type="text" class="code" value="' . $igit_rpwt['related_post_num'] . '" id="related_post_num" name="related_post_num" maxlength="2" size="4"/></td>
				</tr>';
    $chckd = ($igit_rpwt['display_thumb'] == "1") ? "checked=checked" : "";
    //echo $text; 
    echo $message_succ . '<tr valign="top">
				<th scope="row"><label for="blogname">Display Thumb?</label></th>
					<td><input type="checkbox" id="display_thumb" name="display_thumb" value="1" ' . $chckd . '/></td>
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
				<th scope="row" colspan="2"></td>
				</tr>
			</tbody>
		</table>
		</div>
		<input type="submit" name="sb_submit" id="sb_submit" value="Update Options" />&nbsp;<span id="loading_img" style="display:none;"><img src="' . WP_PLUGIN_URL . '/igit-rpwt/images/loader.gif"></span>
	</form>
</div>';
}

?>
