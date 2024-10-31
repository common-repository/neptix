<?php

class NeptixCalendarWidget extends WP_Widget {
    function NeptixCalendarWidget() {
        $options = array( 'description' => __( "Neptix Widget Calendar") );
        parent::WP_Widget(false, $name = 'Neptix Calendar', $options);	
    }
    function widget($args, $instance)
    {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $exclude_events = $instance['exclude_events'];
        if ($instance['calendar_width'] == "") $instance['calendar_width'] = 200;
        echo $before_widget;
			echo $before_title . $title . $after_title;
			echo '<div class="neptix_events"><div class="neptix_calendar" data-json="'.home_url().'/?neptix_ajax_calendar&type='.$instance['type'].'&id='.$instance['id'].'&exclude='.$exclude_events.'&private_events='.$instance['show_private_events'].'" data-buytix="'.$instance['buytix'].'"></div></div>';
        echo $after_widget;
        echo '<style type="text/css">';
            if ($instance['calendar_width'] != "")
            {
                echo '#'.$args["widget_id"].' .neptix_calendar, #'.$args["widget_id"].' .neptix_calendar .ui-datepicker, #'.$args["widget_id"].' .neptix_calendar table {';
                    echo 'width: '.$instance['calendar_width'].'px; table-layout: fixed;';
                echo '}';
                echo '#'.$args["widget_id"].' .neptix_calendar .ui-datepicker th, #'.$args["widget_id"].' .neptix_calendar .ui-datepicker td span, #'.$args["widget_id"].' .neptix_calendar .ui-datepicker td a {';
                    echo 'height: '.($instance['calendar_width']/7-7).'px;';
                    echo 'line-height: '.($instance['calendar_width']/7-10).'px;';
                echo '}';
            }        
            if ($instance['header_color'] != "")
            {
                echo '#'.$args["widget_id"].' .neptix_calendar .ui-widget-header {';
                    echo 'background: '.$instance['header_color'].';';
                echo '}';
            }
            if ($instance['event_day_color'] != "")
            {
                echo '#'.$args["widget_id"].' .neptix_calendar .ui-datepicker td.has_event span, #'.$args["widget_id"].' .neptix_calendar .ui-datepicker td.has_event a {';
                    echo 'background: '.$instance['event_day_color'].';';
                echo '}';
                echo '.neptix_tip .buytix {';
                    echo 'background: '.$instance['event_day_color'].';';
                echo '}';
            }
            if ($instance['calendar_font_color'] != "")
            {
                echo '#'.$args["widget_id"].' .neptix_calendar .ui-datepicker th, #'.$args["widget_id"].' .neptix_calendar .ui-datepicker td span, #'.$args["widget_id"].' .neptix_calendar .ui-datepicker td a {';
                    echo 'color: '.$instance['calendar_font_color'].';';
                echo '}';
            }
        echo '</style>';
    }
    function update($new_instance, $old_instance) {
        return $new_instance;
    }
    function form($instance) {				
		$title = esc_attr(isset($instance['title']) ? $instance['title'] : "Events");        
        $type = esc_attr(isset($instance['type']) ? $instance['type'] : "");
        $id = esc_attr(isset($instance['id']) ? $instance['id'] : "");
        $show_private_events = esc_attr(isset($instance['show_private_events']) ? $instance['show_private_events'] : "");
        $event_day_color = esc_attr(isset($instance['event_day_color']) ? $instance['event_day_color'] : "#EB7944");
        $header_color = esc_attr(isset($instance['header_color']) ? $instance['header_color'] : "#3A3D3E");
        $calendar_width = esc_attr(isset($instance['calendar_width']) ? $instance['calendar_width'] : "200");
        $calendar_font_color = esc_attr(isset($instance['calendar_font_color']) ? $instance['calendar_font_color'] : "#000000");
        $exclude_events = esc_attr(isset($instance['exclude_events']) ? $instance['exclude_events'] : "");
        $buytix = esc_attr(isset($instance['buytix']) ? $instance['buytix'] : "Buy Tix");
        ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title :</label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />	        	
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('type'); ?>">Type :</label>
			<select class="widefat event_type" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
				<option value="2" <?php if ($type == 2) echo "selected"; ?>>Seller Specific Events</option>
				<option value="3" <?php if ($type == 3) echo "selected"; ?>>Venue Specific Events</option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('id'); ?>">ID :</label>
			<input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id; ?>" />	        	
		</p>
        <p>
            <label for="<?php echo $this->get_field_id('calendar_width'); ?>">Calendar width :</label>
            <input class="widefat" id="<?php echo $this->get_field_id('calendar_width'); ?>" name="<?php echo $this->get_field_name('calendar_width'); ?>" type="text" value="<?php echo $calendar_width; ?>" />                
        </p>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('show_private_events'); ?>" name="<?php echo $this->get_field_name('show_private_events'); ?>" <?php if($show_private_events=="on") echo "checked"; ?> />
            <label for="<?php echo $this->get_field_id('show_private_events'); ?>">Show private events</label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('exclude_events'); ?>">Exclude events (optional) :</label>
            <input class="widefat" id="<?php echo $this->get_field_id('exclude_events'); ?>" name="<?php echo $this->get_field_name('exclude_events'); ?>" type="text" value="<?php echo $exclude_events; ?>" />             
            <small>Separate each event ID or URL with a comma ","</small>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('header_color'); ?>">Month/Year color (Header) :</label><br/>
            <div class="irpicker">
                <input class="neptix_wp_colorpicker" type="text" id="<?php echo $this->get_field_id('header_color'); ?>" name="<?php echo $this->get_field_name('header_color'); ?>" value="<?php echo $header_color; ?>" /> 
            </div>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('event_day_color'); ?>">Event day color :</label><br/>
            <div class="irpicker">
                <input class="neptix_wp_colorpicker" type="text" id="<?php echo $this->get_field_id('event_day_color'); ?>" name="<?php echo $this->get_field_name('event_day_color'); ?>" value="<?php echo $event_day_color; ?>" /> 
            </div>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('calendar_font_color'); ?>">Font color :</label><br/>
            <div class="irpicker">
                <input class="neptix_wp_colorpicker" id="<?php echo $this->get_field_id('calendar_font_color'); ?>" name="<?php echo $this->get_field_name('calendar_font_color'); ?>" type="text" value="<?php echo $calendar_font_color; ?>" />                
            </div>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('buytix'); ?>">BuyTix button :</label><br/>
            <input class="widefat" id="<?php echo $this->get_field_id('buytix'); ?>" name="<?php echo $this->get_field_name('buytix'); ?>" type="text" value="<?php echo $buytix; ?>" />
        </p>
        <script type="text/javascript">
            jQuery(document).ready(function($)
            {
                $("#widgets-right .irpicker").each(function(){
                    var cp = $(this).find("input.neptix_wp_colorpicker");
                    var cp_id = cp.attr("id"),
                        cp_name = cp.attr("name"),
                        cp_value = cp.attr("value");
                    if (typeof cp_value == "undefined") cp_value = "";
                    $(this).html('<input class="neptix_wp_colorpicker" type="text" id="'+cp_id+'" name="'+cp_name+'" value="'+cp_value+'" />');
                    $(this).find(".neptix_wp_colorpicker").wpColorPicker();
                });
            });
        </script>
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("NeptixCalendarWidget");'));

?>