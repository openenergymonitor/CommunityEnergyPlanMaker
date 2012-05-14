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

  function set_energydata($userid,$energydata)
  {
    $result = db_query("SELECT * FROM energydata WHERE `userid` = '$userid'");
    
    if (db_num_rows($result)==0){
      db_query("INSERT INTO energydata (`userid`, `data`) VALUES ('$userid','$energydata')");
    }
    else
    {
      db_query("UPDATE energydata SET `data` = '$energydata' WHERE `userid` = '$userid' ");
    }
  }

  function get_energydata($userid)
  {
    $result = db_query("SELECT * FROM energydata WHERE `userid` = '$userid'"); 
    $row = db_fetch_array($result);
    return json_decode($row['data']);
  }

  function getkwh($edata)
  {
    $kwh = $edata->quantity * $edata->kwh;
    return $kwh;
  }

