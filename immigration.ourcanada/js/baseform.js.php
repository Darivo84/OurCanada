
    var ArrLabels = new Array();
    ArrLabels = <?php echo json_encode($labelArray); ?>;
    var eca_user_array = [849, 569, 563, 559, 575, 582, 592, 587, 595]
    var eca_spouse_array = [108, 112, 120, 173, 183, 187, 195, 192]
    var job_user_array = [624, 647, 667, 689, 712]
    var job_spouse_array = [277, 297, 316, 336, 372]

    var comment_box = false
    var years = 0;
    var count = {};
    var countCheck = {};
    var cv, gv, hv, cf, cq, co = '';
    var email_ques = [];

    var checkField = new Array();
    var hiddenQues = new Array();
    var checkValue = new Array();
    var checkQues = new Array();
    var checkOp = new Array();
    var bbb = false;
    var userGrades = [];
    var spouseGrades = [];


    var scoreArray = new Array()
    var scoreArray2 = new Array()
    var spouseScoreArray = new Array()
    var spouseScoreArray2 = new Array()
    var spouseNocScore = new Array()

    var nocArray = new Array()

    var casesArray = new Array()


    var rType = '';
    var dateArray = new Array();
    var dateCheck = 0;
    var dateCheck2 = 0;

    var nocUser = new Array();
    var nocSpouse = new Array();

    var fromDate;
    var toDate;
    var up1 = '', up2 = '', up3 = '', up4 = '', up5 = '', job = '', up = '';

    var lArray = [];
    var sArr = [];
    var currentRequest = '';
    var req_check = false;

    var disCl = '';

    var jobsArr = [], dutyArr = [], jobsArrOrg = [], dutyArrOrg = [],jobsArrExtra=[],dutyArrExtra=[];
    var jobLen = 0, dutyLen = 0;

    var quesArr = [], notesArr = [], optionsArr = [], oldValues = [] , valuesArr = [] , ArrCountry = [], ArrEducation = [] ,  extraArr=[];
    var removeIdentical = [];
    var emailCount = false
    var func1 = false, func2 = false, func3 = false

    var submission = false;
    var pending_submission = false;
    var endCase = false;
    var endCase_message = '';


    function getNoc()
    {
        $.ajax({
            dataType: 'json',
            url: "seoajax.php?h=getNocJobs",
            type: 'POST',
            success: function (data) {

                jobsArr = data.jobsArr;
                jobLen = data.jobsLength;
                jobsArrExtra = data.jobsArrExtra;

                jobsArrOrg = data.jobsArrOrg;
                dutyArrOrg = data.dutyArrOrg;
                dutyArrExtra = data.dutyArrExtra;

                dutyArr = data.dutyArr;
                dutyLen = data.dutyLen;

                tagsInp()
                nocChanger()
            }
            ,
            error: function (data) {

            }
        });
    }
    $(document).ready(function () {

        $('.prompt').html('')

        if (localStorage.getItem('display') == 'Right to Left') {
            disCl = 'rightToLeft';
        } else {
            disCl = 'leftToRight';
        }

        var newArr = new Array()
        for (var key in localStorage) {
            if (key[0] == 'n' || key[0] == 'f') {
                newArr[key] = localStorage.getItem(key)
            }
            if (key[0] == 's') {
                sArr.push(localStorage.getItem(key));
            }
            if (key[0] == 'm') {
                lArray.push(parseInt(localStorage.getItem(key)));
            }
        }
        sArr.forEach(function (i) {

            count[i] = (count[i] || 0) + 1;

        });

        $(window).keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        if(localStorage.getItem('AgreeCheck')==1)
        {
            getNoc()
        }



        if(localStorage.getItem('AgreeCheck')==1 && url!==local_old_url && local_old_url!==null)
        {
            console.log(url)
            console.log(local_old_url)

            $.ajax({
                dataType: 'json',
                url: "lang2.php?h=getTranslationArr",
                type: 'POST',
                success: function (data) {
                    quesArr = data.questArr;
                    notesArr = data.notesArr;
                    ArrCountry = data.ArrCountry;
                    ArrEducation = data.ArrEducation;

                    optionsArr = data.optionsArr;
                    valuesArr = data.valuesArr;
                    oldValues = data.oldValues;

                    if(localStorage.getItem('AgreeCheck')==1)
                    {
                        setTimeout(function () {
                            callTranslations();
                        }, 2000);
                    }
                }
                ,
                error: function (data) {
                    console.log(data)

                }
            });

        }
        else
        {
            setTimeout(function () {
                $('#formLoader').hide();
            }, 3000)
        }




    })
    function nocChanger()
    {
        tagsInp()

        if (localStorage.getItem('Lang') !== 'english') {

            $(".nocJobs").each(function () {
                let curValue = $(this).val();
                let index = jobsArrOrg.indexOf(curValue);
                let orgValue = curValue

                if (index > -1) {
                    orgValue = jobsArr[index];
                }
                else
                {

                    let index=jobsArrExtra.indexOf(curValue)

                    if (index > -1) {
                        orgValue = jobsArr[index];
                    }
                }

                let getAttr = $(this).attr('name');
                $("input[name='" + getAttr + "']").val(orgValue);
                $(this).prev('div').children('a').children('span.select2-chosen').html(orgValue)


            });
            $(".nocPos").each(function () {
                let curValue = $(this).val();
                let index = dutyArrOrg.indexOf(curValue);
                let orgValue = curValue

                if (index > -1) {
                    orgValue = dutyArr[index];
                }
                else
                {
                    index=dutyArrExtra.indexOf(curValue)
                    if (index > -1) {
                        orgValue = dutyArr[index];
                    }
                }

                var getAttr = $(this).attr('name');
                $("input[name='" + getAttr + "']").val(orgValue);
                $(this).prev('div').children('a').children('span.select2-chosen').html(orgValue)

            });


            // for (let i = 0; i < nocUser.length; i++) {
            //     let orgValue = ''
            //     let index = -1;
            //
            //     if (nocUser[i] !== '' && nocUser[i] !== null && nocUser.hasOwnProperty(i) && nocUser[i].noc!==undefined) {
            //         let nc = (nocUser[i].noc).split('^')
            //         console.log(dutyArr)
            //
            //         for (let j = 0; j < nc.length; j++) {
            //             let curValue = nc[j];
            //             index = dutyArr.indexOf(curValue);
            //
            //             if (index > -1) {
            //                 orgValue += dutyArrOrg[index] + '^';
            //             } else {
            //                 index = jobsArr.indexOf(curValue);
            //
            //                 if (index > -1) {
            //                     orgValue += jobsArrOrg[index] + '^';
            //                 }
            //             }
            //         }
            //
            //         nocUser[i].noc = orgValue
            //
            //     }
            // }
            // for (let i = 0; i < nocSpouse.length; i++) {
            //     let orgValue = ''
            //     let index = -1;
            //
            //     if (nocSpouse[i] !== '' && nocSpouse[i] !== null && nocSpouse.hasOwnProperty(i) && nocSpouse[i].noc!==undefined) {
            //         let nc = (nocSpouse[i].noc).split('^')
            //         for (let j = 0; j < nc.length; j++) {
            //             let curValue = nc[j];
            //             index = dutyArr.indexOf(curValue);
            //
            //             if (index > -1) {
            //                 orgValue += dutyArrOrg[index] + '^';
            //             } else {
            //                 index = jobsArr.indexOf(curValue);
            //
            //                 if (index > -1) {
            //                     orgValue += jobsArrOrg[index] + '^';
            //                 }
            //             }
            //         }
            //        // nocSpouse[i].noc = orgValue
            //     }
            // }

        }
        else if (localStorage.getItem('Lang') == 'english') {


            $(".nocJobs").each(function () {
                let curValue = $(this).val();

                let index = jobsArrOrg.indexOf(curValue);
                let orgValue = curValue

                if (index > -1) {
                    orgValue = jobsArr[index];
                }
                else
                {
                    index=jobsArrExtra.indexOf(curValue)
                    if (index > -1) {
                        orgValue = jobsArr[index];
                    }
                }
                let getAttr = $(this).attr('name');
                $("input[name='" + getAttr + "']").val(orgValue);
                $(this).prev('div').children('a').children('span.select2-chosen').html(orgValue)


            });
            $(".nocPos").each(function () {
                let curValue = $(this).val();
                let index = dutyArrOrg.indexOf(curValue);
                let orgValue = curValue

                if (index > -1) {
                    orgValue = dutyArr[index];
                }
                else
                {
                    index=dutyArrExtra.indexOf(curValue)
                    if (index > -1) {
                        orgValue = dutyArr[index];
                    }
                }
                var getAttr = $(this).attr('name');
                $("input[name='" + getAttr + "']").val(orgValue);
                $(this).prev('div').children('a').children('span.select2-chosen').html(orgValue)
            });


            // for (let i = 0; i < nocUser.length; i++) {
            //     let orgValue = ''
            //     let index = -1;
            //
            //     if (nocUser[i] !== '' && nocUser[i] !== null && nocUser.hasOwnProperty(i) && nocUser[i].noc!==undefined) {
            //         let nc = (nocUser[i].noc).split('^')
            //
            //         for (let j = 0; j < nc.length; j++) {
            //             let curValue = nc[j];
            //             index = dutyArr.indexOf(curValue);
            //
            //             if (index > -1) {
            //                 orgValue += dutyArrOrg[index] + '^';
            //             } else {
            //                 index = jobsArr.indexOf(curValue);
            //
            //                 if (index > -1) {
            //                     orgValue += jobsArrOrg[index] + '^';
            //                 }
            //             }
            //         }
            //         nocUser[i].noc = orgValue
            //     }
            // }
            // for (let i = 0; i < nocSpouse.length; i++) {
            //     let orgValue = ''
            //     let index = -1;
            //
            //     if (nocSpouse[i] !== '' && nocSpouse[i] !== null && nocSpouse.hasOwnProperty(i) && nocSpouse[i].noc!==undefined) {
            //         let nc = (nocSpouse[i].noc).split('^')
            //
            //         for (let j = 0; j < nc.length; j++) {
            //             let curValue = nc[j];
            //             index = dutyArr.indexOf(curValue);
            //             if (index > -1) {
            //                 orgValue += dutyArrOrg[index] + '^';
            //             } else {
            //                 index = jobsArr.indexOf(curValue);
            //                 if (index > -1) {
            //                     orgValue += jobsArrOrg[index] + '^';
            //                 }
            //             }
            //         }
            //         nocSpouse[i].noc = orgValue
            //     }
            // }

        }
    }
    var temp_val,temp_id,temp_pid
    var change1=false
    var change2=false
    var no_change=false
    var clicked=false

    var previous_country=''
    var changed_element=''
    function check_country_change(value,id,pid)
    {
        if($(value).hasClass('countryCheck'))
        {
            let name=$(value).attr('name')
            let namesArray=['n[question_68]','n[question_69]','n[question_70]','n[question_71]']
            let element1=document.getElementsByName('n[sub_question_350]')
            let element2=document.getElementsByName('n[question_74]')
            let val1=document.getElementsByName('n[question_68]')
            let val2=document.getElementsByName('n[question_69]')
            let val3=document.getElementsByName('n[question_70]')
            let val4=document.getElementsByName('n[question_71]')

            val1=$(val1).val()
            val2=$(val2).val()
            val3=$(val3).val()
            val4=$(val4).val()

            if(namesArray.indexOf(name) > -1)
            {
                if($(element1).eq(0).prop('checked') || $(element1).eq(1).prop('checked') ||$(element2).eq(0).prop('checked') || $(element2).eq(1).prop('checked'))
                {

                    if($('.parent_350').length > 0)
                    {
                        if(val1!=='Canada' && val2!=='Canada' && val3!=='Canada' && val4!=='Canada')
                        {
                            no_change=false
                            clicked=true
                            valSave(value)
                            return false
                        }
                        else if(val1=='Canada' || val2=='Canada' || val3=='Canada' || val4=='Canada')
                        {

                            change1=true
                        }
                    }
                    else if($('.main_parent_74').length > 0 && $('.main_parent_74').css('display')!=='none')
                    {
                        if(val1!=='Canada' && val2!=='Canada' && val3!=='Canada' && val4!=='Canada')
                        {

                            change2=true
                        }
                        else if(val1=='Canada' || val2=='Canada' || val3=='Canada' || val4=='Canada')
                        {
                            no_change=false
                            clicked=true
                            valSave(value)
                            return false
                        }
                    }

                    if(change1 || change2)
                    {
                        let error_msg='If you want to change country, you will have to fill the form again'
                        if(localStorage.getItem('Lang')!=='english')
                        {
                            error_msg=static_label_changer(error_msg)
                        }
                        temp_val=value;
                        temp_id=id;
                        temp_pid=pid;
                        valSave(value)
                        $('#error_msg').html(error_msg)
                        $('#errorModal').modal()
                        return false
                    }
                    else
                    {
                        no_change=false
                        clicked=true
                    }

                }
                else
                {
                    getQuestion(value,id,pid)
                }
            }
        }
    }
    $(document).on('change', '#language-picker-select', function () {
        localStorage.setItem('newFlag', 1)
    })

    $(document).on('keydown', '.datepicker', function (e) {
        if ((e.keyCode == 86))
        {
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

    $(document).on('focus', '.datepicker', function () {
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

    $(document).on('change', '.datepicker', function () {
        valSave(this)
        $(this).next('label.error').remove()

        let dateVal = $(this).val()
        let ent_date = new Date(dateVal)
        let cur_date = new Date()
        let date_year = ent_date.getFullYear()
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

        let check_years = new Date(new Date() - new Date(enteredDate)).getFullYear() - 1970;
        if (check_years > 121 || dateVal[0] != date_year) {
            if ($(this).parent().parent().children('label.error').length <= 0 && $(this).val() !== '' && $(this).next('label.error').length <= 0) {
                let error_msg = 'Invalid date'
                if(localStorage.getItem('Lang')!=='english')
                {
                    error_msg=static_label_changer(error_msg)
                }
                $(this).parent().parent().append('<label class="error">'+error_msg+'</label>')
            }
            if($(this).hasClass('nocPicker'))
            {
                noc(this,'off1')
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
                    let error_msg = 'Are you sure this person was born today?'
                    if(localStorage.getItem('Lang')!=='english')
                    {
                        error_msg=static_label_changer(error_msg)
                    }
                    $(this).parent().parent().append('<label class="error">' + error_msg + '</label>')
                }
            }
        }
        if($(this).attr('name')=='n[question_30]'){
            years = new Date(new Date() - new Date(enteredDate)).getFullYear() - 1970;
            movegroup3(this)
        }
        if($(this).hasClass('nocPicker'))
        {
            noc(this, '')
            valSave(this)
        }
    });

    $(document).on('change', 'input[type="radio"]', function () {
        movegroup2(this)
    });
    $(document).on('change', 'select', function () {
        if($(this).hasClass('countryCheck'))
        {
            let name=$(this).attr('name')
            let namesArray=['n[question_68]','n[question_69]','n[question_70]','n[question_71]']
            let element1=document.getElementsByName('n[sub_question_350]')
            let element2=document.getElementsByName('n[question_74]')
            let val1=document.getElementsByName('n[question_68]')
            let val2=document.getElementsByName('n[question_69]')
            let val3=document.getElementsByName('n[question_70]')
            let val4=document.getElementsByName('n[question_71]')

            val1=$(val1).val()
            val2=$(val2).val()
            val3=$(val3).val()
            val4=$(val4).val()
            let change=false
            if(namesArray.indexOf(name) > -1)
            {
                if($(element1).eq(0).prop('checked') || $(element1).eq(1).prop('checked') ||$(element2).eq(0).prop('checked') || $(element2).eq(1).prop('checked'))
                {

                    if($('.parent_350').length > 0)
                    {
                        if(val1!=='Canada' && val2!=='Canada' && val3!=='Canada' && val4!=='Canada')
                        {
                            no_change=false
                            return false
                        }
                        else if(val1=='Canada' || val2=='Canada' || val3=='Canada' || val4=='Canada')
                        {
                            change=true
                        }
                    }
                    else if($('.main_parent_74').length > 0 && $('.main_parent_74').css('display')!=='none')
                    {
                        if(val1!=='Canada' && val2!=='Canada' && val3!=='Canada' && val4!=='Canada')
                        {
                            change=true
                        }
                        else if(val1=='Canada' || val2=='Canada' || val3=='Canada' || val4=='Canada')
                        {
                            no_change=false
                            return false

                        }
                    }


                    // if($('.main_parent_74').length > 0 && $('.main_parent_74').css('display')!=='none')
                    // {
                    //     $('.main_parent_74').remove()
                    // }

                }
                else
                {
                    if($('.parent_350').length > 0)
                    {
                        $('.parent_350').remove()
                    }
                    movegroup4(this)
                }
            }
            else
            {
                movegroup4(this)
            }
        }
        else
        {
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
    //
    $(document).on('keypress, keydown, keyup', 'input[type="tel"]', function (e) {
        changeErrorLabels()
    })
    $(document).on('keypress, keydown, keyup', 'input[type="email"]', function (e) {
        changeErrorLabels()
    })
    $(document).on('keypress, keydown, keyup', 'input[type="text"]', function (e) {
        changeErrorLabels()
    })
    $(document).on('keypress, keydown, keyup', 'input[type="number"]', function (e) {
        changeErrorLabels()
    })
    $(document).on('click', 'select', function (e) {
        if($(this).hasClass('countryCheck')) {
            if(clicked==false)
            {
                let name = $(this).attr('name')
                let namesArray = ['n[question_68]', 'n[question_69]', 'n[question_70]', 'n[question_71]']

                if (namesArray.indexOf(name) > -1 && no_change==false ) {
                    previous_country=$(this).val()
                    if(($('.main_parent_74').length > 0 && $('.main_parent_74').css('display')!=='none') || $('.parent_350').length > 0 )
                    {
                        changed_element=this
                        no_change=true
                    }
                }
            }
            else
            {
                clicked=false
            }
        }
        changeErrorLabels()
    })
    $(document).on('keypress', 'input[type="text"]', function (e) {
        changeErrorLabels()
        if ($(this).hasClass('datepicker')) {
            var keyCode = e.keyCode || e.which;
            var regex = /^[0-9-]+$/;
            var isValid = regex.test(String.fromCharCode(keyCode));
            return isValid;
        }
        var keyCode = e.keyCode || e.which;
        var regex = /^[A-Za-z ]+$/;
        let a = $(this).parent().parent().children('label').html();
        if (a !== undefined) {
            if (a.includes('address') || a.includes('Address') || a.includes('Adresse') || a.includes('adresse') || a.includes('پتہ')) {
                return true;
            } else {
                var isValid = regex.test(String.fromCharCode(keyCode));
                return isValid;

            }
            return false;
        }
    })
    $(document).on('keypress', 'input[type="tel"]', function (e) {


        var keyCode = e.keyCode || e.which;
        let v = $(this).val();

        var regex = /^[+0-9]$/;
        var isValid = regex.test(String.fromCharCode(keyCode));
        return isValid;

        return false;
    })

    $(document).on('keypress', 'input[type="number"]', function (e) {
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

    var btnCheck = false

    $(document).on('change', '.countryCheck', function () {
        countryFunc(this)
    })
    $(document).on('change', 'input[type="date"]', function () {
        noc(this, '')
        valSave(this)
    })

    $(document).on('change', 'input.nocPicker', function () {
        // noc(this, '')
        // valSave(this)
    })


    $(document).on('change', '.present_checkbox', function (e) {

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
            let v = 'Present'
            if (localStorage.getItem('Lang') !== 'english') {
                v = static_label_changer(v)
            }
            $(dis).val(v);
            $(dis).attr('data-def','Present');

            noc(dis, 'on')

        } else {
            $(dis).css('pointer-events', '')
            $(dis).val('');
            $(dis).attr('data-def','');
            noc(dis, 'off')


        }
        valSave(dis)
    });
    $(document).on('keyup', 'input', function (e) {
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
    $(document).on('change', 'select', function (e) {

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
                    nocSpouse[index].authorization=''
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
                    nocUser[index].authorization=''
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
    $(document).on('change', '.nocJobs', function (ee) {

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
        $('input.nocJobs[data-position="' + noc_pos + '"]').each(function () {
            let nocJob = $(this).val()
            if ($(this).attr('data-label') == 'user') {
                up3 += nocJob + '^'
            } else {
                up4 += nocJob + '^'
            }
        })
        $('input.nocPos[data-position="' + noc_pos + '"]').each(function () {
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

    $(document).on('change', '.nocPos', function (ee) {
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


        if (noc_flag == '1') {
            up3 = '';
            up4 = '';
            $('input.nocJobs[data-position="' + noc_pos + '"]').each(function () {
                let nocJob = $(this).val()
                if ($(this).attr('data-label') == 'user') {
                    up3 += nocJob + '^'
                } else {
                    up4 += nocJob + '^'
                }
            })
            $('input.nocPos[data-position="' + noc_pos + '"]').each(function () {
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

    $(document).on('click', '#iAgree #terms', function () {
        let fields_check = true
        let error_msg = 'Please fill the above fields first.'
        let error_title='Error'
        $('input').each(function () {
            if($(this).parent().parent().parent().attr('class')!==undefined)
            {
                let class_check=$(this).parent().parent().parent().attr('class').includes('parent')

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
        $('select').each(function () {
            if($(this).parent().parent().parent().attr('class')!==undefined)
            {
                let class_check=$(this).parent().parent().parent().attr('class').includes('parent')

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
            if (localStorage.getItem('Lang') !== 'english') {
                error_msg = static_label_changer(error_msg)
                error_title =static_label_changer(error_title)
            }
            make_toast('danger', error_title, error_msg)
            return false
        }
        getNoc();
        document.cookie = 'AgreeCheck=1';
        localStorage.setItem('AgreeCheck', '1');
        $(".unChecked").css('display', 'block');

        $(".unChecked").each(function () {
            $(this).removeClass('unChecked');
        })

        $("#iAgree, #terms").remove();
        formFunc('')
    });

    $(document).on('change', 'input,textarea,select', function () {
        if ($(this).hasClass('comments')) {

        } else {
            if (localStorage.getItem('Submission') !== 'true') {
                if (localStorage.getItem('EndCase') == 'matched') {
                    $("label.error").each(function () {
                        if ($('label.error').css('display') === 'none') {
                            $(this).remove();
                        } else {
                            //something else
                        }
                    })
                    if ($("label.error").length <= 0) {
                        $('html,body').animate({scrollTop: document.body.scrollHeight}, "fast");
                        $(".email").css('display', 'block');
                        setTimeout(function () {
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

    function noc_job_question(e)
    {
        let noc_flag = $(e).attr('data-noc')
        let noc_pos = $(e).attr('data-position')
        let noc_user = $(e).attr('data-label')
        let noc_type = $(e).attr('data-type')
        let index = parseInt(noc_pos) - 1;
        let v = $(e).val()
        if(noc_type=='' || noc_type==null || noc_type==undefined)
        {

        }
        if (noc_pos == '7' && noc_flag == '1' && (noc_type=='null' || noc_type=='' || noc_type==null || noc_type==undefined)) {
            if (noc_user == 'spouse') {
                if (nocSpouse[index] != '' && v == 'No') {
                    nocSpouse[index] = '';
                } else {
                    nocSpouse[index] = {'position': noc_pos, 'job': 1, 'country': 'Canada'}
                }
            } else {
                if (nocUser[index] != '' && v == 'No') {
                    nocUser[index] = '';
                } else {
                    nocUser[index] = {'position': noc_pos, 'job': 1, 'country': 'Canada'}
                }
            }
        }
    }
    function position_date(value, id, pid, q) {
        if ($(value).hasClass('nocPicker')) {
            let prev = $(value).prev().val()
            if($(value).val()!=='' && prev!=='')
            {
                $(value).parent().children('input').prop('disabled', true)
                $(value).parent().children('select').prop('disabled', true)
                $(value).parent().children('.presCheck').children('input').prop('disabled', true)
            }

            setTimeout(function () {
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

    function getQuestion(value, id, pid) {
        noc_job_question(value)
        if ((id == 74 || id == 77) && $('.parent_350').length > 0) {
            $('.main_parent_74').each(function () {
                if ($(this).hasClass('displayNone74')) {
                    $(this).remove()
                }
            })
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
        valSave(value)

        if ($(value).parent().find('.temp').length == 0)
            $(value).parent().append('<span class="spinner-border spinner-border-sm temp ' + disCl + '" role="status"></span>');

        $(value).parent().children('input').prop('disabled', true)
        $(value).parent().children('select').prop('disabled', true)
        $(value).parent().children('.presCheck').children('input').prop('disabled', true)

        let pos = $(value).parent().children('input').attr('type')


        var val = $(value).val();
        let movescore_case_check = false
        endCase = false

        $('.main_parent_' + id)
            .children()             //Select all the children of the parent
            .not(':first-child')    //Unselect the first child
            .remove();

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
            currentRequest = $.ajax({
                dataType: 'json',
                url: "seoajax.php?h=getQuestion",
                type: 'POST',
                data: {
                    'id': id,
                    'value': val,
                    'pid': pid,
                    'email': email //#bg70143
                },
                success: function (data) {

                    var fieldData = '';

                    let mq = 0;
                    if (lArray.indexOf(parseInt(id)) < 0 && data.MultiCondition.length > 0) {
                        let sid_length=(localStorage.getItem('sid_length'))
                        if(sid_length===null || sid_length==='')
                        {
                            sid_length=0;
                        }
                        else
                        {
                            sid_length=parseInt(sid_length)
                        }
                        let multicond_length = data.MultiCondition.length
                        let number=sid_length+1;


                        for (var i = 0; i < multicond_length; i++) {


                            localStorage.setItem('sid-' + number, data.MultiCondition[i].s_id)
                            localStorage.setItem('qtype-' + number, data.MultiCondition[i].question_type)
                            localStorage.setItem('ex_sid-' + number, data.MultiCondition[i].existing_sid)
                            localStorage.setItem('ex_qid-' + number, data.MultiCondition[i].existing_qid)
                            localStorage.setItem('value-' + number, data.MultiCondition[i].value);
                            localStorage.setItem('op-' + number, data.MultiCondition[i].operator);
                            localStorage.setItem('mainQues-' + number, data.MultiCondition[i].mques)
                            localStorage.setItem('andor-' + number, data.MultiCondition[i].op)
                            number++;

                            if (mq != data.MultiCondition[i].mques) {
                                lArray.push(parseInt(data.MultiCondition[i].mques))
                                mq = data.MultiCondition[i].mques
                            }
                            sArr.push(data.MultiCondition[i].s_id);
                        }
                        count = []
                        sArr.forEach(function (i) {

                            count[i] = (count[i] || 0) + 1;
                            // count against each sid

                        });
                        localStorage.setItem('sid_length',sid_length+multicond_length)
                    }

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
                            endCase_message = 'Form has been submitted'
                        } else if (data.data[i].casetype == 'endwt') {
                            // $('#btnModal').click()
                            localStorage.setItem('EndCase', 'matched');
                            endCase = true;
                            endCase_message = 'Thank You for your interest in Canada'

                        } else if (data.data[i].casetype == 'endwc') {
                            // $('#btnModal').click()
                            localStorage.setItem('EndCase', 'matched');
                            endCase = true;
                            endCase_message = 'Congratulations and thank you for your interest in Canada'

                        } else if (data.data[i].casetype == 'endwa') {
                            // $('#btnModal').click()
                            localStorage.setItem('EndCase', 'matched');
                            endCase = true;
                            endCase_message = 'Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.'
                        } else {
                            if (data.data[i].check == 1) {

                                if (termsCheck == 'unchecked') {

                                    fieldData += "<div class='form-group sub_question_div unChecked sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'>"
                                } else {
                                    fieldData += "<div class='form-group sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'>"
                                }


                                if (data.data[i].notes != '' && data.data[i].notes != null && data.data[i].field != 'pass') {


                                    fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                }

                                fieldData += "<label class='pb-1'>" + data.data[i].other + "</label>";
                            } else {

                                if (termsCheck == 'unchecked') {
                                    fieldData += "<div class='form-group sub_question_div unChecked sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'>"

                                } else {
                                    fieldData += "<div class='form-group sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'>"
                                }


                                if (data.data[i].notes != '' && data.data[i].notes != null) {

                                    fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                }

                                fieldData += "<label class='pb-1'>" + data.data[i].question + "</label>";
                            }
                            fieldData += "<div class='input-group input-group-merge " + permission + "'>"


                            if (data.data[i].field == 'radio' && data.data[i].labeltype == 0) {
                                let y = 'Yes'
                                let n = 'No'
                                if (localStorage.getItem('Lang') !== 'english') {
                                    y = static_label_changer(y)
                                    n = static_label_changer(n)
                                }

                                fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='Yes' " + noc_attr + "><span class='customLabel'>" + y + "</span>"
                                fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='No' " + noc_attr + "><span class='customLabel' >" + n + "</span>";

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
                                fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
                                for (var j = 0; j < (data.country).length; j++) {
                                    let c = data.country[j].name
                                    fieldData += "<option value='" + data.country[j].value + "' >" + c + "</option>";

                                }
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'education') {
                                fieldData += "<select " + data.data[i].validation + " class='education form-control' onchange='getQuestion3(this," + data.data[i].id + "," + id + ")' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                                fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
                                for (var j = 0; j < (data.education).length; j++) {
                                    let c = data.education[j].name
                                    fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                                }
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'dropdown') {
                                fieldData += "<select " + data.data[i].validation + " class='form-control' onchange='getQuestion3(this," + data.data[i].id + "," + id + ")' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                                fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
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
                                fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='from'  max='" + formatted_date + "'  type='text' class='datepicker form-control nocPicker' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                                fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='to' onchange='position_date(this," + data.data[i].id + "," + id + ",3)'   max='" + formatted_date + "'  type='text' class='datepicker form-control nocPicker' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                                fieldData += "<div class='presCheck'><input type='checkbox' class='present_checkbox' onchange='if(presentBox(this)==false){return false;}getQuestion3(this," + data.data[i].id + "," + id + ")'><span class='presentCheckbox static_label'>Present</span></div>"

                            } else {
                                fieldData += "<input " + data.data[i].validation + " onfocusout='getQuestion3(this," + data.data[i].id + "," + id + ")' type='text' class='form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                            }
                        }
                        fieldData += "</div>";
                        fieldData += "</div>";
                        fieldData += "</div>";


                    }
                    if(id==544)
                    {
                        setTimeout(function () {
                            $('.main_parent_' + id).append(fieldData)
                            valSave(value)

                        }, 3000);
                    }
                    else
                    {
                        $('.main_parent_' + id).append(fieldData)
                        $(value).parent().find('.temp').remove()
                        $(value).parent().children('input').prop('disabled', false)
                        $(value).parent().children('select').prop('disabled', false)
                        $(value).parent().children('.presCheck').children('input').prop('disabled', false)
                    }

                    if (movescore_case_check) {
                        $('#validateform').submit()
                    }
                    if (endCase) {
                        if ($('#validateform').valid()) {
                            if(custom_validation())
                            {
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


                    if(id==109)
                    {
                        everyChangeFunction()
                    }



                    let time=1000
                    if(id==544)
                    {
                        time=3000
                    }
                    setTimeout(function () {
                        multi(id, value)
                        if(time==3000)
                        {
                            $(value).parent().find('.temp').remove()
                            $(value).parent().children('input').prop('disabled', false)
                            $(value).parent().children('select').prop('disabled', false)
                            $(value).parent().children('.presCheck').children('input').prop('disabled', false)
                        }

                    }, time);
                    formFunc(value)
                    tagsInp()
                    currentRequest = '';
                    req_check = false

                }
                ,
                error: function (data) {
                    $(value).parent().find('.temp').remove()
                    $(value).parent().children('input[type="radio"]').prop('disabled', false)
                    $(value).parent().children('select').prop('disabled', false)
                    $(value).parent().next('.presCheck').children('input').prop('disabled', false)

                    $('#btnModal2').click()
                    currentRequest = '';
                    req_check = false
                }


            });

        }



    }

    function getQuestion2(value, id, qid, pid, v) {

        valSave(value)

        if ($(value).parent().find('.temp').length == 0)
            $(value).parent().append('<span class="spinner-border spinner-border-sm temp ' + disCl + '" role="status"></span>');

        var val = $(value).val();

        if (value == null) {
            val = v
        }


        $('.parent_' + id)
            .children()
            .not(':first-child')
            .remove();

        let email = $('input[type="email"]:first').val()


        $.ajax({
            dataType: 'json',
            url: "seoajax.php?h=getQuestion2",
            type: 'POST',
            data: {
                'id': id,
                'value': val,
                'qid': qid,
                'email': email //#bg70143
            },
            success: function (data) {
                $(value).parent().find('.temp').remove()

                var fieldData = '';
                if (data.grade != '' && data.grade != null) {
                    if (data.type == 'user') {
                        // console.log(userGrades);

                        if (userGrades.length > 0) {
                            userGrades.indexOf(data.grade) > -1 ? console.log("This item already exists") : userGrades[userGrades.length + 1] = data.grade;

                        } else {
                            var grades = [];
                            for (var g = 0; g < userGrades.length; g++) {
                                grades[g] = userGrades[g];
                            }
                            grades[userGrades.length + 1] = data.grade;
                            userGrades = grades;

                        }
                        // console.log(userGrades)
                        localStorage.setItem('userGrades', JSON.stringify(userGrades))
                    } else {
                        if (spouseGrades.length > 0) {
                            spouseGrades.indexOf(data.grade) > -1 ? console.log("This item already exists") : spouseGrades[spouseGrades.length + 1] = data.grade;
                            ;

                        } else {
                            var grades = [];
                            for (var g = 0; g < spouseGrades.length; g++) {
                                grades[g] = spouseGrades[g];
                            }
                            grades[spouseGrades.length + 1] = data.grade;
                            spouseGrades = grades;
                        }
                        // console.log(spouseGrades)
                        localStorage.setItem('spouseGrades', JSON.stringify(spouseGrades))
                    }


                } else {
                    for (var i = 0; i < data.data.length; i++) {

                        if(id==12800)
                        {
                            let ele1=''
                            let ele2 =''
                            let ele3 =''

                            if($('.main_parent_77').length > 0)
                            {
                                ele1 = document.getElementsByName('n[question_77]')
                            }
                            if($('.parent_118').length > 0)
                            {
                                ele2 = document.getElementsByName('n[sub_question_118]')
                            }
                            if($('.parent_176').length > 0)
                            {
                                ele3 = document.getElementsByName('n[sub_question_176]')
                            }



                            if ((ele1!=='' && ele1[0].checked == true) || (ele2!=='' && ele2[0].checked == true) || (ele3!=='' && ele3[0].checked == true)) {

                            }
                            else
                            {
                                if(data.data[i].id==12154)
                                {
                                    continue
                                }
                            }
                        }

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
                        var $row = $(value).parent();
                        if (localStorage.getItem('AgreeCheck') == 0) {
                            fieldData += "<div class='unChecked parent_" + data.data[i].id + "'>"
                        } else {
                            fieldData += "<div class='parent_" + data.data[i].id + "'>"
                        }

                        {
                            {
                                fieldData += "<div class='form-group sub_question_div sques_" + qid + " sques_" + id + " sques_" + pid + "' id='sub_question_div_" + data.data[i].id + "'>"
                                if (data.data[i].notes != '' && data.data[i].notes != null && data.data[i].field != 'pass') {

                                    fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                }

                                fieldData += "<label class='pb-1'>" + data.data[i].question + "</label>";


                            }
                            fieldData += "<div class='input-group input-group-merge " + permission + "'>"

                            if (data.data[i].field == 'radio' && data.data[i].labeltype == 0) {

                                let y = 'Yes'
                                let n = 'No'
                                if (localStorage.getItem('Lang') !== 'english') {
                                    y = static_label_changer(y)
                                    n = static_label_changer(n)
                                }

                                fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + qid + "," + id + ")' value='Yes' " + noc_attr + "><span class='customLabel'>" + y + "</span>"
                                fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + qid + "," + id + ")' value='No' " + noc_attr + "><span class='customLabel' >" + n + "</span>";

                            } else if (data.data[i].field == 'radio' && data.data[i].labeltype == 1) {
                                fieldData += data.data[i].radios;
                            } else if (data.data[i].field == 'calender') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                            } else if (data.data[i].field == 'age') {
                                fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker age' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + "  onchange='getQuestion3(this," + data.data[i].id + " , " + qid + ")'>";
                                fieldData += "<input type='text' class='form-control dob' readonly hidden name='dob*" + data.data[i].id + "'>"

                            } else if (data.data[i].field == 'email') {
                                fieldData += "<input " + data.data[i].validation + " type='email' class='form-control' name='n[sub_question_" + data.data[i].id + "]'>";
                            } else if (data.data[i].field == 'country') {
                                fieldData += "<select " + data.data[i].validation + "  class='form-control countryCheck' onchange='getQuestion3(this," + data.data[i].id + " , " + qid + ")' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                                fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
                                for (var j = 0; j < (data.country).length; j++) {
                                    let c = data.country[j].name
                                    fieldData += "<option value='" + data.country[j].value + "' >" + c + "</option>";

                                }
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'education') {
                                fieldData += "<select " + data.data[i].validation + " class='education form-control' onchange='getQuestion3(this," + data.data[i].id + "," + qid + ")' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                                fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
                                for (var j = 0; j < (data.education).length; j++) {
                                    let c = data.education[j].name
                                    fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                                }
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'dropdown') {
                                fieldData += "<select " + data.data[i].validation + " onchange='getQuestion3(this," + data.data[i].id + "," + qid + ")' class='form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                                fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
                                fieldData += data.data[i].dropdown;
                                fieldData += "</select>"
                            } else if (data.data[i].field == 'nocjob') {

                                fieldData += "<input " + data.data[i].validation + " class='" + data.data[i].validation + " form-control nocJobs' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                            } else if (data.data[i].field == 'nocduty') {

                                fieldData += "<input " + data.data[i].validation + " class='" + data.data[i].validation + " form-control nocPos' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                            } else if (data.data[i].field == 'pass') {
                                fieldData += "<label class='notesPara2'>" + data.data[i].notes + "</label>"
                            } else if (data.data[i].field == 'number') {
                                fieldData += "<input " + data.data[i].validation + "  type='number' class='form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";

                            } else if (data.data[i].field == 'currentrange') {
                                let current_datetime = new Date()
                                let m = ((current_datetime.getMonth() + 1) >= 10) ? (current_datetime.getMonth() + 1) : '0' + (current_datetime.getMonth() + 1);
                                let d = ((current_datetime.getDate()) >= 10) ? (current_datetime.getDate()) : '0' + (current_datetime.getDate());
                                let formatted_date = current_datetime.getFullYear() + "-" + m + "-" + d

                                fieldData += "<label class='pb-date static_label'>From</label><label class='pb-date static_label'>To</label>"

                                fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='from'   max='" + formatted_date + "'  type='text' class='datepicker form-control nocPicker' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                                fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='to' onchange='position_date(this," + data.data[i].id + "," + qid + ",3)'   max='" + formatted_date + "'  type='text' class='datepicker form-control nocPicker' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                                fieldData += "<div class='presCheck'><input type='checkbox' class='present_checkbox' onchange='if(presentBox(this)==false){return false;}getQuestion3(this," + data.data[i].id + "," + qid + ")'><span class='presentCheckbox static_label'>Present</span></div>"
                                fieldData += "</div>";

                            } else {
                                fieldData += "<input " + data.data[i].validation + " onfocusout='getQuestion3(this," + data.data[i].id + "," + qid + ")' type='text' class='form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                                if (data.data[i].existing_sid == 151) {
                                    fieldData += "<em class='static_label' style='font-size: 12px;font-style: italic;'>Press tab to continue</em>"

                                }
                            }
                        }

                        fieldData += "</div></div>";
                        fieldData += "</div>";


                    }



                    $('.parent_' + id).append(fieldData)
                    if(fieldData.includes('parent_11602'))
                    {
                        setTimeout(function () {
                            let ele=$('.parent_11602')
                            $('.parent_11602').remove()
                            $(ele).insertBefore('.parent_11891')
                        },500)

                    }



                }
                $(value).parent().children('input').prop('disabled', false)
                $(value).parent().children('select').prop('disabled', false)
                $('select').prop('disabled', false)
                $('input').prop('disabled', false)

                tagsInp()
                if (func2) {
                    formFunc(value)
                    func2 = false
                }
                valSave(value)

            }

            ,
            error: function (data) {
                $(value).parent().find('.temp').remove()
                $(value).parent().children('input').prop('disabled', false)
                $(value).parent().children('select').prop('disabled', false)
                $('#btnModal2').click()
            }
        });


    }

    function getQuestion3(value, id, qid, pid) {
        noc_job_question(value)
        if ($(value).hasClass('datepicker')) {
            if ($(value).val() == '' || date_check(value,1)==false) {
                $('.parent_' + id)
                    .children()
                    .not(':first-child')
                    .remove();
                return false
            }
        }


        afterForm()

        if ($(value).parent().find('.temp').length == 0)
            $(value).parent().append('<span class="spinner-border spinner-border-sm temp ' + disCl + '" role="status"></span>');

        $(value).parent().children('input').prop('disabled', true)
        $(value).parent().children('select').prop('disabled', true)


        var val = $(value).val();

        var ab = $('.parent_' + id).children().hasClass('multi')

        $('.parent_' + id)
            .children()
            .not(':first-child')
            .remove();

        let email = $('input[type="email"]:first').val()
        endCase = false
        let already_exists = false
        if (id !== 150) {
            $('div').each(function () {
                if ($(this).hasClass('parent_150')) {
                    already_exists = true
                }
            })
        }

        if (!already_exists) {
            if (id == 149) {
                $('.parent_151').remove()
            }
            $.ajax({
                dataType: 'json',
                url: "seoajax.php?h=getQuestion3",
                type: 'POST',
                data: {
                    'id': id,
                    'value': val,
                    'qid': qid,
                    'pid': 0,
                    'email': email //#bg70143

                },
                success: function (data) {
                    $(value).parent().find('.temp').remove()

                    if (data.Success == 'false') {
                        if (data.level == 2) {
                            let element = document.getElementById(data.val + '_' + data.id)
                            let v = '';

                            if (element == null) {
                                v = val;
                            }
                            func3 = true;
                            getQuestion2(element, data.id, data.qid, data.pid, v)
                            getQuestion4(element, data.id, data.qid, data.pid, v)

                        } else {
                            let v = '';

                            let element = document.getElementById(data.val + '_' + data.id)
                            if (element == null) {
                                v = val;
                            }
                            func2 = true
                            getQuestion2(element, data.id, data.qid, data.pid, v)
                        }
                    } else {

                        func1 = true
                        var fieldData = '';

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
                                if (id == 1290999 && $(value).val() == 'Yes') {
                                    comment_box = true
                                    if ($('#validateform').valid()) {
                                        if(custom_validation())
                                        {
                                            $('#commentModal').modal()
                                        }
                                    } else {
                                        $('#validateform').valid()
                                    }

                                    fieldData = ''
                                    continue;
                                } else {
                                    $('#validateform').submit()
                                    fieldData = ''
                                    continue;
                                }

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
                                endCase_message = 'Form has been submitted'
                            } else if (data.data[i].casetype == 'endwt') {
                                // $('#btnModal').click()
                                localStorage.setItem('EndCase', 'matched');
                                endCase = true;
                                endCase_message = 'Thank You for your interest in Canada'

                            } else if (data.data[i].casetype == 'endwc') {
                                // $('#btnModal').click()
                                localStorage.setItem('EndCase', 'matched');
                                endCase = true;
                                endCase_message = 'Congratulations and thank you for your interest in Canada'

                            } else if (data.data[i].casetype == 'endwa') {
                                // $('#btnModal').click()
                                localStorage.setItem('EndCase', 'matched');
                                endCase = true;
                                endCase_message = 'Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.'
                            } else {

                                if (data.data[i].check == 1) {
                                    fieldData += "<div class='form-group sub_question_div2 sques_" + qid + " sques_" + pid + " sques2_" + id + "' id='sub_question_div2_" + data.data[i].id + "'>"
                                    if (data.data[i].notes != '' && data.data[i].notes != null && data.data[i].field != 'pass') {

                                        fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                    }
                                    fieldData += "<label class='pb-1'>" + data.data[i].other + "</label>";
                                } else {
                                    fieldData += "<div class='form-group sub_question_div2 sques_" + qid + " sques2_" + id + "' id='sub_question_div2_" + data.data[i].id + "'>"
                                    if (data.data[i].notes != '' && data.data[i].notes != null) {

                                        fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"

                                    }

                                    fieldData += "<label class='pb-1'>" + data.data[i].question + "</label>";


                                }
                                fieldData += "<div class='input-group input-group-merge " + permission + "'>"

                                if (data.data[i].field == 'radio' && data.data[i].labeltype == 0) {

                                    let y = 'Yes'
                                    let n = 'No'

                                    if (localStorage.getItem('Lang') !== 'english') {
                                        y = static_label_changer(y)
                                        n = static_label_changer(n)
                                    }
                                    fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_2" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='Yes' " + noc_attr + "><span class='customLabel'>" + y + "</span>"
                                    fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_2" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + id + "," + '' + ")' value='No' " + noc_attr + "><span class='customLabel' >" + n + "</span>";

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
                                    fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
                                    for (var j = 0; j < (data.education).length; j++) {
                                        let c = data.education[j].name
                                        fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                                    }
                                    fieldData += "</select>"
                                } else if (data.data[i].field == 'dropdown') {
                                    fieldData += "<select " + data.data[i].validation + " class='form-control' name='n[sub_question_2" + data.data[i].id + "]'" + noc_attr + ">"
                                    fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
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

                                    fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='from'   max='" + formatted_date + "'  type='text' class='nocPicker datepicker form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                                    fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='to' onchange='position_date(this," + data.data[i].id + "," + id + ",3)'   max='" + formatted_date + "'  type='text' class='nocPicker datepicker form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
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
                        $('.parent_' + id).append(fieldData)

                        if (id != 350) {
                            if ($('.parent_' + id).length <= 1) {
                                movegroup('')
                            }
                        }
                        $(value).parent().children('input').prop('disabled', false)
                        $(value).parent().children('select').prop('disabled', false)
                        $(value).parent().children('.presCheck').children('input').prop('disabled', false)
                        formFunc(value)
                    }


                    if (endCase) {
                        if ($('#validateform').valid()) {
                            if(custom_validation())
                            {
                                $('#commentModal').modal()
                            }
                        } else {
                            $('#validateform').valid()
                        }

                    }

                }
                ,
                error: function (data) {
                    $(value).parent().find('.temp').remove()
                    $(value).parent().children('input').prop('disabled', false)
                    $(value).parent().children('select').prop('disabled', false)
                    $(value).parent().children('.presCheck').children('input').prop('disabled', false)
                    $('#btnModal2').click()
                }
            });
        } else {
            $(value).parent().find('.temp').remove()

            $(value).parent().children('input').prop('disabled', false)
            $(value).parent().children('select').prop('disabled', false)
            $(value).parent().children('.presCheck').children('input').prop('disabled', false)
            formFunc(value)
        }
        already_exists = false
        multi(id, value)
        if (func1) {
            func1 = false
        }


    }

    function getQuestion4(value, id, qid, pid, v) {
        //if(eca_check(id)==true && eca_check2(id)==true)
        {
            valSave(value)
            let b = false;

            if ($(value).parent().find('.temp').length == 0)
                $(value).parent().append('<span class="spinner-border spinner-border-sm temp ' + disCl + '" role="status"></span>');

            var val = $(value).val();
            if (value == null) {
                val = v
            }

            $('.parent_' + id)
                .children()             //Select all the children of the parent
                .not(':first-child')    //Unselect the first child
                .remove();
            let email = $('input[type="email"]:first').val();
            endCase = false

            $.ajax({
                dataType: 'json',
                url: "seoajax.php?h=getQuestion4",
                type: 'POST',
                data: {
                    'id': id,
                    'value': val,
                    'qid': qid,
                    'pid': pid,
                    'email': email //#bg70143

                },
                success: function (data) {
                    $(value).parent().find('.temp').remove()

                    {
                        var fieldData = '';

                        for (var i = 0; i < data.data.length; i++) {
                            if (eca_check(id) == false || eca_check2(id) == false) {
                                if (data.data[i].casetype == 'existing') {
                                    continue
                                }
                            }

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
                            var $row = $(value).parent();
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
                                    $('.parent_' + id)
                                        .children()             //Select all the children of the parent
                                        .not(':first-child')    //Unselect the first child
                                        .remove();
                                    break;

                                } else
                                    continue;
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
                            } else if (data.data[i].casetype == 'group') {

                                fieldData += data.data[i].group_data;
                                continue;

                            } else if (data.data[i].casetype == 'groupques') {
                                fieldData += data.data[i].group_data2;
                                continue;
                            } else if (data.data[i].casetype == 'existing') {
                                fieldData += data.data[i].existing_data;
                                continue;
                            }

                            fieldData += "<div class='parent_" + data.data[i].id + "'>"

                            if (data.data[i].casetype == 'email' && emailCount == false) {

                                emailCount = true
                                if (submission) {
                                    fieldData += "<div style='background: #d1f0d1' class='form-group level2 email sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'><label class='pb-1 static_label'>Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.</label>";

                                } else {
                                    fieldData += "<div style='background: #d1f0d1;display:none' class='form-group level2 email sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'><label class='pb-1 static_label'>Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.</label>";

                                }
                                fieldData += "</div>";
                                fieldData += "</div>"
                                continue
                            } else if (data.data[i].casetype == 'exit' || data.data[i].casetype == 'none') {
                                fieldData += "";
                                continue;
                            } else if (data.data[i].casetype == 'end') {
                                // $('#btnModal').click()
                                localStorage.setItem('EndCase', 'matched');
                                endCase = true;
                                endCase_message = 'Form has been submitted'
                            } else if (data.data[i].casetype == 'endwt') {
                                // $('#btnModal').click()
                                localStorage.setItem('EndCase', 'matched');
                                endCase = true;
                                endCase_message = 'Thank You for your interest in Canada'

                            } else if (data.data[i].casetype == 'endwc') {
                                // $('#btnModal').click()
                                localStorage.setItem('EndCase', 'matched');
                                endCase = true;
                                endCase_message = 'Congratulations and thank you for your interest in Canada'

                            } else if (data.data[i].casetype == 'endwa') {
                                // $('#btnModal').click()
                                localStorage.setItem('EndCase', 'matched');
                                endCase = true;
                                endCase_message = 'Your request for assistance has been submitted. You will be contacted by email to connect you with a qualified professional who can assist you.'
                            } else {

                                if (data.data[i].check == 1) {
                                    fieldData += "<div class='form-group sub_question_div2 sques_" + qid + " sques_" + pid + " sques2_" + id + "' id='sub_question_div2_" + data.data[i].id + "'>"
                                    if (data.data[i].notes != '' && data.data[i].notes != null && data.data[i].field != 'pass') {

                                        fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"


                                    }
                                    fieldData += "<label class='pb-1'>" + data.data[i].other + "</label>";
                                } else {
                                    fieldData += "<div class='form-group sub_question_div2 sques_" + qid + " sques2_" + id + "' id='sub_question_div2_" + data.data[i].id + "'>"
                                    if (data.data[i].notes != '' && data.data[i].notes != null) {

                                        fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"


                                    }

                                    fieldData += "<label class='pb-1'>" + data.data[i].question + "</label>";


                                }
                                fieldData += "<div class='input-group input-group-merge " + permission + "'>"

                                if (data.data[i].field == 'radio' && data.data[i].labeltype == 0) {
                                    let y = 'Yes'
                                    let n = 'No'

                                    if (localStorage.getItem('Lang') !== 'english') {
                                        y = static_label_changer(y)
                                        n = static_label_changer(n)
                                    }
                                    fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_2" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + qid + "," + '' + ")' value='Yes' " + noc_attr + "><span class='customLabel'>" + y + "</span>"
                                    fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_2" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + qid + "," + '' + ")' value='No' " + noc_attr + "><span class='customLabel'>" + n + "</span>";

                                } else if (data.data[i].field == 'radio' && data.data[i].labeltype == 1) {
                                    fieldData += data.data[i].radios;
                                } else if (data.data[i].field == 'calender') {
                                    fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                                } else if (data.data[i].field == 'age') {
                                    fieldData += "<input " + data.data[i].validation + " type='text' class='form-control datepicker age' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                                    fieldData += "<input type='text' class='form-control dob' readonly hidden name='dob*" + data.data[i].id + "'>"

                                } else if (data.data[i].field == 'email') {
                                    fieldData += "<input " + data.data[i].validation + " type='email' class='form-control' name='n[sub_question_2" + data.data[i].id + "]'>";
                                } else if (data.data[i].field == 'phone') {
                                    fieldData += "<input " + data.data[i].validation + " type='tel'   minlength='6' maxlength='15' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                                } else if (data.data[i].field == 'country') {
                                    fieldData += "<select " + data.data[i].validation + " class='form-control countryCheck' onchange='getQuestion3(this," + data.data[i].id + ")' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">"
                                    fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
                                    for (var j = 0; j < (data.country).length; j++) {
                                        let c = data.country[j].name
                                        fieldData += "<option value='" + data.country[j].value + "' >" + c + "</option>";

                                    }
                                    fieldData += "</select>"
                                } else if (data.data[i].field == 'education') {
                                    fieldData += "<select " + data.data[i].validation + " class='education form-control' onchange='getQuestion3(this," + data.data[i].id + ")' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">"
                                    fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
                                    for (var j = 0; j < (data.education).length; j++) {
                                        let c = data.education[j].name
                                        fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                                    }
                                    fieldData += "</select>"
                                } else if (data.data[i].field == 'dropdown') {
                                    fieldData += "<select " + data.data[i].validation + " class='form-control' onchange='getQuestion3(this, " + data.data[i].id + ")' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">"
                                    fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
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

                                    fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='from'   max='" + formatted_date + "'  type='text' class='nocPicker datepicker form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                                    fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='to' onchange='position_date(this," + data.data[i].id + "," + qid + ",3)'   max='" + formatted_date + "'  type='text' class='nocPicker datepicker form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                                    fieldData += "</div>";

                                } else {
                                    fieldData += "<input " + data.data[i].validation + " onfocusout='getQuestion3(this," + data.data[i].id + "," + qid + ")' type='text' class='form-control' name='n[sub_question_2" + data.data[i].id + "]' " + noc_attr + ">";
                                }
                            }

                        }

                        if (id==624 || id==647 || id==667  || id==689 || id==712) {
                            let job_check=job_offer_check(id,0)
                            if(!job_check)
                            {
                                $('.parent_724').remove()
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
                            if(!job_check)
                            {
                                $('.parent_383').remove()
                            }
                            if(job_check)
                            {
                                if($('.parent_383').length <= 0)
                                {
                                    $('.main_parent_84').append(fieldData)
                                }
                            }
                        }
                        else {
                            $('.parent_' + id).append(fieldData)

                        }

                        movegroup('')
                        $(value).parent().children('input').prop('disabled', false)
                        $(value).parent().children('select').prop('disabled', false)
                        if (func3) {
                            formFunc(value)
                            func3 = false
                        }
                    }
                    if (endCase) {
                        if ($('#validateform').valid()) {
                            if(custom_validation())
                            {
                                $('#commentModal').modal()
                            }
                        } else {
                            $('#validateform').valid()
                        }

                    }

                }
                ,
                error: function (data) {
                    $(value).parent().find('.temp').remove()
                    $(value).parent().children('input[type="radio"]').prop('disabled', false)
                    $(value).parent().children('select').prop('disabled', false)
                    $('#btnModal2').click()
                }
            });
        }
    }

    function getQuestion5(value, id, pid, cuuent_id) {
        valSave(value)
        if ($(value).parent().find('.temp').length == 0)
            $(value).parent().append('<span class="spinner-border spinner-border-sm temp ' + disCl + '" role="status"></span>');

        var val = $(value).val();
        var cls = $(value).parent('div').parent('div').parent('div').attr('class')


        var qID = 0;
        let email = $('input[type="email"]:first').val()
        $.ajax({
            dataType: 'json',
            url: "seoajax.php?h=getQuestion5",
            type: 'POST',
            data: {
                'id': id,
                'value': val,
                'email': email //#bg70143
            },
            success: function (data) {

                $(value).parent().find('.temp').remove()
                var fieldData = '';
                let new_id=0;

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
                    qID = data.data[i].question_id;

                    fieldData += "<div class='multi parent_" + data.data[i].id + "'>"
                    fieldData += "<div class='form-group sub_question_div sques_" + id + "' id='sub_question_div_" + data.data[i].id + "'>"
                    if (data.data[i].notes != '' && data.data[i].notes != null) {
                        fieldData += "<p class='notesPara'>" + data.data[i].notes + " </p>"
                    }
                    fieldData += "<label class='pb-1'>" + data.data[i].question + "</label>";

                    fieldData += "<div class='input-group input-group-merge " + permission + "'>"

                    if (data.data[i].field == 'radio' && data.data[i].labeltype == 0) {

                        let y = 'Yes'
                        let n = 'No'

                        if (localStorage.getItem('Lang') !== 'english') {
                            y = static_label_changer(y)
                            n = static_label_changer(n)
                        }
                        fieldData += "<input " + data.data[i].validation + " id='Yes_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + data.data[i].question_id + "," + '' + ")' value='Yes' " + noc_attr + "><span class='customLabel'>" + y + "</span>"
                        fieldData += "<input id='No_" + data.data[i].id + "' type='radio' class='radioButton' name='n[sub_question_" + data.data[i].id + "]' onClick='getQuestion3(this," + data.data[i].id + "," + data.data[i].question_id + "," + '' + ")' value='No' " + noc_attr + "><span class='customLabel'>" + n + "</span>";


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
                        fieldData += "<select " + data.data[i].validation + " class='form-control countryCheck' onchange='getQuestion3(this," + data.data[i].id + " , " + data.data[i].question_id + ")' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                        fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
                        for (var j = 0; j < (data.country).length; j++) {
                            let c = data.country[j].name
                            fieldData += "<option value='" + data.country[j].value + "' >" + c + "</option>";
                        }
                        fieldData += "</select>"
                    } else if (data.data[i].field == 'education') {
                        fieldData += "<select " + data.data[i].validation + " class='education form-control' onchange='getQuestion3(this," + data.data[i].id + "," + data.data[i].question_id + ")' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                        fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
                        for (var j = 0; j < (data.education).length; j++) {
                            let c = data.education[j].name
                            fieldData += "<option value='" + data.education[j].value + "' >" + c + "</option>";
                        }
                        fieldData += "</select>"
                    } else if (data.data[i].field == 'dropdown') {
                        fieldData += "<select " + data.data[i].validation + " class='form-control' onchange='getQuestion3(this," + data.data[i].id + "," + data.data[i].question_id + ")' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                        fieldData += "<option value='' disabled selected class='static_label'>--Select--</option>";
                        fieldData += data.data[i].dropdown;
                        fieldData += "</select>"
                    } else if (data.data[i].field == 'nocjob') {
                        fieldData += "<input " + data.data[i].validation + " class='" + data.data[i].validation + " form-control nocJobs' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                    } else if (data.data[i].field == 'nocduty') {
                        fieldData += "<input " + data.data[i].validation + " class='" + data.data[i].validation + " form-control nocPos' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">"
                    } else if (data.data[i].field == 'pass') {
                        fieldData += "<label class='notesPara2'>" + data.data[i].notes + "</label>"
                    } else if (data.data[i].field == 'number') {
                        fieldData += "<input " + data.data[i].validation + "  type='number' class='form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";

                    } else if (data.data[i].field == 'currentrange') {
                        let current_datetime = new Date()
                        let m = ((current_datetime.getMonth() + 1) >= 10) ? (current_datetime.getMonth() + 1) : '0' + (current_datetime.getMonth() + 1);
                        let d = ((current_datetime.getDate()) >= 10) ? (current_datetime.getDate()) : '0' + (current_datetime.getDate());
                        let formatted_date = current_datetime.getFullYear() + "-" + m + "-" + d
                        fieldData += "<label class='pb-date static_label'>From</label><label class='pb-date static_label'>To</label>"

                        fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='from'   max='" + formatted_date + "'  type='text' class='nocPicker datepicker form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                        fieldData += "<input autocomplete='off' " + data.data[i].validation + " data-date='YYYY-MM-DD' data-id='to' onchange='position_date(this," + data.data[i].id + "," + question_id + ",3)'   max='" + formatted_date + "'  type='text' class='nocPicker datepicker form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                        fieldData += "</div>";

                    } else {
                        fieldData += "<input " + data.data[i].validation + " type='text' onfocusout='getQuestion3(this," + data.data[i].id + "," + data.data[i].question_id + ")' class='form-control' name='n[sub_question_" + data.data[i].id + "]' " + noc_attr + ">";
                        fieldData += "<em class='static_label' style='font-size: 12px;font-style: italic;'>Press tab to continue</em>"
                    }
                    fieldData += "</div>";
                    fieldData += "</div>";
                    fieldData += "</div>";

                    new_id=data.data[i].id
                }

                $('.parent_'+id).remove()
                if (qID == 544) {

                    $(fieldData).insertBefore('.parent_12909')

                    valSave(value)

                }
                else
                {
                    $('.main_parent_' + qID).append(fieldData)
                }

                formFunc(value)
                $('.terms1').hide()


            }
            ,
            error: function (data) {
                $(value).parent().find('.temp').remove()
                $(value).parent().children('input[type="radio"]').prop('disabled', false)
                $(value).parent().children('select').prop('disabled', false)
                $('#btnModal2').click()
            }
        });

    }

    function getQuestion6(id, type, ques_id) {

        let email = $('input[type="email"]:first').val()
        $.ajax({
            dataType: 'json',
            url: "seoajax.php?h=getQuestion6",
            type: 'POST',
            data: {
                'id': id,
                'questiontype': type,
                'ques_id': ques_id,
                'email': email //#bg70143
            },
            success: function (data) {
                // $('.'+data.class).remove()
                if(id==573)
                {
                    if(custom_validation())
                    {
                        $('#commentModal').modal()
                    }
                }
                else
                {
                    $('.formDiv').append(data.data[0].html)

                }
                formFunc()
                tagsInp()
                $('#preloader').hide()
                $('.score_loading').html('')

            }
            ,
            error: function (data) {
                $('#btnModal2').click()
            }


        });

    }

    function eca_check(id) {
        if (id == 586 || id == 594 || id == 573 || id == 595 || id == 582 || id == 598) {
            let divs_count = 0;
            let no_count = 0;

            let div_class = ''
            $('div').each(function () {
                div_class = ($(this).attr('class'))
                if (div_class !== undefined) {
                    if (div_class.includes('parent')) {
                        let div_class2 = div_class.split('_')
                        let check = eca_user_array.indexOf(parseInt(div_class2[1]))
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
                return true
            }

            return false
        } else {
            return true
        }
    }
    function eca_check2(id) {
        if (id == 187 || id == 186 || id == 183 || id == 176 || id == 191 || id == 192 || id == 195 || id == 197) {
            let divs_count = 0;
            let no_count = 0;

            let div_class = ''
            $('div').each(function () {
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
                return true
            }

            return false
        } else {
            return true
        }
    }

    function job_offer_check(id,user) {

        let divs_count = 0;
        let no_count = 0;
        let div_class = ''
        $('div').each(function () {
            div_class = ($(this).attr('class'))
            if (div_class !== undefined) {
                if (div_class.includes('parent')) {
                    let div_class2 = div_class.split('_')
                    let check = job_user_array.indexOf(parseInt(div_class2[1]))

                    if(user==0)
                    {
                        check = job_user_array.indexOf(parseInt(div_class2[1]))

                    }
                    else
                    {
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
        if (no_count == divs_count) {
            return true
        }

        return false

    }


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

            if (bbb == true && hiddenQues[k]==74) {
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
        if (name != undefined || name != '') {
            name = name.split('_')
            name2 = name[1].slice(0, -1)
        }
        for (let k = 0; k < checkField.length; k++) {

            if (name2 == checkQues[k]) {
                let c = checkOp[k];

                if (check_cond(y, c, checkValue[k])) {
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

    function multi(current_id, vv) {
        if (current_id == 71 || current_id == 70) {
            if ($(vv).parent().parent().parent().attr('class') == 'parent_' + current_id) {
                return false;
            }
        }

        var count1 = 0;
        let sid = [];
        let sid_to_remove = [];

        let main_questions=[]
        var current_id2 = 0;
        let op = [];
        let op2= [];

        var sval = 0;
        var mQues = 0;

        // loop to get ID of a question to be appeared
        for (let i = 0; i < localStorage.length; i++) {
            if (current_id == localStorage.getItem('ex_sid-' + i) || current_id == localStorage.getItem('ex_qid-' + i) || current_id == localStorage.getItem('mainQues-' + i))
            {
                if (sid[i - 1] == localStorage.getItem('sid-' + i) && op[i-1] == localStorage.getItem('andor-' + i)) {
                    continue;
                } else {
                    // sid[i] = localStorage.getItem('sid-' + i);
                    op[i] = localStorage.getItem('andor-' + i);
                    // if(sid.indexOf(localStorage.getItem('sid-' + i)) < 0)
                    {
                        sid[i] = localStorage.getItem('sid-' + i);

                    }
                    if(main_questions.indexOf(localStorage.getItem('mainQues-' + i)) < 0)
                    {
                        main_questions[i]=localStorage.getItem('mainQues-' + i)

                    }

                }

            }
        }

        // loop to get ID of questions to be disappeared
        for (let i = 0; i < localStorage.length; i++) {
            if (current_id == localStorage.getItem('ex_sid-' + i) || current_id == localStorage.getItem('ex_qid-' + i) || current_id == localStorage.getItem('mainQues-' + i))
            {
                continue
            }

            if (sid_to_remove[i - 1] == localStorage.getItem('sid-' + i) && op2[i-1] == localStorage.getItem('andor-' + i)) {
                continue;
            } else {
                //if(sid_to_remove.indexOf(localStorage.getItem('sid-' + i)) < 0)
                {
                    sid_to_remove[i] = localStorage.getItem('sid-' + i);

                }
                op2[i] = localStorage.getItem('andor-' + i);
            }
        }

        // loop to check condition is satisfied
        for (let i = 0; i < sid.length; i++) {
            let div_id=localStorage.getItem('mainQues-' + i)

            if($('.main_parent_'+div_id).length < 1 || current_id==sid[i])
            {
                continue
            }
            for (let j = 0; j < localStorage.length; j++) {
                let element = '';
                let local_value=localStorage.getItem('value-' + j) // question's value
                let local_sid=localStorage.getItem('sid-' + j) // question's ID to be appeared
                let local_op=localStorage.getItem('op-' + j) // operator to match the values

                let existing_sid=localStorage.getItem('ex_sid-' + j) // sub question ID
                let existing_qid=localStorage.getItem('ex_qid-' + j) // main question ID

                let mainQuestion = localStorage.getItem('mainQues-' + j) // question's ID that has a multicondition


                if (existing_sid != 0)
                    element = document.getElementsByName('n[sub_question_' + existing_sid + ']')
                else
                    element = document.getElementsByName('n[question_' + existing_qid + ']')

                if (element.length <= 0) {
                    continue
                }

                let element_type=$(element).attr('type')
                let element_value=$(element).val()
                let radio_type_value=''
                if(element_value!=='' && element_value!==null && element_value!==undefined)
                {
                    element_value=element_value.trim()
                }
                if(local_value!=='' && local_value!==null && local_value!==undefined)
                {
                    local_value=local_value.trim()
                }
                if(element_type=='radio')
                {
                    if($(element).eq(0).prop('checked'))
                    {
                        radio_type_value='Yes'
                    }
                    else if($(element).eq(1).prop('checked'))
                    {
                        radio_type_value='No'
                    }

                    if(local_value == 'None' && local_sid == sid[i] && radio_type_value!=='')
                    {

                        count1++;
                        sval = local_value
                        if (existing_sid == 0) {
                            current_id2 = existing_qid
                        } else {
                            current_id2 = existing_sid
                        }
                        mQues = mainQuestion

                    }
                    else if (check_cond(radio_type_value,local_op,local_value)&& local_sid == sid[i]) {

                        count1++;
                        sval = local_value
                        if (existing_sid == 0) {
                            current_id2 = existing_qid
                        } else {
                            current_id2 = existing_sid
                        }
                        mQues = mainQuestion
                    }
                }
                else
                {

                    if (check_cond(element_value,local_op,local_value) &&  local_sid== sid[i]) {

                        count1++;
                        sval = local_value
                        if (existing_sid == 0) {
                            current_id2 = existing_qid
                        } else {
                            current_id2 = existing_sid
                        }
                        mQues = mainQuestion

                    }

                }


            }

            if (count[sid[i]] !== undefined) {
                if ((op[i] == 'or' && count1 > 0) || (op[i] != 'or' && count1 == count[sid[i]])) {
                    let sval2 = document.getElementsByName('n[sub_question_' + current_id + ']')
                    getQuestion5(sval2.item(0), sid[i], current_id2, current_id)
                } else {
                    $('.parent_' + sid[i]).remove();
                }
                // console.log('loop1')
                // console.log(count[sid[i]] + '-' + count1 + '-' + sid[i] + '-' + mQues + '-' +op[i])
                count1 = 0;

            }


        }

        // loop to check condition is not satisfied
        for (let i = 0; i < sid_to_remove.length; i++) {
            let div_id=localStorage.getItem('mainQues-' + i)

            if($('.main_parent_'+div_id).length < 1 || current_id==sid_to_remove[i])
            {
                continue
            }
            for (let j = 0; j < localStorage.length; j++) {
                let element = '';
                let local_value=localStorage.getItem('value-' + j) // question's value
                let local_sid=localStorage.getItem('sid-' + j) // question's ID to be appeared
                let local_op=localStorage.getItem('op-' + j) // operator to match the values

                let existing_sid=localStorage.getItem('ex_sid-' + j) // sub question ID
                let existing_qid=localStorage.getItem('ex_qid-' + j) // main question ID

                let mainQuestion = localStorage.getItem('mainQues-' + j) // question's ID that has a multicondition


                if (existing_sid != 0)
                    element = document.getElementsByName('n[sub_question_' + existing_sid + ']')
                else
                    element = document.getElementsByName('n[question_' + existing_qid + ']')

                if (element.length <= 0) {
                    continue
                }

                let element_type=$(element).attr('type')
                let element_value=$(element).val()
                let radio_type_value=''
                if(element_value!=='' && element_value!==null && element_value!==undefined)
                {
                    element_value=element_value.trim()
                }

                if(element_type=='radio')
                {
                    if($(element).eq(0).prop('checked'))
                    {
                        radio_type_value='Yes'
                    }
                    else if($(element).eq(1).prop('checked'))
                    {
                        radio_type_value='No'
                    }

                    if(local_value == 'None' && local_sid == sid_to_remove[i] && radio_type_value!=='')
                    {
                        count1++;
                        sval = local_value
                        if (existing_sid == 0) {
                            current_id2 = existing_qid
                        } else {
                            current_id2 = existing_sid
                        }
                        mQues = mainQuestion

                    }
                    else if (check_cond(radio_type_value.trim(),local_op,local_value.trim())&& local_sid== sid_to_remove[i]) {
                        count1++;
                        sval = local_value
                        if (existing_sid == 0) {
                            current_id2 = existing_qid
                        } else {
                            current_id2 = existing_sid
                        }
                        mQues = mainQuestion
                    }
                }
                else
                {
                    if (check_cond(element_value,local_op,local_value) &&  local_sid== sid_to_remove[i]) {

                        count1++;
                        sval = local_value
                        if (existing_sid == 0) {
                            current_id2 = existing_qid
                        } else {
                            current_id2 = existing_sid
                        }
                        mQues = mainQuestion

                    }

                }


            }

            if (count[sid_to_remove[i]] !== undefined) {
                if ((op2[i] == 'or' && count1 > 0) || (op2[i] != 'or' && count1 == count[sid_to_remove[i]])) {

                } else {
                    if(op2[i] !== 'or')
                    {
                        $('.parent_' + sid_to_remove[i]).remove();

                    }
                }
                // console.log('loop2')
                // console.log(count[sid_to_remove[i]] + '-' + count1 + '-' + sid_to_remove[i] + '-' + mQues + '-' +op2[i])
                count1 = 0;

            }


        }

    }

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
            let msg='Please Describe'
            let name=$(e).attr('name')+'2'
            if(localStorage.getItem('Lang')!='english')
            {
                msg=static_label_changer(msg)
            }
            if (dClas == 'parent_' + n) {
                $(e).parent().append('<em class="newCountry static_label">'+msg+'</em><input name="'+name+'" type="text" class="form-control newCountry" style="margin-top: 2%;">')

            } else {
                $(e).parent().parent().append('<em class="newCountry static_label">'+msg+'</em><input name="'+name+'" type="text" class="form-control newCountry" style="margin-top: 2%;">')

            }
        }
    }

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
                .children()             //Select all the children of the parent
                .not(':first-child')    //Unselect the first child
                .remove();
            valSave(e)
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
        let snc = '', unc = ''





        if (s == 'off') {
            if (noc_user == 'spouse') {
                nocSpouse[index] = ''

            } else {
                nocUser[index] = ''

            }
        } else {


            if (noc_flag == '1') {

                if (date_pos == 'from') {
                    fromDate = $(e).val()
                    let dd = $(e).next().attr('data-def')
                    if (dd == 'Present') {
                        dd = new Date()
                        cemp = 1;

                    }
                    else
                    {
                        dd=$(e).next().val()
                    }

                    toDate = dd
                } else {
                    let dd = $(e).attr('data-def')
                    if (dd == 'Present') {
                        dd = new Date()
                        cemp = 1;

                    }
                    else
                    {
                        dd=$(e).val()
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
                            if(fromDate=='' && $(e).next('input').val()!=='')
                            {
                                $(e).blur()
                                let error_msg='You cannot remove the date'
                                let error_title='Error'

                                if (localStorage.getItem('Lang') !== 'english') {
                                    error_msg = static_label_changer(error_msg)
                                    error_title =static_label_changer(error_title)

                                }
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
                            if(fromDate=='' && $(e).next('input').val()!=='')
                            {
                                $(e).blur()
                                let error_msg='You cannot remove the date'
                                let error_title='Error'

                                if (localStorage.getItem('Lang') !== 'english') {
                                    error_msg = static_label_changer(error_msg)
                                    error_title =static_label_changer(error_title)

                                }
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
                if( exp < 0 && $(e).next('input').val()!=='' && fromDate!=='' && $(e).next('input').val()!==undefined && fromDate!==undefined)
                {
                    $(e).blur()
                    let error_msg='Experience cannot be less than 0'
                    let error_title='Error'

                    if (localStorage.getItem('Lang') !== 'english') {
                        error_msg = static_label_changer(error_msg)
                        error_title =static_label_changer(error_title)
                    }
                    make_toast('danger', error_title, error_msg)
                    $(e).datepicker("hide");
                    if (date_pos == 'from')
                    {
                        if (noc_user == 'spouse') {
                            $(e).val(nocSpouse[index]['sdate'])
                        }
                        else
                        {
                            $(e).val(nocUser[index]['sdate'])
                        }
                    }
                    else
                    {
                        if (noc_user == 'spouse') {
                            $(e).val(nocSpouse[index]['edate'])
                        }
                        else
                        {
                            $(e).val(nocUser[index]['edate'])
                        }
                    }
                    $(e).parent().children('input').prop('disabled', false)
                    $(e).parent().children('select').prop('disabled', false)
                    $(e).parent().children('.presCheck').children('input').prop('disabled', false)
                    return false
                }
                if( exp < 0 || $(e).prev('input').val()=='' || toDate=='' || toDate==undefined)
                {

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

    function presentBox(e) {
        if ($(e).prop("checked") == false) {
            $(e).parent().parent().parent().parent().children().not(':first-child')    //Unselect the first child
                .remove();        //Select all the children of the parent

            return false;
        }
        let dis = $(e).parent().parent().children('input[data-id="to"]')
        let prev = $(dis).prev().val()
        if (prev === '' || prev === null) {
            let error_msg = 'Please select from date first'
            let error_title='Error'

            if (localStorage.getItem('Lang') !== 'english') {
                error_msg = static_label_changer(error_msg)
                error_title =static_label_changer(error_title)

            }
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

    function tagsInp() {

        if (localStorage.getItem('Lang') == 'english') {
            nocCalling('500');
        } else {
            setTimeout(function () {
                nocCalling('500');
            }, 1000);
        }


    }

    function nocCalling(delay) {
        $('div.nocJobs , div.nocPos').select2('destroy');

        $('.nocJobs').select2({
            data: nocJobs(),
            delay: delay,
            placeholder: '-Select-',
            multiple: false,
            allowClear: true,
            required: true,
            // creating query with pagination functionality.
            query: function (data) {

                var pageSize,
                    dataset,
                    that = this;
                pageSize = 20; // Number of the option loads at a time
                results = [];
                if (data.term && data.term !== '') {
                    // HEADS UP; for the _.filter function I use underscore (actually lo-dash) here
                    results = _.filter(that.data, function (e) {
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
            placeholder: '-Select-',
            delay: delay,
            multiple: false,
            allowClear: true,

            query: function (data) {
                var pageSize,
                    dataset,
                    that = this;
                pageSize = 20; // Number of the option loads at a time
                results = [];
                if (data.term && data.term !== '') {
                    // HEADS UP; for the _.filter function I use underscore (actually lo-dash) here
                    results = _.filter(that.data, function (e) {
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

        setTimeout(function () {
            $('input.nocJobs').each(function () {
                let val2 = $('div.nocJobs').children().children().html()
                let nocJob = $(this).val()
                let val = $(this).attr('name')
                if (nocJob != '' && nocJob != null) {
                    let val1 = val.split('_')
                    let id = val1[2].slice(0, -1)
                    $("#sub_question_div_" + id + " .select2-chosen").html(nocJob)
                }

            })
            $('input.nocPos').each(function () {
                let val2 = $('div.nocPos').children().children().html()
                let nocJob = $(this).val()
                let val = $(this).attr('name')
                if (nocJob !== '' && nocJob !== null) {
                    let val1 = val.split('_')
                    let id = val1[2].slice(0, -1)
                    $("#sub_question_div_" + id + " .select2-chosen").html(nocJob)
                }


            })

            $(".errorReq").each(function () {
                if (!$(this).hasClass('topError')) {
                    $(this).addClass('topError');
                }
            });

        }, delay)
    }

    function education_searchable()
    {
        $('.education').each(function (index) {
            let req = $(this).attr('required')
            let val = $(this).val()
            let txt = $(this).find(":selected").text()

            if ($ (this).prev('div').hasClass ( "select2-container" ))
            {
            }
            else
            {
                if($(this).is("select")) {
                    $(this).select2()
                    $(this).prev('div').children('a').children('span.select2-chosen').html(txt)
                }

            }
        });
    }
    function checkDate(e) {
        let dt = $(e).attr('data-id')
        if ($(e).next('label.error').length > 0) {
            $(e).next('label.error').remove()
        }
        // setTimeout(function () {
        if (dt == 'to') {
            let from_date = new Date($(e).prev('input[type="text"]').val());
            let to_date = new Date($(e).val());
            if (to_date < from_date) {

                let error_msg = 'This date is smaller than previous.'
                let error_title='Error'

                if (localStorage.getItem('Lang') !== 'english') {
                    error_msg = static_label_changer(error_msg)
                    error_title =static_label_changer(error_title)

                }
                make_toast('danger',error_title , error_msg)
                $(e).parent().children('input').prop('disabled', false)
                $(e).parent().children('select').prop('disabled', false)
                $(e).parent().children('.presCheck').children('input').prop('disabled', false)
                $(e).parent().parent().parent()
                    .children()             //Select all the children of the parent
                    .not(':first-child')    //Unselect the first child
                    .remove();
                $(e).val('')
                return false

            } else if (from_date == 'Invalid Date') {
                let error_msg = 'Please select from date first'
                let error_title='Error'

                if (localStorage.getItem('Lang') !== 'english') {
                    error_msg = static_label_changer(error_msg)
                    error_title =static_label_changer(error_title)

                }
                localStorage.removeItem($(e).attr('name'))
                localStorage.removeItem($(e).prev().attr('name'))
                $(e).parent().children('input').prop('disabled', false)
                $(e).parent().children('select').prop('disabled', false)
                $(e).parent().children('.presCheck').children('input').prop('disabled', false)
                make_toast('danger', error_title, error_msg)

                $(e).parent().parent().parent()
                    .children()             //Select all the children of the parent
                    .not(':first-child')    //Unselect the first child
                    .remove();
                $(e).val('')
                return false
            } else if ($(e).val() == '' || $(e).parent().next('label.error').length > 0) {
                $(e).parent().parent().parent()
                    .children()             //Select all the children of the parent
                    .not(':first-child')    //Unselect the first child
                    .remove();
                return false
            } else {
                return true
            }

        } else if (dt == 'from') {
            let from_date = new Date($(e).val());
            let to_date = new Date($(e).next('input[type="text"]').val());
            if (from_date > to_date) {
                let error_msg = 'This date is greater than next.'
                let error_title='Error'

                if (localStorage.getItem('Lang') !== 'english') {
                    error_msg = static_label_changer(error_msg)
                    error_title =static_label_changer(error_title)

                }
                make_toast('danger', error_title, error_msg)
                $(e).parent().children('input').prop('disabled', false)
                $(e).parent().children('select').prop('disabled', false)
                $(e).parent().children('.presCheck').children('input').prop('disabled', false)
                $(e).val('')
                return false

            } else {
                return true
            }
        }
        // },1000)

    }

    $(document).on('change', '.required', function () {
        if ($(this).prev('.select2-container').children('.select2-chosen').html() != '-Select-') {
            $(this).prev('.select2-container').prev('label.errorReq').remove();
        }
    });


    function error_check() {

        let target = ''
        if ($('label.error').length > 0) {

            $("label.error").each(function () {
                if ($(this).css('display') == 'block') {

                    target = $(this)
                    return false;
                }
            });
            if (target !== '' && target !== null) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 200
                }, 2000);
                let error_msg = 'Something important is missing, please fill all the fields and submit again.'
                let error_title='Error'

                if (localStorage.getItem('Lang') !== 'english') {
                    error_msg = static_label_changer(error_msg)
                    error_title =static_label_changer(error_title)

                }
                make_toast('danger', error_title, error_msg)

                return false

            }
        }
    }

    function custom_validation()
    {
        let no_error=true
        $(".age").each(function () {
            if (date_check($(this),0) == false) {
                $('html, body').animate({
                    scrollTop: $(this).offset().top - 200
                }, 2000);
                $(this).css('pointer-events', 'all')

                let error_msg = 'You have entered an invalid date. Please update and submit again.'
                let error_title='Error'

                if (localStorage.getItem('Lang') !== 'english') {
                    error_msg = static_label_changer(error_msg)
                    error_title =static_label_changer(error_title)

                }
                make_toast('danger', error_title, error_msg)
                no_error=false
            }
        });

        if(no_error)
            return true
        else
            return false

    }

    function date_check(e,flag) {
        let dateVal = $(e).val()
        let date_year = new Date(dateVal)
        let attr = $(this).attr('required');
        date_year = date_year.getFullYear()
        dateVal = dateVal.split('-')
        let sDate = dateVal[0] + "/" + dateVal[1] + "/" + dateVal[1]
        let enteredDate = sDate
        let check_years = new Date(new Date() - new Date(enteredDate)).getFullYear() - 1970;

        if ((typeof attr !== undefined && attr !== false && attr!=='undefined' && attr !== undefined) || flag==1) {

            if (check_years > 121 || dateVal[0] != date_year) {

                if ($(e).parent().parent().children('label.error').length <= 0 && $(e).val() !== '' && $(e).next('label.error').length <= 0) {
                    let error_msg='Invalid date'
                    if (localStorage.getItem('Lang') !== 'english') {
                        error_msg = static_label_changer(error_msg)
                    }
                    $(e).parent().parent().append('<label class="error">'+error_msg+'</label>')
                }
                return false
            } else {
                $(e).parent().parent().children('label.error').remove()
            }
        }

    }

    function check_endCase() {
        let error_msg=''
        if (localStorage.getItem('EndCase') != '') {
            error_msg='Are you sure you want to edit?'
        } else {
            error_msg='Are you sure you want to edit ? Once you edit, scoring will re-initiate'

        }

        if (localStorage.getItem('Lang') !== 'english') {
            error_msg = static_label_changer(error_msg)
        }
        $('#editLabel').html(error_msg)
    }

    function static_label_changer(label) {
        for (let i = 0; i < ArrLabels.length; i++) {
            if (ArrLabels[i].value === label || ArrLabels[i].value2 === label || ArrLabels[i].value3===label) {
                label = ArrLabels[i].name
                if(label==='' || label===null)
                {
                    label=ArrLabels[i].value2
                }
                break
            }
        }
        return label
    }

    $('#validateform').validate({
        errorPlacement: function (error, element) {
            if (element.attr("type") == "radio") {
                error.appendTo(element.parent('div.input-group'));
            } else {
                error.insertAfter(element);

            }
            let v = error[0].innerHTML

            if (localStorage.getItem('Lang') !== 'english') {
                v = static_label_changer(v)
            }
            error[0].innerHTML = v
        },
        invalidHandler: function (event, validator) {
            // 'this' refers to the form

            var errors = validator.numberOfInvalids();
            if (errors) {
                error_check()
                setTimeout(function(){
                    $("label.error").each(function () {
                        let target =$(this)
                        if ($(this).css('display') == 'block') {

                            target = $(this)
                            let v = target[0].innerHTML

                            if (localStorage.getItem('Lang') !== 'english') {
                                v = static_label_changer(v)
                            }
                            target[0].innerHTML = v
                        }
                    });
                },1000)
                $('#preloader').hide()
            }

        },

        submitHandler: function () {
            'use strict';
            $('label.errorReq').remove();
            $('label.error').remove();

            let date_error = false
            let position_error = false
            $(".age").each(function () {
                if (date_check($(this),0) == false) {
                    date_error = true
                    $('html, body').animate({
                        scrollTop: $(this).offset().top - 200
                    }, 2000);
                    $(this).css('pointer-events', 'all')

                    let error_msg = 'You have entered an invalid date. Please update and submit again.'
                    let error_title='Error'

                    if (localStorage.getItem('Lang') !== 'english') {
                        error_msg = static_label_changer(error_msg)
                        error_title =static_label_changer(error_title)

                    }
                    make_toast('danger', error_title, error_msg)
                }
            });

            let namechecker = ''
            $(".nocPicker").each(function () {
                if ($(this).attr('name') !== namechecker) {
                    let d = document.getElementsByName($(this).attr('name'))
                    let v = 'This field is required.'
                    var attr = $(this).attr('required');

                    if (typeof attr !== typeof undefined && attr !== false) {

                        if (localStorage.getItem('Lang') !== 'english') {
                            v = static_label_changer(v)

                        }
                        if ($(d).eq(0).val() !== '' && $(d).eq(1).val() == '') {
                            $(d).eq(1).after('<label class="errorReq error">' + v + '</label>');
                            position_error = true
                        }
                    }
                    namechecker = $(this).attr('name')
                }

            });
            let select_msg = '--Select--'
            let select_msg2 = '-Select-'

            if (localStorage.getItem('Lang') !== 'english') {
                select_msg = static_label_changer(select_msg)
            }
            $(".select2-container").each(function () {

                console.log('"'+$(this).children().children('.select2-chosen').html() +'"=="'+ select_msg+'"')
                if ($(this).next('input').hasClass('required') || $(this).next('select').attr('required')) {
                    if ($(this).children().children('.select2-chosen').html() == select_msg2 || $(this).children().children('.select2-chosen').html() == select_msg || $(this).children().children('.select2-chosen').html() == 'null') {
                        let v = 'This field is required.'
                        if (localStorage.getItem('Lang') !== 'english') {
                            v = static_label_changer(v)
                        }
                        $(this).after('<label class="errorReq error">' + v + '</label>');
                    } else {
                        $(this).next('label.errorReq').remove();
                    }
                }
                else {

                }

            });
            if (date_error == true || position_error == true) {
                if (position_error) {
                    var $target = $(".errorReq:first");
                    $('html, body').animate({
                        scrollTop: $target.offset().top - 200
                    }, 2000);
                    $('#preloader').hide()

                }

                let error_msg = 'Something important is missing, please fill all the fields and submit again.'
                let error_title='Error'

                if (localStorage.getItem('Lang') !== 'english') {
                    error_msg = static_label_changer(error_msg)
                    error_title =static_label_changer(error_title)

                }
                make_toast('danger', error_title, error_msg)
                return false
            }
            else if ($(".errorReq").length > 0) {
                var $target = $(".errorReq:first");
                $('html, body').animate({
                    scrollTop: $target.offset().top - 200
                }, 2000);
                $('#preloader').hide()

                let error_msg = 'Something important is missing, please fill all the fields and submit again.'
                let error_title='Error'

                if (localStorage.getItem('Lang') !== 'english') {
                    error_msg = static_label_changer(error_msg)
                    error_title =static_label_changer(error_title)

                }
                make_toast('danger', error_title, error_msg)
            }
            else {
                // alert('submitted')
                // return false

                if (localStorage.getItem('EndCase') == 'matched') {
                    endCase = true;
                }
                let loader_msg = 'Calculating Score'
                if (endCase == false) {
                    loader_msg = 'Calculating Score'
                } else {
                    loader_msg = 'Processing'
                }
                if (localStorage.getItem('Lang') !== 'english') {
                    loader_msg = static_label_changer(loader_msg)
                }
                $('.score_loading').html(loader_msg);
                $('#preloader').css('display', 'block');

                $('.forbidden').children('input').css('pointer-events', 'none')
                $('.forbidden').children('select').css('pointer-events', 'none')
                $('.forbidden').children('div.presCheck').children('input').css('pointer-events', 'none')

                $('.permitted').children('div.presCheck').children('input').css('pointer-events', 'none')
                $('.permitted').children('input').css('pointer-events', 'none')
                $('.permitted').children('select').css('pointer-events', 'none')

                let email = $('input[type="email"]:first').val()
                let phone = $('input[type="tel"]:first').val()
                let name = $('input[type="text"]').eq(1).val()
                let token = '<?php if (isset($_GET['code'])) echo $_GET['code']; else echo ''; ?>'

                let dob = [];

                var assistance_ids = '';
                var assistance = '<ul>';
                $('.email').each(function (i, obj) {
                    let p = $(this).parent().parent().children('div').children('label').html()
                    let level = ''
                    if ($(this).hasClass('level2')) {
                        level = 2
                    } else {
                        level = 1
                    }
                    let cls = $(this).parent().parent().attr('class').split(' ')
                    let id1 = cls[0].split('_')
                    assistance += '<li>' + p + '</li>'
                    if (id1[1] == 'parent') {
                        assistance_ids += id1[2] + '-' + level + ',';

                    } else {
                        assistance_ids += id1[1] + '-' + level + ',';

                    }
                });

                $(".age").each(function () {
                    let dateVal = $(this).val()
                    dateArray[dateCheck] = dateVal
                    dateVal = dateVal.split('-')
                    let sDate = dateVal[0] + "/" + dateVal[1] + "/" + dateVal[2]
                    let enteredDate = sDate
                    let y = new Date(new Date() - new Date(enteredDate)).getFullYear() - 1970;
                    $(this).val(y)
                    dateCheck++;
                });

                let formData = $('.myForm').serializeArray()

                $(".age").each(function () {
                    $(this).val(dateArray[dateCheck2])
                    dateCheck2++;
                });
                $(".dob").each(function () {
                    let name = $(this).attr('name')
                    name = name.split('*')
                    dob[name[1]] = $(this).val()
                });


                $("input,select,textarea").each(function() {

                    if($(this).is("[type='checkbox']") || $(this).is("[type='radio']")) {
                        $(this).attr("checked", $(this).is(":checked"));
                    }

                    else if($(this).prop("tagName") == "SELECT")
                    {
                        $(this).find('option[value="'+ $(this).val()+'"]').attr('selected',true);
                    }
                    else {
                        $(this).attr("value", $(this).val());
                    }
                });
                pending_submission = true;

                setTimeout(function () {
                    $.ajax({
                        dataType: 'json',
                        url: "seoajax.php?h=submitForm",
                        type: 'POST',
                        async: false,
                        data: {
                            'form': formData,
                            'formHtml': $('.myForm').html(),
                            'dob': dob,
                            'email': email,
                            'assistance': assistance_ids,
                            'phone': phone,
                            'name': name,
                            'nocUser': nocUser,
                            'spouseUser': nocSpouse,
                            'scoreID': $('#scoreID').val(),
                            'scoreArray': scoreArray,
                            'nocArray': nocArray,
                            'scoreArray2': scoreArray2,
                            'spouseScoreArray': spouseScoreArray,
                            'spouseScoreArray2': spouseScoreArray2,
                            'spouseNocScore': spouseNocScore,
                            'rType': rType,
                            'userGrades': userGrades,
                            'spouseGrades': spouseGrades,
                            'casesArray': casesArray,
                            'token': token,
                            'endCase': endCase,
                            'removeIdentical': removeIdentical,
                            'comment': $('#com').val()

                        },

                        success: function (data) {
                            localStorage.setItem('Submission', 'true');
                            submission = true;
                            pending_submission = false;

                            userGrades = data.userGrades;
                            spouseGrades = data.spouseGrades
                            spouseNocScore = data.spouseNocScore
                            casesArray = data.casesArray
                            removeIdentical = data.removeIdentical
                            $('.scroll-edit').show();

                            $('.terms1').hide()
                            if (data.Success == 'ques') {
                                $("#btnLoader").html('Re-Submit');

                                getQuestion6(data.question.move_qid, data.question.move_qtype, data.question.q_id)
                                $('#scoreID').val(data.question.scoreID);
                                scoreArray = data.scoreArray;
                                scoreArray2 = data.scoreArray2;
                                spouseScoreArray = data.spouseScoreArray;
                                spouseScoreArray2 = data.spouseScoreArray2;
                                nocArray = data.nocArray;
                                rType = 'question';
                            } else if (data.Success == 'noc_ques') {

                                $("#btnLoader").html('Re-Submit');

                                if (data.question.conditionn == "scoring") {
                                    $('#scoreID').val(data.question.move_scoreType);
                                    rType = 'scoring';
                                    scoreArray = data.scoreArray;
                                    scoreArray2 = data.scoreArray2;
                                    spouseScoreArray = data.spouseScoreArray;
                                    spouseScoreArray2 = data.spouseScoreArray2;
                                    nocArray = data.nocArray;
                                    $('.myForm').submit();

                                } else {
                                    getQuestion6(data.question.move_qid, data.question.move_qtype, data.question.q_id)
                                    $('#scoreID').val(data.question.scoreID);
                                    rType = 'question';
                                    scoreArray = data.scoreArray;
                                    scoreArray2 = data.scoreArray2;
                                    spouseScoreArray = data.spouseScoreArray;
                                    spouseScoreArray2 = data.spouseScoreArray2;
                                    nocArray = data.nocArray;
                                }
                            } else if (data.Success == 'scoring') {
                                $("#btnLoader").html('Re-Submit');

                                $('#scoreID').val(data.question.move_scoreType);
                                scoreArray = data.scoreArray;
                                scoreArray2 = data.scoreArray2;
                                spouseScoreArray = data.spouseScoreArray;
                                spouseScoreArray2 = data.spouseScoreArray2;
                                nocArray = data.nocArray;
                                rType = 'scoring';
                                $('.myForm').submit();
                            } else if (data.Success == 'comment') {
                                $("#btnLoader").html('Re-Submit');
                                $('#scoreID').val(data.question.scoreID);
                                scoreArray = data.scoreArray;
                                scoreArray2 = data.scoreArray2;
                                spouseScoreArray = data.spouseScoreArray;
                                spouseScoreArray2 = data.spouseScoreArray2;
                                nocArray = data.nocArray;
                                rType = 'comment';

                                let ht = '<div class="afterSub"><div class="form-group form-group sub_question_div2 ">';
                                if (localStorage.getItem('Lang') !== 'english') {
                                    ht += '<label>' + data.question.comments_french + '</label>';

                                } else {

                                    ht += '<label>' + data.question.comments + '</label>';

                                }
                                ht += '</div></div>';
                                $('.formDiv').append(ht)
                                $('.myForm').submit();
                            } else if (data.Success == 'true') {
                                $('.forbidden').children('input').css('pointer-events', 'none')
                                $('.forbidden').children('select').css('pointer-events', 'none')
                                $('.forbidden').children('div.presCheck').children('input').css('pointer-events', 'none')

                                $('.permitted').children('div.presCheck').children('input').css('pointer-events', 'none')
                                $('.permitted').children('input').css('pointer-events', 'none')
                                $('.permitted').children('select').css('pointer-events', 'none')

                                $('#preloader').hide()
                                $('.score_loading').html('')
                                $('#scoreID').val('')
                                $('#sform_id').val(data.sfrom_id)
                                $('#com').val('')
                                if (endCase) {
                                    if (localStorage.getItem('Lang') !== 'english') {
                                        endCase_message = static_label_changer(endCase_message)
                                    }

                                    $('#subModalBody').html(endCase_message)
                                } else {

                                    let m = 'Form has been submitted'
                                    if (localStorage.getItem('Lang') !== 'english') {
                                        m = static_label_changer(m)
                                    }
                                    $('#subModalBody').html(m)

                                }
                                $('#submitModal').modal()
                            } else {
                                $('.forbidden').children('input').css('pointer-events', 'none')
                                $('.forbidden').children('select').css('pointer-events', 'none')
                                $('.forbidden').children('div.presCheck').children('input').css('pointer-events', 'none')

                                $('.permitted').children('div.presCheck').children('input').css('pointer-events', 'none')
                                $('.permitted').children('input').css('pointer-events', 'none')
                                $('.permitted').children('select').css('pointer-events', 'none')
                                $(window).scrollTop(0);
                                let error_msg = 'There was a problem. Try to submit again'
                                let error_title='Error'

                                if (localStorage.getItem('Lang') !== 'english') {
                                    error_msg = static_label_changer(error_msg)
                                    error_title =static_label_changer(error_title)

                                }
                                make_toast('danger', error_title, error_msg)

                                // $( '.prompt2' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + error_msg + '</div>' );
                                // setTimeout( function () {
                                //     $( "div.prompt2" ).html('');
                                // }, 5000 );
                            }
                            isShown = false

                        }
                        ,
                        error: function (data) {
                            $('#preloader').hide()
                            $('.score_loading').html('')

                            $(window).scrollTop(0);
                            let error_msg = 'There was a problem. Try to submit again'
                            let error_title='Error'

                            if (localStorage.getItem('Lang') !== 'english') {
                                error_msg = static_label_changer(error_msg)
                                error_title =static_label_changer(error_title)

                            }
                            make_toast('danger', error_title, error_msg)

                            // $( '.prompt2' ).html( '<div class="alert alert-danger" style="text-align:left !important"><i class="fas fa-times" style="margin-right:10px;"></i>' + data.Msg + '</div>' );
                            // setTimeout( function () {
                            //     $( "div.prompt2" ).html('');
                            // }, 5000 );
                        }


                    });
                    return false;
                }, 1000)

            }


        }
    });

    $('#yesBtn1').click(function () {

        $('.btnModal').click()
    })
    var final_submit = false
    $('#yesBtn3').click(function () {
        $('.btnModal').click()
        final_submit = true
        $('#validateform').submit()
    })

    $('#yesBtn2').click(function () {
        $('.permitted').children('input').css('pointer-events', 'auto')
        $('.permitted').attr('title', 'This question is permitted')
        $('.permitted').children('select').css('pointer-events', 'auto')
        $('.permitted').children('div.presCheck').children('input').css('pointer-events', 'auto')

        if(localStorage.getItem('EndCase')!=='matched')
        {
            $('#btnLoader').show()
            $('#lastBox').show()
        }


        $('.afterSub').remove()
        $('#scoreID').val('')

        $('.btnModal').click()
        $('.scroll-edit').hide()
        submission = false
        isShown = false

    })

    $('#yesBtn4').click(function () {
        if(change1)
        {
            let element=document.getElementsByName('n[question_73]')
            $(element).eq(0).prop('checked',false)
            $(element).eq(1).prop('checked',false)
        }
        getQuestion(temp_val,temp_id,temp_pid)
        $('.closeModal').click()
        movegroup4(temp_val)
        temp_val='';
        temp_id='';
        temp_pid='';

        change1=false
        change2=false
        no_change=false
    })
    $('#noBtn4').click(function () {


        let name=$(changed_element).attr('name')
        if(previous_country===null || previous_country==='')
        {
            $('select[name="'+name+'"] option:first').prop('selected', true);

        }
        else
        {
            $('select[name="'+name+'"] option[value="'+previous_country+'"]').prop('selected', true);

        }
        // if(no_change==true && previous_country=='Canada')
        // {
        //     $('select[name="'+name+'"] option:first').prop('selected', true);
        // }
        valSave(changed_element)
        changed_element=''
        change1=false
        change2=false
        no_change=false
        $('.closeModal').click()
    })
    ///==================local storage work========================

    $(document).ready(function () {

        $('label.errorReq').remove();
        if (localStorage.getItem('AgreeCheck') == 1) {
            $(".unChecked").each(function () {
                $(this).show()
                $(this).removeClass('unChecked');
            })
            setTimeout(function () {
                $("#iAgree").remove();

            }, 500)
        }
        $('.terms1').hide()
        if (!localStorage.getItem('oldFlag')) {
            localStorage.setItem('oldFlag', 0)
            localStorage.setItem('newFlag', 0)
        }

        $('input,textarea').attr('autocomplete', 'off');

        let form_id =<?php echo $_GET['id']; ?>;
        if (localStorage.getItem('form_' + form_id)) {
            $('.myForm').html('')
            $('.myForm').html(localStorage.getItem('form_' + form_id))
            $('body').css('opacity', 0.5)
            $('#formLoader').show()
        }

        $('.errorReq').remove();
        $('label.error').remove()
        $('span.temp').remove()
        $('input').prop('disabled', false)
        $('select').prop('disabled', false)
        if (localStorage.getItem('Submission') == 'true') {
            $(".scroll-edit").show();
        }
    })

    $(document).on('keyup', 'input', function () {
        valSave(this)
    });
    $(document).on('change', 'select[name="is_email"]', function () {
        $('#btnModal').click()
    })


    // #bg70143 start


    $(document).on("change", "input[name='n[question_109]']", function () {
        everyChangeFunction();
    })

    // this function is called when any little change take effect
    function everyChangeFunction() {

        $position1PresentCheck = ($(".main_parent_110").children('.form-group').children(".input-group").children(".presCheck").children("input"));

        var fulltimeExperiencyCheck = ($("input[name='n[question_109]']:checked").val());

        $("input[name='n[question_110]']").each(function () {
            $(this).parent().children('label.error').remove()
            if ($(this).attr("data-id") == "from") {
                $fromInput = $(this);
                if (fulltimeExperiencyCheck == "Yes") {
                    $fromInput.attr("required", true);
                    $fromInput.prop("required", true);
                } else {
                    $fromInput.attr("required", false);
                    $fromInput.prop("required", false);
                }
            } else {
                $toInput = $(this);

                if (fulltimeExperiencyCheck == "Yes") {
                    if ($position1PresentCheck.is(":checked")) {
                        $toInput.attr("required", false);
                        $toInput.prop("required", false);
                    } else {
                        $toInput.attr("required", true);
                        $toInput.prop("required", true);
                    }

                } else {
                    $toInput.attr("required", false);
                    $toInput.prop("required", false);
                }


            }

        });


    }

    // #bg70143 end
    function removeLocalStorageValues()
    {

        for (var key in localStorage) {
            if (key !== 'newFlag' && key !== 'oldFlag' && key !== 'oldLang' && key !== 'Lang' && key !== 'display' && key !== 'nocSpouse' && key !== 'nocUser' && key !== 'userGrades' && key !== 'spouseGrades' && key !== 'AgreeCheck' && key !== 'EndCase' && key !== 'Submission' && key !== 'Submission') {
                if (key[0] == 'n') {

                    let element = document.getElementsByName(key)
                    if (element.length > 0) {

                        if (element[0].nodeName.toLowerCase() === 'select') {
                            ///console.log('select')
                        }
                        if (element[0].nodeName.toLowerCase() === 'input') {
                            if($(element).attr('type')=='radio')
                            {
                                let y=$(element).eq(0).prop('checked')
                                let n=$(element).eq(1).prop('checked')

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

                            }
                            else
                            {

                            }
                        }

                    } else {
                        let key2=''
                        if(key.includes('from'))
                        {
                            key2 = key.replace(" from", "");
                            let element = document.getElementsByName(key2)
                            if (element.length > 0)
                            {
                                continue
                            }
                            else
                            {
                                localStorage.removeItem(key)
                                localStorage.removeItem(key2)
                            }
                        }
                        else
                        {
                            localStorage.removeItem(key)

                        }
                    }

                }

            }
        }
    }

    function valSave(e) {
        removeLocalStorageValues()
        localStorage.setItem('EndCase', '');
        emailCount = false
        let dt = $(e).attr('data-id')
        let ex = ''
        if (dt == 'from') {
            ex = ' from'
        }
        let val = $(e).val();
        let id = $(e).attr('name')
        localStorage.setItem(id + ex, val);
        // formFunc('')
        if (nocUser.length > 0)
            localStorage.setItem('nocUser', JSON.stringify(nocUser))
        if (nocSpouse.length > 0)
            localStorage.setItem('nocSpouse', JSON.stringify(nocSpouse))


        // if($(e).attr('name')=='n[question_544]')
        // {
        //     education_searchable();
        // }
        // else
        {
            setTimeout(function () {
                education_searchable();
            },500)
        }

    }

    var isShown = false;

    function formFunc(e) {

        genFormHtml();


        let form_id =<?php echo $_GET['id']; ?>;
        let v = $('.myForm').html()

        try {
            localStorage.setItem('form_' + form_id, v);

        } catch (e) {
            Storage.prototype._setItem = Storage.prototype.setItem;
            Storage.prototype.setItem = function () {
            };
        }

        callLabelDir();

        if (localStorage.getItem('display') == 'Right to Left') {
            $('.input-group-merge').addClass('urduField')
            $('.static_label').addClass('urduField')
            $('.scroll-edit').removeClass('urduField')
            $('.btnModal2').removeClass('urduField')
            $('.btnModal').removeClass('urduField')
            $('.alert').addClass('urduCheckBox')
            $('.custom-checkbox').addClass('urduCheckBox')


        }

        else {
            $('.input-group-merge').removeClass('urduField')
            $('.static_label').removeClass('urduField')
            $('.custom-checkbox').removeClass('urduCheckBox')
            $('.alert').removeClass('urduCheckBox')
            $('.custom-checkbox').removeClass('urduCheckBox')



        }
        // button check
        buttonCheck(e);
        changeStaticLabels();
        country_optional();
    }

    function country_optional() {
        $('.countryCheck').each(function (index) {
            let req = $(this).attr('required')
            let val = $(this).val()
            let txt = $(this).find(":selected").text()
            if (req === undefined) {
                if (val === null || val === '') {
                    let msg='--optional--'
                    if(localStorage.getItem('Lang')!=='english')
                    {
                        msg=static_label_changer(msg)
                    }
                    $(this).find(":selected").text(msg)
                }
            }
        });
    }

    function buttonCheck(e) {
        let current_div = $(e).parent().parent().parent().attr('class')
        let current_div2 = $(e).parent().parent().html()

        let last_div = $('.form-group').parent('div').last().attr('class')
        let lDiv = $('.form-group').parent('div').last().html()
        let eDiv = $('.form-group').last().attr('class')
        let totalDivs = $('.form-group').length
        let last_div2 = $('.form-group').last().html()
        let last_index = 0;
        $(".form-group").each(function (index) {
            last_index = index;
        });

        if (!endCase) {

            // if((current_div===last_div || (lDiv=='' || lDiv==null) || current_div=='main_parent_117' || eDiv.includes('email') ) )
            if ((current_div === last_div || (lDiv == '' || lDiv == null) || current_div == 'main_parent_117')) {
                if (current_div !== 'parent_724') {
                    if (!last_div.includes('afterSub')) {
                        btnCheck = true
                        isShown = true;
                        $('.terms1').show()
                    }
                }
            } else {
                if (!isShown) {
                    btnCheck = false
                    $('.terms1').hide()
                }


            }
        }

    }

    function changeStaticLabels() {
        $('.static_label').each(function () {
            for (var j = 0; j < ArrLabels.length; j++) {
                let innerHtml = $(this).html()

                if (innerHtml.includes('&amp;')) {
                    innerHtml = innerHtml.replace('&amp;', '&')
                }

                if (localStorage.getItem('Lang') !== 'english') {
                    if (innerHtml == ArrLabels[j].value || innerHtml == ArrLabels[j].value2 || innerHtml == ArrLabels[j].value3) {
                        if (ArrLabels[j].name !== '' && ArrLabels[j].name !== null) {
                            $(this).html(ArrLabels[j].name)
                        }
                    }
                } else {
                    if (innerHtml == ArrLabels[j].value || innerHtml == ArrLabels[j].value2 || innerHtml == ArrLabels[j].value3) {
                        if (ArrLabels[j].name !== '' && ArrLabels[j].name !== null) {
                            $(this).html(ArrLabels[j].name)
                        }
                    }
                }

            }
        })
        if(localStorage.getItem('AgreeCheck')==0)
        {
            $('#formLoader').hide()

        }
        changeErrorLabels();

    }

    function changeErrorLabels() {

        $('label.error').each(function () {
            for (var j = 0; j < ArrLabels.length; j++) {
                if (ArrLabels[j].name !== '' && ArrLabels[j].value !== '') {
                    let innerHtml = $(this).html()

                    if (innerHtml.includes('&amp;')) {
                        innerHtml = innerHtml.replace('&amp;', '&')
                    }

                    if (localStorage.getItem('Lang') !== 'english') {
                        if (innerHtml == ArrLabels[j].value || innerHtml == ArrLabels[j].value2 || innerHtml == ArrLabels[j].value3) {
                            $(this).html(ArrLabels[j].name)
                        }
                    } else {
                        if (innerHtml == ArrLabels[j].value || innerHtml == ArrLabels[j].value2 || innerHtml == ArrLabels[j].value3) {
                            $(this).html(ArrLabels[j].name)
                        }
                    }
                }
            }
        })

    }

    $(document).on('focusout', 'input, select', function () {
        changeErrorLabels();
    })

    setTimeout(function () {
        $("div").each(function () {
            if ($(this).hasClass('afterSub')) {
                $('.scroll-edit').show()

                $('.afterSub').remove();
            }
        })
        let q;
        for (var key in localStorage) {
            if (key !== 'newFlag' && key !== 'oldFlag' && key !== 'oldLang' && key !== 'Lang' && key !== 'display' && key !== 'nocSpouse' && key !== 'nocUser' && key !== 'userGrades' && key !== 'spouseGrades' && key !== 'AgreeCheck' && key !== 'EndCase' && key !== 'Submission' && key !== 'Submission') {
                if (key[0] == 'n') {
                    let k = key.split('_')
                    let k2;
                    let value = localStorage[key]
                    let type = jQuery('[name="' + key + '"]').attr('type')

                    if (k.length > 2) {
                        k2 = k[2].slice(0, -1);
                    } else {
                        k2 = k[1].slice(0, -1);
                        q = k2
                    }
                    if (type == 'radio') {

                        // document.getElementById(value + '_' + k2).checked = true;
                        if (document.getElementsByName(key).length > 0) {
                            if (value == 'Yes') {
                                document.getElementsByName(key)[0].checked = true;

                            } else {
                                document.getElementsByName(key)[1].checked = true;

                            }
                        }
                    } else {

                        if (key.includes('from')) {
                            let key2 = key.replace(" from", "");
                            let d = document.getElementsByName(key2)
                            if (document.getElementsByName(key2).length > 0) {
                                document.getElementsByName(key2)[0].value = value;

                            }
                            continue
                        }
                        if (value == 'Present' || ($('input[name="' + key + '"]').eq(1)).attr('data-def')=="Present") {
                            $('input[name="' + key + '"]').parent().children('div').children('input').attr('checked', 'checked');
                        }

                        if (localStorage.hasOwnProperty(key + " from")) {
                            $('[name="' + key + '"]').eq(1).val(value);
                        } else {
                            $('[name="' + key + '"]').val(value);
                        }
                    }
                } else if (key[0] == 'd') {
                    let value = localStorage[key]
                    $('[name="' + key + '"]').val(value);
                }
                $('[name="dob*30"]').val($('[name="n[question_30]"]').val());
                $('[name="dob*61"]').val($('[name="n[question_61]"]').val());

                $('body').css('opacity', 1)
                if (localStorage.getItem('oldFlag') == localStorage.getItem('newFlag')) {

                }

            }
        }
        var nameCheck=''
        $('.nocPicker').each(function () {
            if ($(this).attr('name') !== nameCheck) {
                let d = document.getElementsByName($(this).attr('name'))

                if($(d).eq(1).attr('data-def')!=='Present')
                {
                    $(d).eq(1).next('div').children('input').prop('checked',false)
                }
                nameCheck = $(this).attr('name')
            }

        })
    }, 2000);
    setTimeout(function () {


        formFunc('');
        if (localStorage.getItem('nocUser') != '' && localStorage.getItem('nocUser') != null)
            nocUser = JSON.parse(localStorage.getItem('nocUser'))
        if (localStorage.getItem('nocSpouse') != '' && localStorage.getItem('nocSpouse') != null)
            nocSpouse = JSON.parse(localStorage.getItem('nocSpouse'))
        if (localStorage.getItem('userGrades') != '' && localStorage.getItem('userGrades') != null)
            userGrades = JSON.parse(localStorage.getItem('userGrades'))
        if (localStorage.getItem('spouseGrades') != '' && localStorage.getItem('spouseGrades') != null)
            spouseGrades = JSON.parse(localStorage.getItem('spouseGrades'))
    }, 4000);

    setTimeout(function () {
        try {
            $('div.nocJobs , div.nocPos').select2('destroy');
            $('div.nocJobs ,div.nocPos').remove();

            // if($('.education').length > 0) {
            //     $('div.education').select2('destroy')
            //     $('div.education').remove()
            // }

        } catch (e) {
            //console.log(e)
        }

    }, 2000);

    setTimeout(function () {

        $('body').css('opacity', 1)
        $('#validateform').show();

        tagsInp();
        // if($('.education').length > 0)
        // {
        //     $('.education').select2()
        //     $('div.education').css("display", 'block');
        // }



        $("div.nocJobs,div.nocPos").css("display", 'block');
        //CHanging the values of static labels
        changeStaticLabels()

    }, 4000);



    $(".submit").click(function () {
        return false;
    });


    function callTranslations() {
        // Change Values of Questions
        console.log(123)
        var elements = document.getElementsByTagName("label");
        for (var i = 0; i < elements.length; i++) {
            var valueLabel = '';
            if (elements[i].value == "") {
            } else {
                if (localStorage.getItem('Lang') == 'english') {
                    valueLabel = (elements[i].innerHTML).trim();
                    for (var loop = 0; loop < quesArr.length; loop++) {
                        if (quesArr[loop].label_translation == valueLabel || quesArr[loop].label_old == valueLabel) {
                            if (quesArr[loop].label !== '') {
                                elements[i].innerHTML = quesArr[loop].label;
                            }
                            break;
                        }
                    }
                }
                else if (localStorage.getItem('Lang') !== 'english') {
                    valueLabel = (elements[i].innerHTML).trim();
                    for (var loop = 0; loop < quesArr.length; loop++) {
                        if (quesArr[loop].label_old == valueLabel || quesArr[loop].label == valueLabel ) {
                            if (quesArr[loop].label_translation !== '' ) {
                                elements[i].innerHTML = quesArr[loop].label_translation;
                            }
                            break;
                        }

                    }
                }
            }
        }

        // Change values of Notes
        $("form#validateform p.notesPara").each(function () {
            var spanLabel = ($(this).text()).trim();
            if (spanLabel == "") {
            } else {
                if (localStorage.getItem('Lang') == 'english') {
                    for (var loop = 0; loop < notesArr.length; loop++) {
                        if (notesArr[loop].notes_translation == spanLabel || notesArr[loop].notes_old == spanLabel) {
                            if (notesArr[loop].notes !== '') {
                                $(this).html(notesArr[loop].notes);
                            }
                            break;
                        }
                    }
                } else if (localStorage.getItem('Lang') !== 'english') {
                    for (var loop = 0; loop < notesArr.length; loop++) {
                        if (notesArr[loop].notes == spanLabel || notesArr[loop].notes_old == spanLabel) {
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
        $("form#validateform span.customLabel").each(function () {
            var spanLabel = ($(this).text()).trim();
            if (spanLabel == "") {
                //alert(spanLabel);
            } else {
                if (localStorage.getItem('Lang') == 'english') {
                    var string = $(this).text();
                    var index = valuesArr.indexOf(string.trim());
                    if((optionsArr[index] !== '' && index > -1)){
                        $(this).html(optionsArr[index]);
                    }else{
                        var index = oldValues.indexOf(string.trim());
                        if((optionsArr[index] !== '' && index > '-1')){
                            $(this).html(optionsArr[index]);
                        }else{
                            // var index = extraArr.indexOf(string.trim());
                            // if((valuesArr[index] !== '' && index > -1)){
                            //     $(this).html(optionsArr[index]);
                            // }
                            // else
                            {
                                $(this).html(string);
                            }
                        }

                    }
                } else if (localStorage.getItem('Lang') !== 'english') {
                    var string = $(this).text();
                    var index = optionsArr.indexOf(string.trim());

                    if((valuesArr[index] !== '' && index > -1)){
                        $(this).html(valuesArr[index]);
                    }else{
                        var index = oldValues.indexOf(string.trim());
                        if((valuesArr[index] !== '' && index > -1)){

                            $(this).html(valuesArr[index]);
                        }else{
                            // var index = extraArr.indexOf(string.trim());
                            // if((valuesArr[index] !== '' && index > -1)){
                            //     $(this).html(valuesArr[index]);
                            // }
                            // else
                            {
                                $(this).html(string);
                            }
                        }

                    }
                }

            }
        });


        //Change Values of Dropdown Options
        var selectCount = 0;
        $("form#validateform select").each(function () {
            var selectValue = $(this).val();
            if ($(this).hasClass("countryCheck")) {
                $(this).find('option:not(:first)').remove();
                var country = '';
                for (var j = 0; j < ArrCountry.length; j++) {
                    if(ArrCountry[j].value!=='' && ArrCountry[j].value!==null)
                    {
                        country += '<option value="' + ArrCountry[j].value + '">' + ArrCountry[j].name + '</option>';
                    }
                }
                $(this).append(country);
                $(this).val(selectValue);

                selectCount++;
            }
            else if ($(this).hasClass("education")) {
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
            }
            else
            {
                $("select option").each(function () {
                    if (!$(this).parent().hasClass("countryCheck") && !$(this).parent().hasClass("education") && $(this).parent().attr('name')!=='language-picker-select') {
                        var spanLabel = '';
                        if($(this).attr('data-id'))
                        {
                            spanLabel = ($(this).attr('data-id')).trim();
                        }
                        var spanLabel2 = $(this).text();

                        if (spanLabel == "") {
                        } else {
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
                                        let sp=static_label_changer(spanLabel2)
                                        $(this).text(sp);
                                    } else {
                                        $(this).text($(this).attr('data-id'));
                                    }
                                }

//								var loopIndex = 1;
//                                for (var loop = 0; loop < optionsArr.length; loop++) {
//                                    var string = $(this).val();
//
//                                    if (string == optionsArr[loop].opt) {
//                           				$(this).text(optionsArr[loop].opt_translation);
//                                        break;
//                                    } else {
//										if(loopIndex == optionsArr.length){
//											if (spanLabel == '-- optional --' || spanLabel == '--Select--') {
//
//											} else {
//												$(this).text($(this).val());
//											}
//										}
//
//                                    }
//
//									loopIndex++;
//
//                                }
                            }
                        }
                    }
                });
            }

        });


        if (localStorage.getItem('display') == 'Right to Left') {
            $("form#validateform input[type='radio']").each(function () {
                $(this).parent().addClass('urduField');
            });
        }
        else {
            $("form#validateform input[type='radio']").each(function () {
                $(this).parent().removeClass('urduField');
            });
        }

        setTimeout(function () {
            let form_id =<?php echo $_GET['id']; ?>;
            let v = $('.myForm').html()
            localStorage.setItem('form_' + form_id, v);
            $('#formLoader').hide();
        }, 3000)
    }

    function callLabelDir() {
        if (localStorage.getItem('display') == 'Right to Left') {
            $("form#validateform select").each(function () {
                $("form#validateform select").attr('dir', 'rtl');
            });
        } else {
            $("form#validateform select").each(function () {
                $("form#validateform select").removeAttr('dir', 'rtl');
            });
        }


        if (localStorage.getItem('display') == 'Right to Left') {
            $("form#validateform input[type='radio']").each(function () {
                $(this).parent().addClass('urduField');
            });
        } else {
            $("form#validateform input[type='radio']").each(function () {
                $(this).parent().removeClass('urduField');
            });
        }
    }

    function nocJobs() {
        return _.map(_.range(0, jobLen), function (i) {
            return {
                id: i,
                text: jobsArr[i],
            };
        });
    }

    function nocPos() {
        return _.map(_.range(0, dutyLen), function (i) {
            return {
                id: i,
                text: dutyArr[i],
            };
        });
    }

    // $(document).ready(function(){
    //
    //     $(".prevDiv").css('display','none');
    //
    //     var divsLength = $("form#validateform .form-group").length;
    //     divsCl = Math.ceil(divsLength/9);
    //     localStorage.setItem('divsCl',divsCl);
    //
    //     if(divsCl > 1){
    //         $(".nextDiv").css('display','inline-block');
    //     }
    //
    //     console.log('Total Form Steps: '+divsCl);
    //
    //     let l = 0;
    //     $("form#validateform .form-group").each(function(){
    //         if(l%9 == 1){
    //             frmGroup++;
    //             $(this).addClass("formStep"+frmGroup);
    //         }else{
    //             $(this).addClass("formStep"+frmGroup);
    //         }
    //         l++;
    //     });
    //
    //     $(".formStep0").addClass("formStep1");
    //     $(".formStep1").removeClass("formStep0");
    //     $(".formStep1").css('display','block');
    //
    //     var cT = 2;
    //     for(var c = 1 ; c <= divsCl ; c++){
    //         $("form#validateform .formStep"+cT).each(function(){
    //             $(this).css('display','none');
    //         });
    //
    //         cT++;
    //     }
    //     step = 1;
    //
    //
    // });
    //
    //
    // var divsCl = 0;
    // frmGroup = 0;
    // let step = 0 , stepIn = 0;
    // let quesCall = 0 , newStep = 0;
    // var showStep = 0 ;
    // var curStep = 0;
    //
    // function onQuesCall(){
    //     if(quesCall > 0 ){
    //         var divsLength = $("form#validateform .form-group").length;
    //         newStep = Math.ceil(divsLength/9);
    //         // if(newStep > 1){
    //         // 	$(".nextDiv").css('display','inline-block');
    //         // }
    //         console.log('Total Form Steps: '+newStep);
    //         var c = 1 , lC = 0;
    //
    //         if(newStep > 1){
    //             for (c = 1; c <= newStep ; c++){
    //                 $("form#validateform .formStep"+c).each(function(){
    //                     if($(this).css('display')=='block')
    //                     {
    //                         curStep=c
    //                     }
    //                     $(this).removeClass('formStep'+c);
    //                     console.log('Step--'+c+' Removed');
    //                 });
    //             }
    //         }
    //
    //         if(newStep > localStorage.getItem('divsCl')){
    //             localStorage.setItem('divsCl',newStep);
    //             // step++;
    //         }
    //
    //         console.log('Old Step Was : '+step);
    //
    //         let l = 0 , frmGroup = 0;
    //         $("form#validateform .form-group").each(function(){
    //             if(l%9 == 1){
    //                 frmGroup++;
    //                 $(this).addClass("formStep"+frmGroup);
    //             }else{
    //                 $(this).addClass("formStep"+frmGroup);
    //             }
    //             l++;
    //             //$(".form-group:lt(9)").css("display","block");
    //         });
    //         $(".formStep0").addClass("formStep1");
    //         $(".formStep1").removeClass("formStep0");
    //
    //         if(newStep > 2){
    //             $(".prevDiv").css('display','inline-block');
    //
    //             var cT = 1;
    //             console.log('newstep--'+newStep)
    //             for(var c = 1 ; c <= newStep ; c++){
    //                 $("form#validateform .formStep"+cT).each(function(){
    //                     console.log('Step--'+cT+' Hidden')
    //                     $(this).css('display','none');
    //                 });
    //                 cT++;
    //
    //             }
    //
    //         }
    //
    //         if(newStep == localStorage.getItem('divsCl')){
    //             $(".nextDiv").css('display','inline-block');
    //             //$("#lastBox").css('display','flex');
    //             console.log('yess')
    //         }
    //         // else{
    //         // 	$(".nextDiv").css('display','inline-block');
    //         // 	//$("#lastBox").css('display','none');
    //         // }
    //
    //         console.log('stp-'+step)
    //
    //         if(newStep < step){
    //             stepIn = step - 1;
    //         }else{
    //             stepIn = step;
    //         }
    //         $("form#validateform .formStep"+curStep).each(function(){
    //             $(this).css('display','block');
    //         });
    //         console.log('Step-N:'+newStep+' | Step-O:'+stepIn);
    //         if(newStep == stepIn){
    //             $(".nextDiv").css('display','none');
    //         }else{
    //             $(".nextDiv").css('display','inline-block');
    //         }
    //
    //
    //     }
    //     quesCall++;
    //
    // }
    //
    // $(document).on('click','.nextDiv',function(){
    //     console.log('Step -- '+step);
    //
    //     if($("#validateform").valid()){
    //
    //         $("form#validateform .formStep"+step).each(function(){
    //             $(this).css('display','none');
    //         });
    //         step++;
    //
    //         console.log('Moved To Steps: '+step);
    //         window.scrollTo(0, 0);
    //         if(step >= 1){
    //             $(".prevDiv").css('display','inline-block');
    //         }
    //         if(step == localStorage.getItem('divsCl')){
    //             $(".nextDiv").css('display','none');
    //             $("#lastBox").css('display','flex');
    //         }
    //         else{
    //             $(".nextDiv").css('display','inline-block');
    //             $("#lastBox").css('display','none');
    //         }
    //         $("form#validateform .formStep"+step).each(function(){
    //             $(this).css('display','block');
    //         });
    //
    //     }
    //
    //
    // });
    //
    // $(document).on('click','.prevDiv',function(){
    //
    //     $("#lastBox").css('display','none');
    //
    //     $("form#validateform .formStep"+step).each(function(){
    //         $(this).css('display','none');
    //     });
    //
    //     console.log('Previous step:'+step);
    //
    //     window.scrollTo(0, 0);
    //     if(step > 1){
    //         $(".nextDiv").css('display','inline-block');
    //     }
    //
    //     step--;
    //
    //     if(step == 1){
    //         $(".prevDiv").css('display','none');
    //     }else{
    //         $(".prevDiv").css('display','inline-block');
    //     }
    //
    //     $("form#validateform .formStep"+step).each(function(){
    //         $(this).css('display','block');
    //     });
    //
    //
    // });
    // $(document).on("change","input[type='date']", function() {
    //     this.setAttribute(
    //         "data-date",
    //         moment(this.value, "mm-dd-yyyy")
    //             .format( "YYYY-MM-DD" )
    //     )
    //     $(this).attr("data-date",$(this).val())
    // }).trigger("change")

</script>

