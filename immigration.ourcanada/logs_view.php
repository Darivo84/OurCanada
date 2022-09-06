<!DOCTYPE html>
<?php
require "global.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$logsQuery = mysqli_query($conn, "SELECT * FROM ocs.form_error_logs WHERE resolved = '0' ORDER BY id DESC LIMIT 3000 ;");
$logs = mysqli_fetch_all($logsQuery, MYSQLI_ASSOC);



?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <?php require_once 'style.php'?>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">

    <style>
        .modal-body
        {
            height: 500px;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="main">
        <div class="row justify-content-between align-items-center">
            <div class="col-sm-12">
                <h4>Form Subission Error Logs</h4>
            </div>
        </div>
        <div class="row justify-content-between align-items-center">
            <div class="col-sm-12">
                <table id="logs_table" class="table table-striped">
                    <thead>
                        <th>IP</th>
                        <th>Browser</th>
                        <th>Datetime</th>
                        <th>Exception Info</th>
                        <th>Posted Data</th>
                        <th>Form View</th>
                        <th>Time</th>
                        <th >Action</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($logs as $key => $log) {
                        ?>
                            <tr>

                                <td><?php echo $log['ip'] ?></td>
                                <td><?php echo $log['browser'] ?></td>
                                <td><?php echo $log['client_datetime'] ?></td>
                                
                                <td><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exception_modal_<?php echo $log['id']; ?>">View</button></td>
                                <td><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#postdata_modal_<?php echo $log['id']; ?>">View</button></td>
                                <td><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#fdata_modal_<?php echo $log['id']; ?>">View</button></td>
                                <td><?php echo $log['created_at'] ?></td>
                                <td><button  type="button" class="btn btn-sm btn-primary resolveBtn" data-err-log-id="<?php echo $log['id'] ?>" >Resolve</button></td>

                            </tr>

                        <?php

                        }

                        ?>
                    </tbody>
                </table>
                <?php

                foreach ($logs as $key => $log) {
                ?>
                    <div class="modal fade" id="cv_modal_<?php echo $log['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Client Info</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>IP Address</th>
                                                <td><?php echo $log['ip']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Time Zone</th>
                                                <td><?php echo $log['timezone']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Browser</th>
                                                <td><?php echo $log['browser']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="fdata_modal_<?php echo $log['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Form Inputs</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">

                                            <?php

                                            echo (($log['form_html']));
                                            ?>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="exception_modal_<?php echo $log['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Exception Info</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <pre>
                                    <?php

                                    print_r(json_decode($log['exception_info']));
                                    ?>
                                    </pre>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="postdata_modal_<?php echo $log['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Post Request Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <pre>
                                    <?php

                                    print_r(json_decode($log['post_data']));
                                    ?>
                                    </pre>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                <?php
                }

                ?>
            </div>

        </div>
    </div>
    <?php require_once 'script.php'?>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#logs_table').DataTable({
                "ordering": false
            });
            $(".select2-focusser").hide();
            $(".select2-input").hide();
            
        });

        $(document).on("click",".resolveBtn",function(){
            

            $resolveBtn = $(this);
            logId = $resolveBtn.attr("data-err-log-id");
            $.ajax({
                        dataType: 'json',
                        url: "bg_ajax.php?h=markasresolved",
                        type: 'POST',
                        async: false,
                        data: {
                            logId:logId
                        },

                        success: function (data) 
                        {
                            
                            
                            $resolveBtn.parent('td').html("Resolved");
                            $resolveBtn.remove();
                        },
                        error: function (data) {
                           
                        
                        }


                    });




        });
    </script>
</body>

</html>