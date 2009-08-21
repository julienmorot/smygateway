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

// File configs
$config['squid']['maincfgFile']=$_SERVER["DOCUMENT_ROOT"]."config/squid/main";
$config['squid']['allowednetworksFile']=$_SERVER["DOCUMENT_ROOT"]."config/squid/allowedNetworks";
$config['squid']['allowedportsFile']=$_SERVER["DOCUMENT_ROOT"]."config/squid/allowedPorts";
$config['squid']['allowedsslportsFile']=$_SERVER["DOCUMENT_ROOT"]."config/squid/allowedSSLPorts";
$config['squid']['unrestrictedipFile']=$_SERVER["DOCUMENT_ROOT"]."config/squid/unrestrictedIP";
$config['squid']['bannedipFile']=$_SERVER["DOCUMENT_ROOT"]."config/squid/bannedIP";
$config['squid']['unrestrictedmacFile']=$_SERVER["DOCUMENT_ROOT"]."config/squid/unrestrictedMAC";
$config['squid']['bannedmacFile']=$_SERVER["DOCUMENT_ROOT"]."config/squid/bannedMAC";
$config['squid']['dstnocacheFile']=$_SERVER["DOCUMENT_ROOT"]."config/squid/dst_NoCache";
$config['squid']['daemoncfgFile']=$_SERVER["DOCUMENT_ROOT"]."config/squid/squid.conf";
$config['squid']['browsercfgFile']=$_SERVER["DOCUMENT_ROOT"]."config/squid/browserACL";
$config['squid']['restartSquid']=$_SERVER["DOCUMENT_ROOT"]."scripts/restartsquid.sh";

// Values
$cache_level1_subdir = Array(16, 32, 64, 128, 256);
$cache_level2_subdir = Array(128, 256, 512, 1024);
$cache_type = Array('aufs', 'diskd');
$cache_directory = "/var/spool/squid";
$cache_dir_default = "aufs /var/spool/squid 50 64 256";
$cache_replacement_policy = Array('lru', 'heap GDSF', 'heap LFUDA', 'heap LRU');
$error_lang_dir = "/usr/share/squid/errors";
$error_default_lang = "English";

$ua_list = Array(
	"AOL" => "AOL",
	"AvantBrowser" => "avantbrowser",
	"Firefox" => "Firefox",
	"FrontPage" => "FrontPage",
	"Gecko" => "Gecko",
	"GetRight" => "GetRight",
	"Go!Zilla" => "Go!Zilla",
	"Chrome" => "Chrome",
	"Google_Earth" => "kh_lt\/LT",
	"Google_Toolbar" => "Google\sToolbar",
	"Microsoft_Internet_Explorer" => "MSIE.*[)]$",
	"Java" => "Java",
	"Konqueror" => "Konqueror",
	"Lynx" => "Lynx",
	"Mac_OSX_Update" => "CFNetwork",
	"Windows_Media_Player" => "Windows\-Media\-Player",
	"Netscape" => "Netscape",
	"Opera" => "Opera",
	"Safari" => "Safari",
	"Windows_Genuine_Advantage" => "LegitCheck",
	"Wget" => "Wget",
	"APT" => "APT\-HTTP",
	"Microsoft_BITS" => "Microsoft\sBITS",
	"Windows_Update_Agent" => "Windows\-Update\-Agent",
	"Progressive_Download" => "Progressive\sDownload",
	"Windows_Update" => "Windows\sUpdate",
	"Industry_Update_Control" => "Industry\sUpdate\sControl",
	"Service_Pack_Setup" => "Service\sPack\sSetup"
);




?>
