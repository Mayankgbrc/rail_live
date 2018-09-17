<html>
	<head>
		<title> Buffer </title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>
	<body>
		<div class="w3-container">
		<?php 
			$t_no= $_POST['t_no'];
			$date = $_POST['date'];
			$year= substr($date,0,4);
			$month= substr($date,5,2);
			$day= substr($date,8,2);
			$newdate = $day."-".$month."-".$year;
			$url="https://api.railwayapi.com/v2/live/train/".$t_no."/date/".$newdate."/apikey/zpa7xe2y3v/";
		    $data=file_get_contents($url);
		    $jssson = json_decode($data, true);
		    $i=0;
		    while(isset($jssson["route"][$i]["station"]["name"])){
		      $i++;
		    }
		    $max=$i-1;
		    $i=0;
		    while($jssson["route"][$i]["has_arrived"]){
		      $i++;
		    }
		    $dest=$i-1;
		    echo "<h4>You are searching for Train Number ".$jssson["train"]["number"]." - ".$jssson["train"]["name"].".</h4>" ;
		    echo "<h4>Current position : ".$jssson["position"]."</h4>";
		    $i=0;
		?>
			<table class="w3-table-all w3-hoverable ">
				<tr class="w3-green w3-large">
					<td>S. No.</td>
					<td>Station Name</td>
					<td>Arrival / Actual Arrival</td>
					<td>Departure / Actual Departure</td>
					<td>Distance</td>
					<td>Late / Early</td>
				</tr>

		<?php
		    while(isset($jssson["route"][$i]["station"]["name"])){
		    	echo "<tr><td>";
		    	echo $i+1;
		    	echo "</td><td>";
		      	echo ($jssson["route"][$i]["station"]["name"]);
		      	echo "</td><td>";
		      	
		      	if ($jssson["route"][$i]["scharr"]=='Source'){
		      		echo "Source";
		      	}
		      	else{
		      		echo ($jssson["route"][$i]["scharr"]." / ".$jssson["route"][$i]["actarr"]);
		      	}
		      	echo "</td><td>";

		      	if($jssson["route"][$i]["schdep"]=="Destination"){
		      		echo "Destination";
		      	}
		      	else{
		      		echo ($jssson["route"][$i]["schdep"]." / ".$jssson["route"][$i]["actdep"]);
		      	}
		      	echo "</td><td>";
		      	echo ($jssson["route"][$i]["distance"]." km");
		      	echo "</td><td>";
		      	if ($jssson["route"][$i]["latemin"] > 0 and ($jssson["route"][$i]["has_arrived"])){
		      		echo ("Train is late by ".$jssson["route"][$i]["latemin"]." minutes.");
		      	}
		      	elseif ($jssson["route"][$i]["latemin"] < 0){
		      		echo ("Train is running before by ".abs($jssson["route"][$i]["latemin"])." minutes.");
		      	}
		      	elseif ($jssson["route"][$i]["has_arrived"]){
		      		echo "Train is on right time.";
		      	}
		      	else{
		      		echo "Yet to arrive.";
		      	}
		      	echo "</td></tr>";
		      	$i++;
		    } 
		?>
			</table>
		</div>
	</body>
</html>