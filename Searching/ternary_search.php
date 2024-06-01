<?php

/**
 * Performs a ternary search on a sorted array.
 *
 * @param int   $l      The left index of the array to search.
 * @param int   $r      The right index of the array to search.
 * @param mixed $target The value to search for.
 * @param array $arr    The sorted array to search in.
 *
 * @return int  The index of the target if found, otherwise -1.
 */
function ternary_search($l, $r, $target, array $arr) : int
{
    $mid1 = (int) ($l + ($r - $l) / 3);
    $mid2 = (int) ($r - ($r - $l) / 3);

    if($r >= $l)
    {
        if($arr[$mid1] === $target) return $mid1; // if found at mid 1 return imidiately
        if($arr[$mid2] === $target) return $mid2; // if found at mid 2 return imidiately

        if($arr[$mid1] < $target) 
        {
            return ternary_search($l, $mid1 - 1, $target, $arr); // move the mid 1 left
        }

        else if($arr[$mid2] > $target)
        {
            return ternary_search($mid2 + 1, $r, $target, $arr); //move the pointer mid 2 to right
        }

        else
        {
            return ternary_search($mid1 + 1, $mid2 - 2, $target, $arr); // both move between the two pointers
        }

    }
    return -1; // retun if out of bounce;
}

$array = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

$l = 0;
$r = count($array) -1;

$res = ternary_search($l, $r, 5, $array);

echo $res !== -1 ? "Found at index [{$res}]" : "Out of bounce";
?>