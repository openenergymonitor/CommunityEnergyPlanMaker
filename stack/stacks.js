  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */

 function drawtext(ctx,x,mov,text)
 {
    ctx.fillStyle    = "rgba(0, 0, 0, 0.9)";
    ctx.textAlign    = "center";
    ctx.font         = "bold 10px arial";
    ctx.fillText(text, x+40,mov+20);  
 }

 function drawCat(ctx,x,mov,kwh,text,c,scale,unit,width)
  {

    if (kwh!=0)
    {
    seg = kwh*scale;
    mov -=seg;

    if (c==0)
    {
    ctx.fillStyle = "#ffd4d4";
    ctx.strokeStyle = "#ff7373";
    }
    if (c==1)
    {
    ctx.fillStyle = "#baf8ba";
    ctx.strokeStyle = "#78bf78";
    }
    if (c==2)
    {
    ctx.fillStyle = "#fff7f7";
    ctx.strokeStyle = "#ffd3d3";
    }

    if (c==3)
    {
    ctx.fillStyle = "#fdfffd";
    ctx.strokeStyle = "#c3e8c3";
    }

    if (c==4)
    {
    ctx.fillStyle = "#ffdbbd";
    ctx.strokeStyle = "#ffb172";
    }
    if (c==5)
    {
    ctx.fillStyle = "#ffeebc";
    ctx.strokeStyle = "#ffd44f";
    }
    if (c==6)
    {
    ctx.fillStyle = "#ede8c2";
    ctx.strokeStyle = "#bdb570";
    }

    if (c==7)
    {
    ctx.fillStyle = "rgb(240,240,240)";
    ctx.strokeStyle = "rgb(240,240,240)";
    }

    ctx.fillRect (x, mov, width, seg-4);
    ctx.strokeRect(x, mov, width, seg-4);

    if (seg>30.0)
    {
    ctx.fillStyle    = "rgba(0, 0, 0, 0.9)";
    ctx.textAlign    = "center";
    ctx.font         = "bold 12px arial";
    ctx.fillText(text, x+(width/2),mov+(seg/2)-8+2);  
    ctx.font         = "normal 12px arial"; 
    ctx.fillText((kwh).toFixed(0)+unit, x+(width/2),mov+(seg/2)+8+2);   
    } else {
    ctx.fillStyle    = "rgba(0, 0, 0, 0.5)";
    ctx.textAlign    = "center";
    ctx.font         = "bold 12px arial";
    //ctx.fillText(text+" "+(kwh).toFixed(0), x+60,mov+(seg/2)+2);  
    }
    }
    return mov;
  }

