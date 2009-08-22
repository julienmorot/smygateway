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

function proxy_parse_general_form_settings() {
	global $config;
	global $cache_directory;
	$config['squid']['main']['http_port'] = cleanInput($_POST['http_port']);
	$config['squid']['main']['visible_hostname'] = cleanInput($_POST['visible_hostname']);
	$config['squid']['main']['hosts_file'] = cleanInput($_POST['hosts_file']);
	$config['squid']['main']['coredump_dir'] = cleanInput($_POST['coredump_dir']);
	$config['squid']['main']['error_directory'] = $_POST['error_directory'];
	
	if ($_POST['access_log'] == "on") {
		$config['squid']['main']['access_log'] = "/var/log/squid/access.log";
		$config['squid']['main']['cache_log'] = "/var/log/squid/cache.log";
		$config['squid']['main']['cache_store_log'] = "none";
	} else { 
		$config['squid']['main']['access_log'] = "/dev/null";
		$config['squid']['main']['cache_log'] = "/dev/null";
		$config['squid']['main']['cache_store_log'] = "none";
	}
	if ($_POST['useragent_log'] == "on") {
		$config['squid']['main']['useragent_log'] = "/var/log/squid/user_agent.log";
	} else { $config['squid']['main']['useragent_log'] = "/dev/null"; }
	if ($_POST['strip_query_terms'] == "on") {
		$config['squid']['main']['strip_query_terms'] = "off";
	} else { $config['squid']['main']['strip_query_terms'] = "on"; }
	
	/* Cache */
	$config['squid']['main']['cache_mem'] = cleanInput($_POST['cache_mem'])." MB";
	$config['squid']['main']['cache_dir'] = $_POST['cache_type']." ".$cache_directory." ".cleanInput($_POST['cache_harddisk'])." ".$_POST['cache_level1']." ".$_POST['cache_level2'];
	$config['squid']['main']['minimum_object_size'] = cleanInput($_POST['minimum_object_size'])." KB";
	$config['squid']['main']['maximum_object_size'] = cleanInput($_POST['maximum_object_size'])." KB";
	$config['squid']['main']['memory_replacement_policy'] = $_POST['memory_replacement_policy'];
	$config['squid']['main']['cache_replacement_policy'] = $_POST['cache_replacement_policy'];
	if ((isset($_POST['offline_mode'])) && ($_POST['offline_mode'] == "on")) {
		$config['squid']['main']['offline_mode'] = "on";
	} else { $config['squid']['main']['offline_mode'] = "off"; }

	$fd = fopen($config['squid']['dstnocacheFile'], 'w+');
	fwrite($fd, $_POST['dst_no_cache']);
	fclose($fd);
}

function proxy_parse_advanced_form_settings() {
	global $config;
	global $ua_list;
	$size = intval(cleanInput($_POST['reply_body_max_size'])) * 1024;
	$config['squid']['main']['reply_body_max_size'] = $size." deny all";
	$config['squid']['main']['request_body_max_size'] = cleanInput($_POST['request_body_max_size'])." KB";

	$fd = fopen($config['squid']['browsercfgFile'], 'w+');
	if ($_POST['ua_filter'] == "on") {
		fwrite($fd, "BROWSER_FILTER=on\n");
	} else {
		fwrite($fd, "BROWSER_FILTER=off\n");
	}
	if (!isset($_POST['ua_policy'])) {
		$_POST['ua_policy'] = "ua_policy_allow";
	}
	if ($_POST['ua_policy'] == "ua_policy_allow") {
		fwrite($fd, "BROWSER_FILTER_POLICY=allow\n");
	} else {
		fwrite($fd, "BROWSER_FILTER_POLICY=deny\n");
	}

	$BROWSER_FILTER_UA = "BROWSER_FILTER_UA=";
	foreach ($ua_list as $ua_name => $ua_sign) {
		if (isset($_POST[$ua_name])) {
			$BROWSER_FILTER_UA .= $ua_name.",";
		}
	}
	$BROWSER_FILTER_UA = substr($BROWSER_FILTER_UA, 0, -1);
	fwrite($fd, $BROWSER_FILTER_UA."\n");
}

/*
* Save every form values into a easily parsable key=value file
*/
function proxy_write_settings() {
	global $config;
	copy($config['squid']['maincfgFile'], $config['squid']['maincfgFile'].".bak");
	$fd = fopen($config['squid']['maincfgFile'], 'w+');
	foreach ($config['squid']['main'] as $key => $val) {
		$val = rtrim($val);
		fwrite($fd,$key."=".$val."\n");
	}
	fclose($fd);
}

/*
* Write every additional ACL files from network access tab
*/
function proxy_write_additionnal_conf() {
	global $config;

	$fd = fopen($config['squid']['allowedportsFile'], 'w+');
	fwrite($fd, $_POST['allowed_ports']);
	fclose($fd);
	
	$fd = fopen($config['squid']['allowedsslportsFile'], 'w+');
	fwrite($fd, $_POST['allowed_ssl_ports']);
	fclose($fd);
	
	$fd = fopen($config['squid']['allowednetworksFile'], 'w+');
	fwrite($fd, $_POST['allowed_networks']);
	fclose($fd);
	
	$fd = fopen($config['squid']['unrestrictedipFile'], 'w+');
	fwrite($fd, $_POST['unrestricted_ip']);
	fclose($fd);
	
	$fd = fopen($config['squid']['bannedipFile'], 'w+');
	fwrite($fd, $_POST['banned_ip']);
	fclose($fd);
	
	$fd = fopen($config['squid']['unrestrictedmacFile'], 'w+');
	fwrite($fd, $_POST['unrestricted_mac']);
	fclose($fd);
	
	$fd = fopen($config['squid']['bannedmacFile'], 'w+');
	fwrite($fd, $_POST['banned_mac']);
	fclose($fd);
	
}

