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

/**
 * Perform exponential search to find the position of a target value within a sorted array.
 *
 * Exponential search first finds a range where the target value might be located using exponential steps,
 * and then performs a binary search within that range.
 *
 * @param array $array The sorted array to search within.
 * @param mixed $target The target value to search for.
 * @return int The index of the target value in the array, or -1 if the target is not found.
 */
function exponential_search(array $array, $target)
{
    $n = count($array);

    // If the array is empty, return -1
    if ($n == 0) {
        return -1;
    }

    // Start with the first element
    if ($array[0] == $target) {
        return 0;
    }

    // Find the range for binary search by repeated doubling
    $i = 1;
    while ($i < $n && $array[$i] <= $target) {
        $i *= 2;
    }

    // Call binary search for the found range
    return binary_search($array, $target, $i / 2, min($i, $n - 1));
}

// Example usage:
$array = [1, 3, 4, 5, 6, 75, 85, 99];
$target = 3;

$result = exponential_search($array, $target);
echo $result != -1 ? 
    "Element found at index [{$result}]"
    :
    "Element not found in the array";
