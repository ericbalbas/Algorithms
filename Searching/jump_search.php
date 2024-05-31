<?php

/**
 * Jump search algorithm to find the position of a target value within a sorted array.
 *
 * @param array $arr The sorted array to search within.
 * @param mixed $target The target value to search for.
 * @return int The index of the target value in the array, or -1 if the target is not found.
 */
function jump_search(array $arr, $target)
{   
    $n = count($arr);
    $jump = $block_size = ceil(sqrt($n)); // Round up the square root to handle arrays
    $prev = 0;

    // Jumping ahead until the value at index $jump is greater than or equal to the target
    while ($jump < $n && $arr[$jump] < $target) {
        $prev = $jump;
        $jump += $block_size;
    }


    // Performing linear search within the block containing the target value
    for($i = $prev; $i <= min($jump, $n-1); $i++)
    {
        if($arr[$i] === $target) return $i;
    }

    return -1;
}

$res = jump_search([1, 3, 4, 5, 6, 7, 8, 12], 3);
echo  $res!== -1 ? "Found at index [{$res}] " : "Not found in the array" ;
?>