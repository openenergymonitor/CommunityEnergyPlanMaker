  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */

function draw_user_stack_view(group_data)
{
  var stcks = process_stacks(group_data);

  // Sort by stack height and draw
  var stacks = [];
  stacks = sort_by_stack_height(stcks['breakdown']);
  draw_energy_stacks(stacks,"can",300,500);
}

function process_stacks(group_data){

  var ig = 0;
  var stacks_group = [];

  var stacks_breakdown = [];
  var stacks_greenred = [];
  var stacks_types = [];
  var stacks_heat = [];

  var group_sustainable = 0;
  var group_fossil = 0;
  var group_saving = 0;

  var group_wood = 0;
  var group_electricity = 0;

  var nhouse = 0;

  for (i in group_data)
  {
    var stack = generate_stack(group_data[i]);

    var stack_types = [];
    var stack_heat = [];
    var stack_greenred = [];
       
    // Reset variables
    var total = 0; 
    var electric = 0, transport = 0, heating = 0;
    var heat_green = 0, heat_red = 0, heat_loss = 0;
    var red = 0, green = 0;

    var total = 0; 
    for (key in stack)
    {
      var s = stack[key];
      // Get values for greenred stack
      if (i != 0 && i != 1){ 
        if (s['color']==0 || s['color']==2) group_fossil+= s['kwhd'];
        if (s['color']==1 || s['color']==3) group_sustainable+= s['kwhd'];
        if (s['color']==7) group_saving+= s['kwhd'];
      }

      if (s['color']==0 || s['color']==2) red += s['kwhd'];
      if (s['color']==1 || s['color']==3) green += s['kwhd'];

      // Get values for types stack
      if (s['type']==0) electric += s['kwhd'];
      if (s['type']==1) heating += s['kwhd'];
      if (s['type']==2) transport += s['kwhd'];

      // Get values for heat stack
      if (s['type']==1 && s['color']==0) heat_red += s['kwhd'];
      if (s['type']==1 && s['color']==1) heat_green += s['kwhd'];
      if (s['type']==1 && s['color']==2) heat_loss += s['kwhd'];
      if (s['type']==1 && s['color']==3) heat_loss += s['kwhd'];

      if (key == 6) group_wood+=s['kwhd'];
      if ((key == 0 || key == 1 || key == 2 || key == 13) && s['color']==1) group_electricity+=s['kwhd'];

      total += s['kwhd'];
    }
    if (total>0){ 

    stacks_breakdown[nhouse] = {"name":group_data[i]['name'],"stack":stack,"height":total};	// Add user Stack
   
    if (i == 0 || i == 1) {stacks_group[ig] = {"name":group_data[i]['name'],"stack":stack,"height":total}; ig++;}	// Add user Stack

    //-------------------------------------------------------------------------------
    // Generate greenred stack
    //-------------------------------------------------------------------------------
    stack_greenred[0] = add_block("Sustainable",green,		1,	0	);
    stack_greenred[1] = add_block("Fossil",	red,		0,	0	);
    stacks_greenred[nhouse] = {'name':group_data[i]['name'],'stack':stack_greenred,'height':green+red};

    //-------------------------------------------------------------------------------
    // Generate electric/transport/heating stack
    //-------------------------------------------------------------------------------
    stack_types[0] = add_block("Electric",	electric,	4,	0	);
    stack_types[1] = add_block("Heating",	heating,	5,	0	);
    stack_types[2] = add_block("Transport",	transport,	6,	0	);
    stacks_types[nhouse] = {'name':group_data[i]['name'],'stack':stack_types,'height':electric+heating+transport};
       
    //-------------------------------------------------------------------------------
    // Generate heat stack
    //-------------------------------------------------------------------------------
    stack_heat[0] = add_block("Renewable",heat_green,		1,	0	);
    stack_heat[1] = add_block("Fossil",	heat_red,		0,	0	);
    stack_heat[2] = add_block("Loss",	heat_loss,		2,	0	);
    stacks_heat[nhouse] = {'name':group_data[i]['name'],'stack':stack_heat,'height':heat_green+heat_red+heat_loss};

    nhouse++;
    }
  }

  //------------------------------------------------------------------------------------
  // Calculation of group stats
  //------------------------------------------------------------------------------------
  var group_stats = {'sustainable':group_sustainable, 'fossil':group_fossil, 'wood':group_wood,'elec':group_electricity};
  var stack = [];
  stack[0] = add_block(		"Sustainable"	,group_sustainable/(nhouse-2),1	,0	);
  stack[1] = add_block(		"Fossil"	,group_fossil/(nhouse-2),0	,0	);
  stack[2] = add_block(		"Saving"	,group_saving/(nhouse-2),7	,4	);
  stacks_group[ig] = {"name":"Group","stack":stack,"height":(group_sustainable+group_fossil)/(nhouse-2)};

  return {'breakdown':stacks_breakdown,'greenred':stacks_greenred,'types':stacks_types,'heat':stacks_heat,'group_stats':group_stats,'stacks_group':stacks_group};
}


