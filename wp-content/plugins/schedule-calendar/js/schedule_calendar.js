document.addEventListener('DOMContentLoaded', function() {
	var now = new Date();
	var range_start = now.getFullYear() + "-" + (now.getMonth() + 1) + "-01";
	var range_end = now.getFullYear() + "-" + (now.getMonth() + 4) + "-01";
	var calendar_el = document.getElementById('calendar');
	if (calendar_el === null) {
		return;
	}
	var core_week = JSON.parse(calendar_el.dataset.coreweek);
	var events = JSON.parse(calendar_el.dataset.events);
	var is_loggedin = calendar_el.dataset.is_loggedin;
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
		dateClick: function(info) {
			if(is_available_day(info) && calc_available_timelist(info.dateStr).length > 0 && info.date > now && is_loggedin) {
				document.getElementById( "booking_date" ).value = info.dateStr;
				add_option(info.dateStr);
				$("#booking-modal").modal("show");
			}
      		},
		validRange: {
			start: range_start,
			end: range_end
		},
		initialView: 'dayGridMonth',
		contentHeight: 'auto',
		businessHours: true,
    	});
	calendar.render();
	change_color_unavailable_weekdays(core_week);
	change_color_unavailable_days();
	change_color_past_days(now);

	$('table').addClass('my-0');

	var month_offset = 0;
	$('.fc-prev-button').click(function(){
		month_offset--;
   		change_color_unavailable_weekdays(core_week);
		change_color_unavailable_days();
		change_color_past_days(month_offset);
	});
	$('.fc-next-button').click(function(){
		month_offset++;
   		change_color_unavailable_weekdays(core_week);
		change_color_unavailable_days();
		change_color_past_days(month_offset);
	});
});

function add_option(date_str) {
	// 時間選択ボックス
        var select_boxes     = document.getElementsByClassName("time_select_box");
        var available_timelist = [];
        if (document.getElementById('calendar') !== null) {
                var date_str        = document.getElementById("booking_date").value;
                available_timelist = calc_available_timelist(date_str);
        }
        if (select_boxes !== null) {
                for (var select_box of select_boxes) {
			while(select_box.lastChild) {
                		select_box.removeChild(select_box.lastChild);
        		}
			var option = document.createElement("option");
			var value  = "";
			var inner_text = "時間を選択";
			option.value     = value;
                        option.innerText = inner_text;
			select_box.appendChild(option);
                        for (var available_time of available_timelist) {
                                var option       = document.createElement("option");
                                var hour         = ('00' + parseInt(available_time/60)).slice(-2);
                                var minute       = ('00' + available_time%60).slice(-2);
                                var value        = hour + ':' + minute + ':00';
                                var inner_text   = hour + ':' + minute;
                                option.value     = value;
                                option.innerText = inner_text;
                                select_box.appendChild(option);
                        }
                }
        }
}


document.addEventListener('DOMContentLoaded', function() {
	// 時間選択ボックス
        var select_boxes     = document.getElementsByClassName("time_select_box");
	var available_timelist = [];
	if (document.getElementById('calendar') !== null) {
		var date_str        = document.getElementById("booking_date").value;
		available_timelist = calc_available_timelist(date_str);
	}
        if (select_boxes !== null) {
                for (var select_box of select_boxes) {
                        for (var i = 0; i < 24; i++) {
				for (var j = 0; j < 4; j++) {
					var option       = document.createElement("option");
					var hour         = ('00' + i).slice(-2);
					var minute       = ('00' + j*15).slice(-2);
					var value        = hour + ':' + minute + ':00';
					var inner_text   = hour + ':' + minute;
					option.value     = value;
					option.innerText = inner_text;
					select_box.appendChild(option);
				}
                        }
                }
        }
});


function onChange() {
	var bts                = document.getElementById("booking_time_start");
	var bts_id             = bts.selectedIndex;
	var booking_time_start = bts.options[bts_id].value;
	var bs_hour            = Number(booking_time_start.substr(0,2));
	var bs_minute          = Number(booking_time_start.substr(3,2));
	var bts_time           = calc_time_str(booking_time_start);
	var need_time          = 0;
	var core_time_start    = '00:00:00';
	var core_time_end      = '00:00:00';
	var start_break_time   = '00:00:00';
	var end_break_time     = '00:00:00';
	if (document.getElementById('calendar') !== null) {
		var cal_data     = document.getElementById('calendar').dataset;
		need_time        = parseFloat(cal_data.needtime)*60;
		core_time_start  = JSON.parse(cal_data.coretime).start_time;
		core_time_end    = JSON.parse(cal_data.coretime).end_time;
		start_break_time = JSON.parse(cal_data.coretime).start_break_time;
		end_break_time   = JSON.parse(cal_data.coretime).end_break_time;
	}
	var sb_time = calc_time_str(start_break_time);
	var eb_time = calc_time_str(end_break_time);
	var bt      = 0;
	if (bts_time < sb_time && (bts_time + need_time*60) > sb_time) {
		bt = eb_time - sb_time;
	}
	var bte_time = bts_time + bt + need_time;
	var bte_hour = ('00' + parseInt(bte_time/60)).slice(-2);
	var bte_minute = ('00' + bte_time%60).slice(-2);
	document.getElementById("booking_time_end").value = bte_hour + ":" + bte_minute + ":00";
}

