<?php

	$weather="";
	$error="";

	if(array_key_exists("city",$_GET))
	{
		
		$city=str_replace(' ','',$_GET['city']);
		
		$file_headers=@get_headers("https://www.weather-forecast.com/locations.$city.forecasts/latest");
		
		if($file_headers[0]=="HTTP/1.1 404 not found")
		{
			$error="that city could not be 1 found";
		}
		else
		{
			$forecastPage=file_get_contents("https://www.weather-forecast.com/locations.$city.forecasts/latest");
			
			$pageArray=explode('Weather Today</h2> (1&ndash;3 days)</div><p class="b-forecast_table-description-content"><span class="phrase">',$forecastPage);
			
			if(sizeof($pageArray)>1)
			{
				$secondPageArray= explode('</span></p></td>', $pageArray[1]);
			
					if(sizeof($secondPageArray)>1)
					{
						$weather=$secondPageArray[0];
					}
					
					else
					{
						$error="that city could not 2 found";
			
					}
			}		
			else
			{
			$error="that city could not ( (file_get_contents) function not excute properly) found";
			}
			
			
		
		}
	}
	else
	{
		$error="that city could not  found";
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather scraper</title>
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
                if(array_key_exists('city',$_GET))
                {
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
            if($weather){
             echo'<div class="alert alert-success" role="alert">'.$weather.'</div>';
            }
            
            else if($error)
            {
            	echo'<div class="alert alert-danger" role="alert">'.$error.'</div>';
            }
            ?>
            </div>
        </div>
    </div>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js">
</body>
</html>
