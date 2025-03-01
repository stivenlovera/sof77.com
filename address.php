<?php
  function getaddress($lat,$lng)
  {
     $url = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
     //echo "Llego a address function <br>";
     $json = @file_get_contents($url);
     $data=json_decode($json);
     $status = $data->status;
	 //echo "Status address:".$status."<br>";
     if($status=="OK")
     {
       return $data->results[0]->formatted_address;
     }
     else
     {
       return false;
     }
  }
?>
	