function change_color_unavailable_days() {
	var calendar_el = document.getElementById('calendar');
        var events      = JSON.parse(calendar_el.dataset.events);
	for(var ev of events) {
		var atl = calc_available_timelist(ev.start);
		if(atl <= 0){
			var id = `td[data-date = '${ev.start}']`;
			$(id).css("background", "#f5f5f5");
		}
	}
}

function change_color_past_days(month_offset) {
	var now = new Date();
	var now_day   = now.getDate();
	var now_month = now.getMonth() + 1;
	var month_end = new Date(now.getFullYear(), now_month, 0).getDate();
	if (month_offset < 0) {
		now_month += month_offset;
		now_day   = new Date(now.getFullYear(), now_month, 0).getDate();
	}
	for(var i = 1; i <= now_day; i++) {
		var date = now.getFullYear()+'-'+('00'+now_month).slice(-2)+'-'+('00'+i).slice(-2);
		var id = `td[data-date = '${date}']`;
		$(id).css("background", "#f5f5f5");
	}
}

function get_range_days() {
	var now = new Date();
	var range_start = now.getFullYear() + "-" + (now.getMonth() + 1) + "-01";
        var range_end   = now.getFullYear() + "-" + (now.getMonth() + 4) + "-01";
}

function change_color_unavailable_weekdays(core_week) {
	const DAYGRID = "td.fc-daygrid-day.fc-day.fc-day-";
	const WEEK = ["sun", "mon", "tue", "wed", "tur", "fri", "sat"];
	for(var i = 0; i < WEEK.length; i++) {
		if (core_week[i] === '0') {
			var week_class = DAYGRID + WEEK[i];
			$(week_class).css("background", "#f5f5f5");
		}
	}
}

function is_available_day(date_info) {
	var calendar_el = document.getElementById('calendar');
	var core_week = JSON.parse(calendar_el.dataset.coreweek);
	var week_day = date_info.date.getDay();
	// 曜日から除外
	if(core_week[week_day] === '0') {
		return false;
	}
	return true;
}

function get_timelist(date_str) {
        var calendar_el = document.getElementById('calendar');
        var events      = JSON.parse(calendar_el.dataset.events);
        var core_time   = JSON.parse(calendar_el.dataset.coretime);
        var cs          = calc_time_str(core_time.start_time);
        var ce          = calc_time_str(core_time.end_time);
        var timelist    = [];
        // コアタイム、休憩時間
        var cs_time     = {
                label: 'core_time_start',
                start_time: cs,
                end_time: cs
        }
        timelist.push(cs_time);
        var break_time = {
                label: 'break_time',
                start_time: calc_time_str(core_time.start_break_time),
                end_time: calc_time_str(core_time.end_break_time)
        }
        timelist.push(break_time);
        var ce_time = {
                label: 'core_time_end',
                start_time: ce,
                end_time: ce
        }
        timelist.push(ce_time);
	// イベント
        for (var ev of events) {
                if(ev.start === date_str && ev.title !== '予約可能') {
                        var es = calc_time_str(ev.start_time);
                        var ee = calc_time_str(ev.end_time);
                        var unavailable_time = {
                                label: 'unavailable',
                                start_time: es,
                                end_time: ee
                        };
                        timelist.push(unavailable_time);
                }
        }
        sort_timelist(timelist);
	return timelist;
}

function calc_available_timelist(date_str) {
	var calendar_el        = document.getElementById('calendar');
	var timelist           = get_timelist(date_str);
        var need_time          = parseFloat(calendar_el.dataset.needtime)*60;
	var available_timelist = [];
	// 予約可能な時間が、必要な時間を上回るかチェック
        for(var i = 1; i < timelist.length; i++) {
                var delta_time = 0;
                delta_time = timelist[i].start_time - timelist[i-1].end_time;
                if (timelist[i-1].label === 'break_time') {
                        delta_time += timelist[i-1].start_time - timelist[i-2].end_time;
                }
                if(delta_time >= need_time) {
			// 休憩時間を挟むときの開始時間に注意
			if (timelist[i-1].label === 'break_time') {
				for(var j = 0; j <= parseInt((delta_time - need_time)/15); j++) {
					if ((timelist[i-2].end_time + j*15 >= timelist[i-1].start_time)) {
						available_timelist.push(timelist[i-2].end_time + j*15 + timelist[i-1].end_time - timelist[i-1].start_time);
						continue;
					}
					available_timelist.push(timelist[i-2].end_time + j*15);
				}
			} else {
				for(var j = 0; j <= parseInt((delta_time - need_time)/15); j++){
                                	available_timelist.push(timelist[i-1].end_time + j*15);
                        	}
			}
                }
        }
        return available_timelist;
}

function calc_time_str(time_str) {
	var hour   = Number(time_str.substr(0,2));
	var minute = Number(time_str.substr(3,2));
	return hour*60 + minute;
}

function calc_time(hour, minute) {
	return hour*60 + minute;
}

function calc_time_qtr(hour, quarters) {
	return hour*60 + quarters*15;
}

function sort_timelist(timelist) {
	timelist.sort(function(a, b) {
		return a.start_time - b.start_time;
	});
}
