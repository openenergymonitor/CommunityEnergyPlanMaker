  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */

//--------------------------------------------------------------------------------------------------
// Draw stacks
//--------------------------------------------------------------------------------------------------
  function draw_stacks_hr(stacks,element,width,height)
  {
    var canvas = document.getElementById(element);
    var ctx = canvas.getContext("2d");
    ctx.clearRect(0,0,width,height);

    var bheight = height/(stacks.length);
    if (bheight>100) bheight = 100;

    // Find max height to find how much the graph needs to be scaled by to fit everything on the page
    var top = 0;
    for (var i in stacks) if (top<stacks[i]['height']) top = stacks[i]['height'];
    var scale = (width) / top;

    var mov; var y = 5;
    for (var i in stacks)
    {
      mov = 2;
      //draw_text(ctx,mov,y,stacks[i]['name']);
      //draw_text(ctx,mov+20,y,stacks[i]['height'].toFixed(0)+" kWh/d");
      var stack = stacks[i]['stack'];
      for (var b in stack)
      {
        var block = stack[b];
        mov = draw_block_hr(ctx,mov,y,block['kwhd'],block['name'],block['color'],scale," kWh/d",bheight-10);
      }
      y += bheight;
    }
  }

//--------------------------------------------------------------------------------------------------
// Draw text label
//--------------------------------------------------------------------------------------------------
function draw_text_hr(ctx,x,mov,text)
{
  ctx.fillStyle    = "rgba(0, 0, 0, 0.9)";
  ctx.textAlign    = "center";
  ctx.font         = "bold 10px arial";
  ctx.fillText(text, x+40,mov+20);  
}

//--------------------------------------------------------------------------------------------------
// Draw stack block
//--------------------------------------------------------------------------------------------------
function draw_block_hr(ctx,mov,y,kwh,text,c,scale,unit,height)
{
  var fill,border;

  if (kwh!=0)
  {
    seg = kwh*scale;
    // Set color
    if (c==0) { fill = "#ffd4d4"; border = "#ff7373"; }				// fossil red
    if (c==1) { fill = "#baf8ba"; border = "#78bf78"; }				// sustainable green
    if (c==2) { fill = "#fff7f7"; border = "#ffd3d3"; }				// fossil loss
    if (c==3) { fill = "#fdfffd"; border = "#c3e8c3"; }				// sustainable loss
    if (c==4) { fill = "#ffdbbd"; border = "#ffb172"; }				// orange
    if (c==5) { fill = "#ffeebc"; border = "#ffd44f"; }				// yellow
    if (c==6) { fill = "#ede8c2"; border = "#bdb570"; }				// red
    if (c==7) { fill = "rgb(240,240,240)"; border = "rgb(240,240,240)"; }
 
    ctx.fillStyle = fill; ctx.strokeStyle = border;

    // Draw block
    ctx.fillRect (mov, y, seg-4, height);
    ctx.strokeRect(mov, y, seg-4, height);

    ctx.fillStyle    = "rgba(0, 0, 0, 0.9)";
    ctx.textAlign    = "center";

    // Draw text if block height is more than 30 pixels
    if (seg>50.0)
    {
      ctx.font = "bold 12px arial";
      ctx.fillText(text, mov+(seg/2),y+(height/2)-8+2);
      ctx.font = "normal 12px arial"; 
      ctx.fillText((kwh).toFixed(0)+unit, mov+(seg/2),y+(height/2)+8+2);   
    }

    mov +=seg;
  }
  return mov;
}

