<?php
	$event_title_color = get_option("event_title_color");
	$event_date_color = get_option("event_date_color");
	$event_font_color = get_option("event_font_color");
	$event_link_color = get_option("event_link_color");
	$event_thumbnail_width = get_option("event_thumbnail_width");
	$event_countdown_color = get_option("event_countdown_color");
	header("Content-type: text/css");
?>
.neptix_events {
	color: #<?php echo $event_font_color; ?>;
}
.neptix_events .row {
	display: table;
	width: 100%;
	position: relative;
	text-align: center;
}
.neptix_events .row > div {
	display: table-cell;
	vertical-align: top;
	position: relative;
	padding: 10px;
}
.neptix_events .row > div:first-child {
	padding-left: 0;
}
.neptix_events .row.event_type_1 > div:first-child {
	padding-right: 0;
}
.neptix_events .row > div:last-child {
	padding-right: 0;
}
.neptix_events .row > div.t { vertical-align: top; }
.neptix_events .row > div.m { vertical-align: middle; }
.neptix_events .row > div.b { vertical-align: bottom; }
.neptix_events .row > div.col-12 { width: 100%; }
.neptix_events .row > div.col-11 { width: 91.66%; }
.neptix_events .row > div.col-10 { width: 83.33%; }
.neptix_events .row > div.col-9 { width: 75%; }
.neptix_events .row > div.col-8 { width: 66.66%; }
.neptix_events .row > div.col-7 { width: 58.33%; }
.neptix_events .row > div.col-6 { width: 50%; }
.neptix_events .row > div.col-5 { width: 41.66%; }
.neptix_events .row > div.col-4 { width: 33.33%; }
.neptix_events .row > div.col-3 { width: 25%; }
.neptix_events .row > div.col-2 { width: 16.66%; }
.neptix_events .row > div.col-1 { width: 8.33%; }

.neptix_events .row.event_type_1,
.neptix_events .row.event_type_1 > div {
	display: block!important;
	width: auto!important;
}
.neptix_events .row.event_type_1 {
	text-align: center;
}

.neptix_events p {
	margin-bottom: 10px;
}
.neptix_events a {
	text-decoration: none!important;
}
.neptix_events img.thumb_event {
	max-width: 97%;
	width: <?php echo $event_thumbnail_width; ?>px;
	height: <?php echo $event_thumbnail_width*0.6; ?>px;
}
.neptix_events .row.event_type_1 img.thumb_event {
	width: auto;
}
.neptix_events .row > .thumb {
	width: <?php echo ($event_thumbnail_width+10); ?>px;
}
.neptix_events .event_date {
	color: #<?php echo $event_date_color; ?>;
}
.neptix_events .event_title {
	color: #<?php echo $event_title_color; ?>;
}
.neptix_events .event_title:hover {
	color: #<?php echo $event_link_color; ?>;
}

.neptix_calendar,
.neptix_calendar .ui-datepicker {
	width: 100%;
	position: relative;
	font-size: 14px;
}
.neptix_calendar .ui-datepicker .ui-datepicker-prev span {
	background: url('<?php echo neptix_plugin_url; ?>images/calendar_left.png') no-repeat center center;
	margin-top: -7px;
}
.neptix_calendar .ui-datepicker .ui-datepicker-next span {
	background: url('<?php echo neptix_plugin_url; ?>images/calendar_right.png') no-repeat center center;
	margin-top: -7px;
}
.neptix_calendar .ui-datepicker .ui-datepicker-prev.ui-state-hover,
.neptix_calendar .ui-datepicker .ui-datepicker-next.ui-state-hover {
	background: none;
	border-color: transparent;
}
.neptix_calendar .ui-datepicker .ui-datepicker-title {
	font-weight: normal;
}
.neptix_calendar table {
	width: 100%;
}
.neptix_calendar .ui-corner-all {
	border-radius: 0;
}
.neptix_calendar .ui-widget-header {
	background: #3a3d3e;
	color: #FFF;
	border: none;
}
.neptix_calendar .ui-widget-content {
	background: none;
	border: none;
}
.neptix_calendar .ui-state-highlight {
	background: inherit;
	border: inherit;
}
.neptix_calendar .ui-state-highlight {
	background: none;
	border: none;
}
.neptix_calendar .ui-state-disabled {
	opacity: 1!important;
}
.neptix_calendar table {
	border: none;
}
.neptix_calendar .ui-datepicker th {
	font-weight: normal;
	font-size: 11px;
	color: #000;
}
.neptix_calendar .ui-datepicker td span,
.neptix_calendar .ui-datepicker td a {
	background: none;
	border: none;
	text-align: center;
	color: #000;
}
.neptix_calendar .ui-datepicker td.has_event span,
.neptix_calendar .ui-datepicker td.has_event a {
	background: #eb7944;
	color: #FFF;
	border-radius: 100%;
}

