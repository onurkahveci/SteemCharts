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
        data.addColumn('number', 'Author Reward Values in SBD');
        data.addColumn('number', 'Author Reward Values in Steem Power');
        
		  data.addRows([
		  <?php
	// Create the loop //
	foreach ($data as $person1) {
			$author = $person1['author'];

$total_amount_mine = str_replace(" SBD", "", $person1["pending_payout_value"]);
	
	if(($total_amount_mine>0) and ($author==$meme)){
		
		$pending_payout_value_insbd = $total_amount_mine * 0.75 * 0.75 * 0.5;
$steem_power = $pending_payout_value_insbd / $steemprice;

    $id1 = $person1['id'];
    $url = $person1['url'];
	$NameUrl= substr($url, strrpos($url, '/') + 1);

 echo "['".$url."', '".$NameUrl."', ".$pending_payout_value_insbd.", ".$steem_power."],";
	}
	}
		
		?>
		   ]);


        var table = new google.visualization.Table(document.getElementById('table_div'));

	var formatter = new google.visualization.PatternFormat(
    '<a href="http://www.steemit.com{0}" target="_blank">{1}</a>');
formatter.format(data, [0, 1, 2, 3]);
var view = new google.visualization.DataView(data);
view.setColumns([0, 2, 3]); // Create a view with the first column only.
table.draw(view, {allowHtml: true, showRowNumber: true, width: '800px', height: '400px'});

	  }
    </script>

	
	<?php
	// Create the loop //
	foreach ($data as $person1) {
	try
	{
	$author = $person1['author'];
    $benef1 = $person1['parent_permlink'];
    $children = $person1['children'];
	$numberofposts = $numberofposts + 1;

	if(!($person1["pending_payout_value"] == "0.00 SBD") and ($author==$meme)){

    $total_amount_mine = str_replace(" SBD", "", $person1["pending_payout_value"]);
	$payment = $payment + $total_amount_mine;
	// Steemit curator cut //
	$paymentsbd_mine = $payment * 75 / 100;
	// Beneficaries cut //
	$paymentsbd_mine_beneficaries = $paymentsbd_mine * 75 / 100;
	// %50 - %50 POST END //
	$payment_end_mine = $paymentsbd_mine_beneficaries / 2;
	// Calculation to the fiat //
	include 'sbdfiat.php';

	$try_mine_total = intval($try_mine_total);
	$dollar_mine_total = intval($dollar_mine_total);
	$euro_mine_total = intval($euro_mine_total);
	$steem_mine_total = intval($steem_mine_total);
	
	// Calculation SP //
	$steem_power = $payment_end_mine / $steemprice;
	
    }
    }
	catch(Exception $me){}
    }
	}
		if($error == false){
		// if api returns null, give warn //
		if($person1['author'] == null){
		
		$error = true;
		$error_null = '<div class="alert alert-danger"><strong>WARNING!!! </strong>This username doesnt exist</div>';
		echo $error_null;

	}   
	else{
		

		echo '<div class="alert alert-success" role="alert"><strong>Total pending payouts</strong>: '.$payment.'. STU</div>';
		echo '<div class="alert alert-success" role="alert"><strong>Total amount of SBD</strong>: '.$payment_end_mine.'. SBD</div>';
		echo '<div class="alert alert-success" role="alert"><strong>Total amount of SP</strong>: '.$steem_power.'. SP</div>';
			echo'	    <div id="table_div"></div><br><br>';

	echo '<div class="col-md-10 col-sm-10 col-xs-12 col-lg-10 margin-auto-float-none"> 
	
<div class="table-responsive">
  <table class="table green-table">
  <thead>
    <tr>
      <th scope="col">Username</th>
      <th scope="col">Bitcoin</th>
      <th scope="col">Ethereum</th>
      <th scope="col">STEEM</th>
      <th scope="col">USD</th>
      <th scope="col">Euro</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>'.$author.'</td>
      <td>'.$btc_mine_total.'</td>
      <td>'.$eth_mine_total.'</td>
      <td>'.$steem_mine_total.'</td>
      <td>'.$dollar_mine_total.'</td>
      <td>'.$euro_mine_total.'</td>
    </tr>
  </tbody>
</table>
</div>
</div>


';
	;
    }
	}
    } 
?>
