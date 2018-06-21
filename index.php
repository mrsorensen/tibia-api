<?php
// Uncomment these for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'classes/TibiaCharacter.php';

if(isset($_POST['characterName'])){

	$character = new TibiaCharacter($_POST['characterName']);


}

?>
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
