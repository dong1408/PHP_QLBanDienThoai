$(document).ready(function () {
    $('.nav-link.active .sub-menu').slideDown();
    // $("p").slideUp();

    $('#sidebar-menu .arrow').click(function () {
        $(this).parents('li').children('.sub-menu').slideToggle();
        $(this).toggleClass('fa-angle-right fa-angle-down');
    });

    $("input[name='checkall']").click(function () {
        var checked = $(this).is(':checked');
        $('.table-checkall tbody tr td input:checkbox').prop('checked', checked);
    });

    $("#select-statistical").change(function () {
        $select = $("#select-statistical").val();
        $stringHtmlFilterByDate = '<div class="col-md-1"></div>\
                                    <div class="col-md-4">\
                                        <div class="form-group">\
                                            <label for="" style="padding-right: 15px;">Ngày bắt đầu</label>\
                                            <input type="date" id="date-from" style="width: 160px">\
                                        </div>\
                                    </div>\
                                    <div class="col-md-4">\
                                        <div class="form-group">\
                                            <label for="" style="padding-right: 15px;">Ngày kết thúc</label>\
                                            <input type="date" id="date-to" style="width: 160px">\
                                        </div>\
                                    </div>\
                                    <div class="col-md-1"></div>\
                                    <div class="col-md-2">\
                                        <div class="form-group">\
                                            <button style="border-radius: 5px;">Tìm kiếm</button>\
                                        </div>\
                                    </div>';
        $stringHtmlFilterByMonth = '<div class="col-md-2"></div>\
        <div class="col-md-4">\
            <div class="form-group">\
                <label for="" style="padding-right: 15px;">Từ</label>\
                <select name="" id="month-from" style="margin-right: 15px;">\
                </select>\
                <label for="">Tới</label>\
                <select name="" id="month-to" style="margin-left: 10px;">\
                </select>\
            </div>\
        </div>\
        <div class="col-md-4">\
            <div class="form-group">\
                <div class="form-group">\
                    <label for="" style="padding-right: 15px;">Năm</label>\
                    <select name="" id="year" style="padding-right: 15px;">\
                        <option value="">2010</option>\
                        <option value="">2011</option>\
                        <option value="">2012</option>\
                        <option value="">2013</option>\
                        <option value="">2014</option>\
                        <option value="">2015</option>\
                    </select>\
                </div>\
            </div>\
        </div>\
        <div class="col-md-2">\
            <div class="form-group">\
                <button style="border-radius: 5px;">Tìm kiếm</button>\
            </div>\
        </div>';
        $stringHtmlFilterByQuy = '<div class="col-md-6">\
                                        <div class="form-group">\
                                            <label for="" style="padding-right: 15px;">Lựa chọn quý</label>\
                                            <select name="" id="" style="padding-right: 20px;">\
                                                <option value="">Quý 1</option>\
                                                <option value="">Quý 2</option>\
                                                <option value="">Quý 3</option>\
                                                <option value="">Quý 4</option>\
                                            </select>\
                                            <select name="" id="" style="padding-right: 15px;">\
                                                <option value="">2010</option>\
                                                <option value="">2011</option>\
                                                <option value="">2012</option>\
                                                <option value="">2013</option>\
                                                <option value="">2014</option>\
                                                <option value="">2015</option>\
                                            </select>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-4"></div>\
                                    <div class="col-md-2">\
                                        <div class="form-group">\
                                            <button style="border-radius: 5px;">Tìm kiếm</button>\
                                        </div>\
                                    </div>';
        if ($select == 'statisticalByDate') {
            $("#filter").html($stringHtmlFilterByDate)
            var dateFromInput = document.getElementById("date-from");
            var dateToInput = document.getElementById("date-to");
            var date = new Date();
            var currentDay = date.getDate();
            var currentMonth = date.getMonth() + 1; // Lưu ý: Tháng được đánh số từ 0 đến 11
            var currentYear = date.getFullYear();
            // Định dạng ngày và tháng để phù hợp với định dạng của input type 'date'
            var formattedDate = currentYear + "-" + (currentMonth < 10 ? '0' : '') + currentMonth + "-" + (currentDay < 10 ? '0' : '') + currentDay;
            dateFromInput.value = formattedDate;
            dateToInput.value = formattedDate;
        } else if ($select == 'statisticalByMonth') {
            $("#filter").html($stringHtmlFilterByMonth)
            var monthFromSelectTag = document.getElementById("month-from");
            var monthToSelectTag = document.getElementById("month-to");
            var date = new Date();
            var currentMonth = date.getMonth() + 1;
            console.log(currentMonth);
            for (let i = 1; i <= 12; i++) {
                var option = document.createElement("option");
                option.value = i;
                option.text = "Tháng " + i;
                monthToSelectTag.add(option);
            }
            for (let i = 1; i <= 12; i++) {
                var option = document.createElement("option");
                option.value = i;
                option.text = "Tháng " + i;
                if (currentMonth == i) {
                    option.setAttribute("selected", "selected");
                }
                monthFromSelectTag.add(option);
            }
        } else if ($select == 'statisticalByQuy') {
            $("#filter").html($stringHtmlFilterByQuy);
        }
    });
});