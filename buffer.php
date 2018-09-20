<?php
    if(!strlen($_GET['t_no'])){
        header("location: index.php");
    }
    else{
?>
<html>
	<head>
	    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-9757289779386871",
            enable_page_level_ads: true
          });
        </script>
		<title> Buffer </title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	</head>
	<body>
		<header class="w3-container w3-teal w3-center">
          <h1>Xsonic Rail Tracking</h1>
        </header>
        <div class="w3-container">
		<?php 
			$t_no= $_GET['t_no'];
			$date = $_GET['date'];
			$year= substr($date,0,4);
			$month= substr($date,5,2);
			$day= substr($date,8,2);
			$newdate = $day."-".$month."-".$year;
			$url="https://api.railwayapi.com/v2/live/train/".$t_no."/date/".$newdate."/apikey/----------/";
		    $data=file_get_contents($url);
		    $jssson = json_decode($data, true);
		    $response = array(200=>"Success", 210=>"Train doesn’t run on the date queried", 211=>"Train doesn’t have journey class queried", 220=>"Flushed PNR", 221=>"Invalid PNR", 230=> "Date chosen for the query is not valid for the chosen parameters", 404=>"Data couldn’t be loaded on our servers. No data available.", 405=> "Data couldn't be loaded on our servers. Request couldn't go through.", 500=> "Unauthorised API key", 501 =>"Contact mayankgbrc@gmail.com", 502=> "Invalid arguments passed, may be you entered in back date");
		    $res = $jssson["response_code"];
		    if ($res==200){
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
			    echo "<h5>You are searching for Train: ".$jssson["train"]["number"]." - ".$jssson["train"]["name"].".</h5>" ;
			    echo "<h5>Current position : ".$jssson["position"]."</h5>";
			    $i=0;
		?>
		</div>
			<table class="w3-table-all w3-hoverable w3-hide-small">
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
			      		echo ("<span class=w3-text-red>Train is late by ".$jssson["route"][$i]["latemin"]." minutes.");
			      	}
			      	elseif ($jssson["route"][$i]["latemin"] < 0){
			      		echo ("<span class=w3-text-green>Train is running before by ".abs($jssson["route"][$i]["latemin"])." minutes.");
			      	}
			      	elseif ($jssson["route"][$i]["has_arrived"]){
			      		echo "<span class=w3-text-purple>Train is on right time.";
			      	}
			      	else{
			      		echo "<span class=w3-text-grey>Yet to arrive.";
			      	}
			      	echo "</span></td></tr>";
			      	$i++;
			    }
			    echo "</table></div>";
			    $i =0;
			    ?>
			<table class="w3-table-all w3-hoverable w3-hide-large">
				<tr class="w3-green w3-large">
					<b><td>S.No.<br>Dist.</td>
					<td>Station Name<br>Late / Early</td>
					<td>Sch/Act Arrival</td>
					<td>Sch/Act Depart</td></b>
				</tr>

		<?php
			    while(isset($jssson["route"][$i]["station"]["name"])){
			    	echo "<tr><td>";
			    	echo $i+1;
			    	echo (".<br>".$jssson["route"][$i]["distance"]." km");
			    	echo "</td><td>";
			      	echo ($jssson["route"][$i]["station"]["name"]."<br>");
			      	if ($jssson["route"][$i]["latemin"] > 0 and ($jssson["route"][$i]["has_arrived"])){
			      		echo ("<span class=w3-text-red>Late by ".$jssson["route"][$i]["latemin"]." minutes.");
			      	}
			      	elseif ($jssson["route"][$i]["latemin"] < 0){
			      		echo ("<span class=w3-text-green>Early by ".abs($jssson["route"][$i]["latemin"])." minutes.");
			      	}
			      	elseif ($jssson["route"][$i]["has_arrived"]){
			      		echo "<span class=w3-text-purple>Right time";
			      	}
			      	else{
			      		echo "<span class=w3-text-grey>Yet to arrive.";
			      	}
			      	echo "</span></td><td>";
			      	
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
			      	echo "</td></tr>";
			      	$i++;
			    }
			    echo "</table>";
			    ?>
			    <?php
		    }
		    else{
		        echo $response[$res];
		    }
		?>
		<br><br>
		<footer class="w3-container w3-teal w3-center" style="position:fixed;bottom:0;left:0;width:100%;">
          <h4>Developed with <span class="w3-text-red">&hearts;</span> by <a href="https://www.facebook.com/mayankgbrc" target="_blank">Mayank Gupta</a> </h4>
        </footer>
	</body>
</html>
<?php
    }
?>
