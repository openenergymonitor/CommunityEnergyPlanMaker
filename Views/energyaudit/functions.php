<!--
   All Emoncms code is released under the GNU General Public License v3.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
-->

<?php
  // no direct access
  defined('EMONCMS_EXEC') or die('Restricted access');

  function checkbox($data,$key)
  {
    if ( $data[$key]) $out = "<input class='checksel' type='checkbox' name='".$key."' checked />";
    if (!$data[$key]) $out = "<input class='checksel' type='checkbox' name='".$key."' />";
    return $out;
  }

  function form_input_text($data,$key,$width)
  {
    return "<input id=".$key." name=".$key." type='text' class='inp01' style='width:".$width."px;' value='".$data[$key]."'/>";
  }

  function form_input_textarea($data,$key)
  {
    return "<textarea id=".$key." name=".$key." class='inp01' rows='4' cols='21'>".$data[$key]."</textarea>";
  }

  function form_input_textarea2($data,$key,$rows,$cols)
  {
    return "<textarea id=".$key." name=".$key." class='inp01' rows='".$rows."' cols='".$cols."'>".$data[$key]."</textarea>";
  }

  function form_input_select($data,$key,$options)
  {
    $out = "<select class='inpsel' id=".$key." name=".$key.">";
    $options = explode("|", $options);
    foreach ($options as $option)
    {
      $out .= select_option($data[$key],$option);
    }
    $out .= "</select>";
    return $out;
  }

  function form_select($name,$d,$options)
  {
    $out = "<select id=".$key." name=".$name.">";
    $options = explode("|", $options);
    foreach ($options as $option)
    {
      $out .= select_option($d,$option);
    }
    $out .= "</select>";
    return $out;
  }

  function select_option($d,$value)
  {
    if ($d == $value) return "<option selected >".$value."</option>";
    if ($d != $value) return "<option>".$value."</option>";
  }

  function form_radio($name,$d,$options)
  {
    $options = explode("|", $options);
    $out ="";
    foreach ($options as $option)
    {
      if ($d == $option) $out .= "<label>".$option.":</label><input type='radio' name=".$name." value=".$option." checked /><br/>";
      if ($d != $option) $out .= "<label>".$option.":</label><input type='radio' name=".$name." value=".$option." /><br/>";  
    }
    return $out;
  }


?>
