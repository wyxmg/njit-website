<html>
<head>
<?php
include('dbconnect.php');

//this file adds new location to the locations table. More proof of concept than anything else,
//just wanted to get it up and running before I add it to the main page

//this functions helps clean the inputs, preventing SQL injection. Might need more to be added
function parseToXML($htmlStr)
{
    $xmlStr=str_replace('<','&lt;',$htmlStr);
    $xmlStr=str_replace('>','&gt;',$xmlStr);
    $xmlStr=str_replace('"','&quot;',$xmlStr);
    $xmlStr=str_replace("'",'&#39;',$xmlStr);
    $xmlStr=str_replace("&",'&amp;',$xmlStr);
    $xmlStr=str_replace(",",'&#44;',$xmlStr);
    return $xmlStr;
}
//I hate to do this, but since it receives POSTs on the same page that it sends them, it gives me an error on the first
//load telling me that $_POST['pid'] doesn't exist, because it doesn't yet.
error_reporting(0);
if ($_POST['pid'])
{
$lat = $_POST['lat'];
$lng = $_POST['lng'];
$loc = parseToXML($_POST['loc']);
$name= parseToXML($_POST['pid']);
$bar = 'bar';
echo $name;
$sql = "INSERT INTO mt1 (name, address, lat, lng, type) VALUES ('$name', '$loc', '$lat', '$lng', '$bar')";

if ($connection->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $connection->error;
}

$connection->close();
}
else {
}
error_reporting(E_ALL);
?>
</head>
<body>

<form action = "addlocation.php" method = "post">
    <input type = "hidden" name = lat id = "hlat" value ="">
    <input type = "hidden" name = lng id = "hlng">
    <input type = "hidden" name = loc id = "hloc">
    <input type = "hidden" name = pid id = "hpid" value = ''>
        <table style = 'height:350px; width: 400px' border = 2>
            <tr><td><strong>Write Review for (Enter Address): <input id='addr' type = 'text' ></strong></td></tr>
        </table>
            Please Fill in all fields and then click 'Submit'. <br>
            <input type = submit value = 'Submit'>
        </form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<div id="hey"></div>
<script>
    var formAd;
    var service;

    //this function will find the place info for the requested address
    function findPlaces() {

        var cur_location = formAd;

        var request = {
            query: cur_location
        };

        service = new google.maps.places.PlacesService(document.getElementById('hey'));
        service.textSearch(request, callitback);
    }

    //very poor naming, I know. This function sends over the name of the place. Cool, right? Well, actually not so cool.
    //google places API names very very few places, like Radio City Music Hall, or The White House. So I'm not sure how
    //we're going to get around this- maybe try a different API for places?
    function callitback(results, status) {
        if (status == google.maps.places.PlacesServiceStatus.OK) {

            console.log(results[0].name);
            $('#hpid').val(results[0].name);
        }
        else if (status == google.maps.places.PlacesServiceStatus.ZERO_RESULTS) {
        alert('Sorry, nothing is found');
    }
    }


</script>

<script>

    //this is called before findPlaces(), but it's here. I'm sorry. Anyway, it finds the lat/lng and formatted address
    //when a user types in a partial address. No drop down menu yet, like google maps has, but that's possible too
function getGeo()
{
    $.getJSON('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCjGGnIpBiOwydg9wvVhgs1X2srpD5ifY4',{
            sensor: false,
            address: $('#addr').val(),
            dataType: "jsonp",
        },
        function( data, textStatus ) {
            $('#hlat').val(data.results[0].geometry.location.lat);
            $('#hlng').val(data.results[0].geometry.location.lng);
            $('#hloc').val(data.results[0].formatted_address);
            formAd = data.results[0].formatted_address;
            //$('#hloc').val(data.results[0].place_id);
            console.log(data.results[0].place_id);
            findPlaces();
        }
     );
}


$( "#addr" ).on('focusout', function() {getGeo();});
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA9eq1g-EgGjGr6H2iMGtoegQz9GjVGcOI&libraries=places" async defer></script>
</body>
</html>
