<?php
$start_date="";
$end_date=date('Y-m-d');
$current_month=date('m');

$segment = 3;
$total_segment = 12/$segment;
$next_segment = 00;
$prev_segment = 00;
for($i=0;$i<$total_segment;$i++){
	if($current_month <= $next_segment){
		if($i==0){
			$start_date=date("Y")."-".str_pad($next_segment,2,0,STR_PAD_LEFT)."-01";
			break;
		}else{
			$start_date=date("Y")."-".str_pad(($prev_segment+1),2,0,STR_PAD_LEFT)."-01";
			break;
		}
	}
	$prev_segment = $next_segment;
	$next_segment = $next_segment + $segment;
}
if($start_date==""){
	$start_date=date("Y")."-".str_pad(($prev_segment+1),2,0,STR_PAD_LEFT)."-01";
}

// Current Quarter
echo "Current Quarter : ".$start_date." To ".date("Y-m-t", strtotime("+2 month", strtotime($start_date)))."<br><br>";

// First Month
$first_start = $start_date;
$first_end = date("Y-m-t", strtotime($start_date));
echo "First Month : ".$start_date." To ".$first_end."<br><br>";

// Second Month
$second_start = date("Y-m-d", strtotime("+1 month", strtotime($start_date)));
$second_end = date("Y-m-t", strtotime($second_start));
echo "Second Month : ".$second_start." To ".$second_end."<br><br>";

// Third Month
$third_start = date("Y-m-d", strtotime("+2 month", strtotime($start_date)));
$third_end = date("Y-m-t", strtotime($third_start));
echo "Third Month : ".$third_start." To ".$third_end."<br><br>";

// Previous Quarter
$pre_start_date = date("Y-m-d", strtotime("-3 month", strtotime($start_date)));
$pre_end_date = date("Y-m-d", strtotime("-1 day", strtotime($start_date)));
echo "Previous Quarter : ".$pre_start_date." To ".$pre_end_date."<br>";
?>
