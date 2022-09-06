$(document).ready(function(){
    changeStaticLabels();
})

function changeStaticLabels() {
    $('.static_label').each(function() {
        let innerHtml = $(this).attr('data-org')
        if (innerHtml !== '' && innerHtml !== null) {
            if ($(this).attr('data-org')) {
                innerHtml = $(this).attr('data-org')
            } else {
                innerHtml = $(this).attr('data-html')
            }
            if(innerHtml !== undefined){
                if (innerHtml.includes('&amp;')) {
                    innerHtml = innerHtml.replace('&amp;', '&')
                }
            }

            let index = labelsArray.indexOf(innerHtml)
            console.log(innerHtml+'-'+index);

            if (index > -1) {
                if (labelsTransArray[index] != '') {
                    $(this).html(labelsTransArray[index])
                }
            }

            if($(this).html() == ''){
                $(this).html(innerHtml);
            }

        }


    })

    changeErrorLabels();
}

function changeErrorLabels() {

    $('label.error').each(function() {

        let innerHtml = $(this).html()
        if (innerHtml.includes('&amp;')) {
            innerHtml = innerHtml.replace('&amp;', '&')
        }
        let index = labelsArray.indexOf(innerHtml)
        if (index > -1) {
            if (labelsTransArray[index] != '') {
                $(this).html(labelsTransArray[index])
            }
        }
    })
        set_alignment();
}

function static_label_changer(label) {
    let index = labelsArray.indexOf(label)
    if (index > -1) {
        if (labelsTransArray[index] !== '') {
            label = labelsTransArray[index]
        }
    }
    return label
}

function set_alignment() {
    if (localStorage.getItem('display') == 'Right to Left' || localStorage.getItem('Lang') == 'urdu') {
        $('.input-group-merge input').addClass('urduField')
        $('.static_label').addClass('urduField')
        $('.scroll-edit').removeClass('urduField')
        $('.btnModal2').removeClass('urduField')
        $('.btnModal').removeClass('urduField')
        $('.alert').addClass('urduCheckBox')
        $('.custom-checkbox').addClass('urduCheckBox')
        $('.formHeading').addClass('rightAlign')
        $('.modal-header2').addClass('urduField')
        $('.pb-date').addClass('rightFloat')
        $('.pb-date').removeClass('urduField')
        $('.modal-title').removeClass('urduField')
        $('select').css('direction', 'rtl')
        $('#saveAsDraft').addClass('rightAlign')
        $('#saveAsDraft').removeClass('urduField')


        $('.btn').addClass('rightAlign')
        $('.btn').removeClass('urduField')

        $(".specifiedUrduElm a").removeClass("urduField");
        if($('.specifiedUrduElm div').hasClass('text-left'))
        {
            $('.specifiedUrduElm div').removeClass('text-left')
        }
        $(".specifiedUrduElm p").removeClass("urduField");
        $(".specifiedUrduElm input").removeClass("urduField");
        $(".specifiedUrduElm label").removeClass("urduField");
        $(".specifiedUrduElm span").removeClass("urduField");
        $(".specifiedUrduElm la").removeClass("urduField");
        $(".specifiedUrduElm .btn").removeClass("urduField");
        $(".specifiedUrduElm .alert").removeClass("urduField");
        $(".specifiedUrduElm").removeClass("urduField");

        $(".specifiedUrduElm").addClass("rightAlign");
        $(".specifiedUrduElm").css('direction', 'rtl');

        setTimeout(function() {
            $('.select2-results').addClass('rightAlign')
            $('.select2-container .select2-choice>.select2-chosen').css('direction', 'rtl')
        }, 2000)

        console.log('urdu fields')

    } else {
        $('.input-group-merge').removeClass('urduField')
        $('.static_label').removeClass('urduField')
        $('.custom-checkbox').removeClass('urduCheckBox')
        $('.alert').removeClass('urduCheckBox')
        $('.custom-checkbox').removeClass('urduCheckBox')
        $('.formHeading').removeClass('rightAlign')
        $('.pb-date').removeClass('rightFloat')
        $('.modal-header2').removeClass('urduField')
        $('select').css('direction', 'ltr')
        $('#saveAsDraft').removeClass('rightAlign')

        setTimeout(function() {
            $('.select2-results').removeClass('rightAlign')
            $('.select2-container .select2-choice>.select2-chosen').css('direction', 'ltr')

        }, 2000)


    }
}

$(document).on('keypress, keydown, keyup', 'input[type="tel"]', function(e) {
    changeErrorLabels()
});
$(document).on('keypress, keydown, keyup', 'input[type="email"]', function(e) {
    changeErrorLabels()
});
$(document).on('keypress, keydown, keyup', 'input[type="text"]', function(e) {
    changeErrorLabels()
});
$(document).on('keypress, keydown, keyup', 'input[type="number"],textarea', function(e) {
    changeErrorLabels()
});
$(document).on('focusout', 'input, select ,textarea', function() {
    changeErrorLabels();
});
$(document).on('focusin', 'input, select ,textarea', function() {
    changeErrorLabels();
});