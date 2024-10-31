<?php

class NeptixCountdownWidget extends WP_Widget {
    function NeptixCountdownWidget() {
        $options = array( 'description' => __( "Neptix Countdown Widget") );
        parent::WP_Widget(false, $name = 'Neptix Countdown', $options);   
    }
    function widget($args, $instance)
    {
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $total_events = $instance['total_events'];
        $event_title_color = $instance['event_title_color'];
        $event_date_color = $instance['event_date_color'];
        $event_font_color = $instance['event_font_color'];
        $event_link_color = $instance['event_link_color'];
        $countdown_width = $instance['countdown_width'];
        $countdown_color = $instance['countdown_color'];
        $show_only_events = $instance['show_only_events'];
        $exclude_events = $instance['exclude_events'];
        $show_thumb = $instance['show_thumb'];
        $alignment = $instance['alignment'];
        $private_events = $instance['show_private_events'];
        echo $before_widget;
            echo $before_title . $title . $after_title;
            echo neptix_get_events($instance['type'], $instance['id'], $is_widget = true, $total_events, $show_thumb, "all", $show_only_events, $exclude_events, $private_events, $alignment);
        echo $after_widget;

        echo '<style type="text/css">';
            if ($instance['thumb_width'] != "")
            {
                echo '#'.$args["widget_id"].' .thumb {';
                    echo 'width: '.$instance['thumb_width'].'px;';
                echo '}';
                echo '#'.$args["widget_id"].' img {';
                    echo 'width: '.$instance['thumb_width'].'px;';
                echo '}';
            }
            if ($instance['countdown_width'] != "")
            {
                echo '#'.$args["widget_id"].' .event_countdown {';
                    echo 'width: '.$instance['countdown_width'].'px;';
                echo '}';
            }
            if ($instance['countdown_color'] != "")
            {
                echo '#'.$args["widget_id"].' .flip-clock-wrapper ul li a div div.inn {';
                    echo 'background-color: '.$instance['countdown_color'].';';
                echo '}';
            }
            if ($instance['event_title_color'] != "")
            {
                echo '#'.$args["widget_id"].' .neptix_events .event_title {';
                    echo 'color: '.$instance['event_title_color'].';';
                echo '}';
            }
            if ($instance['event_date_color'] != "")
            {
                echo '#'.$args["widget_id"].' .neptix_events .event_date {';
                    echo 'color: '.$instance['event_date_color'].';';
                echo '}';
            }
            if ($instance['event_font_color'] != "")
            {
                echo '#'.$args["widget_id"].' .neptix_events {';
                    echo 'color: '.$instance['event_font_color'].';';
                echo '}';
            }
            if ($instance['event_link_color'] != "")
            {
                echo '#'.$args["widget_id"].' .neptix_events .event_title:hover {';
                    echo 'color: '.$instance['event_link_color'].';';
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
        $total_events = esc_attr(isset($instance['total_events']) ? $instance['total_events'] : "5");
        $show_private_events = esc_attr(isset($instance['show_private_events']) ? $instance['show_private_events'] : "");
        $show_thumb = esc_attr(isset($instance['show_thumb']) ? $instance['show_thumb'] : "on");
        $thumb_width = esc_attr(isset($instance['thumb_width']) ? $instance['thumb_width'] : "150");
        $event_title_color = esc_attr(isset($instance['event_title_color']) ? $instance['event_title_color'] : "#EB7944");
        $event_date_color = esc_attr(isset($instance['event_date_color']) ? $instance['event_date_color'] : "#CCCCCC");
        $event_font_color = esc_attr(isset($instance['event_font_color']) ? $instance['event_font_color'] : "#000000");
        $event_link_color = esc_attr(isset($instance['event_link_color']) ? $instance['event_link_color'] : "#000000");
        $countdown_width = esc_attr(isset($instance['countdown_width']) ? $instance['countdown_width'] : "200");
        $countdown_color = esc_attr(isset($instance['countdown_color']) ? $instance['countdown_color'] : "#1F1F1F");
        $show_only_events = esc_attr(isset($instance['show_only_events']) ? $instance['show_only_events'] : "");
        $exclude_events = esc_attr(isset($instance['exclude_events']) ? $instance['exclude_events'] : "");
        $alignment = esc_attr(isset($instance['alignment']) ? $instance['alignment'] : "1");
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Title :</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />               
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('type'); ?>">Type :</label>
            <select class="widefat event_type" id="<?php echo $this->get_field_id('type'); ?>" name="<?php echo $this->get_field_name('type'); ?>">
                <option value="1" <?php if ($type == 1) echo "selected"; ?>>Single Event</option>
                <option value="2" <?php if ($type == 2) echo "selected"; ?>>Seller Specific Events</option>
                <option value="3" <?php if ($type == 3) echo "selected"; ?>>Venue Specific Events</option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('id'); ?>">ID :</label>
            <input class="widefat" id="<?php echo $this->get_field_id('id'); ?>" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo $id; ?>" />                
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('countdown_width'); ?>">Countdown width :</label>
            <input class="widefat" id="<?php echo $this->get_field_id('countdown_width'); ?>" name="<?php echo $this->get_field_name('countdown_width'); ?>" type="text" value="<?php echo $countdown_width; ?>" />              
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('countdown_color'); ?>">Countdown color :</label><br/>
            <div class="irpicker">
                <input class="neptix_wp_colorpicker" id="<?php echo $this->get_field_id('countdown_color'); ?>" name="<?php echo $this->get_field_name('countdown_color'); ?>" type="text" value="<?php echo $countdown_color; ?>" />              
            </div>
        </p>
        <div class="multiple_events" style="display: none">
            <p>
                <input type="checkbox" id="<?php echo $this->get_field_id('show_private_events'); ?>" name="<?php echo $this->get_field_name('show_private_events'); ?>" <?php if($show_private_events=="on") echo "checked"; ?> />
                <label for="<?php echo $this->get_field_id('show_private_events'); ?>">Show private events</label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('total_events'); ?>">Total events :</label>
                <input class="widefat" id="<?php echo $this->get_field_id('total_events'); ?>" name="<?php echo $this->get_field_name('total_events'); ?>" type="text" value="<?php echo $total_events; ?>" />              
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('show_only_events'); ?>">Show only events (optional) :</label>
                <input class="widefat" id="<?php echo $this->get_field_id('show_only_events'); ?>" name="<?php echo $this->get_field_name('show_only_events'); ?>" type="text" value="<?php echo $show_only_events; ?>" />             
                <small>Separate each event ID or URL with a comma ","</small>
            </p> 
            <p>
                <label for="<?php echo $this->get_field_id('exclude_events'); ?>">Exclude events (optional) :</label>
                <input class="widefat" id="<?php echo $this->get_field_id('exclude_events'); ?>" name="<?php echo $this->get_field_name('exclude_events'); ?>" type="text" value="<?php echo $exclude_events; ?>" />             
                <small>Separate each event ID or URL with a comma ","</small>
            </p>
        </div>
        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('show_thumb'); ?>" name="<?php echo $this->get_field_name('show_thumb'); ?>" <?php if($show_thumb=="on") echo "checked"; ?> />
            <label for="<?php echo $this->get_field_id('show_thumb'); ?>">Show Thumbnail</label>
        </p>          
        <p>
            <label for="<?php echo $this->get_field_id('thumb_width'); ?>">Thumbnail width :</label>
            <input class="widefat" id="<?php echo $this->get_field_id('thumb_width'); ?>" name="<?php echo $this->get_field_name('thumb_width'); ?>" type="text" value="<?php echo $thumb_width; ?>" />             
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('event_title_color'); ?>">Event Title :</label><br/>
            <div class="irpicker">
                <input class="neptix_wp_colorpicker" type="text" id="<?php echo $this->get_field_id('event_title_color'); ?>" name="<?php echo $this->get_field_name('event_title_color'); ?>" value="<?php echo $event_title_color; ?>" /> 
            </div>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('event_date_color'); ?>">Event Date :</label><br/>
            <div class="irpicker">
                <input class="neptix_wp_colorpicker" type="text" id="<?php echo $this->get_field_id('event_date_color'); ?>" name="<?php echo $this->get_field_name('event_date_color'); ?>" value="<?php echo $event_date_color; ?>" /> 
            </div>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('event_font_color'); ?>">Font Color :</label><br/>
            <div class="irpicker">
                <input class="neptix_wp_colorpicker" type="text" id="<?php echo $this->get_field_id('event_font_color'); ?>" name="<?php echo $this->get_field_name('event_font_color'); ?>" value="<?php echo $event_font_color; ?>" /> 
            </div>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('event_link_color'); ?>">Link Color :</label><br/>
            <div class="irpicker">
                <input class="neptix_wp_colorpicker" type="text" id="<?php echo $this->get_field_id('event_link_color'); ?>" name="<?php echo $this->get_field_name('event_link_color'); ?>" value="<?php echo $event_link_color; ?>" /> 
            </div>
        </p>
        <p><label>Alignment :</label></p>
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td>
                        <input type="radio" id="<?php echo $this->get_field_id('alignment'); ?>1" name="<?php echo $this->get_field_name('alignment'); ?>" value="1" <?php if ($alignment=="1") echo "checked"; ?>><br/>
                        <label for="<?php echo $this->get_field_id('alignment'); ?>1"><img src="<?php echo neptix_plugin_url; ?>images/template1.jpg" alt=""></label>
                    </td>
                    <td>
                        <input type="radio" id="<?php echo $this->get_field_id('alignment'); ?>2" name="<?php echo $this->get_field_name('alignment'); ?>" value="2" <?php if ($alignment=="2") echo "checked"; ?>><br/>
                        <label for="<?php echo $this->get_field_id('alignment'); ?>2"><img src="<?php echo neptix_plugin_url; ?>images/template2.jpg" alt=""></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="radio" id="<?php echo $this->get_field_id('alignment'); ?>3" name="<?php echo $this->get_field_name('alignment'); ?>" value="3" <?php if ($alignment=="3") echo "checked"; ?>><br/>
                        <label for="<?php echo $this->get_field_id('alignment'); ?>3"><img src="<?php echo neptix_plugin_url; ?>images/template3.jpg" alt=""></label>
                    </td>
                    <td>
                        <input type="radio" id="<?php echo $this->get_field_id('alignment'); ?>4" name="<?php echo $this->get_field_name('alignment'); ?>" value="4" <?php if ($alignment=="4") echo "checked"; ?>><br/>
                        <label for="<?php echo $this->get_field_id('alignment'); ?>4"><img src="<?php echo neptix_plugin_url; ?>images/template4.jpg" alt=""></label>
                    </td>
                </tr>                
            </tbody>
        </table>
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

                if ($("#<?php echo $this->get_field_id('type'); ?>").val() == "1")
                {
                    $("#<?php echo $this->get_field_id('type'); ?>").parent().parent().find(".multiple_events").hide();
                } else {
                    $("#<?php echo $this->get_field_id('type'); ?>").parent().parent().find(".multiple_events").show();
                }

                $(document).on("change", ".event_type", function(){
                    if ($(this).val() == "1") {
                        $(this).parent().parent().find(".multiple_events").hide();
                    } else {
                        $(this).parent().parent().find(".multiple_events").show();
                    }
                    return false;
                });
            });
        </script>
        <?php 
    }
}
add_action('widgets_init', create_function('', 'return register_widget("NeptixCountdownWidget");'));

?>