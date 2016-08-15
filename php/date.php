<?php

class MyDate {

    public static function divDate($start, $end)
    {
        if(date('Ymd' ,$start) == date('Ymd', $end)) {
            return [date('Y-m-d',$start)];
        }
        $result[] = date('Y-m-d', $start);
        return array_merge($result, static::divDate($start + 86400, $end));
    }

}

// 2016-04-22 09:00:00 -- 2016-05-22 18:00:00

$startDate = '2016-04-22 09:00:00';
$endDate = '2016-05-22 18:00:00';

$startDate = '2016-04-22 09:00:00';
$endDate = '2016-04-22 18:00:00';

$startDate = '2016-04-22 09:00:00';
$endDate = '2016-04-22 12:00:00';

$startDate = '2016-04-22 14:00:00';
$endDate = '2016-04-22 18:00:00';

$startDate = '2016-04-22 09:00:00';
$endDate = '2016-04-23 12:00:00';

$startDate = '2016-04-22 09:00:00';
$endDate = '2016-04-23 18:30:00';

$startDate = '2016-04-22 09:00:00';
$endDate = '2016-04-24 14:00:00';

$startDate = '2016-04-22 14:00:00';
$endDate = '2016-04-27 12:00:00';

$startDate = '2016-09-13 09:00:00';
$endDate = '2016-09-14 14:00:00';

$dates = MyDate::divDate(strtotime($startDate),strtotime($endDate));

var_dump($dates);

// 节假日
$holidays = [
    '2016-04-02',
    '2016-04-03',
    '2016-04-04',
    '2016-04-30',
    '2016-05-01',
    '2016-05-02',
    '2016-09-15',
    '2016-09-16',
    '2016-09-17',
];

// 交集
$arr = array_intersect($dates,$holidays);
var_dump($arr);

// 差集
$dates = array_diff($dates, $arr);
var_dump($dates);

// 计算出周末
$weeks = [];
foreach($dates as $date) {
    if(in_array(date('N', strtotime($date)), ['6','7'])) {
        $weeks[] = $date;
    }
}

var_dump($weeks);

// 周末上班日
$workOnWeeks = [
    '2016-02-06',
    '2016-02-14',
    '2016-06-12',
    '2016-09-18',
    '2016-10-08',
    '2016-10-09',
];

// 要除去到周末日期
// 第一个数组有，其他数组没有到
$weeks = array_diff($weeks, $workOnWeeks);
var_dump($weeks);

$dates = array_diff($dates, $weeks);

// 实际上班日
$dates = array_values($dates);
var_dump($dates);

$days = 0;
$total = count($dates);
if($total > 0) {

    // 12点之前到当作是一天
    $point = strtotime($dates[0].' 12:00:00');
    if(strtotime($startDate) < $point) {
        $days = 1;
    } else {
        $days = 0.5;
    }
    echo $dates[0].'==>'.$days.';;;';
    // todo 添加第一天的数据

    // 最后一天
    $last = $total-1;
    if( $last > 0) {
        $point = strtotime($dates[$last].' 14:00:00');
        if(strtotime($endDate) > $point) {
            $days = 1;
        } else {
            $days = 0.5;
        }
        echo $dates[$last].'==>'.$days.';;;';
        // todo 添加最后一天到数据
        // 把最后一个删除掉
        array_pop($dates);
    }

    // 删掉第一个
    array_shift($dates);

    // 中间到全是1
    foreach($dates as $date) {
        $days = 1;
        echo $date.'==>'.$days.';;;';
    }

}
