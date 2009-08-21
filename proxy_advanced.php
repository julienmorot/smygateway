<?php
/*
    This file is part of Debian CA.

    Debian CA is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Foobar is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once('inc/squid.write.conf.inc.php');
require_once('inc/squid.config.inc.php');
require_once('inc/general.inc.php');
require_once('inc/squid.parse.inc.php');

proxy_do_parsing();

if (isset($_POST['reply_body_max_size'])) {
	proxy_parse_advanced_form_settings();
	proxy_write_settings();
	proxy_write_squid_conf();
	proxy_restart_service();
	header('Location: '.$_SERVER["PHP_SELF"].' ');
}

include('inc/header.php');

?>
<h1>Squid advanced proxying :</h1>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
 <fieldset>
  <legend>Transfert limits :</legend>
    Max download size (KB) : <input type="text" name="reply_body_max_size" size="10" maxlenght="10" value="<?php echo proxy_get_reply_body_max_size() ?>" /><br />
    Max upload size (KB) : <input type="text" name="request_body_max_size" size="10" maxlenght="10" value="<?php echo proxy_get_request_body_max_size() ?>" /><br />
 </fieldset>
 <br />
 <fieldset>
  <legend>Useragent authorizations :</legend>
  Enable User Agent filtering : <input type="checkbox" <?php proxy_draw_browser_filtering_status(); ?> name="ua_filter" /><br />
  Default useragent policy :
  <input type="radio" name="ua_policy" value="ua_policy_allow" <?php proxy_draw_browser_filtering_policy("allow"); ?> >Allow only...
  <input type="radio" name="ua_policy" value="ua_policy_deny" <?php proxy_draw_browser_filtering_policy("deny"); ?> >Deny this list...<br />
  <br />
  User agent list :<br />
  <table>
<?php
$i = 0;
foreach ($ua_list as $ua_name => $ua_sign) {
	if ($i == 0) {
		echo "<tr>\n";
	}
	$checked = proxy_draw_browser_filtering_useragent($ua_name);
	echo "<td><input type=\"checkbox\" $checked name=\"$ua_name\" />$ua_name</td>\n";
	$i++;
	if ($i == 3) {
		echo "</tr>\n";
		$i = 0;
	}
}
?>
  </table>
 </fieldset>
 <br />
 <input type="submit" value="Save configuration" />
 
</form>


<?
include('inc/footer.php');
?>

