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

include('inc/header.php');
?>

<?php
require('inc/system_informations.inc.php');
$os = system_get_os_informations();

?>
<h1>System informations :</h1>

Operating system : <?php echo $os['ostype']; ?> on <?php echo $os['hostname']; ?><br />
Version : <?php echo $os['osrelease']; echo $os['version'] ?><br />
IP Address : <?php echo system_get_ip_address() ?><br />
Uptime : <?php echo system_get_uptime(); ?><br />
Load average : <?php echo system_get_load_average(); ?><br />
Current users : <?php echo system_get_current_users(); ?><br />



<?
include('inc/footer.php');
?>

