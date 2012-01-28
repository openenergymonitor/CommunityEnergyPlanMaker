<!---------------------------------------------------------------------------------
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
---------------------------------------------------------------------------------->
<div style="margin: 0px auto; max-width: 990px; text-align:left; margin-top:20px;">

<div class='widget-container' style="width:590px; min-height:550px; margin-bottom: 20px; float:left;">
<br/><br/><br/>
<h2>Energy group</h2>
<p><b>Note: </b>This page is still under construction, the plan is to extend it with several different options for exploring different sustainable energy pathways. Including financial aspects.</p>
<p>As a group we provide <b><span id="percentage_sustainable"></span>%</b> of our transport, heating and electricity energy needs from renewable sources.</p>
<br/>
<canvas id="energy_bar" width="550px;" height="80"></canvas> 
<br/><br/>
<p>The figure on the right shows a stack of the group average in relation to the national average and the Zero Carbon Britain target.</p>

<p>Explore below how our individual contributions add up to the overall group picture.</p>

<h3>Group wood demand: <span id="group_wood"></span> m2/day</h3>
<h3>Group green electric demand: <span id="group_elec"></span> kWh/day</h3>
<p>The electricity demand could be supplied by:</p>
<h3><span id="of_wind"></span>% of one 100kW wind turbine</h3>
<h3><span id="of_solar"></span> kWp of installed solar capacity</h3>

</div>

<div class='widget-container' style="width:300px; height:550px; margin-left: 15px; float:left;">
<canvas id="groupstacks" width="290px;" height="500"></canvas> 
</div>

</div>
<div style='clear:both;'></div>
<div id="cancon" style="margin: 0px auto; width:1440px; text-align:left;">
<div class="widget-container" style="margin:0;">
   <h2>Individual Contributions</h2>
   Sort by: 

   <input id="comparison1" type="button" value="GreenRed" />
   <input id="comparison2" type="button" value="Breakdown" />
   <input id="comparison3" type="button" value="Types" />
   <input id="comparison4" type="button" value="Heat" /><br/>
<!--
   Order by: 
   <input class="order" type="button" value="0" />
   <input class="order" type="button" value="1" />
   <input class="order" type="button" value="2" />-->


<canvas id="can" width="1400px" height="600"></canvas> 

<p>Our current overall position is made up of every one of our individual situations. Each block on the graph above relates to a big chunk of
energy use: such as all our heating, or all our transport. The challenge of sustainable energy is essentially to convert each of the red blocks
(fossil fuels) to green blocks (renewable energy).

</p>

</div>
</div>

<div style="margin: 0px auto; max-width: 990px; text-align:left; margin-top:20px; margin-bottom:20px;">
<div class="widget-container" style="margin:0;">
<h2>Create a Sustainable Energy Plan</h2> 

  <P>Explore the effect of different potential measures on our energy use</p>
  <table>

  <tr>
  <td width="400px">Get all our electricity from renewable sources</td>
  <td><input id="susen0" type='checkbox' name='green' /></td>
  </tr>

  <tr>
  <td width="400px">Convert all petrol and diesel cars to electric cars</td>
  <td><input id="susen1" type='checkbox' name='Cars' /></td>
  </tr>

  <tr>
  <td>Convert all oil and gas heating to renewable electricity powered heatpumps</td>
  <td><input id="susen2" type='checkbox' name='Heatpumps' /></td>
  </tr>

  <tr>
  <td><p>Convert all flights to train journeys (we will need transatlantic trains for this to be even possible) so this is just for interest really: </td>
  <td><input id="susen3" type='checkbox' name='Trains' /></td>
  </tr>
  </table>
</div>
</div>

