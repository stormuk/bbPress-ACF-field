bbPress Forums Advanced Custom Fields Field
=======================

This is an Advanced Custom Field (ACF) custom field to select one or many [bbPress Forums](http://www.bbpress.org/).

This provides a field that lets you select from a list of bbPress Forums.


Installation
============

Download or clone the repository for bbPress-ACF-Field and put the bbpress_forums.php in your theme somewhere.  We like to create a Custom-Fields sub-directory to keep things tidy.

Register the field in your functions.php file

```
if(function_exists('register_field')) {  
  register_field(‘bbPress_forums_field', dirname(__File__) . '/Custom-Fields/bbpress_forums.php');
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