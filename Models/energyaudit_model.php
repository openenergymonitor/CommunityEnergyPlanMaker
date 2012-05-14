<?php
  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */

  // no direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  function set_energyaudit_data($userid,$data)
  {
    while($key = key($data)) 
    {
      $key = preg_replace('/[^\w\s-.?]/','',$key);	// filter out all except for alphanumeric white space and dash and full stop
      $val = preg_replace('/[^\w\s-.?@%&,]/','',$data->$key);	// filter out all except for alphanumeric white space and dash and full stop
      set_form_entry($userid,$key,$val);
      next($data);
    }
  }

  function set_energyaudit_data_assoc($userid,$data)
  {
    while($key = key($data)) 
    {
      $key = preg_replace('/[^\w\s-.?]/','',$key);	// filter out all except for alphanumeric white space and dash and full stop
      $val = preg_replace('/[^\w\s-.?@%&,]/','',$data[$key]);	// filter out all except for alphanumeric white space and dash and full stop
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
    return $data;
  }

