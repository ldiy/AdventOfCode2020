<?php
$lines = file("input.txt", FILE_IGNORE_NEW_LINES);
$result = 0;
$adapters = array();
foreach ($lines as $line) {
    array_push($adapters, intval($line));
}

array_push($adapters,0); // To outlet
array_push($adapters,max($adapters)+3); // Adapter in device
sort($adapters);
$jolts1 = 0;
$jolts3 = 0;

for($i=0;$i< count($adapters)-1; $i++){
    if($adapters[$i] == $adapters[$i+1] - 1)
        $jolts1++;
    if( $adapters[$i] == $adapters[$i+1] - 3)
        $jolts3++;
}
echo "result: " . $jolts1 * $jolts3 . "\n";