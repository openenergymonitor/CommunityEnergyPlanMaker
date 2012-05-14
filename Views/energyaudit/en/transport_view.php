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

<form name="input" action="" method="post">

<h2>Transport</h2>

<table>
<tr><th width="150px"></th><th width="180px"></th><th width="90px">Fuel</th><th width="130px">Annual milage</th></tr>
<tr>
<td>First car/van</td><td><?php echo form_input_text($data,'car1_mpg',70); ?> MPG</td>
<td><?php echo form_input_select($data,"car1_fuel"," |petrol|diesel|LPG"); ?></td>
<td><?php echo form_input_text($data,'car1_miles',80); ?>&nbsp;miles</td>
</tr>
<tr>
<td>Second car/van</td><td><?php echo form_input_text($data,'car2_mpg',70); ?> MPG</td>
<td><?php echo form_input_select($data,"car2_fuel"," |petrol|diesel|LPG"); ?></td>
<td><?php echo form_input_text($data,'car2_miles',80); ?>&nbsp;miles</td>
</tr>
<tr>
<td>Third car/van</td><td><?php echo form_input_text($data,'car3_mpg',70); ?> MPG</td>
<td><?php echo form_input_select($data,"car3_fuel"," |petrol|diesel|LPG"); ?></td>
<td><?php echo form_input_text($data,'car3_miles',80); ?>&nbsp;miles</td>
</tr>

<tr>
<td>Electric car</td><td><?php echo form_input_text($data,'ecar_kwhm',70); ?> kWh/mile</td>
<td></td>
<td><?php echo form_input_text($data,'ecar_miles',80); ?>&nbsp;miles</td>
</tr>

<tr>
<td>Motorbike </td><td><?php echo form_input_text($data,'mbike_mpg',70); ?> CC</td>
<td><?php echo form_input_select($data,"mbike_fuel"," |petrol|diesel|LPG"); ?></td>
<td><?php echo form_input_text($data,'mbike_miles',80); ?>&nbsp;miles</td>
</tr>


<tr>
<th></th><th></th><th></th><th>Distance travelled</th>
</tr>
<tr>
<td>Bus</td> <td></td><td></td>
<td><?php echo form_input_text($data,'bus_miles',80); ?>&nbsp;miles</td>
</tr>
<tr>
<td>Train</td> <td></td><td></td>
<td><?php echo form_input_text($data,'train_miles',80); ?>&nbsp;miles</td>
</tr>
<tr>
<td>Boat</td> <td></td><td></td>
<td><?php echo form_input_text($data,'boat_miles',80); ?>&nbsp;miles</td>
</tr>
<tr>
<td>Plane</td> <td></td><td></td>
<td><?php echo form_input_text($data,'plane_miles',80); ?>&nbsp;miles</td>
</tr>


</table>
<p><b>Note:</b> If you fly or take a boat less than once a year, <br/>please give a 5 year average.</p>

</form> 
