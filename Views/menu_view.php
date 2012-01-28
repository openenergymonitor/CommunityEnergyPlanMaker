<!--
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
-->
<style>

.top_menu ul li 
{
  float: left;
  <?php if ($_SESSION['admin']) echo "width: 20.00%;"; else echo "width: 33.33%;"; ?> 
}

</style>

<?php if ($_SESSION['admin']) { ?>

<li><a href='<?php echo $GLOBALS['path']; ?>input/list'>Inputs</a></li>
<li><a href='<?php echo $GLOBALS['path']; ?>feed/list'>Feeds</a></li>
<?php } ?>
<li><a href='<?php echo $GLOBALS['path']; ?>user/view'>Account</a></li>
<li><a href='<?php echo $GLOBALS['path']; ?>energyaudit/start'>My Energy</a></li>
<li><a href='<?php echo $GLOBALS['path']; ?>energyaudit/group'>Energy Group</a></li>

