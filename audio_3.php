<?php
//Scans the given directory and generates links for audio files. Assumes the format: Title - Teacher - Day Date

//path to directory to scan
$directory = dirname(__FILE__) . '/audio';


//break it up into two lists, one for Friday and one for Sunday
$friday = array();
$sunday = array();
$unspecified = array();

if ($handle = opendir($directory)) {

    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {
    	if (strpos($entry,'Friday')) {
    		array_push($friday, $entry);
    	}
    	elseif (strpos($entry,'Sunday')) {
    		array_push($sunday, $entry);
    	}
    	else {
    		array_push($unspecified, $entry);
    	}
        //echo "<a href='audio/$entry'>$entry</a></br>";
    }

    closedir($handle);
}

echo "<h2>FRIDAYS:</h2></br>";

echo "<table class='tablesorter'><thead><tr><th>Title</th><th>Teacher</th><th>Date</th></tr></thead><tbody>";

// create table row - might blow up, if so something's probably badly formatted
foreach ($friday as $entry) {

	try {
		$split = explode('-', $entry);
		
		$title = $split[0];
		$teacher = $split[1];

		// get date
		$date = substr($entry, strpos($entry, 'Friday') +7);
		$date = str_replace('.mp3','',$date);

		echo "<tr><td><a href='audio/$entry'>$title</a></td><td>$teacher</td><td>$date</td></tr>";
	}
	catch (Exception $e) {
		echo "error: " + print_r($entry);
		echo $e;
	}

}

echo "</tbody></table>";
echo "<table class='tablesorter'><thead><tr><th>Title</th><th>Teacher</th><th>Date</th></tr></thead><tbody>";

echo "<h2>SUNDAYS:</h2></br>";
foreach ($sunday as $entry) {

	try {
		$split = explode('-', $entry);
		
		$title = $split[0];
		$teacher = $split[1];

		// get date
		$date = substr($entry, strpos($entry, 'Sunday') +7);
		$date = str_replace('.mp3','',$date);

		echo "<tr><td><a href='audio/$entry'>$title</a></td><td>$teacher</td><td>$date</td></tr>";
	}
	catch (Exception $e) {
		echo "error: " + print_r($entry);
		echo $e;
	}
}

echo "</tbody></table>";
echo "<table class='tablesorter'><thead><tr><th>Title</th><th>Teacher</th><th>Date</th></tr></thead><tbody>";

echo "<h2>UNSPECIFIED:</h2></br>";
foreach ($unspecified as $entry) {
	try {
		$split = explode('-', $entry);
		
		$title = $split[0];
		$teacher = $split[1];

		// get date
		$date = '';

		echo "<tr><td><a href='audio/$entry'>$title</a></td><td>$teacher</td><td>$date</td></tr>";
	}
	catch (Exception $e) {
		echo "error: " + print_r($entry);
		echo $e;
	}
}

echo "</tbody></table>";

?>

<html>
 <head>
  <title>Compile audio</title>
 </head>
 <body>
 </body>
</html>