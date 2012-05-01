<!--
   All Emoncms code is released under the GNU General Public License v3.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
-->

<form name="input" action="" method="post">

<h2>Home context</h2>
<!---------------------------------------------------------------------------------
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
---------------------------------------------------------------------------------->
<table>
<tr><td width="320px">How many people live at your address?</td><td><?php echo form_input_text($data,'occupancy',100); ?></td></tr>
</table>
<p><b>House dimentions:</b></p>
<table>
<tr><td>Width</td><td style="width:140px"><?php echo form_input_text($data,'house_width',80); ?> m</td><td>Length</td><td style="width:140px"><?php echo form_input_text($data,'house_length',80); ?> m</td><td>Number of floors</td><td><?php echo form_input_text($data,'house_floors',50); ?></td></tr>
</table><br/>
<table>
<tr><td>What type of house do you have?</td><td>
<?php echo form_input_select($data,"house_type"," |Flat|Detached|Semi detached|Mid terrace|End terrace"); ?></td></tr>

<tr><td>When was the largest part of your house built?</td><td>
<?php echo form_input_select($data,"house_date"," |Before 1900|1900-1929|1930-1949|1950-1965|1966-1976|1977-1981|1982-1990|1991-1995|1996 or later"); ?></td></tr>

<tr><td><label>What is the construction of your house?</label></td><td>
<?php echo form_input_select($data,"house_construction"," |Stone|Uninsulated cavity|Timber frame|Insulated cavity|Other"); ?></td></tr>

</table>
<br/><hr/>
<div>
<table>
<th width="130px"></th><th width="140px">Thickness</th><th>Type</th>
<tr><td>Wall insulation</td><td><?php echo form_input_text($data,'wall_ins_w',65); ?> mm </td><td><?php echo form_input_text($data,'wall_ins_type',90); ?></td></tr>
<tr><td>Roof insulation</td><td><?php echo form_input_text($data,'roof_ins_w',65); ?> mm </td><td><?php echo form_input_text($data,'roof_ins_type',90); ?></td></tr>
<tr><td>Floor insulation</td><td><?php echo form_input_text($data,'floor_ins_w',65); ?> mm </td><td><?php echo form_input_text($data,'floor_ins_type',90); ?></td></tr>
</table>
</div><br/><hr/>
<div>
<table>
<tr><td width="250px">How draughty is your house?</td><td>
<?php echo form_input_select($data,"draughts"," |it isnt|a little|middle|very"); ?></td></tr>

<tr><td><br/>What type of galzing do you have?</td><td><br/>
<?php echo form_input_select($data,"glz_type"," |single|double|triple|secondary"); ?></td></tr>

<tr><td><br/>
How much solar gain do you have? do you have large south facing windows?</td><td><br/>
<?php echo form_input_text($data,'solargain',120); ?></td></tr>

<tr><td><br/>
How warm do you keep your house, do you know your indoor temperature?</td><td><br/>
<?php echo form_input_text($data,'temperature',120); ?> C</td></tr>

</table>
</div>
<br/><br/>
<div class='button05' style="line-height:30px; width:160px;"><a href="../energyaudit/finish">Finish</a></div>

