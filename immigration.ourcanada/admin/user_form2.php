<?php
include_once( "global.php" );

$getQuery = mysqli_query($conn , "SELECT * FROM user_form where id={$_GET['id']}");
$r=mysqli_fetch_assoc($getQuery);

?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <ul>
                    <?php
                    $questions=json_decode($r['questions']);
                    $answers=json_decode($r['answers']);
                    $ques_check='';
                    for($i=0;$i<sizeof($questions);$i++) {

                                ?>
                                <li><?php echo $questions[$i] ?> <br><b><?php echo $answers[$i] ?></b></li>

                                <?php

                    }
                    ?>
                </ul>
            </div>

        </div>
    </div>
</div>