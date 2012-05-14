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


<h2>Electricity and electric heat</h2>
<p>Enter annual consumption or generation values</p>
<table>
<tr>
  <td  style="width:220px;">Electricity</td>
  <td  style="width:150px;"><?php echo form_input_text($data,'elec_tot',70); ?>&nbsp;kWh</td>
  <td  style="width:150px;">£&nbsp;<?php echo form_input_text($data,'elec_cost',70); ?></td>
</tr><tr>
  <td>Storage heaters</td>
  <td><?php echo form_input_text($data,'eheat_tot',70); ?>&nbsp;kWh</td>
  <td>£&nbsp;<?php echo form_input_text($data,'eheat_cost',70); ?></td>
</tr><tr>
  <td>Heatpump electrical input</td>
  <td><?php echo form_input_text($data,'hp_tot',70); ?>&nbsp;kWh</td>
  <td>£&nbsp;<?php echo form_input_text($data,'hp_cost',70); ?></td>
</tr><tr>
  <td>Do you know your COP?</td><td><?php echo form_input_text($data,'hp_cop',70); ?></td>
</tr>
<tr>
<td><br/><b>Onsite electrical generation</b></td>
</tr>
<tr>
<td>Solar PV</td>
<td><?php echo form_input_text($data,'spv_tot',70); ?>&nbsp;kWh</td>
</tr><tr>
<td>Hydro</td>
<td><?php echo form_input_text($data,'hydro_tot',70); ?>&nbsp;kWh</td>
</tr>

<tr>
<td>Wind</td>
<td><?php echo form_input_text($data,'wind_tot',70); ?>&nbsp;kWh</td>
</tr>

</table>

<br/>
<table>
<tr><td>Do you buy 100% Green Electricity?</td><td>
<?php echo form_input_select($data,"green_elec"," |yes|no"); ?></td></tr>
</table>
