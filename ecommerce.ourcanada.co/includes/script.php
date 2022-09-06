<!-- tap to top -->
<div class="tap-top top-cls" data-target="html">
    <div>
        <i class="fa fa-angle-double-up"></i>
    </div>
</div>
<script src="<?php echo $baseURL; ?>assets/js/jquery-3.3.1.min.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/popper.min.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/bootstrap.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/bootstrap.min.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/jquery.exitintent.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/exit.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/popper.min.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/slick.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/menu.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/lazysizes.min.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/bootstrap-notify.min.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/prettify.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/jquery.slimscroll.min.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/script.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/filter-sidebar.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/validate.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/adblock.js"></script>
<script src="<?php echo $baseURL; ?>assets/js/jquery.dd.min.js"></script>
<script src="<?php echo $main_domain; ?>/assets/js/translation2.js"></script>



<script>

    $("#language-picker-select").on('change',function(){
        let val = $(this).val() ;
        if(val == 'english'){
            val = '';
        }
        console.log(val);
        <?php
        if(isset($getLangUrl[2])){
            if(is_numeric($getLangUrl[2]))
            {
                $pageURL = '/';
            }
            else
            {
                $pageURL = "/".$getLangUrl[1]."/";
            }

        }else{
            $pageURL = '/';
        }
        ?>
        <?php
        if(isset($pagee) && $pagee > 1)
        {
        ?>
        if(val != "")
        {
            val = val+"/";
        }
        window.location.assign("<?php echo $baseURL; ?><?php  echo $pageURL; ?>"+val+"<?php echo $pagee; ?>");
        <?php
        }
        else
        {
        ?>
        window.location.assign("<?php echo $baseURL; ?><?php echo $pageURL; ?>"+val);
        <?php
        }
        ?>


    });

    $(document).ready(function() {
        $('[data-toggle="popover"]').popover({
            placement: "auto",
            trigger: "click hover",
            html: true
        });
    });
</script>
