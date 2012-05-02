<?php
  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */

  function set_energyaudit_data($userid,$data)
  {
    while($key = key($data)) 
    {
      $key = preg_replace('/[^\w\s-.?]/','',$key);	// filter out all except for alphanumeric white space and dash and full stop
      $val = preg_replace('/[^\w\s-.?]/','',$data->$key);	// filter out all except for alphanumeric white space and dash and full stop
      set_form_entry($userid,$key,$val);
      next($data);
    }
  }

  function set_form_entry($userid,$key,$value)
  {
    $result = db_query("SELECT * FROM energyaudit WHERE `userid` = '$userid' AND `key`='$key'");

    if (db_num_rows($result)==0){
      //echo "creating new entry: ".$userid." ".$key." ".$value;
      db_query("INSERT INTO energyaudit (`userid`,`key`,`value`) VALUES ('$userid','$key','$value')");
    }
    else
    {
      //echo "updating entry: ".$userid." ".$key." ".$value;
      db_query("UPDATE energyaudit SET `value` = '$value' WHERE `userid` = '$userid' AND `key`='$key'");
    }
  }

  function get_energyaudit_data($userid)
  {
    $result = db_query("SELECT * FROM energyaudit WHERE `userid` = '$userid'"); 

    $data = array();
    while ($row = db_fetch_array($result))
    {
      $key = $row['key'];
      $value = $row['value'];
      $data[$key] = $value;
    }
    $data['name'] = get_user_name($userid); //$data['name'];
    return $data;
  }

  function get_energyaudit_data_energy($userid)
  {
    $result = db_query("SELECT * FROM energyaudit WHERE `userid` = '$userid'"); 

    $data = array();
    while ($row = db_fetch_array($result))
    {
      $key = $row['key'];
      $value = $row['value'];
      $data[$key] = $value;
    }
    $data_energy['green_elec'] = $data['green_elec'];
    $data_energy['name'] = get_user_name($userid); //$data['name'];
    $data_energy['elec_tot'] = $data['elec_tot'];
    $data_energy['eheat_tot'] = $data['eheat_tot'];
    $data_energy['hp_tot'] = $data['hp_tot'];
    $data_energy['hp_cop'] = $data['hp_cop'];

    $data_energy["wood_m3"] = $data["wood_m3"];
    $data_energy["woodpellet_m3"] = $data["woodpellet_m3"];
    $data_energy["oil_L"] = $data["oil_L"];
    $data_energy["mainsgas_m3"] = $data["mainsgas_m3"];
    $data_energy["lpg_L"] = $data["lpg_L"];
    $data_energy["botgas_kg"] = $data["botgas_kg"];
    $data_energy["coal_kg"] = $data["coal_kg"];
    $data_energy["wood_eff"] = $data["wood_eff"];
    $data_energy["woodpellet_eff"] = $data["woodpellet_eff"];
    $data_energy["oil_eff"] = $data["oil_eff"];
    $data_energy["gas_eff"] = $data["gas_eff"];
    $data_energy["coal_eff"] = $data["coal_eff"];

    $data_energy["car1_miles"] = $data["car1_miles"];
    $data_energy["car2_miles"] = $data["car2_miles"];
    $data_energy["car3_miles"] = $data["car3_miles"];
    $data_energy["ecar_miles"] = $data["ecar_miles"];

    $data_energy["mbike_miles"] = $data["mbike_miles"];
    $data_energy["bus_miles"] = $data["bus_miles"];
    $data_energy["train_miles"] = $data["train_miles"];
    $data_energy["boat_miles"] = $data["boat_miles"];
    $data_energy["plane_miles"] = $data["plane_miles"];
   
    return $data_energy;
  }
