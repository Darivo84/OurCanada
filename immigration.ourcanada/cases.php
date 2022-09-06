<?php
include_once("global.php");

if(isset($_GET['id']))
{
    $query = "SELECT * FROM form_submission_cases where form_id={$_GET['id']}";

}
else
{
    $query = "SELECT * FROM form_submission_cases order by id desc;";

}
$queryResult = mysqli_query($conn, $query);
$logs = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Submission Cases </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
</head>

<body>
    <style>
        pre {
            white-space: pre-wrap;
        }
    </style>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h1>Form Submission Cases</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-stripped" id="log_dt">
                    <thead>
                        <th>#</th>
                        <th>Form Id</th>

                        <th>Cases Array</th>
                        <th>Occurred At</th>


                    </thead>
                    <tbody>
                        <?php
                        if (count($logs) > 0) {
                            for ($i = 0; $i < count($logs); $i++) {
                        ?>
                                <tr>
                                    <td><?php echo ($i + 1); ?></td>
                                    <td><?php echo ($logs[$i]['form_id']); ?></td>
                                    <td> <span data-toggle="modal" data-target="#clientInfoModal<?php echo ($logs[$i]['id']); ?>">View</span>
                                        <div class="modal fade" id="clientInfoModal<?php echo ($logs[$i]['id']); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Cases Array</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <ul>
                                                            <?php
                                                            $cases=(json_decode($logs[$i]['case_array']));
                                                            $count==0;
                                                            foreach ($cases as $item) {
                                                                if(is_array($item))
                                                                {
                                                                    print_r($item);

                                                                }
                                                                else
                                                                {
                                                                    echo '<li>'.$item.'</li>';

                                                                }
                                                                $count++;
                                                            }
                                                            ?>
                            </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </td>

                                    <td><?php
                                        $gmtTimezone = new DateTimeZone('GMT');
                                        $myDateTime = new DateTime($logs[$i]['created_at'], $gmtTimezone);
                                        $myDateTime->setTimezone(new DateTimeZone('GMT+5'));

                                        echo $myDateTime->format('Y-m-d H:i:s')?>

                                    </td>


                                </tr>
                        <?php
                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#log_dt").DataTable({
                responsive: true
            });


            $(".folder_jstree").each(function() {
                var outId = $(this).attr("id");
                var txtareaoutId = $(this).attr("data-idd");

                var folder_jsondata = JSON.parse($('#' + txtareaoutId).val());
                // alert(folder_jsondata)
                $('#' + outId).jstree({
                    'core': {
                        'data': folder_jsondata,
                        'multiple': true
                    }
                });
            });






        });
    </script>
</body>