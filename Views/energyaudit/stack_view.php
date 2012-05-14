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

<script type="text/javascript" src="../Vis/flot/jquery.js"></script>
<script type="text/javascript" src="../stack_lib/process2.js"></script>
<script type="text/javascript" src="../stack_lib/stacks.js"></script>
<script type="text/javascript" src="../stack_lib/sort.js"></script>

<?php global $path; ?>

<h2>Energy Stacks</h2>

<canvas id="can" width="300" height="500"></canvas> 

<script type="application/javascript">
  var path = "<?php echo $path; ?>";
  var apikey_write = "<?php echo $apikey_write; ?>";
  var data = <?php echo json_encode($data); ?>;
  var dataToSave = {};

  var stacks = [];

  var energydata;

 // setInterval(savedata,30000);

  if (data.length == 0) data = {};

//----------------------------------------------------------------------------
// Function converts group data into energy stacks
//----------------------------------------------------------------------------
function prepare_stacks(){
    energydata = getUserEnergyData(data);

    var total = 0, i = 0;
    stacks[0] = {'name':"Your house", 'stack':[]};
    for (z in energydata) {
      stacks[0]['stack'][i] = {	'kwhd':getkwhd_use(energydata[z]),'color':energydata[z]['color'],'name':energydata[z]['name']}; 
      total += getkwhd_use(energydata[z]); i++;
    }
    for (z in energydata) {
      stacks[0]['stack'][i] = {'kwhd':getkwhd_loss(energydata[z]), 'color':energydata[z]['color']+2, 'name':"loss"}; 
      total += getkwhd_loss(energydata[z]); i++;
    }
    stacks[0]['height'] = total;

  stacks[1] = {'name':"Average", 'stack':[], 'height':99};
  stacks[1]['stack'][0] = {'kwhd':9, 'color':0, 'name':"Electric" };
  stacks[1]['stack'][1] = {'kwhd':45, 'color':0, 'name':"Heating" }; 
  stacks[1]['stack'][2] = {'kwhd':46, 'color':0, 'name':"Transport" };

  stacks[2] = {'name':"2030?", 'stack':[], 'height':66};
  stacks[2]['stack'][0] = {'kwhd':9, 'color':1, 'name':"Electric" };
  stacks[2]['stack'][1] = {'kwhd':32, 'color':1, 'name':"Heating" }; 
  stacks[2]['stack'][2] = {'kwhd':12, 'color':1, 'name':"Transport" };
}

//----------------------------------------------------------------------------

prepare_stacks();
stacks = sort_by_stack_height(stacks);
draw_stacks(stacks,"can",500,500);


  $("#save_label").html("Saved");
$(".inp01").keyup(function(){
  $("#save_label").html("");
  data[$(this).attr("name")] = $(this).val();
  dataToSave[$(this).attr("name")] = $(this).val();

  prepare_stacks();
  stacks = sort_by_stack_height(stacks);
  draw_stacks(stacks,"can",500,500);
});

$(".inpsel").click(function(){
  $("#save_label").html("");
  data[$(this).attr("name")] = $(this).val();
  dataToSave[$(this).attr("name")] = $(this).val();

  prepare_stacks();
  stacks = sort_by_stack_height(stacks);
  draw_stacks(stacks,"can",500,500);
});

$(".checksel").click(function(){
  $("#save_label").html("");
  data[$(this).attr("name")] = $(this).attr('checked');
  dataToSave[$(this).attr("name")] = $(this).attr('checked');

  prepare_stacks();
  stacks = sort_by_stack_height(stacks);
  draw_stacks(stacks,"can",500,500);
});

$(".top_menu2").click(function(){
 // savedata();
});

$(".button05").click(function(){
  savedata();
});

function savedata()
{
  $.ajax({                                      
    type: "POST",
    url: path+"energyaudit/save.json?apikey="+apikey_write,           
    data: "&data="+encodeURIComponent(JSON.stringify(dataToSave)),
    success: function(msg) {if (msg=="saving") $("#save_label").html("Saved"); 

  dataToSave = {};

  $.ajax({                                      
    type: "POST",
    url: path+"energydata/save.json?apikey="+apikey_write,           
    data: "&data="+JSON.stringify(energydata),
    success: function(msg) {console.log(msg);}
  });

    }
  });


}

</script>
