<?php include"first.php";?>
<?php 

ini_set('display_errors','off');
  $string= file_get_contents("tripti1.json") or die("error");
  $json_a = json_decode($string,true);
  $district_array=array_column($json_a,'district');
  $population_array=array_column($json_a,'population');


  $length=count($district_array);
$dis_dummy=array();
  for ($i=0; $i < $length ; $i++) { 
        $dist=$district_array[$i];
      $pop=$population_array[$i];
      $dis_dummy[$dist]=$pop;
      //echo $pop[$i];
    } 
sort($district_array);


?>

<!DOCTYPE html>


<html>


<form action='<?php echo $_SERVER['PHP_SELF'];?>' method="post" >
      District 1: <select name="district_name1">
        <?php
          foreach ($district_array as $key => $value) {
            echo '<option value="'.$value.'">'.$value.'</option>';
          }
        ?>
      </select>
      District 2: <select name="district_name2">
        <?php
          foreach ($district_array as $key => $value) {
            echo '<option value="'.$value.'">'.$value.'</option>';
          }
        ?>
      </select>
      <input name="submit" type="submit"/>
    </form>
</html>


<?php
  $district1;
  $district2;
  if(isset($_POST['submit'])){
    $district1=$_POST['district_name1'];
    $district2=$_POST['district_name2'];


  }
  
  $pop_dist1=$dis_dummy[$district1];
  $pop_dist2=$dis_dummy[$district2];

  $final_array=array();
  //$final_array[0]=array();
  //array_push($final_array[0],"district");
  //array_push($final_array[0], "population");
  $final_array[0]=array();

  $final_array[0]['district']=$district1;
  $final_array[0]['population']=$dis_dummy[$district1];


  $final_array[1]=array();
  $final_array[1]['district']=$district2;
  $final_array[1]['population']= $dis_dummy[$district2];


  $final_json_array=json_encode($final_array);

  
  
//var_dump($final_json_array);

$file = fopen("test.json","w+") or die ("can't open file");
fwrite($file,$final_json_array);
fclose($file);
  
?>









<style>

.bar {
  fill: steelblue;
}

.bar:hover {
  fill: brown;
}

.axis {
  font: 10px sans-serif;
}

.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}


</style>
<div id="wrapper" style="margin-top:40px; align="center"; ">

<script src="d3.min.js"></script>
<?php if(isset($_POST['submit'])):?>
<script>

var margin = {top: 100, right: 20, bottom: 30, left: 100},
    width = 300 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

var x = d3.scale.ordinal()
    .rangeRoundBands([0, width], .1);

var y = d3.scale.linear()
    .range([height, 0]);

var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

var yAxis = d3.svg.axis()
    .scale(y)
    .orient("left");
   

var svg = d3.select("#wrapper").append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

d3.json("test.json",function(error, data) {
  x.domain(data.map(function(d) { return d.district; }));
  y.domain([0, d3.max(data, function(d) { return d.population; })]);

  svg.append("g")
      .attr("class", "x axis")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
      .append("text")
      .attr("y",30)
      .attr("x",75)
      .style("text-anchor","left")
      .text("Districts");

  svg.append("g")
      .attr("class", "y axis")
      .call(yAxis)
      .append("text")
      .attr("transform", "rotate(-90)")
      .attr("x",-130)
      .attr("y",-60)
      //.attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Population");

  svg.selectAll(".bar")
      .data(data)
    .enter().append("rect")
      .attr("class", "bar")
      .attr("x", function(d) { return x(d.district); })
      .attr("width", x.rangeBand())
      .attr("y", function(d) { return y(d.population); })
      .attr("height", function(d) { return height - y(d.population); })
      .append("title")
            .text(function(d) {
                return (d.district) + ": " +(d.population) ;
            });

});
</script>
</div>
<?php endif; ?>