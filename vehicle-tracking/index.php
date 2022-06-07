<?php
//error: Google Maps JavaScript API error: ApiNotActivatedMapError
//solution: click "APIs and services" Link
//			click "Enable APIs and services" button
//			Select "Maps JavaScript API" then click on enable

require 'model/config.php';

$sql = "SELECT * FROM gps_data WHERE 1";
$result = $db->query($sql);
if (!$result) { {
    echo "Error: " . $sql . "<br>" . $db->error;
  }
}

$rows = $result->fetch_all(MYSQLI_ASSOC);

?>
<html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <title>Vehicle tracking system</title>
  <style>
    body {
      font-family: Arial;
    }

    #map-layer {
      margin: 20px 0px;
      max-width: 700px;
      min-height: 400;
      margin: 0 auto;
    }

    #main-h1 {
      text-align: center;
      margin-top: 3%;
    }

    #map {
      text-align: center;
    }
  </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    
<nav class="flex items-center justify-between flex-wrap bg-teal-500 p-6">
  <div class="flex items-center flex-shrink-0 text-white mr-6">
    <svg class="fill-current h-8 w-8 mr-2" width="54" height="54" viewBox="0 0 54 54" xmlns="http://www.w3.org/2000/svg"><path d="M13.5 22.1c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05zM0 38.3c1.8-7.2 6.3-10.8 13.5-10.8 10.8 0 12.15 8.1 17.55 9.45 3.6.9 6.75-.45 9.45-4.05-1.8 7.2-6.3 10.8-13.5 10.8-10.8 0-12.15-8.1-17.55-9.45-3.6-.9-6.75.45-9.45 4.05z"/></svg>
    <span class="font-semibold text-xl tracking-tight">Vehicle Tracking</span>
  </div>
  <div class="block lg:hidden">
    <button class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white">
      <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
    </button>
  </div>
  <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
    <div class="text-sm lg:flex-grow">
      <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4">
       Home
      </a>
      <a href="#responsive-header" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 hover:text-white mr-4">
        Docs
      </a>
    </div>
  </div>
</nav>

    <h1 class="text-center mt-10 mb-10 text-xl font-bold">Vehicle tracking system</h1>

  <div id="map-layer"></div>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMVI40S3cZSdGxhbRiiSFYlgt_ZzTIJ70&callback=initMap" async defer></script>

  <script>
    var map;

    function initMap() {

      var mapLayer = document.getElementById("map-layer");
      var centerCoordinates = new google.maps.LatLng(44.2107675, 20.9224158);
      var defaultOptions = {
        center: centerCoordinates,
        zoom: 10
      }

      map = new google.maps.Map(mapLayer, defaultOptions);


      <?php foreach ($rows as $location) { ?>
        var location = new google.maps.LatLng(<?php echo $location['lat']; ?>, <?php echo $location['lng']; ?>);
        var marker = new google.maps.Marker({
          position: location,
          map: map
        });
      <?php } ?>

    }
  </script>
 
  <footer id="footer" class="text-center bg-gray-900 text-white mt-10">

    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2021 Copyright - Vehicle Tracking System
    </div>

  </footer>

</body>

</html>