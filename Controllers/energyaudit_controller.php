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

  function energyaudit_controller()
  {
    require "Models/energyaudit_model.php";
    global $action, $format, $lang, $session;

    $output['content'] = "";
    $output['message'] = "";

    if ($action == "save" && $session['write']) {
        $output['message'] = "saving";

        $data = json_decode($_POST['data']);
        if (isset($_GET['apikey'])) { //The session is defined by apikey
            set_energyaudit_data($session['userid'], $data);

        } else { //the session is defined by the session id
            if ($_POST['CSRF_token'] == $_SESSION['CSRF_token']) {
                set_energyaudit_data($session['userid'], $data);
                $output['message'] = "saving via token";
            } else {
                reset_CSRF_token();
                $output['message'] = "Invalid token";
            }
        }
    }

    if ($action != "" && $action != "save" && $session['write'])
    {
      $userid = $session['userid'];
      $data = get_energyaudit_data($userid);
      require "Views/energyaudit/functions.php";

      if ($lang == "en") $left = view("energyaudit/en/".$action."_view.php", array('data'=>$data));

      $right = view("energyaudit/stack_view.php", array('data'=>$data,'apikey_write' => get_apikey_write($userid) ));

      if ($lang == "en") $output['content'] = view("energyaudit/en/energyaudit_view.php", array('left'=>$left,'right'=>$right));
    }

    return $output;
  }

?>
