<!---------------------------------------------------------------------------------
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
---------------------------------------------------------------------------------->

<form name="input" action="" method="post">

<h2>Transport</h2>
<p>How many miles does your family / household travel annually on average?</p>

<table>
<tr><th width="70px">Cars</th><th width="80px">MPG</th><th width="90px">Fuel</th><th width="200px">Distance travelled</th></tr>
<tr>
<td>Car 1</td><td><?php echo form_input_text($data,'car1_mpg',50); ?></td>
<td><?php echo form_input_select($data,"car1_fuel"," |petrol|diesel|LPG"); ?></td>
<td><?php echo form_input_text($data,'car1_miles',100); ?>&nbsp;miles</td>

</tr>
<tr>
<td>Car 2</td><td><?php echo form_input_text($data,'car2_mpg',50); ?></td>
<td><?php echo form_input_select($data,"car2_fuel"," |petrol|diesel|LPG"); ?></td>
<td><?php echo form_input_text($data,'car2_miles',100); ?>&nbsp;miles</td>
</tr>
<tr>
<td>Car 3</td><td><?php echo form_input_text($data,'car3_mpg',50); ?></td>
<td><?php echo form_input_select($data,"car3_fuel"," |petrol|diesel|LPG"); ?></td>
<td><?php echo form_input_text($data,'car3_miles',100); ?>&nbsp;miles</td>
</tr>

<tr>
<td>Electric car</td><td>n/a</td>
<td>Electric</td>
<td><?php echo form_input_text($data,'ecar_miles',100); ?>&nbsp;miles</td>
</tr>


</table>
<br/>
<table>
<tr>
<th></th><th>Distance travelled</th>
</tr>
<tr>
<td width="248px">Motorcycle</td>
<td width="200px"><?php echo form_input_text($data,'mbike_miles',100); ?>&nbsp;miles</td>
</tr>
<tr>
<td>Bus</td>
<td><?php echo form_input_text($data,'bus_miles',100); ?>&nbsp;miles</td>
</tr>
<tr>
<td>Train</td>
<td><?php echo form_input_text($data,'train_miles',100); ?>&nbsp;miles</td>
</tr>
<tr>
<td>Boat</td>
<td><?php echo form_input_text($data,'boat_miles',100); ?>&nbsp;miles</td>
</tr>
<tr>
<td>Plane</td>
<td><?php echo form_input_text($data,'plane_miles',100); ?>&nbsp;miles</td>
</tr>


</table>
<p><b>Note:</b> If you fly or take a boat less than once a year, <br/>please give a 5 year average.</p>


</form> 

