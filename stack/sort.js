  /*
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  */

function sort_by_block(stacks2,block_id)
{
  var stacks =   eval(JSON.stringify(stacks2));

  for(var x = 0; x < stacks.length; x++) {
        var block_holder = stacks[x]['stack'][block_id];
        stacks[x]['stack'][block_id] = stacks[x]['stack'][0];
        stacks[x]['stack'][0] = block_holder;
  }

  for(var x = 0; x < stacks.length; x++) {
    for(var y = 0; y < (stacks.length-1); y++) {
      if (stacks[y]['height']>0 && stacks[y+1]['height']>0)
      {
      if(stacks[y]['stack'][0]['kwhd'] < stacks[y+1]['stack'][0]['kwhd']) {
        var holder = stacks[y+1];
        stacks[y+1] = stacks[y];
        stacks[y] = holder;
      }
      }
    }
  }
  return stacks;
}

function sort_by_stack_height(stacks)
{

  for(x = 0; x < stacks.length; x++) {
    for(y = 0; y < (stacks.length-1); y++) {
      if(stacks[y]['height'] < stacks[y+1]['height']) {
        holder = stacks[y+1];
        stacks[y+1] = stacks[y];
        stacks[y] = holder;
      }
    }
  }
  return stacks;
}

