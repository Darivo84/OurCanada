<script>
    //this file contains all js function used in immigration form

    // *********** functions ***********


    // changes the language of static labels according to the language selected
    function changeStaticLabels() {
        console.log('im in function')
        $('.static_label').each(function() {
            let innerHtml = ''
            var attr = $(this).attr('data-org');

            if (typeof attr !== 'undefined' && attr !== false) {
                innerHtml=attr
            }
            else
            {
                innerHtml=$(this).html()
            }

            if (innerHtml !== '' && innerHtml !== null) {
                if ($(this).attr('data-org')) {
                    innerHtml = $(this).attr('data-org')
                } else {
                    innerHtml = $(this).html()
                }
                if (innerHtml.includes('&amp;')) {
                    innerHtml = innerHtml.replace('&amp;', '&')
                }
                let index = labelsArray.indexOf(innerHtml)

                if (index > -1) {

                    if (labelsTransArray[index] != '') {

                        $(this).html(labelsTransArray[index])
                    }
                    else
                    {

                        $(this).html(labelsArray[index])
                    }
                }

            }

        })
        // setTimeout(function() {
        //     set_alignment()
        // }, 1500)
        // set_alignment()
        changeErrorLabels();
        if (localStorage.getItem('display') == 'Right to Left')
        {
            $('.pb-date').addClass('rightFloat')
        }
    }

    // changes the language of error labels according to the language selected
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

    // get the NOC Jobs/Duties on page load and stores in the local arrays
    function getNoc() {
        $.ajax({
            dataType: 'json',
            url: "<?php echo $currentTheme.$ajaxFileToCall; ?>?h=getNocJobs<?php echo $langParam; ?>",
            type: 'POST',
            success: function(data) {

                is_session(data) //checks if session is expired

                jobsArr = data.jobsArr;
                jobLen = data.jobsLength;

                jobsArrOrg = data.jobsArrOrg;
                dutyArrOrg = data.dutyArrOrg;

                dutyArr = data.dutyArr;
                dutyLen = data.dutyLen;

                tagsInp()
                nocChanger()
            },
            error: function(data) {

            }
        });
    }

    // changes the NOC Jobs/Duties text of dropdown according to the language selected
    function nocChanger() {
        tagsInp()

        if (localStorage.getItem('Lang') !== 'english') {

            $(".nocJobs").each(function() {
                let curValue = $(this).val();
                let index = jobsArrOrg.indexOf(curValue);
                let orgValue = curValue

                if (index > -1) {
                    orgValue = jobsArr[index];
                }

                let getAttr = $(this).attr('name');
                $("input[name='" + getAttr + "']").val(orgValue);
                $(this).prev('div').children('a').children('span.select2-chosen').html(orgValue)


            });
            $(".nocPos").each(function() {
                let curValue = $(this).val();
                let index = dutyArrOrg.indexOf(curValue);
                let orgValue = curValue

                if (index > -1) {
                    orgValue = dutyArr[index];
                }

                var getAttr = $(this).attr('name');
                $("input[name='" + getAttr + "']").val(orgValue);
                $(this).prev('div').children('a').children('span.select2-chosen').html(orgValue)

            });

        } else if (localStorage.getItem('Lang') == 'english') {


            $(".nocJobs").each(function() {
                let curValue = $(this).val();

                let index = jobsArrOrg.indexOf(curValue);
                let orgValue = curValue

                if (index > -1) {
                    orgValue = jobsArr[index];
                }
                let getAttr = $(this).attr('name');
                $("input[name='" + getAttr + "']").val(orgValue);
                $(this).prev('div').children('a').children('span.select2-chosen').html(orgValue)


            });
            $(".nocPos").each(function() {
                let curValue = $(this).val();
                let index = dutyArrOrg.indexOf(curValue);
                let orgValue = curValue

                if (index > -1) {
                    orgValue = dutyArr[index];
                }
                var getAttr = $(this).attr('name');
                $("input[name='" + getAttr + "']").val(orgValue);
                $(this).prev('div').children('a').children('span.select2-chosen').html(orgValue)
            });

        }
    }

    // check the country change for spouse citizenship, a bound for multicondition
    function check_country_change(value, id, pid) {
        if ($(value).hasClass('countryCheck')) {
            let name = $(value).attr('name')
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

            if (namesArray.indexOf(name) > -1) {
                if ($(element1).eq(0).prop('checked') || $(element1).eq(1).prop('checked') || $(element2).eq(0).prop('checked') || $(element2).eq(1).prop('checked')) {

                    if ($('.parent_350').length > 0) {
                        if (val1 !== 'Canada' && val2 !== 'Canada' && val3 !== 'Canada' && val4 !== 'Canada') {
                            no_change = false
                            clicked = true
                            valSave(value)
                            return false
                        } else if (val1 == 'Canada' || val2 == 'Canada' || val3 == 'Canada' || val4 == 'Canada') {

                            change1 = true
                        }
                    } else if ($('.main_parent_74').length > 0 && $('.main_parent_74').css('display') !== 'none') {
                        if (val1 !== 'Canada' && val2 !== 'Canada' && val3 !== 'Canada' && val4 !== 'Canada') {

                            change2 = true
                        } else if (val1 == 'Canada' || val2 == 'Canada' || val3 == 'Canada' || val4 == 'Canada') {
                            no_change = false
                            clicked = true
                            valSave(value)
                            return false
                        }
                    }

                    if (change1 || change2) {
                        let error_msg = '<?php echo $allLabelsArray[102] ?>'//'If you want to change country, you will have to fill the form again'
                        // if (localStorage.getItem('Lang') !== 'english') {
                        //     error_msg = static_label_changer(error_msg)
                        // }
                        temp_val = value;
                        temp_id = id;
                        temp_pid = pid;
                        valSave(value)
                        $('#error_msg').html(error_msg)
                        $('#errorModal').modal()
                        return false
                    } else {
                        no_change = false
                        clicked = true
                    }

                } else {
                    getQuestion(value, id, pid)
                }
            }
        }
    }

    // checks if the question type is NOC and has attribute "data-type=country", set country Canada for "Job" in NOC array
    function noc_job_question(e) {
        let noc_flag = $(e).attr('data-noc')
        let noc_pos = $(e).attr('data-position')
        let noc_user = $(e).attr('data-label')
        let noc_type = $(e).attr('data-type')
        let index = parseInt(noc_pos) - 1;
        let v = $(e).val()
        if (noc_type == '' || noc_type == null || noc_type == undefined) {

        }
        if (noc_pos == '7' && noc_flag == '1' && (noc_type == 'null' || noc_type == '' || noc_type == null || noc_type == undefined)) {
            if (noc_user == 'spouse') {
                if (nocSpouse[index] != '' && v == 'No') {
                    nocSpouse[index] = '';
                } else {
                    nocSpouse[index] = {
                        'position': noc_pos,
                        'job': 1,
                        'country': 'Canada'
                    }
                }
            } else {
                if (nocUser[index] != '' && v == 'No') {
                    nocUser[index] = '';
                } else {
                    nocUser[index] = {
                        'position': noc_pos,
                        'job': 1,
                        'country': 'Canada'
                    }
                }
            }
        }
    }

    // checks if any date of any position gets null, calls on change of date change
    function position_date(value, id, pid, q) {
        if ($(value).hasClass('nocPicker')) {
            let prev = $(value).prev().val()
            if ($(value).val() !== '' && prev !== '') {
                changeFieldState(value,true)
            }

            setTimeout(function() {
                if (checkDate(value)) {
                    if (q === 3) {
                        getQuestion3(value, id, pid)

                    } else {
                        getQuestion(value, id, pid)

                    }
                }
            }, 1000)
        }
    }

    // appends/remove questions of case type "multi condition", calls on every question request's success
    function appendMultiConditionQuestion(id, question_id, parent_id, satisfy, html) {
        for (let i = 0; i < satisfy.length; i++) {
            if (satisfy[i] == 'true') {

                if ($('.parent_' + question_id[i]).length <= 0) {
                    if(parent_id[i]==576)
                    {
                        if(question_id[i]==12306)
                        {
                            $(html[i]).insertAfter($('.parent_12154'))
                        }
                        else if(question_id[i]==12449)
                        {
                            $(html[i]).insertAfter($('.parent_12306'))
                        }
                        else if(question_id[i]==1595)
                        {
                            $(html[i]).insertAfter($('.parent_12449'))
                        }
                        else
                        {
                            $('.main_parent_' + parent_id[i]).append(html[i]);
                        }
                    }
                    else if(parent_id[i]==544)
                    {
                        if(question_id[i]==11602)
                        {
                            $(html[i]).insertAfter($('.parent_11597'))
                        }
                        else if(question_id[i]==11891)
                        {
                            $(html[i]).insertAfter($('.parent_11602'))
                        }
                        else if(question_id[i]==12020)
                        {
                            $(html[i]).insertAfter($('.parent_11891'))
                        }
                        else
                        {
                            $('.main_parent_' + parent_id[i]).append(html[i]);
                        }
                    }
                    else
                    {
                        $('.main_parent_' + parent_id[i]).append(html[i]);
                    }
                }
            } else if (satisfy[i] == 'false') {
                if($('.parent_' + question_id[i]).hasClass('multi'))
                {
                    $('.parent_' + question_id[i]).remove();
                }
            }
        }
    }

    // get the questions from data base and appends according the the satisfying conditions, for level 0/main questions
    function getQuestion(value, id, pid) {

        noc_job_question(value)
        if ((id == 74 || id == 77) && $('.parent_350').length > 0) {
            $('.main_parent_74').each(function() {
                if ($(this).hasClass('displayNone74')) {
                    $(this).remove()

                }
            })
        }

        let name = $(this).attr('name')
        let namesArray = ['n[question_68]', 'n[question_69]', 'n[question_70]', 'n[question_71]']
        let element1 = document.getElementsByName('n[sub_question_350]')
        let element2 = document.getElementsByName('n[question_74]')
        if ($(element1).eq(0).prop('checked') || $(element1).eq(1).prop('checked') || $(element2).eq(0).prop('checked') || $(element2).eq(1).prop('checked')) {
            if (namesArray.indexOf(name) > -1)
            {
                return false
            }
        }

        var termsCheck = '';
        if (localStorage.getItem('AgreeCheck') == 1) {
            termsCheck = 'checked';
            document.cookie = 'AgreeCheck=1';
            localStorage.setItem('AgreeCheck', '1');
        } else {
            termsCheck = 'unchecked';
            localStorage.setItem('AgreeCheck', '0');
            document.cookie = 'AgreeCheck=0';
        }

        afterForm()
        let multi_condition_satisfy = []
        let multi_condition_parent_id = []
        let multi_condition_question_id = []
        let multi_condition_html = []
        if ($(value).parent().find('.temp').length == 0)
            $(value).parent().append('<span class="spinner-border spinner-border-sm temp ' + disCl + '" role="status"></span>');

        changeFieldState(value,true)


        let pos = $(value).parent().children('input').attr('type')


        var val = $(value).val();
        let movescore_case_check = false
        endCase = false

        $('.main_parent_' + id)
            .children() //Select all the children of the parent
            .not(':first-child') //Unselect the first child
            .remove();
        removeLocalStorageValues()

        if (pos === 'date') {
            if (currentRequest === '') {
                req_check = true
            } else {
                req_check = false
            }
        } else {
            req_check = true
        }

        if (req_check) {
            let email = $('input[type="email"]:first').val()
            let formData = $('.myForm').serializeArray()
            formData.push({
                name: $(value).attr('name'),
                value: $(value).val()
            });

            currentRequest = $.ajax({
                dataType: 'json',
                url: "<?php echo $currentTheme.$ajaxFileToCall; ?>?h=getQuestion<?php echo $langParam; ?>",
                type: 'POST',
                data: {
                    'id': id,
                    'value': val,
                    'pid': pid,
                    'form_data': formData
                },
                success: function(data) {

                    is_session(data) //checks if session is expired

                    var fieldData = '';
                    localStorage.setItem('EndCase', '');

                    for (var i = 0; i < data.data.length; i++) {
                        if (data.data[i].casetype == 'email' && emailCount == true) {
                            continue;
                        }
                        let noc_attr = "data-noc='" + data.data[i].noc_flag + "' data-position='" + data.data[i].position_no + "' data-type='" + data.data[i].noc_type + "' data-label='" + data.data[i].user_type + "'"
                        let permission = '';
                        if (data.data.permission == 1) {
                            permission = 'permitted'
                        } else {
                            permission = 'forbidden'
                        }

                        if (data.data[i].check == 3) {
                            continue
                        } else if (data.data[i].ques_case == 'movescore') {
                            $('#scoreID').val(data.data[i].scoreID)
                            // $('#validateform').submit()
                            movescore_case_check = true;
                            continue;
                        } else if (data.data[i].casetype == 'existing') {
                            fieldData += data.data[i].existing_data;
                            continue;
                        } else if (data.data[i].casetype == 'group') {
                            fieldData += data.data[i].group_data;
                            continue;
                        } else if (data.data[i].casetype == 'groupques') {
                            fieldData += data.data[i].group_data2;
                            continue;
                        } else if (data.data[i].check == 4) {
                            fieldData += data.data[i].gData;

                            cq = data.data[i].checkQuesID;
                            cv = data.data[i].checkVal;
                            hv = data.data[i].hideQuesID;
                            cf = data.data[i].checkQuestField;
                            co = data.data[i].checkOp;

                            checkField.push(cf)
                            hiddenQues.push(hv)
                            checkQues.push(cq)
                            checkValue.push(cv)
                            checkOp.push(co)


                            continue;
                        } else if (data.data[i].casetype == 'multicondition') {
                            multi_condition_satisfy.push(data.data[i].satisfy)
                            multi_condition_parent_id.push(data.data[i].parent_id)
                            multi_condition_question_id.push(data.data[i].question_id)
                            multi_condition_html.push(data.data[i].html)
                            continue;
                        } else {
                            fieldData += "<div class='parent_" + data.data[i].id + "'>"
                        }


                        if (termsCheck == 'unchecked') {
                            $('.parent_' + data.data[i].id).addClass('unChecked');
                        } else {

                        }

                        if (data.data[i].casetype == 'email' && emailCount == false) {
                            emailCount = true
                            if (submission) {
                                fieldData += "<div style='background: #d1f0d1' class='form-group level1 email sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'><label class='pb-1 static_label'>Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.</label>";

                            } else {
                                fieldData += "<div style='background: #d1f0d1;display:none' class='form-group level1 email sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'><label class='pb-1 static_label'>Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.</label>";

                            }

                        } else if (data.data[i].casetype == 'exit' || data.data[i].casetype == 'none') {
                            fieldData += "";
                            continue;
                        } else if (data.data[i].casetype == 'end') {
                            // $('#btnModal').click()
                            localStorage.setItem('EndCase', 'matched');
                            endCase = true;
                            endCase_message = '<?php echo $allLabelsArray[214] ?>'//'Thank you for using our immigration tool and for your interest in Canada!'
                        } else if (data.data[i].casetype == 'endwt') {
                            // $('#btnModal').click()
                            localStorage.setItem('EndCase', 'matched');
                            endCase = true;
                            endCase_message = '<?php echo $allLabelsArray[4] ?>'//'Thank You for your interest in Canada'

                        } else if (data.data[i].casetype == 'endwc') {
                            // $('#btnModal').click()
                            localStorage.setItem('EndCase', 'matched');
                            endCase = true;
                            endCase_message = '<?php echo $allLabelsArray[37] ?>'//'Congratulations and thank you for your interest in Canada'

                        } else if (data.data[i].casetype == 'endwa') {
                            // $('#btnModal').click()
                            localStorage.setItem('EndCase', 'matched');
                            endCase = true;
                            endCase_message = '<?php echo $allLabelsArray[18] ?>'//'Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.'
                        } else {
                            if (data.data[i].check == 1) {

                                if (termsCheck == 'unchecked') {

                                    fieldData += "<div class='form-group sub_question_div unChecked sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'>"
                                } else {
                                    fieldData += "<div class='form-group sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'>"
                                }


                                if (data.data[i].notes != '' && data.data[i].notes != null && data.data[i].field != 'pass') {


                                    fieldData += "<p class='notesPara' data-org='" + data.data[i].org_notes + "'>" + data.data[i].notes + " </p>"

                                }

                                fieldData += "<label class='pb-1' data-org='" + data.data[i].org_question + "'>" + data.data[i].other + "</label>";
                            } else {

                                if (termsCheck == 'unchecked') {
                                    fieldData += "<div class='form-group sub_question_div unChecked sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'>"

                                } else {
                                    fieldData += "<div class='form-group sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'>"
                                }


                                if (data.data[i].notes != '' && data.data[i].notes != null) {

                                    fieldData += "<p class='notesPara' data-org='" + data.data[i].org_notes + "'>" + data.data[i].notes + " </p>"

                                }

                                fieldData += "<label class='pb-1' data-org='" + data.data[i].org_question + "'>" + data.data[i].question + "</label>";
                            }
                            let disp_class = ''
                            if (localStorage.getItem('display') == 'Right to Left') {
                                disp_class = ' urduField'
                            }
                            fieldData += "<div class='input-group input-group-merge " + permission + disp_class + "'>"


                            if (data.data[i].field == 'radio' && data.data[i].labeltype == 0) {
                                let y = 'Yes'
                                let n = 'No'
                                if (localStorage.getItem('Lang') !== 'english') {
                                    y = static_label_changer(y)
                                    n = static_label_changer(n)
                                }

                                fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='Yes' " + noc_attr + "><span class='customLabel' data-org='Yes'>" + y + "</span>"
                                fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='No' " + noc_attr + "><span class='customLabel' data-org='No'>" + n + "</span>";

                            } else if (data.data[i].field == 'radio' && data.data[i].labeltype == 1) {
                                fieldData += data.data[i].radios;
                            } else if (data.data[i].field == 'phone') {
                                fieldData += "<input " + data.data[i].validation + " type='tel'   minlength='6' maxlength='15' class='form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                            } else if (data.data[i].field == 'calender') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                            } else if (data.data[i].field == 'age') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker age' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                                fieldData += "<input type='text' class='form-control dob' readonly hidden name='dob*" + data.data[i].id + "'>"
                            } else if (data.data[i].field == 'email') {
                                fieldData += "<input " + data.data[i].validation + " type='email' class='form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                            } else if (data.data[i].field == 'country') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control countryCheck' onchange='getQuestion3(this," + data.data[i].id + "," + id + ")' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                                let op = '--Select--'
                                if (localStorage.getItem('Lang') !== 'english') {
                                    op = static_label_changer(op)
                                }
                                fieldData += "<option value='' disabled selected class='static_label' data-org='--Select--'>" + op + "</option>";
                                for (var j = 0; j < (data.country).length; j++) {
                                    let c = data.country[j].name
                                    fieldData += "<option value='" + data.country[j].value + "' >" + c + "</option>";

                                }
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'education') {
                                fieldData += "<select " + data.data[i].validation + " class='education form-control' onchange='getQuestion3(this," + data.data[i].id + "," + id + ")' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                                let op = '--Select--'
                                if (localStorage.getItem('Lang') !== 'english') {
                                    op = static_label_changer(op)
                                }
                                fieldData += "<option value='' disabled selected class='static_label' data-org='--Select--'>" + op + "</option>";
                                for (var j = 0; j < (data.education).length; j++) {
                                    let c = data.education[j].name
                                    fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                                }
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'dropdown') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control' onchange='getQuestion3(this," + data.data[i].id + "," + id + ")' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                                let op = '--Select--'
                                if (localStorage.getItem('Lang') !== 'english') {
                                    op = static_label_changer(op)
                                }
                                fieldData += "<option value='' disabled selected class='static_label' data-org='--Select--'>" + op + "</option>";
                                fieldData += data.data[i].dropdown;
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'nocjob') {

                                fieldData += "<input " + data.data[i].validation + " class='" + data.data[i].validation + " form-control nocJobs' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                            } else if (data.data[i].field == 'nocduty') {
                                fieldData += "<input " + data.data[i].validation + " class='" + data.data[i].validation + " form-control nocPos' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                            } else if (data.data[i].field == 'pass') {
                                fieldData += "<label class='notesPara2'>" + data.data[i].notes + "</label>"
                            } else if (data.data[i].field == 'number') {
                                fieldData += "<input " + data.data[i].validation + " type='number' class='form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";

                            } else if (data.data[i].field == 'currentrange') {
                                let current_datetime = new Date()
                                let m = ((current_datetime.getMonth() + 1) >= 10) ? (current_datetime.getMonth() + 1) : '0' + (current_datetime.getMonth() + 1);
                                let d = ((current_datetime.getDate()) >= 10) ? (current_datetime.getDate()) : '0' + (current_datetime.getDate());
                                let formatted_date = current_datetime.getFullYear() + "-" + m + "-" + d

                                fieldData += "<label class='pb-date static_label'>From</label><label class='pb-date static_label'>To</label>"
                                fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='from'   type='text' class='datepicker form-control nocPicker' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                                fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='to' onchange='position_date(this," + data.data[i].id + "," + id + ",3)'     type='text' class='datepicker form-control nocPicker' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                                fieldData += "<div class='presCheck'><input type='checkbox' class='present_checkbox' onchange='if(presentBox(this)==false){return false;}getQuestion3(this," + data.data[i].id + "," + id + ")'><span class='presentCheckbox static_label'>Present</span></div>"

                            } else {
                                fieldData += "<input " + data.data[i].validation + " onfocusout='getQuestion3(this," + data.data[i].id + "," + id + ")' type='text' class='form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                            }
                        }
                        fieldData += "</div>";
                        fieldData += "</div>";
                        fieldData += "</div>";


                    }
                    if (id == 544 || id == 576) {
                        appendMultiConditionQuestion(id, multi_condition_question_id, multi_condition_parent_id, multi_condition_satisfy, multi_condition_html)
                        $('.main_parent_' + id).append(fieldData)
                        valSave(value);

                    } else {
                        $('.main_parent_' + id).append(fieldData)
                        appendMultiConditionQuestion(id, multi_condition_question_id, multi_condition_parent_id, multi_condition_satisfy, multi_condition_html)


                    }
                    changeFieldState(value,false)
                    valSave(value)


                    if (movescore_case_check) {
                        changeFieldState(value,false)
                        $('#validateform').submit()
                    }
                    if (endCase) {
                        if ($('#validateform').valid()) {
                            if (custom_validation()) {
                                localStorage.setItem('drafted','true');
                                onDraftStatusChanged();

                                $('#commentModal').modal()

                            }
                        } else {
                            $('#validateform').valid()
                        }
                    }
                    if (id !== 74) {
                        movegroup('')
                    }
                    if (localStorage.getItem('AgreeCheck') == 0 || localStorage.getItem('AgreeCheck') == '0') {
                        $(".unChecked").css('display', 'none');

                    }
                    tagsInp()
                    currentRequest = '';
                    req_check = false
                    formFunc(value)

                },
                error: function(data) {
                    changeFieldState(value,false)

                    $('#btnModal2').click()
                    currentRequest = '';
                    req_check = false
                }
            });
        }
    }


    // get the questions from data base and appends according the the satisfying conditions, for level 1/sub questions
    function getQuestion3(value, id, qid, pid) {
        noc_job_question(value)
        if ($(value).hasClass('datepicker')) {
            if ($(value).val() == '' || date_check(value, 1) == false) {
                $(value).parent().children('input.dob').val($(value).val())

                valSave($(value).parent().children('input.dob'))

                $('.parent_' + id)
                    .children()
                    .not(':first-child')
                    .remove();
                return false
            }
        }

        if (id == 11580) {
            let ele = document.getElementsByName('n[question_116]')
            if (ele[0].checked == true) {
                if ($(value).val() == 'No') {

                    $('#scoreID').val(598.1)
                    $('#validateform').submit();
                    return false
                }
            }
        }

        if (id == 12810) {
            let ele = document.getElementsByName('n[question_92]')
            if (ele[0].checked == true) {
                if ($(value).val() == 'No') {

                    $('#scoreID').val(599)
                    $('#validateform').submit();
                    return false
                }
            }
        }
        afterForm()
        let multi_condition_satisfy = []
        let multi_condition_parent_id = []
        let multi_condition_question_id = []
        let multi_condition_html = []
        if ($(value).parent().find('.temp').length == 0)
            $(value).parent().append('<span class="spinner-border spinner-border-sm temp ' + disCl + '" role="status"></span>');

        changeFieldState(value,true)


        var val = $(value).val();

        var ab = $('.parent_' + id).children().hasClass('multi')

        $('.parent_' + id)
            .children()
            .not(':first-child')
            .remove();
        removeLocalStorageValues()

        let email = $('input[type="email"]:first').val()
        endCase = false
        let already_exists = false
        if (id !== 150) {
            $('div').each(function() {
                if ($(this).hasClass('parent_150')) {
                    already_exists = true
                }
            })
        }

        if (!already_exists) {
            if (id == 149) {
                $('.parent_151').remove()
            }

            let formData = $('.myForm').serializeArray()
            formData.push({
                name: $(value).attr('name'),
                value: $(value).val()
            });
            $.ajax({
                dataType: 'json',
                url: "<?php echo $currentTheme.$ajaxFileToCall; ?>?h=getQuestion3<?php echo $langParam; ?>",
                type: 'POST',
                data: {
                    'id': id,
                    'value': val,
                    'qid': qid,
                    'pid': 0,
                    'form_data': formData

                },
                success: function(data) {
                    localStorage.setItem('EndCase', '');

                    is_session(data) //checks if session is expired

                    var fieldData = '';

                    for (var i = 0; i < data.data.length; i++) {
                        console.log('return  =>'+eca_check(id) +'-'+ eca_check2(id))
                        if (eca_check(id) == true || eca_check2(id) == true) {
                            if (data.data[i].casetype == 'existing') {
                                continue
                            }
                        }

                        if (data.data[i].casetype == 'email' && emailCount == true) {
                            continue;
                        }
                        if (data.data[i].casetype == 'multicondition') {
                            multi_condition_satisfy.push(data.data[i].satisfy)
                            multi_condition_parent_id.push(data.data[i].parent_id)
                            multi_condition_question_id.push(data.data[i].question_id)
                            multi_condition_html.push(data.data[i].html)
                            continue;
                        }
                        let noc_attr = "data-noc='" + data.data[i].noc_flag + "' data-position='" + data.data[i].position_no + "' data-type='" + data.data[i].noc_type + "' data-label='" + data.data[i].user_type + "'"
                        let permission = '';
                        if (data.data.permission == 1) {
                            permission = 'permitted'
                        } else {
                            permission = 'forbidden'
                        }
                        if (data.data[i].check == 4) {
                            fieldData += data.data[i].gData;

                            cq = data.data[i].checkQuesID;
                            cv = data.data[i].checkVal;
                            hv = data.data[i].hideQuesID;
                            cf = data.data[i].checkQuestField;
                            co = data.data[i].checkOp;

                            checkField.push(cf)
                            hiddenQues.push(hv)
                            checkQues.push(cq)
                            checkValue.push(cv)
                            checkOp.push(co)


                            continue;
                        }

                        if (data.data[i].casetype == 'existingcheck') {
                            fieldData += data.data[i].html;
                            continue;
                        }
                        if (data.data[i].casetype == 'group') {
                            fieldData += data.data[i].group_data;
                            continue;
                        }
                        if (data.data[i].casetype == 'groupques') {
                            fieldData += data.data[i].group_data2;
                            continue;
                        }
                        if (data.data[i].casetype == 'existing') {
                            fieldData += data.data[i].existing_data;
                            continue;
                        }
                        if (data.data[i].ques_case == 'movescore') {
                            $('#scoreID').val(data.data[i].scoreID)
                            $('#validateform').submit()
                            fieldData = ''
                            continue;

                        }
                        if (data.data[i].casetype == 'age') {
                            if (ageLimit(data.data[i].group_operator, data.data[i].value)) {
                                $('#btnModal').click()
                                fieldData = ''
                                break;
                            } else
                                continue;
                        }


                        fieldData += "<div class='parent_" + data.data[i].id + "'>"


                        if (data.data[i].casetype == 'email' && emailCount == false) {
                            emailCount = true

                            if (submission) {
                                fieldData += "<div style='background: #d1f0d1' class='form-group email level2 sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'><label class='pb-1 static_label'>Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.</label>";

                            } else {
                                fieldData += "<div style='background: #d1f0d1;display:none' class='form-group level2 email sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'><label class='pb-1 static_label'>Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.</label>";

                            }
                            fieldData += "</div>";
                            fieldData += "</div>"
                            $('.parent_' + id).append(fieldData)
                            fieldData = '';
                            continue

                        } else if (data.data[i].casetype == 'exit' || data.data[i].casetype == 'none') {
                            fieldData = "";
                            continue;
                        } else if (data.data[i].casetype == 'end') {
                            // $('#btnModal').click()
                            localStorage.setItem('EndCase', 'matched');
                            endCase = true;
                            console.log('end case--'+localStorage.getItem('EndCase'))
                            endCase_message = '<?php echo $allLabelsArray[214] ?>'//'Thank you for using our immigration tool and for your interest in Canada!'
                        } else if (data.data[i].casetype == 'endwt') {
                            // $('#btnModal').click()
                            localStorage.setItem('EndCase', 'matched');
                            endCase = true;
                            endCase_message = '<?php echo $allLabelsArray[4] ?>'//'Thank You for your interest in Canada'

                        } else if (data.data[i].casetype == 'endwc') {
                            // $('#btnModal').click()
                            localStorage.setItem('EndCase', 'matched');
                            endCase = true;
                            endCase_message = '<?php echo $allLabelsArray[37] ?>'//'Congratulations and thank you for your interest in Canada'

                        } else if (data.data[i].casetype == 'endwa') {
                            // $('#btnModal').click()
                            localStorage.setItem('EndCase', 'matched');
                            endCase = true;
                            endCase_message ='<?php echo $allLabelsArray[18] ?>'// 'Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.'
                        } else {

                            if (data.data[i].check == 1) {
                                fieldData += "<div class='form-group sub_question_div2 sques_" + qid + " sques_" + pid + " sques2_" + id + "' id='sub_question_div2_" + data.data[i].id + "'>"
                                if (data.data[i].notes != '' && data.data[i].notes != null && data.data[i].field != 'pass') {

                                    fieldData += "<p class='notesPara' data-org='" + data.data[i].org_notes + "'>" + data.data[i].notes + " </p>"

                                }
                                fieldData += "<label class='pb-1' data-org='" + data.data[i].org_question + "'>" + data.data[i].other + "</label>";
                            } else {
                                fieldData += "<div class='form-group sub_question_div2 sques_" + qid + " sques2_" + id + "' id='sub_question_div2_" + data.data[i].id + "'>"
                                if (data.data[i].notes != '' && data.data[i].notes != null) {

                                    fieldData += "<p class='notesPara' data-org='" + data.data[i].org_notes + "'>" + data.data[i].notes + " </p>"

                                }

                                fieldData += "<label class='pb-1' data-org='" + data.data[i].org_question + "'>" + data.data[i].question + "</label>";


                            }
                            fieldData += "<div class='input-group input-group-merge " + permission + "'>"

                            if (data.data[i].field == 'radio' && data.data[i].labeltype == 0) {

                                let y = 'Yes'
                                let n = 'No'

                                if (localStorage.getItem('Lang') !== 'english') {
                                    y = static_label_changer(y)
                                    n = static_label_changer(n)
                                }
                                fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_2" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='Yes' " + noc_attr + "><span class='customLabel' data-org='Yes'>" + y + "</span>"
                                fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_2" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='No' " + noc_attr + "><span class='customLabel' data-org='No'>" + n + "</span>";

                            } else if (data.data[i].field == 'radio' && data.data[i].labeltype == 1) {
                                fieldData += data.data[i].radios;
                            } else if (data.data[i].field == 'calender') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                            } else if (data.data[i].field == 'age') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker age' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                                fieldData += "<input type='text' class='form-control dob' readonly hidden name='dob*" + data.data[i].id + "'>"

                            } else if (data.data[i].field == 'email') {
                                fieldData += "<input " + data.data[i].validation + " type='email' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                            } else if (data.data[i].field == 'phone') {
                                fieldData += "<input " + data.data[i].validation + " type='tel'   minlength='6' maxlength='15' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                            } else if (data.data[i].field == 'country') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control countryCheck' onchange='getQuestion3(this," + data.data[i].id + ")' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">"
                                fieldData += "<option value='' disabled selected>--Select--</option>";
                                for (var j = 0; j < (data.country).length; j++) {
                                    let c = data.country[j].name
                                    fieldData += "<option value='" + data.country[j].value + "' >" + c + "</option>";

                                }
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'education') {
                                fieldData += "<select " + data.data[i].validation + " class='education form-control' onchange='getQuestion3(this," + data.data[i].id + ")' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">"
                                let op = '--Select--'
                                if (localStorage.getItem('Lang') !== 'english') {
                                    op = static_label_changer(op)
                                }
                                fieldData += "<option value='' disabled selected class='static_label' data-org='--Select--'>" + op + "</option>";
                                for (var j = 0; j < (data.education).length; j++) {
                                    let c = data.education[j].name
                                    fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                                }
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'dropdown') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control' name='n[sub_question_2" + data.data[i].id + "]'" + noc_attr + ">"
                                let op = '--Select--'
                                if (localStorage.getItem('Lang') !== 'english') {
                                    op = static_label_changer(op)
                                }
                                fieldData += "<option value='' disabled selected class='static_label' data-org='--Select--'>" + op + "</option>";
                                fieldData += data.data[i].dropdown;
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'nocjob') {
                                fieldData += "<input " + data.data[i].validation + " class='" + data.data[i].validation + " form-control nocJobs' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                            } else if (data.data[i].field == 'nocduty') {
                                fieldData += "<input " + data.data[i].validation + " class='" + data.data[i].validation + " form-control nocPos' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                            } else if (data.data[i].field == 'pass') {
                                fieldData += "<label class='notesPara2'>" + data.data[i].notes + "</label>"
                            } else if (data.data[i].field == 'number') {
                                fieldData += "<input " + data.data[i].validation + " type='number' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";

                            } else if (data.data[i].field == 'currentrange') {

                                let current_datetime = new Date()
                                let m = ((current_datetime.getMonth() + 1) >= 10) ? (current_datetime.getMonth() + 1) : '0' + (current_datetime.getMonth() + 1);
                                let d = ((current_datetime.getDate()) >= 10) ? (current_datetime.getDate()) : '0' + (current_datetime.getDate());
                                let formatted_date = current_datetime.getFullYear() + "-" + m + "-" + d
                                fieldData += "<label class='pb-date static_label'>From</label><label class='pb-date static_label'>To</label>"

                                fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='from'     type='text' class='nocPicker datepicker form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                                fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='to' onchange='position_date(this," + data.data[i].id + "," + id + ",3)'     type='text' class='nocPicker datepicker form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                                fieldData += "<div class='presCheck'><input type='checkbox' class='present_checkbox' onchange='if(presentBox(this)==false){return false;}getQuestion3(this," + data.data[i].id + "," + id + ")'><span class='presentCheckbox static_label'>Present</span></div>"

                                fieldData += "</div>";

                            } else {
                                fieldData += "<input " + data.data[i].validation + " onfocusout='getQuestion3(this," + data.data[i].id + "," + id + ")' type='text' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                            }
                        }

                        fieldData += "</div>";
                        fieldData += "</div>"
                        fieldData += "</div>";

                    }

                    if (id==624 || id==647 || id==667  || id==689 || id==712) {
                        let job_check=job_offer_check(id,0)
                        if(!job_check)
                        {
                            $('.parent_' + id).append(fieldData)
                            $('.parent_724').remove()
                            appendMultiConditionQuestion(id, multi_condition_question_id, multi_condition_parent_id, multi_condition_satisfy, multi_condition_html)

                        }
                        if(job_check)
                        {
                            if($('.parent_724').length <= 0)
                            {
                                $('.main_parent_110').append(fieldData)
                            }
                        }
                    }
                    else  if (id==277 || id==297 || id==316  || id==336 || id==372) {
                        let job_check=job_offer_check(id,1)
                        console.log('im in func-'+job_check)

                        if(!job_check)
                        {
                            $('.parent_' + id).append(fieldData)
                            $('.parent_383').remove()
                            appendMultiConditionQuestion(id, multi_condition_question_id, multi_condition_parent_id, multi_condition_satisfy, multi_condition_html)

                        }
                        if(job_check)
                        {
                            if($('.parent_383').length <= 0)
                            {
                                $('.main_parent_84').append(fieldData)
                            }
                        }
                    }
                    else
                    {
                        if(qid==576 || qid==544)
                        {
                            appendMultiConditionQuestion(id, multi_condition_question_id, multi_condition_parent_id, multi_condition_satisfy, multi_condition_html)
                            $('.parent_' + id).append(fieldData)
                            valSave(value)
                        }
                        else
                        {
                                $('.parent_' + id).append(fieldData)
                                appendMultiConditionQuestion(id, multi_condition_question_id, multi_condition_parent_id, multi_condition_satisfy, multi_condition_html)

                        }
                    }

                    if (id != 350) {
                        if ($('.parent_' + id).length <= 1) {
                            movegroup('')
                        }
                    }
                    valSave(value)

                    tagsInp()
                    changeFieldState(value,false)
                    formFunc(value)

                    if (endCase) {
                        if ($('#validateform').valid()) {
                            if (custom_validation()) {
                                $('#commentModal').modal()
                                localStorage.setItem('drafted','true');
                                onDraftStatusChanged();
                            }
                        } else {
                            $('#validateform').valid()
                        }

                    }

                },
                error: function(data) {
                    changeFieldState(value,false)

                    $('#btnModal2').click()
                }
            });


        } else {
            changeFieldState(value,false)
            formFunc(value)
        }
        already_exists = false
    }


    // get the questions from data base and appends according the the satisfying conditions, calls on after submission return of "move to question"
    function getQuestion6(id, type, ques_id) {

        let email = $('input[type="email"]:first').val()
        $.ajax({
            dataType: 'json',
            url: "<?php echo $currentTheme.$ajaxFileToCall; ?>?h=getQuestion6<?php echo $langParam; ?>",
            type: 'POST',
            data: {
                'id': id,
                'questiontype': type,
                'ques_id': ques_id,
                'email': email //#bg70143
            },
            success: function(data) {


                is_session(data) //checks if session is expired
                if (id == 573) {
                    if (custom_validation()) {
                        $('#commentModal').modal()
                        localStorage.setItem('drafted','true');
                        onDraftStatusChanged();
                        $('#scoreID').val(622)
                        progressBar(2)

                    }
                } else {
                    $('.formDiv').append(data.data[0].html)
                    progressBar(3)
                }
                formFunc()
                tagsInp()
                $('.scroll-edit').show();
                console.log('showing edit button 1')
            },
            error: function(data) {
                $('#btnModal2').click()
            }
        });
    }

    // checks if session is expired, calls on every question request's success
    function is_session(data)
    {
        if (data.Success == 'false1') {

            if (data.logout == "yes") {
                let error_msg = '<?php echo $allLabelsArray[185] ?>'//'This session is expired because another user is currently logged in with this account on different browser/machine.'
                // if (localStorage.getItem('Lang') !== 'english') {
                //     error_msg = static_label_changer(error_msg)
                // }
                // make_toast("danger", "", error_msg);
                // if user login from new session this session will automatically go to logout
                //setTimeout(function() {
                //    window.location.href = "<?php //echo $currentTheme; ?>//logout<?//= $langURL?>//";
                //}, 3000);
                $(".spinner-border").remove();
                $("#continueLoginModal").modal('show');


                // modal show krwana hai

            } else {
                $(".formContainer").remove()
                $(".ipblockContainer").removeClass("d-none");
                return false;
            }
        }
    }
    // set input fields enabled/disabled after answering question, calls on every question's change and on request's success
    function changeFieldState(element,state)
    {
        if(!state)
        {
            $(element).parent().find('.temp').remove()
        }
        $(element).parent().children('input').prop('disabled', state)
        $(element).parent().children('select').prop('disabled', state)
        $(element).parent().children('.presCheck').children('input').prop('disabled', state)
        // $(element).parent().children('input[type="radio"]').prop('disabled', state)

    }
    // eca question bound for user's education questions, calls on every element change
    function eca_check(id) {
        console.log('checked ID-'+id)
        if (id == 586 || id == 594 || id == 573 || id == 595 || id == 598) {
            let divs_count = 0;
            let no_count = 0;

            let div_class = ''
            $('div').each(function() {
                div_class = ($(this).attr('class'))
                if (div_class !== undefined) {
                    if (div_class.includes('parent')) {
                        let div_class2 = div_class.split('_')
                        if(div_class2[1]!='parent')
                        {
                            let check = eca_user_array.indexOf(parseInt(div_class2[1]))
                            console.log(div_class2[1]+'='+check)
                            if (check > -1) {
                                divs_count++
                                let ele = document.getElementsByName('n[sub_question_' + div_class2[1] + ']')
                                if (ele !== undefined) {
                                    console.log('yes-'+div_class2[1]+'-'+ele[0].checked)

                                    if (ele[0].checked == true) {
                                        no_count++;
                                    }
                                }
                            }
                        }

                    }
                }
            })
            console.log('count--'+no_count +'-'+ divs_count)
            if ((no_count != divs_count))
            {
                if(no_count==0 && divs_count>0)
                {
                    return false
                }
                else
                {
                    return true
                }
            }

            return true
        } else {
            return false
        }
    }

    // eca question bound for spouse's education questions, calls on every element change
    function eca_check2(id) {
        if (id == 187 || id == 186 || id == 183 || id == 176 || id == 191 || id == 192 || id == 195 || id == 197) {
            let divs_count = 0;
            let no_count = 0;

            let div_class = ''
            $('div').each(function() {
                div_class = ($(this).attr('class'))
                if (div_class !== undefined) {
                    if (div_class.includes('parent')) {
                        let div_class2 = div_class.split('_')
                        let check = eca_spouse_array.indexOf(parseInt(div_class2[1]))
                        if (check > -1) {
                            divs_count++
                            let ele = document.getElementsByName('n[sub_question_' + div_class2[1] + ']')
                            if (ele !== undefined) {
                                if (ele[0].checked == true) {
                                    no_count++;
                                }
                            }
                        }
                    }
                }
            })
            if (no_count != divs_count) {
                if(no_count==0 && divs_count>0)
                {
                    return false
                }
                else
                {
                    return true
                }
            }

            return true
        } else {
            return false
        }
    }

    //job offer bound for both user and spouse, calls on every element change
    function job_offer_check(id, user) {

        let divs_count = 0;
        let no_count = 0;
        let div_class = ''
        $('div').each(function() {
            div_class = ($(this).attr('class'))
            if (div_class !== undefined) {
                if (div_class.includes('parent')) {
                    let div_class2 = div_class.split('_')
                    let check = job_user_array.indexOf(parseInt(div_class2[1]))

                    if (user == 0) {
                        check = job_user_array.indexOf(parseInt(div_class2[1]))

                    } else {
                        check = job_spouse_array.indexOf(parseInt(div_class2[1]))

                    }
                    if (check > -1) {
                        divs_count++
                        let ele = document.getElementsByName('n[sub_question_' + div_class2[1] + ']')

                        if (ele !== undefined) {
                            if ($(ele).val() !== 'Canada') {
                                no_count++;
                            }

                        }
                    }
                }
            }
        })
        console.log(no_count == divs_count)
        if (no_count == divs_count) {
            return true
        }

        return false

    }


    // check if question's submission type is "after" and
    function afterForm(e) {
        let a = $(e).parent().parent().parent()
        if (!a.hasClass('afterSub')) {
            let v = $('#submitCheck').val()
            if (v == 1 || v == '1') {
                $('.afterSub').remove()
            }
        }
    }

    function ageLimit(c, age) {

        if (check_cond(years, c, age)) {
            return true;
        }
        return false
    }

    function movegroup(e) {

        bbb = false;
        for (let k = 0; k < checkField.length; k++) {

            if (bbb == true && hiddenQues[k] == 74) {
                continue
            }
            $('.displayNone' + hiddenQues[k]).hide();

            $('.main_parent_' + hiddenQues[k]).not(':first').remove()
            if (checkField[k] == 'age') {

                let c = checkOp[k];
                if (check_cond(years, c, checkValue[k])) {
                    $('.main_parent_' + hiddenQues[k]).show()
                }
            } else {
                let sv = document.getElementsByName('n[sub_question_2' + checkQues[k] + ' ')
                let sel = document.getElementsByName('n[question_' + checkQues[k] + ']')
                gv = $('#question_div_' + checkQues[k]).children('div').children('input[type="radio"]:checked')

                if ($(gv).length > 0 && $(gv).val() == checkValue[k]) {
                    $('.main_parent_' + hiddenQues[k]).show()
                } else if ($(sv.item(0)).val() == checkValue[k]) {
                    $('.main_parent_' + hiddenQues[k]).show()
                } else {
                    if (sel.length > 0 && hiddenQues[k] == 74) {
                        if ($('.parent_350').length <= 0) {
                            if (bbb == false) {
                                movegroup4(sel)
                            }
                        }

                    }
                }
            }
        }

    }

    function movegroup2(e) {
        let val = $(e).attr('id')
        let val2 = val.split('_')


        for (let k = 0; k < checkQues.length; k++) {
            if (checkQues[k] == val2[1]) {
                let c = $('#question_div_' + checkQues[k]).children('div').children('input[type="radio"]:checked')


                if ($(c).length > 0 && $(c).val() == checkValue[k]) {
                    $('.main_parent_' + hiddenQues[k]).show()

                } else {

                    c = $('#sub_question_div_' + checkQues[k]).children('input[type="radio"]:checked')

                    if ($(c).length > 0 && $(c).val() == checkValue[k]) {
                        $('.main_parent_' + hiddenQues[k]).show()

                    } else {

                        $('.main_parent_' + hiddenQues[k])
                            .children()
                            .not(':first-child')
                            .remove();
                        $('.main_parent_' + hiddenQues[k]).hide()
                        $('.main_parent_' + hiddenQues[k]).children().children('div').children('input[type="radio"]').prop('checked', false)
                    }
                }
            }
        }

    }

    function movegroup3(e) {

        let dateVal = $(e).val()
        dateVal = dateVal.split('-')
        let sDate2 = dateVal[0] + "/" + dateVal[1] + "/" + dateVal[2]
        let enteredDate2 = sDate2
        let y = new Date(new Date() - new Date(enteredDate2)).getFullYear() - 1970;
        let name = $(e).attr('name')

        name = name.split('_')
        let name2 = name[1].slice(0, -1)

        for (let k = 0; k < checkField.length; k++) {
            if (name2 == checkQues[k]) {
                $('.main_parent_' + hiddenQues[k])
                    .children()
                    .not(':first-child')
                    .remove();
                $('.main_parent_' + hiddenQues[k]).hide()
                $('.main_parent_' + hiddenQues[k]).children().children('div').children('input[type="radio"]').prop('checked', false)
            }

        }
        for (let k = 0; k < checkField.length; k++) {

            if (name2 == checkQues[k]) {
                let c = checkOp[k];

                if (check_cond(y, c, checkValue[k])) {
                    $('.main_parent_' + hiddenQues[k]).show()
                }
            }
        }
    }

    function movegroup4(e) {

        let dateVal = $(e).val()

        let y = dateVal
        let name = $(e).attr('name')
        let name2 = '';
        if ((name != undefined || name != '') && name.includes('_')) {
            name = name.split('_')
            name2 = name[1].slice(0, -1)
        }
        for (let k = 0; k < checkField.length; k++) {

            if (name2 == checkQues[k]) {
                let c = checkOp[k];
                let bool=check_cond(y, c, checkValue[k])
                if (bool) {
                    $('.main_parent_' + hiddenQues[k]).show()
                    bbb = true;
                    break;
                } else {
                    $('.main_parent_' + hiddenQues[k]).hide()
                    bbb = false;
                    break;
                }

            }

        }
    }


    // calculate the years of experience for every position of work experience, calls on change of position's date
    function noc(e, s) {

        let noc_flag = $(e).attr('data-noc')
        let noc_pos = $(e).attr('data-position')
        let noc_user = $(e).attr('data-label')
        let noc_type = $(e).attr('data-type')
        let date_pos = $(e).attr('data-id')
        let index = parseInt(noc_pos) - 1
        let cemp = 0;


        if (s == 'off1') {
            if (noc_user == 'spouse') {
                nocSpouse[index] = ''

            } else {
                nocUser[index] = ''
                nocUser[index] = ''

            }
            $(e).val('')
            $(e).parent().children('input').prop('disabled', false)
            $(e).parent().children('select').prop('disabled', false)
            $(e).parent().children('.presCheck').children('input').prop('disabled', false)
            $(e).next('input').val('')
            $(e).parent().children('.presCheck').children('input').prop('checked', false)
            $(e).next('input').css('pointer-events', 'auto')
            $(e).parent().parent().parent()
                .children() //Select all the children of the parent
                .not(':first-child') //Unselect the first child
                .remove();
            formFunc('')
            console.log('removed date')
            localStorage.removeItem($(e).attr('name'))
            localStorage.removeItem($(e).attr('name') + ' from')
            localStorage.removeItem($(e).parent().children('input').attr('name'))

            // valSave(e)
            // valSave($(e).parent().children('input').eq(1))
            return false
        }


        if (date_pos == 'to') {
            if (s == '') {
                $(e).next('div.presCheck').children('input').prop('checked', false);
            }
            if (noc_user == 'spouse') {
                for (let i = index; i < nocSpouse.length; i++) {
                    for (var k in nocSpouse[i]) {
                        if (i == index) {
                            if (k !== 'sdate') {
                                nocSpouse[i][k] = ''
                            }
                        } else {
                            nocSpouse[i][k] = ''
                        }


                    }
                }
            } else {
                for (let i = index; i < nocUser.length; i++) {

                    for (var k in nocUser[i]) {
                        if (i == index) {
                            if (k !== 'sdate') {
                                nocUser[i][k] = ''
                            }
                        } else {
                            nocUser[i][k] = ''
                        }


                    }

                }

            }
        }
        let snc = '',
            unc = ''





        if (s == 'off') {
            if (noc_user == 'spouse') {
                nocSpouse[index] = ''

            } else {
                nocUser[index] = ''

            }
            formFunc('')
            valSave(e)
        } else {


            if (noc_flag == '1') {

                if (date_pos == 'from') {
                    fromDate = $(e).val()
                    let dd = $(e).next().attr('data-def')
                    if (dd == 'Present') {
                        dd = new Date()
                        cemp = 1;

                    } else {
                        dd = $(e).next().val()
                    }

                    toDate = dd
                } else {
                    let dd = $(e).attr('data-def')
                    if (dd == 'Present') {
                        dd = new Date()
                        cemp = 1;

                    } else {
                        dd = $(e).val()
                    }

                    toDate = dd
                    fromDate = $(e).prev('input').val()

                }
                if (date_pos == 'from' && (toDate == '' || toDate == undefined)) {
                    if (noc_user == 'spouse') {
                        if (nocSpouse.hasOwnProperty(index)) {
                            toDate = nocSpouse[index]['edate']

                        }

                    } else {
                        if (nocUser.hasOwnProperty(index)) {
                            toDate = nocUser[index]['edate']

                        }

                    }
                }
                if (date_pos == 'from' && toDate != '' && toDate != undefined) {
                    if (noc_user == 'spouse') {
                        if (nocSpouse.hasOwnProperty(index)) {
                            snc = nocSpouse[index]['noc'];
                            if (fromDate == '' && $(e).next('input').val() !== '') {
                                $(e).blur()
                                let error_msg = '<?php echo $allLabelsArray[81] ?>'//'You cannot remove the date'
                                let error_title = '<?php echo $allLabelsArray[65] ?>'//'Error'

                                // if (localStorage.getItem('Lang') !== 'english') {
                                //     error_msg = static_label_changer(error_msg)
                                //     error_title = static_label_changer(error_title)
                                //
                                // }
                                make_toast('danger', error_title, error_msg)

                                $(e).datepicker("hide");
                                $(e).val(nocSpouse[index]['sdate'])
                                $(e).parent().children('input').prop('disabled', false)
                                $(e).parent().children('select').prop('disabled', false)
                                $(e).parent().children('.presCheck').children('input').prop('disabled', false)
                                return false
                            }

                        }
                    } else {
                        if (nocUser.hasOwnProperty(index)) {
                            unc = nocUser[index]['noc'];
                            if (fromDate == '' && $(e).next('input').val() !== '') {
                                $(e).blur()
                                let error_msg = '<?php echo $allLabelsArray[81] ?>'//'You cannot remove the date'
                                let error_title ='<?php echo $allLabelsArray[65] ?>'// 'Error'

                                // if (localStorage.getItem('Lang') !== 'english') {
                                //     error_msg = static_label_changer(error_msg)
                                //     error_title = static_label_changer(error_title)
                                //
                                // }
                                make_toast('danger', error_title, error_msg)

                                $(e).datepicker("hide");
                                $(e).val(nocUser[index]['sdate'])
                                $(e).parent().children('input').prop('disabled', false)
                                $(e).parent().children('select').prop('disabled', false)
                                $(e).parent().children('.presCheck').children('input').prop('disabled', false)
                                return false
                            }
                        }
                    }

                }
                let exp1 = new Date(new Date(toDate) - new Date(fromDate)).getFullYear() - 1970;
                let exp2 = new Date(new Date(toDate) - new Date(fromDate)).getMonth() / 12;
                let exp = parseFloat(exp1) + parseFloat(exp2.toFixed(1));
                let emp = new Date(new Date() - new Date(toDate)).getFullYear() - 1970;
                if (exp < 0 && $(e).next('input').val() !== '' && fromDate !== '' && $(e).next('input').val() !== undefined && fromDate !== undefined) {
                    $(e).blur()
                    let error_msg = '<?php echo $allLabelsArray[80] ?>'//'Experience cannot be less than 0'
                    let error_title = '<?php echo $allLabelsArray[65] ?>'//'Error'

                    // if (localStorage.getItem('Lang') !== 'english') {
                    //     error_msg = static_label_changer(error_msg)
                    //     error_title = static_label_changer(error_title)
                    // }
                    make_toast('danger', error_title, error_msg)
                    $(e).datepicker("hide");
                    if (date_pos == 'from') {
                        if (noc_user == 'spouse') {
                            $(e).val(nocSpouse[index]['sdate'])
                        } else {
                            $(e).val(nocUser[index]['sdate'])
                        }
                    } else {
                        if (noc_user == 'spouse') {
                            $(e).val(nocSpouse[index]['edate'])
                        } else {
                            $(e).val(nocUser[index]['edate'])
                        }
                    }
                    $(e).parent().children('input').prop('disabled', false)
                    $(e).parent().children('select').prop('disabled', false)
                    $(e).parent().children('.presCheck').children('input').prop('disabled', false)
                    return false
                }
                if (exp < 0 || $(e).prev('input').val() == '' || toDate == '' || toDate == undefined) {

                    $(e).parent().children('input').prop('disabled', false)
                    $(e).parent().children('select').prop('disabled', false)
                    $(e).parent().children('.presCheck').children('input').prop('disabled', false)
                    return false
                }


                if (date_pos == 'to') {
                    if (noc_user == 'spouse')
                        nocSpouse[index] = {
                            'position': noc_pos,
                            'experience': exp,
                            'employment': cemp,
                            'sdate': fromDate,
                            'edate': toDate
                        }
                    else
                        nocUser[index] = {
                            'position': noc_pos,
                            'experience': exp,
                            'employment': cemp,
                            'sdate': fromDate,
                            'edate': toDate
                        }
                } else {
                    if (noc_user == 'spouse') {
                        if (nocSpouse.hasOwnProperty(index)) {
                            nocSpouse[index]['noc'] = snc;
                            nocSpouse[index]['experience'] = exp;
                            nocSpouse[index]['sdate'] = fromDate;
                        }

                    } else {
                        if (nocUser.hasOwnProperty(index)) {
                            nocUser[index]['experience'] = exp;
                            nocUser[index]['sdate'] = fromDate;
                            nocUser[index]['noc'] = unc;
                        }

                    }

                }

            }
        }
        //console.log('user')
        //console.log(nocUser)
        //console.log('spouse')
        //console.log(nocSpouse)

    }

    // calculate the years of experience for every position of work experience, calls on change of position's present check
    function presentBox(e) {
        if ($(e).prop("checked") == false) {
            $(e).parent().parent().parent().parent().children().not(':first-child') //Unselect the first child
                .remove(); //Select all the children of the parent

            return false;
        }
        let dis = $(e).parent().parent().children('input[data-id="to"]')
        let prev = $(dis).prev().val()
        if (prev === '' || prev === null) {
            let error_msg ='<?php echo $allLabelsArray[33] ?>'// 'Please select from date first'
            let error_title = '<?php echo $allLabelsArray[65] ?>'//'Error'

            // if (localStorage.getItem('Lang') !== 'english') {
            //     error_msg = static_label_changer(error_msg)
            //     error_title = static_label_changer(error_title)
            //
            // }
            localStorage.removeItem($(dis).attr('name'))
            localStorage.removeItem($(dis).prev().attr('name'))
            $(dis).parent().children('input').prop('disabled', false)
            $(dis).parent().children('select').prop('disabled', false)
            $(dis).parent().children('.presCheck').children('input').prop('disabled', false)
            make_toast('danger', error_title, error_msg)

            $(e).prop('checked', false);
            return false;
        }
    }

    // if "other" is selected from country, new field gets appended, calls on every country change
    function countryFunc(e) {
        var cval = $(e).val()
        let name = ($(e).attr('name')).split('_')
        let n = ''
        if (name.length == 2) {
            n = name[1].slice(0, name[1].length - 1)

        } else {
            n = name[2].slice(0, name[2].length - 1)

        }
        let dClas = $(e).parent().parent().attr('class')

        if (cval != 'Other') {
            if (dClas == 'parent_' + n || dClas == 'main_parent_' + n) {
                $(e).parent().find('.newCountry').remove()
            } else {
                $(e).parent().parent().find('.newCountry').remove()
            }
        } else {
            let msg = '<?php echo $allLabelsArray[77] ?>'//'Please Describe'
            let name = $(e).attr('name') + '2'
            // if (localStorage.getItem('Lang') != 'english') {
            //     msg = static_label_changer(msg)
            // }
            if (dClas == 'parent_' + n) {
                $(e).parent().append('<em class="newCountry static_label">' + msg + '</em><input name="' + name + '" type="text" class="form-control newCountry" style="margin-top: 2%;">')

            } else {
                $(e).parent().parent().append('<em class="newCountry static_label">' + msg + '</em><input name="' + name + '" type="text" class="form-control newCountry" style="margin-top: 2%;">')

            }
        }
    }

    // dynamically matches two values with provided operator
    function check_cond(var1, op, var2) {

        switch (op) {
            case "=":
                return var1 == var2;
            case "==":
                return var1 == var2;
            case "!=":
                return var1 != var2;
            case ">=":
                return var1 >= var2;
            case "<=":
                return var1 <= var2;
            case ">":
                return var1 > var2;
            case "<":
                return var1 < var2;
            default:
                return true;
        }
    }

    // set the delay for making NOC searchable, calls on every question request's success
    function tagsInp() {
        console.log('tagsInp called')
        if (localStorage.getItem('Lang') == 'english') {
            nocCalling('500');
        } else {
            setTimeout(function() {
                nocCalling('500');
            }, 1000);
        }


    }

    // makes NOC jobs/duties searchable, calls when tagsInp get called
    function nocCalling(delay) {
        $('div.nocJobs , div.nocPos').select2('destroy');

        let placeHolder = '--Select--'
        if (localStorage.getItem('Lang') != 'english') {
            placeHolder = static_label_changer(placeHolder)
        }
        $('.nocJobs').select2({
            data: nocJobs(),
            delay: delay,
            placeholder: placeHolder,
            multiple: false,
            allowClear: true,
            required: true,
            // creating query with pagination functionality.
            query: function(data) {

                var pageSize,
                    dataset,
                    that = this;
                pageSize = 20; // Number of the option loads at a time
                results = [];
                if (data.term && data.term !== '') {
                    // HEADS UP; for the _.filter function I use underscore (actually lo-dash) here
                    results = _.filter(that.data, function(e) {
                        return e.text.toUpperCase().indexOf(data.term.toUpperCase()) >= 0;
                    });
                } else if (data.term === '') {
                    results = that.data;


                }
                data.callback({
                    results: results.slice((data.page - 1) * pageSize, data.page * pageSize),
                    more: results.length >= data.page * pageSize,
                });
            },
        });
        $('.nocPos').select2({
            data: nocPos(),
            placeholder: placeHolder,
            delay: delay,
            multiple: false,
            allowClear: true,

            query: function(data) {
                var pageSize,
                    dataset,
                    that = this;
                pageSize = 20; // Number of the option loads at a time
                results = [];
                if (data.term && data.term !== '') {
                    // HEADS UP; for the _.filter function I use underscore (actually lo-dash) here
                    results = _.filter(that.data, function(e) {
                        return e.text.toUpperCase().indexOf(data.term.toUpperCase()) >= 0;
                    });
                } else if (data.term === '') {
                    results = that.data;
                }
                data.callback({
                    results: results.slice((data.page - 1) * pageSize, data.page * pageSize),
                    more: results.length >= data.page * pageSize,
                });
            },

        });

        setTimeout(function() {
            $('input.nocJobs').each(function() {
                let val2 = $('div.nocJobs').children().children().html()
                let nocJob = $(this).val()
                let val = $(this).attr('name')
                if (nocJob != '' && nocJob != null) {
                    let val1 = val.split('_')
                    let id = val1[2].slice(0, -1)
                    $("#sub_question_div_" + id + " .select2-chosen").html(nocJob)
                    $(this).prev('div').children('a').children('span.select2-chosen').html(nocJob)

                }

            })
            $('input.nocPos').each(function() {
                let val2 = $('div.nocPos').children().children().html()
                let nocJob = $(this).val()
                let val = $(this).attr('name')
                if (nocJob !== '' && nocJob !== null) {
                    let val1 = val.split('_')
                    let id = val1[2].slice(0, -1)
                    $("#sub_question_div_" + id + " .select2-chosen").html(nocJob)
                    $(this).prev('div').children('a').children('span.select2-chosen').html(nocJob)

                }


            })

            $(".errorReq").each(function() {
                if (!$(this).hasClass('topError')) {
                    $(this).addClass('topError');
                }
            });

        }, delay)
        if (localStorage.getItem('display') == 'Right to Left') {

            setTimeout(function() {
                $('.select2-results').addClass('rightAlign')
                $('.select2-container .select2-choice>.select2-chosen').css('direction', 'rtl')
            }, delay)
        }
    }

    // makes education dropdown searchable, calls on every question request's success
    function education_searchable() {
        $('.education').each(function(index) {
            let req = $(this).attr('required')
            let val = $(this).val()
            let txt = $(this).find(":selected").text()

            if ($(this).prev('div').hasClass("select2-container")) {} else {
                if ($(this).is("select")) {
                    $(this).select2()
                    $(this).prev('div').children('a').children('span.select2-chosen').html(txt)
                }

            }
        });
    }

    // checks date on submission according to te client's format
    function checkDate(e) {
        let dt = $(e).attr('data-id')
        let value = $(e).val()
        let selected_date=new Date(value)
        let current_date = new Date();
        if ($(e).next('label.error').length > 0) {
            $(e).next('label.error').remove()
        }
        let compare=selected_date > current_date
        if(compare)
        {
            let error_msg ='<?php echo $allLabelsArray[47] ?>' //Invalid date
            let error_title ='<?php echo $allLabelsArray[65] ?>'// 'Error'

            make_toast('danger', error_title, error_msg)
            $(e).parent().children('input').prop('disabled', false)
            $(e).parent().children('select').prop('disabled', false)
            $(e).parent().children('.presCheck').children('input').prop('disabled', false)
            $(e).parent().parent().parent()
                .children() //Select all the children of the parent
                .not(':first-child') //Unselect the first child
                .remove();
            $(e).val('')
            valSave(e)
            formFunc('')
            return false
        }
        if (dt == 'to') {
            let from_date = new Date($(e).prev('input[type="text"]').val());
            let to_date = new Date($(e).val());
            if (to_date < from_date) {

                let error_msg = '<?php echo $allLabelsArray[66] ?>'//'This date is smaller than previous.'
                let error_title ='<?php echo $allLabelsArray[65] ?>'// 'Error'

                // if (localStorage.getItem('Lang') !== 'english') {
                //     error_msg = static_label_changer(error_msg)
                //     error_title = static_label_changer(error_title)
                //
                // }
                make_toast('danger', error_title, error_msg)
                $(e).parent().children('input').prop('disabled', false)
                $(e).parent().children('select').prop('disabled', false)
                $(e).parent().children('.presCheck').children('input').prop('disabled', false)
                $(e).parent().parent().parent()
                    .children() //Select all the children of the parent
                    .not(':first-child') //Unselect the first child
                    .remove();
                $(e).val('')
                valSave(e)
                formFunc('')
                return false

            } else if (from_date == 'Invalid Date') {
                let error_msg = '<?php echo $allLabelsArray[33] ?>'//'Please select from date first'
                let error_title = '<?php echo $allLabelsArray[65] ?>'//'Error'

                // if (localStorage.getItem('Lang') !== 'english') {
                //     error_msg = static_label_changer(error_msg)
                //     error_title = static_label_changer(error_title)
                //
                // }
                localStorage.removeItem($(e).attr('name'))
                localStorage.removeItem($(e).prev().attr('name'))
                $(e).parent().children('input').prop('disabled', false)
                $(e).parent().children('select').prop('disabled', false)
                $(e).parent().children('.presCheck').children('input').prop('disabled', false)
                make_toast('danger', error_title, error_msg)

                $(e).parent().parent().parent()
                    .children() //Select all the children of the parent
                    .not(':first-child') //Unselect the first child
                    .remove();
                $(e).val('')
                valSave(e)
                formFunc('')
                return false
            } else if ($(e).val() == '' || $(e).parent().next('label.error').length > 0) {
                $(e).parent().parent().parent()
                    .children() //Select all the children of the parent
                    .not(':first-child') //Unselect the first child
                    .remove();
                formFunc('')
                valSave(e)

                return false
            } else {
                return true
            }

        }
        else if (dt == 'from') {
            let from_date = new Date($(e).val());
            let to_date = new Date($(e).next('input[type="text"]').val());
            if (from_date > to_date) {
                let error_msg = 'This date is greater than next.'
                let error_title = '<?php echo $allLabelsArray[65] ?>'//'Error'

                if (localStorage.getItem('Lang') !== 'english') {
                    error_msg = static_label_changer(error_msg)
                    error_title = static_label_changer(error_title)

                }
                make_toast('danger', error_title, error_msg)
                $(e).parent().children('input').prop('disabled', false)
                $(e).parent().children('select').prop('disabled', false)
                $(e).parent().children('.presCheck').children('input').prop('disabled', false)
                $(e).val('')
                valSave(e)
                formFunc('')
                return false

            } else {
                return true
            }
        }

    }

    // checks on submission if any error exists
    function error_check() {

        let target = ''
        if ($('label.error').length > 0) {

            $("label.error").each(function() {
                if ($(this).css('display') == 'block') {

                    target = $(this)
                    return false;
                }
            });
            if (target !== '' && target !== null) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 200
                }, 2000);
                let error_msg = '<?php echo $allLabelsArray[64] ?>'//'Something important is missing, please fill all the fields and submit again.'
                let error_title = '<?php echo $allLabelsArray[65] ?>'//'Error'

                // if (localStorage.getItem('Lang') !== 'english') {
                //     error_msg = static_label_changer(error_msg)
                //     error_title = static_label_changer(error_title)
                //
                // }
                make_toast('danger', error_title, error_msg)

                return false

            }
        }
    }

    // custom validation check for date of birth
    function custom_validation() {
        let no_error = true
        $(".age").each(function() {
            if (date_check($(this), 0) == false) {
                $('html, body').animate({
                    scrollTop: $(this).offset().top - 200
                }, 2000);
                $(this).css('pointer-events', 'all')

                let error_msg = 'You have entered an invalid date. Please update and submit again.'
                let error_title ='<?php echo $allLabelsArray[65] ?>'// 'Error'

                if (localStorage.getItem('Lang') !== 'english') {
                    error_msg = static_label_changer(error_msg)
                    error_title = static_label_changer(error_title)

                }
                make_toast('danger', error_title, error_msg)
                no_error = false
            }
        });

        if (no_error)
            return true
        else
            return false

    }

    // checks date on submission according to te client's format
    function date_check(e, flag) {
        let dateVal = $(e).val()
        let date_year = new Date(dateVal)
        let attr = $(this).attr('required');
        date_year = date_year.getFullYear()
        dateVal = dateVal.split('-')
        let sDate = dateVal[0] + "/" + dateVal[1] + "/" + dateVal[1]
        let enteredDate = sDate
        let check_years = new Date(new Date() - new Date(enteredDate)).getFullYear() - 1970;

        if ((typeof attr !== undefined && attr !== false && attr !== 'undefined' && attr !== undefined) || flag == 1) {

            if (check_years > 121 || dateVal[0] != date_year) {

                if ($(e).parent().parent().children('label.error').length <= 0 && $(e).val() !== '' && $(e).next('label.error').length <= 0) {
                    let error_msg ='<?php echo $allLabelsArray[47] ?>'// 'Invalid date'
                    // if (localStorage.getItem('Lang') !== 'english') {
                    //     error_msg = static_label_changer(error_msg)
                    // }
                    let a = '<label class="error">' + error_msg + '</label>'
                    $(e).parent().parent().append('<label class="error">' + error_msg + '</label>');
                }

                return false
            } else {
                $(e).parent().parent().children('label.error').remove()
            }
        }

    }

    // changes the static labels on run time
    function static_label_changer(label) {
        let index = labelsArray.indexOf(label)
        if (index > -1) {
            if (labelsTransArray[index] !== '') {
                label = labelsTransArray[index]
            }
        }
        return label
    }

    // shows the progress bar and changes the text according the submission type, calls on submission
    function progressBar(state) {
        let loader_msg = '';
        if (state == 0) {
            $('.meter').hide();
            return false;
        } else if (state == 1) {
            loader_msg = '<?php echo $allLabelsArray[42] ?>'//'Calculating Score';
        } else if (state == 2) {
            loader_msg = '';
        } else if (state == 3) {
            loader_msg = '<?php echo $allLabelsArray[226] ?>'//'Please answer the question.';
        }

        // if (localStorage.getItem('Lang') !== 'english') {
        //     loader_msg = static_label_changer(loader_msg)
        // }
        $('.progress_bar_label').children().html(loader_msg);
        $('.meter').show()
        if(state == 2)
        {
            $('.meter').hide()
        }
    }

    // removes the values of questions from local storage which are removed from form on change of any question, calls on change of every form field
    function removeLocalStorageValues() {
        console.log('Local Storage values remove function called')
        for (var key in localStorage) {
            if (key !== 'guest_in_process' && key !== 'guest_logged' && key !== 'process_form_id' && key !== 'process_draft_id' && key !== 'form_2_in_process' && key !== 'form_in_process' && key !== 'Lang' && key !== 'display' && key !== 'nocSpouse' && key !== 'nocUser' && key !== 'userGrades' && key !== 'spouseGrades' && key !== 'AgreeCheck' && key !== 'EndCase' && key !== 'Submission' && key !== 'Submission') {
                if (key[0] == 'n') {

                    let element = document.getElementsByName(key)
                    if (element.length > 0) {

                        if (element[0].nodeName.toLowerCase() === 'select') {
                            ///console.log('select')
                        }
                        if (element[0].nodeName.toLowerCase() === 'input') {
                            if ($(element).attr('type') == 'radio') {
                                let y = $(element).eq(0).prop('checked')
                                let n = $(element).eq(1).prop('checked')

                                //     if(y==true)
                                //     {
                                //         localStorage.setItem(key,'Yes')
                                //     }
                                // else if(n==true)
                                //     {
                                //         localStorage.setItem(key,'No')
                                //     }
                                // else
                                //     {
                                //         localStorage.removeItem(key)
                                //     }

                            } else {

                            }
                        }
                    } else {
                        let key2 = ''
                        if (key.includes('from')) {
                            key2 = key.replace(" from", "");
                            let element = document.getElementsByName(key2)
                            if (element.length > 0) {
                                continue
                            } else {
                                localStorage.removeItem(key)
                                localStorage.removeItem(key2)
                            }
                        } else {
                            localStorage.removeItem(key)

                        }

                    }

                }
            }
        }
    }

    // saves the values of every individual question in local storage, calls on every element change
    function valSave(e) {
        console.log("val save call")
        drafted = false;


        let dt = $(e).attr('data-id')
        let ex = ''
        if (dt == 'from') {
            ex = ' from'
        }
        let val = $(e).val();
        let id = $(e).attr('name')

        if($(e).val()!=='' && $(e).val()!==null)
        {
            //console.log(localStorage.getItem(id + ex)+'--'+val)
            //if(localStorage.getItem(id + ex) != val)
            {
                console.log('if value-'+$(e).val())
                localStorage.setItem('drafted','false')
                onDraftStatusChanged(e);
            }
            // else
            // {
            //     console.log('In ValSave drafted else')
            // }

        }
        else
        {
            console.log('else value-'+$(e).val())
            checkDraftButton()
        }



        localStorage.setItem(id + ex, val);




        //$('#btnLoader').hide()

        // showButton(e)
        if(drafted_on_load)
        {
            //localStorage.setItem('EndCase', '');
        }
        emailCount = false

        if (nocUser.length > 0)
            localStorage.setItem('nocUser', JSON.stringify(nocUser))
        if (nocSpouse.length > 0)
            localStorage.setItem('nocSpouse', JSON.stringify(nocSpouse))

        setTimeout(function() {
            education_searchable();
        }, 500)
    }

    // saves the form's html in local storage, calls on every element change
    function formFunc(e) {
        time=60;
        question_changed++;
        if(question_changed > 3)
        {
            time=60;
            question_changed=0;
            saveForm();
        }

        console.log("form func call");

        genFormHtml();


        let form_id = <?php echo $formID; ?>;
        let v = $('.myForm').html()

        try {
            localStorage.setItem('form_' + form_id, v);

        } catch (e) {
            Storage.prototype._setItem = Storage.prototype.setItem;
            Storage.prototype.setItem = function() {};
        }

        changeStaticLabels();
        country_optional();
        // button check
        showButton(e);

    }

    // if country drop down field is optional, set "optional" placeholder, calls on every element change
    function country_optional() {
        $('.countryCheck').each(function(index) {
            let req = $(this).attr('required')
            let val = $(this).val()
            let txt = $(this).find(":selected").text()
            if (req === undefined) {
                if (val === null || val === '') {
                    let msg = '<?php echo $allLabelsArray[79] ?>'//'--optional--'
                    // if (localStorage.getItem('Lang') !== 'english') {
                    //     msg = static_label_changer(msg)
                    // }
                    $(this).find(":selected").text(msg)
                    $(this).find(":selected").attr('data-org', '<?php echo $allLabelsEnglishArray[79] ?>')
                }
            }
        });
    }

    // decided when to show button, calls on every element change
    function buttonCheck(e) {

        let last_div_display=$('.form-group').last().parent().css('display')
        let no_of_divs=$('.form-group').length-1

        if(last_div_display=='none')
        {
            no_of_divs=no_of_divs-1
        }
        let last_div = $('.form-group').parent('div').eq(no_of_divs).attr('class')
        let lDiv = $('.form-group').parent('div').eq(no_of_divs).html()
        let last_parent_div = $('.form-group').eq(no_of_divs).parent().attr('class')
        let last_div_input_name = $('.form-group').eq(no_of_divs).children().children().attr('name')


        let current_div = $(e).parent().parent().parent().attr('class')
        let last_multi_element=($(e).parents('.afterSub')).length


        let last_div_input_check = $('input[name="' + last_div_input_name + '"')
        last_div_input_check = $(last_div_input_check).attr('type')
        let last_div_input1 = false;
        let last_div_input2 = false;

        if (last_div_input_check == 'radio') {
            last_div_input1 = document.getElementsByName(last_div_input_name)[0].checked
            last_div_input2 = document.getElementsByName(last_div_input_name)[1].checked
        }
        console.log('last input name--'+last_div_input_name)
        console.log('displaying last divs value=>'+last_div_input1+'-'+last_div_input2)
        let is_submitted = localStorage.getItem('Submission');

        if (!endCase) {

            if ((current_div === last_div || (lDiv == '' || lDiv == null) || current_div == 'main_parent_117' || current_div == 'unChecked main_parent_117')) {

                if (current_div !== 'parent_724' && current_div !== 'multi parent_11591'  && current_div!=='parent_11582' && current_div!=='multi parent_12818') {

                    if (!last_div.includes('afterSub') && last_multi_element <= 0) {
                        console.log('near to show 4')
                        if (last_div_input1 || last_div_input2)
                        {
                            btnCheck = true
                            isShown = true;
                            $("#btnLoader").show()
                            console.log("show 4")
                        }

                    }
                }
            } else {
                if (last_div_input_check == 'radio') {
                    if (last_div_input1 || last_div_input2) {
                        if (!last_parent_div.includes('afterSub')) {
                            console.log('b-' + is_submitted + '-' + local_storage_form)

                            if (is_submitted == 'false' || local_storage_form) {
                                if ($('.scroll-edit').css('display') == 'none'  && last_multi_element <= 0) {
                                    $("#btnLoader").show()
                                    console.log("show 5")

                                }
                            }
                        }
                    }
                }

                if (!isShown) {

                    btnCheck = false
                    $('#btnLoader').hide()
                    console.log("hide 1")
                    console.log('a-' + is_submitted + '-' + local_storage_form)
                    console.log(last_div_input_check)
                    if (last_div_input_check == 'radio') {
                        if (last_div_input1 || last_div_input2) {
                            if (!last_parent_div.includes('afterSub')) {
                                if (is_submitted == 'false' || local_storage_form) {
                                    if ($('.scroll-edit').css('display') == 'none') {
                                        $("#btnLoader").show()
                                        console.log("show 6")

                                    }
                                }
                            }
                        }
                    }
                }


            }
        }

    }
    function showButton(e)
    {
        console.log('show Button called')

        let btn_show=false
        let no_of_divs=0;
        $('.form-group').each(function () {
            if($(this).css('display')!='none')
            {
                no_of_divs++
            }
        })
        no_of_divs=no_of_divs-1
        let last_div_display=$('.form-group').eq(no_of_divs).parent().css('display')
        let last_div_display2=$('.input-group').eq(no_of_divs).parent().parent().css('display')

        console.log(no_of_divs)
        console.log("'"+last_div_display+"'")
        console.log("'"+last_div_display2+"'")

        if(last_div_display=='none' || last_div_display2=='none')
        {
            no_of_divs=no_of_divs-1
            console.log('im sub')
        }

        let last_multi_element=($(e).parents('.afterSub')).length

        let last_element1=$('.input-group').eq(no_of_divs).children('input')
        let last_element2=$('.input-group').eq(no_of_divs).children('select')

        let last_element_name=$(last_element1).attr('name')
        let last_multi_element1=($(last_element1).parents('.afterSub')).length
        let last_multi_element2=($(last_element2).parents('.afterSub')).length

        let endcase_btn=localStorage.getItem('EndCase')

        console.log('any parent of after Sub-'+last_multi_element1+'-'+last_multi_element2);
        console.log('after sub--'+last_multi_element)
        console.log(last_element1)
        console.log(last_element2)
        console.log('last input attr-'+$(last_element1).attr('type'))
        if($(last_element1).attr('type')=='radio')
        {
            let ans1 = document.getElementsByName(last_element_name)[0].checked
            let ans2=document.getElementsByName(last_element_name)[1].checked
            console.log('ans1-'+ans1+'-ans2-'+ans2+'-multi-'+last_multi_element+'-endcase-'+endCase)
            if(ans1==true || ans2==true)
            {
                if (last_multi_element <= 0)
                {
                    if(!endCase && endcase_btn!='matched')
                    {
                        btn_show=true
                    }
                }
            }
            else
            {
                btn_show=false
            }

        }

        else {
            if($(last_element2).is("select"))
            {
                let ans=$(last_element2).children('option:eq(0)').prop('selected')
                console.log('ans-'+ans+'-multi-'+last_multi_element+'-endcase-'+endCase)

                if(ans)
                {
                    btn_show=false
                }
                else
                {
                    if (last_multi_element <= 0)
                    {
                        if(!endCase && endcase_btn!='matched')
                        {
                            btn_show=true
                        }
                    }
                }

            }
            else if($(last_element1).is("input"))
            {
                let ans=$(last_element1).val()
                console.log('ans-'+ans+'-multi-'+last_multi_element+'-endcase-'+endCase)

                if(ans!=='' && ans!==null)
                {
                    if (last_multi_element <= 0)
                    {
                        if(!endCase && endcase_btn!='matched')
                        {
                            btn_show=true
                        }
                    }
                }
                else
                {
                    btn_show=false
                }
            }
        }
        if(localStorage.getItem('Submission')=='true')
        {
            btn_show=false
        }
        if(btn_show)
        {
            $('#btnLoader').show()
        }
        else
        {
            $('#btnLoader').hide()
        }

    }
    function getTranslations()
    {
        let error_msg = 'Form translation is under process<?php //echo $allLabelsArray[214] ?>'
        let error_title = ''
        $.toaster({
            priority: "success",
            title: error_title,
            message: error_msg,
            settings: {
                timeout: 600000
            },
        });
        $.ajax({
            dataType: 'json',
            url: "<?php echo $currentTheme.$incFolderName?>/lang.php?h=getTranslationArr<?php echo $langParam;?>",
            type: 'POST',
            success: function (data) {
                is_session(data)

                quesArr = data.questArr;
                notesArr = data.notesArr;
                ArrCountry = data.ArrCountry;
                ArrEducation = data.ArrEducation;

                optionsArr = data.optionsArr;
                valuesArr = data.valuesArr;
                oldValues = data.oldValues;


                setTimeout(function () {
                    callTranslations();
                }, 2000);

            }
            ,
            error: function (data) {
                console.log(data)

            }
        });

    }
    // translates the whole form, calls on language change
    function callTranslations() {
        console.log('Translation function called')
        // Change Values of Questions
        var elements = document.getElementsByTagName("label");
        for (var i = 0; i < elements.length; i++) {
            var valueLabel = '';
            var valueLabel2 = '';

            if (elements[i].getAttribute('data-org') == "" || elements[i].getAttribute('data-org') == null) {} else {

                if (localStorage.getItem('Lang') == 'english') {
                    // valueLabel = (elements[i].innerHTML).trim();
                    valueLabel = (elements[i].getAttribute('data-org')).trim();
                    valueLabel2 = (elements[i].getAttribute('data-org'));

                    elements[i].innerHTML = valueLabel
                } else if (localStorage.getItem('Lang') !== 'english') {
                    // valueLabel = (elements[i].innerHTML).trim();
                    valueLabel = (elements[i].getAttribute('data-org')).trim();
                    valueLabel2 = (elements[i].getAttribute('data-org'));

                    for (var loop = 0; loop < quesArr.length; loop++) {
                        if (quesArr[loop].label == valueLabel || quesArr[loop].label == valueLabel2) {
                            if (quesArr[loop].label_translation !== '') {
                                elements[i].innerHTML = quesArr[loop].label_translation;
                            }
                            break;
                        }

                    }
                }
            }
        }

        // Change values of Notes
        $("form#validateform p.notesPara").each(function() {
            // var spanLabel = ($(this).text()).trim();
            var spanLabel = ($(this).attr('data-org')).trim();

            if (spanLabel == "") {} else {
                if (localStorage.getItem('Lang') == 'english') {
                    $(this).html(spanLabel);

                } else if (localStorage.getItem('Lang') !== 'english') {
                    for (var loop = 0; loop < notesArr.length; loop++) {
                        if (notesArr[loop].notes == spanLabel) {
                            if (notesArr[loop].notes_translation !== '') {
                                $(this).html(notesArr[loop].notes_translation);
                            }
                            break;
                        }
                    }
                }
            }
        });

        // Custom Labels
        $("form#validateform span.customLabel").each(function() {
            // var spanLabel = ($(this).text()).trim();
            var spanLabel = ($(this).attr('data-org')).trim();

            if (spanLabel == "") {} else {
                if (localStorage.getItem('Lang') == 'english') {
                    $(this).html(spanLabel);
                } else if (localStorage.getItem('Lang') !== 'english') {
                    var string = $(this).attr('data-org');
                    var index = optionsArr.indexOf(string.trim());

                    if ((valuesArr[index] !== '' && index > -1)) {
                        $(this).html(valuesArr[index]);
                    }
                }

            }
        });


        //Change Values of Dropdown Options
        var selectCount = 0;
        $("form#validateform select").each(function() {
            var selectValue = $(this).val();
            if ($(this).hasClass("countryCheck")) {
                $(this).find('option:not(:first)').remove();
                var country = '';
                for (var j = 0; j < ArrCountry.length; j++) {
                    if (ArrCountry[j].value !== '' && ArrCountry[j].value !== null) {
                        country += '<option value="' + ArrCountry[j].value + '">' + ArrCountry[j].name + '</option>';
                    }
                }
                $(this).append(country);
                $(this).val(selectValue);

                selectCount++;
            } else if ($(this).hasClass("education")) {
                $(this).find('option:not(:first)').remove();
                var country = '';
                for (var j = 0; j < ArrEducation.length; j++) {
                    country += '<option value="' + ArrEducation[j].value + '">' + ArrEducation[j].name + '</option>';
                }
                $(this).append(country);
                $(this).val(selectValue);
                let getAttr = $(this).attr('name');
                $("input[name='" + getAttr + "']").val(selectValue);
                $(this).prev('div').children('a').children('span.select2-chosen').html(selectValue)
                selectCount++;
            } else {
                $("select option").each(function() {
                    if (!$(this).parent().hasClass("countryCheck") && !$(this).parent().hasClass("education") && $(this).parent().attr('name') !== 'language-picker-select') {
                        var spanLabel = '';
                        if ($(this).attr('data-id')) {
                            spanLabel = ($(this).attr('data-id')).trim();
                        }
                        var spanLabel2 = $(this).text();

                        if (spanLabel == "") {} else {
                            if (localStorage.getItem('Lang') == 'english') {
                                if (spanLabel2 == '--Select--') {

                                } else {
                                    $(this).text($(this).attr('data-id'));
                                }

                            } else if (localStorage.getItem('Lang') !== 'english') {
                                var index = optionsArr.indexOf(spanLabel);
                                //console.log('Index of '+string+' : '+index);
                                if (valuesArr[index] !== '' && index > -1) {
                                    $(this).text(valuesArr[index]);
                                } else {
                                    if (spanLabel2 == '--optional--' || spanLabel2 == '--Select--' || spanLabel2 == '') {
                                        let sp = static_label_changer(spanLabel2)
                                        $(this).text(sp);
                                    } else {
                                        $(this).text($(this).attr('data-id'));
                                    }
                                }
                            }
                        }
                    }
                });
            }

        });


        if (localStorage.getItem('display') == 'Right to Left') {
            $("form#validateform input[type='radio']").each(function() {
                $(this).parent().addClass('urduField');
            });
        } else {
            $("form#validateform input[type='radio']").each(function() {
                $(this).parent().removeClass('urduField');
            });
        }

        setTimeout(function() {
            if ($('#toaster').children().length > 0) {
                $('#toaster').children().remove()
            }
            $('body').css('cursor', 'auto')
            $('form').css('pointer-events', 'all')
            let form_id = <?php echo $formID; ?>;
            let v = $('.myForm').html()
            localStorage.setItem('form_' + form_id, v);
        }, 1000)
    }

    // sets the direction of form's fields
    function callLabelDir() {
        if (localStorage.getItem('display') == 'Right to Left') {
            $("form#validateform select").each(function() {
                $("form#validateform select").attr('dir', 'rtl');
            });
        } else {
            $("form#validateform select").each(function() {
                $("form#validateform select").removeAttr('dir', 'rtl');
            });
        }


        if (localStorage.getItem('display') == 'Right to Left') {
            $("form#validateform input[type='radio']").each(function() {
                $(this).parent().addClass('urduField');
            });
        } else {
            $("form#validateform input[type='radio']").each(function() {
                $(this).parent().removeClass('urduField');
            });
        }
    }

    // sets limit/range of noc Jobs in loading data
    function nocJobs() {
        return _.map(_.range(0, jobLen), function(i) {
            return {
                id: i,
                text: jobsArr[i],
            };
        });
    }

    // sets limit/range of noc Duties in loading data
    function nocPos() {
        return _.map(_.range(0, dutyLen), function(i) {
            return {
                id: i,
                text: dutyArr[i],
            };
        });
    }


    // returns the whole local storage in shape of an array
    function allStorage() {

        var values = [],
            keys = Object.keys(localStorage),
            i = keys.length;

        while (i--) {
            item = {}
            // console.log(keys[i])
            item[keys[i] + ''] = localStorage.getItem(keys[i]);
            values.push(item);
        }

        return values;
    }


    function getCookie(name) {
        var dc = document.cookie;
        var prefix = name + "=";
        var begin = dc.indexOf("; " + prefix);
        if (begin == -1) {
            begin = dc.indexOf(prefix);
            if (begin != 0) return null;
        } else {
            begin += 2;
            var end = document.cookie.indexOf(";", begin);
            if (end == -1) {
                end = dc.length;
            }
        }
        // because unescape has been deprecated, replaced with decodeURI
        //return unescape(dc.substring(begin + prefix.length, end));
        return decodeURI(dc.substring(begin + prefix.length, end));
    }

    function check_endCase() {
        let error_msg = ''
        if (localStorage.getItem('EndCase') != '') {
            error_msg = '<?php echo $allLabelsArray[62] ?>'//'Are you sure you want to edit?'
        } else {
            error_msg = '<?php echo $allLabelsArray[36] ?>'//'Are you sure you want to edit ? Once you edit, scoring will re-initiate'

        }

        // if (localStorage.getItem('Lang') !== 'english') {
        //     error_msg = static_label_changer(error_msg)
        // }
        $('#editLabel').html(error_msg)
    }

    //-------makes the last input uncheck or remove value because of error---------
    function unsetInput()
    {

        console.log('unsetting input')
        let last_element1=$('.input-group').last().children('input')
        let last_element2=$('.input-group').last().children('select')

        let last_element_name=$(last_element1).attr('name')
        let last_multi_element1=($(last_element1).parents('.afterSub')).length
        let last_multi_element2=($(last_element2).parents('.afterSub')).length

        console.log('any parent of after Sub-'+last_multi_element1+'-'+last_multi_element2);
        if($(last_element1).attr('type')=='radio')
        {
            let ans1 = document.getElementsByName(last_element_name)[0].checked
            let ans2=document.getElementsByName(last_element_name)[1].checked

            if(ans1==true || ans2==true)
            {
                $('#btnLoader').show()
            }
            if(last_multi_element1 > 0 || last_multi_element2 > 0)
            {

                document.getElementsByName(last_element_name)[0].checked=false
                document.getElementsByName(last_element_name)[1].checked=false
            }

        }
        else if($(last_element2).is("select"))
        {
            $(last_element2).val('')
            $(last_element2).children('option:selected').prop('selected',false)
            $(last_element2).children('option:eq(0)').prop('selected',true)
        }
        else {
            let ans=$(last_element1).val()
            if(ans!=='' && ans!==null)
            {
                $('#btnLoader').show()
            }
            if(last_multi_element1 > 0)
            {
                $(last_element1).val('')
            }
            // document.getElementsByName(last_element_name).value=''
        }
        //$('#btnLoader').hide()
    }

    // this function is to hide or show save as draft button when draft status changed
    function onDraftStatusChanged(e)
    {
        console.log("onDraftStatusChanged call")

        let class_check=($(e).parents('.afterSub').length)

        if(drafted && localStorage.getItem('drafted')=='true')
        {
            $(".float-div").hide("slow");
        }
        else
        {
            // alert(class_check)
            if(class_check<=0)
            {
                if(screen.width > 766)
                {
                    // big button show
                    $(".float-div").each(function (){
                        if(!$(this)[0].hasAttribute("id"))
                        {
                            // $(this).show("slow");
                        }
                        else
                        {
                            $(this).hide();
                        }

                    });
                }
                else
                {
                    // small button show
                    $(".float-div").each(function (){
                        if($(this)[0].hasAttribute("id"))
                        {
                            // $(this).show("slow");
                        }
                        else
                        {
                            $(this).hide();
                        }

                    });
                }
            }
        }

        console.log('csss--'+$('.scroll-edit').css('display'))
        if ($('.scroll-edit').css('display') == 'block' || localStorage.getItem('drafted') == 'true') {
            $(".float-div").hide("slow");
            console.log("draft button hide")
        }
    }

    function checkDraftButton()
    {
        console.log('check draft called')
        let totalCount=0;
        let falseCount=0;
        $(".myForm input").each(function() {
            if($(this).attr('type') !=='checkbox' && $(this).css('display')!=='none')
            {
                totalCount++
                if($(this).attr('radio'))
                {
                    let ans1=$(this).eq(0).prop('checked')
                    let ans2=$(this).eq(1).prop('checked')
                    if(!ans1 && !ans2)
                    {
                        falseCount++;
                    }
                }
                else if($(this).is('input'))
                {
                    let ans=$(this).val()
                    if (ans == "" || ans==null) {
                        falseCount++;
                    }
                }
            }
        });
        $(".myForm select").each(function() {
            if($(this).css('display')!=='none')
            {
                totalCount++
                let ans=$(this).children('option:eq(0)').prop('selected')
                if (ans) {
                    falseCount++;
                }
            }
        });
        console.log('total fields-'+totalCount)
        console.log('false fields-'+falseCount)

        if(falseCount==totalCount)
        {
            // localStorage.setItem('drafted','true')
            console.log("drafted called => 1 env")
            drafted=true
        }
        else
        {


            // if(drafted_on_load)
            // {
            //     localStorage.setItem('drafted','false')
            //     drafted=false
            // }

        }
        console.log('drafted-'+drafted+'--'+drafted_on_load)
        onDraftStatusChanged();
    }
    function langChangeYes()
    {
        confirmChanged = true
        modal_is_open = false;

        localStorage.setItem('url', url)
        localStorage.setItem('old_url', local_url)
        local_old_url = local_url
        loaded = true
        for (var key in localStorage) {
            if (key == 'guest_in_process' || key == 'guest_logged' || key == 'drafted' || key == 'process_form_id' || key == 'process_draft_id' || key == 'form_2_in_process' || key == 'form_in_process' || key == 'Lang' || key == 'url' || key == 'old_url'  || key == 'display') {
                continue
            } else {
                localStorage.removeItem(key)
            }
        }


        $(".myForm").empty();
        <?php $defaultHTMLJs =   addslashes($defaultHTML);//str_replace("'", "\'", $defaultHTML); ?>
        $(".myForm").append('<?php echo $defaultHTMLJs; ?>');
        $("#languageChangeModal").modal("hide");
        changeStaticLabels()
    }

    function editFormFunction()
    {
        $('.permitted').children('input').css('pointer-events', 'auto')
        $('.permitted').attr('title', 'This question is permitted')
        $('.permitted').children('select').css('pointer-events', 'auto')
        $('.permitted').children('div.presCheck').children('input').css('pointer-events', 'auto')

        localStorage.setItem('EndCase','')

        if (localStorage.getItem('EndCase') !== 'matched') {

            // if($('#iAgree').length > 0)
            // {
            //
            // }
            // else
            {
                $("#btnLoader").show()
                console.log("show 2")
                $('#lastBox').show()
            }

        }
        let msg = '<?php echo $allLabelsArray[45] ?>'//'Re-Submit'

        $('#btnLoader').html(msg)
        $("#btnLoader").attr("data-org",'<?php echo $allLabelsEnglishArray[45] ?>')


        $('.afterSub').remove()
        $('#scoreID').val('')

        $('.btnModal').click()
        $('.scroll-edit').hide()
        $('.email').parent('div').remove()

        progressBar(0)


        submission = false
        localStorage.setItem('Submission', 'false')
        localStorage.setItem('subBtnTxt',"Re-Submit");

        isShown = false
        userGrades = []
        spouseGrades = []
    }
    function checkMainEmptyFields()
    {
        console.log("empty fields func called")
        // this function return true if all  main fields before agree check checkbox are empty

        if($('input[name="n[question_28]"]').val() != "")
        {
            return false;
        }
        if($('input[name="n[question_29]"]').val() != "")
        {
            return false;
        }
        if($('input[name="n[question_30]"]').val() != "")
        {
            return false;
        }
        if($('input[name="n[question_31]"]').val() != "")
        {
            return false;
        }
        if($('input[name="n[question_32]"]').val() != "")
        {
            return false;
        }
        if($('select[name="n[question_43]"]').val() != "")
        {
            return false;
        }
        if($('select[name="n[question_45]"]').val() != "")
        {
            return false;
        }

        return true;

    }
    function removeExtraText(e) {
        var initVal = $(e).val();
        let outputVal=''

        let label = $(e).parent().parent().children('label').attr('data-org');
        if(label!==undefined)
        {
            if (label.includes('address') || label.includes('Address') || label.includes('Please describe')) {
                return true;
            }
        }


        if ($(e).hasClass('datepicker')) {
            outputVal = initVal.replace(/[^0-9-]/g, "");
        }
        else
        {
            outputVal = initVal.replace(/[^a-zA-Z '\-]/g, "");
        }
        if (initVal != outputVal) {
            $(e).val(outputVal);
        }
    }
    function removeExtraTel(e) {
        var initVal = $(e).val();
        let outputVal=''

        outputVal = initVal.replace(/[^+0-9]/g, "");
        if (initVal != outputVal) {
            $(e).val(outputVal);
        }
    }
    function removeExtraNumber(e) {
        var initVal = $(e).val();
        let outputVal=''

        outputVal = initVal.replace(/[^0-9]/g, "");

        if (initVal != outputVal) {
            $(e).val(outputVal);
        }
    }

    setInterval(function(){
        time--;
        if(time==0)
        {
            //time=60;
            saveForm();
        }
    }, 1000);

    function saveForm() {

        if(sess_id != "")
        {
                //
                $("#saveAsDraft").click();
        }
        else
        {
            let email = $('input[type="email"]:first').val()

            $("input,select,textarea").each(function() {

                if ($(this).is("[type='checkbox']") || $(this).is("[type='radio']")) {
                    $(this).attr("checked", $(this).is(":checked"));
                } else if ($(this).prop("tagName") == "SELECT") {
                    $(this).find('option[value="' + $(this).val() + '"]').attr('selected', true);
                } else {
                    $(this).attr("value", $(this).val());
                }
            });
            setTimeout(function() {
                $.ajax({
                    dataType: 'json',
                    url: "<?php echo $currentTheme.$ajaxFileToCall; ?>?h=autoSave<?php echo $langParam; ?>",
                    type: 'POST',
                    async: false,

                    data: {
                        'formHtml': $('.myForm').html(),
                        'email': email,
                    },

                    success: function(data) {

                        if (data.Success == 'true') {

                        } else {

                            let error_msg = '<?php echo $allLabelsArray[53] ?>'//'There was a problem. Try to submit again'
                            let error_title ='<?php echo $allLabelsArray[65] ?>'// 'Error'
                            //make_toast('danger', error_title, error_msg)
                        }
                    },

                    error: function(data) {

                    }
                });
                return false;
            }, 1000)
        }



    }
    // *********** end functions ***********
</script>
