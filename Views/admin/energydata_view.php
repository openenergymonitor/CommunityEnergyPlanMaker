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
<div style="margin: 0px auto; max-width: 1800px; text-align:left; margin-top:20px; padding:20px; min-height:500px; color:#000; background-color:#fff;">

<h2>Energy Data table</h2>

<table cellpadding="10">
<tr>

  <th>Username</th>

  <th width="80">Electric: kWh/d</th>
  <th width="80">Heating: kWh/d</th>
  <th width="80">Transport: kWh/d</th>

  <th>Electric (kwh)</th>
  <th>Electric Heat (kwh)</th>
  <th>Heatpump (kwh)</th>

  <th>Wood (m3)</th>
  <th>Wood (kwh)</th>

  <th>Wood Pellet (m3)</th>
  <th>Wood Pellet (kwh)</th>

  <th>Oil (L)</th>
  <th>Oil (kwh)</th>

  <th>Mains gas (m3)</th>
  <th>Mains gas (kwh)</th>

  <th>lpg (L)</th>
  <th>lpg (kwh)</th>

  <th>botgas (kg)</th>
  <th>botgas (kwh)</th>

  <th>coal (kg)</th>
  <th>coal (kwh)</th>

  <th>ecar (miles)</th>
  <th>ecar (kwh)</th>

  <th>car (miles)</th>
  <th>car (kwh)</th>

  <th>mbike (miles)</th>
  <th>mbike (kwh)</th>

  <th>bus (miles)</th>
  <th>bus (kwh)</th>

  <th>train (miles)</th>
  <th>train (kwh)</th>

</tr>

<?php foreach ($userlist as $user) { ?>

 <tr>
   <td><a href="setuser?id=<?php echo $user['userid']; ?>" ><?php echo $user['name']; ?></a></td>

   <?php 
 
   $energy = $user['endata']; 

   $electric = 0; $heating = 0; $transport = 0;
   foreach ($energy as $line){
     if ($line->type==0) $electric += $line->quantity * $line->kwh;
     if ($line->type==1) $heating += $line->quantity * $line->kwh;
     if ($line->type==2) $transport += $line->quantity * $line->kwh;
   }

   ?>

   <td><?php echo intval($electric/365.0); ?></td>
   <td><?php echo intval($heating/365.0); ?></td>
   <td><?php echo intval($transport/365.0); ?></td>

   <td><?php echo intval($energy->elec->quantity); ?></td>
   <td><?php echo intval($energy->eheat->quantity); ?></td>
   <td><?php echo intval($energy->stor->quantity); ?></td>

   <td><?php echo number_format($energy->wlog->quantity,1); ?></td>
   <td><?php echo intval($energy->wlog->quantity * $energy->wlog->kwh); ?></td>

   <td><?php echo intval($energy->wplt->quantity); ?></td>
   <td><?php echo intval($energy->wplt->quantity * $energy->wplt->kwh); ?></td>

   <td><?php echo intval($energy->oil->quantity); ?></td>
   <td><?php echo intval($energy->oil->quantity * $energy->oil->kwh); ?></td>

   <td><?php echo intval($energy->mgas->quantity); ?></td>
   <td><?php echo intval($energy->mgas->quantity * $energy->mgas->kwh); ?></td>

   <td><?php echo intval($energy->lpg->quantity); ?></td>
   <td><?php echo intval($energy->lpg->quantity * $energy->lpg->kwh); ?></td>

   <td><?php echo intval($energy->bgas->quantity); ?></td>
   <td><?php echo intval($energy->bgas->quantity * $energy->bgas->kwh); ?></td>

   <td><?php echo intval($energy->coal->quantity); ?></td>
   <td><?php echo intval($energy->coal->quantity * $energy->coal->kwh); ?></td>

   <td><?php echo intval($energy->ecar->quantity); ?></td>
   <td><?php echo intval($energy->ecar->quantity * $energy->ecar->kwh); ?></td>

   <td><?php echo intval($energy->car1->quantity); ?></td>
   <td><?php echo intval($energy->car1->quantity * $energy->car1->kwh); ?></td>

   <td><?php echo intval($energy->mbike->quantity); ?></td>
   <td><?php echo intval($energy->mbike->quantity * $energy->mbike->kwh); ?></td>

   <td><?php echo intval($energy->bus->quantity); ?></td>
   <td><?php echo intval($energy->bus->quantity * $energy->bus->kwh); ?></td>

   <td><?php echo intval($energy->train->quantity); ?></td>
   <td><?php echo intval($energy->train->quantity * $energy->train->kwh); ?></td>

 </tr>

<?php } ?>

</table>

</div>

