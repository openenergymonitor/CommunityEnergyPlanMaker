<!---------------------------------------------------------------------------------
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
---------------------------------------------------------------------------------->
<script type="text/javascript" src="../Vis/flot/jquery.js"></script>
<script type="text/javascript" src="../stack/stacks.js"></script>
<script type="text/javascript" src="../stack/draw_energy_stack.js"></script>
<script type="text/javascript" src="../stack/sort.js"></script>
<script type="text/javascript" src="../stack/process_data.js"></script>
<script type="text/javascript" src="../stack/energy_bar.js"></script>

<?php if ($lang == "en") require "group_view_en.php"; ?>

<script type="application/javascript">
  var group_data_in = <?php echo json_encode($group_data); ?>;

  var width = 1400;

  var oil = 0, car = 0, gas = 0, train = 0, green_elec =0;
  var stcks;

  explore_savings(group_data_in);

  var stacks = [];
  var view_id = 1;

   $(function () {
     stacks = sort_by_stack_height(stcks['breakdown'])
     draw_energy_stacks(stacks,"can",width,600);

     $("#comparison1").click(function () {
       stacks = sort_by_stack_height(stcks['greenred'])
       draw_energy_stacks(stacks,"can",width,600);
       view_id = 0;
     });

     $("#comparison2").click(function () {
       stacks = sort_by_stack_height(stcks['breakdown'])
       draw_energy_stacks(stacks,"can",width,600);
       view_id = 1;
     });

     $("#comparison3").click(function () {
       stacks = sort_by_stack_height(stcks['types'])
       draw_energy_stacks(stacks,"can",width,600);
       view_id = 2
     });

     $("#comparison4").click(function () {
       stacks = sort_by_stack_height(stcks['heat'])
       draw_energy_stacks(stacks,"can",width,600);
       view_id = 3
     });


     // ORDER BY BLOCK ID : ---
     $(".order").click(function () {
       var block_id = $(this).attr('value');
       if (view_id==0) stacks = sort_by_block(stcks['greenred'],block_id);
       if (view_id==1) stacks = sort_by_block(stcks['breakdown'],block_id);
       if (view_id==2) stacks = sort_by_block(stcks['types'],block_id);
       if (view_id==3) stacks = sort_by_block(stcks['heat'],block_id);
       draw_energy_stacks(stacks,"can",width,600);
     });

     $("#susen0").click(function () {
       green_elec++;
       if (green_elec>1) green_elec=0;
       explore_savings(group_data_in);
       stacks = sort_by_stack_height(stcks['breakdown'])
       draw_energy_stacks(stacks,"can",width,600);
     });

     $("#susen1").click(function () {
       car++;
       if (car>1) car=0;
       explore_savings(group_data_in);
       stacks = sort_by_stack_height(stcks['breakdown'])
       draw_energy_stacks(stacks,"can",width,600);
     });

     $("#susen2").click(function () {
       oil++; gas++;
       if (oil>1) oil=0;
       if (gas>1) gas=0;
       explore_savings(group_data_in);
       stacks = sort_by_stack_height(stcks['breakdown'])
       draw_energy_stacks(stacks,"can",width,600);
     });

     $("#susen3").click(function () {
       train++;
       if (train>1) train=0;

       explore_savings(group_data_in);
       stacks = sort_by_stack_height(stcks['breakdown'])
       draw_energy_stacks(stacks,"can",width,600);
     });
   });

   function explore_savings(group_data_in)
   {

       var group_data =   eval(JSON.stringify(group_data_in));
  for (i in group_data)
  {

    if (group_data[i]["name"] !="ZCB 2030" && group_data[i]["name"] !="DECC 2008")
    {
      group_data[i]["energy_saving"] = 0;
      if (green_elec == 1) group_data[i]["green_elec"] = "yes";

      if (car==1){
      var ecar_miles = group_data[i]["ecar_miles"];
      if (!ecar_miles) ecar_miles = 0;
        var miles = parseInt(group_data[i]["car1_miles"]);
        if (miles){
          var pcar = get_kwhd(miles,1.29,100);
          var ecar = get_kwhd(miles,0.25,100);
          ecar_miles += miles;
          group_data[i]["energy_saving"] += 365* (pcar-ecar);
          group_data[i]['car1_miles'] = 0;
        }

        var miles = parseInt(group_data[i]["car2_miles"]);
        if (miles){
          var pcar = get_kwhd(miles,1.29,100);
          var ecar = get_kwhd(miles,0.25,100);
          ecar_miles += miles;
          group_data[i]["energy_saving"] += 365* (pcar-ecar);
          group_data[i]['car2_miles'] = 0;
        }

        var miles = parseInt(group_data[i]["car3_miles"]);
        if (miles){
          var pcar = get_kwhd(miles,1.29,100);
          var ecar = get_kwhd(miles,0.25,100);
          ecar_miles += miles;
          group_data[i]["energy_saving"] += 365* (pcar-ecar);
          group_data[i]['car3_miles'] = 0;
        }

        group_data[i]["ecar_miles"] = ecar_miles;
      }

      if (!group_data[i]["hp_tot"]) group_data[i]["hp_tot"] = 0;

      if (oil == 1){
        var oil_kwhd_in = get_kwhd(group_data[i]["oil_L"],10.27,100);
        var oil_kwhd = get_kwhd(group_data[i]["oil_L"],10.27,group_data[i]["oil_eff"]);
        if (oil_kwhd){
          var hp_kwhd = oil_kwhd / 3.0;
          group_data[i]["hp_tot"] = parseInt(group_data[i]["hp_tot"]) + ( 365* hp_kwhd);
          group_data[i]["energy_saving"] += 365* (oil_kwhd_in - hp_kwhd);
          group_data[i]['oil_eff'] = 100; group_data[i]['oil_L'] = 0;
        }
      }

      if (gas == 1){
        var gas_kwhd_in = get_kwhd(group_data[i]["botgas_kg"],13.9,100);
        var gas_kwhd = get_kwhd(group_data[i]["botgas_kg"],13.9,group_data[i]["gas_eff"]);
        if (gas_kwhd){
          var hp_kwhd = gas_kwhd / 3.0;
          group_data[i]["hp_tot"] = parseInt(group_data[i]["hp_tot"]) + ( 365* hp_kwhd);
          group_data[i]["energy_saving"] += 365* (gas_kwhd_in - hp_kwhd);
        group_data[i]['gas_eff'] = 100; group_data[i]['botgas_kg'] = 0;
        }
      }

      if (train == 1){
        var plane = get_kwhd(group_data[i]["plane_miles"],0.68,100);
        var traine = get_kwhd(group_data[i]["plane_miles"],0.096,100);

        group_data[i]["elec_tot"] = parseInt(group_data[i]["elec_tot"]) + ( 365* traine);
        group_data[i]["energy_saving"] += 365* (plane-traine);

        group_data[i]["train_miles"] = group_data[i]["plane_miles"];
        group_data[i]["plane_miles"] = 0;
      }
    }
  }

  stcks = process_stacks(group_data);


  var percentage_sustainable_energy = (100*stcks['group_stats']['sustainable']/(stcks['group_stats']['fossil']+stcks['group_stats']['sustainable'])).toFixed(0);
  $("#percentage_sustainable").html(percentage_sustainable_energy);
  draw_energy_bar("energy_bar",550,80,percentage_sustainable_energy);

  $("#group_wood").html((stcks['group_stats']['wood']/1380).toFixed(2));
  $("#group_elec").html(stcks['group_stats']['elec'].toFixed(0));
  $("#of_wind").html((100*stcks['group_stats']['elec']/720).toFixed(0));
  $("#of_solar").html((stcks['group_stats']['elec']/2.3).toFixed(0)); 
  var stacks = sort_by_stack_height(stcks['stacks_group']);
  draw_energy_stacks(stacks,"groupstacks",290,500);

   }

</script>

