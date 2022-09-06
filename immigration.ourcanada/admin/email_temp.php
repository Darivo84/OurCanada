<?php
require_once 'global.php';

if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $s=mysqli_query($conn,"select * from user_form where id=$id");
    $r=mysqli_fetch_assoc($s);

    echo json_decode($r['email_data']);
}

?>