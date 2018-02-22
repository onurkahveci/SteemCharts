<?php
	$error = false;
    $payment = 0;
    error_reporting(0);
if(true){
	
	$meme = $_GET['author'];
	// if both inputs are empty give error //
	if(empty($meme)){
	$error = true;
	$error_input = '<div class="alert alert-danger">Please type username to analyse</div>';
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
	include 'sbdfiat.php';
	$numberofposts = 0;
	$numberofposts2 = 0;
	$tempnumber = 0;
	?>
	   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
         <script type="text/javascript">
        google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {
        var data = new google.visualization.DataTable();
		
		data.addColumn('string', 'Post URL');
        data.addColumn('string', 'Post');
        data.addColumn('number', 'Number of Comments');
        data.addColumn('number', 'Number of Upvotes');
        data.addColumn('number', 'Total Payout Value in SBD');
        
		  data.addRows([
		  <?php
	// Create the loop //
	foreach ($data as $person1) {
			$author = $person1['author'];
	
	if(($author==$meme)){

    $id1 = $person1['id'];
    $url = $person1['url'];
    $comments = $person1['children'];
    $netvotes = $person1['net_votes'];
    $totalpayoutvalue = $person1['total_payout_value'];
    $pending_payout_value = $person1['pending_payout_value'];
	$total_amount_of_payout_value = str_replace(" SBD", "", $person1["total_payout_value"]);
	$total_amount_of_pending_payout_value = str_replace(" SBD", "", $person1["pending_payout_value"]);
	$NameUrl= substr($url, strrpos($url, '/') + 1);

if(($person1["pending_payout_value"] == "0.000 SBD")){echo "['".$url."', '".$NameUrl."', ".$comments.", ".$netvotes.", ".$total_amount_of_payout_value."],";}
if(!($person1["pending_payout_value"] == "0.000 SBD")){echo "['".$url."', '".$NameUrl."', ".$comments.", ".$netvotes.", ".$total_amount_of_pending_payout_value."],";}
	}
	}
		
		?>
		   ]);


        var table = new google.visualization.Table(document.getElementById('table_div'));

	var formatter = new google.visualization.PatternFormat(
    '<a href="http://www.steemit.com{0}" target="_blank">{1}</a>');
formatter.format(data, [0, 1, 2, 3, 4]);
var view = new google.visualization.DataView(data);
view.setColumns([0, 2, 3, 4]); // Create a view with the first column only.
table.draw(view, {allowHtml: true, showRowNumber: true, width: '800px', height: '400px'});

	  }
    </script>

       
       
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
				echo'<div id="table_div"></div><br><br>';

	echo '
       <div id="columnchart_material" style="width: 800px; height: 500px;"></div>


';
	}
    } 
?>
