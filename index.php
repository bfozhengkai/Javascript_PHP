
<?php 
	ini_set('default_charset', 'utf-8');

	if(isset($_POST["keyword"])){
		
		if(isset($_POST["distance"]) && $_POST["distance"] != "") { 
			$radius = $_POST["distance"]*1609;
		}
		else {
			$radius = 10*1609;
		}
		
		
		$type = $_POST["category"];
		$keyword = $_POST["keyword"];
		$requestJson = "";
		$lat="";
		$lon="";
		if (isset($_POST["here"])){
			if(isset($_POST["locationinput"])) {
				$place = $_POST["locationinput"];

				$requestHere = "https://maps.googleapis.com/maps/api/geocode/json?address=".$place."&key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE";
				$here = str_replace(" ","+",$requestHere);
				$jsonFile = file_get_contents($here);
				$json = json_decode($jsonFile);
				$geo = $json->results[0]->{'geometry'}->{'location'};
				$lat2= $geo->{'lat'};
				$lon2 = $geo->{'lng'};
				$requestJson = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$lat2.",".$lon2."&radius=".$radius."&type=".$type."&keyword=".$keyword."&key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE";

			
			}

			else {
			$jsonFile = file_get_contents($_POST["here"]);
			$json = json_decode($jsonFile);
			$lat1 = $json->{'lat'};
			$lon1 = $json->{'lon'};
			$requestJson = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?location=".$lat1.",".$lon1."&radius=".$radius."&type=".$type."&keyword=".$keyword."&key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE";
			}
			
		}

			
		$request = str_replace(" ", "+", $requestJson);
		$jsonFileForNearby = file_get_contents($request);
		echo $jsonFileForNearby;
		return;
	}

	if(isset($_GET["here2"])) {
		
			$place = $_GET["here2"];
			$requestHere = "https://maps.googleapis.com/maps/api/geocode/json?address=".$place."&key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE";
			$here = str_replace(" ","+",$requestHere);
			$jsonFile = file_get_contents($here);
			echo $jsonFile;
			return;
		
	}



	if (isset($_GET["placeid"])) {
		$placeid = $_GET["placeid"];
		$requestJson = "https://maps.googleapis.com/maps/api/place/details/json?placeid=".$placeid."&key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE";
		$jsonFileForDetail = file_get_contents($requestJson);
		echo $jsonFileForDetail;
		return;
	}


	if (isset($_GET["photo_reference"]) && isset($_GET["photonum"])) {
		$photo_reference = $_GET["photo_reference"];
		$photonum = $_GET["photonum"];
		$requestPhoto = "https://maps.googleapis.com/maps/api/place/photo?maxwidth=750&photoreference=".$photo_reference."&key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE";
		$file = file_get_contents($requestPhoto);
		$filename = $photonum.".jpg";
		file_put_contents($filename, $file);
		return;
	}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>My Homework6</title>
