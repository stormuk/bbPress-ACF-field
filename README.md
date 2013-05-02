bbPress Forums Advanced Custom Fields Field
=======================

This is an Advanced Custom Field (ACF) custom field to select one or many [bbPress Forums](http://www.bbpress.org/).

This provides a field that lets you select from a list of bbPress Forums.


Compatibility
============

This add-on will work with:

* version 4 and up
* version 3 and bellow

Installation
============

This add-on can be treated as both a WP plugin and a theme include.

*Plugin*
1. Copy the 'bbPress-ACF-field' folder into your plugins folder
2. Activate the plugin via the Plugins admin page

*Include*
1.  Copy the 'bbPress-ACF-field' folder into your theme folder (can use sub folders). You can place the folder anywhere inside the 'wp-content' directory
2.  Edit your functions.php file and add the code below (Make sure the path is correct to include the acf-bbpress_forums_field.php file)

```
add_action('acf/register_fields', 'my_register_fields');

function my_register_fields()
{
  include_once('acf-bbpress_forums.php');
}
```

Using the field
===============

The field lets you pick one or many forums.

The data returned is either a Forum object or an array of Forum objects.

If you are using the field to select multiple forums, you will have to iterate over the array.  You can then use the forum object as you like:

```
<ul>
  <?php
  $forums = get_field('your_field_name');

  if($forums === "")
  {
    echo "<li>No forums have been selected</li>";
  }
  else{

    foreach($forums as $forum){

      if($forum == null || !is_object($forum)){
        echo "<li>The forum has been deleted</li>";
        continue;
      }

      echo "<li><a href='".bbp_get_forum_permalink($forum->ID)."'>" . $forum->post_title . "</a></li>"; 
    }
  }
  ?>
</ul>
```

You can also use the field in to select a single forum and then show the latests topics in that forum:

Disclaimer: Due to bbPress's use of global variables this code is HORRIBLE.

```
<?php
// Get ACF field values
$forum = get_field('forum');
$limit = get_field('limit');
?>
<ul>
  <?php

    if( bbp_has_topics() ){

      // Override the topic query to set the forum to query
      $args = bbpress()->topic_query->query;
      $args['post_parent'] = $forum->ID;
      $args['posts_per_page'] = $limit;
      $args['meta_query'] = bbpress()->topic_query->meta_query->queries;

      bbpress()->topic_query = new WP_Query($args);

      while ( bbp_topics() ) : bbp_the_topic();

        // Skip sticky posts
        if(bbp_is_topic_sticky()){
          continue;
        }

        $reply_id = bbp_get_topic_last_reply_id();
        $date = get_post_time( 'd/m', false, $reply_id );

        echo "<li><span class='date'>".$date."</span> <a href='".bbp_get_topic_permalink()."'>". bbp_get_topic_title() ."</a> by ".bbp_get_reply_author_display_name()."</li>";
      endwhile;

    }
  ?>
</ul>
```



About
=====

Version: 1.0

Written by Adam Pope of Storm Consultancy - <http://www.stormconsultancy.co.uk>

Storm Consultancy are a web design and development agency based in Bath, UK.

If you are looking for a [Bath WordPress Developer](http://www.stormconsultancy.co.uk/Services/Bath-WordPress-Developers), then [get in touch](http://www.stormconsultancy.co.uk/Contact)!


Credits
=======

Thanks for Lewis Mcarey for the Users Field ACF add-on on which we based this - https://github.com/lewismcarey/User-Field-ACF-Add-on

We've released a similar plugin for [Gravity Forms](https://github.com/stormuk/Gravity-Forms-ACF-Field).