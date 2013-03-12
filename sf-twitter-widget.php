<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
/*
 * Twitter Widget
 */

require_once('base-widget.class.php');

class sf_twitter_widget extends baseWidgetClass
{
    var $name = 'Twitter';
   
   /* constructor */
   
   function __construct() 
   {
      parent::__construct( $this->name );
   }
   

   /** @see WP_Widget::widget */
   function widget($args, $instance)
   {
      $this->set_args( $args, $instance );
      $this->before_content();
      
      extract($args);
      $title = apply_filters('widget_title', $instance['title']);
      $content = $instance['content'];
      
      //Create content and put it in the $content variable
      
      $args['title'] = $title;
      $args['content'] = $content;
      ?>
    <div id="sf-twitter-feed" class="tweets"><img  id="twitter-placeholder" src="<?php echo plugin_dir_url(__FILE__);?>img/ajax-loader.gif" /></div>
<?php
      add_action('wp_footer', array(&$this, 'add_twitter_js'), 5);
      wp_enqueue_style('sf-twitter-widget', plugin_dir_url(__FILE__).'css/twitter.css');
      
      $this->after_content();
   }
   
   
   function add_twitter_js()
   {
?>
    <script type="text/javascript" src="<?php echo plugin_dir_url(__FILE__);?>js/tweetMachine.js" ></script>
    <script type="text/javascript">
        $('#sf-twitter-feed').tweetMachine(
            '@social_factory OR social_factory OR from:social_factory AND -"unfollowed me"',		
            {
                endpoint: 'search/tweets',
                backendScript: '<?php echo plugin_dir_url(__FILE__);?>sf-twitter-backend.php',
                rate: 30000, //Set refresh intervall to 30s (we do not want to exhaust Twitter's rate limit)
                limit: 5, //Get 5 Tweets
                
                localization: { //Localization for timestamp texts
                    seconds:    '<?php _e('seconds ago', 'sf-widget-pack'); ?>',
                    minute:      '<?php _e('a minute ago', 'sf-widget-pack'); ?>',
                    minutes:    '<?php _e('minutes ago', 'sf-widget-pack'); ?>',
                    hour:         '<?php _e('an hour ago', 'sf-widget-pack'); ?>',
                    hours:       '<?php _e('hours ago', 'sf-widget-pack'); ?>',
                    day:          '<?php _e('a day ago', 'sf-widget-pack'); ?>',
                    days:        '<?php _e('days ago', 'sf-widget-pack'); ?>'
                }
                
            },
            function(tweets, tweetsDisplayed) {
                
                $('#twitter-placeholder').fadeOut();
                
                if(tweetsDisplayed <= 0)
                {
                    $('#sf-twitter-feed').html('<p class="no-tweets-notice">No tweets found</p>')
                }
                
            }
        );
	</script>
<?php
   }

   /** @see WP_Widget::form */
   function form($instance)
   {
      $instance = wp_parse_args((array) $instance, array('title' => ''));
      $content = esc_attr($instance['content']);
      
      $alt_color = $instance['alt_color'];
      
      $this->before_form($instance);
      ?>
      
   <?php
      $this->after_form($instance);
         
         
   }

}
?>
