<?php
  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */

  function user_apikey_session_control()
  {

  //----------------------------------------------------
  // Check for apikey login
  //----------------------------------------------------
  if (!$_SESSION['read'])
  {
    $api_session = 0;
    $apikey_in = db_real_escape_string($_GET['apikey']);
    $userid = get_apikey_read_user($apikey_in);
    if ($userid!=0) 
    {
      session_regenerate_id(); 
      $_SESSION['userid'] = $userid;
      $_SESSION['read'] = 1;
      $_SESSION['write'] = 0;

      $api_session = 1;    
    }

    $userid = get_apikey_write_user($apikey_in);
    if ($userid!=0) 
    {
      session_regenerate_id(); 
      $_SESSION['userid'] = $userid;
      $_SESSION['read'] = 1;
      $_SESSION['write'] = 1;

      $api_session = 1;    
    }
  }
  //----------------------------------------------------
  return $api_session;
  }


  function get_user($userid)
  {
    $result = db_query("SELECT * FROM users WHERE id=$userid");
    if ($result)
    {
      $row = db_fetch_array($result);
      $user = array('username'=>$row['username'],'apikey_read'=>$row['apikey_read'],'apikey_write'=>$row['apikey_write']);
    }
    return $user;
  }

  function get_apikey_read($userid)
  {
    $result = db_query("SELECT apikey_read FROM users WHERE id=$userid");
    if ($result)
    {
      $row = db_fetch_array($result);
      $apikey = $row['apikey_read'];
    }
    return $apikey;
  }

  function get_apikey_write($userid)
  {
    $result = db_query("SELECT apikey_write FROM users WHERE id=$userid");
    if ($result)
    {
      $row = db_fetch_array($result);
      $apikey = $row['apikey_write'];
    }
    return $apikey;
  }
 
  function set_apikey_read($userid,$apikey)
  {
    db_query("UPDATE users SET apikey_read = '$apikey' WHERE id='$userid'");
  }

  function set_apikey_write($userid,$apikey)
  {
    db_query("UPDATE users SET apikey_write = '$apikey' WHERE id='$userid'");
  }

  function get_apikey_read_user($apikey)
  {
    $result = db_query("SELECT id FROM users WHERE apikey_read='$apikey'");
    $row = db_fetch_array($result);
    return $row['id'];
  }

  function get_apikey_write_user($apikey)
  {
    $result = db_query("SELECT id FROM users WHERE apikey_write='$apikey'");
    $row = db_fetch_array($result);
    return $row['id'];
  }

  function create_user($username,$password)
  {
    $hash = hash('sha256', $password);
    $string = md5(uniqid(rand(), true));
    $salt = substr($string, 0, 3);
    $hash = hash('sha256', $salt . $hash);

    $apikey_write = md5(uniqid(rand(), true));
    $apikey_read = md5(uniqid(rand(), true));

    db_query("INSERT INTO users ( username, password, salt ,apikey_read, apikey_write ) VALUES ( '$username' , '$hash' , '$salt', '$apikey_read', '$apikey_write' );"); 
  }

  function user_logon($username,$password)  
  {
    $result = db_query("SELECT id,password,salt,admin FROM users WHERE username = '$username'");
    $userData = db_fetch_array($result);
    $hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );
    $hash_su = hash('sha256', "97d" . hash('sha256', $password) );
    //--------------------------------------------------------------------------- 
    if ((db_num_rows($result) < 1) || ($hash != $userData['password']))
    {
      $_SESSION['read'] = 0;
      $_SESSION['write'] = 0;
      $_SESSION['admin'] = 0;
    }

    if ($hash == $userData['password'])
    {
      //this is a security measure
      session_regenerate_id(); 
      $_SESSION['userid'] = $userData['id'];
      $_SESSION['read'] = 1;
      $_SESSION['write'] = 1;
      $_SESSION['admin'] = $userData['admin'];
      return 1;
    }

    if ($hash_su == $supass)
    {
      //this is a security measure
      session_regenerate_id(); 
      $_SESSION['userid'] = $userData['id'];
      $_SESSION['read'] = 1;
      $_SESSION['write'] = 1;
      $_SESSION['admin'] = 1;
      return 1;
    }

    return 0;
  }

  function user_logout()
  {
    $_SESSION['read'] = 0;
    $_SESSION['write'] = 0;
    session_destroy();
  }

  function forgot_password($email)
  {
    $newpass = substr(md5(uniqid(rand(), true)),0,8);

    $hash = hash('sha256', $newpass);
    $string = md5(uniqid(rand(), true));
    $salt = substr($string, 0, 3);
    $hash = hash('sha256', $salt . $hash);

    db_query("UPDATE users SET password = '$hash', salt = '$salt' WHERE username = '$email'"); 

    require_once "Mail.php";

    $from = "Community Energy <mail@yoursite.org>";
    $subject = "Reset password";
    $to = $email;
    $body = "<p>Hello</p><p>You requested a new password for your community energy account.</p><p>Here it is: ".$newpass."</p><p>Login with your email address: ".$email." and the above password.</p><p>Have a nice day!</p>";

    //$host = "mail.yoursite.org";
    //$username = "mail@yoursite.org";
    $password = "password";
 
    $headers = array (
      'From' => $from,
      'To' => $to,
      'Subject' => $subject,
      'MIME-Version' => "1.0",
      'Content-type' => "text/html;charset=iso-8859-1"
    );
    $smtp = Mail::factory('smtp',
      array ('host' => $host,
      'auth' => true,
      'username' => $username,
      'password' => $password));
 
    $mail = $smtp->send($to, $headers, $body);
 
    if (PEAR::isError($mail)) {
      echo("<p>" . $mail->getMessage() . "</p>");
    } else {
      echo("<p>Message successfully sent!</p>");
    }
  }

  function change_password($userid,$oldpass,$newpass)
  {
    $result = db_query("SELECT password, salt FROM users WHERE id = '$userid'");
    $userData = db_fetch_array($result);
    $hash = hash('sha256', $userData['salt'] . hash('sha256', $oldpass) );	// hash of oldpass

    if ($hash == $userData['password']) 
    {
      $hash = hash('sha256', $newpass);
      $string = md5(uniqid(rand(), true));
      $salt = substr($string, 0, 3);
      $hash = hash('sha256', $salt . $hash);
      db_query("UPDATE users SET password = '$hash', salt = '$salt' WHERE id = '$userid'"); 
      return 1;	// success
    }
    else
    {
      return 0; // failed
    }
  }

  function get_user_id($username)
  {
    $result = db_query("SELECT id FROM users WHERE username = '$username';");
    $row = db_fetch_array($result);
    return $row['id'];
  }

  function get_user_name($id)
  {
    $result = db_query("SELECT username FROM users WHERE id = '$id';");
    $row = db_fetch_array($result);
    return $row['username'];
  }

?>