function generate_stack(data)
{
  var stack = [];
  var green_elec = 0; if (data["green_elec"] == "yes") green_elec = 1;
  //----------------------------------------------------------------------------------------------
  // Energy Stack data array - holds all energy stack data
  //----------------------------------------------------------------------------------------------
  //                              	Name		Units	Conv	kWh/d	color	type	--
  stack[0] = add_block(		"Electric"	,get_kwhd(data["elec_tot"]	,1	,100)	,green_elec	,0	);
  stack[1] = add_block(		"Storage"	,get_kwhd(data["eheat_tot"]	,1	,100)	,green_elec	,1	);
  stack[2] = add_block(		"Heatpump"	,get_kwhd(data["hp_tot"]	,1	,100)	,green_elec	,1	);
  //stack[3] = add_block(	"Solar"		,get_kwhd(data["spv_tot"]	,1	,1)	,1	,3	);
  //stack[4] = add_block(	"Hydro"		,get_kwhd(data["hydro_tot"]	,1	,1)	,1	,3	);
  //stack[5] = add_block(	"Wind"		,get_kwhd(data["wind_tot"]	,1	,1)	,1	,3	);

  stack[6] = add_block(		"Wood"		,get_kwhd(data["wood_m3"]	,1380	,data["wood_eff"]	)	,1	,1	);
  stack[7] = add_block(		"Wood"		,get_kwhd(data["woodpellet_m3"]	,4800	,data["woodpellet_eff"]	)	,1	,1	);
  stack[8] = add_block(		"Oil"		,get_kwhd(data["oil_L"]		,10.27	,data["oil_eff"]	)	,0	,1	);
  stack[9] = add_block(		"Gas"		,get_kwhd(data["mainsgas_m3"]	,9.8	,data["gas_eff"]	)	,0	,1	);
  stack[10] = add_block(	"Gas"		,get_kwhd(data["lpg_L"]		,11.00	,data["gas_eff"]	)	,0	,1	);
  stack[11] = add_block(	"Gas"		,get_kwhd(data["botgas_kg"]	,13.9	,data["gas_eff"]	)	,0	,1	);
  stack[12] = add_block(	"Coal"		,get_kwhd(data["coal_kg"]	,6.67	,data["coal_eff"]	)	,0	,1	);

  stack[13] = add_block(	"E Car"		,get_kwhd(data["ecar_miles"]	,0.25	,100)	,green_elec	,2	);

  stack[14] = add_block(	"Car 1"		,get_kwhd(data["car1_miles"]	,1.29	,100)	,0	,2	);
  stack[15] = add_block(	"Car 2"		,get_kwhd(data["car2_miles"]	,1.29	,100)	,0	,2	);
  stack[16] = add_block(	"Car 3"		,get_kwhd(data["car3_miles"]	,1.29	,100)	,0	,2	);

  stack[17] = add_block(	"Motorbike"	,get_kwhd(data["mbike_miles"]	,1	,100)	,0	,2	);
  stack[18] = add_block(	"Bus"		,get_kwhd(data["bus_miles"]	,0.53	,100)	,0	,2	);
  stack[19] = add_block(	"Train"		,get_kwhd(data["train_miles"]	,0.096	,100)	,0	,2	);
  stack[20] = add_block(	"Boat"		,get_kwhd(data["boat_miles"]	,1	,100)	,0	,2	);
  stack[21] = add_block(	"Plane"		,get_kwhd(data["plane_miles"]	,0.68	,100)	,0	,2	);

  // HEATING LOSS
  stack[22] = add_block(	"Wood loss"		,get_kwhd_loss(data["wood_m3"]		,1380	,data["wood_eff"])	,3	,1	);
  stack[23] = add_block(	"Wood loss"		,get_kwhd_loss(data["woodpellet_m3"]	,4800	,data["woodpellet_eff"]),3	,1	);
  stack[24] = add_block(	"Oil loss"		,get_kwhd_loss(data["oil_L"]		,10.27	,data["oil_eff"])	,2	,1	);
  stack[25] = add_block(	"Gas loss"		,get_kwhd_loss(data["mainsgas_m3"]	,9.8	,data["gas_eff"])	,2	,1	);
  stack[26] = add_block(	"Gas loss"		,get_kwhd_loss(data["lpg_L"]		,11.00	,data["gas_eff"])	,2	,1	);
  stack[27] = add_block(	"Gas loss"		,get_kwhd_loss(data["botgas_kg"]	,13.9	,data["gas_eff"])	,2	,1	);
  stack[28] = add_block(	"Coal loss"		,get_kwhd_loss(data["coal_kg"]		,6.67	,data["coal_eff"])	,2	,1	);
  stack[29] = add_block(	"Saving"		,get_kwhd(data["energy_saving"]		,1	,100)	,7	,4	);
  //----------------------------------------------------------------------------------------------
  return stack;
}

function get_kwhd(qty,conv,eff)
{ 
  if (!qty) qty = 0; 
  if (!eff) eff = 100;
  return (((eff/100.0)*(qty * conv))/365.0); 
}

function get_kwhd_loss(qty,conv,eff)
{ 
  if (!qty) qty = 0; 
  if (!eff) eff = 100;
  return ((((100-eff)/100.0)*(qty * conv))/365.0); 
}

function add_block(iname,kwhd,color,type)
{
  return {"name":iname,"kwhd":kwhd,"color":color,"type":type}
}
