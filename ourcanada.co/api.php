<?php



include 'global.php';

$reqURL = explode("/", $_SERVER['REQUEST_URI']);

$param = $reqURL[2];



$json = file_get_contents('php://input');

// Converts it into a PHP object

$inputreq = json_decode($json, true);

$count = 0;



$limit = $inputreq['limit'];

$offset = $inputreq['offset'];

if (!isset($offset)) {

    $offset = 0;

}



$media_url = "https://ecommerce.ourcanadadev.site/admin/uploads/";





function loadTableColumns($table) {

    global $conn, $tableArr, $inputreq, $dbquery, $limit, $offset;



    $table_column = mysqli_query($conn, "SHOW COLUMNS FROM $table");

    $tableArr = array();

    while ($row1 = mysqli_fetch_assoc($table_column)) {

        $tableArr[] = $row1;

    }

    if (!empty($inputreq['id'])) {



        if (is_array($inputreq['id'])) {

            $idsarr = $inputreq['id'];

            $dbquery .= "WHERE id IN ('" . implode("','", $idsarr) . "') ";

        } else {



            $dbquery .= "WHERE id = '" . $inputreq['id'] . "'";

        }

    } else {



        if (sizeof($inputreq) >= 1) {

            $dbquery .= " WHERE ";

            foreach ($inputreq as $key => $value) {

                foreach ($tableArr as $col) {

                    if ($key == $col['Field']) {



                        if (is_array($value)) {

                             $dbquery .= " " . $key . " IN ('" . implode("','", $value) . "')  AND";

                        } else {

                            if ((strpos($col['Type'], 'int') !== false) || (strpos($col['Type'], 'float') !== false) || (strpos($col['Type'], 'double') !== false)) {



                                $dbquery .= " " . $key . " = '" . $value . "' AND";

                            } else {



                                $dbquery .= " " . $key . " LIKE '%" . $value . "%' AND";

                            }

                        }

                    }

                }

            }

            if (isset($offset) && $offset > 0 && !isset($limit)) {

                $dbquery .= " id > " . $offset;

            } else {

                $words = explode(" ", $dbquery);

                if ($words[count($words) - 1] == "AND") {

                    array_splice($words, -1);

                }

                $dbquery = implode(" ", $words);

            }

        }

    }

    $dbquery .= " ORDER By id DESC ";

    if (isset($limit)) {

        $dbquery .= " LIMIT " . $offset . "," . $limit;

    }

}



if ($param == 'products') {

    $arrArray = array();

    $dbquery = "SELECT * FROM product ";



    loadTableColumns('product');




    
    $queryresult = mysqli_query($conn, $dbquery);

    $totCount = mysqli_num_rows($queryresult);

    while ($row = mysqli_fetch_assoc($queryresult)) {

       $imgs = $row['images'];

        $imgarray = explode(',',$imgs);

        for($i = 0;$i < count($imgarray); $i++)

        {

            if(!empty($imgarray[$i]))

            {

            $imgarray[$i]= $media_url.$imgarray[$i];

            }

        }

       $row['images'] = implode(", ", $imgarray);

        $arrArray[] = $row;

    }



    die(json_encode(array('results' => $arrArray, 'total' => $totCount)));

}





// Get Products Listing

if ($param == 'products1') {

    $search = '';

    $q = mysqli_query($conn, "SELECT * FROM product");

    $field = mysqli_num_fields($q);



    for ($i = 0; $i < $field; $i++) {

        $names = mysqli_fetch_field_direct($q, $i);

        if (array_key_exists($names->name, $data)) {

            if ($i < $field) {

                $search .= $names->name . ' LIKE %' . $data[$names->name] . '% AND ';

            } else {

                $search .= $names->name . ' LIKE %' . $data[$names->name] . '%';

            }

        }

    }



    $query = "SELECT * FROM product WHERE " . $search;

    echo $query;

    die(json_encode(array('results' => $arrArray, 'total' => $totCount)));

}

?>

