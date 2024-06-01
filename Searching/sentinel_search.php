<?php
function sentinel_search(array $arr, $target)
{
    $arr [] = $target;  // append to the last;

    $i = 0;

    while ($arr[$i] != $target) $i++;

    array_pop($arr);

    return ($i < count($arr)) ? "Found at index [{$i}]" : "Out of bounds"; 
}

$array = [12,34,53,46,75,34];

echo sentinel_search($array, 53);
?>