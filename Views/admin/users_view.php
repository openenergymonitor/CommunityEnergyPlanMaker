<!--
   All Emoncms code is released under the GNU General Public License v3.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
-->

<?php
  // no direct access
  defined('EMONCMS_EXEC') or die('Restricted access');
?>

<style>
th { text-align:left; }
tr { background-color:#ddd; }

}
</style>

<div style="height:2px; background-color:#ddd"></div>
<div style="margin: 0px auto; max-width: 850px; text-align:left; margin-top:20px; padding:20px; min-height:500px; color:#000; background-color:#fff;">

<h2>Users</h2>
<h3><?php echo sizeof($userlist); ?> registered users</h3>

<table cellpadding="10">
<tr><th>id</th><th width="700px">Username</th><th>Hits</th><th>Admin</th></tr>
<?php 

foreach ($userlist as $user) {
  echo "<tr><td>".$user['userid']."</td><td><a href='setuser?id=".$user['userid']."'>".$user['name']."</a></td><td>".$user['dnhits']."</td><td>".$user['admin']."</td></tr>";
}

?>
</table>

</div>
