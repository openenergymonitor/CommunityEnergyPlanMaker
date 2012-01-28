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
  function user_controller()
  {
    global $action,$format,$lang;

    //---------------------------------------------------------------------------------------------------------
    // Login user (PUBLIC ACTION)
    // http://yoursite/emoncms/user/login?name=john&pass=test
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'login')
    {
      $username = preg_replace('/[^\w\s-.@]/','',$_GET["name"]);	// filter out all except for alphanumeric white space and dash
      $username = db_real_escape_string($username);

      $password = db_real_escape_string($_GET['pass']);
      $result = user_logon($username,$password);
      if ($result == 0) $output = "invalid username or password"; else $output = "login successful";

      if ($format == 'html') header("Location: ../energyaudit/group");
    }

    //---------------------------------------------------------------------------------------------------------
    // Create a user (PUBLIC ACTION) 
    // To disable addtional user creation remove or add higher priviledges to this
    // http://yoursite/emoncms/user/create?name=john&pass=test
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'create')
    {
      $username = preg_replace('/[^\w\s-.@]/','',$_GET["name"]);	// filter out all except for alphanumeric white space and dash
      $username = db_real_escape_string($username);

      $password = db_real_escape_string($_GET['pass']);

      if (get_user_id($username)!=0) $output = "username already exists";
      if (strlen($password) < 4 || strlen($password) > 30) $output = "password must be 4 to 30 characters<br/>";
      if (strlen($username) < 4 || strlen($username) > 30) $output = "username must be 4 to 30 characters<br/>";
      if (!$output) {
        create_user($username,$password);
        $result = user_logon($username,$password);
        $output = "user created";
        if ($format == 'html') header("Location: ../energyaudit/start");
      } else { echo "there was a problem?"; }
    }

    //---------------------------------------------------------------------------------------------------------
    // Forgot password
    // http://yoursite/emoncms/user/forgotpass?email=test@test.org
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'loginview') {
      if ($format == 'html' && $lang == "en") $output = view("user/login_block.php", array());
      if ($format == 'html' && $lang == "cy") $output = view("user/login_block_cy.php", array());
    }

    if ($action == 'forgotpass') {
      if ($format == 'html' && $lang == "en") $output = view("user/reset_password.php", array());
      if ($format == 'html' && $lang == "cy") $output = view("user/reset_password_cy.php", array());
    }

    if ($action == 'resetpass') {
      $email = preg_replace('/[^\w\s-.@]/','',$_GET["email"]);		// validate entry
      if (get_user_id($email)!=0) forgot_password($email);
      if ($format == 'html') header("Location: ../");
    }

    // http://yoursite/emoncms/user/changepass?old=sdgs43&new=sdsg345
    if ($action == 'changepass' && $_SESSION['write']) {
      $oldpass =  db_real_escape_string($_GET['oldpass']);
      $newpass =  db_real_escape_string($_GET['newpass']);
      if (change_password($_SESSION['userid'],$oldpass,$newpass)) $output = "Your password has been changed"; else $output = "Invalid old password";
    }

    //---------------------------------------------------------------------------------------------------------
    // NEW API READ
    // http://yoursite/emoncms/user/newapiread
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'newapiread' && $_SESSION['write']) {
      $apikey_read = md5(uniqid(rand(), true));
      set_apikey_read($_SESSION['userid'],$apikey_read);
      $output = "New read apikey: ".$apikey_read;

      if ($format == 'html') header("Location: view");
    }

    //---------------------------------------------------------------------------------------------------------
    // NEW API WRITE
    // http://yoursite/emoncms/user/newapiwrite
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'newapiwrite' && $_SESSION['write']) {
      $apikey_write = md5(uniqid(rand(), true));
      set_apikey_write($_SESSION['userid'],$apikey_write);
      $output = "New write apikey: ".$apikey_write;

      if ($format == 'html') header("Location: view");
    }

    //---------------------------------------------------------------------------------------------------------
    // Logout
    // http://yoursite/emoncms/user/logout
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'logout' && $_SESSION['read'])
    { 
      user_logout(); 
      $output = "logout"; 

      if ($format == 'html') header("Location: ../");
    }

    //---------------------------------------------------------------------------------------------------------
    // GET API READ
    // http://yoursite/emoncms/user/getapiread
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'getapiread' && $_SESSION['read']) {
      $apikey_read = get_apikey_read($_SESSION['userid']);
      $output = $apikey_read;
    }

    //---------------------------------------------------------------------------------------------------------
    // GET API WRITE
    // http://yoursite/emoncms/user/getapiwrite
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'getapiwrite' && $_SESSION['write']) {
      $apikey_write = get_apikey_write($_SESSION['userid']);
      $output = $apikey_write;
    }

    //---------------------------------------------------------------------------------------------------------
    // GET USER
    // http://yoursite/emoncms/user/view
    //---------------------------------------------------------------------------------------------------------
    if ($action == 'view' && $_SESSION['write']) {
      $user = get_user($_SESSION['userid']);

      if ($format == 'json') $output = json_encode($user);
      if ($format == 'html' && $lang == "en") $output = view("user_view.php", array('user' => $user));
      if ($format == 'html' && $lang == "cy") $output = view("user_view_cy.php", array('user' => $user));
    }

    return $output;
  }

?>
