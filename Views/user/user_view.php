<!--
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
-->
<?php

// no direct access
defined('EMONCMS_EXEC') or die('Restricted access');

global $path, $session; 

?>
<div class='lightbox' style="margin-bottom:20px; margin-left:3%; margin-right:3%;">

  <h2>User: <?php echo $user['username']; ?></h2>

  
<div class="widget-container-nc"  style="width:600px;">
<h3>Change password</h3>
<form action="changepass" method="get">
<p><b>Old password:</b><br/>
<input class="inp01" type="password" name="oldpass" style="width:250px"/></p>
<p><b>New password:</b><br/>
<input class="inp01" type="password" name="newpass" style="width:250px"/></p>
<input type="submit" class="button04" value="Change" /> 
</form>
</div>
  <div style="clear:both;"></div><br/>

</div>

