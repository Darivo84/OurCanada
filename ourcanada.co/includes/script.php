
<script>
    var labelsArray = new Array();
    labelsArray = <?php echo json_encode($labelArray); ?>;
    var labelsTransArray = new Array();
    labelsTransArray = <?php echo json_encode($labelTransArray); ?>;


    <?php
    echo file_get_contents($baseURL."/assets/js/vendor/jquery-1.12.4.min.js");
    echo file_get_contents($baseURL."/assets/js/bootstrap.min.js");
    echo file_get_contents($baseURL."/assets/js/popper.min.js");
    echo file_get_contents($baseURL."/assets/js/wow.min.js");
    echo file_get_contents($baseURL."/assets/js/wow.min.js");
    echo file_get_contents($baseURL."/assets/js/jquery.meanmenu.min.js");
    echo file_get_contents($baseURL."/assets/js/onepage-nav.min.js");
    echo file_get_contents($baseURL."/assets/js/main.js");
    echo file_get_contents($baseURL."/assets/js/translation2.js");
    echo file_get_contents($baseURL."/assets/js/validate.js");
    echo file_get_contents($baseURL."/assets/js/select2.min.js");
    ?>

    $('.main-mneu ul li').click(function () {
        let curClass=$(this).attr('class')
        if(curClass=='active' || curClass.includes('active'))
        {
            $(this).removeClass('active')
        }
    })
</script>

<?php include("js_functions.php") ?>


