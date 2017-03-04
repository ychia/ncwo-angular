<?php
//Scans the given directory and generates links for audio files. Assumes the format: Title - Teacher - Day Date

//path to directory to scan
$directory = dirname(__FILE__) . '/audio';

//archived audio - goes to S3
$directory_archive = dirname(__FILE__) . '/audio/archive';

//disable error/warning/notices
error_reporting(0);
@ini_set('display_errors', 0);

//break it up into two lists, one for Friday and one for Sunday
$friday = array();
$sunday = array();
$soc = array();
$other = array();

// archived for Amazon S3
$friday_arch = array();
$sunday_arch = array();
$soc_arch = array();

echo '<script type="text/javascript" src="js/jquery.min.js"></script>';
echo '<script type="text/javascript" src="js/__jquery.tablesorter/jquery.tablesorter.min.js"></script>';
echo '<script>$(document).ready(function() { $("#table_fridays").tablesorter( {sortList: [[3,1]]} );  $("#table_sundays").tablesorter( {sortList: [[3,1]]} ); $("#table_soc").tablesorter( {sortList: [[3,1]]} ); } );</script>';

if ($handle = opendir($directory)) {

    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {

    	if (strpos($entry,'Sunday') > -1) {
    		array_push($sunday, $entry);
    	}
    	elseif (strpos($entry,'SOC') > -1) {
    		array_push($soc, $entry);
    	}
      elseif (strpos($entry, 'Friday') > -1) {
        array_push($friday, $entry);
      }
      else {
        // for now, lump in others with Friday
        array_push($friday, $entry);
      }

        //echo "<a href='audio/$entry'>$entry</a></br>";
    }

    closedir($handle);
}

if ($handle = opendir($directory_archive)) {

    /* This is the correct way to loop over the directory. */
    while (false !== ($entry = readdir($handle))) {

      if (strpos($entry,'Sunday') > -1) {
        array_push($sunday_arch, $entry);
      }
      elseif (strpos($entry,'SOC') > -1) {
        array_push($soc_arch, $entry);
      }
      elseif (strpos($entry, 'Friday') > -1) {
        array_push($friday_arch, $entry);
      }
      else {
        // for now, lump in others with Friday
        array_push($friday_arch, $entry);
      }

        //echo "<a href='audio/$entry'>$entry</a></br>";
    }

    closedir($handle);
}

$fridays_html = "<table id='table_fridays'><thead><tr><th>Title (click to play)</th><th>Download (right-click and save target/link as)</th><th>Teacher</th><th>Date</th></tr></thead><tbody>";

// create table row - might blow up, if so something's probably badly formatted
foreach ($friday as $entry) {

	try {
		$split = explode('-', $entry);
		
		$title = $split[0];
		$teacher = $split[1];

    if (!$teacher) {
      continue;
    }

		// get date
		$date = substr($entry, strpos($entry, 'day') +4);
		$date = str_replace('.mp3','',$date);

		$fridays_html .= '<tr><td><a href="javascript:void(0);" onclick="playTrack(\'audio/'.$entry.'\')">'.$title.'</a></td><td><a href="audio/'.$entry.'">Download</a></td><td>'.$teacher.'</td><td>'.$date.'</td></tr>';
 	}
	catch (Exception $e) {
		$fridays_html .= "error: " + print_r($entry);
		$fridays_html .= $e;
	}

}

foreach ($friday_arch as $entry) {

  try {
    $split = explode('-', $entry);
    
    $title = $split[0];
    $teacher = $split[1];

    if (!$teacher) {
      continue;
    }

    // get date
    $date = substr($entry, strpos($entry, 'day') +4);
    $date = str_replace('.mp3','',$date);

     // link to S3
    $entry = str_replace(' ','+',$entry);
    $entry = 'https://s3-us-west-2.amazonaws.com/newcovenantchristiancentersanjose/' . $entry;

    $fridays_html .= '<tr><td><a href="javascript:void(0);" onclick="playTrack(\''.$entry.'\')">'.$title.'</a></td><td><a href="'.$entry.'">Download</a></td><td>'.$teacher.'</td><td>'.$date.'</td></tr>';
  }
  catch (Exception $e) {
    echo "error: " + print_r($entry);
    echo $e;
  }

}

$fridays_html .= "</tbody></table>";

// write to fridays.html
file_put_contents('friday.html', $fridays_html);
echo($fridays_html);

$sundays_html = "<table id='table_sundays'><thead><tr><th>Title (click to play)</th><th>Download (right-click and save target/link as)</th><th>Teacher</th><th>Date</th></tr></thead><tbody>";

