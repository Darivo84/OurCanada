<?php
require_once '../user_inc.php';
require_once '../allLabels.php';

$_GET['Lang']=explode('_',$_GET['Lang']);
$size=sizeof($_GET['Lang']);
?>
var labels = new Array();
labels = <?php echo json_encode($labels); ?>;
var language_change=false
var parameter_size=<?php echo $size; ?>

$(document).ready(function () {

    $("#languagePickerSelect").focus(function () {
        // Store the current value on focus, before it changes
        $('#prevLang').val(this.value);
    })
	$("#languagePickerSelect").on('change', function () {

    var display = $('#languagePickerSelect option:checked').attr('data-id');
    language_change=true
    let val = $(this).val()
    let url = window.location.origin
    let full_url = (window.location.href).split('/')
    let file_name = full_url[3].split('?');
    let changeURL='';
    localStorage.setItem('form_in_process',"no");
    if (val == 'english') {
        changeURL=url + '/' + file_name[0]
    } else {
        changeURL=url + '/' + file_name[0] + '/' + val
    }

        if ((localStorage.getItem('AgreeCheck') == '1' || localStorage.getItem('AgreeCheck') == 1) && parameter_size==2)
        {
            console.log('lang change-'+val)
            console.log('phpLAng-'+labels[86][val])
            if(val=='urdu' || val=='arabic')
            {
                $('#languageChangeModal .modal-header').css('direction','rtl')
                $('#languageChangeModal .modal-content').css('text-align','right')
                $('#languageChangeModal .modal-footer').css('direction','rtl')

            }
            else
            {
                $('#languageChangeModal .modal-header').css('direction','ltr')
                $('#languageChangeModal .modal-content').css('text-align','left')
                $('#languageChangeModal .modal-footer').css('direction','ltr')


            }


            let error_msg = labels[86][val]//'<?php echo $_GET['Lang'][1] ?>'//"If you want to change language, your previous form data will be lost"
            $('#langChangeNo').html(labels[41][val])
            $('#langChangeYes').html(labels[40][val])

            $('#languageChangeLabel').html(error_msg)
            $('#languageChangeModal').modal('show')
            $('#langChangeLink').attr('data-url',changeURL)
        }
        else
        {
           window.location.assign(changeURL)
        }

    //localStorage.setItem('display', display);

  });
	let lang='<?php echo $_GET['Lang'][0]=='' ? 'english' : $_GET['Lang'][0]; ?>'
	localStorage.setItem('Lang',lang)

  $("#languagePickerSelect").val(lang);

  //changeClass();

});
function changeClass() {
    if (localStorage.getItem('display') == 'Right to Left') {
        $(".quesCreate").addClass("urduListing");
        $(".quesCreate").removeClass("engListing");

        $("input[type='radio']").parent().addClass("checkbox");

    } else {
        $(".quesCreate").removeClass("urduListing");
        $(".quesCreate").addClass("engListing");
    }
}
var rTitle = '';
