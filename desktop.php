<?php
$Shortcut = "[InternetShortcut]
URL=http://www.05273.cn/
IDList=
IconIndex=43
IconFile=https://www.05273.cn/favicon.ico
Hotkey=1626
[{000214A0-0000-0000-C000-000000000046}]
Prop3=19,2
";
Header("Content-type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=沭阳网.url;"); 
echo $Shortcut; 
?>