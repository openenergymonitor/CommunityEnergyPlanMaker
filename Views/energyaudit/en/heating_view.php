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

<h2>Heating (non-electric)</h2>

<table cellpadding="2">
<tr>
<th width="150px">Fuel Type</th>
<th width="180px">Annual consumption</th>
<th width="110px">Annual cost</th>
<th>System efficiency</th>
</tr>
<tr>
<td>Heating Oil</td>
<td><?php echo form_input_text($data,'oil_L',100); ?>&nbsp;litres</td>
<td>£ <?php echo form_input_text($data,'oil_cost',70); ?>&nbsp;</td>
<td><?php echo form_input_text($data,'oil_eff',70); ?>&nbsp;%</td>
</tr>
<tr>
<td>Wood pellet</td>
<td><?php echo form_input_text($data,'woodpellet_m3',100); ?>&nbsp;tonnes</td>
<td>£ <?php echo form_input_text($data,'woodpellet_cost',70); ?>&nbsp;</td>
<td><?php echo form_input_text($data,'woodpellet_eff',70); ?>&nbsp;%</td>
</tr>
<tr>
<td>Mains/Bulk Gas</td>
<td><?php echo form_input_text($data,'mainsgas_m3',100); ?>&nbsp;m3</td>
<td>£ <?php echo form_input_text($data,'mainsgas_cost',70); ?>&nbsp;</td>
<td><?php echo form_input_text($data,'gas_eff',70); ?>&nbsp;%</td>
</tr>
<tr>
<td>Bulk LPG</td>
<td><?php echo form_input_text($data,'lpg_L',100); ?>&nbsp;litres</td>
<td>£ <?php echo form_input_text($data,'lpg_cost',70); ?>&nbsp;</td>
<td><?php echo form_input_text($data,'lpg_eff',70); ?>&nbsp;%</td>
</tr>
<tr>
<td>Propane or Butane</td>
<td><?php echo form_input_text($data,'botgas_kg',100); ?>&nbsp;kg</td>
<td>£ <?php echo form_input_text($data,'botgas_cost',70); ?>&nbsp;</td>
<td><?php echo form_input_text($data,'botgas_eff',70); ?>&nbsp;%</td>
</tr>
<tr>
<td>Coal</td>
<td><?php echo form_input_text($data,'coal_kg',100); ?>&nbsp;kg</td>
<td>£ <?php echo form_input_text($data,'coal_cost',70); ?>&nbsp;</td>
<td><?php echo form_input_text($data,'coal_eff',70); ?>&nbsp;%</td>
</tr>
<tr>
<!-- The question id's for the wood question are out of order -->
<td>Wood</td>
<td><?php echo form_input_text($data,'wood_m3',100); ?>&nbsp;m3</td>
<td>£ <?php echo form_input_text($data,'wood_cost',70); ?>&nbsp;</td>
<td><?php echo form_input_text($data,'wood_eff',70); ?>&nbsp;%</td>
</tr>
</table>