.neptix_tip {
	position: absolute;
	display: block;
	background: #FFF;
	padding: 4px;
	border-radius: 5px;
	z-index: 99999;
	width: 220px;
	font-size: 14px;
	text-align: left;
	border: 1px solid #b8b8b8;
	box-shadow: 0 2px 5px rgba(0,0,0,.2);
}
.neptix_tip:after {
	content: "";
	width: 0;
	height: 0;
	border-style: solid;
	border-width: 5px 4px 0 4px;
	border-color: #ffffff transparent transparent transparent;
	position: absolute;
	left: 50%;
	margin-left: -4px;
	bottom: -5px;
}
.neptix_tip.tip_bottom:after {
	border-width: 0px 4px 5px 4px;
	border-color: transparent transparent #f7f7f7 transparent;
	top: -5px;
	bottom: auto;
}
.neptix_tip .close {
	background: url('<?php echo neptix_plugin_url; ?>images/close.png') no-repeat;
	width: 24px;
	height: 24px;
	display: block;
	position: absolute;
	right: 0px;
	top: 10px;
	text-indent: -9999px;
	display: none;
}
.neptix_tip h3 {
	background: #f7f7f7;
	border-bottom: 1px solid #f0f0f0;
	padding: 5px 6px;
	font-size: 14px;
	line-height: 18px;
	font-weight: normal;
	text-transform: uppercase;
	margin: -4px -4px 4px;
	border-radius: 5px 5px 0 0;
	box-shadow: inset 0 1px 0 1px rgba(255,255,255,.5);
}
.neptix_tip .img {
	width: 95px;
}
.neptix_tip .img img {
	width: 85px;
	height: auto;
	border: 1px solid #dfdfdf;
}
.neptix_tip .row > div {
	padding: 0;
	text-align: left;
	line-height: 18px;
}
.neptix_tip .buytix {
	background: #eb7944;
	padding: 0px 4px;
	font-size: 14px;
	line-height: 20px;
	color: #FFF;
	border-radius: 2px;
	margin: 5px 0;
	display: inline-block;
}
.neptix_tip .buytix:hover {
	box-shadow: inset 0 0 50px rgba(0,0,0,.2);
}
.neptix_events .neptix_signature > div {
	text-align: right;
}
.neptix_events .buytix {
	background: #eb7944;
	padding: 4px 10px;
	color: #FFF;
	display: inline-block;
	border-radius: 2px;
}
.neptix_events .buytix:hover {
	box-shadow: inset 0 0 20px rgba(0,0,0,0.2);
}
.event_countdown {
	width: 100%;
	display: block;
	margin: 10px auto 0;
	position: relative;
}
.neptix_events .row.event_type_1 .event_countdown {
	max-width: 500px;
	height: 80px;
}
.flip-clock-wrapper .flip {
	box-shadow: none;
}
.flip-clock-wrapper ul {
	font-size: 30px;
	height: 28px;
	line-height: 28px;
    margin: 0 1% 0 0!important;
    width: 11%;
    list-style: none!important;
}
.neptix_events .row.event_type_1 .flip-clock-wrapper ul {
	height: 48px;
	line-height: 48px;
	box-shadow: 0 0 2px rgba(0,0,0,0.6);
}
.neptix_events .row.event_type_1 .flip-clock-divider .flip-clock-label {
	font-size: 14px;
}
.flip-clock-wrapper ul li a div div.inn {
	font-size: 20px;
	border-radius: 4px;
	background: #1f1f1f;
	color: #FFF;
	<?php if ($event_countdown_color != "") : ?>
	background: #<?php echo $event_countdown_color; ?>;
	<?php endif; ?>
	box-shadow: inset 0 1px 0px rgba(255,255,255,0.10), inset 0 -1px 0px 0 rgba(0,0,0,.2);
}
.neptix_events .row.event_type_1 .flip-clock-wrapper ul li a div div.inn {
	font-size: 40px;
	box-shadow: inset 0 3px 0px rgba(255,255,255,0.10), inset 0 -3px 0px 0 rgba(0,0,0,.2);
}
.flip-clock-divider {
	height: 47px;
	width: 1.3%;
}
.flip-clock-dot {
	width: 6px;
	height: 6px;
	display: none;
}
.flip-clock-dot.top {
	top: 20px;
}
.flip-clock-divider .flip-clock-label {
	top: auto;
	right: -44px;
    bottom: 0em;
    color: inherit;
    text-transform: uppercase;
    font-size: 9px;
}
.flip-clock-divider.minutes .flip-clock-label {
	right: -50px;
}
.flip-clock-divider.seconds .flip-clock-label {
	right: -54px;
}
.flip-clock-divider {
	position: absolute;
	padding-top: 30px;
}
.neptix_events .row.event_type_1 .flip-clock-divider {
	padding-top: 58px;
}
.flip-clock-divider,
.flip-clock-divider:first-child {
	width: 22%;
}
.flip-clock-divider.days {
	left: 0%;
}
.flip-clock-divider.hours {
	left: 25.33%;
}
.flip-clock-divider.minutes {
	left: 50.66%;
}
.flip-clock-divider.seconds {
	left: 75.99%;
}
.flip-clock-divider .flip-clock-label,
.flip-clock-divider.minutes .flip-clock-label,
.flip-clock-divider.seconds .flip-clock-label {
	position: relative;
	left: auto;
	right: auto;
	bottom: auto;
}
.flip-clock-divider.hours + ul,
.flip-clock-divider.minutes + ul,
.flip-clock-divider.seconds + ul {
	margin-left: 1.33%!important;
}

