<?php 

  $cityName = "";
  $weather = "";
  $warning = "";

  if (array_key_exists('city', $_GET)) {
    
    // clean spache from city input string
    $cityName = str_replace(' ', '', $_GET['city']);

    // get error if url not exist
    $file_headers = @get_headers("https://www.weather-forecast.com/locations/".$cityName."/forecasts/latest");

    if($file_headers[0] == "HTTP/1.1 404 Not Found") {

      $warning = '<hr><div class="alert alert-danger" role="alert">This city could not be found.</div>';
      $exists = false;

    } else {

      // go url
      $forecastPage = file_get_contents("https://www.weather-forecast.com/locations/".$cityName."/forecasts/latest");

      // cut after this codeString...from URL's shource code
      $pageArray = explode('</div></div></section><section class="row"><div class="large-8 columns"><section class="b-metar"><div class="row"><h2 class="b-metar__title columns">', $forecastPage);

      // cut before this codeString of URL's shource code
      $weather = explode('* NOTE: not all weather stations near', $pageArray[1]);
    }

  }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Weather App</title>

    <style type="text/css">
      
      html {
        
        background: url(image.jpeg) no-repeat center center fixed; 
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }

      body {

        background: none;
        font-family: sans-serif;
      }

      .container {

        text-align: center;
        margin-top: 100px;

      }


    </style>
  </head>
  <body>

    <div class="container">
      
      <h1>What's The Weather?</h1>

      <form>

        <fieldset class="form-group">
          <label for="exampleInputEmail1">Enter the name of a city.</label>
          <input type="text" class="form-control" name="city" id="city" placeholder="Eg. London, Tokyo" value = "<?php if (array_key_exists('city', $_GET)) { echo $_GET['city']; } ?>">
        </fieldset>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>

      <div id="weather"> <?php 

        if ($weather) {
          
          echo '<hr><div class="alert alert-success" role="alert">'.$weather[0].'</div><hr>
  <p class="mb-0">* NOTE: not all weather stations near '.$_GET['city'].' update at the same time and we only show reports from the nearest stations that are deemed current. Weather reports submitted by any ship (SYNOP) that is close to '.$_GET['city'].' within an acceptable time window are also included.</p>
</div>';
        } else if ($warning){

          echo $warning;
        }

       ?>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    
  </body>
</html>