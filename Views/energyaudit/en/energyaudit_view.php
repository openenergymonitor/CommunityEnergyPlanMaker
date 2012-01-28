<!---------------------------------------------------------------------------------
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
---------------------------------------------------------------------------------->
          <div style="margin: 0px auto; max-width: 990px; text-align:left; margin-top:20px;">

<div class='widget-container' style="width:590px; min-height:550px; margin-bottom: 20px; float:left; position:relative;">

  <div class='top_menu2'>
    <ul>
      <li><a href='../energyaudit/electric'>Electric</a></li>
      <li><a href='../energyaudit/heating'>Heating</a></li>
      <li><a href='../energyaudit/transport'>Transport</a></li>
      <li><a href='../energyaudit/context'>Context</a></li>
    </ul>
    <div style='clear:both;'></div>
  </div>

  <?php echo $left; ?>
  <div style="position:absolute; bottom:20px; right:20px; width:200px; text-align:right;">
  <i><span id="save_label" style="padding-right:10px; color:#666;"></span></i><button type='button' id='save' class='button05' style="width:80px; line-height:30px;" >Save</button>
  </div>
</div>

<div class='widget-container' style="width:300px; height:550px; margin-left: 15px; float:left;">
  <?php echo $right; ?>
</div>

</div>
