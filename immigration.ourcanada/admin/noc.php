<?php
require_once 'global.php';

$select=mysqli_query($conn,"SELECT job_duty,COUNT(job_duty) as count FROM noc_translation GROUP BY job_duty HAVING COUNT(job_duty) > 1;");

//$select=mysqli_query($conn,"SELECT distinct(job_duty) FROM noc_translation");

while($row=mysqli_fetch_assoc($select))
{
    if($row['job_duty']=='')
    {
        continue;
    }
    echo $row['job_duty'].' => Count-'.$row['count'].'<br>';
//    echo $row['job_duty'].'<br>';

}
?>