foreach ($sunday as $entry) {

	try {
		$split = explode('-', $entry);
		
		$title = $split[0];
		$teacher = $split[1];

    if (!$teacher) {
      continue;
    }

		// get date
		$date = substr($entry, strpos($entry, 'day') +4);
		$date = str_replace('.mp3','',$date);

	  $sundays_html .= '<tr><td><a href="javascript:void(0);" onclick="playTrack(\'audio/'.$entry.'\')">'.$title.'</a></td><td><a href="audio/'.$entry.'">Download</a></td><td>'.$teacher.'</td><td>'.$date.'</td></tr>';
 	}
	catch (Exception $e) {
		echo "error: " + print_r($entry);
		echo $e;
	}
}

foreach ($sunday_arch as $entry) {

  try {
    $split = explode('-', $entry);
    
    $title = $split[0];
    $teacher = $split[1];

    if (!$teacher) {
      continue;
    }

    // get date
    $date = substr($entry, strpos($entry, 'day') +4);
    $date = str_replace('.mp3','',$date);

     // link to S3
    $entry = str_replace(' ','+',$entry);
    $entry = 'https://s3-us-west-2.amazonaws.com/newcovenantchristiancentersanjose/' . $entry;

    $sundays_html .= '<tr><td><a href="javascript:void(0);" onclick="playTrack(\''.$entry.'\')">'.$title.'</a></td><td><a href="'.$entry.'">Download</a></td><td>'.$teacher.'</td><td>'.$date.'</td></tr>';
  }
  catch (Exception $e) {
    echo "error: " + print_r($entry);
    echo $e;
  }
}


$sundays_html .= "</tbody></table>";

//write to sunday.html
file_put_contents('sunday.html', $sundays_html);
echo($sundays_html);


$socs_html = "<table id='table_soc'><thead><tr><th>Title (click to play)</th><th>Download (right-click and save target/link as)</th><th>Teacher</th><th>Date</th></tr></thead><tbody>";

foreach ($soc as $entry) {

  try {
    $split = explode('-', $entry);
    
    $title = $split[0];
    $teacher = $split[1];

    if (!$teacher) {
      continue;
    }

    // get date
    $date = substr($entry, strpos($entry, 'day') +4);
    $date = str_replace('.mp3','',$date);

    $socs_html .= '<tr><td><a href="javascript:void(0);" onclick="playTrack(\'audio/'.$entry.'\')">'.$title.'</a></td><td><a href="audio/'.$entry.'">Download</a></td><td>'.$teacher.'</td><td>'.$date.'</td></tr>';
  }
  catch (Exception $e) {
    echo "error: " + print_r($entry);
    echo $e;
  }
}
foreach ($soc_arch as $entry) {

  try {
    $split = explode('-', $entry);
    
    $title = $split[0];
    $teacher = $split[1];

    if (!$teacher) {
      continue;
    }

    // get date
    $date = substr($entry, strpos($entry, 'day') +4);
    $date = str_replace('.mp3','',$date);

   // link to S3
    $entry = str_replace(' ','+',$entry);
    $entry = 'https://s3-us-west-2.amazonaws.com/newcovenantchristiancentersanjose/' . $entry;

    $socs_html .= '<tr><td><a href="javascript:void(0);" onclick="playTrack(\''.$entry.'\')">'.$title.'</a></td><td><a href="'.$entry.'">Download</a></td><td>'.$teacher.'</td><td>'.$date.'</td></tr>';
  }
  catch (Exception $e) {
    echo "error: " + print_r($entry);
    echo $e;
  }
}

$socs_html .= "</tbody></table>";

//write to soc.html
file_put_contents('soc_audio.html', $socs_html);
echo($socs_html);


/*echo "<table id='table_other'><thead><tr><th>Title (click to play)</th><th>Download (right-click and save target/link as)</th><th>Teacher</th><th>Date</th></tr></thead><tbody>";

echo "<h2>Other:</h2></br>";
foreach ($other as $entry) {

  try {
    $split = explode('-', $entry);
    
    $title = $split[0];
    $teacher = $split[1];

    if (!$teacher) {
      continue;
    }

    // get date
    $date = substr($entry, strpos($entry, 'day') +4);
    $date = str_replace('.mp3','',$date);

    echo '<tr><td><a href="javascript:void(0);" onclick="playTrack(\'audio/'.$entry.'\')">'.$title.'</a></td><td><a href="audio/'.$entry.'">Download</a></td><td>'.$teacher.'</td><td>'.$date.'</td></tr>';
  }
  catch (Exception $e) {
    echo "error: " + print_r($entry);
    echo $e;
  }
}

echo "</tbody></table>";*/


?>

<html>
 <head>
  <title>Compile audio</title>
 </head>
 <body>
 </body>
</html>