</head>	
<style type="text/css">
	body {
		font-family: "Times New Roman",Georgia,Serif;
	}
	#content {
		margin-top: 20px;
		border: solid;
		width: 600px;
		margin-right: auto;
		margin-left: auto;
		border-color:#cccccc;
		background-color: #fafafa;

		
	}
	.head {
		text-align: center;
		font-family: "Times New Roman",Georgia,Serif;
		font-size: 1.9rem;
		font-weight: 500;

		margin-top:5px;
	}
	.line {
		width: 580px;
		margin-top: 5px;
		color: #cccccc;
		opacity: 0.8;
	}
	.keyword {
		margin-top: -2px;
		margin-left: 10px;
		line-height: 25px;

	}

	.inputlocation {


		padding-left: 308px;
	}


	.button {
		margin-top: -20px;
		margin-left: 66px;
		margin-bottom: 20px;
	}
	#map {
		
	}


	#table {
		margin-top: 10px;
		font-family: "Times New Roman",Georgia,Serif;
		margin-right: auto;
		margin-left: auto;
		z-index: 1;
		

	}
	#createTable {

		z-index: 1;
		width: 987px;
		margin-right: auto;
		margin-left: auto;
		
	}
	a {
		text-decoration: none;
		color:black;
	}
	table, th, td {
    border: 1px solid;
    border-color:#cccccc;
    border-collapse: collapse;
	}

	table {
		margin-right: auto;
		margin-left: auto;
	}

	th {
		text-align: center;
	}

	tr {
		text-align: left;
	}

	#header {
		text-align: center;
	}

	#intable {
		padding-left: 10px;
	}
	.nameClass {
		padding-left: 10px;
	}

	#error {
		margin-top: 20px;
		border: solid;
		width: 720px;
		text-align: center;
		margin-right: auto;
		margin-left: auto;
		border-color:#cccccc;
		background-color: #efefef;
	}

	#inlinked {
		 text-decoration: none;
		 color: black;
	}

	#detail {
		text-align: center;
		font-family: "Times New Roman",Georgia,Serif;
		font-size: 1.2rem ;
		
		margin-right: auto;
		margin-left: auto;

	}
	#arrow {
		height: 20px;
		width: 30px;
	}
	#detail1 {

		font-weight: 600;
	}
	#clickhere #showphoto {
		font-size: 0.6rem;
	}
	#reviewTable {
		width: 620px;
	}

	#phototable {
		min-height: 500px;
		min-width: 500px;
	}

	#fiveimage {
	  padding-top:15px; 
	  padding-left:15px; 
	  padding-right:15px; 
	  padding-bottom:15px; 
	}
	#notFound {
		border: solid;
		width: 700px;
		text-align: center;
		margin-right: auto;
		margin-left: auto;
		border-color:#cccccc;
	}
	#map {
        z-index: 4;
        height: 330px;
        width: 460px;
      }

      /* Optional: Makes the sample page fill the window. */
      #floating-panel {
        position: absolute;
        z-index: 5;
        width: 95px;
        text-align: center;
        background-color: #efefef;
        text-align: center;
      }
      #mapSelector1,#mapSelector2,#mapSelector3 {
        width: 95px;
        font-size: 1.2rem;
        padding-top: 8px;
        text-align: center;
        text-decoration: none;
        font-weight: 500;
        font-family: "Times New Roman",Georgia,Serif;
        color: black;
        display: block;
        height: 35px;
        
      }

       #mapSelector1:hover, #mapSelector2:hover, #mapSelector3:hover {
         background-color: #dcdcdc;
      }

      #mapLinked {
      	cursor:pointer;
      }
</style>


<body>
<div  id="content">
<div class = "head"><I> Travel and Entertainment Seaarch</I></div>
<hr class = "line">
	<form id="myForm" type="onsubmit" method="post" name="myForm" action="./index.php" onsubmit="return processJSON()">
		<div class="keyword">
		<b>Keyword</b><input id='keyword' type="text" name="keyword" size="20" style="margin-left:5px" required="required"><br>
		<b class="Category"> Category</b>
		<select id='category' name="category" style="margin-left: 5px">
			<option value="default">default</option>
			<option value="cafe">cafe</option>
			<option value="bakery">bakery</option>
			<option value="restaurant">restaurant</option>
			<option value="beauty_salon">beauty salon</option>
			<option value="casino">casino</option>
			<option value="movie_theater">movie theater</option>
			<option value="lodging">lodging</option>
			<option value="airport">airport</option>
			<option value="train_station">train station</option>
			<option value="subway_station">subway station</option>
			<option value="bus_station">bus station</option>
		</select>
		<br>

		<div style="float: left">
		<b class="distance">Distance (miles)</b><input id='distance' style="margin-left: 5px" type="text" name="distance" size="20" placeholder="10"><b style="margin-left: 5px">from</b>
	
		<label><input id="here" type="radio" name="here" value="http://ip-api.com/json" checked="checked" onclick="Send1()">
		Here</label><br>


		<label><div class="inputlocation">
		<input  type="radio" name="here" onclick="Send2()"><input id="location" type="text" name="locationinput" placeholder="location" required="required"></div></label>
		</div>
		</div>
		<br>
		<br>
		<br>
		<br>
		<div class="button">
			<input type="submit" id="submit" name="submit" value="Search" style="margin-top: 13px" onclick="sendHere(this.form)">

			<input type="reset" value="Clear" style="margin-top: 13px" onclick="clearPage()">
		</div>
	</form>
</div>
<div id="table"></div>
<div id="detail"></div>
<div id="here2" hidden="hidden"><div>
</body>
</html>

