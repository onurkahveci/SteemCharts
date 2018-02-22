<?php
	$error = false;
    $payment = 0;
    error_reporting(0);
if(true){
	
	$meme = $_GET['tag'];
	// if both inputs are empty give error //
	if(empty($meme)){
	$error = true;
	$error_input = '<div class="alert alert-danger">Please type tag to analyse</div>';
	echo $error_input;
	}
	// both inputs filled, then give the result //
    if($error == false){
    $myself_url = 'https://api.steemjs.com/get_discussions_by_blog?query={"tag":"'.$meme.'","limit":"100"}';
	$json= file_get_contents($myself_url);
    $data = json_decode($json,true);
	// GET data from https://coinmarketcap.com/coins/views/all/ //
	//include 'currentvalues.php';
	include 'currentvalues.php';
	include 'converts.php';
	$numberofposts = 0;
	$numberofposts2 = 0;
	$tempnumber = 0;
	?>
	   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Post', 'Comments'],
          <?php
	// Create the loop //
	foreach ($data as $person1) {
			$author = $person1['author'];

		if($author==$meme){

    $id1 = $person1['id'];
    $url = $person1['url'];
	$children = $person1['children'];
 echo "['".$url."', ".$children."],";
	}
	}
		
		?>
        ]);

        var options = {
            title: 'Number of Comments',
            subtitle: 'Charts of Number of Comments for Last Posts',
			hAxis:{textStyle : {
            fontSize: 0 // or the number you want
        }}
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      
	   google.visualization.events.addListener(chart, 'select', selectHandler); 

    function selectHandler(e)     {  
	
	if(data.getValue(chart.getSelection()[0].row, 0).length > 0)
	
	{
		
		urllast = 'http://www.steemit.com'+data.getValue(chart.getSelection()[0].row, 0);
		
		window.open(urllast,'_blank');
		}
	
	
	}
	  }
    </script>

	
	<?php
	// Create the loop //
	echo '
       <div id="columnchart_material" style="width: 800px; height: 500px;"></div>


';
	}
    } 
?>
