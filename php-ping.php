<!DOCTYPE html>
<html>
<body>
<h1>PHP-Ping</h1>

<table border="1" cellspacing="0" cellpadding="5" width='100%'>
<?php

$cols="4";
$file = fopen("php-ping.txt", "r");
$i = 0;
$line_of_text = '';
while (!feof($file)) {
  $line_of_text .= fgets($file);
}
$servers = explode("\n", $line_of_text);
fclose($file);
$remove = array_pop($servers);
# print_r($servers);
# $servers = array(
#    'Google' => 'www.google.com',
#    'Apple' => 'www.apple.com',
#    'Yahoo' => 'www.yahoo.com',
#    'Local Server' => '192.168.1.1', // Example local IP
#);


$j = 0;
foreach ($servers as $name => $ip) {
    $status = 'down';
    $output = null;
    $return_var = null;

    // Use escapeshellarg() for security
    $safe_ip = escapeshellarg($ip);

    // Determine OS-specific ping command (Linux/macOS uses -c, Windows uses -n)
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $command = "ping -n 1 " . $safe_ip;
    } else {
        $command = "ping -c 1 " . $safe_ip;
    }

    exec($command, $output, $return_var);

    if ($return_var == 0) {
        $status = 'up';
    }

    if ( $status == "up" ) {
	    $bkcolor = "#00ff00";
	    $fgcolor = "#000000";
    }
    else {
	    $bkcolor = "#ff0000";
	    $fgcolor = "#ffffff";
    } 
    // Display status (you can style this with CSS)
      if ( $j == "0" ) {
	      print '<tr>';
      } 
      else {
	      print '<td> &nbsp; </td>';
      }
      print '<td bgcolor=' . $bkcolor . '><font color= '. $fgcolor .'>' . htmlspecialchars($ip) . '</font></td>';
      if ( $j == $cols ) {
	      print '</tr>';
	      $j = 0;
      } 
      else {
	 $j = $j + 1;
      }
}

?>
</table>
&nbsp;<br/>
<hr>
<?php
date_default_timezone_set('America/New_York');
$date = new DateTime();
print '<font size="-1">Last Modified: ';
	echo $date->format('Y-m-d H:i:s');
print '</font>';
?>
</body>
</html>
