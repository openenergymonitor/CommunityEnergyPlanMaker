  <!----
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  ----->

<script type="text/javascript" src="../Vis/flot/jquery.js"></script>
<script type="text/javascript" src="../stack/draw_energy_stack.js"></script>
<script type="text/javascript" src="../stack/stacks.js"></script>
<script type="text/javascript" src="../stack/sort.js"></script>
<script type="text/javascript" src="../stack/process_data.js"></script>

<?php global $path; ?>

<h2>Energy stack</h2>
<input id="comparison1" type="button" value="GreenRed" />
<input id="comparison2" type="button" value="Breakdown" />
<input id="comparison3" type="button" value="Types" />
<input id="comparison4" type="button" value="Heat" />

<canvas id="can" width="300" height="500"></canvas>

<script type="application/javascript">
var path = "<?php echo $path; ?>";
var apikey_write = "<?php echo $apikey_write; ?>";
var group_data = <?php echo json_encode($group_data); ?>;

if (group_data[0].length == 0)  group_data[0] = {};

var stacks = [];
var type = 'breakdown';

var stcks = process_stacks(group_data);
stacks = sort_by_stack_height(stcks[type]);
draw_energy_stacks(stacks,"can",300,500);
  $("#save_label").html("Saved");
$(".inp01").keyup(function(){
  $("#save_label").html("");
  group_data[0][$(this).attr("name")] = $(this).val();

  stcks = process_stacks(group_data);
  stacks = sort_by_stack_height(stcks[type]);
  draw_energy_stacks(stacks,"can",300,500);
});

$(".inpsel").click(function(){
  $("#save_label").html("");
  group_data[0][$(this).attr("name")] = $(this).val();

  stcks = process_stacks(group_data);
  stacks = sort_by_stack_height(stcks[type]);
  draw_energy_stacks(stacks,"can",300,500);

  
});

$(".checksel").click(function(){
  $("#save_label").html("");
  group_data[0][$(this).attr("name")] = $(this).attr('checked');

  stcks = process_stacks(group_data);
  stacks = sort_by_stack_height(stcks[type]);
  draw_energy_stacks(stacks,"can",300,500);
});

$(".top_menu2").click(function(){
  $("#save_label").html("Saved");
  $.ajax({                                      
    type: "POST",
    url: path+"energyaudit/save.json?apikey="+apikey_write,           
    data: "&data="+JSON.stringify(group_data[0]),
    dataType: 'json',   
    success: function() {}
  });
});

$(".button05").click(function(){
  $("#save_label").html("Saved");
  $.ajax({                                      
    type: "POST",
    url: path+"energyaudit/save.json?apikey="+apikey_write,           
    data: "&data="+JSON.stringify(group_data[0]),
    dataType: 'json',   
    success: function() {}
  });
});

     $("#comparison1").click(function () {
       type = 'greenred';
       stacks = sort_by_stack_height(stcks[type])
       draw_energy_stacks(stacks,"can",300,500);
     });

     $("#comparison2").click(function () {
       type = 'breakdown';
       stacks = sort_by_stack_height(stcks[type])
       draw_energy_stacks(stacks,"can",300,500);
     });

     $("#comparison3").click(function () {
       type = 'types';
       stacks = sort_by_stack_height(stcks[type])
       draw_energy_stacks(stacks,"can",300,500);
     });

     $("#comparison4").click(function () {
       type = 'heat';
       stacks = sort_by_stack_height(stcks[type])
       draw_energy_stacks(stacks,"can",300,500);
     });




</script>
