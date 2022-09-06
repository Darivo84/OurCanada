<script>
    // this file contains all events

    // draft submission handlings
    <?php if (isset($_SESSION['user_id'])) {  ?>


    $(document).on("click","#continueFormBtn",function(){
        $.ajax({
            url: "<?php echo $currentTheme.$ajaxFileToCall; ?>?h=continueFormRequest<?php echo $langParam; ?>",
            type: 'POST',
            async: false,

            data: {

            },
            success:function ()
            {
                localStorage.clear();
                window.location.reload();
            }
        });
    })


    $(document).on("click", "#saveAsDraft", function() {
        let gotoDraft = false;




        if ($("input[name='n[question_28]']").val() != "") {
            gotoDraft = true;

        }
        if ($("input[name='n[question_29]']").val() != "") {
            gotoDraft = true;

        }
        if ($("input[name='n[question_30]']").val() != "") {
            gotoDraft = true;

        }
        if ($("input[name='n[question_31]']").val() != "") {
            gotoDraft = true;

        }
        if ($("input[name='n[question_32]']").val() != "") {
            gotoDraft = true;

        }

        if (($("select[name='n[question_43]']").val()) != null) {
            gotoDraft = true;

        }
        if ($("select[name='n[question_45]']").val() != null) {
            gotoDraft = true;


        }


        if (gotoDraft) {

            let error_msg = '<?php echo $allLabelsArray[304] ?>'//'Form saving is under process'
            let error_title = ''

            if ($('#toaster').children().length > 0) {
                $('#toaster').children().remove()
            }
            // $.toaster({
            //     priority: "success",
            //     title: error_title,
            //     message: error_msg,
            //     settings: {
            //         timeout: 6000
            //     },
            // });

            setTimeout(function() {
                $("input,select,textarea").each(function() {

                    if ($(this).is("[type='checkbox']") || $(this).is("[type='radio']")) {
                        $(this).attr("checked", $(this).is(":checked"));
                    } else if ($(this).prop("tagName") == "SELECT") {
                        $(this).find('option[value="' + $(this).val() + '"]').attr('selected', true);
                    } else {
                        $(this).attr("value", $(this).val());
                    }
                });

                var fformData = $('.myForm').serializeArray();


                console.log("allStorage")
                drafted = true;
                localStorage.setItem('drafted','true')
                console.log("drafted called => 7 func")
                console.log(JSON.stringify(allStorage()));

                // let email = $('input[type="email"]:first').val()
                $.ajax({
                    dataType: 'json',
                    url: "<?php echo $currentTheme.$ajaxFileToCall; ?>?h=saveAsDraft<?php echo $langParam; ?>",
                    type: 'POST',
                    async: false,
                    beforeSend : function(){
                        drafted = true;
                        localStorage.setItem('drafted','true')
                        console.log("drafted called => 2 func")
                    },
                    data: {
                        'locs_display': localStorage.getItem('display'),
                        'locs_Lang': localStorage.getItem('Lang'),
                        'locs_oldLang': localStorage.getItem('oldLang'),
                        'locs_AgreeCheck': localStorage.getItem('AgreeCheck'),
                        'locs_nocSpouse': localStorage.getItem('nocSpouse'),
                        'locs_nocUser': localStorage.getItem('nocUser'),
                        'locs_userGrades': localStorage.getItem('userGrades'),
                        'locs_spouseGrades': localStorage.getItem('spouseGrades'),
                        'locs_Submission': localStorage.getItem('Submission'),
                        'locs_showsubmit': localStorage.getItem('showsubmit'),
                        'cookie_Lang': getCookie('Lang'),
                        'cookie_oldLang': getCookie('oldLang'),
                        'cookie_AgreeCheck': getCookie('AgreeCheck'),
                        'userId': '<?php echo $_SESSION['user_id']; ?>',
                        'formHtml': $(".myForm").html(),
                        'is_pro': is_pro,
                        'sformId': sformId,
                        'submitBtnVis': $("#btnLoader").is(":visible"),
                        'localStorage': JSON.stringify(allStorage()),
                        'formData': JSON.stringify(fformData),
                        'sdraftId':sdraftId,
                        // 'email':email


                        // 'json_data':json_data

                    },

                    success: function(data) {
                        is_session(data) //checks if session is expired
                        if ($('#toaster').children().length > 0) {
                            $('#toaster').children().remove()
                        }
                        if (data.status == 1 && data.show_modal == 0) {


                            $("#languagePickerSelect").css('pointer-events', 'none')

                            drafted = true;
                            localStorage.setItem('drafted','true')
                            console.log("drafted called => 3 func")

                            if(data.s_draft_id != undefined)
                            {
                                if(data.s_draft_id != "")
                                {
                                    sdraftId =   data.s_draft_id


                                    localStorage.setItem("process_draft_id",data.s_draft_id)
                                }

                            }


                            localStorage.setItem("process_draft_id",data.s_draft_id)

                            onDraftStatusChanged();
                            $(".closeDraftModal").click();

                            let msg = '<?php echo $allLabelsArray[181] ?>'//"Successfully saved as draft.";
                            let title ='<?php echo $allLabelsArray[104] ?>'// "Successful";


                            // if (localStorage.getItem('Lang') !== 'english') {
                            //     msg = static_label_changer(msg)
                            //     title = static_label_changer(title)
                            // }
                            // make_toast('success', title, msg)

                        } else if (data.show_modal == 1) {
                            console.log('d false 1')
                            drafted = false;
                            localStorage.setItem('drafted','false')

                            onDraftStatusChanged();
                            //$("#draftModal").modal('show');
                            $('#draftupdatebtn').click()
                        } else {
                            console.log('d false 2')
                            drafted = false;
                            localStorage.setItem('drafted','false')

                            onDraftStatusChanged();
                            // console.log(data.err)
                        }

                    },
                    error: function(data) {
                        console.log(data)
                        $('#preloader').hide()
                        let error_title = '<?php echo $allLabelsArray[65] ?>' //"Error";
                        let error_msg ='<?php echo $allLabelsArray[215] ?>'// "Some error occurred. Please try again.";

                        // if (localStorage.getItem('Lang') !== 'english') {
                        //
                        //     error_msg = static_label_changer(error_msg)
                        //     error_title = static_label_changer(error_title)
                        // }
                        // make_toast('danger', error_title, error_msg)
                        drafted = false;
                        localStorage.setItem('drafted','false')


                    }


                });
            }, 1000)
        } else {
            let title = '<?php echo $allLabelsArray[65] ?>' //"Error";
            let msg = '<?php echo $allLabelsArray[219] ?>'//"You can’t save an empty form.";
            // if (localStorage.getItem('Lang') !== 'english') {
            //     msg = static_label_changer(msg)
            //     title = static_label_changer(title)
            // }
            // make_toast('info', title, msg)
        }

    });

    $(document).on("click", "#logoutLink", function(e) {
        // if (drafted == true )
        if (localStorage.getItem('drafted')== 'true' )
        {

        } else {
            // e.preventDefault();
            // $("#logoutConformModal").modal('show');
        }

    });

    $(document).on("click", "#draftupdatebtn", function() {
        let error_msg = '<?php echo $allLabelsArray[304] ?>'//'Form saving is under process'
        let error_title = ''

        if ($('#toaster').children().length > 0) {
            $('#toaster').children().remove()
        }
        $.toaster({
            priority: "success",
            title: error_title,
            message: error_msg,
            settings: {
                timeout: 6000
            },
        });
        setTimeout(function() {
            $("input,select,textarea").each(function() {
                if ($(this).is("[type='checkbox']") || $(this).is("[type='radio']")) {
                    $(this).attr("checked", $(this).is(":checked"));
                } else if ($(this).prop("tagName") == "SELECT") {
                    $(this).find('option[value="' + $(this).val() + '"]').attr('selected', true);
                } else {
                    $(this).attr("value", $(this).val());
                }
            });
            var fformData = $('.myForm').serializeArray();

            console.log("allStorage")
            drafted = true;
            localStorage.setItem('drafted','true')
            console.log("drafted called => 4 func")
            console.log(JSON.stringify(allStorage()));
            $.ajax({
                dataType: 'json',
                url: "<?php echo $currentTheme.$ajaxFileToCall; ?>?h=saveAsDraft<?php echo $langParam; ?>",
                type: 'POST',
                async: false,
                beforeSend:function(){
                    drafted = true;
                    localStorage.setItem('drafted','true')
                    console.log("drafted called => 5 func")
                },
                data: {
                    'locs_display': localStorage.getItem('display'),
                    'locs_Lang': localStorage.getItem('Lang'),
                    'locs_oldLang': localStorage.getItem('oldLang'),
                    'locs_AgreeCheck': localStorage.getItem('AgreeCheck'),
                    'locs_nocSpouse': localStorage.getItem('nocSpouse'),
                    'locs_nocUser': localStorage.getItem('nocUser'),
                    'locs_userGrades': localStorage.getItem('userGrades'),
                    'locs_spouseGrades': localStorage.getItem('spouseGrades'),
                    'locs_Submission': localStorage.getItem('Submission'),
                    'locs_showsubmit': localStorage.getItem('showsubmit'),
                    'cookie_Lang': getCookie('Lang'),
                    'cookie_oldLang': getCookie('oldLang'),
                    'cookie_AgreeCheck': getCookie('AgreeCheck'),
                    'userId': '<?php echo $_SESSION['user_id']; ?>',
                    'formHtml': $(".myForm").html(),
                    'is_pro': is_pro,
                    'is_overwrite': 'yes',
                    'sformId': sformId,
                    'sdraftId':sdraftId,
                    'submitBtnVis': $("#btnLoader").is(":visible"),
                    'localStorage': JSON.stringify(allStorage()),
                    'formData': JSON.stringify(fformData)

                    // 'json_data':json_data

                },

                success: function(data) {
                    is_session(data) //checks if session is expired


                    if ($('#toaster').children().length > 0) {
                        $('#toaster').children().remove()
                    }

                    if (data.status == 1) {
                        drafted = true;
                        localStorage.setItem('drafted','true')
                        console.log("drafted called => 6 func")

                        localStorage.setItem("process_draft_id",sdraftId)

                        onDraftStatusChanged();
                        $(".closeDraftModal").click();


                        let msg = '<?php echo $allLabelsArray[181] ?>'//"Successfully saved as draft.";
                        let title = '<?php echo $allLabelsArray[104] ?>'//"Successful";


                        // if (localStorage.getItem('Lang') !== 'english') {
                        //     msg = static_label_changer(msg)
                        //     title = static_label_changer(title)
                        // }
                        make_toast('success', title, msg)

                    } else if (data.show_modal == 1) {
                        console.log('d false 3')
                        drafted = false;
                        localStorage.setItem('drafted','false')

                        onDraftStatusChanged();
                        //$("#draftModal").modal('show');
                        $('#draftupdatebtn').click()
                    } else {
                        console.log('d false 4')
                        drafted = false;
                        localStorage.setItem('drafted','false')

                        onDraftStatusChanged();
                        // console.log(data.err)
                    }

                },
                error: function(data) {
                    console.log(data)
                    $('#preloader').hide()
                    let error_title ='<?php echo $allLabelsArray[65] ?>' //"Error";
                    let error_msg = '<?php echo $allLabelsArray[215] ?>'//"Some error occur! Try Again";

                    // if (localStorage.getItem('Lang') !== 'english') {
                    //
                    //     error_msg = static_label_changer(error_msg)
                    //     error_title = static_label_changer(error_title)
                    // }
                    make_toast('danger', error_title, error_msg);
                    drafted = false;
                    localStorage.setItem('drafted','false')


                }


            });

        }, 1000);
    });

    <?php } ?>
    // end draft submission handlings

    $(document).on('keydown', '.datepicker', function(e) {
        if ((e.keyCode == 86)) {
            return false;
        }
        $(this).parent().parent().children('label.error').remove()
        $(this).next('label.error').remove()


        let v = $(this).val()
        let y;
        let m;
        let d;
        if (v.length == 7 && !v.includes('-')) {
            y = v.substr(0, 4)
            m = v.substr(4, 5)
            m = m.substr(0, m.length - 1)
            d = v.substr(6, 7)
            $(this).val(y + '-' + m + '-' + d)
        }
    })
    $(document).on('focus', '.datepicker', function() {
        $(this).parent().parent().children('label.error').remove()

        let d = new Date();
        let d1 = moment().subtract(10, 'years').calendar();
        d = new Date(d1)
        let month = (d.getMonth() + 1);
        let day = (d.getDate());
        let year = (d.getFullYear());
        let fd = year + "-" + month + "-" + day;
        let start_date = new Date('1900-01-01');

        $(this).datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: 'TRUE',
            autoclose: true,
            constrainInput: true,
            endDate: new Date(),
            // startDate: start_date

        });
    });
    $(document).on('change', '.datepicker', function() {
        valSave(this)
        $(this).next('label.error').remove()
        if($(this).val()=='' || $(this).val()==null)
        {
            if ($(this).hasClass('age'))
            {
                $(this).parent().children('input.dob').val($(this).val())
                valSave($(this).parent().children('input.dob'))
            }
        }
        let dateVal = $(this).val()
        let ent_date = new Date(dateVal)
        let cur_date = new Date()
        let date_year = ent_date.getFullYear()
        console.log(ent_date+'--'+dateVal)
        dateVal = dateVal.split('-')
        let sDate = dateVal[0] + "/" + dateVal[1] + "/" + dateVal[2]
        let enteredDate = sDate

        let today = new Date();
        let dd = today.getDate();

        let mm = today.getMonth() + 1;
        let yyyy = today.getFullYear();

        if (mm < 10)
            mm = "0" + mm;
        if (dd < 10)
            dd = "0" + dd;
        today = yyyy + '-' + mm + '-' + dd

        let check_years = new Date( new Date()- new Date(enteredDate)).getFullYear() - 1971;
        // console.log(new Date().getTimezoneOffset()+'--'+new Date(enteredDate).getTimezoneOffset())
        // console.log( new Date()+'-'+new Date(enteredDate) + '=='+ new Date(new Date()- new Date(enteredDate)))
        // console.log(new Date().getTimezoneOffset() + '--' + new Date(enteredDate).getTimezoneOffset())

        if(new Date().getTimezoneOffset()!= new Date(enteredDate).getTimezoneOffset() || new Date().getTimezoneOffset()>0)
        {
            if(date_year<dateVal[0])
            {
                date_year+=1

            }
        }


        // console.log(check_years + '--'+dateVal[0] +'--'+ date_year)
        if (check_years > 121 || dateVal[0] != date_year) {
            if ($(this).parent().parent().children('label.error').length <= 0 && $(this).val() !== '' && $(this).next('label.error').length <= 0) {
                let error_msg = '<?php echo $allLabelsArray[47] ?>'//'Invalid date'
                // if (localStorage.getItem('Lang') !== 'english') {
                //     error_msg = static_label_changer(error_msg)
                // }
                $(this).parent().parent().append('<label class="error">' + error_msg + '</label>')
            }
            if ($(this).hasClass('nocPicker')) {
                noc(this, 'off1')
                valSave(this)
            }
            $(this).val('')

            return false
        } else {
            $(this).parent().parent().children('label.error').remove()
        }

        let check = $(this).parent().prev().html()
        if ($(this).hasClass('age')) {
            $(this).parent().children('input.dob').val($(this).val())
            valSave($(this).parent().children('input.dob'))

            if ($(this).val() === today) {
                if ($(this).parent().parent().children('label.error').length <= 0 && $(this).val() !== '' && $(this).next('label.error').length <= 0) {
                    let error_msg = '<?php echo $allLabelsArray[58] ?>'//'Are you sure this person was born today?'
                    // if (localStorage.getItem('Lang') !== 'english') {
                    //     error_msg = static_label_changer(error_msg)
                    // }
                    $(this).parent().parent().append('<label class="error">' + error_msg + '</label>')
                }
            }
        }
        if ($(this).attr('name') == 'n[question_30]') {
            years = new Date(new Date() - new Date(enteredDate)).getFullYear() - 1970;
            movegroup3(this)
        }
        if ($(this).hasClass('nocPicker')) {
            noc(this, '')
            valSave(this)
        }
    });
    $(document).on('change', 'input[type="radio"]', function() {
        movegroup2(this)
    });
    $(document).on('change', 'select', function() {

        var prevvalue = $(this).val();
        $(this).find('option').attr('selected', false);
        $(this).find('option[value="' + prevvalue + '"]').attr('selected', true);

        if ($(this).hasClass('countryCheck')) {
            let name = $(this).attr('name')
            let id =name.split('_')
            id=id[1].slice(0,-1)
            let namesArray = ['n[question_68]', 'n[question_69]', 'n[question_70]', 'n[question_71]']
            let element1 = document.getElementsByName('n[sub_question_350]')
            let element2 = document.getElementsByName('n[question_74]')
            let val1 = document.getElementsByName('n[question_68]')
            let val2 = document.getElementsByName('n[question_69]')
            let val3 = document.getElementsByName('n[question_70]')
            let val4 = document.getElementsByName('n[question_71]')

            val1 = $(val1).val()
            val2 = $(val2).val()
            val3 = $(val3).val()
            val4 = $(val4).val()
            let change1 = false
            let change2 = false

            if (namesArray.indexOf(name) > -1) {
                if ($(element1).eq(0).prop('checked') || $(element1).eq(1).prop('checked') || $(element2).eq(0).prop('checked') || $(element2).eq(1).prop('checked')) {

                    if ($('.parent_350').length > 0) {
                        if (val1 !== 'Canada' && val2 !== 'Canada' && val3 !== 'Canada' && val4 !== 'Canada') {
                            no_change = false
                            return false
                        } else if (val1 == 'Canada' || val2 == 'Canada' || val3 == 'Canada' || val4 == 'Canada') {
                            change1 = true
                        }
                    } else if ($('.main_parent_74').length > 0 && $('.main_parent_74').css('display') !== 'none') {
                        if (val1 !== 'Canada' && val2 !== 'Canada' && val3 !== 'Canada' && val4 !== 'Canada') {
                            change2 = true
                        } else if (val1 == 'Canada' || val2 == 'Canada' || val3 == 'Canada' || val4 == 'Canada') {
                            no_change = false
                            return false

                        }
                    }


                    // if($('.main_parent_74').length > 0 && $('.main_parent_74').css('display')!=='none')
                    // {
                    //     $('.main_parent_74').remove()
                    // }
                    console.log('c1')
                    if (change1 || change2) {
                        let error_msg = '<?php echo $allLabelsArray[102] ?>'//'If you want to change country, you will have to fill the form again'
                        // if (localStorage.getItem('Lang') !== 'english') {
                        //     error_msg = static_label_changer(error_msg)
                        // }
                        temp_val = $(this);
                        temp_id = id;
                        temp_pid = 0;
                        valSave($(this))
                        $('#error_msg').html(error_msg)
                        $('#errorModal').modal()
                        console.log('c1-0')

                        return false
                    } else {
                        no_change = false
                        clicked = true
                    }

                } else {
                    console.log('c0')

                    if ($('.parent_350').length > 0) {
                        console.log('c2')

                        //$('.parent_350').remove()
                        if(val1 == 'Canada' || val2 == 'Canada' || val3 == 'Canada' || val4 == 'Canada')
                        {
                            $('.parent_350').remove()
                            if( $('.main_parent_74').length > 0)
                            {
                                $('.main_parent_74').show()
                            }
                            else
                            {
                                let element = document.getElementsByName('n[question_73]')
                                $(element).eq(0).prop('checked', false)
                                $(element).eq(1).prop('checked', false)
                                $('.main_parent_73')
                                    .children() //Select all the children of the parent
                                    .not(':first-child') //Unselect the first child
                                    .remove();
                            }
                        }
                        else
                        {
                            $('.main_parent_74').hide()
                            $('.main_parent_74')
                                .children() //Select all the children of the parent
                                .not(':first-child') //Unselect the first child
                                .remove();
                            getQuestion(document.getElementsByName('n[question_73'), 73, 0)
                        }
                    }
                    else
                    {
                        if(val1 == 'Canada' || val2 == 'Canada' || val3 == 'Canada' || val4 == 'Canada')
                        {
                            $('.parent_350').remove()
                            if( $('.main_parent_74').length > 0)
                            {
                                $('.main_parent_74').show()
                            }
                            else
                            {
                                let element = document.getElementsByName('n[question_73]')
                                $(element).eq(0).prop('checked', false)
                                $(element).eq(1).prop('checked', false)
                                $('.main_parent_73')
                                    .children() //Select all the children of the parent
                                    .not(':first-child') //Unselect the first child
                                    .remove();
                            }
                        }
                        else
                        {
                            $('.main_parent_74').hide()
                            $('.main_parent_74')
                                .children() //Select all the children of the parent
                                .not(':first-child') //Unselect the first child
                                .remove();
                            getQuestion(document.getElementsByName('n[question_73'), 73, 0)
                        }
                    }
                    movegroup4(this)
                }
            } else {
                console.log('c3')
                movegroup4(this)
            }
        } else {
            console.log('c4')
            movegroup4(this)
        }


    });
    // $(document).on('paste', 'input[type="text"]', function (e) {
    //     e.preventDefault()
    // })
    // $(document).on('paste', 'input[type="tel"]', function (e) {
    //     e.preventDefault()
    // })
    // $(document).on('paste', 'input[type="number"]', function (e) {
    //     e.preventDefault()
    // })
    // $(document).on('paste', 'input[type="email"]', function (e) {
    //     e.preventDefault()
    // })
    $(document).on('keypress, keydown, keyup', 'input[type="tel"]', function(e) {
        changeErrorLabels()
    })
    $(document).on('keypress, keydown, keyup', 'input[type="email"]', function(e) {
        changeErrorLabels()
    })
    $(document).on('keypress, keydown, keyup', 'input[type="text"]', function(e) {
        changeErrorLabels()
    })
    $(document).on('keypress, keydown, keyup', 'input[type="number"]', function(e) {
        changeErrorLabels()
    })
    $(document).on('click', 'select', function(e) {
        if ($(this).hasClass('countryCheck')) {
            if (clicked == false) {
                let name = $(this).attr('name')
                let namesArray = ['n[question_68]', 'n[question_69]', 'n[question_70]', 'n[question_71]']

                if (namesArray.indexOf(name) > -1 && no_change == false) {
                    previous_country = $(this).val()
                    if (($('.main_parent_74').length > 0 && $('.main_parent_74').css('display') !== 'none') || $('.parent_350').length > 0) {
                        changed_element = this
                        no_change = true
                    }
                }
            } else {
                clicked = false
            }
        }
        changeErrorLabels()
    })


    $(document).on('keyup blur', 'input[type="text"]', function(e) {
        removeExtraText(this)
    })
    $(document).on('keyup blur', 'input[type="tel"]', function(e) {
        removeExtraTel(this)
    })
    $(document).on('keyup blur', 'input[type="number"]', function(e) {
        removeExtraNumber(this)
    })


    $(document).on('keypress', 'input[type="text"]', function(e) {
        if ($(this).hasClass('datepicker')) {
            var keyCode = e.keyCode || e.which;
            var regex = /^[0-9-]+$/;
            var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        }

        var keyCode = e.keyCode || e.which;
        var regex = /^[A-Za-z  '\-]+$/;
        let label = $(this).parent().parent().children('label').attr('data-org');
        if (label !== undefined) {
            if (label.includes('address') || label.includes('Address') || label.includes('Please describe')) {
                return true;
            } else {
                var isValid = regex.test(String.fromCharCode(keyCode));
                return isValid;

            }
            return false;
        }
    })
    $(document).on('keypress', 'input[type="tel"]', function(e) {


        var keyCode = e.keyCode || e.which;
        let v = $(this).val();

        var regex = /^[+0-9]$/;
        var isValid = regex.test(String.fromCharCode(keyCode));
        return isValid;

        return false;
    })
    $(document).on('keypress', 'input[type="number"]', function(e) {
        var keyCode = e.keyCode || e.which;
        let v = $(this).val();
        let a = $(this).attr('data-type')
        if (a == 'hour') {
            var regex = /^[0-9]$/;
            var isValid = regex.test(String.fromCharCode(keyCode));

            if (isValid && v > 9)
                return false;

            return isValid;
        }
        // else if(a.includes('hours worked'))
        // {
        //     var regex = /^[0-9]$/;
        //     var isValid = regex.test(String.fromCharCode(keyCode));
        //     return isValid;
        // }
        else {
            var regex = /^[+0-9]$/;
            var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        }
        return false;
    })

    $(document).on('change', '.countryCheck', function() {
        countryFunc(this)
    })
    $(document).on('change', 'input[type="date"]', function() {
        noc(this, '')
        valSave(this)
    })
    $(document).on('change', 'input.nocPicker', function() {
        $(this).parent('div').children('label.error').remove()
    })
    $(document).on('change', '.present_checkbox', function(e) {

        let dis = $(this).parent().parent().children('input[data-id="to"]')
        let prev = $(dis).prev().val()
        var now = new Date();
        var month = (now.getMonth() + 1);
        var day = now.getDate();
        if (month < 10)
            month = "0" + month;
        if (day < 10)
            day = "0" + day;
        var today = now.getFullYear() + '-' + month + '-' + day;
        $(dis).parent().children('label.error').remove()

        if (this.checked) {

            $(dis).val(new Date());

            $(dis).css('pointer-events', 'none')
            let v = '<?php echo $allLabelsArray[21] ?>'//'Present'
            // if (localStorage.getItem('Lang') !== 'english') {
            //     v = static_label_changer(v)
            // }
            $(dis).val(v);
            $(dis).attr('data-def', 'Present');

            noc(dis, 'on')

        } else {
            $(dis).css('pointer-events', '')
            $(dis).val('');
            $(dis).attr('data-def', '');
            noc(dis, 'off')


        }
        valSave(dis)
    });
    $(document).on('keyup', 'input', function(e) {
        let noc_flag = $(this).attr('data-noc')
        let noc_pos = $(this).attr('data-position')
        let noc_user = $(this).attr('data-label')
        let noc_type = $(this).attr('data-type')
        let date_pos = $(this).attr('data-id')
        let val = $(this).val()
        let index = parseInt(noc_pos) - 1

        if (noc_flag == '1') {
            if (noc_user == 'spouse') {
                if (noc_type == 'hour') {
                    nocSpouse[index].hours = val
                } else if (noc_type == 'wage') {
                    nocSpouse[index].wage = val
                }
            } else {
                if (noc_type == 'hour') {
                    nocUser[index].hours = val
                } else if (noc_type == 'wage') {
                    nocUser[index].wage = val
                }
            }
        }

        //console.log('user')
        //console.log(nocUser)
        //console.log('spouse')
        //console.log(nocSpouse)
    })
    $(document).on('change', 'select', function(e) {

        let noc_flag = $(this).attr('data-noc')
        let noc_pos = $(this).attr('data-position')
        let noc_user = $(this).attr('data-label')
        let noc_type = $(this).attr('data-type')
        let date_pos = $(this).attr('data-id')
        let val = $(this).val()
        let index = parseInt(noc_pos) - 1

        if (noc_flag == '1') {
            if (noc_user == 'spouse') {
                if (noc_type == 'country') {
                    nocSpouse[index].country = val
                    nocSpouse[index].authorization = ''
                } else if (noc_type == 'province') {
                    nocSpouse[index].province = val
                    nocSpouse[index].region = ''
                } else if (noc_type == 'region') {
                    nocSpouse[index].region = val
                } else if (noc_type == 'authorization') {
                    nocSpouse[index].authorization = val
                }
            } else {
                if (noc_type == 'country') {
                    nocUser[index].country = val
                    nocUser[index].authorization = ''
                } else if (noc_type == 'province') {
                    nocUser[index].province = val
                    nocUser[index].region = ''
                } else if (noc_type == 'region') {
                    nocUser[index].region = val
                } else if (noc_type == 'authorization') {
                    nocUser[index].authorization = val
                }
            }
        }

        //console.log('user')
        //console.log(nocUser)
        //console.log('spouse')
        //console.log(nocSpouse)
    })
    $(document).on('change', '.nocJobs', function(ee) {

        tagsInp()

        var $aRr = $(this).val();
        let val = jobsArr[$aRr];

        var getAttr = $(this).attr('name');


        $("input[name='" + getAttr + "']").val(val);
        let noc_flag = $(this).attr('data-noc')
        let noc_pos = $(this).attr('data-position')
        let noc_user = $(this).attr('data-label')
        let noc_type = $(this).attr('data-type')
        let date_pos = $(this).attr('data-id')

        let index = parseInt(noc_pos) - 1
        if (noc_flag == '1')

            if (nocSpouse.length > 0) {
                if (typeof nocSpouse[index] !== undefined && typeof nocSpouse[index] != undefined && typeof nocSpouse[index] !== 'undefined' && typeof nocSpouse[index] != 'undefined') {
                    if (nocSpouse[index].noc != '') {

                        up1 += nocSpouse[index].noc
                    }
                }
            }
        if (nocUser.length > 0) {
            if (typeof nocUser[index] !== undefined && typeof nocUser[index] != undefined && typeof nocUser[index] !== 'undefined' && typeof nocUser[index] != 'undefined') {
                if (nocUser[index].noc != '') {

                    up2 += nocUser[index].noc
                }
            }

        }

        up3 = '';
        up4 = '';
        $('input.nocJobs[data-position="' + noc_pos + '"]').each(function() {
            let nocJob = $(this).val()
            if ($(this).attr('data-label') == 'user') {
                up3 += nocJob + '^'
            } else {
                up4 += nocJob + '^'
            }
        })
        $('input.nocPos[data-position="' + noc_pos + '"]').each(function() {
            let nocJob = $(this).val()
            if ($(this).attr('data-label') == 'user') {
                up3 += nocJob + '^'
            } else {
                up4 += nocJob + '^'
            }
        })


        if (noc_type == 'job' || noc_type == 'duty') {
            if (noc_user == 'spouse') {
                nocSpouse[index].noc = up4
            } else {
                nocUser[index].noc = up3
            }
        }


        valSave(this)


        //console.log('user')
        //console.log(nocUser)
        //console.log('spouse')
        //console.log(nocSpouse)
    });
    $(document).on('change', '.nocPos', function(ee) {
        $(this).parent().children('label.dutyError').remove()
        tagsInp()

        var $aRr = $(this).val();
        let val = dutyArr[$aRr];
        var getAttr = $(this).attr('name');
        // console.log(getAttr);
        $("input[name='" + getAttr + "']").val(val);
        let getID = getAttr.split('_')
        let id = getID[2].slice(0, -1)

        let noc_flag = $(this).attr('data-noc')
        let noc_pos = $(this).attr('data-position')
        let noc_user = $(this).attr('data-label')
        let noc_type = $(this).attr('data-type')
        let date_pos = $(this).attr('data-id')
        let index = parseInt(noc_pos) - 1

        if ($(this).attr('data-label') == 'user') {

            if (nocUser.length > 0) {
                if (typeof nocUser[index] !== undefined && typeof nocUser[index] != undefined && typeof nocUser[index] !== 'undefined') {
                    if (nocUser[index].noc !== '' && nocUser[index].noc !== undefined) {
                        if ((nocUser[index].noc).includes(val)) {
                            $(this).val('').change();
                            if(($(this).parent().children('label.dutyError')).length <= 0)
                            {
                                $(this).parent().append('<label class="error dutyError"><?php echo $allLabelsArray[801] ?></label>')

                            }
                            return false;
                        }

                    }
                }

            }
        }
        else
        {
            if (nocSpouse.length > 0) {
                if (typeof nocSpouse[index] !== undefined && typeof nocSpouse[index] != undefined && typeof nocSpouse[index] !== 'undefined') {
                    if (nocSpouse[index].noc !== '' && nocSpouse[index].noc !== undefined) {
                        if ((nocSpouse[index].noc).includes(val)) {
                            $(this).val('').change();
                            if(($(this).parent().children('label.dutyError')).length <= 0)
                            {
                                $(this).parent().append('<label class="error dutyError"><?php echo $allLabelsArray[801] ?></label>')

                            }
                            return false;
                        }

                    }
                }

            }
        }
        if (noc_flag == '1') {
            up3 = '';
            up4 = '';
            $('input.nocJobs[data-position="' + noc_pos + '"]').each(function() {
                let nocJob = $(this).val()
                if ($(this).attr('data-label') == 'user') {
                    up3 += nocJob + '^'
                } else {
                    up4 += nocJob + '^'
                }
            })
            $('input.nocPos[data-position="' + noc_pos + '"]').each(function() {
                let nocJob = $(this).val()
                if ($(this).attr('data-label') == 'user') {
                    up3 += nocJob + '^'
                } else {
                    up4 += nocJob + '^'
                }
            })


            if (noc_type == 'job' || noc_type == 'duty') {
                if (noc_user == 'spouse') {
                    nocSpouse[index].noc = up4
                } else {
                    nocUser[index].noc = up3
                }
            }

        }
        valSave(this)

        if (id == "664") {
            getQuestion3(document.getElementsByName("input[name='" + getAttr + "']"), 664, 110)
        }

        // console.log('user')
        // console.log(nocUser)
        // console.log('spouse')
        // console.log(nocSpouse)
    });
    $(document).on('click', '#iAgree #terms', function() {
        let fields_check = true
        let error_msg ='<?php echo $allLabelsArray[63] ?>'; // 'Please fill the above fields first.'
        let error_title = '<?php echo $allLabelsArray[65] ?>' //"Error";
        $('input').each(function() {
            if ($(this).parent().parent().parent().attr('class') !== undefined) {
                let class_check = $(this).parent().parent().parent().attr('class').includes('parent')

                if (class_check) {
                    if (!$(this).parent().parent().hasClass('unChecked') && !$(this).parent().parent().parent().hasClass('unChecked')) {
                        if (($(this).val() == '' || $(this).val() == null) && $(this).val() !== undefined) {
                            fields_check = false
                            return false
                        }
                    }
                }
            }


        })
        $('select').each(function() {
            if ($(this).parent().parent().parent().attr('class') !== undefined) {
                let class_check = $(this).parent().parent().parent().attr('class').includes('parent')

                if (class_check) {
                    if (!$(this).parent().parent().hasClass('unChecked') && !$(this).parent().parent().parent().hasClass('unChecked')) {

                        if (($(this).val() == '' || $(this).val() == null) && $(this).val() !== undefined) {
                            fields_check = false
                            return false
                        }
                    }
                }
            }


        })
        if (!fields_check) {
            // if (localStorage.getItem('Lang') !== 'english') {
            //     error_msg = static_label_changer(error_msg)
            //     error_title = static_label_changer(error_title)
            // }
            make_toast('danger', error_title, error_msg)
            return false
        }
        getNoc();
        document.cookie = 'AgreeCheck=1';
        localStorage.setItem('AgreeCheck', '1');
        $(".unChecked").css('display', 'block');

        $(".unChecked").each(function() {
            $(this).removeClass('unChecked');
        })

        $("#iAgree, #terms").remove();
        formFunc('')

        // drafted = false;
        // localStorage.setItem('drafted','false');
        // onDraftStatusChanged();
        checkDraftButton()
    });
    $(document).on('change', 'input,textarea,select', function() {
        if ($(this).hasClass('comments')) {

        } else {
            if (localStorage.getItem('Submission') !== 'true') {
                if (localStorage.getItem('EndCase') == 'matched') {
                    $("label.error").each(function() {
                        if ($('label.error').css('display') === 'none') {
                            $(this).remove();
                        } else {
                            //something else
                        }
                    })
                    if ($("label.error").length <= 0) {
                        $('html,body').animate({
                            scrollTop: document.body.scrollHeight
                        }, "fast");
                        $(".email").css('display', 'block');
                        setTimeout(function() {
                            $('#validateform').submit();
                        }, 6000)
                    } else {

                    }

                    // console.log('End case matched');
                }

            } else {
                // console.log('Endcheck validater not working');
            }

        }


    }); //copy
    $(document).on('change', '.required', function() {
        console.log($(this).prev('.select2-container').children('.select2-chosen').html()+'-text')
        if ($(this).prev('.select2-container').children('.select2-chosen').html() != '<?php echo $allLabelsArray[78] ?>') {
            console.log('error label removed')
            $(this).parent('div').children('label.errorReq').remove()
            // $(this).prev('.select2-container').prev('label.errorReq').remove();
        }
    });
    $(document).on('change', '.education', function() {
        if ($(this).prev('.select2-container').children('.select2-chosen').html() != '<?php echo $allLabelsArray[78] ?>') {
            // $(this).prev('.select2-container').prev('label.errorReq').remove();
            $(this).parent('div').children('label.errorReq').remove()

        }
    });

    $(document).on('keyup', 'input', function() {
        // valSave(this)
    });
    $(document).on('change', 'select[name="is_email"]', function() {
        $('#btnModal').click()
    })
    $(document).on('focusout', 'input, select', function() {
        changeErrorLabels();
    })

    $('#yesBtn3').click(function() {
        $('.btnModal').click()
        final_submit = true
        let error_msg = '<?php echo $allLabelsArray[217] ?>'//'Form submission is in process'
        let error_title = ''
        // if (localStorage.getItem('Lang') !== 'english') {
        //     error_msg = static_label_changer(error_msg)
        //     error_title = static_label_changer(error_title)
        //
        // }
        if ($('#toaster').children().length > 0) {
            $('#toaster').children().remove()
        }
        if (($('#toaster').children()).length <= 0) {
            $.toaster({
                priority: "info",
                title: error_title,
                message: error_msg,
                settings: {
                    timeout: 20000
                },
            });

        }
        comment_button = true;
        $('#validateform').submit()

    })

    $('#yesBtn2').click(function() {


      editFormFunction()
    })

    $('#yesBtn4').click(function() {
        if (change1) {
            let element = document.getElementsByName('n[question_73]')
            // $(element).eq(0).prop('checked', false)
            // $(element).eq(1).prop('checked', false)
        }
        console.log('button click question request')
        if(temp_id!=='' && temp_id!==null && temp_val!=='' && temp_val!==null && temp_val!==undefined)
        {
            getQuestion(temp_val, temp_id, temp_pid)
        }
        $('.closeModal').click()
        if($(temp_val).val()=='Canada')
        {
            $('.parent_350').remove()
            if( $('.main_parent_74').length > 0)
            {
                $('.main_parent_74').show()
            }
            else
            {
                let element = document.getElementsByName('n[question_73]')
                $(element).eq(0).prop('checked', false)
                $(element).eq(1).prop('checked', false)
                $('.main_parent_73')
                    .children() //Select all the children of the parent
                    .not(':first-child') //Unselect the first child
                    .remove();
            }
        }
        else
        {
            $('.main_parent_74').hide()
            $('.main_parent_74')
                .children() //Select all the children of the parent
                .not(':first-child') //Unselect the first child
                .remove();
            getQuestion(document.getElementsByName('n[question_73'), 73, 0)
        }
        // movegroup4(temp_val)
        temp_val = '';
        temp_id = '';
        temp_pid = '';

        change1 = false
        change2 = false
        no_change = false
    })
    $('#noBtn4').click(function() {


        let name = $(changed_element).attr('name')
        if (previous_country === null || previous_country === '') {
            $('select[name="' + name + '"] option:first').prop('selected', true);

        } else {
            $('select[name="' + name + '"] option[value="' + previous_country + '"]').prop('selected', true);

        }
        // if(no_change==true && previous_country=='Canada')
        // {
        //     $('select[name="'+name+'"] option:first').prop('selected', true);
        // }
        valSave(changed_element)
        changed_element = ''
        change1 = false
        change2 = false
        no_change = false
        $('.closeModal').click()
    })

    $('#yesBtn1').click(function() {

        $('.btnModal').click()
        progressBar(0)
    })
    $('#langChangeYes').click(function() {

        // langChangeYes();
        $('#langChangeLink').click()

    })
    $('#langChangeNo').click(function() {
        $("#languageChangeModal").modal("hide");
        let lang=$('#prevLang').val()
        $("#languagePickerSelect").val(lang).change();
        $("#languagePickerSelect").val(lang);


        // localStorage.setItem('url', local_url)
        // localStorage.setItem('old_url', local_url)
        // window.location.assign(local_url)
    })
    $('#langChangeLink').click(function () {
        window.location.assign($(this).attr('data-url'))
    })
    window.addEventListener("resize", function(){
        onDraftStatusChanged();
    });

    $('#minimize_button').on('click',function (){

        $('#minimize_button').hide();

    })
    $('.miniIcon').on('click',function (){
        $('#minimize_button').show();
    })
</script>