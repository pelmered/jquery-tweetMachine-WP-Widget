jquery-tweetMachine-WP-Widget
=============================

#WP Widget usning [ryangiglio's](https://github.com/ryangiglio/) excellent [jquery-tweetMachine](https://github.com/ryangiglio/jquery-tweetMachine) Twitter live feed jQuery plugin


## Setup

1. Get API keys for authenticating.To do this:

  1.1. Go to https://dev.twitter.com/apps and create a new application
  
  1.2. Choose your new app from the list
  
  1.3. Under the Details tab you can see your Consumer key and Consumer secret. Copy these into $consumerKey and $consumerSecret
  
  1.4. At the bottom of the page, click "Create my access token" under the "Your access token" heading. This will generate and Access token and Access token secret. Copy these into $accessToken and $accessTokenSecret

2. Include sf-twitter-widget.php in your theme. Preferably in the functions.php file usning something similar to:

    require_once('path/to/sf-twitter-widget.php');
    
3. The Widget should now be among the Wordpress widgets in WP Admin. Add it and enjoy!
