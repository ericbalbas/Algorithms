<?php

/**
 * Recursively search for a target value in a sorted array using binary search.
 *
 * @param array $array The sorted array to search within.
 * @param mixed $target The target value to search for.
 * @param int $low The lower bound index for the current search range.
 * @param int $high The upper bound index for the current search range.
 * @return int The index of the target value in the array, or -1 if the target is not found.
 */
function binary_search(array $array, $target, int $low, int $high)
{
    if ($low <= $high) {
        // Calculate the middle index
        $mid = (int) (($low + $high) / 2);

        // Check if the target value is at the middle index
        if ($array[$mid] === $target) {
            return $mid;
        }
        // If the target value is less than the middle element, search the left half
        else if ($array[$mid] > $target) {
            return binary_search($array, $target, $low, $mid - 1);
        }
        // If the target value is greater than the middle element, search the right half
        else {
            return binary_search($array, $target, $mid + 1, $high);
        }
    }

    // Return -1 if the target value is not found
    return -1;
}


$array = [1, 3, 4, 5 ,6 ,75, 85, 99];
$target = 99;
$low = 0;
$high = count($array) - 1;

$res =  binary_search($array, $target, $low, $high);

echo $res != -1? "Found at index[{$res}]" : "Out of bounce";

?>