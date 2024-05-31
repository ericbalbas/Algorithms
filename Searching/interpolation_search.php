<?php

/**
 * Recursively perform interpolation search to find the position of a target value within a sorted array.
 *
 * @param array $array The sorted array to search within.
 * @param mixed $target The target value to search for.
 * @param int $low The lower bound index for the current search range.
 * @param int $high The upper bound index for the current search range.
 * @return int The index of the target value in the array, or -1 if the target is not found.
 */
function interpolation_search(array $array, $target, int $low, int $high)
{
    // Formula;
    // pos = low + ((target - array[low]) * (high - low) / (array[high) - array[high]));
    if($low <= $high && $target <= $array[$high] && $target >= $array[$low])
    {
        $pos = $low + (int) ((($target - $array[$low]) * ($high - $low)) / ($array[$high] - $array[$low]));

        if($array[$pos] === $target) return $pos;

        if($array[$pos] > $target) return interpolation_search($array, $target, $pos - 1, $high);
        
        return interpolation_search($array, $target, $low, $pos + 1);
    }
    
    return -1;

}
$array = [1,2,4,5,6,7,8,9];
$result = interpolation_search($array, 5, 0, count($array) - 1);
echo $result !== -1 ? "Found at index [{$result}] " : "Not found!" ;

?>