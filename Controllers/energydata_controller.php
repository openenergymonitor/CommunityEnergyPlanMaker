<?php
  /*
   All Emoncms code is released under the GNU General Public License v3.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */

  // no direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  function energydata_controller()
  {
    require "Models/energydata_model.php";
    global $action, $format, $lang, $session;

    $output['content'] = "";
    $output['message'] = "";

    if ($action == "save" && $session['write'])
    {
      $output['message'] = "saving";
      $json = preg_replace('/[^\w\s-.?@%&:[]{},]/','',$_POST['data']);// filter out all except for alphanumeric white space and dash and full stop
        if (isset($_GET['apikey'])) { //The session is defined by apikey
            set_energydata($session['userid'], $json);
        } else { //the session is defined by the session id
            if ($_POST['CSRF_token'] == $_SESSION['CSRF_token'])
                set_energydata($session['userid'], $json);
            else {
                reset_CSRF_token();
                $output['message'] = "Invalid token";
            }
        }

    }

    /*

    Controller action for statistics page

    We do the data processing here in php so that no user specific data is made available publicly
    The data passed to the javascript (client) side is only the aggregated statistics and is the data
    required to give an overview.

    */ 

    if ($action == "view" && $session['read'])
    {
      $userlist = get_user_list();

      $audit_data = array();
      foreach ($userlist as $user) {
        $data = get_energydata($user['userid']);
        if ($data) $audit_data[] = $data;
      }

      $totals = array();
      $fossil = 0; $green = 0; $electric = 0; $heating = 0; $transport = 0; $i = 0;
      foreach ( $audit_data as $user ) {
  
        // We cycle through the $user objects by energy use type key i.e elec,eheat,stor,ecar,oil etc...
        // The reason it is done this way is that we can use the key from the user object to populate the totals object.
        // The key is transfered making the implementation really neat.
        while ($key = key($user)){

          $totals[$key] += $user->$key->quantity;	// Calculation of totals and transfer of key.
         
	  if ($user->$key->color==0) $fossil += getkwh($user->$key);
          if ($user->$key->color==1) $green += getkwh($user->$key);

          if ($user->$key->type==0) $electric += getkwh($user->$key);
          if ($user->$key->type==1) $heating += getkwh($user->$key);
          if ($user->$key->type==2) $transport += getkwh($user->$key);

          next($user);
        }
        $i++;
      } 

      $totals['electric'] = $electric/$i;
      $totals['heating'] = $heating/$i;
      $totals['transport'] = $transport/$i;
      $totals['no-user'] = $i;

      $totals['suspos'] = intval(100*$green / ($green+$fossil));

      if ($lang == "en") $output['content'] = view("stats_view.php", array('group_data'=>$totals));
    }

    /*

    Action for energy group page

    The group action loads the energy data of all users and passes it to the javascript client side scripting
    The scripting then creates the big stack comparison visualisation - hence the need to pass all user energy data.
 
    This action and its page is a great tool if users have given concent to sharing their data such as in a community energy 
    common interest group.

    */

    if ($action == "group" && $session['read'])
    {
      $userlist = get_user_list();

        $energy_data = array();
        foreach ($userlist as $user) {
          $data = get_energydata($user['userid']);
          if ($data) $energy_data[] = $data;
        }
      $output['content'] = view("group_view.php", array('group_data'=>$energy_data, 'lang'=>$lang));
    }

    return $output;
  }

?>
