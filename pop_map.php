<?php include "nav.html";?>
<!DOCTYPE html>
<meta charset="utf-8">
<style>

/* CSS goes here. */
path{
	stroke:black;
	stroke-width: 0.75px;
	/*fill:green;*/
}
.district-dark_green{
  fill:rgb(35,132,67);
}
.district-green{
  fill:rgb(120,198,121);
}
.district-light_green{
  fill:rgb(194,230,153);
}
.district-cream{
  fill:rgb(255,255,204);
}
.legend{
    font-size: 12px;
}

#wrapper{
  width:900px;
  margin-top:80px;
 

}

#map{
  width: 700px;
  padding-left:0px;
  float:right;
}
p{
  text-align: center;
  font-size: 20px;
}
</style>
<body>
<p><strong>Districts Vs Population</strong></p>

<div id="wrapper">

  <div id="map"></div>
</div>

<?php

ini_set('display_errors','off');
  $string= file_get_contents("json/pop1.json") or die("error");
  $json_a = json_decode($string,true);
  $district_array=array_column($json_a,'district');
  $population_array=array_column($json_a,'population');


  $length=count($district_array);
$dis_dummy=array();
  for ($i=0; $i < $length ; $i++) { 
        $dist=$district_array[$i];
      $pop=$population_array[$i];
      $dis_dummy[$dist]=$pop;
    
    } 

    

?>
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://d3js.org/topojson.v1.min.js"></script>
<script>

var file_j = <?php echo $string;?>
//alert(file_j[0].district);
len=file_j.length;
var color= ["#238443","#78c679","#c2e699","#ffffcc"];
var label =[">500000",">200000",">0","0"];
var col=color.len;

function getDistrictClass(population){
  return population > 500000?'dark_green':
          population > 200000? 'green':
          population > 0 ? 'light_green': 'cream';
}
function pop(dist){
	var dist=dist;
	var p=0;
	for (var i = 0; i < len; i++) {
		if (dist==file_j[i].district) {
			p=file_j[i].population;
		};
	};
	return p;
}

var width = 960,
  height = 1000;
 
var projection = d3.geo.mercator()
    .center([84.965, 28.185])
    .scale(4500);

var path = d3.geo.path()
  	.projection(projection);

 

var svg = d3.select("#map").append("svg")
    .attr("width", width)
    .attr("height", height);

 
 var g = svg.append("g"); 

  


d3.json("json/nepal-topo.json", function(error, nepal) {
 	g.selectAll("path")
 		.data(topojson.feature(nepal, nepal.objects.nepal).features)
 		.enter()
 		.append("path")
 		.attr("d", path)
    .attr("class",function(d){ return 'district-'+getDistrictClass(pop(d.id)); })
 		.append("title")
            .text(function(d) { 
            	var x=pop(d.id);
                return (d.id + "\n" + "Population: " +x) ;
            });
          //  var1==>d.id
            //console.log.status
  var legend = svg.selectAll("g.legend")
    .data(color)
    .enter().append("g")
    .attr("class","legend");
    //.attr("width",);

  legend.append("rect")
    .attr("width",18)
    .attr("height",18)
    .attr("x", 40)
    .attr("y", function(d,i){ return i*20;})
    .style("fill", function(d,i){return color[i];});

  legend.append("text")
    .attr("x", 60)
    .attr("y", function(d,i){ return 10+i*20;})
    .attr("dy", ".2em")
    .text(function(d,i){return label[i];});  
  
  
});



</script>