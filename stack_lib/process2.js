/*

This script converts the user entered form data into processed energy data that can then be used for the energy stack visualisations and other energy data analysis.

What is processed energy data?
-------------------------------

We use energy for a lot of different things, and often have specific fuels for these things. A users energy data is a list of these uses or fuels such as electricity, oil, gas, wood, a car.

Each of these energy items has several properties:
- how much of the item that is used: quantity
- the efficiency at which the item is used
- if we measure quantity in the given items units such as m3 of wood or Litres of oil then another property that is important is the conversion to kwh's
- We also store unit cost property for financial conversion
- Whether the energy item is renewable or not
- and the type of energy item it is: electric/transport/heating

Here is how the energy item object is constructed:

energydata[id] = {'name':dname,'quantity':1*quantity,'eff':eff,'kwh':kwh,'unitcost':unitcost,'color':color,'type':type};

the values are entered via the function add_energy_use below.

*/

var energydata = {};

// getUserEnergyData is the main energydata processing function, it is called from: Views/energyaudit/stack_view.php
function getUserEnergyData(data)
{
  var green_elec = 0; if (data["green_elec"] == "yes") green_elec = 1;

  add_energy_use('elec',"Electric",data["elec_tot"],100,1,data["elec_cost"],0.15,green_elec,0);

  add_energy_use('stor',"Storage",data["eheat_tot"],100,1,data["eheat_cost"],0.15,green_elec,1);

  add_energy_use('hp',"Heatpump",data["hp_tot"],100,1,data["hp_cost"],0.15,green_elec,1);

  add_energy_use('ambt',"Ambient",data["hp_tot"]*2,100,1,data["hp_cost"]*2,0.15,1,1);

  add_energy_use('wlog',"Wood",data["wood_m3"],data["wood_eff"],1380,data["wood_cost"],63.5,1,1);

  add_energy_use('wplt',"Wood pellet",data["woodpellet_m3"],data["woodpellet_eff"],4800,data["woodpellet_cost"],240,1,1);

  add_energy_use('oil',"Oil",data["oil_L"],data["oil_eff"],10.27,data["oil_cost"],0.6,0,1);

  add_energy_use('mgas',"Gas",data["mainsgas_m3"],data["mainsgas_eff"],9.8,data["mainsgas_cost"],0.42,0,1);

  add_energy_use('lpg',"Gas",data["lpg_L"],data["lpg_eff"],11.0,data["lpg_cost"],0.5,0,1);

  add_energy_use('bgas',"Gas",data["botgas_kg"],data["botgas_eff"],13.9,data["botgas_cost"],1.8,0,1);

  add_energy_use('coal',"Coal",data["coal_kg"],data["coal_eff"],6.67,data["coal_cost"],0.49,0,1);

  add_energy_use("gheat","Green heat",0,85,1.0,null,0.00,1,1);

  add_energy_use('ecar',"E Car",data["ecar_miles"],100,0.5,null,0.02,green_elec,2);

  add_energy_use('car1',"Car 1",data["car1_miles"],100,1.29,null,0.16,0,2);

  add_energy_use('car2',"Car 2",data["car2_miles"],100,1.29,null,0.16,0,2);

  add_energy_use('car3',"Car 3",data["car3_miles"],100,1.29,null,0.16,0,2);

  add_energy_use('mbike',"Motorbike",data["mbike_miles"],100,1.0,null,0.06,0,2);

  add_energy_use('bus',"Bus",data["bus_miles"],100,0.53,null,0.00,0,2);

  add_energy_use('train',"Train",data["train_miles"],100,0.096,null,0.00,0,2);

  add_energy_use('boat',"Boat",data["boat_miles"],100,1,null,0.00,0,2);

  add_energy_use('plane',"Plane",data["plane_miles"],100,0.69,null,0.00,0,2);

  return energydata;
}

function add_energy_use(id, dname, quantity, eff, kwh, annualcost, unitcost, color, type)
{
  // One of the main things to note here is that if a user enters annual cost but no quantity
  // the quantity is calculated from the annual cost / unit cost.
  // If both quantity and annual cost are given then the default unit cost is overwritten
  // with the unit cost calculated from the entered annual cost and quantity.
  if (annualcost && quantity) unitcost = annualcost / quantity;
  if (!quantity) quantity = annualcost / unitcost;

  // The || symbol sets the variable to the value given (i.e 0) if it is undefined.
  annualcost = annualcost || 0;
  quantity = quantity || 0;
  eff = eff || 100;

  // Add to the energydata object
  energydata[id] = {'name':dname,'quantity':1*quantity,'eff':eff,'kwh':kwh,'unitcost':unitcost,'color':color,'type':type};
}

function getkwh(edata)
{
  var kwh = edata['quantity']*edata['kwh'];
  return kwh;
}

function getkwhd(edata)
{
  var kwhd = (edata['quantity']*edata['kwh'])/365.0;
  return kwhd;
}

function getkwhd_use(edata)
{
  var kwhd = (edata['quantity']*edata['kwh']*(edata['eff']/100.0))/365.0;
  return kwhd;
}

function getkwhd_loss(edata)
{
  var kwhd = (edata['quantity']*edata['kwh']*((100-edata['eff'])/100.0))/365.0;
  if (kwhd<0) kwhd = 0;
  return kwhd;
}

function getAnnualCost(edata)
{
  var cost = (edata['quantity']*edata['unitcost']);
  return cost;
}

function get10yCost(edata)
{
  var cost = (edata['quantity']*edata['unitcost']*10);
  return cost;
}

function get_percentage_sustainability(edata)
{
  var fossil = 0, green = 0;
  for (z in edata) {
    if (edata[z]['color']==0 || edata[z]['color']==2) fossil += getkwh(edata[z]);
    if (edata[z]['color']==1 || edata[z]['color']==3) green += getkwh(edata[z]);
  }
  return parseInt(100*green / (green+fossil));
}

