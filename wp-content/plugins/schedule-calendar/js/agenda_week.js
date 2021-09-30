document.addEventListener('DOMContentLoaded', function() {
	var calendar_el = document.getElementById('agenda_week_calendar');
	if (calendar_el === null) {
		return;
	}
	var events = JSON.parse(calendar_el.dataset.events);
	var coretime = JSON.parse(calendar_el.dataset.coretime);
        var calendar = new FullCalendar.Calendar(calendar_el, {
                locale: 'ja',
                buttonText: {
                        prev:     '<',
                        next:     '>',
                        prevYear: '<<',
                        nextYear: '>>',
                        today:    '今日',
                        week:     '週',
                        day:      '日',
                        list:     '一覧'
                },
		contentHeight: 'auto',
                initialView: 'timeGridWeek',
		views: {
                        timeGridWeek: {
                        	slotMinTime: coretime.start_time,
                        	slotMaxTime: coretime.end_time
			}
                },
		events: events,
		eventDidMount: function(info) {
			if (info.event._def.title=='予約済み') {
				info.el.style.background='green' ;
			}
			if (info.event._def.title=='予約不可') {
				info.el.style.background='gray' ;
			}
			if (info.event._def.title=='予約可能') {
				info.el.style.background='blue' ;
			}
		}
        });
        calendar.render();
	$('table').addClass('my-0');
});

