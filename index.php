<?php

$weather = "";
$error = "";

if (array_key_exists("city", $_GET)) {
   
    $city = str_replace(' ', '', $_GET['city']); 
    
    
    $url = "https://www.weather-forecast.com/locations/" . $city . "/forecasts/latest";
    
 
    $file_headers = @get_headers($url);
      
    if ($file_headers[0] == "HTTP/1.1 404 Not Found") {
        $error = "That city could not be found.";
    } else {
        // Fetch the page content
        $forecastPage = file_get_contents($url);
        
        // Debug: Check if the page content is fetched
        if ($forecastPage === FALSE) {
            $error = "Failed to retrieve the page content.";
        } else {
            echo "Page fetched successfully.<br>";  // Debug: Page fetched
            
            $pageArray = explode('</h2> (1&ndash;3 days)</div><p class="b-forecast__table-description-content"><span class="phrase">', $forecastPage);
            
            // Debug: Check the result after the first explode operation
            echo "After first explode, array size: " . sizeof($pageArray) . "<br>";
            //echo "<pre>" . htmlspecialchars($forecastPage) . "</pre>";

            if (sizeof($pageArray) > 1) {
                $secondPageArray = explode('</span></p></td>', $pageArray[1]);
                
                // Debug: Check the result after the second explode operation
                echo "After second explode, array size: " . sizeof($secondPageArray) . "<br>";
                
                if (sizeof($secondPageArray) > 1) {
                    $weather = $secondPageArray[0];
                } else {
                    $error = "Weather data could not be extracted from the page.";
                }
            } else {
                $error = "Weather data extraction failed: page structure might have changed.";
            }
        }
    }
} else {
    $error = "Please enter a city name.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Scraper</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            background-image: url('images/Horizon Aesthetic.jpeg');
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;
            background-attachment: fixed; 
            min-height: 100vh; 
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center mt-4">
        <div class="col-md-6 justify-content-center text-center" style="margin-top: 100px;">
            <h2 class="d-flex align-items-center justify-content-center">What's The Weather</h2>
            <form method="GET">
            
            <figcaption class="blockquote-footer mt-2 d-flex align-items-center justify-content-center">
                <b>Enter the name of the city to get weather</b>
            </figcaption>
            
            <div class="d-flex justify-content-center">
                <input class="form-control" id="city" type="text" name="city"  value="<?php
                if (array_key_exists('city', $_GET)) {
                    echo $_GET['city'];
                }
                ?>"
                style="width: 100%; max-width: 380px; margin-left:10px;">
            </div>
            <div class="d-flex align-items-center justify-content-center mt-3">
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </div>
            
            </form>

            <div class="d-flex justify-content-center p-4" id="weather">
            <?php
            // Debugging the weather and error messages
            if ($weather) {
                echo '<div class="alert alert-success" role="alert">' . $weather . '</div>';
            } else if ($error) {
                echo '<div class="alert alert-danger" role="alert">' . $error . '</div>';
            }
            ?>
            <

