<?php include 'nav.html';?>
<link rel="stylesheet" type="text/css" href="styles.css">
<html>
	<style>
		
		.axis path,
		.axis line {
			fill: none;
			stroke: black;
			shape-rendering: crispEdges;
		}

		.axis text {
			font-family: sans-serif;
			font-size: 11px;
		}

	</style>
	<script src="d3.min.js" charset="utf-8">
	</script>

<body>
<script>

var margin = {top:100, right: 100, bottom:100, left:150};
	var w = 1200-margin.left - margin.right;
	var h = 1200-margin.top - margin.bottom;



    var svg = d3.select("body")
		.append("svg")
		.attr("width", w + margin.left + margin.right)
		.attr("height", h + margin.top + margin.bottom)
		.append("g")
		.attr("transform","translate(" + margin.left + "," + margin.bottom + ")");

	var y = d3.scale.ordinal()
        .rangeRoundBands([0,h], .1);

  	var x = d3.scale.linear()
              .range([0,w]);

	var xAxis = d3.svg.axis()
        .scale(x)
        .orient("top")
        .tickFormat(d3.format('s'));

  	var yAxis = d3.svg.axis()
          .scale(y)
          .orient("left");


d3.json("pop1.json", function(error, data){
    x.domain([0,d3.max(data, function(d){return d.population;})]);
    y.domain(data.map(function(d){return d.district;}));

    	
    //var sortOrder = false;

    

    svg.selectAll("rect")
    	.data(data)
    	.enter()
    	.append("rect")
    	//.attr("x",function(d){
    		//return x(d.population);
    	//})
    	.attr("y", function(d){
    		return y(d.district)
    	})
    	.attr("height", y.rangeBand())
    	.attr("width", function(d){return x(d.population); })
    	.attr("fill", function(d) {  
        			return "rgb(0,102, " + (d.population) + ")";})
    	
        .on("mouseover", function() {
        	d3.select(this)
          	 .attr("fill", "aqua");
					})
        .on("mouseout", function(d) {
        	d3.select(this)
        		.transition()
        		.duration(150)
        		.attr("fill", "rgb(0,102, " + (d.population) + ")");
						})
        .append("title")
            .text(function(d) {
                return (d.district) + ": " +(d.population) ;
            });
        /*.on("click", function() {
            sortBars();             
                        });*/

    svg.append("g")
    	.attr("class","x axis")
    	.call(xAxis)
        .append("text")
        .attr("y",-45)
        .attr("x", (w/2))
        .style("text-anchor","end")
        .text("Population");


    svg.append("g")
    	.attr("class","y axis")
    	.call(yAxis)
        .append("text")
        .attr("transform","rotate(-90)")
        .attr("x",-400)
        .attr("y", -100)
        .style("text-anchor","end")
        .text("Districts");


});
</script>
</body>


</html>