<?php

require_once "global.php";
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$count = 0;
$col=$langType;
$labelArray=array();
$labelTransArray=array();
if($col=='francais')
{
    $col='french';
}
//echo "yyy";
if($langType !== 'english' &&  !empty($langType)) {
//    echo "sss";
    $labels = mysqli_query( $conn, "select label,label_$col from static_labels" );
    while ( $getLabels = mysqli_fetch_assoc( $labels ) ) {

        $labelTransArray[] = $getLabels[ 'label_'.$col ];
        $labelArray[]= $getLabels[ 'label' ];

    }
}
else
{
//    echo "vvv";
    $labels = mysqli_query( $conn, "select label from static_labels" );
    while ( $getLabels = mysqli_fetch_assoc( $labels ) ) {

        $labelTransArray[] = $getLabels[ 'label' ];
        $labelArray[]= $getLabels[ 'label' ];

    }
}
//echo $langType;
//
//print_r($labelTransArray);
//die();
?>