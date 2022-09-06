<?php
include_once( "global.php" );

$getQuery = mysqli_query($conn , "SELECT * FROM user_form where id={$_GET['id']}");
$r=mysqli_fetch_assoc($getQuery);
$questions=json_decode($r['questions']);
$answers=json_decode($r['answers']);
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <ul>
                    <?php


                    $ques_check='';
                    for($i=0;$i<sizeof($questions);$i++) {
                        if ($answers[$i] != '' && $answers[$i] != 'NaN') {

                            if (strpos($questions[$i], 'Date') !== false || strpos($questions[$i], 'date') !== false || (strpos($questions[$i], 'born') !== false &&  strpos($questions[$i], 'child') !==false && (strpos($questions[$i], '(') < 0 || strpos($questions[$i], '(') == '' ) ))

                            {

                                $questions[$i+1] = $questions[$i];

                                $i++;
                            }
                            if($questions[$i]==$questions[$i+1] && (strpos($questions[$i], 'Position') !==false || strpos($questions[$i], 'work-experience') !==false || strpos($questions[$i], 'Please describe time period') !==false || strpos($questions[$i], 'Please select time period') !==false))
                            {
                                if($answers[$i+1]=='' || $answers[$i+1]==null)
                                {
                                    continue;
                                }
                                if(strtotime($answers[$i+1])){
                                    // it's in date format
                                }
                                else
                                {
                                    $answers[$i+1]='Present';
                                }
                                $answers[$i]='From: <b>'.$answers[$i].'</b> To: <b>'.$answers[$i+1].'</b>';
                                ?>
                                <li><?php echo $questions[$i] ?> <br><?php echo $answers[$i] ?></li>
                                <?php
                                $i++;
                            }

                            else
                            {
                                if(strpos($questions[$i],'show')!==false)
                                {
                                    ?>
                                    <li><b><?php echo $answers[$i] ?></b></li>

                                    <?php
                                    continue;
                                }
                                if($questions[$i]=='')
                                {
                                    continue;
                                }

                                ?>
                                <li><?php echo $questions[$i] ?> <br><b><?php echo $answers[$i] ?></b></li>

                                <?php
                            }
                        }

                        $ques_check=$questions[$i];
                    }
                    ?>
                </ul>
            </div>

        </div>
    </div>
</div>