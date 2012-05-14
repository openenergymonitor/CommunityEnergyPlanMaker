<?php
// no direct access
defined('EMONCMS_EXEC') or die('Restricted access');
?>

<script type="text/javascript" src="../stack_lib/energy_bar.js"></script>
<script type="text/javascript" src="../stack_lib/stacks.js"></script>
<script type="text/javascript" src="../stack_lib/sort.js"></script>

<div style="margin: 0px auto; max-width: 990px; text-align:left; margin-top:20px;">

<div class='widget-container' style="width:590px; height:640px; margin-bottom: 20px; float:left;">
<h2>Energy Stats</h2> 

<br/>
<br/>
<canvas id="energy_bar" width="550px;" height="80"></canvas>
<br/>
<br/> 
<h3>Total annual consumption figures:</h3>

<table cellspacing=30>
<tr style="vertical-align:top;">
<td>
<h2>Electric</h2>

<table cellspacing=5>
<tr><td width=100>Electric: </td><td><?php echo intval($group_data['elec']); ?> kWh</td></tr>
<tr><td>Storage heaters:</td><td><?php echo intval($group_data['eheat']); ?> kWh</td></tr>
<tr><td>Heatpump:</td><td><?php echo intval($group_data['hp']); ?> kWh</td></tr>
</table>

</td><td>

<h2>Heating</h2>

<table cellspacing=5>
<tr><td width=100>Wood:</td><td><?php echo intval($group_data['wlog']); ?> m3</td></tr>
<tr><td>Wood pellet:</td><td><?php echo intval($group_data['wplt']); ?> m3</td></tr>
<tr><td>Oil:</td><td><?php echo intval($group_data['oil']); ?> litres</td></tr>
<tr><td>Mains gas:</td><td><?php echo intval($group_data['mgas']); ?> m3</td></tr>
<tr><td>LPG:</td><td><?php echo intval($group_data['lpg']); ?> litres</td></tr>
<tr><td>Bottled gas:</td><td><?php echo intval($group_data['bgas']); ?> kg</td></tr>
<tr><td>Coal:</td><td><?php echo intval($group_data['coal']); ?> kg</td></tr>
</table>


</td><td>

<h2>Transport</h2>

<table cellspacing=5>
<tr><td width=100>Total miles driven:</td><td><?php echo $group_data['car1']+$group_data['car2']+$group_data['car3']; ?> miles</td></tr>
<tr><td >Electric car:</td><td><?php echo $group_data['ecar']; ?> miles</td></tr>
<tr><td >Motorbike:</td><td><?php echo $group_data['mbike']; ?> miles</td></tr>
<tr><td >Bus:</td><td><?php echo $group_data['bus']; ?> miles</td></tr>
<tr><td >Train:</td><td><?php echo $group_data['train']; ?> miles</td></tr>
<tr><td >Plane:</td><td><?php echo $group_data['plane']; ?> miles</td></tr>
</table>


</td></tr>

</table>
<p><i>The above statistics are based on the data of <?php echo $group_data['no-user']; ?> buildings.</i></p>

</div>

<div class='widget-container' style="width:300px; height:640px; margin-left: 15px; float:left;">
<h2>Energy Stack</h2>
<canvas id="can" width="290px;" height="500"></canvas> 
</div>


<div style="clear:both;"></div>
</div>

<script type="application/javascript">
  var group_data = <?php echo json_encode($group_data); ?>;

  var stacks = [];

  var height =  (group_data['electric']+group_data['heating']+group_data['transport'])/365.0
  stacks[0] = {'name':"Llyn", 'stack':[], 'height':height};
  stacks[0]['stack'][0] = {'kwhd':group_data['electric']/365.0, 'color':4, 'name':"Trydan" };
  stacks[0]['stack'][1] = {'kwhd':group_data['heating']/365.0, 'color':5, 'name':"Gwres" }; 
  stacks[0]['stack'][2] = {'kwhd':group_data['transport']/365.0, 'color':6, 'name':"Clydiant" };

  stacks[1] = {'name':"Cyfartaledd", 'stack':[], 'height':99};
  stacks[1]['stack'][0] = {'kwhd':12, 'color':4, 'name':"Trydan" };
  stacks[1]['stack'][1] = {'kwhd':42, 'color':5, 'name':"Gwres" }; 
  stacks[1]['stack'][2] = {'kwhd':45, 'color':6, 'name':"Clydiant" };

  stacks[2] = {'name':"2030?", 'stack':[], 'height':66};
  stacks[2]['stack'][0] = {'kwhd':12, 'color':4, 'name':"Trydan" };
  stacks[2]['stack'][1] = {'kwhd':32, 'color':5, 'name':"Gwres" }; 
  stacks[2]['stack'][2] = {'kwhd':22, 'color':6, 'name':"Clydiant" };

  stacks = sort_by_stack_height(stacks);
  draw_stacks(stacks,"can",500,500);

  draw_energy_bar("Sustainable Energy","energy_bar",550,80,group_data['suspos']);
</script>


