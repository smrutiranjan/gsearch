<?php
/*
Plugin Name: GSearch form
Plugin URI: https://github.com/smrutiranjan/gsearch
Description: This is a custom google search form.You can download the latest from <a href="https://github.com/smrutiranjan/gsearch/archive/master.zip">here</a>
Author: Smrutiranjan
Author URI: http://smrutiranjan.in
Version: 0.3
Text Domain: Google Custom Search
*/

define("PLUGIN_NAME","Google Custom Search");
define("PLUGIN_TAGLINE","Customize your google custom search setting");

register_activation_hook(__FILE__,'google_custom_search_install');

function google_custom_search_install()
{
$google_search_css='.cse input.gsc-input, input.gsc-input {background-image:none !important;}
input.gsc-search-button, input.gsc-search-button:hover, input.gsc-search-button:focus {background-color:#41C800;border-color:#41C800;}
input.gsc-input, .gsc-input-box, .gsc-input-box-hover, .gsc-input-box-focus{border-color:#FF7907;}
.gsc-control-cse{background:none;background-color:none;border-color:transparent;border:0px;}
.cse .gsc-control-cse, .gsc-control-cse{padding:0;margin:0;border-color:none;}
form.gsc-search-box{margin:0;}
.cse .gsc-search-button input.gsc-search-button-v2, input.gsc-search-button-v2{margin:0;}
table.gsc-search-box td{vertical-align:top;}

/* Smartphones (portrait and landscape) ----------- */
@media only screen 
and (min-device-width : 320px) 
and (max-device-width : 480px) {
.customgsearch { width: 100%; left: 0; top:0;}
}

/* Smartphones (landscape) ----------- */
@media only screen 
and (min-width : 321px) {
.customgsearch { width: 100%; left: 0; top:0;}
}

/* Smartphones (portrait) ----------- */
@media only screen 
and (max-width : 320px) {
.customgsearch { width: 100%; left: 0; top:0;}
}

/* iPads (portrait and landscape) ----------- */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) {
.customgsearch { position: absolute; z-index: 999; width: 100%; left: 0; top: 0;}
}

/* iPads (landscape) ----------- */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) 
and (orientation : landscape) {
.customgsearch { position: absolute; z-index: 999; width: 350px; left: 230px; top: 139px;}
}

/* iPads (portrait) ----------- */
@media only screen 
and (min-device-width : 768px) 
and (max-device-width : 1024px) 
and (orientation : portrait) {
.customgsearch { width: 100%; left: 0; top: 0;}
}

/* Desktops and laptops ----------- */
@media only screen 
and (min-width : 1224px) {
.customgsearch { position: absolute; z-index: 999; width: 350px; left: 230px; top: 139px;}
}

/* Large screens ----------- */
@media only screen 
and (min-width : 1824px) {
.customgsearch { position: absolute; z-index: 999; width: 350px; left: 30%; top: 139px;}
}

/* iPhone 4 ----------- */
@media
only screen and (-webkit-min-device-pixel-ratio : 1.5),
only screen and (min-device-pixel-ratio : 1.5) {
.customgsearch { width: 100%; left: 0; top: 0;}
}
';
	$google_search_code='011868867032629366780:jwjioz8d8-a';
	
	delete_option( 'google_search_css');
	add_option( 'google_search_css',$google_search_css, '', 'yes' ); 
	
	delete_option( 'google_search_code');
	add_option( 'google_search_code',$google_search_code, '', 'yes' ); 	
}
if ( is_admin() ){ // admin actions
	add_action('admin_menu', 'googlesearch_settingform');	
}

function googlesearch_settingform() {
	add_menu_page( 'Google Search', 'Google Search', 'manage_options', 'gsearch', 'gsearch_setting'); 
}
function gsearch_setting() {
	$msg='';
	if(isset($_POST['save'])){			
		if(isset($_POST["google_search_css"]))
		{
			delete_option('google_search_css');
			add_option('google_search_css',$_POST["google_search_css"], '', 'yes' ); 
		}
		$msg="Setting has been saved successfully.";
	}
	?>
    <div class="pea_admin_wrap">
        <div class="pea_admin_top">
            <h1><?php echo PLUGIN_NAME ?> <small> - <?php echo PLUGIN_TAGLINE ?></small></h1>
        </div>
 		<?php if($msg!=""){ echo '<div class="msg">'.$msg.'</div>';}?>
        <div class="pea_admin_main_wrap">
            <div class="pea_admin_main_left">
            <form method="post" action="" name="form1" enctype="multipart/form-data">
	            <p>Google Search Custom Id</p> 
                <p><input type="text" name="gsearch" size="80" value="<?php echo get_option('google_search_code');?>"/></p>           	               
                <p>Stylesheet</p>
                <p><textarea name="google_search_css" class="regular-text csstxt"><?php echo stripslashes(get_option('google_search_css'));?></textarea></p>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Setings') ?>" name="save"/>
                </p>
                <p><strong>Shortcode:&nbsp;</strong>[gsearch]</p>
			</form>            
            </div>
		</div>            
    </div>
    <?php
}
add_shortcode('gsearch','gsearchfun');
function gsearchfun($attr)
{
	$str='';
	$str .= '<style>'."\n";
	$str .= get_option('google_search_css');
	$str .= '</style>
<script>
  (function() {
    var cx = \''.get_option('google_search_code').'\';
    var gcse = document.createElement(\'script\');
    gcse.type = \'text/javascript\';
    gcse.async = true;
    gcse.src = (document.location.protocol == \'https:\' ? \'https:\' : \'http:\') +
        \'//www.google.com/cse/cse.js?cx=\' + cx;
    var s = document.getElementsByTagName(\'script\')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<div class="customgsearch"><gcse:search></gcse:search></div>';
return $str;
}
?>