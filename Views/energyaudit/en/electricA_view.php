<!---------------------------------------------------------------------------------
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
---------------------------------------------------------------------------------->

<form name="input" action="" method="post">

<h2>Electricity and electric heat - part A</h2>
<p>Please enter annual consumption or generation values</p>
<table>
<tr>
<td  style="width:140px;">Electricity</td>
<td  style="width:150px;"><?php echo form_input_text($data,'elec_tot',70); ?>&nbsp;kWh</td>
<td>Storage heaters</td>
<td style="width:140px;"><?php echo form_input_text($data,'eheat_tot',70); ?>&nbsp;kWh</td>
</tr>

<tr>
<td>Heatpump electrical input</td>
<td><?php echo form_input_text($data,'hp_tot',70); ?>&nbsp;kWh</td>

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
<tr><td>If yes which supplier and tariff do you use?</td><td><?php echo form_input_text($data,'supplier',150); ?></td></tr>
<tr><td>How much of electricity consumption is business use?</td><td><?php echo form_input_text($data,'business_elec',100); ?>&nbsp;%</td></td></tr>
</table>


