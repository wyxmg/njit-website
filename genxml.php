<?php

//this file generates xml from the PHP, which then is used to power the main page. I did it because I wanted to learn
//no idea if it's the most efficient way

//this functions helps clean the inputs, preventing SQL injection. Might need more to be added
function parseToXML($htmlStr)
{
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','&quot;',$xmlStr);
	$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return $xmlStr;
}

require('dbconnect.php');

$query = "SELECT * FROM mt1 WHERE 1";
$result = $connection->query($query);
if (!$result) {
	die('Invalid query: ' . mysqli_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// go through rows, printing a node for each
if ($result->num_rows > 0)
{
	while ($row = $result->fetch_assoc())
	{
		echo '<marker ';
		echo 'id ="' . $row['id'] . '" ';
		echo 'name="' . parseToXML($row['name']) . '" ';
		echo 'address="' . parseToXML($row['address']) . '" ';
		echo 'lat="' . $row['lat'] . '" ';
		echo 'lng="' . $row['lng'] . '" ';
		echo 'type="' . $row['type'] . '" ';
		echo '/>';
	}
}

//here's where it gets a little tricky. See, I tried to make it into one xml file, with success, but it's a little funky
//it goes like this:
//<markers>
//<marker...>
//<reviews>
//<review...>
//</reviews>
//</markers>
//no idea how gross that looks to an actual programmer, but I'm sorry in advance


$query = "SELECT * FROM mr1 WHERE 1";
$result = $connection->query($query);
if (!$result) {
	die('Invalid query: ' . mysqli_error());
}


echo '<reviews>';


if ($result->num_rows > 0)
{
	while ($row = $result->fetch_assoc())
	{
		// ADD TO XML DOCUMENT NODE
		echo '<review ';
		echo 'loc_id ="' . $row['loc_id'] . '" ';
		echo 'name="' . parseToXML($row['name_first']) . '" ';
		echo 'date="' . $row['date'] . '" ';
		echo 'review="' . parseToXML($row['review']) . '" ';
		echo 'title="' . parseToXML($row['title']) . '" ';
		echo '/>';
	}
}


echo '</reviews>';
echo '</markers> ';

?>
