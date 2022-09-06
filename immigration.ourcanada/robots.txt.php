
<?php
include_once("global.php");


if($ext=='.co'){ ?>
    User-Agent: *<br>
    Allow: / <br>
    Sitemap : https://immigration.ourcanada.co/sitemap.xml <br>
<?php } else {?>

    User-Agent: *<br>
    Disallow: / <br>
<?php } ?>
