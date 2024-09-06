let year, month;

$(function(){
    drawCalendar(new Date());
});

function drawCalendar(now){
    year = now.getFullYear();
    month = now.getMonth();
    const firstDay = new Date(year, month, 1);
    const start = dateFormat(new Date(year, month, 1 - firstDay.getDay()));
    const end = dateFormat(new Date(year, month, 1 - firstDay.getDay() + 41));
    const param1 = {
        url: 'holiday.php', 
        type: 'get', 
        data: {start: start, end: end}, 
        dataType: 'json'
    };
    $.ajax(param1).done(function(holiday){
        const param2 = {
            url: 'schedule.php', 
            type: 'get', 
            data: {start: start, end: end}, 
            dataType: 'json'
        };
        $.ajax(param2).done(function(schedule){
            draw(holiday, schedule);
        });
    });
}

function dateFormat(dt){
    let year = dt.getFullYear();
    let month = dt.getMonth() + 1;
    let date = dt.getDate();
    return year + '-' + ('0' + month).slice(-2) + '-' + ('0' + date).slice(-2);
}

function draw(holiday, schedule) {
    let title = '<nav>';
    title += '<div id="month-navigation">';
    title += '<span id="prev-month"> < </span>';
    title += '<span id="current-month">' + year + '年' + (month + 1) + '月</span>';
    title += '<span id="next-month"> > </span>';
    title += '</div>';

    title += '<div id="youbi-container">';
    title += '<div id="youbi"><div>日</div><div>月</div><div>火</div><div>水</div><div>木</div><div>金</div><div>土</div></div>';
    title += '</div>';
    title += '</nav>';
    $('#title').html(title);

    let html = "";
    let firstDay = new Date(year, month, 1);
    for (var i = 1; i <= 42; i++) {
        var day = new Date(year, month, i - firstDay.getDay());
        var m = day.getMonth();
        var d = day.getDate();
        var className = 'day';
        if (i % 7 === 1) className += ' sunday';
        if (i % 7 === 0) className += ' saturday';
        if (m !== month) className += ' other-month';
        let s = d;
        for (let date in holiday) {
            if (date == dateFormat(day)) {
                s += '&nbsp;<span class="holiday-text">' + holiday[date] + '</span>';
                className += ' holiday';
            }
        }
        for (let date in schedule) {
            if (date == dateFormat(day)) {
                s += '<div class="schedule-text">' + schedule[date] + '</div>';
            }
        }
        html += '<div class="' + className + '" id="' + year + '-' + (m + 1) + '-' + d + '">';
        html += s;
        html += '</div>'
    }
    $('#calendar').html(html);

    $('#prev-month').on('click', function(){
        drawCalendar(new Date(year, month - 1, 1));
    });

    $('#next-month').on('click', function(){
        drawCalendar(new Date(year, month + 1, 1));
    });

    $('.day').on('click', function(){
        windowOpen($(this).prop('id'));
    });

    $('#ok-button').on('click', function(){
        windowClose();
    });
}

function windowOpen(id){
    let url = 'calendarEdit.php?id=' + id;
    const left = (screen.width - 600) / 2;
    const top = (screen.height - 320) / 2;
    window.open(url, null, 'width=600, height=320, top' + top + ',left=' + left);
}

function windowClose(){
    const id = $('#id').val();
    let content = $('#content').val(); // contentを取得
    content = content.replace(/\n/g, '<br>');

    console.log('ID:', id);
    console.log('Content:', content);

    const ajaxParam = {
        url: 'calendarUpdate.php', 
        type: 'get', 
        dataType: 'text', 
        data: {id: id, content: content}
    }

    $.ajax(ajaxParam).done(function(txt){
        console.log('Update response:', txt);

        let ary = id.split('-');
        let year = parseInt(ary[0]);
        let month = parseInt(ary[1])-1;

        console.log('Year:', year, 'Month:', month);

        if (window.opener && !window.opener.closed) {
            window.opener.drawCalendar(new Date(year, month, 1));
            console.log('親ウィンドウのカレンダーを更新しました。');
        } else {
            console.log('親ウィンドウが利用できません。');
        }

        self.close(); // ウィンドウを閉じる試み
        console.log('ウィンドウを閉じる操作が実行されました。');
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error('更新に失敗しました:', textStatus, errorThrown);
    });
}
