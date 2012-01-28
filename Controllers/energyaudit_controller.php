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
    global $action, $format, $lang;

    if ($action == "save" && $_SESSION['write'])
    {
      $content = "saving";
      $data = json_decode($_POST['data']);
      set_energyaudit_data($_SESSION['userid'],$data);
    }

    if ($action != "save" && $action != "group" && $_SESSION['read'])
    {
      $userid = $_SESSION['userid'];
      $data = get_energyaudit_data($userid);
      require "Views/energyaudit/functions.php";

      if ($lang == "en") $left = view("energyaudit/en/".$action."A_view.php", array('data'=>$data));
      if ($lang == "cy") $left = view("energyaudit/cy/".$action."A_view.php", array('data'=>$data));

      $group_data = array();
      $group_data[0] = $data;
      $group_data[1] = $decc = get_energyaudit_data(2);
      $group_data[2] = $zcb = get_energyaudit_data(1);

      $right = view("stack_view.php", array('group_data'=>$group_data,'apikey_write' => get_apikey_write($userid) ));
      if ($lang == "en") $content = view("energyaudit/en/energyaudit_view.php", array('left'=>$left,'right'=>$right));
      if ($lang == "cy") $content = view("energyaudit/cy/energyaudit_view.php", array('left'=>$left,'right'=>$right));
    }

    if ($action == "group" && $_SESSION['read'])
    {
      $group_data = array();
      for ($user=1; $user<60; $user++) {
        $data = get_energyaudit_data_energy($user);
        if ($data) $group_data[] = $data;
      }
      $content = view("group_view.php", array('group_data'=>$group_data, 'lang'=>$lang));
    }

    return $content;
  }

?>
