<?php

function color($steps, $whichStep) {
//    $steps = 1280;
    $stepChange = 1280 / $steps;
    $change = $stepChange * $whichStep;
    $r=0; $g=0; $b=0;

    if ($change < 256)
    {
        $r = 255;
        $g += $change;
    }
    else if ($change < 512)
    {
        $r = 511 - $change;
        $g = 255;
    }
    else if ($change < 768)
    {
        $g = 255;
        $b = $change-512;
    }
    else if ($change < 1024)
    {
        $g = 1023 - $change;
        $b = 255;
    }
    else
    {
        $r = $change - 1024;
        $b = 255;
    }   
   
    return array($r,$g, $b);
}

$steps = 1280;
for($i=0;$i<$steps;$i+=10) {
    echo '<div style="background-color: rgb('.implode(',', color($steps, $i)).');height:500px;width:10px; float:left"></div>'."\n";
}
?>
