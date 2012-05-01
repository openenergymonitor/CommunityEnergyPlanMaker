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
<tr><th width="200px">Fuel Type</th><th>Annual Consumption</th></tr>
<tr>
<!-- The question id's for the wood question are out of order -->
<td>Wood</td>
<td><?php echo form_input_text($data,'wood_m3',100); ?>&nbsp;m3</td>
</tr>
<tr>
<!-- The question id's for the wood question are out of order -->
<td>Wood pellet</td>
<td><?php echo form_input_text($data,'woodpellet_m3',100); ?>&nbsp;tonnes</td>
</tr>

<tr>
<td>Heating Oil</td>
<td><?php echo form_input_text($data,'oil_L',100); ?>&nbsp;litres</td>
</tr>
<tr>
<td>Mains/Bulk Gas</td>
<td><?php echo form_input_text($data,'mainsgas_m3',100); ?>&nbsp;m3</td>
</tr>
<tr>
<td>Bulk LPG</td>
<td><?php echo form_input_text($data,'lpg_L',100); ?>&nbsp;litres</td>
</tr>
<tr>
<td>Propane or Butane</td>
<td><?php echo form_input_text($data,'botgas_kg',100); ?>&nbsp;kg</td>
</tr>
<tr>
<td>Coal</td>
<td><?php echo form_input_text($data,'coal_kg',100); ?>&nbsp;kg</td>
</tr>
</table>

<table>
<tr>
<td >How much of the above is business use?</td>
<td width="200px"><?php echo form_input_text($data,'business_heat',100); ?>&nbsp;%</td>
</tr>
</table>
<div class='button05' style="line-height:30px; width:160px;"><a href="../energyaudit/hcon">2. Heating context ></a></div>



