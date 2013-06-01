<?php
$date = strtotime($data->start_date);
                $month = date("M", $date);
                $day = date("d", $date);
                $year = date("Y", $date);
                $final_start_date = date("F d, Y", $date);




                $end_date = strtotime($data->end_date);
                $end_month = date("M", $end_date);
                $end_day = date("d", $end_date);
                $end_year = date("Y", $end_date);
                $final_end_date = date("l, F d, Y", $end_date);
                
                
                $start_time = $data->start_time;
//echo $start_time.'<br>';
$start_time = $start_time / 60;

$start_time = number_format($start_time, 2);
//echo $start_time.'<br>';


$hour = floor($start_time);
$min = $start_time - $hour;



$min*=60;

//echo $min.'<br>';
//echo $hour.'<br>';
$start_time = $hour . ':' . $min;
$time = strtotime($start_time);




$end_time = $data->end_time;
//echo $end_time.'<br>';
$end_time = $end_time / 60;

$end_time = number_format($end_time, 2);
//echo $start_time.'<br>';


$end_hour = floor($end_time);
$end_min = $end_time - $end_hour;



$end_min*=60;

//echo $min.'<br>';
//echo $hour.'<br>';
$end_time = $end_hour . ':' . $end_min;
$finished_end_time = strtotime($end_time);
?>

<tr>
            <td class="lft"><?php echo CHtml::link($data->name, array('event/'.$data->eventurl));?><br>
            <?php echo $data->countrsvp;?> People Attend This !! </td>
            <td class="date"><?php echo $final_start_date.' at '.date("g:i A", $time);?> </td>
            <td><a href="#" class="button">Attend</a></td>
</tr>