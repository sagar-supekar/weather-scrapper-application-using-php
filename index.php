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


