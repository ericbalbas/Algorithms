<?php

/**
 * Recursively search for a target value in a sorted array
 */
function search(array $array, $target, $low, $high)
{

    if($low <= $high)
    {
        $mid = (int) (($low + $high) / 2);

        if($array[$mid] === $target) return $mid;
        else if($array[$mid] > $target) return search($array, $target, $low, $mid-1);
        else return search($array, $target, $mid + 1, $high);


        return -1;
    }

}

$array = [1, 3, 4, 5 ,6 ,75, 85, 99];
$target = 99;
$low = 0;
$high = count($array) - 1;

$res =  search($array, $target, $low, $high);

echo $res != -1? "Found at index[{$res}]" : "Out of bounce";

?>