@media screen and (max-width: 1050px) {
	.neptix_events .row,
	.neptix_events .row > div {
		display: block;
		width: auto;
	}
	.neptix_events .row > div.col-12,
	.neptix_events .row > div.col-11,
	.neptix_events .row > div.col-10,
	.neptix_events .row > div.col-9,
	.neptix_events .row > div.col-8,
	.neptix_events .row > div.col-7,
	.neptix_events .row > div.col-6,
	.neptix_events .row > div.col-5,
	.neptix_events .row > div.col-4,
	.neptix_events .row > div.col-3,
	.neptix_events .row > div.col-2,
	.neptix_events .row > div.col-1 {
		width: auto;
	}

	.neptix_calendar,
	.neptix_calendar .ui-datepicker,
	.neptix_calendar table {
		width: 100%!important;
	}
	.neptix_tip .close {
		display: block;
	}
	.neptix_tip h3 {
		padding-right: 30px;
	}
	.neptix_tip:after {
		display: none;
	}
	.neptix_tip,
	.neptix_tip .row > div {
		text-align: center;
	}
	.neptix_tip .img {
		margin-bottom: 5px;
	}
	.neptix_tip .img,
	.neptix_tip .img img {
		width: 100%;
	}
	.neptix_tip .buytix {
		display: block;
		padding: 10px;
		width: 100%;
		padding-left: 0;
		padding-right: 0;
	}
}
<?php die(); ?>