<?php
  /*
    All Emoncms code is released under the GNU Affero General Public License.
    See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org

    ADMIN CONTROLLER ACTIONS		ACCESS


  */

  // no direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  function admin_controller()
  {
    global $action,$format,$lang, $session;
    require "Models/energyaudit_model.php";
    require "Models/energydata_model.php";
    $output['content'] = "";
    $output['message'] = "";

    if ($session['admin'])
    {

    if ($action == '' && $session['write'] && $session['admin']) {
     $output['content'] = '<div style="height:2px; background-color:#ddd"></div><div style="margin: 0px auto; max-width: 850px; text-align:left; margin-top:20px; padding:20px; min-height:700px; color:#000; background-color:#fff;">';
     $output['content'] .= "<h2><a href='admin/users'>Users</a></h2>";
     $output['content'] .= "<h2><a href='admin/exportdata'>Export data</a></h2>";
     $output['content'] .= "<h2><a href='admin/energydata'>Energy data</a></h2></div>";

    }

    if ($action == 'setuser' && $session['write'] && $session['admin']) {
      $userid = intval($_GET['id']);
      $_SESSION['userid'] = $userid;
      header("Location: ../energyaudit/page1");
    }

    if ($action == 'users' && $session['write'] && $session['admin']) {
      $userlist = get_user_list();

      $i = 0;
      foreach ($userlist as $user) {
        $stats = get_statistics($user['userid']);
        $userlist[$i]['dnhits'] = $stats['dnhits'];
        $i++;
      }

      $output['content'] = view("admin/users_view.php", array('userlist'=>$userlist));
    }

    // admin/energydata shows heating form data for each household
    if ($action == 'energydata' && $session['write'] && $session['admin']) {
      $userlist = get_user_list();

      $data = array();
      foreach ($userlist as $user) {
        $data[$user['userid']]['userid'] = $user['userid'];
        $data[$user['userid']]['name'] = $user['name'];
        $data[$user['userid']]['data'] = get_energyaudit_data($user['userid']);
        $data[$user['userid']]['endata'] = get_energydata($user['userid']);
      }

      $output['content'] = view("admin/energydata_view.php", array('userlist'=>$data));
    }

    if ($action == 'exportdata' && $session['write'] && $session['admin']) {
      $userlist = get_user_list();

      $group_data = array();

      $data = get_energyaudit_data(1); // 1) Get key's from admin user

      $keys = array();
      foreach ($data as $d)
      {
        $keys[] = key($data);
        next($data);
      }

      $output['content'] = "<table border=1><tr>";
      foreach ($keys as $key) {
        $output['content'] .= "<th>".$key."</th>";
      }
      $output['content'] .= "</tr>";

      foreach ($userlist as $user) {

        $data = get_energyaudit_data($user['userid']);
        if ($data) {
          $group_data[] = $data;

          $output['content'] .= "<tr>";
          foreach ($keys as $key) {
            $output['content'] .= "<td>".$data[$key]."</td>";
          }
          $output['content'] .= "</tr>";
        }
      }
      $output['content'] .= "</table>";
    }

    } // end second if admin check

    return $output;
  }

?>
