<?php

if(!isset($_GET['dev']))
  die();

$dev = $_GET['dev'];

if(preg_match("/[^a-zA-Z0-9._-]/", $dev))
  die();

if(!file_exists("dev/${dev}.rrd"))
  die();


$ts = "d";

if(isset($_GET['d']))
  $ts = "d";
else if(isset($_GET['w']))
  $ts = "w";
else if(isset($_GET['m']))
  $ts = "m";
else
  die();

$dir = "/srv/http/temp-humid";
$rrd = "$dir/dev/${dev}.rrd";
$img = "$dir/img/${dev}.$ts.png";

if(!file_exists($rrd))
  die();

$opts = array("--start", "-1$ts", "--vertical-label=Temperature F / % Humidity",  "--width=600", "--height=200",
	      "DEF:temp=$rrd:temperature:AVERAGE",
	      "DEF:humid=$rrd:humidity:AVERAGE",
	      "AREA:humid#ccccff",
	      "LINE1:humid#5555ff:Humidity\\r",
	      "LINE2:temp#ee2200:Temperature F",
	      "COMMENT:\\r",
	      "GPRINT:temp:LAST:Tempature \: %6.2lf %S F",
	      "GPRINT:humid:LAST:Humidity \: %6.2lf %S %%\\r");

$ret = true;
if(file_exists($img)) {
  if(time() - filemtime($img) > 300)
    //$ret = rrd_graph($img, $opts, count($opts));
    $ret = rrd_graph($img, $opts);
}
else
  $ret = rrd_graph($img, $opts);

if(!$ret)
  print rrd_error();
else {
  $file = fopen($img, 'r');
  if($file !== false) {
    header('Content-Type: image/png');
    fpassthru($file);
  }
}

?>