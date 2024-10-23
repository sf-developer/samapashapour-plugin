var sampaWaterGlass = 0

jQuery(function($){

    $(".sampa-water-glass").each(function () {
        if($(this).is(":checked")) {
            sampaWaterGlass++;
        }
    });

    /**
     * Initialize notiflix
     */
    Notiflix.Notify.init({
        width: '300px',
        distance: '30px',
        position: 'center-bottom',
        closeButton: false,
        rtl: true,
        fontFamily: "iransans",
        fontSize: '16px',
        messageMaxLength: 320,
    });

    $(document).on("change", ".sampa-water-glass", function() {
        if($(this).is(":checked")) {
            sampaWaterGlass++;
        }else {
            sampaWaterGlass--;
        }
    });

    $(document).on("click", ".sampa-goto-step-2", function(e) {
        e.preventDefault();
        if($(this).data("type") === "monthly") {
            if($(this).data("time") == "first") {
                if(!$("#my-name").val() || !$("#my-height").val() ||
                    !$("#my-weight").val() || !$("#my-age").val() ||
                    !$("#my-number").val() || !$("#my-goal").val()
                ) {
                    Notiflix.Notify.warning(sampa_translate.emptyValues);
                } else {
                    $(".report-step-1").hide();
                    $(".report-step-2").show();
                    $(".report-step-3").hide();
                    $(".report-step-4").hide();
                    $(".report-step-5").hide();
                }
            } else {
                if(!$.trim($("#sampa-motivational-sentence").val()) || !$.trim($("#sampa-thanksgiving").val()) || !$.trim($("#sampa-works").val()) || sampaWaterGlass == 0) {
                    Notiflix.Notify.warning(sampa_translate.emptyValues);
                } else {
                    $(".report-step-1").hide();
                    $(".report-step-2").show();
                    $(".report-step-3").hide();
                    $(".report-step-4").hide();
                    $(".report-step-5").hide();
                }
            }

        } else {
            if(!$.trim($("#sampa-motivational-sentence")) || !$.trim($("#sampa-thanksgiving")) || !$.trim($("#sampa-works")) || sampaWaterGlass == 0) {
                Notiflix.Notify.warning(sampa_translate.emptyValues);
            } else {
                $(".report-step-1").hide();
                $(".report-step-2").show();
            }
        }
    });

    $(document).on("click", ".sampa-return-to-step-1", function(e) {
        e.preventDefault();
        $(".report-step-1").show();
        $(".report-step-2").hide();
        if($(this).data("type") === "monthly") {
            $(".report-step-3").hide();
            $(".report-step-4").hide();
            $(".report-step-5").hide();
        }
    });

    $(document).on("click", ".sampa-goto-step-3", function(e) {
        e.preventDefault();
        if($(this).data("time") == "first") {
            if(!$("#sampa-about-this-month").val()) {
                Notiflix.Notify.warning(sampa_translate.emptyValues);
            } else {
                $(".report-step-1").hide();
                $(".report-step-2").hide();
                $(".report-step-3").show();
                $(".report-step-4").hide();
                $(".report-step-5").hide();
            }
        }else {
            if(!$("#sampa-nutrition").val() || !$("#sampa-sport").val() || !$("#sampa-sleep").val() || !$("#sampa-expenses").val()) {
                Notiflix.Notify.warning(sampa_translate.emptyValues);
            } else {
                $(".report-step-1").hide();
                $(".report-step-2").hide();
                $(".report-step-3").show();
                $(".report-step-4").hide();
                $(".report-step-5").hide();
            }
        }
    });

    $(document).on("click", ".sampa-return-to-step-2", function(e) {
        e.preventDefault();
        $(".report-step-2").show();
        $(".report-step-1").hide();
        if($(this).data("type") === "monthly") {
            $(".report-step-3").hide();
            $(".report-step-4").hide();
            $(".report-step-5").hide();
        }
    });

    $(document).on("click", ".sampa-goto-step-4", function(e) {
        e.preventDefault();
        if($(this).data("time") == "first") {
            if(!$("#chest").val() || !$("#left-arm").val() || !$("#right-arm").val()
                || !$("#waist").val() || !$("#belly").val() || !$("#hip").val()
                || !$("#left-thigh").val() || !$("#right-thigh").val()
                || !$("#left-leg").val() || !$("#right-leg").val()) {
                Notiflix.Notify.warning(sampa_translate.emptyValues);
            } else {
                $(".report-step-1").hide();
                $(".report-step-2").hide();
                $(".report-step-3").hide();
                $(".report-step-4").show();
                $(".report-step-5").hide();
            }
        } else {
            if(!$("#sampa-about-this-month").val()) {
                Notiflix.Notify.warning(sampa_translate.emptyValues);
            } else {
                $(".report-step-1").hide();
                $(".report-step-2").hide();
                $(".report-step-3").hide();
                $(".report-step-4").show();
                $(".report-step-5").hide();
            }
        }
    });

    $(document).on("click", ".sampa-return-to-step-3", function(e) {
        e.preventDefault();
        $(".report-step-1").hide();
        $(".report-step-2").hide();
        $(".report-step-3").show();
        $(".report-step-4").hide();
        $(".report-step-5").hide();
    });

    $(document).on("click", ".sampa-goto-step-5", function(e) {
        e.preventDefault();
        if($(this).data("time") == "first") {
            if(!$.trim($("#sampa-motivational-sentence").val()) || !$.trim($("#sampa-thanksgiving").val()) || !$.trim($("#sampa-works").val()) || sampaWaterGlass == 0) {
                Notiflix.Notify.warning(sampa_translate.emptyValues);
            } else {
                $(".report-step-1").hide();
                $(".report-step-2").hide();
                $(".report-step-3").hide();
                $(".report-step-4").hide();
                $(".report-step-5").show();
            }
        } else {
            if(!$("#chest").val() || !$("#left-arm").val() || !$("#right-arm").val() || !$("#waist").val() || !$("#belly").val() || !$("#hip").val() || !$("#left-thigh").val() || !$("#right-thigh").val() || !$("#left-leg").val() || !$("#right-leg").val()) {
                Notiflix.Notify.warning(sampa_translate.emptyValues);
            } else {
                $(".report-step-1").hide();
                $(".report-step-2").hide();
                $(".report-step-3").hide();
                $(".report-step-4").hide();
                $(".report-step-5").show();
            }
        }
    });

    $(document).on("click", ".sampa-return-to-step-4", function(e) {
        e.preventDefault();
        $(".report-step-1").hide();
        $(".report-step-2").hide();
        $(".report-step-3").hide();
        $(".report-step-4").show();
        $(".report-step-5").hide();
    });

    function h(e) {
        var height =  e.scrollTop;
        $(".sampa-before-title").css({'top' : 12 - height });
    }
    function h2(e) {
        var height =  e.scrollTop;
        $(".sampa-before-title2").css({'top' : 12 - height });
    }
    function h3(e) {
        var height =  e.scrollTop;
        $(".sampa-before-title3").css({'top' : 12 - height });
    }
    $('#sampa-this-month-diet').each(function () {
        h(this);
    }).on('scroll' , function(){
        h(this) ;
    });
    $('#sampa-this-month-gym').each(function () {
        h2(this);
    }).on('scroll' , function(){
        h2(this) ;
    });
    $('#sampa-this-month-sleep-time').each(function () {
        h3(this);
    }).on('scroll' , function(){
        h3(this) ;
    });

    $(document).on("click", ".sampa-save-daily-form", function(e) {
        e.preventDefault();
        let formItems = [],
            userId = $(this).data("uid"),
            motivationalSentence = $("#sampa-motivational-sentence").val(),
            thanksgiving = $("#sampa-thanksgiving").val(),
            works = $("#sampa-works").val(),
            nutrition = $("#sampa-nutrition").val(),
            sport = $("#sampa-sport").val(),
            sleep = $("#sampa-sleep").val(),
            expenses = $("#sampa-expenses").val(),
            note = $("#sampa-note").val();
        if (!$.trim(userId) || !$.trim(motivationalSentence) || !$.trim(thanksgiving) || !$.trim(works) || !$.trim(nutrition) || !$.trim(sport) || !$.trim(sleep) || !$.trim(expenses) ) {
            Notiflix.Notify.warning(sampa_translate.emptyValues);
        }else {
            Notiflix.Confirm.show(
                sampa_translate.savingConfirmTitle,
                sampa_translate.savingConfirmContent,
                sampa_translate.yes,
                sampa_translate.no,
                function okCb() {
                    formItems.push({
                        "motivational_sentence": motivationalSentence,
                        "thanksgiving": thanksgiving,
                        "works": works,
                        "nutrition": nutrition,
                        "sport": sport,
                        "sleep": sleep,
                        "expenses": expenses,
                        "note": note,
                        "water": sampaWaterGlass
                    });
                    $.ajax({
                        type: "POST",
                        url: sampa._ajax_url,
                        data: {
                            action: "sampa_save_daily_form",
                            form_items: formItems,
                            user_id: userId,
                            nonce: sampa._ajax_nonce
                        },
                        beforeSend: function () {
                            Notiflix.Loading.standard();
                        },
                        success: function (response) {
                            Notiflix.Loading.remove();
                            if (response.success) {
                                Notiflix.Notify.success(response.data.message);
                            }else {
                                Notiflix.Notify.warning(response.data.message);
                            }
                        },
                        error: function (t, e, n) {
                            Notiflix.Loading.remove();
                            Notiflix.Notify.failure(e);
                        }
                    });
                },
                function cancelCb() {}
            );
        }
    });

    $(document).on("click", ".sampa-update-daily-form", function(e) {
        e.preventDefault();
        let formItems = [],
            userId = $(this).data("uid"),
            formId = $(this).data("form-id"),
            motivationalSentence = $("#sampa-motivational-sentence").val(),
            thanksgiving = $("#sampa-thanksgiving").val(),
            works = $("#sampa-works").val(),
            nutrition = $("#sampa-nutrition").val(),
            sport = $("#sampa-sport").val(),
            sleep = $("#sampa-sleep").val(),
            expenses = $("#sampa-expenses").val(),
            note = $("#sampa-note").val();
        if (!$.trim(userId) || !$.trim(formId) || !$.trim(motivationalSentence) || !$.trim(thanksgiving) || !$.trim(works) || !$.trim(nutrition) || !$.trim(sport) || !$.trim(sleep) || !$.trim(expenses) ) {
            Notiflix.Notify.warning(sampa_translate.emptyValues);
        }else {
            Notiflix.Confirm.show(
                sampa_translate.savingConfirmTitle,
                sampa_translate.savingConfirmContent,
                sampa_translate.yes,
                sampa_translate.no,
                function okCb() {
                    formItems.push({
                        "motivational_sentence": motivationalSentence,
                        "thanksgiving": thanksgiving,
                        "works": works,
                        "nutrition": nutrition,
                        "sport": sport,
                        "sleep": sleep,
                        "expenses": expenses,
                        "note": note,
                        "water": sampaWaterGlass
                    });
                    $.ajax({
                        type: "POST",
                        url: sampa._ajax_url,
                        data: {
                            action: "sampa_update_daily_form",
                            form_items: formItems,
                            user_id: userId,
                            form_id: formId,
                            nonce: sampa._ajax_nonce
                        },
                        beforeSend: function () {
                            Notiflix.Loading.standard();
                        },
                        success: function (response) {
                            Notiflix.Loading.remove();
                            if (response.success) {
                                Notiflix.Notify.success(response.data.message);
                            }else {
                                Notiflix.Notify.warning(response.data.message);
                            }
                        },
                        error: function (t, e, n) {
                            Notiflix.Loading.remove();
                            Notiflix.Notify.failure(e);
                        }
                    });
                },
                function cancelCb() {}
            );
        }
    });

    $(document).on("click", ".sampa-save-monthly-form", function(e) {
        e.preventDefault();
        let formItems = [],
            personalItems = [],
            dailyItems = [],
            endMonthItems = [],
            userId = $(this).data("uid"),
            chest = $("#chest").val(),
            leftArm = $("#left-arm").val(),
            rightArm = $("#right-arm").val(),
            waist = $("#waist").val(),
            belly = $("#belly").val(),
            hip = $("#hip").val(),
            leftThigh = $("#left-thigh").val(),
            rightThigh = $("#right-thigh").val(),
            leftLeg = $("#left-leg").val(),
            rightLeg = $("#right-leg").val(),
            about = $("#sampa-about-this-month").val(),
            motivationalSentence = $("#sampa-motivational-sentence").val(),
            thanksgiving = $("#sampa-thanksgiving").val(),
            works = $("#sampa-works").val(),
            nutrition = $("#sampa-nutrition").val(),
            sport = $("#sampa-sport").val(),
            sleep = $("#sampa-sleep").val(),
            expenses = $("#sampa-expenses").val(),
            note = $("#sampa-note").val(),
            firstTime = $(this).data("time") == "first" ? 1 : 0;
        if(firstTime) {
            var myName = $("#my-name").val(),
                myHeight = $("#my-height").val(),
                myWeight = $("#my-weight").val(),
                myAge = $("#my-age").val(),
                myNumber = $("#my-number").val(),
                myGoal = $("#my-goal").val();
        } else {
            var thisMonthDiet = $("#sampa-this-month-diet").val(),
                thisMonthGym = $("#sampa-this-month-gym").val(),
                thisMonthSleepTime = $("#sampa-this-month-sleep-time").val(),
                beginingWeight = $("#sampa-begining-weight").val(),
                endingWeight = $("#sampa-ending-weight").val(),
                award = $("#sampa-this-month-award").val();
        }
        if (!$.trim(userId) || !$.trim(chest) || !$.trim(leftArm) || !$.trim(rightArm) || !$.trim(waist) || !$.trim(belly) || !$.trim(hip) || !$.trim(leftThigh) || !$.trim(rightThigh) || !$.trim(leftLeg) || !$.trim(rightLeg) || !$.trim(about) || !$.trim(motivationalSentence) || !$.trim(thanksgiving) || !$.trim(works) || sampaWaterGlass == 0 || !$.trim(nutrition) || !$.trim(sport) || !$.trim(sleep) || !$.trim(expenses) ) {
            Notiflix.Notify.warning(sampa_translate.emptyValues);
        }else if(firstTime && ( !$.trim(myName) || !$.trim(myHeight) || !$.trim(myWeight) || !$.trim(myAge) || !$.trim(myNumber) || !$.trim(myGoal) )) {
            Notiflix.Notify.warning(sampa_translate.emptyValues);
        }else if(!firstTime && (!$.trim(thisMonthDiet) || !$.trim(thisMonthGym) || !$.trim(thisMonthSleepTime) || !$.trim(beginingWeight) || !$.trim(endingWeight) || !$.trim(award))) {
            Notiflix.Notify.warning(sampa_translate.emptyValues);
        }else {
            Notiflix.Confirm.show(
                sampa_translate.savingConfirmTitle,
                sampa_translate.savingConfirmContent,
                sampa_translate.yes,
                sampa_translate.no,
                function okCb() {
                    formItems.push({
                        "chest": chest,
                        "left_arm": leftArm,
                        "right_arm": rightArm,
                        "waist": waist,
                        "belly": belly,
                        "hip": hip,
                        "left_thigh": leftThigh,
                        "right_thigh": rightThigh,
                        "left_leg": leftLeg,
                        "right_leg": rightLeg
                    });
                    dailyItems.push({
                        "motivational_sentence": motivationalSentence,
                        "thanksgiving": thanksgiving,
                        "works": works,
                        "water": sampaWaterGlass,
                        "nutrition": nutrition,
                        "sport": sport,
                        "sleep": sleep,
                        "expenses": expenses,
                        "note": note
                    });
                    if(firstTime) {
                        personalItems.push({
                            "my_name": myName,
                            "my_height": myHeight,
                            "my_weight": myWeight,
                            "my_age": myAge,
                            "my_number": myNumber,
                            "my_goal": myGoal
                        });
                    } else {
                        endMonthItems.push({
                            "this_month_diet": thisMonthDiet,
                            "this_month_gym": thisMonthGym,
                            "this_month_sleep_time": thisMonthSleepTime
                        });
                    }
                    $.ajax({
                        type: "POST",
                        url: sampa._ajax_url,
                        data: {
                            action: "sampa_save_monthly_form",
                            form_items: formItems,
                            personal_items: personalItems,
                            daily_items: dailyItems,
                            end_month_items: endMonthItems,
                            user_id: userId,
                            about: about,
                            begining_weight: beginingWeight,
                            ending_weight: endingWeight,
                            award: award,
                            first_time: firstTime,
                            nonce: sampa._ajax_nonce
                        },
                        beforeSend: function () {
                            Notiflix.Loading.standard();
                        },
                        success: function (response) {
                            Notiflix.Loading.remove();
                            if (response.success) {
                                Notiflix.Notify.success(response.data.message);
                                if(! firstTime) {
                                    $(".report-step-3").hide();
                                    $(".report-step-4").hide();
                                    $(".report-step-5").hide();
                                    $(".report-step-6").show();
                                }
                            }else {
                                Notiflix.Notify.warning(response.data.message);
                            }
                        },
                        error: function (t, e, n) {
                            Notiflix.Loading.remove();
                            Notiflix.Notify.failure(e);
                        }
                    });
                },
                function cancelCb() {}
            );
        }
    });

    $(document).on("click", ".sampa-update-monthly-form", function(e) {
        e.preventDefault();
        let formItems = [],
            personalItems = [],
            dailyItems = [],
            endMonthItems = [],
            userId = $(this).data("uid"),
            formId = $(this).data("form-id"),
            chest = $("#chest").val(),
            leftArm = $("#left-arm").val(),
            rightArm = $("#right-arm").val(),
            waist = $("#waist").val(),
            belly = $("#belly").val(),
            hip = $("#hip").val(),
            leftThigh = $("#left-thigh").val(),
            rightThigh = $("#right-thigh").val(),
            leftLeg = $("#left-leg").val(),
            rightLeg = $("#right-leg").val(),
            about = $("#sampa-about-this-month").val(),
            motivationalSentence = $("#sampa-motivational-sentence").val(),
            thanksgiving = $("#sampa-thanksgiving").val(),
            works = $("#sampa-works").val(),
            nutrition = $("#sampa-nutrition").val(),
            sport = $("#sampa-sport").val(),
            sleep = $("#sampa-sleep").val(),
            expenses = $("#sampa-expenses").val(),
            note = $("#sampa-note").val(),
            firstTime = $(this).data("time") == "first" ? 1 : 0;

        if(firstTime) {
            var myName = $("#my-name").val(),
                myHeight = $("#my-height").val(),
                myWeight = $("#my-weight").val(),
                myAge = $("#my-age").val(),
                myNumber = $("#my-number").val(),
                myGoal = $("#my-goal").val();
        } else {
            var thisMonthDiet = $("#sampa-this-month-diet").val(),
                thisMonthGym = $("#sampa-this-month-gym").val(),
                thisMonthSleepTime = $("#sampa-this-month-sleep-time").val(),
                beginingWeight = $("#sampa-begining-weight").val(),
                endingWeight = $("#sampa-ending-weight").val(),
                award = $("#sampa-this-month-award").val();
        }
        if (!$.trim(userId) || !$.trim(formId) || !$.trim(chest) || !$.trim(leftArm) || !$.trim(rightArm) || !$.trim(waist) || !$.trim(belly) || !$.trim(hip) || !$.trim(leftThigh) || !$.trim(rightThigh) || !$.trim(leftLeg) || !$.trim(rightLeg) || !$.trim(about) || !$.trim(motivationalSentence) || !$.trim(thanksgiving) || !$.trim(works) || sampaWaterGlass == 0 || !$.trim(nutrition) || !$.trim(sport) || !$.trim(sleep) || !$.trim(expenses) ) {
            Notiflix.Notify.warning(sampa_translate.emptyValues);
        }else if(firstTime && ( !$.trim(myName) || !$.trim(myHeight) || !$.trim(myWeight) || !$.trim(myAge) || !$.trim(myNumber) || !$.trim(myGoal) )) {
            Notiflix.Notify.warning(sampa_translate.emptyValues);
        }else if(!firstTime && (!$.trim(thisMonthDiet) || !$.trim(thisMonthGym) || !$.trim(thisMonthSleepTime) || !$.trim(beginingWeight) || !$.trim(endingWeight) || !$.trim(award))) {
            Notiflix.Notify.warning(sampa_translate.emptyValues);
        }else {
            Notiflix.Confirm.show(
                sampa_translate.savingConfirmTitle,
                sampa_translate.savingConfirmContent,
                sampa_translate.yes,
                sampa_translate.no,
                function okCb() {
                    formItems.push({
                        "chest": chest,
                        "left_arm": leftArm,
                        "right_arm": rightArm,
                        "waist": waist,
                        "belly": belly,
                        "hip": hip,
                        "left_thigh": leftThigh,
                        "right_thigh": rightThigh,
                        "left_leg": leftLeg,
                        "right_leg": rightLeg
                    });
                    dailyItems.push({
                        "motivational_sentence": motivationalSentence,
                        "thanksgiving": thanksgiving,
                        "works": works,
                        "water": sampaWaterGlass,
                        "nutrition": nutrition,
                        "sport": sport,
                        "sleep": sleep,
                        "expenses": expenses,
                        "note": note
                    });
                    if(firstTime) {
                        personalItems.push({
                            "my_name": myName,
                            "my_height": myHeight,
                            "my_weight": myWeight,
                            "my_age": myAge,
                            "my_number": myNumber,
                            "my_goal": myGoal
                        });
                    } else {
                        endMonthItems.push({
                            "this_month_diet": thisMonthDiet,
                            "this_month_gym": thisMonthGym,
                            "this_month_sleep_time": thisMonthSleepTime
                        });
                    }
                    $.ajax({
                        type: "POST",
                        url: sampa._ajax_url,
                        data: {
                            action: "sampa_update_monthly_form",
                            form_items: formItems,
                            personal_items: personalItems,
                            daily_items: dailyItems,
                            end_month_items: endMonthItems,
                            user_id: userId,
                            form_id: formId,
                            about: about,
                            begining_weight: beginingWeight,
                            ending_weight: endingWeight,
                            award: award,
                            first_time: firstTime,
                            nonce: sampa._ajax_nonce
                        },
                        beforeSend: function () {
                            Notiflix.Loading.standard();
                        },
                        success: function (response) {
                            Notiflix.Loading.remove();
                            if (response.success) {
                                Notiflix.Notify.success(response.data.message);
                                if(! firstTime) {
                                    $(".report-step-3").hide();
                                    $(".report-step-4").hide();
                                    $(".report-step-5").hide();
                                    $(".report-step-6").show();
                                }
                            }else {
                                Notiflix.Notify.warning(response.data.message);
                            }
                        },
                        error: function (t, e, n) {
                            Notiflix.Loading.remove();
                            Notiflix.Notify.failure(e);
                        }
                    });
                },
                function cancelCb() {}
            );
        }
    });

    if($("#daily-reports").length && ! $.fn.DataTable.isDataTable( '#daily-reports' )) {
        get_daily_reports();
    }

    $(document).on("click", "#pills-daily-tab", function() {
        if(! $.fn.DataTable.isDataTable( '#daily-reports' )) {
            get_daily_reports();
        }
    });

    $("#my-name").on("change paste keyup", function() {
        $("#agreement-name").val($(this).val());
    });

    $("#my-height").on("change paste keyup", function() {
        $("#agreement-height").val($(this).val());
    });

    $("#my-weight").on("change paste keyup", function() {
        $("#agreement-weight").val($(this).val());
    })

    $(document).on("click", "#pills-monthly-tab", function() {
        if(! $.fn.DataTable.isDataTable( '#monthly-reports' )) {
            $.ajax({
                type: "GET",
                url: sampa._ajax_url,
                data: {
                    action: "sampa_monthly_reports",
                    nonce: sampa._ajax_nonce
                },
                beforeSend: function () {
                    Notiflix.Loading.standard();
                },
                success: function (response) {
                    Notiflix.Loading.remove();
                    if(response.success) {
                        let monthlyTable = new DataTable("#monthly-reports", {
                            data: response.data.data,
                            buttons: true,
                            processing: true,
                            responsive: true,
                            language: {
                                url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/fa.json"
                            }
                        });
                        let buttons = new $.fn.dataTable.Buttons(monthlyTable, {
                            buttons: [
                                {
                                    extend: 'excelHtml5',
                                    autoFilter: true
                                }
                            ]
                       }).container().appendTo($('#ExportMonthlyReporttoExcel'));
                    }else {
                        Notiflix.Notify.warning(response.data.message);
                    }
                },
                error: function (t, e, n) {
                    Notiflix.Loading.remove();
                    Notiflix.Notify.failure(e);
                }
            });
        }
    });

    function get_daily_reports() {
        $.ajax({
            type: "GET",
            url: sampa._ajax_url,
            data: {
                action: "sampa_daily_reports",
                nonce: sampa._ajax_nonce
            },
            beforeSend: function () {
                Notiflix.Loading.standard();
            },
            success: function (response) {
                Notiflix.Loading.remove();
                if(response.success) {
                    let dailyTable = new DataTable("#daily-reports", {
                        data: response.data.data,
                        buttons: true,
                        processing: true,
                        responsive: true,
                        language: {
                            url: "//cdn.datatables.net/plug-ins/1.13.5/i18n/fa.json"
                        }
                    });
                    let buttons = new $.fn.dataTable.Buttons(dailyTable, {
                        buttons: [
                          {
                            extend: 'excelHtml5',
                            autoFilter: true
                          }
                        ]
                   }).container().appendTo($('#ExportDailyReporttoExcel'));
                }else {
                    Notiflix.Notify.warning(response.data.message);
                }
            },
            error: function (t, e, n) {
                Notiflix.Loading.remove();
                Notiflix.Notify.failure(e);
            }
        });
    }
});