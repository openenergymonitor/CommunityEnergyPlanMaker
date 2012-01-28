  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */

function draw_energy_bar(element,width,height,pos)
{
    var canvas = document.getElementById(element);
    var ctx = canvas.getContext("2d");

    ctx.clearRect(0,0,width,height);

    ctx.fillStyle = "#dedede";
    ctx.fillRect   (1, 1, (width-2),height-2);

    ctx.strokeStyle = "#888";
    ctx.strokeRect (1, 1, (width-2),height-2);

    var x = (pos/100.0) * (width-8);
    ctx.fillStyle = "rgb(100,220,100)";
    ctx.fillRect (4, 4,x,(height-8));

    ctx.fillStyle    = "rgba(0, 0, 0, 0.9)";
    ctx.textAlign    = "center";
    ctx.font         = "bold 24px arial";

    var text = ""+(pos*1).toFixed(0)+"%";
    ctx.fillText(text, x/2,(height/2)+0);  
    ctx.font         = "bold 12px arial";
    ctx.fillText("Sustainable Energy", x/2,(height/2)+20);  

} 

