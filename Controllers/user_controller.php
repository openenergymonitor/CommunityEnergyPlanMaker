<?php
  /*
    All Emoncms code is released under the GNU Affero General Public License.
    See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org

    USER CONTROLLER ACTIONS		ACCESS

    login?name=john&pass=test		all
    create?name=john&pass=test		all
    newapiread				write
    newapiwrite				write
    logout				read
    getapiread				read
    getapiwrite 			write
    view				write

  */
  // no direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  function user_controller()
  {
    global $action,$format,$lang,$session;

    $output['content'] = "";
    $output['message'] = "";

    //---------------------------------------------------------------------------------------------------------
    // Login user (PUBLIC ACTION)
    // http://yoursite/emoncms/user/login?name=john&pass=test
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'login')
    {
      $username = preg_replace('/[^\w\s-.@]/','',$_POST["name"]);	// filter out all except for alphanumeric white space and dash
      $username = db_real_escape_string($username);

      $password = db_real_escape_string($_POST['pass']);
      $result = user_logon($username,$password);
      if ($result == 0) $output['message'] = "Invalid username or password"; else {$output['message'] = "Welcome, you are now logged in";

      if ($format == 'html') header("Location: ../energyaudit/electric");}
    }

    //---------------------------------------------------------------------------------------------------------
    // Create a user (PUBLIC ACTION) 
    // To disable addtional user creation remove or add higher priviledges to this
    // http://yoursite/emoncms/user/create?name=john&pass=test
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'create')
    {
      $username = preg_replace('/[^\w\s-.@]/','',$_POST["name"]);	// filter out all except for alphanumeric white space and dash
      $username = db_real_escape_string($username);

      $password = db_real_escape_string($_POST['pass']);

      if (get_user_id($username)!=0) $output['message'] = "Sorry username already exists";
      if (strlen($password) < 4 || strlen($password) > 30) $output['message'] = "Please enter a password that is 4 to 30 characters long<br/>";
      if (strlen($username) < 4 || strlen($username) > 30) $output['message'] = "Please enter a username that is 4 to 30 characters long<br/>";
      if (!$output['message']) {
        create_user($username,$password);
        $result = user_logon($username,$password);
        $output['message'] = "Your new account has been created";
        if ($format == 'html') header("Location: ../energyaudit/electric");
        if ($_SESSION['write']) create_user_statistics($_SESSION['userid']);
      }
    }

    //---------------------------------------------------------------------------------------------------------
    // Forgot password
    // http://yoursite/emoncms/user/forgotpass?email=test@test.org
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'loginview') {
      if ($format == 'html' && $lang == "en") $output['content'] = view("user/login_block.php", array());
    }

    if ($action == 'forgotpass') {
      if ($format == 'html' && $lang == "en") $output['content'] = view("user/reset_password.php", array());
    }

    if ($action == 'resetpass') {
      $email = preg_replace('/[^\w\s-.@]/','',$_GET["email"]);		// validate entry
      if (get_user_id($email)!=0) forgot_password($email);
      //if ($format == 'html') header("Location: ../");
    }

    // http://yoursite/emoncms/user/changepass?old=sdgs43&new=sdsg345
    if ($action == 'changepass' && $session['write']) {
      $oldpass =  db_real_escape_string($_POST['oldpass']);
      $newpass =  db_real_escape_string($_POST['newpass']);
      if (change_password($_session['userid'],$oldpass,$newpass)) $output['message'] = "Your password has been changed"; else $output['message'] = "Invalid old password";
    }

    //---------------------------------------------------------------------------------------------------------
    // Logout
    // http://yoursite/emoncms/user/logout
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'logout' && $session['read'])
    { 
        if ($_POST['CSRF_token'] == $_SESSION['CSRF_token']) {
            user_logout();
            $output['message'] = "You are logged out";
        } else {
            reset_CSRF_token();
            $output['message'] = "Invalid token";
        }

       if ($format == 'html') header("Location: ../");
    }

    //---------------------------------------------------------------------------------------------------------
    // GET USER
    // http://yoursite/emoncms/user/view
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'view' && $session['write']) {
      $user = get_user($session['userid']);

      if ($format == 'json') $output['content'] = json_encode($user);
      if ($format == 'html' && $lang == "en") $output['content'] = view("user/user_view.php", array('user' => $user));
    }

    return $output;
  }

?>
