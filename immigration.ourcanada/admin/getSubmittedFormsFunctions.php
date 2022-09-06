<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Block IP Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="prompt"></div>
                <div id="deleteBox">
                    <i class="mdi mdi-alert-outline mr-2"></i>
                    <h3>Are you sure?</h3>
                    <p >You want to <strong id="blockP">block</strong> this IP Address!</p>
                </div>
                <input type="hidden" name="id" id="did">
                <input type="hidden" name="ban" id="ban">

                <button type="button" class="btn btn-danger waves-effect waves-light" id="delLoader">Yes</button>
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">No</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div id="mailModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myModalLabel">Resend Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="prompt"></div>
                <div id="deleteBox">
                    <i class="mdi mdi-alert-outline mr-2"></i>
                    <h3>Are you sure?</h3>
                    <p>You want to send email again ?</p>
                </div>
                <input type="hidden" name="id" id="id">

                <button type="button" class="btn btn-danger waves-effect waves-light" id="resendLoader">Yes</button>
                <button type="button" class="btn btn-secondary waves-effect" id="close" data-dismiss="modal">No</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
    var dt;
    $(document).ready(function () {
        dt= $('#datatable1').DataTable()
        $('#datatable11').DataTable( {
            ajax: {
                url: 'ajax.php?h=loadSubmittedForm',
                method: "GET",
                xhrFields: {
                    withCredentials: true
                }
            },
            columns: [
                { data: "count" },
                { data: "user_name" },
                { data: "user_email" },
                { data: "total_score" },
                { data: "created_date" },
                { data: "account_type" },
                { data: "account_email" },
                { data: "ip_address" },

                { data: "blocked" },
                { data: "action" },


                /*and so on, keep adding data elements here for all your columns.*/
            ]
        } );

    })
    $('#filterSearch').change(function () {
        let val=$(this).val()
        dt.column(5).search(val).draw()
    })

    $("#resendLoader").on('click',function(){
        var id = $("#id").val();
        $( "#resendLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $( "#resendLoader" ).prop('disabled',true)
        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=resend_email",
            type: 'POST',
            data: {'id' : id},
            success: function ( data ) {
                $( "#resendLoader" ).html( 'Yes' );
                $( "#resendLoader" ).prop('disabled',false)
                if(data.Success == 'true'){

                    $( '.prompt' ).html( '<div class="alert alert-success" style="text-align:left !important"><i class="fas fa-check" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                    setTimeout( function () {
                        $('#close').click()
                        $( "div.prompt" ).html('');
                        $( "div.prompt" ).hide();
                    }, 3000 );
                }else{
                    $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).html('');
                        $( "div.prompt" ).hide();
                    }, 5000 );
                }
            }
        } );
    });

    function resendMail(id){
        $("#id").val(id);
        $("#mailModal").modal();
    }
    function DeleteModal(ip,ban){
        if(ip!=='' && ip!==null)
        {
            if(ban==1)
            {
                $('#blockP').html('unblock')
            }
            else
            {
                $('#blockP').html('block')
            }
            $("#did").val(ip);
            $("#ban").val(ban);

            $("#deleteModal").modal();
        }
        else
        {
            alert('No Ip Registered')
        }

    }
    $("#delLoader").on('click',function(){
        var ip = $("#did").val();
        var ban = $("#ban").val();

        $( "#delLoader" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> Processing' );
        $.ajax( {
            dataType: 'json',
            url: "ajax.php?h=blockIP",
            type: 'POST',
            data: {'ip' : ip , 'ban':ban},
            success: function ( data ) {
                $( "#delLoader" ).html( 'Yes' );

                if(data.Success == 'true'){
                    window.location.reload()
                }else{
                    $( window ).scrollTop( 0 );
                    $( '.prompt' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                    setTimeout( function () {
                        $( "div.prompt" ).hide();
                    }, 5000 );
                }
            }
        } );
    });

</script>
