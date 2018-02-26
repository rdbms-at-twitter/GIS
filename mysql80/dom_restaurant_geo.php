<?php

require("phpsqlajax_dbinfo.php");

// PHP の DOM 関数を使用して XML を出力
// Start XML file, create parent node

$dom = new DOMDocument("1.0", "UTF-8");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection=mysql_connect ('127.0.0.1', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Set the active MySQL database

$db_selected = mysql_select_db($database, $connection);
mysql_query("SET NAMES 'utf8mb4'", $connection);

if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

// Select all the rows in the markers table

$query = "select nodetags.v as 'name',st_latfromgeohash(st_geohash((nodes.geom),8)) as 'lat', st_longfromgeohash(st_geohash((nodes.geom),8)) as 'lng','restaurant' as 'type' FROM nodes,nodetags WHERE nodes.id = nodetags.id and match(tags) against ('+restaurant' IN BOOLEAN MODE) and nodetags.k='name' and nodes.GeoHash5 = 'xn76g' limit 30";
$result = mysql_query($query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}

header("Content-type: text/xml; charset=utf-8");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", $row['type']);
}

echo $dom->saveXML();

?>
