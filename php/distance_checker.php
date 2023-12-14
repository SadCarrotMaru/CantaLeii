<?
$latitude = 37.7649; //floatval pt string in float daca e nevoie
$longitude = -122.4194; //astea le iei din javascript, vad acum cum

$targetLatitude = 37.7679; // trebuie facut get din baza de date
$targetLongitude = -122.4194;


function same_location($lat1, $lon1, $lat2, $lon2)
{
	$distance = calculateDistance($lat1, $lon1, $lat2, $lon2);
	if ($distance <= 500) return true;
	return false;
}


function calculateDistance($lat1, $lon1, $lat2, $lon2) 
{
    $earthRadius = 6371000; // Earth radius in meters
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $earthRadius * $c;
    return $distance;
}

echo same_location($latitude,$longitude,$targetLatitude,$targetLongitude);
?>