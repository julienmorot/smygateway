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

if (isset($_POST['allowed_ports'])) {
	proxy_write_additionnal_conf();
	proxy_write_squid_conf();
	proxy_restart_service();
	header('Location: '.$_SERVER["PHP_SELF"].' ');
}

include('inc/header.php');

?>
<h1>Squid Network Access :</h1>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
 <fieldset>
  <legend>Network-based Access Control :</legend>
  <table>
   <tr><td>
     Ports :<br />
     <textarea name="allowed_ports" cols="30" rows="10"><?php proxy_print_list($config['squid']['allowedports']); ?></textarea><br />
   </td>
   <td>
     SSL Ports :<br />
     <textarea name="allowed_ssl_ports" cols="30" rows="10"><?php proxy_print_list($config['squid']['allowedsslports']); ?></textarea><br />
   </td></tr>
  </table>
  <hr />
  
  <table>
   <tr><td colspan="2">
    Allowed networks :<br />
    <textarea name="allowed_networks" cols="30" rows="10"><?php proxy_print_list($config['squid']['allowednetworks']); ?></textarea><br />
   </td></tr>
   <tr>
    <td>
     Unrestricted IP address :<br />
     <textarea name="unrestricted_ip" cols="30" rows="10"><?php proxy_print_list($config['squid']['unrestrictedip']); ?></textarea><br />
    </td>
    <td>
     Banned IP address :<br />
     <textarea name="banned_ip" cols="30" rows="10"><?php proxy_print_list($config['squid']['bannedip']); ?></textarea><br />
    </td>
   </tr>
   <tr>
    <td>
     Unrestricted MAC address :<br />
     <textarea name="unrestricted_mac" cols="30" rows="10"><?php proxy_print_list($config['squid']['unrestrictedmac']); ?></textarea><br />
    </td>
    <td>
     Banned MAC address :<br />
     <textarea name="banned_mac" cols="30" rows="10"><?php proxy_print_list($config['squid']['bannedmac']); ?></textarea><br />
    </td>
   </tr>
 </fieldset>
 
  </table>
 <br />
 <input type="submit" value="Save configuration" />
 
</form>


<?
include('inc/footer.php');
?>

