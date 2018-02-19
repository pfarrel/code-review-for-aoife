<?php
function greatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $longFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $longTo = deg2rad($longitudeTo);

  $latDelta = $latTo - $latFrom;
  $longDelta = $longTo - $longFrom;

  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
    cos($latFrom) * cos($latTo) * pow(sin($longDelta / 2), 2)));
  return $angle * $earthRadius;
}