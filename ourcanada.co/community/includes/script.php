
<script>

    <?php
    /*echo file_get_contents($cms_url."/assets/js/jquery-3.4.1.min.js");
    echo file_get_contents($cms_url."/assets/js/fluidvids.js");
    echo file_get_contents($cms_url."/assets/js/infinitescroll.js");
    echo file_get_contents($cms_url."/assets/js/justified.js");
    echo file_get_contents($cms_url."/assets/js/slick.js");
    echo file_get_contents($cms_url."/assets/js/theia-sticky-sidebar.js");
    echo file_get_contents($cms_url."/assets/js/aos.js");

    echo file_get_contents($cms_url."/assets/js/custom.js");
    echo file_get_contents($cms_url."/assets/js/validate.js");
    echo file_get_contents($cms_url."/assets/js/bootstrap.js");
    echo file_get_contents($cms_url."/assets/js/extjs/ext-core.js");
    echo file_get_contents($cms_url."/assets/js/extjs/elastic-textarea.js");*/


    ?>
</script>
<script src="<?php echo $cms_url ?>assets/js/jquery-3.4.1.min.js"></script>
<script src="<?php echo $cms_url ?>assets/js/fluidvids.js"></script>
<script src="<?php echo $cms_url ?>assets/js/infinitescroll.js"></script>
<script src="<?php echo $cms_url ?>assets/js/justified.js"></script>
<script src="<?php echo $cms_url ?>assets/js/slick.js"></script>
<script src="<?php echo $cms_url ?>assets/js/theia-sticky-sidebar.js"></script>
<script src="<?php echo $cms_url ?>assets/js/aos.js"></script>
<script src="<?php echo $cms_url ?>assets/js/custom.js"></script>
<script src="<?php echo $cms_url ?>assets/js/validate.js"></script>
<!---->
<script src="<?php echo $cms_url ?>assets/js/bootstrap.js"></script>
<!---->
<!---->
<?php
if(!empty($getLangUrl[2]))
{
    ?>
    <script src="<?php echo $cms_url ?>assets/js/extjs/ext-core.js"></script>

<?php
}
?>
<script src="<?php echo $cms_url ?>assets/js/extjs/elastic-textarea.js"></script>

<!-- trans -->
<script>
    var labelsArray = new Array();
    labelsArray = <?php echo json_encode($labelArray); ?>;
    var labelsTransArray = new Array();
    labelsTransArray = <?php echo json_encode($labelTransArray); ?>;
</script>

<script type="text/javascript">
    <?php echo file_get_contents($baseURL."/assets/js/translation2.js"); ?>
</script>
<?php if($displayType == 'Right to Left'){ ?>
        <script>
           $(document).on('ready',function (){
              $("body").addClass("RightToLeft")
               localStorage.setItem('display','<?php echo $displayType ?>')

           });
        </script>
    <?php } ?>
<script type="text/javascript">
    $(document).on('ready',function (){
            localStorage.setItem('display','<?php echo $displayType ?>')
        });
        $(document).on('change','#language-picker-select',function(){
            console.log('dropdown changed')
            let val = $(this).val() ;
            let display = $(this).attr('data-id')
            if(val == 'english'){
                val = '';
            }
            localStorage.setItem('display','<?php echo $displayType ?>')
            <?php

            if(sizeof($getLangUrl)>2){
                $pageURL = $getLangUrl[2]."/";
            }else{
                $pageURL = '';
            }

            if(sizeof($getLangUrl) >= 4 && ($getLangUrl[2]=='edit-content' || $getLangUrl[2]=='blog' || $getLangUrl[2]=='news')){
                $pageURL = $getLangUrl[2].'/'.$getLangUrl[3].'/';
            }
            if($getLangUrl[2]=='edit-content' && strpos($getLangUrl[4],'?')!==false)
            {
                $editType = explode('?',$getLangUrl[4]);
            }

            ?>
            let url1='<?php echo $getLangUrl[2] ?>'
                let url2='<?php echo $getLangUrl[4] ?>'
            var cur_url = window.location.href;
            var cur_lang = cur_url.split("/");
            cur_lang = cur_lang[cur_lang.length - 1];
            
            var present_in_list = false;

            $("#language-picker-select option").each(function(){
                if(cur_lang == $(this).val()){
                    present_in_list = true;
                }
            });
            let urlNow='';
            if(url1=='edit-content' && url2.includes('?'))
            {
                urlNow="<?php echo $cms_url.$getLangUrl[2].'/'.$getLangUrl[3].'/'; ?>"+val+"<?php echo '?'.$editType[1] ?>"
            }
            console.log(urlNow)

            if(present_in_list){

                if(urlNow!=='')
                {
                    window.location.href=urlNow;
                }

                if(val == ""){
                    window.location.href = cur_url.replace("/"+cur_lang,"");
                }else{
                    window.location.href = cur_url.replace("/"+cur_lang,"/"+val);
                }
            }else{

                var move_to = cur_url+"/"+val;
                move_to = move_to.replace("//"+val,"/"+val);
                if(urlNow!=='')
                {
                    move_to=urlNow;
                }
               window.location.href = move_to;
            }
           // window.location.assign("<?php echo $cms_url; ?><?php echo $pageURL=='/'?'':$pageURL; ?>"+val);
        });
