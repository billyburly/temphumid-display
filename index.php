<?php

$dirs = scandir("dev");
$devs = array();
$dev = "";

foreach($dirs as $d) {
  if(preg_match("/(.+)\.rrd/", $d, $m))
    array_push($devs, $m[1]);
}

if(isset($_GET['dev'])) {
  $dev = $_GET['dev'];

  if(preg_match("/[^a-zA-Z0-9._-]/", $dev))
    die("invalid characters in device identifier!");

  if(!file_exists("dev/${dev}.rrd"))
    die("invalid device identifier!");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Temperature and Humidity</title>
  <script type="text/javascript">dev = "<?php print $dev; ?>";</script>
  <script src="http://code.jquery.com/jquery-1.5.2.min.js"></script>
  <script src="js/graphs.js"></script>
</head>

<body>
  <div style="text-align:center">
    <h1>Temperature and Humidity</h1>

<?php if(isset($_GET['dev'])){  ?>
    <h3>Last Day</h3>
    <img id="graph-day" src="getGraph.php?d&dev=<?php print $dev; ?>" alt="" />
    <h3>Last Week</h3>
    <img id="graph-week" src="getGraph.php?w&dev=<?php print $dev; ?>" alt="" />
    <h3>Last Month</h3>
    <img id="graph-month" src="getGraph.php?m&dev=<?php print $dev; ?>" alt="" />
<?php } ?>
    <br /><br />
    <select id="dev-chooser">
<?php 
$devSel = false;
foreach($devs as $d) {
  if($d == $dev) {
    print "      <option value=\"$d\" selected>$d</option>\n";
    $devSel = true;
  } else
    print "      <option value=\"$d\">$d</option>\n";
}
if(!$devSel)
  print "      <option value=\"\" selected></option>";
?>
    </select>
  </div>
</body>

</html>
