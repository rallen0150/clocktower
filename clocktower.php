<?php
// function to get the count of bell chimes so I don't repeat this code
function checkHour ($startHour, $endHour) {
  $count = 0;
  for ($startHour = intval($startHour); $startHour <= 13; $startHour++) {
    if ($startHour == 13) {
      $startHour = 1;
    }

    $count+=$startHour;
    if ($startHour == $endHour) {
      break;
    }
  }
  return $count;
}

function countBells($startTime, $endTime) {
  /*
    If the times are the same, then it acts as 24 hours has passed, so each chime is for the hour the hour-hand is on
    The math goes ((1+2+3+4+5+6+7+8+9+10+11+12)*2) because it's adding each hour pass has the number of chimes equivalent to what hour the hour hand is on
  */
  if ($startTime === $endTime) {
    $count = 156;
    return $count."\n";
  }
  /*
    Get the hour and minute of each time for comparison
    Each hour is not on a 24 hour format, it's on a 12 hour format
  */
  $startHour = date('g', strtotime($startTime));
  $startMin = date('i', strtotime($startTime));
  $endHour = date('g', strtotime($endTime));
  $endMin = date('i', strtotime($endTime));

  // If the startMin is greater than the endMin, run the checkHour function then erase the start hour if it didn't start on the top of the hour (which should always be the case)
  if ($startMin > $endMin) {
    $count = checkHour($startHour, $endHour);
    if ($startMin > '00') {
      $count -= $startHour;
    }
  }
  /*
    Run the checkHour function and again if the startTime is not on the start of the hour, remove the chimes for the startHour
  */
  else {
    $count = checkHour($startHour, $endHour);
    if ($startMin > '00') {
      $count -= $startHour;
    }
  }
  return $count."\n";
}

echo countBells('2:00', '3:00'); // output 5
echo countBells('14:00', '15:00'); // output 5
echo countBells('14:23', '15:42'); // output 3
echo countBells('23:00', '1:00'); // output 24
?>
