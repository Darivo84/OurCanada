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
<script src="<?php echo $currentTheme; ?>js/validate.js"></script>
<script src="<?php echo $currentTheme; ?>js/moment.min.js" defer></script>
<script src="<?php echo $currentTheme; ?>js/lodash.min.js" defer></script>
<script src="<?php echo $currentTheme; ?>js/select2.min.js" defer></script>

<script src="<?php echo $currentTheme; ?>js/moment.js" type="text/javascript" defer></script>
<script src="<?php echo $currentTheme; ?>js/datepicker.js" type="text/javascript" defer></script>
<script src="<?php echo $currentTheme; ?>js/angular.min.js" defer></script>
<script src="<?php echo $currentTheme; ?>js/bootstrap-tagsinput.js" defer></script>
<script src="<?php echo $currentTheme; ?>js/typeahead.bundle.min.js" defer></script>
<script src="<?php echo $currentTheme; ?>js/lang.js" type="text/javascript" defer></script>
<script src="<?php echo $currentTheme; ?>js/selectize.min.js" type="text/javascript" defer></script>
<script src="<?php echo $currentTheme; ?>js/jquery.toaster.js"></script>
<script src="<?php echo $currentTheme; ?>js/crash.js"></script>

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

        $.toaster({ priority : priority, title : title, message : message});
    }
    jQuery(window).bind('beforeunload', function(){
        alert('Are you sure you want to leave?')
        return 'my text';
    });
</script>