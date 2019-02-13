<?php

// Include the TibiaCharacter class file
include 'classes/TibiaCharacter.php';

// Construct the TibiaCharacter class if there was an input from the search form
if(isset($_POST['characterName'])){

	$character = new TibiaCharacter($_POST['characterName']);


}

?>
<!doctype html>
<head>
<title>Tibia Character API</title>
<style type="text/css" media="all">
	html {
		font-family:"cantarell";
	}	
	
</style>
</head>
<body>
	
<div style="text-align:center;">
	
	<h1>Check Tibia characters online status</h1>
	
	<form method="post">
	<input type="text" name="characterName" placeholder="Enter a tibia characters name" autofocus>
	<input type="submit" value="Search"> 
	</form>
		
</div>

<div style="text-align:center;">
<?php

if(isset($character)){
	echo '<pre>';
	print_r($character);
	echo '</pre>';
}
?>
</div>
</body>
</html>
