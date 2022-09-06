<?php

require_once 'global.php';
$tab=1;

$tables=mysqli_query($conn,"SHOW FULL TABLES");
while($tr=mysqli_fetch_assoc($tables))
{

    $column=mysqli_query($conn,"SHOW COLUMNS FROM {$tr['Tables_in_ocs']}");
    while($cr=mysqli_fetch_assoc($column))
    {

//        $col=mysqli_query($conn,"ALTER TABLE {$tr['Tables_in_ocs']} MODIFY COLUMN id INT auto_increment");
//        if($col)
//        {
//            echo $tr['Tables_in_ocs'].'--'.$tab.'<br>';
//
//        }
//        else
//        {
//            echo mysqli_error($conn).'<br>';
//
//        }
//        print_r($cr);
        echo '<br>';
    }
$tab++;

}


?>