<?php

$args = array_slice($argv, 1);

$arr = array_map('intval', $args);

function custom_sort($array) {
    if (count($array) < 2) {
        return $array;
    } else {
        $pivot = $array[0];
        $less = [];
        $second = [];
        for($i = 1; $i < count($array); $i++){
            if ($array[$i] < $pivot) {
                array_push($less, $array[$i]);
            }
            if ($array[$i] > $pivot) {
                array_push($second, $array[$i]);
            }
        }
        return array_merge(custom_sort($less), [$pivot], custom_sort($second));
    }
}

echo implode(' ', custom_sort($arr));
