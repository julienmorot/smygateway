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

function proxy_parse_main_config($filename) {
    $lines = file($filename);  
    $config = array();

    foreach ($lines as $line) {
        list($k, $v) = explode('=', $line);
// FIXME: look if others rtrim are always needed...
	$config[$k] = rtrim($v);
    }

    return $config;
}

function proxy_print_list($lines) {
	if (!empty($lines)) {
		foreach ($lines as $line) {
			echo $line;
		}
	}
}

function proxy_parse_list($filename) {
	$lines = "";
	if (file_exists($filename)) {	
		$lines = file($filename);  
	}
	return $lines;
}

function proxy_get_http_port() {
	global $config;
	if (!isset($config['squid']['main']['http_port'])) {
		$config['squid']['main']['http_port'] = 3128;
	}
	return $config['squid']['main']['http_port'];
}

function proxy_get_hosts_file() {
        global $config;
        if (!isset($config['squid']['main']['hosts_file'])) {
		$config['squid']['main']['hosts_file'] = "/etc/hosts";
	}
        return $config['squid']['main']['hosts_file'];
}

function proxy_get_coredump_dir() {
        global $config;
        return $config['squid']['main']['coredump_dir'];
}

/**
* CACHE
* Default values are Squid default values
*/

function proxy_get_cache_mem() {
	global $config;
	if (!isset($config['squid']['main']['cache_mem'])) {
		$config['squid']['main']['cache_mem'] = 8;
	} else {
		$mem = explode(" ", $config['squid']['main']['cache_mem']);
		$config['squid']['main']['cache_mem'] = $mem[0];
	}
	return $config['squid']['main']['cache_mem'];
}

function proxy_get_cache_harddisk() {
	global $config;
	global $cache_dir_default;
	if (!isset($config['squid']['main']['cache_dir'])) {
		$config['squid']['main']['cache_dir'] = $cache_dir_default;
        }
	$cache_dir_opts = explode(" ", $config['squid']['main']['cache_dir']);
        return $cache_dir_opts[2];
}

function proxy_get_minimum_object_size() {
	global $config;
	if (!isset($config['squid']['main']['minimum_object_size'])) {
		$config['squid']['main']['minimum_object_size'] = 0;
	} else {
		$obj = explode(" ", $config['squid']['main']['minimum_object_size']);
		$config['squid']['main']['minimum_object_size'] = $obj[0];
	}
	return $config['squid']['main']['minimum_object_size'];
}

function proxy_get_maximum_object_size() {
	global $config;
	if (!isset($config['squid']['main']['maximum_object_size'])) {
		$config['squid']['main']['maximum_object_size'] = 20480;
	} else {
		$obj = explode(" ", $config['squid']['main']['maximum_object_size']);
		$config['squid']['main']['maximum_object_size'] = $obj[0];
	}
	return $config['squid']['main']['maximum_object_size'];
}

function proxy_draw_memory_replacement_policy($cache_replacement_policy) {
	foreach ($cache_replacement_policy as $policy) {
		if ($policy == proxy_get_memory_replacement_policy()) {
			echo "<option value=\"$policy\" selected=\"selected\">".$policy."</option>\n";
		} else {
			echo "<option value=\"$policy\">".$policy."</option>\n";
		}
	}
}

function proxy_get_memory_replacement_policy() {
	global $config;
	if (!isset($config['squid']['main']['memory_replacement_policy'])) {
		$config['squid']['main']['memory_replacement_policy'] = "lru";
	}
	return $config['squid']['main']['memory_replacement_policy'];
}

function proxy_draw_cache_replacement_policy($cache_replacement_policy) {
	foreach ($cache_replacement_policy as $policy) {
		if ($policy == rtrim(proxy_get_cache_replacement_policy())) {
			echo "<option value=\"$policy\" selected=\"selected\">".$policy."</option>\n";
		} else {
			echo "<option value=\"$policy\">".$policy."</option>\n";
		}
	}
}

function proxy_get_cache_replacement_policy() {
	global $config;
	if (!isset($config['squid']['main']['cache_replacement_policy'])) {
		$config['squid']['main']['cache_replacement_policy'] = "lru";
	}
	return $config['squid']['main']['cache_replacement_policy'];
}

function proxy_draw_cache_level1_subdir($cache_level1_subdir) {
	foreach ($cache_level1_subdir as $dir) {
		if ($dir == rtrim(proxy_get_cache_level1_subdir())) {
			echo "<option value=\"$dir\" selected=\"selected\">".$dir."</option>\n";
		} else {
			echo "<option value=\"$dir\">".$dir."</option>\n";
		}
	}
}

function proxy_get_cache_level1_subdir() {
	global $config;
	global $cache_dir_default;
	if (!isset($config['squid']['main']['cache_dir'])) {
		$config['squid']['main']['cache_dir'] = $cache_dir_default;
	}
	$cache_dir_opts = explode(" ", $config['squid']['main']['cache_dir']);
	return $cache_dir_opts[3];
}

function proxy_draw_cache_level2_subdir($cache_level2_subdir) {
	foreach ($cache_level2_subdir as $dir) {
		if ($dir == proxy_get_cache_level2_subdir()) {
			echo "<option value=\"$dir\" selected=\"selected\">".$dir."</option>\n";
		} else {
			echo "<option value=\"$dir\">".$dir."</option>\n";
		}
	}
}