<script type="text/javascript">
Send1();
function clearPage() {
	document.getElementById('keyword').value="";
	document.getElementById('category').value="default";
	document.getElementById('category').options[0].selected = true;
	document.getElementById('distance').value = "10";
	document.getElementById('here').checked = "checked";
	document.getElementById("location").disabled = true;
	document.getElementById("location").value = "";
	document.getElementById('table').innerHTML = "";
	document.getElementById('detail').innerHTML = "";
}
function sendURL(url3) {
	if(window.XMLHttpRequest){
				xmlhttp = new XMLHttpRequest();
		}
		else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.open("GET",url3,false);
		xmlhttp.send(null);
		try {
			jsonDoc= JSON.parse(xmlhttp.responseText);
		}
		catch (e) {
			alert('Not Valid JSON Error.');
			throw "It's not valid Json file.";
		}
		if (xmlhttp.status==404) {
			alert('Not valid URL.');
			throw "No URL address.";
		}
	
	console.log("1");
	root = jsonDoc.DocumentElement;
	return jsonDoc;
}
function sendHere(form) {
	if (form.locationinput.value != "") {
		//document.getElementById('here2').innerHTML = form.locationinput.value;
		hereplace = form.locationinput.value;

		url3 = "./index.php?here2=";
		url3+=hereplace;
		console.log(url3);
		jsonDoc = sendURL(url3);
		latForStart = jsonDoc.results[0].geometry.location.lat;
		lngForStart = jsonDoc.results[0].geometry.location.lng;

	}
	else {
		document.getElementById('here2').innerHTML = "here";
		url3 ="http://ip-api.com/json";
		console.log(url3);
		jsonDoc = sendURL(url3);
		
		latForStart = jsonDoc.lat;
		lngForStart=jsonDoc.lon;
	}
	console.log(latForStart);
	console.log(lngForStart);

}


htmlCode="";
reviewInfo="";
function Send1() {
			document.getElementById("location").disabled = true;
			document.getElementById("location").value = "";
			//createTable();

		}

function Send2() {
			document.getElementById("location").disabled = false;
			document.getElementById("here").disabled = false;
		}
function processJSON() {
	
	url = "./index.php";
	if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
	}
	else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.open("POST",url,false);
	var form = document.getElementById('myForm');
	newform = new FormData(form);

	xmlhttp.send(newform);
	setTimeout(loadJSON(),2000);
	return false;
}

function loadJSON() {
	
	try {
			jsonDoc= JSON.parse(xmlhttp.responseText);
		}
	catch (e) {
		alert('Not Valid JSON Error.');
		throw "It's not valid Json file.";
	}
	if (xmlhttp.status==404) {
		alert('Not valid URL.');
		throw "No URL address.";
	}
	
	results = jsonDoc.results;
	if (!Array.isArray(results) || results.length == 0) {
		htmlCode = "<div id='error'> No Records has been found <div>";
	}
	else {
		console.log("1");
		root = jsonDoc.DocumentElement;

		htmlCode="<table id='createTable‘>";

			htmlCode+="<tr style='width:1012px'>";
			htmlCode+="<th id='header' style='width:100px'>Category</th>";
			htmlCode+="<th id='header' style='width:450px'>Name</th>";
			htmlCode+="<th id='header' style='width:460px'>Address</th>";
			htmlCode+="</tr>";


			results = jsonDoc.results;
			latForStart = parseFloat(latForStart);
     		lngForStart = parseFloat(lngForStart);

			for (i=0;i<results.length;i++) {
				var placeid = results[i].place_id;
				var latForDestination = results[i].geometry.location.lat;
				var lngForDestination = results[i].geometry.location.lng;
				htmlCode+="<tr>";
	 			htmlCode+="<td style='height=40px'>"+"<img src='"+ results[i].icon +"' width=50px height=30px>"+"</td>";

	 			htmlCode+="<td>"
	 			+"<a id='inlinked' style='height=10px' value='"+placeid+"' class='nameClass' href=\"javascript:createDetail(\'"+placeid+"\')\">"+results[i].name+"</a>"+"</td>";
	 			
	 			htmlCode+="<td id='intable' style='height=10px;'>"+"<div id='mapLinked' style='width=75px; height=10px' class='mapClass' onClick=\"javascript:createMap(\'"+i+"\',\'"+latForDestination+"\',\'"+lngForDestination+"\')\">"+results[i].vicinity+"</div>"+"<div id='mapId"+i+"' style='z-index=3; position:absolute; margin-top=10px' ></div>"+"</td>";
	 			
				htmlCode+="</tr>";
			}

		htmlCode+="</table>";

		}
	document.getElementById("table").innerHTML = htmlCode;	
}


