<?php
include_once("global.php");
if(isset($_SESSION['user_id']))
{
    echo $_SESSION['user_id'];
    $select=mysqli_query($conn,"select * from users where id='{$_SESSION['user_id']}' and is_logged=1");
    if(mysqli_num_rows($select)>0)
    {
        $update=mysqli_query($conn,"update * users set cookie='{$_COOKIE['PHPSESSID']}' where id='{$_SESSION['user_id']}'");
    }
    else
    {
        unset($_SESSION['user_id']);
    }
}

?>