function proxy_get_cache_level2_subdir() {
	global $config;
	global $cache_dir_default;
	if (!isset($config['squid']['main']['cache_dir'])) {
		$config['squid']['main']['cache_dir'] = $cache_dir_default;
        }
	$cache_dir_opts = explode(" ", $config['squid']['main']['cache_dir']);
	return $cache_dir_opts[4];
}

function proxy_draw_cache_type($cache_type) {
	foreach ($cache_type as $type) {
		if ($type == proxy_get_cache_type()) {
			echo "<option value=\"$type\" selected=\"selected\">".$type."</option>\n";
		} else {
			echo "<option value=\"$type\">".$type."</option>\n";
		}
	}
}

function proxy_get_cache_type() {
	global $config;
	$cache_dir_opts = explode(" ", $config['squid']['main']['cache_dir']);
	return $cache_dir_opts[0];
}

/**
* LOGS
*/
function proxy_get_access_log_checked() {
        global $config;
        if (strcmp(rtrim($config['squid']['main']['access_log']), rtrim("/var/log/squid/access.log")) == 0) {
        	return "checked=\"checked\"";
        }
}

function proxy_get_useragent_log_checked() {
        global $config;
        if (strcmp(rtrim($config['squid']['main']['useragent_log']), rtrim("/var/log/squid/user_agent.log")) == 0) {
        	return "checked=\"checked\"";
        }
}

function proxy_get_strip_query_terms_checked() {
        global $config;
        if (strcmp(rtrim($config['squid']['main']['strip_query_terms']), rtrim("off")) == 0) {
        	return "checked=\"checked\"";
        }
}

function proxy_get_visible_hostname() {
        global $config;
        if (!isset($config['squid']['main']['visible_hostname'])) {
        	$config['squid']['main']['visible_hostname'] = @system('hostname');
        }
       	return $config['squid']['main']['visible_hostname'];
}

function proxy_get_offline_mode() {
        global $config;
        if (!isset($config['squid']['main']['offline_mode'])) {
        	$config['squid']['main']['offline_mode'] = "off";
        }
        if ($config['squid']['main']['offline_mode'] == "on") {
        	return "checked=\"checked\"";
        }
}

function proxy_get_error_lang_avail() {
	global $error_lang_dir;
	$arrDir = Array();
	$langdir = opendir($error_lang_dir);
	while ($dir = readdir($langdir)) {
		if ($dir != "." && $dir != "..") {
			$arrDir[] = $dir;
		}
	}
	closedir($langdir);
	sort($arrDir);
	return $arrDir;
}

function proxy_set_default_error_lang() {
	global $config;
	global $error_lang_dir;
	global $error_default_lang;
	if (!isset($config['squid']['main']['error_directory'])) {
		$config['squid']['main']['error_directory'] = $error_lang_dir."/".$error_default_lang;
	}
}

function proxy_draw_lang() {
	global $error_lang_dir;
	global $error_default_lang;
	global $config;
	proxy_set_default_error_lang();
	$langs = proxy_get_error_lang_avail();
	$defined_lang = $config['squid']['main']['error_directory'];
	$defined_lang = explode('/', $defined_lang);
	$max = count($defined_lang);
	$defined_lang = $defined_lang[$max-1];
	foreach ($langs as $lang) {
		if ($lang == $defined_lang ) {
			echo "<option selected=\"selected\" value=\"".$error_lang_dir."/".$lang."\">".$lang."</option>\n";
		} else {
			echo "<option value=\"".$error_lang_dir."/".$lang."\">".$lang."</option>\n";
		}
	}
}

/*
* Transfert limit
*/
function proxy_get_reply_body_max_size() {
	global $config;
	if (!isset($config['squid']['main']['reply_body_max_size'])) {
		$config['squid']['main']['reply_body_max_size'] = 0;
	} else {
		$size = explode(" ", $config['squid']['main']['reply_body_max_size']);
		$config['squid']['main']['reply_body_max_size'] = $size[0];
	}
	return $config['squid']['main']['reply_body_max_size'] / 1024;
}

function proxy_get_request_body_max_size() {
	global $config;
	if (!isset($config['squid']['main']['request_body_max_size'])) {
		$config['squid']['main']['request_body_max_size'] = 0;
	} else {
		$size = explode(" ", $config['squid']['main']['request_body_max_size']);
		$config['squid']['main']['request_body_max_size'] = $size[0];
	}
	return $config['squid']['main']['request_body_max_size'];
}

function proxy_do_parsing() {
	global $config;
	$config['squid']['main'] = proxy_parse_main_config($config['squid']['maincfgFile']);
	$config['squid']['allowedports'] = proxy_parse_list($config['squid']['allowedportsFile']);
	$config['squid']['allowedsslports'] = proxy_parse_list($config['squid']['allowedsslportsFile']);
	$config['squid']['allowednetworks'] = proxy_parse_list($config['squid']['allowednetworksFile']);
	$config['squid']['unrestrictedip'] = proxy_parse_list($config['squid']['unrestrictedipFile']);
	$config['squid']['bannedip'] = proxy_parse_list($config['squid']['bannedipFile']);
	$config['squid']['unrestrictedmac'] = proxy_parse_list($config['squid']['unrestrictedmacFile']);
	$config['squid']['bannedmac'] = proxy_parse_list($config['squid']['bannedmacFile']);
	$config['squid']['dst_no_cache'] = proxy_parse_list($config['squid']['dstnocacheFile']);
}

?>
