<!---------------------------------------------------------------------------------
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
---------------------------------------------------------------------------------->

<form name="input" action="" method="post">

<h2>Heating (non-electric)</h2>

<table>
<tr><th width="200px">Fuel Type</th><th width="200px" >Annual Consumption</th><th>System efficiency</th></tr>
<tr>
<!-- The question id's for the wood question are out of order -->
<td>Wood</td>
<td><?php echo form_input_text($data,'wood_m3',100); ?>&nbsp;m3</td>
<td><?php echo form_input_text($data,'wood_eff',100); ?>&nbsp;%</td>
</tr>
<tr>
<!-- The question id's for the wood question are out of order -->
<td>Wood pellet</td>
<td><?php echo form_input_text($data,'woodpellet_m3',100); ?>&nbsp;tonnes</td>
<td><?php echo form_input_text($data,'woodpellet_eff',100); ?>&nbsp;%</td>
</tr>

<tr>
<td>Heating Oil</td>
<td><?php echo form_input_text($data,'oil_L',100); ?>&nbsp;litres</td>
<td><?php echo form_input_text($data,'oil_eff',100); ?>&nbsp;%</td>
</tr>
<tr>
<td>Mains/Bulk Gas</td>
<td><?php echo form_input_text($data,'mainsgas_m3',100); ?>&nbsp;m3</td>
<td><?php echo form_input_text($data,'mainsgas_eff',100); ?>&nbsp;%</td>
</tr>
<tr>
<td>Bulk LPG</td>
<td><?php echo form_input_text($data,'lpg_L',100); ?>&nbsp;litres</td>
<td><?php echo form_input_text($data,'lpg_eff',100); ?>&nbsp;%</td>
</tr>
<tr>
<td>Propane or Butane</td>
<td><?php echo form_input_text($data,'botgas_kg',100); ?>&nbsp;kg</td>
<td><?php echo form_input_text($data,'botgas_eff',100); ?>&nbsp;%</td>
</tr>
<tr>
<td>Coal</td>
<td><?php echo form_input_text($data,'coal_kg',100); ?>&nbsp;kg</td>
<td><?php echo form_input_text($data,'coal_eff',100); ?>&nbsp;%</td>
</tr>
</table>
