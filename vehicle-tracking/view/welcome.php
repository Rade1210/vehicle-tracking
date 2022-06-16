<?php

require '../db/config.php';


$sql = "SELECT * FROM gps_data WHERE 1";
$result = $db->query($sql);
if (!$result) { {
    echo "Error: " . $sql . "<br>" . $db->error;
  }
}

$rows = $result->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Vehicle Tracking</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <script src="https://kit.fontawesome.com/ab2155e76b.js" crossorigin="anonymous"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="../css/app.css" rel="stylesheet" />
    
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="welcome.php">Vehicle Tracking</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white" href="#">Docs</a>
      </li>
       <li class="nav-item">
        <a class="nav-link text-white" href="../logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>
  
    <div class="jumbotron mt-5">
        <div class="container-fluid">
             <div class="text-center"><button class="btn btn-primary bg-dark" id="btn">Calculate route</button>
             <button class="btn btn-primary bg-dark" id="btn-track">Track vehicle</button><button class="btn btn-primary bg-dark ml-1" id="btn-clearAll">Clear All</button></div><br>
            <form style="margin:0 auto;" id="form" class="form-horizontal w-25">
                <div class="form-group">
                    <label for="from" class="col-xs-2 control-label"></label>
                    <div class="col-xs-4">
                        <input type="text" id="from" placeholder="Origin" class="form-control">
                    </div>
               </div>
               <div class="form-group">
                
                    <label for="to" class="col-xs-2 control-label"></label>
                    <div class="col-xs-4">
                        <input type="text" id="to" placeholder="Destination" class="form-control">
                    </div>
                  
                 </div>
                 
            </form>

            <div id="btn-calcRoute" class="col-xs-offset-2 col-xs-10 text-center">
                <button class="btn btn-info btn-lg " onclick="calcRoute();"><i class="fas fa-map-signs"></i></button>
            </div>
           
            
            <form style="margin:0 auto;" id="form2" class="form-horizontal w-25">
                <div class="form-group">
                    <label for="from2" class="col-xs-2 control-label"></label>
                    <div class="col-xs-4">
                        
                        
                        <input type="text" id="from2" placeholder="Origin" class="form-control" value="<?php 
                        
                        $numItems = count($rows);
                        $i = 0;
                        foreach($rows as $key=>$location) {
                        if(++$i === $numItems) {
                        echo $location['lat'].', '.$location['lng'];
                        }
                        }    
                        
                        
                        
                        
                        ?>">
                        
                        
                    </div>
               </div>
               
               <div class="form-group">
                
                    <label for="to2" class="col-xs-2 control-label"></label>
                    <div class="col-xs-4">
                        <input type="text" id="to2" placeholder="Destination" class="form-control">
                    </div>
                  
                 </div>
                 
            </form>

            <div id="btn-calcRoute2" class="col-xs-offset-2 col-xs-10 text-center">
                <button class="btn btn-info btn-lg " onclick="calcRoute2();"><i class="fas fa-map-signs"></i></button>
            </div>
            
            
        </div>
        
        <br>
       
    <script>
    
        const btnClearAll = document.getElementById('btn-clearAll');

        btnClearAll.addEventListener('click', function handleClick(event) {


        const from = document.getElementById('from');
        const to = document.getElementById('to');
        const from2 = document.getElementById('from2');
        const to2 = document.getElementById('to2');

        // Send value to server
        console.log(from.value);
        console.log(to.value);
        console.log(from2.value);
        console.log(to2.value);

        // 👇️ clear input field
        from.value = '';
        to.value = '';
        from2.value = '';
        to2.value = '';
        });
        
    </script>
        
        
        <div class="container-fluid">
            
            <div style="height:500px !important" id="googleMap">

            </div>
            <br>
            <div id="output">

            </div>
        </div>

    </div>
    
    <script>
            window.onload = function(){
            document.getElementById("form").style.display = "none";
            document.getElementById("btn-calcRoute").style.display = "none";
            
             document.getElementById("form2").style.display = "none";
            document.getElementById("btn-calcRoute2").style.display = "none";
            }
        
            const btn = document.getElementById('btn');
            
            const btn2 = document.getElementById('btn-track');

            btn.addEventListener('click', () => {
            const form = document.getElementById('form');
            const hideCalcBtn = document.getElementById('btn-calcRoute');
            if (form.style.display === 'none') {
             // 👇️ this SHOWS the form
             form.style.display = 'block';
                hideCalcBtn.style.display = 'block';
            } else {
             // 👇️ this HIDES the form
             form.style.display = 'none';
             hideCalcBtn.style.display = 'none';
            }
            });
            
             btn2.addEventListener('click', () => {
            const form2 = document.getElementById('form2');
            const hideCalcBtn2 = document.getElementById('btn-calcRoute2');
            if (form2.style.display === 'none') {
             // 👇️ this SHOWS the form
             form2.style.display = 'block';
                hideCalcBtn2.style.display = 'block';
            } else {
             // 👇️ this HIDES the form
             form2.style.display = 'none';
             hideCalcBtn2.style.display = 'none';
            }
            });
    </script>
    
    <script>
    var map;

    function initMap() {

      var mapLayer = document.getElementById("googleMap");
      var centerCoordinates = new google.maps.LatLng(44.2108, 20.9224);
      var defaultOptions = {
        center: centerCoordinates,
        zoom: 8
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

<br>
<div class="footer text-center bg-dark text-white p-2">
    <span>&#169; Vehicle Tracking System</span>
</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCMVI40S3cZSdGxhbRiiSFYlgt_ZzTIJ70&callback=initMap"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="Scripts/jquery-3.1.1.min.js"></script>
    <?php require '../controller/main.php'?>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>



</body>
</html>
