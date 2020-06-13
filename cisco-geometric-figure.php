<?php
$img = imagecreatetruecolor(1360,768);

function regularPolygon($img,$x,$y,$radius,$sides,$color)
{
    $points = array();
    for($a = 0;$a <= 360; $a += 360/$sides)
    {
        $points[] = $x + $radius * cos(deg2rad($a));
        $points[] = $y + $radius * sin(deg2rad($a));
    }
    return imagepolygon($img,$points,$sides,$color);
}

regularPolygon($img,1360/2,768/2,180,4,0xffffff);
regularPolygon($img,1360/2,768/2,240,360,0xffffff);
regularPolygon($img,1360/2,768/2,300,6,0xffffff);

header('Content-type: image/png');
imagepng($img);
imagedestroy($img);
?>