function createDetail(val) {
	 
	
	url1= "./index.php?placeid=";
	url1= url1+val;
	if(window.XMLHttpRequest){
			xmlhttp = new XMLHttpRequest();
	}
	else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.open("GET",url1,false);
	xmlhttp.send(null);
	loadDetail();
	

}

function loadDetail() {
	try {
			jsonDoc= JSON.parse(xmlhttp.responseText);
		}
	catch (e) {
		alert('Not Valid JSON Error.');
		throw "It's not valid Json file.";
	}
	if (xmlhttp.status==404) {
		alert('Not valid URL.');
		throw "No URL address.";
	}
	
	result = jsonDoc.result;
	console.log("1");
	root = jsonDoc.DocumentElement;

	
	if (!Array.isArray(jsonDoc.result.reviews) || jsonDoc.result.reviews.length == 0) {
		htmlCode="<div id='detail1'>";
		htmlCode+=jsonDoc.result.name;
		htmlCode+="</div>";
		htmlCode+="<br>";
		htmlCode+="<br>";
		htmlCode+="<a id='clickhere' href=\"javascript:showNoViewer()\">";
		htmlCode+="click to show reviews";
		htmlCode+="<br>";
		htmlCode+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png'>";
		htmlCode+="</a>";
	}
	else {
		htmlCode="<div id='detail1'>";
		htmlCode+=jsonDoc.result.name;
		htmlCode+="</div>";
		htmlCode+="<br>";
		htmlCode+="<br>";
		htmlCode+="<a id='clickhere' href=\"javascript:showReviews()\">";
		htmlCode+="click to show reviews";
		htmlCode+="<br>";
		htmlCode+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png'>";
		htmlCode+="</a>";
	}
		htmlCode+="<br>";
	if (!Array.isArray(jsonDoc.result.photos) || jsonDoc.result.photos.length == 0) {
		htmlCode+="<a id='showphoto' href=\"javascript:showNoPhoto()\">";
		htmlCode+="click to show photos"
		htmlCode+="<br>";
		htmlCode+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png'>";
		htmlCode+="</a>";
	}
	else {
		htmlCode+="<a id='showphoto' href=\"javascript:showPhotos()\">";
		htmlCode+="click to show photos"
		htmlCode+="<br>";
		htmlCode+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png'>";
		htmlCode+="</a>";
	}	
	document.getElementById("table").innerHTML = "";
	document.getElementById("detail").innerHTML = htmlCode;	

	photo = jsonDoc.result.photos;
	photolen = photo.length;
	review = jsonDoc.result.reviews;
	len = review.length;
	
	if (photolen>5) {
		photolen=5;
	}
	for (j=0;j<photolen;j++) {
		var url2 = "./index.php?photo_reference=";
		url2+= photo[j].photo_reference;
		url2+="&photonum=";
		url2+=j;
		if(window.XMLHttpRequest){
				xmlhttp = new XMLHttpRequest();
		}
		else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		xmlhttp.open("GET",url2,false);
		xmlhttp.send(null);
	}
	
}

function showReviews() {
	hidePhotos();
	if (!Array.isArray(jsonDoc.result.reviews) || jsonDoc.result.reviews.length == 0) {
		showNoViewer();
	}
	else {
	reviewInfo ="<a id='clickhere' href=\"javascript:hideReviews()\">";
	reviewInfo+="click to hide reviews";
	reviewInfo+="<br>";
	reviewInfo+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png'>";
	reviewInfo+="</a>";
	}

	var len = jsonDoc.result.reviews.length;
	var reviews = jsonDoc.result.reviews;
	reviewInfo+="<table id='reviewTable'>";
	if (len>5) {
		len=5;
	}
	for (i=0;i<len;i++) {
		reviewInfo+="<tr>";
		reviewInfo+="<th style='height: 40px'>";
		reviewInfo+="<div><img id='arrow' src='"+reviews[i].profile_photo_url+"'>";
		reviewInfo+=reviews[i].author_name+"</div>";
		reviewInfo+="</th>";
		reviewInfo+="</tr>";
		reviewInfo+="<tr>";
		reviewInfo+="<td>";
		reviewInfo+=reviews[i].text;
		reviewInfo+="</td>";
		reviewInfo+="</tr>";
		
		
	}
	reviewInfo+="</table>";
	
	document.getElementById("clickhere").innerHTML = reviewInfo;
	return;
}

