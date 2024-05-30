<?php

function search(array $array, $target)
{
    foreach($array as $key => $value)
    {
        if($value === $target) return "found in array at index[{$key}]";
    }

    return "Not found!";
}

$array = [1,2,3,4,5];

$result = search($array, 4);

echo $result;

?>