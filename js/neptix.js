jQuery(document).ready(function($){
	jQuery(".neptix_calendar").each(function(){
		var $this = $(this);
		var neptix_event = {};
		var json_url = $this.data("json");
		var buytix_btn = $this.data("buytix");
		$.getJSON(json_url, function(json){
			for(var i=0; i<json.length; i++)
			{
				var days = new Array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
				var event_date = new Date(json[i].event_startdate);
				var event_time = new Date(json[i].event_dooropen);
				var event_hours = event_time.getHours();
				var event_minutes = event_time.getMinutes();
				var event_ampm = event_hours >= 12 ? 'pm' : 'am';
				event_hours = event_hours % 12;
				event_hours = event_hours ? event_hours : 12;
				event_minutes = event_minutes < 10 ? '0'+event_minutes : event_minutes;
				var event_strTime = event_hours + ':' + event_minutes + ' ' + event_ampm;
				var event_date_str = days[event_date.getDay()]+", "+event_date.getDate()+" "+event_date.getFullYear()+"<br/>"+event_strTime;
				var event_link = 'http://www.neptix.com/events/'+json[i].id;
				var event_image = '<a href="'+event_link+'" target="_blank"><img src="http://www.neptix.com/userfiles/'+json[i].userid+'/'+json[i].event_image+'" alt="" /></a>';
				neptix_event[event_date] = '<h3>'+json[i].event_name+'</h3><div class="row"><div class="img">'+event_image+'</div><div>'+event_date_str+'<br/><a href="'+event_link+'" target="_blank" class="buytix">'+buytix_btn+'</a></div></div>';
			}
			$this.datepicker({
				beforeShowDay: function(date) {
					if (neptix_event[date]) {
						return [true, "has_event neptix_tooltip", neptix_event[date]];
					}
					return [false, "", ""];
				}
			});
		});
	});

	jQuery(document).on("hover", '.neptix_calendar .ui-datepicker td', function(e){
		if ($(this).attr("title") != "")
		{
			$(this).attr("data-title", $(this).attr("title"));
			$(this).attr("title", "");
		}
	});

	var tip_timer;
	var tip_lck = false;
	var calendar_fix_trigger = false;
	jQuery(document).on("hover click", ".neptix_calendar .has_event a", function(e){
		if (!calendar_fix_trigger) { calendar_fix_trigger = true; return false; }
		e.stopPropagation();
		tip_lck = true;
		clearTimeout(tip_timer);
		tip_timer = setTimeout(function(){ tip_lck = false; }, 200);
		$(".neptix_tip").remove();
		if ($(this).parent().attr("title") != "")
		{
			$(this).parent().attr("data-title", $(this).parent().attr("title"));
			$(this).parent().attr("title", "");
		}
		$('body').append('<div class="neptix_tip neptix_events"><a href="#" class="close">close</a> '+$(this).parent().attr("data-title")+'</div>');
		if ($(window).width() > 1050)
		{
			if ($(this).offset().top+$(".neptix_tip").outerHeight() <= jQuery(window).scrollTop()+jQuery(window).height())
			{
				$(".neptix_tip").addClass("tip_bottom").css({
					top: $(this).offset().top+$(this).outerHeight(),
					left: $(this).offset().left-($(".neptix_tip").outerWidth()/2-$(this).width()/2)+2
				});
			} else {
				$(".neptix_tip").removeClass("tip_bottom").css({
					top: $(this).offset().top-$(".neptix_tip").outerHeight(),
					left: $(this).offset().left-($(".neptix_tip").outerWidth()/2-$(this).width()/2)+2
				});
			}
		} else {
			$(".neptix_tip").addClass("tip_bottom").css({
				top: $(window).scrollTop()+($(window).height()/2-$(".neptix_tip").outerHeight()/2),
				left: $(window).width()/2-$(".neptix_tip").outerWidth()/2
			});
		}
	});
	jQuery(".neptix_tip").remove();
	jQuery("*:not(.neptix_tip)").on("hover", function(e){
		if (!tip_lck) $(".neptix_tip").remove();
	});
	jQuery(document).on("click", ".neptix_tip .close", function(e){
		$(".neptix_tip").remove();
		return false;
	});

	FlipClock.Lang.shortdays = {
		'years'   : 'years',
		'months'  : 'months',
		'days'    : 'days',
		'hours'   : 'hours',
		'minutes' : 'min',
		'seconds' : 'sec'
	};
	FlipClock.Lang['shortdays'] = FlipClock.Lang.shortdays;

	jQuery(".event_countdown").each(function(){
		var date = new Date($(this).data("date"));
		var now = new Date();
		var timeDiff = date.getTime() - now.getTime();
		var diffsec = timeDiff / 1000; 
		if (diffsec < 0) diffsec = 0;
		$(this).FlipClock(diffsec, {
			clockFace: 'DailyCounter',
			countdown: true,
			language: "shortdays"
		});
	});

});