/*
* Write a temporary squid-compliant (as much as possible) squid.conf
*/
function proxy_write_squid_conf() {
	global $config;
	
	copy($config['squid']['daemoncfgFile'], $config['squid']['daemoncfgFile'].".bak");
	$fd = fopen($config['squid']['daemoncfgFile'], 'w+');

	fwrite($fd, "acl all src 0.0.0.0/0.0.0.0\n");
	fwrite($fd, "acl localhost src 127.0.0.1/255.255.255.255\n");

	fwrite($fd, "## GENERAL CONFIG\n");
	foreach ($config['squid']['main'] as $key => $val) {
		$val = rtrim($val);
		fwrite($fd,$key." ".$val."\n");
	}	

	$line = "acl no_cache_domains url_regex -i \"".$config['squid']['dstnocacheFile']."\"\n";
	fwrite($fd, $line);
	fwrite($fd, "cache deny no_cache_domains\n");
	
	fwrite($fd, "\n");

	$lines = proxy_parse_list($config['squid']['allowedsslportsFile']);
	if (!empty($lines)) {
		foreach ($lines as $line) {
			$line = rtrim($line);
			fwrite($fd, "acl SSL_ports port $line\n");
		}
	}
	
	$lines = proxy_parse_list($config['squid']['allowedportsFile']);
	if (!empty($lines)) {
		foreach ($lines as $line) {
			$line = rtrim($line);
			fwrite($fd, "acl Safe_ports port $line\n");
		}
	}
	
	$lines = proxy_parse_list($config['squid']['allowednetworksFile']);
	if (!empty($lines)) {
		$filename = '"'.$config['squid']['allowednetworksFile'].'"';
		fwrite($fd, "acl Allowed_networks src $filename\n");
	}
	fwrite($fd, "acl purge method PURGE\n");
	fwrite($fd, "acl CONNECT method CONNECT\n");
	fwrite($fd, "acl manager proto cache_object\n");

	if (proxy_get_browser_filtering_status() == "true") {
		$useragent_acl_name = "acl_useragent";
		$acl = "acl ".$useragent_acl_name." browser -i ".proxy_draw_browser_filtering_squidconf()."\n";
		fwrite($fd, $acl);
	}
	
	$lines = proxy_parse_list($config['squid']['unrestrictedipFile']);
	if (!empty($lines)) {
		$filename = '"'.$config['squid']['unrestrictedipFile'].'"';
		fwrite($fd, "acl Unrestricted_IP src $filename\n");
	}

	$lines = proxy_parse_list($config['squid']['bannedipFile']);
	if (!empty($lines)) {
		$filename = '"'.$config['squid']['bannedipFile'].'"';
		fwrite($fd, "acl Banned_IP src $filename\n");
	}
	
	$lines = proxy_parse_list($config['squid']['unrestrictedmacFile']);
	if (!empty($lines)) {
		$filename = '"'.$config['squid']['unrestrictedmacFile'].'"';
		fwrite($fd, "acl Unrestricted_MAC arp $filename\n");
	}

	$lines = proxy_parse_list($config['squid']['bannedmacFile']);
	if (!empty($lines)) {
		$filename = '"'.$config['squid']['bannedmacFile'].'"';
		fwrite($fd, "acl Banned_MAC arp $filename\n");
	}
	
	fwrite($fd, "http_access allow manager localhost\n");
	fwrite($fd, "http_access deny manager\n");
	fwrite($fd, "http_access allow purge localhost\n");
	fwrite($fd, "http_access deny purge\n");
	fwrite($fd, "\n## ONLY AUTHORIZED PORTS ARE ALLOWED\n");
	fwrite($fd, "http_access deny !Safe_ports\n");
	fwrite($fd, "\n## NO HTTP CONNECT METHOD WITHOUT SSL OF COURSE\n");
	fwrite($fd, "http_access deny CONNECT !SSL_ports\n");
	
	fwrite($fd, "\n## THE PROXY HAS NO LIMITATIONS\n");
	fwrite($fd, "http_access allow localhost\n");

	$lines = proxy_parse_list($config['squid']['bannedipFile']);
	if (!empty($lines)) {	
		fwrite($fd, "http_access deny Banned_IP\n");
	}

	$lines = proxy_parse_list($config['squid']['unrestrictedipFile']);
	if (!empty($lines)) {	
		fwrite($fd, "http_access allow Unrestricted_IP\n");
	}

	$lines = proxy_parse_list($config['squid']['bannedmacFile']);
	if (!empty($lines)) {	
		fwrite($fd, "http_access deny Banned_MAC\n");
	}

	$lines = proxy_parse_list($config['squid']['unrestrictedmacFile']);
	if (!empty($lines)) {	
		fwrite($fd, "http_access allow Unrestricted_MAC\n");
	}

	if ((proxy_get_browser_filtering_status() == "true") && (proxy_get_browser_filtering_policy() == "deny")) {
		fwrite($fd, "http_access deny $useragent_acl_name\n");
		$useragent_acl_name = "";
	}

	$lines = proxy_parse_list($config['squid']['allowednetworksFile']);
	if (!empty($lines)) {	
		fwrite($fd, "http_access allow Allowed_networks $useragent_acl_name\n");
		fwrite($fd, "http_access allow CONNECT Allowed_networks\n");
	}
	
	fwrite($fd, "\n## AND FINALLY EVERYTHING IS REFUSED\n");
	fwrite($fd, "http_access deny all\n");

	fwrite($fd, "\n");
	fclose($fd);
	
}

function proxy_restart_service() {
	global $config;
//	system($config['squid']['restartSquid']);
}



?>
