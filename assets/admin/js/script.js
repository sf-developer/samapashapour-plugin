jQuery(function($){

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

    if($("#daily-reports").length && ! $.fn.DataTable.isDataTable( '#daily-reports' )) {
        get_daily_reports();
    }

    $(document).on("click", "#pills-daily-tab", function() {
        if(! $.fn.DataTable.isDataTable( '#daily-reports' )) {
            get_daily_reports();
        }
    });

    $(document).on("click", "#pills-monthly-tab", function() {
        if(! $.fn.DataTable.isDataTable( '#monthly-reports' )) {
            $.ajax({
                type: "GET",
                url: sampa._ajax_url,
                data: {
                    action: "sampa_monthly_reports_for_admin",
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
                action: "sampa_daily_reports_for_admin",
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