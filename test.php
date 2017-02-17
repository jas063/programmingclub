<?php
echo '<img src = "cskjdfk.png" alt="fdsgdsg"></img>';?>
<?php
$dest = imagecreatefrompng('uc.png');
$src = imagecreatefrompng('clublogo.png');

imagealphablending($dest, false);
imagesavealpha($dest, true);

imagecopymerge($dest, $src, 10, 9, 0, 0, 181, 180, 100); //have to play with these numbers for it to work for you, etc.


imagepng($dest,'ffsfs.png');

imagedestroy($dest);
imagedestroy($src);?> 
<?php
echo '<img src = "cskjdfk.png" alt="fdsgdsg"></img>';
?>