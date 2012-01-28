<!--
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
-->
<div style="margin-left:20px;">
  <div style="max-width:392px; margin-right:20px; padding-top:45px; padding-bottom:15px; color: #888;">
    <div style="font-size:32px; font-weight:bold;">Prosiect Egni Ecobro</div>
    <div style="font-size:16px;"></div>
  </div>

  <div class="widget-container" style="max-width:350px; margin-right:20px;" >

    <div style="text-align:left">

      <form action="<?php echo $GLOBALS['path']; ?>user/resetpass" method="get">

        <p>Request a new password by typing in your email:</p>

        <p><b>Email:</b><br/>
        <input class="inp01" type="text" name="email" style="width:270px"/>

        <input type="submit" class="button04" value="Reset" /></p>
        <p>Once you click reset a new password will be emailed to you automatically, which may take a minuite. If nothing arrives check your junk mailbox.</p>
      </form>
    </div>
  </div>
</div>

