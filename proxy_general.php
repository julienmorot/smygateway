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

if (isset($_POST['http_port'])) {
	proxy_parse_general_form_settings();
	proxy_write_settings();
	proxy_write_squid_conf();
	proxy_restart_service();
	header('Location: '.$_SERVER["PHP_SELF"].' ');
}

include('inc/header.php');

?>
<h1>Squid General Configuration :</h1>

<form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
 <fieldset>
  <legend>General :</legend>
  <strong>Main settings :</strong><br />
  Port number : <input type="text" name="http_port" size="5" maxlenght="5" value="<?php echo proxy_get_http_port() ?>" /><br />
  Visible hostname : <input type="text" name="visible_hostname" size="5" maxlenght="5" value="<?php echo proxy_get_visible_hostname() ?>" /><br />
  Host file : <input type="text" name="hosts_file" size="30" maxlenght="60" value="<?php echo proxy_get_hosts_file() ?>" /><br />
  Coredump directory : <input type="text" name="coredump_dir" size="30" maxlenght="60" value="<?php echo proxy_get_coredump_dir() ?>" /><br />
  Error messages language : <select name="error_directory">
    <?php echo proxy_draw_lang(); ?>
  </select>
  <hr />
  <strong>Logs :</strong><br />
  Logs activated : <input type="checkbox" <?php echo proxy_get_access_log_checked(); ?> name="access_log" /><br />
  Logs user agents : <input type="checkbox" <?php echo proxy_get_useragent_log_checked(); ?> name="useragent_log" /><br />
  Logs query terms : <input type="checkbox" <?php echo proxy_get_strip_query_terms_checked(); ?> name="strip_query_terms" /><br />  
  <hr />
  <strong>Cache management :</strong><br />
  <table>
   <tr>
    <td>Memory cache size (MB) : <input type="text" name="cache_mem" size="5" maxlenght="5" value="<?php echo proxy_get_cache_mem() ?>" /><br /></td>
    <td>Minimum object size (Ko) <input type="text" name="minimum_object_size" size="5" maxlenght="5" value="<?php echo proxy_get_minimum_object_size() ?>" /><br /></td>
   </tr>
   <tr>
    <td>Harddisk cache size (MB) : <input type="text" name="cache_harddisk" size="5" maxlenght="5" value="<?php echo proxy_get_cache_harddisk() ?>" /><br /></td>
    <td>Maximum object size (Ko) <input type="text" name="maximum_object_size" size="5" maxlenght="5" value="<?php echo proxy_get_maximum_object_size() ?>" /><br /></td>
   </tr>
   <tr>
    <td>Memory replacement policy <select name="memory_replacement_policy">
        <?php echo proxy_draw_memory_replacement_policy($cache_replacement_policy) ?>
      </select>
      <br />
      Cache replacement policy <select name="cache_replacement_policy">
        <?php echo proxy_draw_cache_replacement_policy($cache_replacement_policy) ?>
      </select><br />
      Offline mode : <input type="checkbox" <?php echo proxy_get_offline_mode(); ?> name="offline_mode" /><br />
     </td>
     <td>
      Do not cache these destinations :
      <textarea name="dst_no_cache" cols="30" rows="10"><?php proxy_print_list($config['squid']['dst_no_cache']); ?></textarea><br />
     </td>
    <tr>
     <td>
      Level1 cache directory <select name="cache_level1">
        <?php echo proxy_draw_cache_level1_subdir($cache_level1_subdir); ?>
      </select>
      <br />
      Level2 cache subdirectory <select name="cache_level2">
        <?php echo proxy_draw_cache_level2_subdir($cache_level2_subdir); ?>
      </select>
     </td>
     <td>
      Cache type <select name="cache_type">
        <?php echo proxy_draw_cache_type($cache_type); ?>
      </select>
     </td>
    </tr>
  </table>
 </fieldset>
 <br />
  </table>
 <br />
 <input type="submit" value="Save configuration" />
 
</form>


<?
include('inc/footer.php');
?>

