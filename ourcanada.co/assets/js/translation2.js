$(document).ready(function(){
    // changeStaticLabels();
    changeErrorLabels();

})

function changeStaticLabels() {
    console.log('changing static Labels')
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