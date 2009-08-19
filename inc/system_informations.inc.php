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

function system_get_os_informations() {
	$res = array();
	$res['ostype'] = chop(`/sbin/sysctl -n kernel.ostype`);
	$res['osrelease'] = chop(`/sbin/sysctl -n kernel.osrelease`);
	$res['version'] = chop(`/sbin/sysctl -n kernel.version`);
	$res['hostname'] = chop(`/sbin/sysctl -n kernel.hostname`);
	return $res;
}

function system_get_ip_address() {
	return gethostbyaddr(gethostbyname(getenv('SERVER_NAME')));
}

function system_get_uptime() {
	$up = chop(`cat /proc/uptime`);
	$up = explode(" ", $up);
	$up = $up[0];
	$uptime = intval($up);
	// If the system is up since less than one hour :
	if ($uptime < 3600) {
		$time = intval($uptime / 60) ." mins.";
		return $time;
	}
	// If the system is up since less than a day :
	if (($uptime > 3600) && ($uptime < 86400)) {
		$uptime_to_h = $uptime / 3600;
		$h = intval($uptime_to_h);
		$htom = $h * 3600;
		$m = ($uptime - $htom) / 60;
		$time = intval($h)." hours ".intval($m)." mins";
		return $time;
	}
	// If the system is up since more than one day :
	if ($uptime > 86400) {
		$uptime_to_d = $uptime / 86400;
		$d = intval($uptime_to_d);
		$dtoh = $d * 86400;
		$h = ($uptime - $dtoh) / 1440;
		$time = intval($d)." days ".intval($h)." hours";
		return $time;
	}
}

function system_get_load_average() {
	$load = chop(`cat /proc/loadavg`);
	$load = explode(" ", $load);
	$load = $load[0]." ".$load[1]." ".$load[2];
	return $load;
}

function system_get_current_users() {
	$users = chop(`who -q`);
	$arrWho = split( '=', $users );
	return $arrWho[1];
}

?>
