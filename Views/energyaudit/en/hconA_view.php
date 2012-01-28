<!---------------------------------------------------------------------------------
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
---------------------------------------------------------------------------------->

<form name="input" action="" method="post">
<h2>Heating (non-electric) context</h2>
<p><span style="font-size:12px" ><i>The following questions are generated in accordance with your answers to heating part A and are to understand your heating context.</i></span></p>
<!------------------------------------------------------------------------------------------------------------------------->
<?php if ($data['wood_m3']>0) { ?>
<h3>Wood heating</h2>
<table>
<tr>
  <td width="280px">Do you burn your wood in an open fire, woodstove, range or log batch boiler? Please list and give models if applicable.</td>
  <td><?php echo form_input_textarea2($data,"wood_context",2,21); ?></td>
</tr>
<tr>
  <td width="280px">Estimate of burn efficiency:</td>
  <td><?php echo form_input_text($data,'wood_eff',70); ?> % <span style="font-size:12px" ><i> ..leave blank if unsure</i></span></td>
</tr>
</table>
Do you use wood for:&nbsp;&nbsp;
Cooking?<?php echo checkbox($data,'wood_ch') ?>&nbsp;&nbsp;
Water heating?<?php echo checkbox($data,'wood_wh') ?>&nbsp;&nbsp;
Space heating<?php echo checkbox($data,'wood_sh') ?>
<?php } ?>

<!------------------------------------------------------------------------------------------------------------------------->
<?php if ($data['woodpellet_m3']>0) { ?>
<h3>Wood pellet heating</h2>
<table>
<tr>
  <td width="280px">Please give the model of your wood pellet boiler:</td>
  <td><?php echo form_input_textarea2($data,"woodpellet_context",2,21); ?></td>
</tr>
<tr>
  <td width="280px">Estimate of burn efficiency:</td>
  <td><?php echo form_input_text($data,'woodpellet_eff',70); ?> % <span style="font-size:12px" ><i> ..leave blank if unsure</i></span></td>
</tr>
</table>
Do you use woodpellets for:&nbsp;&nbsp;
Cooking?<?php echo checkbox($data,'woodpellet_ch') ?>&nbsp;&nbsp;
Water heating?<?php echo checkbox($data,'woodpellet_wh') ?>&nbsp;&nbsp;
Space heating<?php echo checkbox($data,'woodpellet_sh') ?>
<?php } ?>

<!------------------------------------------------------------------------------------------------------------------------->
<?php if ($data['oil_L']>0) { ?>
<h3>Oil heating</h2>
<table>
<tr>
  <td width="280px">Do you burn oil in an oil boiler or range cooker? Please give model if applicable:</td>
  <td><?php echo form_input_textarea2($data,"oil_context",2,21); ?></td>
</tr>
<tr>
  <td width="280px">Estimate of burn efficiency:</td>
  <td><?php echo form_input_text($data,'oil_eff',70); ?> % <span style="font-size:12px" ><i> ..leave blank if unsure</i></span></td>
</tr>
</table>
Do you use oil for:&nbsp;&nbsp;
Cooking?<?php echo checkbox($data,'oil_ch') ?>&nbsp;&nbsp;
Water heating?<?php echo checkbox($data,'oil_wh') ?>&nbsp;&nbsp;
Space heating<?php echo checkbox($data,'oil_sh') ?>
<?php } ?>

<!------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------->
<?php if ( $data['mainsgas_m3']>0 || $data['lpg_L']>0 || $data['botgas_kg']>0) { ?>
<h3>Gas heating</h2>
<table>
<tr>
  <td width="280px">If applicable please give model of gas stove or/and gas boiler:</td>
  <td><?php echo form_input_textarea2($data,"gas_context",2,21); ?></td>
</tr>
<tr>
  <td width="280px">Estimate of burn efficiency:</td>
  <td><?php echo form_input_text($data,'gas_eff',70); ?> % <span style="font-size:12px" ><i> ..leave blank if unsure</i></span></td>
</tr>
</table>
Do you use gas for:&nbsp;&nbsp;
Cooking?<?php echo checkbox($data,'gas_ch') ?>&nbsp;&nbsp;
Water heating?<?php echo checkbox($data,'gas_wh') ?>&nbsp;&nbsp;
Space heating<?php echo checkbox($data,'gas_sh') ?>

<?php } ?>

<!------------------------------------------------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------------------------------------------------->
<?php if ( $data['coal_kg']>0) { ?>
<h3>Coal heating</h2>
<table>
<tr>
  <td width="280px">Do you burn your coal in an open fire, stove, range? Please give model if applicable:</td>
  <td><?php echo form_input_textarea2($data,"coal_context",2,21); ?></td>
</tr>
<tr>
  <td width="280px">Estimate of burn efficiency:</td>
  <td><?php echo form_input_text($data,'coal_eff',70); ?> % <span style="font-size:12px" ><i> ..leave blank if unsure</i></span></td>
</tr>
</table>
Do you use coal for:&nbsp;&nbsp;
Cooking?<?php echo checkbox($data,'coal_ch') ?>&nbsp;&nbsp;
Water heating?<?php echo checkbox($data,'coal_wh') ?>&nbsp;&nbsp;
Space heating<?php echo checkbox($data,'coal_sh') ?>
<?php } ?>

<!------------------------------------------------------------------------------------------------------------------------->
<p><b>Note:</b> Feel free to mention any other relevant detail in the boxes above, if you use several of any appliance please list and please state how often each appliance is used.</p>
