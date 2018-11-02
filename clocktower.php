<?php
// function to get the count of bell chimes so I don't repeat this code
function checkHour ($startHour, $endHour) {
  $count = 0;
  for ($startHour = intval($startHour); $startHour <= 24; $startHour++) {
    if ($startHour == 24) {
      $startHour = 0;
    }
    // If it's midnight (or 12 am), then the clock hour should be 12 and not 0
    if ($startHour == 0) {
      $time = 12;
      $count+=$time;
    }
    // If it's past noon and before midnight, the chimes should be equivalent to 12 hour format
    if ($startHour > 12) {
      $time = $startHour-12;
      $count+=$time;
    } else {
      $count+=$startHour;
    }
    if ($startHour == $endHour) {
      break;
    }

  }
  return $count;

}

// echo checkHour(22, 20);
// echo intval(date('H', strtotime('24:00')));

function countBells($startTime, $endTime) {
  /*
    Get the hour and minute of each time for comparison
  */
  $startHour = date('H', strtotime($startTime));
  $startMin = date('i', strtotime($startTime));
  $endHour = date('H', strtotime($endTime));
  $endMin = date('i', strtotime($endTime));
  /*
    If the times are the same, then it acts as 24 hours has passed, so each chime is for the hour the hour-hand is on
    The math goes ((1+2+3+4+5+6+7+8+9+10+11+12)*2) + hour it's on, because it's adding each hour pass has the number of chimes equivalent to what hour the hour hand is on
  */
  if ($startTime === $endTime) {
    $time = $startHour;
    // If it's midnight (or 12 am), then the clock hour should be 12 and not 0
    if ($startHour == 0) {
      $time = 12;
    }
    // If it's past noon and before midnight, the chimes should be equivalent to 12 hour format
    if ($time > 12) {
      $time-=12;
    }
    $count = 156+$time;
    return $count."\n";
  }

  // If the startMin is greater than the endMin, run the checkHour function then erase the start hour if it didn't start on the top of the hour (which should always be the case)
  if ($startMin > $endMin) {
    $count = checkHour($startHour, $endHour);
    if ($startMin > '00') {
      // If it's midnight (or 12 am), then the clock hour should be 12 and not 0
      if ($startHour == 0) {
        $time = 12;
        $count -= $time;
      }
      // If it's past noon and before midnight, the chimes should be equivalent to 12 hour format
      if ($startHour > 12) {
        $time = $startHour-12;
        $count -= $time;
      } else {
        $count -= $startHour;
      }
    }
  }
  /*
    Run the checkHour function and again if the startTime is not on the start of the hour, remove the chimes for the startHour
  */
  else {
    $count = checkHour($startHour, $endHour);
    if ($startMin > '00') {
      if ($startHour == 0) {
        $time = 12;
        $count -= $time;
      }
      if ($startHour > 12) {
        $time = $startHour-12;
        $count -= $time;
      }

    }
  }
  return $count."\n";
}

echo countBells('2:00', '3:00'); // output 5
echo countBells('14:00', '15:00'); // output 5
echo countBells('14:23', '15:42'); // output 3
echo countBells('23:00', '1:00'); // output 24
// echo countBells('23:00', '21:00'); // output 146
// echo countBells('14:32', '16:42'); // output 7
// // echo countBells('11:52', '16:42'); // output 22
// // echo countBells('22:00', '22:00'); // output 166 (156+10)
?>
