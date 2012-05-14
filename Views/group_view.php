<!---------------------------------------------------------------------------------
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
---------------------------------------------------------------------------------->
<script type="text/javascript" src="../Vis/flot/jquery.js"></script>
<script type="text/javascript" src="../stack_lib/stacks.js"></script>
<script type="text/javascript" src="../stack_lib/sort.js"></script>
<script type="text/javascript" src="../stack_lib/process2.js"></script>
<script type="text/javascript" src="../stack_lib/energy_bar.js"></script>

<?php if ($lang == "en") require "group_view_en.php"; ?>

<script type="application/javascript">
  var group_data_in = <?php echo json_encode($group_data); ?>;
  var group_data = {};


  var green_elec = 0;
  var green_heat = 0;
  var green_transport = 0;
  var green_transport2 = 0; 

  explore_energy_plan();
  big_stack_comparison();
  process_and_output_totals();

     $("#susen0").click(function () {
       green_elec++;
       if (green_elec>1) green_elec=0;
       explore_energy_plan();
       big_stack_comparison();
       process_and_output_totals();
     });

     $("#susen1").click(function () {
       green_transport++;
       if (green_transport>1) green_transport=0;
       explore_energy_plan();
       big_stack_comparison();
       process_and_output_totals();
     });

     $("#susen2").click(function () {
       green_heat++;
       if (green_heat>1) green_heat=0;
       explore_energy_plan();
       big_stack_comparison();
       process_and_output_totals();
     });

     $("#susen3").click(function () {
       green_transport2++;
       if (green_transport2>1) green_transport2=0;
       explore_energy_plan();
       big_stack_comparison();
       process_and_output_totals();
     });

  /*

  explore_energy_plan handles how the sustainable energy plan explorer.

  */ 

  function explore_energy_plan()
  {

     group_data =   eval(JSON.stringify(group_data_in));

  for (n in group_data) 
  {
    var user = group_data[n];
    for (z in user) {
      if (green_elec == 1) {
        // Power electric, storage heaters or heatpump from green electricity 
        if (user[z]['type']==0) user[z]['color'] = 1;
      }

      if (green_heat == 1) {
        // Covert all ffossil fuel heating over to green heating
        if (user[z]['type']==1 && user[z]['color']==0)
        {
          var demand = user[z]['quantity']*user[z]['kwh']*(user[z]['eff']/100.0);
          var new_energy_input = (demand/(user['gheat']['eff']/100));
          user['gheat']['quantity'] += new_energy_input;
          user[z]['quantity'] = 0;
        }
      }
    }

    if (green_transport == 1) {
      user['ecar']['color'] = 1;


      user['ecar']['quantity'] += 1*user['car1']['quantity']; user['car1']['quantity'] = 0;
      user['ecar']['quantity'] += 1*user['car2']['quantity']; user['car2']['quantity'] = 0;
      user['ecar']['quantity'] += 1*user['car3']['quantity']; user['car3']['quantity'] = 0;
      user['ecar']['quantity'] += 1*user['mbike']['quantity']; user['mbike']['quantity'] = 0;
    }


    if (green_transport2 == 1) {
      user['train']['color'] = 1;
      user['train']['quantity'] += 1*user['bus']['quantity']; user['bus']['quantity'] = 0;
      user['train']['quantity'] += 1*user['boat']['quantity']; user['boat']['quantity'] = 0;
      user['train']['quantity'] += 1*user['plane']['quantity']; user['plane']['quantity'] = 0;
    }
  }

  }

  /*

  In the first part here we process the group data into stack data for the 'inidividual contributions' visualisation.
  For every user in group_data we generate an energy stack and add that energy stack to the energy stacks array.

  We also add the reference stags national average and target and sort from highest to lowest, left to right.

  */ 

  function big_stack_comparison()
  {

  var stacks = [];
  var sn = 0;

  for (n in group_data)
  {
    var user = group_data[n];

    var total = 0, i = 0;
    stacks[sn] = {'name':(sn+1), 'stack':[]};
    for (z in user) {
      var kwhd = getkwhd_use(user[z]);
      stacks[sn]['stack'][i] = {'kwhd':kwhd,'color':user[z]['color'],'name':user[z]['name']}; 
      total += kwhd; i++;
    }
    for (z in user) {
      var kwhd = getkwhd_loss(user[z]);
      stacks[sn]['stack'][i] = {'kwhd':kwhd, 'color':user[z]['color']+2, 'name':"loss"}; 
      total += kwhd; i++;
    }
    stacks[sn]['height'] = total;
    sn++;
  }

  stacks[sn] = {'name':"Average", 'stack':[], 'height':103};
  stacks[sn]['stack'][0] = {'kwhd':9, 'color':0, 'name':"Electric" };
  stacks[sn]['stack'][1] = {'kwhd':45, 'color':0, 'name':"Heating" }; 
  stacks[sn]['stack'][2] = {'kwhd':46, 'color':0, 'name':"Transport" };
  sn++;

  stacks[sn] = {'name':"2030?", 'stack':[], 'height':56};
  stacks[sn]['stack'][0] = {'kwhd':9, 'color':1, 'name':"Electric" };
  stacks[sn]['stack'][1] = {'kwhd':32, 'color':1, 'name':"Heating" }; 
  stacks[sn]['stack'][2] = {'kwhd':12, 'color':1, 'name':"Transport" };

  stacks = sort_by_stack_height(stacks);
  draw_stacks(stacks,"can",1400,600);

  }

  /*

  In the second part here we aggregate the groups energy data into totals, such as total electricity use or total percentage 
  sustainability of the group.

  We also create an energy stack comparison for the group as a whole.

  */ 

  function process_and_output_totals()
  {

  var totals = [];
  var fossil = 0, green = 0, electric = 0, heating = 0, transport = 0, i = 0;

  totals['wlog'] = 0;
 
  for (n in group_data) 
  {
    var user = group_data[n];
    for (z in user) {

      if (user[z]['color']==0) fossil += getkwh(user[z]);
      if (user[z]['color']==1) green += getkwh(user[z]);

      if (user[z]['type']==0) electric += getkwh(user[z]);
      if (user[z]['type']==1) heating += getkwh(user[z]);
      if (user[z]['type']==2) transport += getkwh(user[z]);

      totals[z] += user[z]['quantity'];
    }
    i++;
  }

  totals['electric'] = electric/i;
  totals['heating'] = heating/i;
  totals['transport'] = transport/i;
  totals['no-user'] = i;

  totals['suspos'] = Math.round(100*green / (green+fossil));

  draw_energy_bar("Sustainable Energy","energy_bar",550,80,totals['suspos']);

  $("#percentage_sustainable").html(totals['suspos']);
  $("#group_wood").html((1*totals['wlog']/365.0).toFixed(3));
  $("#group_elec").html((1*electric/365.0).toFixed(0));
  $("#of_wind").html((100*(electric/365)/720).toFixed(0));
  $("#of_solar").html((electric/365*2.3).toFixed(0)); 

  var stacks = [];

  var height =  (totals['electric']+totals['heating']+totals['transport'])/365.0
  stacks[0] = {'name':"Group", 'stack':[], 'height':height};
  stacks[0]['stack'][0] = {'kwhd':totals['electric']/365.0, 'color':4, 'name':"Electric" };
  stacks[0]['stack'][1] = {'kwhd':totals['heating']/365.0, 'color':5, 'name':"Heating" }; 
  stacks[0]['stack'][2] = {'kwhd':totals['transport']/365.0, 'color':6, 'name':"Transport" };

  stacks[1] = {'name':"Average", 'stack':[], 'height':103};
  stacks[1]['stack'][0] = {'kwhd':12, 'color':4, 'name':"Electric" };
  stacks[1]['stack'][1] = {'kwhd':45, 'color':5, 'name':"Heating" }; 
  stacks[1]['stack'][2] = {'kwhd':46, 'color':6, 'name':"Transport" };

  stacks[2] = {'name':"2030?", 'stack':[], 'height':56};
  stacks[2]['stack'][0] = {'kwhd':12, 'color':4, 'name':"Electric" };
  stacks[2]['stack'][1] = {'kwhd':32, 'color':5, 'name':"Heating" }; 
  stacks[2]['stack'][2] = {'kwhd':12, 'color':6, 'name':"Transport" };

  stacks = sort_by_stack_height(stacks);
  draw_stacks(stacks,"groupstacks",290,500);

  }

</script>

