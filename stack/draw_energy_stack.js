  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */
  function draw_energy_stacks(stacks,element,width,height)
  {
    var canvas = document.getElementById(element);
    var ctx = canvas.getContext("2d");
    ctx.clearRect(0,0,width,height);


    var bwidth = width/(stacks.length);
    if (bwidth>100) bwidth = 100;

    // Find max height to find how much the graph needs to be scaled by to fit everything on the page
    var top = 0;
    for (var i in stacks) if (top<stacks[i]['height']) top = stacks[i]['height'];
    var scale = (height-80) / top;

    var mov; var x = 5;
    for (var i in stacks)
    {
      mov = height-60;
      drawtext(ctx,x,mov,stacks[i]['name']);
      drawtext(ctx,x,mov+20,stacks[i]['height'].toFixed(0)+" kWh/d");
      var stack = stacks[i]['stack'];
      for (var b in stack)
      {
        var block = stack[b];
        mov = drawCat(ctx,x,mov,block['kwhd'],block['name'],block['color'],scale," kWh/d",bwidth-10);
      }
      x += bwidth;
    }
  }