function hideReviews() {
	if (!Array.isArray(jsonDoc.result.reviews) || jsonDoc.result.reviews.length == 0) {
		reviewInfo ="<a id='clickhere' href=\"javascript:showNoViewer()\">";
		reviewInfo+="click to show reviews";
		reviewInfo+="<br>";
		reviewInfo+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png'>";
		reviewInfo+="</a>";
	}
	else {
	reviewInfo ="<a id='clickhere' href=\"javascript:showReviews()\">";
	reviewInfo+="click to show reviews";
	reviewInfo+="<br>";
	reviewInfo+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png'>";
	reviewInfo+="</a>";
	
	}
	document.getElementById("clickhere").innerHTML = reviewInfo;
}

function showPhotos() {
	hideReviews();
	if (!Array.isArray(jsonDoc.result.photos) || jsonDoc.result.photos.length == 0) {
		showNoPhoto();
	}
	else {
	photoInfo ="<a id='showphoto' href=\"javascript:hidePhotos()\">";
	photoInfo+="click to hide photos";
	photoInfo+="<br>";
	photoInfo+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png'>";
	photoInfo+="</a>";
	}

	var photo = jsonDoc.result.photos;
	var photolen = photo.length;
	
	if (photolen>5) {
		photolen=5;
	}

	photoInfo+="<table id='reviewTable'>";

	for (i=0;i<photolen;i++) {
		var photoname = "./"+i+".jpg";
		photoInfo+="<tr id='phototable'>";
		photoInfo+="<td id='fiveimage' style='text-align:center; min-height: 500px'>";
		photoInfo+="<a id='showphoto' href=\""+photoname+"?"+Math.random()+"\">";
		photoInfo+="<img  src=\""+photoname+"\" style='width: 580px; height: 430px'>";
		photoInfo+="</a>";
		photoInfo+="</td>";
		photoInfo+="</tr>";
		
		
	}
	photoInfo+="</table>";
	
	document.getElementById("showphoto").innerHTML = photoInfo;
}
function hidePhotos() {
	if (!Array.isArray(jsonDoc.result.photos) || jsonDoc.result.photos.length == 0) {
		photoInfo ="<a id='showphoto' href=\"javascript:showNoPhoto()\">";
		photoInfo+="click to show photos";
		photoInfo+="<br>";
		photoInfo+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png'>";
		photoInfo+="</a>";
	}
	else {
	photoInfo ="<a id='showphoto' href=\"javascript:showPhotos()\">";
	photoInfo+="click to show photos";
	photoInfo+="<br>";
	photoInfo+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png'>";
	photoInfo+="</a>";
	}
	document.getElementById("showphoto").innerHTML = photoInfo;
}

function showNoViewer() {
	reviewInfo ="<a id='clickhere' href=\"javascript:hideReviews()\">";
	reviewInfo+="click to hide reviews";
	reviewInfo+="<br>";
	reviewInfo+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png'>";
	reviewInfo+="</a>";
	reviewInfo+="<br>";
	reviewInfo+="<div id='notFound'> No Reviews Found <div>";
	document.getElementById("clickhere").innerHTML = reviewInfo;
}

function showNoPhoto() {
	photoInfo ="<a id='showphoto' href=\"javascript:hidePhotos()\">";
	photoInfo+="click to hide photos";
	photoInfo+="<br>";
	photoInfo+="<img id='arrow' src='http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png'>";
	photoInfo+="</a>";
	photoInfo+="<br>";
	photoInfo+="<div id='notFound'> No Photos Found <div>";
	document.getElementById("showphoto").innerHTML = photoInfo;
}
function createMap(i, lati,lonti) {
	mapCode = "<div id='floating-panel'></div><div id=\"map\"></div>";
	currTag = "mapId"+i;
	currentTag = document.getElementById(currTag);
	
	if (currentTag.style.display == "block") {
		currentTag.innerHTML = "";
		currentTag.style.display = "none";
		 
		
	}
	else {
		currentTag.innerHTML = mapCode;
		func(lati,lonti);
		currentTag.style.display = "block";
	}
	

}
mode="";

