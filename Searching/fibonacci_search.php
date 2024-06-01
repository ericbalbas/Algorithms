<?php

/**
 * Generates the Fibonacci numbers up to a given value.
 *
 * This function generates the Fibonacci numbers up to a given value $n,
 * returning an associative array containing the last Fibonacci number ($fibMm), 
 * its two predecessors ($fibMm1 and $fibMm2).
 *
 * @param int $n The value up to which Fibonacci numbers are generated.
 * @param int $fibMm2 (Optional) The (m-2)th Fibonacci number. Defaults to 0.
 * @param int $fibMm1 (Optional) The (m-1)th Fibonacci number. Defaults to 1.
 * @return array An associative array containing the last Fibonacci number 
 *               and its two predecessors.
 */
function fibonacci($n, $fibMm2 = 0, $fibMm1 = 1)
{
    // Base case: return Fibonacci series for n = 0 and 1
    if ($n == 0) {
        return ["fibMm1" => -1, "fibMm2" => 0, "fibMm" => 1]; // Special values for n = 0
    } elseif ($n == 1) {
        return ["fibMm1" => 0, "fibMm2" => 0, "fibMm" => 1]; // Special values for n = 1
    }

    $fibMm = $fibMm2 + $fibMm1;

    // Recursive case: call fibonacci() recursively
    if ($fibMm < $n) {
        return fibonacci($n, $fibMm1, $fibMm);
    }

    // Return the last Fibonacci number and its predecessors as an associative array
    return [
        "fibMm1" => $fibMm1, // (m-1)th Fibonacci number
        "fibMm2" => $fibMm2, // (m-2)th Fibonacci number
        "fibMm" => $fibMm,   // mth Fibonacci number
    ]; 
}


function fibonacci_search($arr , $target)
{
    $n = count($arr);
    $fib = fibonacci($n);
    extract($fib); // use to make the key as variable 
    $offset = -1;
    while($fibMm > 1)
    {
        $i = min($offset + $fibMm2, count($arr)-1);

        /* If x is greater than the value at index fibMm2, 
        cut the subarray array from offset to i */
        if($arr[$i] < $target)
        {
            $fibMm = $fibMm1; // m = m1
            $fibMm1 = $fibMm2; // m1 = 2
            $fibMm2 = $fibMm - $fibMm1; //m2 = m - m1
            $offset = $i; 
        }

        /* If x is less than the value at index fibMm2, 
        cut the subarray after i+1 */
        else if($arr[$i] > $target)
        {
            $fibMm = $fibMm2;
            $fibMm1 = $fibMm1 - $fibMm2;
            $fibMm2 = $fibMm - $fibMm1;
        }

        else return $i;

    }
    if ($fibMm1 && $arr[$n - 1] == $target) return $n - 1;

    return -1; 
}
$array = [1,2,3,4,5,6];
$res = fibonacci_search($array, 5);

echo $res !== -1 ? "found at index [{$res}]" : "Out of bounds";
?>