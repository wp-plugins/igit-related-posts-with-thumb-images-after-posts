<?php header("content-type: application/x-javascript"); ?>
<?php 

if($_GET['igit_qtip_position'] == "Top")
{
	$igit_target = "topMiddle";
	$igit_tooltip = "bottomMiddle";
}
else
{
	$igit_target = "bottomMiddle";
	$igit_tooltip = "topMiddle";
}
?>
$(document).ready(function() 
{  
// Use the each() method to gain access to each elements attributes
   $('#igit_rpwt_css a').not(".igit_rpwt_rel_img").each(function()
   {
  
      $(this).qtip(
      {
			style: {
			name: '<?php echo addslashes($_GET['igit_qtip_style']); ?>', 
			tip: true,
			textAlign: '<?php echo addslashes($_GET['igit_qtip_content_align']); ?>',
			border: {
               width: <?php echo addslashes($_GET['igit_qtip_border_width']); ?>,
               radius: <?php echo addslashes($_GET['igit_qtip_border_radius']); ?>
            },
			width: <?php echo addslashes($_GET['igit_qtip_width']); ?>, // Set the tooltip width
			height: <?php echo addslashes($_GET['igit_qtip_height']); ?> // Set the tooltip width
			},
			
			position: { 
				corner: {
					target: '<?php echo addslashes($igit_target); ?>',
					tooltip: '<?php echo addslashes($igit_tooltip); ?>'
						} ,
					adjust: {
					   screen: true // Keep the tooltip on-screen at all times
					}
			},
			content: {
            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
            text: $(this).attr('rel'),
	         },
         show: { 
            when: '<?php echo addslashes($_GET['igit_qtip_show']); ?>', 
            solo: <?php echo addslashes($_GET['igit_qtip_solo']); ?>, // Only show one tooltip at a time
			effect: { type: '<?php echo addslashes($_GET['igit_qtip_show_effect_type']); ?>',length: <?php echo addslashes($_GET['igit_qtip_show_effect_length']); ?> }
         },
         hide: {
			when: '<?php echo addslashes($_GET['igit_hide_qtip']); ?>', 
			effect: { type: '<?php echo addslashes($_GET['igit_qtip_hide_effect_type']); ?>' }
		 }
			
		
      })
   });
   
   
    $('#igit_rpwt_css img').not(".igit_rpwt_rel_img").each(function()
   {
  
      $(this).qtip(
      {
			style: {
			name: '<?php echo addslashes($_GET['igit_qtip_style']); ?>', 
			tip: true,
			textAlign: '<?php echo addslashes($_GET['igit_qtip_content_align']); ?>',
			border: {
               width: <?php echo addslashes($_GET['igit_qtip_border_width']); ?>,
               radius: <?php echo addslashes($_GET['igit_qtip_border_radius']); ?>
            },
			width: <?php echo addslashes($_GET['igit_qtip_width']); ?>, // Set the tooltip width
			height: <?php echo addslashes($_GET['igit_qtip_height']); ?> // Set the tooltip width
			},
			
			position: { 
				corner: {
					target: '<?php echo addslashes($igit_target); ?>',
					tooltip: '<?php echo addslashes($igit_tooltip); ?>'
						} ,
					adjust: {
					   screen: true // Keep the tooltip on-screen at all times
					}
			},
			content: {
            // Set the text to an image HTML string with the correct src URL to the loading image you want to use
            text: $(this).parent().attr('rel'),
	         },
         show: { 
            when: '<?php echo addslashes($_GET['igit_qtip_show']); ?>', 
            solo: <?php echo addslashes($_GET['igit_qtip_solo']); ?>, // Only show one tooltip at a time
			effect: { type: '<?php echo addslashes($_GET['igit_qtip_show_effect_type']); ?>',length: <?php echo addslashes($_GET['igit_qtip_show_effect_length']); ?> }
         },
         hide: {
			when: '<?php echo addslashes($_GET['igit_hide_qtip']); ?>', 
			effect: { type: '<?php echo addslashes($_GET['igit_qtip_hide_effect_type']); ?>' }
		 }
			
		
      })
   });
   
   
   
   
   
   
  });