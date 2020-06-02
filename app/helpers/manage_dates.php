<?php
function chat_dates($date){
	$yesterday_array = explode("-", date("Y-m-d"));
	$yesterday_array[2] -= 1;
	$yesterday = join("-", $yesterday_array);
	$date_array = explode(" ", $date);
	$date_date = explode("-", $date_array[0]);
	$date_hour = explode(":", $date_array[1]);
	$chat_date = explode(":", $date_array[1]);
	if($date_array[0] == date('Y-m-d')){
		return "today at " . $chat_date[0] . ":" . $chat_date[1];
	}elseif($date_array[0] == $yesterday){
		return "yesterday at " . $chat_date[0] . ":" . $chat_date[1];
	}else{
		$months = ["01" => "Jan","02" => "Feb","03" => "Mar","04" => "Apr","05" => "May","06" => "Jun","07" => "Jul","08" => "Aug","09" => "Sep","10" => "Oct","11" => "Nov","12" => "Dec"];
		$second_part = $months[$date_date[1]] . " " . $date_date[2];
		$date_hour[0] = (int)$date_hour[0];
		$date_hour[1] = (int)$date_hour[1];
		if($date_hour[0] > 12){
			$date_hour[0] -= 12;
			$first_part = $date_hour[0] . ":" . $date_hour[1] . " PM";
		}else{
			$first_part = $date_hour[0] . ":" . $date_hour[1] . " AM";
		}
		$date = $first_part . " | " . $second_part;
		return $date;
	}
}
function chat_dates2($date){
	$date_array = explode(" ", $date);
	$date_date = explode("-", $date_array[0]);
	$months = ["01" => "Jan","02" => "Feb","03" => "Mar","04" => "Apr","05" => "May","06" => "Jun","07" => "Jul","08" => "Aug","09" => "Sep","10" => "Oct","11" => "Nov","12" => "Dec"];
	$second_part = $date_date[2] . " " . $months[$date_date[1]];
	return $second_part;
}
?>