<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- JAVASCRIPT --> 
<script src="assets/libs/jquery/jquery.min.js"></script> 
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script> 
<script src="assets/libs/metismenu/metisMenu.min.js"></script> 
<script src="assets/libs/simplebar/simplebar.min.js"></script> 
<script src="assets/libs/node-waves/waves.min.js"></script> 



<!-- bootstrap datepicker -->
<script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>



<!-- Required datatable js -->
<script src="assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- Responsive examples -->
<script src="assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>


<!-- validate js -->

<script src="assets/js/validate.js"></script>
<script src="assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
<!-- App js --> 

 <script src="assets/libs/dropzone/min/dropzone.js"></script>
 
<script src="assets/js/app.js"></script>

<script>


$(window).on("load", function(e) {
	$("#global-loader").fadeOut("slow");
});
var timezone_offset_minutes = new Date().getTimezoneOffset();
timezone_offset_minutes = timezone_offset_minutes == 0 ? 0 : -timezone_offset_minutes;
var user_time_zone = timezone_offset_minutes; 
</script>