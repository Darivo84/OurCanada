<!--bottom to top button start-->
<button class="scroll-top scroll-to-target" data-target="html">
    <span class="ti-angle-up"></span>
</button>
<!--bottom to top button end-->


<!--jQuery-->
<script src="<?php echo $currentTheme; ?>js/jquery-3.4.1.min.js"></script>
<!--Popper js-->
<script src="<?php echo $currentTheme; ?>js/popper.min.js" defer></script>
<!--Bootstrap js-->
<script src="<?php echo $currentTheme; ?>js/bootstrap.min.js" defer></script>
<!--jquery easing js-->
<script src="<?php echo $currentTheme; ?>js/jquery.easing.min.js" defer></script>
<!--wow js-->
<script src="<?php echo $currentTheme; ?>js/wow.min.js" defer></script>
<!--custom js-->
<script src="<?php echo $currentTheme; ?>js/scripts.js" defer></script>
<?php
if(!empty($getLangUrl[1]))
{
    ?>
    <script src="<?php echo $currentTheme; ?>js/validate.js"></script>
    <script src="<?php echo $currentTheme; ?>js/angular.min.js" defer></script>
    <script src="<?php echo $currentTheme; ?>js/lodash.min.js" defer></script>
    <script src="<?php echo $currentTheme; ?>js/moment.js" type="text/javascript" defer></script>
<?php
}
?>

<script src="<?php echo $currentTheme; ?>js/select2.min.js" defer></script>

<script src="<?php echo $currentTheme; ?>js/datepicker.js" defer></script>
<script src="<?php echo $currentTheme; ?>js/bootstrap-tagsinput.js" defer></script>
<script src="<?php echo $currentTheme; ?>js/typeahead.bundle.min.js" defer></script>
<script src="<?php echo $currentTheme; ?>js/selectize.min.js" defer></script>
<script src="<?php echo $currentTheme; ?>js/jquery.toaster.js"></script>
<script src="<?php echo $currentTheme; ?>js/crash.js"></script>
<!--<script src="--><?php //echo $currentTheme; ?><!--js/jquery.dd.min.js"></script>-->


<!-- For static pages excluding form -->
<?php if($webConversion == true) { ?>
<script>
    var labelsArray = new Array();
    labelsArray = <?php echo json_encode($labelArray); ?>;
    var labelsTransArray = new Array();
    labelsTransArray = <?php echo json_encode($labelTransArray); ?>;
</script>



<script src="<?php echo $mainURL; ?>/assets/js/translation2.js"></script>
<script>
    <!-- ID is changed so the dropdown will not conflict -->
    $("#languagePickerSelect").on('change',function(){
        let val = $(this).val() ;
        if(val == 'english'){
            val = '';
        }
    <?php
            $code='';
        $getLangUrl = explode("/",$_SERVER['REQUEST_URI']);
        if(isset($getLangUrl[2])){
            $pageURL = "/".$getLangUrl[1]."/";
        }else{
            if(isset($getLangUrl[1]))
            {
                $s=mysqli_query($conn,"select * from `multi-lingual` where lang_slug='$getLangUrl[1]'");
                if(mysqli_num_rows($s)>0 || $getLangUrl[1]=='francais')
                {
                    $pageURL = "/";
                }
                else
                {
                    $pageURL = "/".$getLangUrl[1]."/";
                }
            }
        }

        if($getLangUrl[1]=='change-password')
        {
            if(isset($getLangUrl[3])){
               $code="/".$getLangUrl[3];
            }else{
                $code="/".$getLangUrl[2];
            }
        }
        ?>
        var display = $('#languagePickerSelect option:checked').attr('data-id');
        localStorage.setItem('display', display);
        console.log('<?php echo sizeof($getLangUrl) ?>')

        console.log('<?php echo $getLangUrl[0] ?>')
        console.log('<?php echo $getLangUrl[1] ?>')
        console.log('<?php echo $getLangUrl[2] ?>')
        console.log('<?php echo $getLangUrl[3] ?>')

        console.log('<?php echo $baseURL; ?><?php echo $pageURL; ?>'+val+'<?php echo $code; ?>')
       window.location.assign("<?php echo $baseURL; ?><?php echo $pageURL; ?>"+val+"<?php echo $code; ?>");

    });
</script>

<?php } ?>
<script>
    function make_toast (type,response,msg)
    {
        let priority = type;
        let title    = response;
        let message  = msg;
        if($('#toaster').children().length > 0)
        {
            $('#toaster').children().remove()
        }

        $.toaster({ priority : priority, title : title, message : message });
    }

    $(document).ready(function() {
        //$("#languagePickerSelect").msDropdown();
        <?php
        if(isset($_SESSION['with_notify']) && isset($_SESSION['user_id'])){ ?>
        $("#with_notify").modal("show");
        <?php }
        unset($_SESSION['with_notify']);
        ?>
    })

</script>