function func(lati, lonti) {

     lati = parseFloat(lati);
     lonti = parseFloat(lonti);

     maphtml="<a  id='mapSelector1' href=\"javascript:initMap(\'WALKING\',\'"+lati+"\',\'"+lonti+"\')\" type=\"button\" id='mode' value=\"WALKING\" style=\"border:0;cursor: pointer\">Walk there</a>";
     maphtml+="<a id='mapSelector2' href=\"javascript:initMap(\'BICYCLING\',\'"+lati+"\',\'"+lonti+"\')\" type=\"button\" id=\'mode\' value=\"BICYCLING\" style=\"border:0;cursor: pointer\">Bike there</a>";
     maphtml+="<a id=\"mapSelector3\" href=\"javascript:initMap(\'DRIVING\',\'"+lati+"\',\'"+lonti+"\')\" type=\"button\" id=\'mode\' value=\"DRIVING\" style=\"border:0;cursor: pointer\" >Drive there</a>";
       map = document.getElementById("map");
       pannel = document.getElementById("floating-panel");
       pannel.innerHTML = maphtml;
       initMap1(lati, lonti);
      if(map.style.display == "block"){
         currentTag.style.display = "none";
         pannel.style.display = "none";
          map.style.display = "none";
        }
      else{
        
        
        currentTag.style.display="block";  
        map.style.display = "block";
        pannel.style.display = "block";
        
        }

 }
function initMap1(lati, lonti) {
        var uluru = {lat: 0, lng: 0};
        uluru["lat"] = lati;
        uluru["lng"] = lonti;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 15,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }

function initMap(val, lati, lonti) {
        mode  = val;
        lati = parseFloat(lati);
     	lonti = parseFloat(lonti);
        var center = {lat:0,lng:0};
        center["lat"] = latForStart;
        center["lng"] = lngForStart;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var directionsService = new google.maps.DirectionsService;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 14,
          center: center
        });
        directionsDisplay.setMap(map);

        calculateAndDisplayRoute(directionsService, directionsDisplay, lati, lonti);
        document.getElementById('mode').addEventListener('change', function() {
          calculateAndDisplayRoute(directionsService, directionsDisplay, lati, lonti);
        });
}


function calculateAndDisplayRoute(directionsService, directionsDisplay, lati, lonti) {
        var selectedMode = mode;
        var start = {lat: 0, lng:0};
        start["lat"] = latForStart;
        start["lng"] = lngForStart;
        var end = {lat: 0, lng: 0};
        end["lat"] = lati;
        end["lng"] = lonti;
        directionsService.route({
          origin: start,  // Haight.
          destination: end,  // Ocean Beach.
          // Note that Javascript allows us to access the constant
          // using square brackets and a string value as its
          // "property."
          travelMode: google.maps.TravelMode[selectedMode]
        }, function(response, status) {
          if (status == 'OK') {
            directionsDisplay.setDirections(response);
          } else {
            window.alert('Directions request failed due to ' + status);
          }
        });
}

</script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE">
 </script>

<!-- https://maps.googleapis.com/maps/api/geocode/json?address=University+of+Southern+California+CAZ&key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE -->
<!-- https://maps.googleapis.com/maps/api/geocode/json?address=University+of+Southern+California+CA&key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE -->
<!-- https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJ7aVxnOTHw
oARxKIntFtakKo&key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE --> 
<!-- http://cs-server.usc.edu:45678/hw/hw6/images/arrow_up.png
http://cs-server.usc.edu:45678/hw/hw6/images/arrow_down.png -->
<!-- https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJ7aVxnOTHw
oARxKIntFtakKo&key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE -->
<!-- https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJ7aVxnOTHw
oARxKIntFtakKo&key=AIzaSyB5HpnNpiDMGXftWGmx0Fg6bfPJDfJ_WPE -->
