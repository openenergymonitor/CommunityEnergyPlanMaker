<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

  <!--
   All Emoncms code is released under the GNU Affero General Public License.
   See COPYRIGHT.txt and LICENSE.txt.

    ---------------------------------------------------------------------
    Emoncms - open source energy visualisation
    Part of the OpenEnergyMonitor project:
    http://openenergymonitor.org
  -->


<?php
  $apikey_read = $_GET['apikey'];
  $path = dirname("http://".$_SERVER['HTTP_HOST'].str_replace('Vis/Dashboard', '', $_SERVER['SCRIPT_NAME']))."/";
?>

<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="user-scalable=no, width=device-width" />

    <link rel="stylesheet" type="text/css" href="../../Views/theme/dark/style.css" />

<!------------------------------------------------------------------------------------------
  Dashboard related javascripts
------------------------------------------------------------------------------------------->
<script type="text/javascript" src="../flot/jquery.js"></script>
<script type="text/javascript" src="../flot/jquery.flot.js"></script>


    <title>emoncms</title>
  </head>
  <body>

<!------------------------------------------------------------------------------------------
  Dashboard HTML
------------------------------------------------------------------------------------------->

<div id="placeholder" style="width:400px; height:300px;" ></div>
   
<script type="application/javascript">

$(function() {
  var path = "<?php echo $path; ?>";
  var apikey_read = "5be7ab8aee54b153d3a9222a89560c1c";

      $("#placeholder").width(600);
      $("#placeholder").height(600);

      var feedid = 270;


      var start = ((new Date()).getTime())-(3600000*12*100);		//Get start time
      var end   = ((new Date()).getTime())-(3600000*12*20);		//Get start time

      var end = 1322754124000;
      var start = 1322726994000;
      var timeWindow = end-start;
      console.log((timeWindow/1000)/3600);

      var ndp_target = 4000;
      var postrate = 000; //ms
      var ndp_in_window = timeWindow / postrate;
      var res = ndp_in_window / ndp_target;
      if (res<1) res = 1;

      res = 10;

      var data1 = [];
      $.ajax({                                      
          url: path+"feed/data.json",                         
          data: "&apikey="+apikey_read+"&id="+feedid+"&start="+start+"&end="+end+"&res="+res,
          dataType: 'json',    
          async: false,                       
          success: function(datain) 
          { 
            data1 = datain;
          } 
      });

      var data2 = []; feedid = 268;

      $.ajax({                                      
          url: path+"feed/data.json",                         
          data: "&apikey="+apikey_read+"&id="+feedid+"&start="+start+"&end="+end+"&res="+res,
          dataType: 'json',    
          async: false,                       
          success: function(datain) 
          { 
            data2 = datain;
          } 
      });

      var data = [];
      for (i in data2)
      {
        if (data1[i]){

          if (data1[i][1]<1000 && data1[i][1]>0){
            if (data2[i][1]<1000 && data2[i][1]>0){
              data[i] = [];
              data[i][0] = data1[i][1];
              data[i][1] = data2[i][1];
              console.log(data1[i][0]+","+data1[i][1]+","+(data2[i][0])+","+data2[i][1]);
            }
          }

        }
      }

      console.log(data1.length);

             $.plot($("#placeholder"),
              [{data: data, points: { show: true }}],
              { grid: { show: true } });
});

</script>

</body>
</html>


