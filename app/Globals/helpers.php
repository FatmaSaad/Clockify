<?php

use App\Globals\CONSTANTS;

if (!function_exists('vincentyGreatCircleDistance')) {
   
    /**
     * Calculates the great-circle distance between two points, with
     * the Vincenty formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [km] 
     */
    function vincentyGreatCircleDistance(
        $latitudefrom,
        $longitudefrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = CONSTANTS::Earth_Radius,
    ) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudefrom);
        $lonFrom = deg2rad($longitudefrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $distance = null;

        if ($longitudeTo != null && $latitudeTo != null) {
            $lonDelta = $lonTo - $lonFrom;
            $a = pow(cos($latTo) * sin($lonDelta), 2) +
                pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
            $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

            $angle = atan2(sqrt($a), $b);
            $distanceWithKM = $angle * $earthRadius / 1000;
            $distance = round($distanceWithKM, 2);
        }
        return  $distance;
    }
}