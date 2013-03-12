<?php

/*
 * Base widget
 * This class should be extended by widgets
 */

class baseWidgetClass extends WP_Widget
{
   var $args = array(), $instance = array(), $extra_classes = array();
   
   /* constructor */
   function __construct($name, $widget_options = NULL, $control_options = NULL) {
      parent::WP_Widget(false, __($name, 'Widget name'), $widget_options, $control_options);
   }
   
   function set_args($args = array(), $instance = array(), $extra_classes = array() )
   {
      $this->args = $args;
      $this->instance = $instance;
      $this->extra_classes = $extra_classes;
   }
   
   
   /**
    * Outputs the widget
    * 
    * @param type $args Shall contain title and content as keys in array
    * @param type $instance The widget instance
    * @param type $extra_classes 
    * @return boolean FALSE if the was not output successfully
    */
   function widget_template( $args = array(), $instance = array(), $extra_classes = array() ) {
      
      $this->set_args( $args, $instance, $extra_classes );
      
      $this->before_content( TRUE );
      
      echo $args['content'];
      
      $this->after_content();
      
      //echo $after_widget;
      
      return TRUE;
   }
   
   
   function before_content( $content_requred = FALSE ) {
      
      if(!is_array($this->args) || empty($this->args) )
      {
         return FALSE;
      } 
      else
      {
         /*
         print_r($this->args);
         print_r($this->instance);
         */
         extract($this->args);
      }
      
      if( $content_requred && (!isset($content) && $content == '') )
      { //Content is required
         return FALSE;
      }
     
      if(empty($extra_classes) || !is_array($extra_classes))
      { 
         $temp = $extra_classes;
         $extra_classes = array();
         $extra_classes[] = $temp;
         unset($temp);
      }
      
      if(!empty($this->instance['widget_color'])) 
      {
         $extra_classes[] = $this->instance['widget_color'];
      }
      
      if ( empty($title) )
      {
         $title = $this->instance['title'];
         
         if ( empty($title) )
         {
            $extra_classes[] = 'no-title';
         }
      }
      
      
      if (!empty($extra_classes)) {
         if( strpos($before_widget, 'class') === false ) {
            $before_widget = str_replace('>', 'class="'. implode(' ', $extra_classes) . '" >', $before_widget);
         }
         // there is 'class' attribute - prepend the value to it
         else {
            $before_widget = str_replace('class="', 'class="'. implode(' ', $extra_classes). ' ', $before_widget);
         }
      }
      
      
      echo $before_widget;
      ?>
   <div class="widget-box-wrapper clearfix">
   <?php
      if( $title )
         echo $before_title . $title . $after_title;
      else
         echo '<div class="no-title"></div>';
      ?>
   <div class="widget_content">
   <?php
   }
   
   function after_content() {
      extract($this->args);
      ?>
   </div>
</div>
   <?php
      echo $after_widget;
   }
   

   /** @see WP_Widget::widget */
   function widget($args, $instance)
   {
      extract($args);
      $title = apply_filters('widget_title', $instance['title']);
      $content = $instance['content'];
      
      $extra_class = $instance['alt_color'];
      
      if ($extra_class != "") {
      
            if( strpos($before_widget, 'class') === false ) {
              $before_widget = str_replace('>', 'class="'. $extra_class . '"', $before_widget);
            }
            // there is 'class' attribute - append width value to it
            else {
              $before_widget = str_replace('class="', 'class="'. $extra_class. ' ', $before_widget);
            }
      }
      
      echo $before_widget;
      ?>
<div class="main-box-wrapper clearfix">
   <?php
      if ($title)
         echo $before_title . $title . $after_title;
      ?>
   <div class="widget_content">
      <p>
         <?php echo $content; ?>
      </p>
   </div>
</div>
   <?php
      echo $after_widget;
   }

   /** @see WP_Widget::update */
   function update($new_instance, $old_instance)
   {
      return $new_instance;
   }

   function before_form($instance)
   {
      $instance = wp_parse_args((array) $instance, array('title' => ''));
      $title = esc_attr($instance['title']);
      
?>
      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
         <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
      </p>
<?php
      return TRUE;
   }

    function after_form($instance)
    {
        global $widget_colors;

        if (!empty($widget_colors)) :
            $instance = wp_parse_args((array) $instance, array('title' => ''));
            $alt_color = $instance['alt_color'];
?>
        <p>
            <label for="<?php echo $this->get_field_id('widget_color'); ?>"><?php _e('Färgtema:'); ?></label>
            <ul class="no-bullet">
                <li><input class="" id="<?php echo $this->get_field_id('widget_color'); ?>" name="<?php echo $this->get_field_name('widget_color'); ?>" type="radio" value="" <?php echo ($widget_color == "" || $widget_color == NULL ) ? 'checked="true"' : ''; ?> /> Ingen</li>
              <?php foreach ($widget_colors AS $key => $text) : ?>
                <li><input class="" id="<?php echo $this->get_field_id('widget_color'); ?>" name="<?php echo $this->get_field_name('widget_color'); ?>" type="radio" value="<?php echo $key; ?>" <?php echo ($widget_color == $key) ? 'checked="true"' : ''; ?> /> <?php echo $text; ?></li>
              <?php endforeach; ?>
            </ul>
        </p>
<?php
                 endif;


                 return TRUE;
             }

         }
?>
