<!DOCTYPE html >
<head>
    <link rel="stylesheet" type="text/css" href="style1.css" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Prototype 1</title>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjGGnIpBiOwydg9wvVhgs1X2srpD5ifY4"
            type="text/javascript"></script>

<?php
//handles new review

require('dbconnect.php');

//I hate to do this, but since it receives POSTs on the same page that it sends them, it gives me an error on the first
//load telling me that $_POST['name_f'] doesn't exist, because it doesn't yet.
error_reporting(0);


$namef = $_POST['name_f'];
$namel = $_POST['name_l'];
$title = $_POST['title'];
$review = $_POST['review'];
$email = $_POST['email'];
$id = $_POST['id'];
error_reporting('E_ALL');
if ($title != null)
{
$sql = "INSERT INTO mr1 (name_first,title,review, loc_id, name_second, email ) VALUES ('$namef','$title','$review', '$id', '$namel', '$email')";
if ($connection->query($sql) === true)
{
	echo "good, inserted into: ".$id;

}
else
{
	echo "<br><br>Error ". $sql. "<br>".$connection->error;
}
}
?>

    <script type="text/javascript">
    //creates icons for map. Perhaps we could do this for "good" and "bad" rated hospitals? Right now it's static
    var customIcons = {
      restaurant: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      },
      bar: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      }
    };
    //creates map. Different types available, but roadmap might be the most useful
    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(47.6145, -122.3418),
        zoom: 13,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;

      //database info is exported to an XML file and then imported by this page. Efficient? Probably not.
      downloadUrl("genxml.php", function(data) {
        var xml = data.responseXML;
        var reviews = xml.documentElement.getElementsByTagName("review");
        var locid = new Array();
        var title = new Array();
        var review = new Array();
        var author = new Array();
        var date = new Array();
        var k = reviews.length;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < reviews.length; i++) {
        	locid[i] = reviews[i].getAttribute("loc_id");
        	title[i] = reviews[i].getAttribute("title");
        	review[i]= reviews[i].getAttribute("review");
        	author[i]= reviews[i].getAttribute("name");
        	date[i]= reviews[i].getAttribute("date");
        	}
        for (var i = 0; i < markers.length; i++) {
          var id = markers[i].getAttribute("id");
          var length2 = markers.length;
          var name = markers[i].getAttribute("name");
          var address = markers[i].getAttribute("address");
          var type = markers[i].getAttribute("type");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b> <br/>" + address;
          var icon = customIcons[type] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html, id, locid, title, review, date, author);
          //bindInfoWindow does more than just bind infowindow now- it's also used to export local
          // variables to our eventlistener function, which can use those to display this data in the side div
        }
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html, id, locid, title, review, date, author) {
        google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            //still not sure if this is too annoying or not- perhaps we should just do away with infowindow entirely?
            //since after all, var html is displayed in the div
            document.getElementById('ot').innerHTML = (html + " <div style='float:right'> <button onclick=\"writeReview("
                + id + "," + "'" + html +"'" +  ")\">Write Review</button> </div>");

            for (var i = 0; i < locid.length; i++)
        	{
        		if (locid[i]==id) 
        			{
        			document.getElementById('ot').innerHTML = (document.getElementById('ot').innerHTML +"<br>"
                        + " <div border=1 style='float:right; width: 100%; background-color: orange; border-color: red; padding: 5px; margin: 5px'>"
                        + title[i] + "<div style='float: right; text-align:right'> by "
                        + author[i] + ", at " + date[i] + "</div><hr>" + review[i]+ "</div><br><br><br>");
                        //my big mistake here was not including a css file- will fix if I have the time, this was just for time's sake
                        //it basically just creates each review, and then appends it on to the previous review
        			}
        	}

        infoWindow.open(map, marker);
        
      });
    }

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function writeReview(id, html)
    {
        document.getElementById('ot').innerHTML = ("<form action = 'index.php' method = 'post'>" +
            "<table style = 'height:350px; width: 100%' border = 2>" +
            "<tr><td><strong>Write Review for: <br> " + html + "</strong></td></tr>  " +
            "<tr><td> E-mail: <input type = 'text' name = 'email'> <div style='text-align: right; float: right'> Phone: <input type = 'text' name = 'Phone'></div></td></tr>  " +
            "<tr><td>First Name: <input type = 'text' name = 'name_f'> <div style='float: right; text-align:right'> Last Name: <input type = 'text' name = 'name_l'></div></td></tr>" +
            "<tr><td>Title: <input type = 'text' name = 'title'></td></tr>" +
            "<tr><td>Review: <br><textarea rows = '7' cols = '65' name='review'></textarea></td></tr>" +
            "</table> " +
            "<input type = 'hidden' name = 'id' value = '" + id + "'>" +
            "Please Fill in all fields and then click 'Submit'. <br>" +
            "<input type = submit value = 'Submit'>" +
            "</form>");
            //this replaces the review text with a form to submit data to write a review. It POSTS the data to this
            //page again, which is received by the PHP at the top and submitted into the database
    }

</script>

</head>

<body onload="load()">
    <div id="map" style="width: 700px; height: 400px; float:left"></div>
    <div id='ot' style="overflow-y: scroll; float:right; height:375px; width: 42%; background-color: lightblue; border-radius: 25px; padding: 25px; padding-top: 10px;"></div>
</body>

</html>
