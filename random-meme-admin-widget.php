<?php
/*
Plugin Name: Random Meme Dashboard Widget
Plugin URI: http://www.adriangrant.org
Description: Adds a widget to the admin dashboard showcasing a random meme.
Author: Adrian Grant
Version: 0.1
Author URI: http://www.adriangrant.org
 */


function memeofday_dashboard_widget()
{
	// *******************************
	// Proccess Memegenerator.com API
	// *******************************
	$url = "http://version1.api.memegenerator.net/Instances_Select_ByPopular?languageCode=en&pageIndex=0&pageSize=12&days=1";

	//  Initiate curl
	$ch = curl_init();
	// Disable SSL verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL,$url);
	// Execute
	$result=curl_exec($ch);
	// Closing
	curl_close($ch);

	// Get Array from JSON
	$array = json_decode($result, true);

	$randomNumber = rand(1, 10);

	// Display JSON on screen
	// print_r($array);  

	$imgURL = $array["result"][$randomNumber /* thread id */]["instanceImageUrl"/* thread key */];
	$instanceUrl = $array["result"][$randomNumber /* thread id */]["instanceUrl"/* thread key */];

	?>
<style type="text/css">
	#randommeme-dashboard-widget img {
		margin: 30px;
		display: block;
		    margin-left: auto;
		    margin-right: auto;
		-webkit-box-shadow:
		  		0px 0px 0px 2px rgba(0,0,0,0.6),
		              0px 0px 0px 14px #fff,
		              0px 0px 0px 18px rgba(0,0,0,0.2),
		              6px 6px 8px 17px #555;
		
		   -moz-box-shadow:
		  		0px 0px 0px 2px rgba(0,0,0,0.6),
		              0px 0px 0px 14px #fff,
		              0px 0px 0px 18px rgba(0,0,0,0.2),
		              6px 6px 8px 17px #555;
		
		        box-shadow:
		  		0px 0px 0px 2px rgba(0,0,0,0.6),
		              0px 0px 0px 14px #fff,
		              0px 0px 0px 18px rgba(0,0,0,0.2),
		              6px 6px 8px 17px #555;

	}
</style>

	<a href="<?php echo $instanceUrl; ?>" target="_blank" title="Open in New Window" >
	<img src="<?php echo $imgURL; ?>" align="center" >
	</a>
	<?php 
}

function sdbw_register_widget()
{
	wp_add_dashboard_widget('randommeme-dashboard-widget','Random Meme', 'memeofday_dashboard_widget');
}

add_action('wp_dashboard_setup', 'sdbw_register_widget');
