$(document).ready(function () {

  $("#language-picker-select").on('change', function () {
   
    var display = $('#language-picker-select option:checked').attr('data-id');
   
    let val = $(this).val()
    let url = window.location.origin
    let full_url = (window.location.href).split('/')
    let file_name = full_url[3].split('?')
    if (val == 'english') {
      window.location.assign(url + '/' + file_name[0] + '?id=10')
    } else {
      window.location.assign(url + '/' + file_name[0] + '?id=10&Lang=' + val)
    }
    localStorage.setItem('display', display);
    localStorage.setItem('newFlag', 1);
  });
  
  $("#language-picker-select").val(localStorage.getItem('Lang'));

  // let cookiess = (document.cookie).split(';')
  // for (let i = 0; i < cookiess.length; i++) {
  //   let single_cookie = cookiess[i].split('=')
  //
  //   if (single_cookie[0].trim() == 'Lang') {
  //     if (localStorage.getItem('Lang') !== '' && localStorage.getItem('Lang') !== undefined && localStorage.getItem('Lang') !== null) {
  //       localStorage.setItem('oldLang', localStorage.getItem('Lang'))
  //     } else {
  //       localStorage.setItem('oldLang', 'english')
  //     }
  //     localStorage.setItem('Lang', single_cookie[1])
  //   }
  // }



  changeClass();

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

// For Labels
function translateVal(title) {

  $.ajax({
    dataType: 'json',
    url: "function.php?h=getTranslation",
    type: 'POST',
    async: false,
    data: {
      'title': title
    },
    success: function (data) {

      if (data.Success == 'true') {
        returnFunc(data.Question)
      } else {
        returnFunc(title)
      }
    }
  });
}

function translateValOrg(title) {
  $.ajax({
    dataType: 'json',
    url: "function.php?h=getTranslationOrg",
    type: 'POST',
    async: false,
    data: {
      'title': title
    },
    success: function (data) {

      if (data.Success == 'true') {
        returnFunc(data.Question)
      } else {
        returnFunc(title)
      }
    }
  });
}

function valueConversion(title) {
  $.ajax({
    dataType: 'json',
    url: "function.php?h=valueConversion",
    type: 'POST',
    async: false,
    data: {
      'title': title
    },
    success: function (data) {

      if (data.Success == 'true') {
        $.ajax({
          dataType: 'json',
          url: "function.php?h=getTranslationConversion",
          type: 'POST',
          async: false,
          data: {
            'title': data.Question
          },
          success: function (data) {

            if (data.Success == 'true') {
              returnFunc(data.Question)
            } else {
              returnFunc(title)
            }
          }
        });

      } else {
        returnFunc(title)
      }
    }
  });
}

function optionsConversion(title) {
  $.ajax({
    dataType: 'json',
    url: "function.php?h=optionsConversion",
    type: 'POST',
    async: false,
    data: {
      'title': title
    },
    success: function (data) {

      if (data.Success == 'true') {
        $.ajax({
          dataType: 'json',
          url: "function.php?h=getoptionsConversion",
          type: 'POST',
          async: false,
          data: {
            'title': data.Question
          },
          success: function (data) {

            if (data.Success == 'true') {
              returnFunc(data.Question)
            } else {
              returnFunc(title)
            }
          }
        });

      } else {
        returnFunc(title)
      }
    }
  });
}
// For Custom Radio Button Values
function customLabel(title, type, fieldType) {
  $.ajax({
    dataType: 'json',
    url: 'function.php?h=customLabel',
    type: 'POST',
    async: false,
    data: {
      title: title,
      type: type,
      fieldType: fieldType
    },
    success: function (data) {

      if (data.Success == 'true') {
        returnFunc(data.Question)
        if (localStorage.getItem('display') == 'Right to Left') {
          $("select").attr('dir', 'rtl');
        }
      } else {
        returnFunc(title)
      }
    }
  });
}

function countryDropdown(title, type, fieldType) {
  $.ajax({
    dataType: 'json',
    url: 'function.php?h=countryDropdown',
    type: 'POST',
    async: false,
    data: {
      title: title,
      type: type,
      fieldType: fieldType
    },
    success: function (data) {

      if (data.Success == 'true') {
        returnFunc(data.Question)
        if (localStorage.getItem('display') == 'Right to Left') {
          $("select").attr('dir', 'rtl');
        }
      } else {
        returnFunc(title)
      }
    }
  });
}

function notesTrans(title) {
  $.ajax({
    dataType: 'json',
    url: 'function.php?h=getNotes',
    async: false,
    type: 'POST',
    data: {
      'title': title
    },
    success: function (data) {
      if (data.Success == 'true') {
        returnFunc(data.Question)
      } else {
        returnFunc(title)
      }
    }
  });
}

function notesConversion(title) {
  $.ajax({
    dataType: 'json',
    url: "function.php?h=notesConversion",
    type: 'POST',
    async: false,
    data: {
      'title': title
    },
    success: function (data) {

      if (data.Success == 'true') {
        $.ajax({
          dataType: 'json',
          url: "function.php?h=getnotesConversion",
          type: 'POST',
          async: false,
          data: {
            'title': data.Question
          },
          success: function (data) {

            if (data.Success == 'true') {
              returnFunc(data.Question)
            } else {
              returnFunc(title)
            }
          }
        });

      } else {
        returnFunc(title)
      }
    }
  });
}

function returnFunc(ques) {
  rTitle = ques;
}


//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches

$(document).on('click', '.next', function () {

  current_fs = $(this).parent().parent();
  next_fs = $(this).parent().parent().next();

  //activate next step on progressbar using the index of next_fs
  $("#progressbar li").eq($(".parent_question").index(next_fs)).addClass("active");

  //show the next fieldset
  next_fs.show();
  //hide the current fieldset with style
  current_fs.hide();
});

$(document).on('click', '.previous', function () {

  current_fs = $(this).parent().parent();;
  previous_fs = $(this).parent().parent().prev();

  //de-activate current step on progressbar
  $("#progressbar li")
    .eq($(".parent_question").index(current_fs))
    .removeClass("active");

  //show the next fieldset
  previous_fs.show();
  //hide the current fieldset with style
  current_fs.hide();

});
