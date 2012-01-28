<?php 
  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */
function api_controller()
{
  global $action;
  require "Models/input_model.php";
  require "Models/feed_model.php";
  require "Models/process_model.php";


  // POST arduino posts up to emoncms 				
  if ($action == 'post' && $_SESSION['write']) $json = db_real_escape_string($_GET['json']);			

  if ($json)
  {
    //db_query("INSERT INTO dump (text) VALUES ('$json')");
    $datapairs = validate_json($json);				// validate json
    $time = time();						// get the time - data recived time
    if (isset($_GET["time"])) $time = intval($_GET["time"]);	// - or use sent timestamp if present
    $inputs = register_inputs($_SESSION['userid'],$datapairs,$time);          // register inputs
    process_inputs($_SESSION['userid'],$inputs,$time);                        // process inputs to feeds etc
    $output = "ok";
  }

  return $output;
}

  //-------------------------------------------------------------------------
  function register_inputs($userid,$datapairs,$time)
  {

  //--------------------------------------------------------------------------------------------------------------
  // 2) Register incoming inputs
  //--------------------------------------------------------------------------------------------------------------
  $inputs = array();
  foreach ($datapairs as $datapair)       
  {
    $datapair = explode(":", $datapair);
    $name = preg_replace('/[^\w\s-.]/','',$datapair[0]); 	// filter out all except for alphanumeric white space and dash
    $value = floatval($datapair[1]);		

    $id = get_input_id($userid,$name);				// If input does not exist this return's a zero
    if ($id==0) {
      create_input_timevalue($userid,$name,$time,$value);	// Create input if it does not exist
    } else {			
      $inputs[] = array($id,$time,$value);	
      set_input_timevalue($id,$time,$value);			// Set time and value if it does
    }
  }

  return $inputs;
  }

  function process_inputs($userid,$inputs,$time)
  {
  //--------------------------------------------------------------------------------------------------------------
  // 3) Process inputs according to input processlist
  //--------------------------------------------------------------------------------------------------------------
  foreach ($inputs as $input)            
  {
    $id = $input[0];
    $input_processlist =  get_input_processlist($userid,$id);
    if ($input_processlist)
    {
      $processlist = explode(",",$input_processlist);				
      $value = $input[2];
      foreach ($processlist as $inputprocess)    			        
      {
        $inputprocess = explode(":", $inputprocess); 		// Divide into process id and arg
        $processid = $inputprocess[0];				// Process id
        $arg = $inputprocess[1];	 			// Can be value or feed id

        $process_list = get_process_list();
        $process_function = $process_list[$processid][2];	// get process function name
        $value = $process_function($arg,$time,$value);		// execute process function
      }
    }
  }
  }

?>