</script>

<!-- trans end -->

<script>
jQuery(window).on("load", function(e) {
		jQuery("#global-loader").fadeOut("slow");
	})
<?php echo $login_popup; ?>

$( '#referFriend' ).validate({
    messages: {
        email: {
            required: '<?= $allLabelsArray[48] ?>',
            email: '<?= $allLabelsArray[32] ?>',
        },
    },
        submitHandler: function () {
            'use strict';
            $("#referProcess").html('  <i class="fa fa-spinner fa-spin"></i> <?= $allLabelsArray[43] ?>');
            $.ajax({
                dataType: 'json',
                url: "<?= $cms_url ?>refer.php?h=referFriend&lang=<?= getCurLang($langURL,true) ?>",
                type: 'POST',
                data: $("#referFriend").serialize(),
                beforeSend: function(){
                    $("#referProcess").prop("disabled",true);
                    $(".alertRefer").html('');
                },
                success: function (data) {
                    $("#referProcess").prop("disabled",false);
                    console.log(data)
                    if (data.Success == 'true') {
                        $("#referProcess").html('<?= $allLabelsArray[709] ?>');
                        $("#referEmail").val('');
                        $(".alertRefer").html('<div class="alert alert-success"><i class="fa fa-check" style="margin-right: 10px;"></i>' + data.Msg + '</div>');
                        var t = $("#tokenModal #totalReferal").text();
                        t = parseInt(t);
                        t = t+1;
                        $("#tokenModal #totalReferal").text(t);
                    } else {
                        $("#referProcess").html('<?= $allLabelsArray[709] ?>');
                        $(".alertRefer").html('<div class="alert alert-danger"> <i class="fa fa-trash" style="margin-right: 10px;"></i> ' + data.Msg + '</div>');
                    }
                     setTimeout(function(){
                        $(".alertRefer").html("");
                     },15000);
                },error: function(e){
                    $("#referProcess").html('<?= $allLabelsArray[709] ?>');
                    $("#referProcess").prop("disabled",false);
                    console.log(e)
                }
            });
            return false;
        }
    });

    $(".close").on('click',function(){
       $("#referEmail").val('');
       $(".alertRefer").html('');
    });

function show_hide(sel){
    if(sel.siblings("input").attr("type") == "text"){
        sel.siblings("input").attr("type","password");
        sel.removeClass("fa fa-eye");
        sel.addClass("fa fa-eye-slash");

    }else{
        sel.siblings("input").attr("type","text");
        sel.removeClass("fa fa-eye-slash");
        sel.addClass("fa fa-eye");
    }
}
</script>
<?php if($displayType == 'Right to Left'){ ?>
    <script>
        $('div,h1,h2,h3,h4,h5,h6').each(function () {
           // $(this).addClass('urduClass')
        })

    </script>
<?php } ?>


<script type="text/javascript">
    
    var dt = new Date();
    var c_date = dt.getDate();
    var c_month = dt.getMonth() + 1;
    var c_year = dt.getFullYear();
    var c_hour = dt.getHours();
    var c_min = dt.getMinutes();
    var c_sec = dt.getSeconds();
    var total_sec = c_hour * 60 * 60 + (c_min * 60) + c_sec;
    var months_name = [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Des'
    ];
    $(".user_cur_date").text(c_date+" "+months_name[c_month - 1]+", "+c_year);

    $(document).on("click","#close_continueLoginmodal",function(){
            $( "#addLoader" ).html( '   <?= $allLabelsArray[11] ?>' );
        });

        $(document).on("click","#continueLoginbtn",function(){
            $( "#continueLoginbtn" ).html( '<span class="spinner-border spinner-border-sm" role="status"></span> <?php echo $allLabelsArray[43] ?>');
            $.ajax( {
                dataType: 'json',
                url: "<?php echo $cms_url; ?>ajax?h=continue_login<?php echo '&lang='.str_replace('/','',$langURL);?>",
                type: 'POST',
                data: $( "#validateform" ).serialize(),
                success: function ( data ) {
                    $( "#continueLoginbtn" ).text( '<?php echo $allLabelsArray[28] ?>' );
                    if ( data.Success === 'true' ) {
                        $( window ).scrollTop( 0 );
                        // document.getElementById( "validateform" ).reset();

                        $("#continueLoginbtn").hide();

                        $( '#continueAlert' ).html( '<div class="alert alert-success" style=""><i class="fa fa-check" style="margin-right:10px;"></i>' + static_label_changer(data.Msg) + '</div>' );


                        // $(".prompt").html('<div class="alert alert-success"><i class="fa fa-check"></i>'+data.Msg+'</div>');
                        setTimeout(function() {
                            window.location = "<?= $cms_url.getCurLang($langURL,true) ?>";
                        }, 1000);

                    }
                    else
                    {

                    }


                },
                error:function(){
                    $( "#continueLoginbtn" ).text( static_label_changer('Continue') );
                }
            } );
        })
        
</script>