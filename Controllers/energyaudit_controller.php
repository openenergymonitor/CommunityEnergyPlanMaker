<?php
  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */
  function energyaudit_controller()
  {
    require "Models/energyaudit_model.php";
    global $session, $action, $format;

    $lang = "en";

    $output['content'] = "";
    $output['message'] = "";

    if ($action == "save" && $session['write'])
    {
      $output['content'] = "saving";
      $data = json_decode($_POST['data']);
      set_energyaudit_data($session['userid'],$data);
    }

    if ($action != "save" && $action != "group" && $session['read'])
    {

      $userid = $session['userid'];
      $data = get_energyaudit_data($userid);
      require "Views/energyaudit/functions.php";

      if ($lang == "en") $left = view("energyaudit/en/".$action."_view.php", array('data'=>$data));

      $group_data = array();
      $group_data[0] = $data;

      $right = view("stack_view.php", array('group_data'=>$group_data,'apikey_write' => get_apikey_write($userid) ));
      if ($lang == "en") $output['content'] = view("energyaudit/en/energyaudit_view.php", array('left'=>$left,'right'=>$right));
    }

    if ($action == "group" && $session['read'])
    {
      $group_data = array();

      $userlist = get_user_list();
      
      foreach ($userlist as $user) {
        $data = get_energyaudit_data_energy($user['userid']);
        if ($data) $group_data[] = $data;
      }
      $output['content'] = view("group_view.php", array('group_data'=>$group_data, 'lang'=>$lang));
    }

    return $output;
  }

?>
