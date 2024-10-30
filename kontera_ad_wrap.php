<?php
/*
Plugin Name: Kontera Ad Wrap
Plugin URI: http://justtalkaboutweb.com/2008/02/19/kontera-ad-wrap-wordpress-plugin/
Description: Simple plugin to wrap Kontera zone tags around content and/or comments
Version: 1.0.3
Author: Jimmy Vu
Author URI: http://justtalkaboutweb.com/


Copyright 2008  Jimmy Vu  (email : jimmy [a t ] justtalkaboutweb DOT com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/
// set default values on install
function kontera_ad_wrap_install() {
	if(get_option('kontera_wrap_content')=="") {
    	update_option('kontera_wrap_content', "Yes"); // wrap content by default
		update_option('kontera_wrap_comment', "No");
  	}
}

add_action("activate_kontera_ad_wrap/kontera_ad_wrap.php", "kontera_ad_wrap_install");

//add Kontera menu to the wordpress options menu
function kontera_add_options(){
  if(function_exists('add_options_page')){
    add_options_page('Kontera Ad Wrap', 'Kontera Ad Wrap', 9, basename(__FILE__), 'kontera_options_subpanel');
  }
}

//validate options
switch($_POST['kontera_action']){
	case 'Save':
	 	if($_POST['kontera_wrap_content'] == "on") update_option('kontera_wrap_content', "Yes");
	  	else update_option('kontera_wrap_content', "No");
	  	if($_POST['kontera_wrap_comment'] == "on") update_option('kontera_wrap_comment', "Yes");
	  	else update_option('kontera_wrap_comment', "No");
	  	break;
}

//option panel
function kontera_options_subpanel(){
?>
<div class="wrap"> 
  	<h2>Kontera Ad Wrap Options</h2> 
  	<form name="form1" method="post">
		<fieldset class="options">
			<legend>Options</legend>
			<INPUT TYPE=CHECKBOX NAME="kontera_wrap_content" <?php if(get_option('kontera_wrap_content')=="Yes") echo "CHECKED=on"; ?>>Wrap Content<BR><BR>
			<INPUT TYPE=CHECKBOX NAME="kontera_wrap_comment" <?php if(get_option('kontera_wrap_comment')=="Yes") echo "CHECKED=on"; ?>>Wrap Comment<BR>
		</fieldset>
		<br />
		<input type="submit" name="kontera_action" value="Save" />
	</form>
</div>

<?php
}


add_action('admin_menu', 'kontera_add_options');

// main functionality
function kontera_ad_wrap ($text)
{
	return '<div class="KonaBody">'.$text.'</div>';
}

if(get_option('kontera_wrap_content') == "Yes")
	add_filter ('the_content', 'kontera_ad_wrap');

if(get_option('kontera_wrap_comment') == "Yes")
	add_filter ('comment_text', 'kontera_ad_wrap');
?>