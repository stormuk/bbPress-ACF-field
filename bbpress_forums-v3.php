<?php

class acf_field_bbpress_forums extends acf_Field
{

  // vars
  var $settings, // will hold info such as dir / path
      $defaults; // will hold default field options


  /*--------------------------------------------------------------------------------------
  *
  * Constructor
  * - This function is called when the field class is initalized on each page.
  * - Here you can add filters / actions and setup any other functionality for your field
  *
  * @author Elliot Condon
  * @since 2.2.0
  *
  *-------------------------------------------------------------------------------------*/

  function __construct($parent)
  {
    // do not delete!
    parent::__construct($parent);

    // set name / title
    $this->name = 'bbpress_forums_field';
    $this->title = __('bbPress Forums');
    $this->defaults = array();

  }

  /*--------------------------------------------------------------------------------------
  *
  * create_options
  * - this function is called from core/field_meta_box.php to create extra options
  * for your field
  *
  * @params
  * - $key (int) - the $_POST obejct key required to save the options to the field
  * - $field (array) - the field object
  *
  * @author Elliot Condon
  * @since 2.2.0
  *
  *-------------------------------------------------------------------------------------*/

  function create_options($key, $field)
  {
    $field['multiple'] = isset($field['multiple']) ? $field['multiple'] : '0';
    $field['allow_null'] = isset($field['allow_null']) ? $field['allow_null'] : '0';

    ?>
    <tr class="field_option field_option_<?php echo $this->name; ?>">
      <td class="label">
        <label><?php _e("Allow Null?",'acf'); ?></label>
      </td>
      <td>
<?php
        $this->parent->create_field(array(
          'type'  =>  'radio',
          'name'  =>  'fields['.$key.'][allow_null]',
          'value' =>  $field['allow_null'],
          'choices' =>  array(
            '1' =>  'Yes',
            '0' =>  'No',
          ),
          'layout'  =>  'horizontal',
        ));
?>
      </td>
    </tr>
    <tr class="field_option field_option_<?php echo $this->name; ?>">
      <td class="label">
        <label><?php _e("Select multiple values?",'acf'); ?></label>
      </td>
      <td>
<?php
        $this->parent->create_field(array(
          'type'  =>  'radio',
          'name'  =>  'fields['.$key.'][multiple]',
          'value' =>  $field['multiple'],
          'choices' =>  array(
            '1' =>  'Yes',
            '0' =>  'No',
          ),
          'layout'  =>  'horizontal',
        ));
?>
      </td>
    </tr>
    <?php
  }


  /*--------------------------------------------------------------------------------------
  *
  * create_field
  * - this function is called on edit screens to produce the html for this field
  *
  * @author Elliot Condon
  * @since 2.2.0
  *
  *-------------------------------------------------------------------------------------*/

  function create_field($field)
  {
    $field['multiple'] = isset($field['multiple']) ? $field['multiple'] : false;


    // multiple select
    $multiple = '';
    if($field['multiple'] == '1')
    {
      $multiple = ' multiple="multiple" size="5" ';
      $field['name'] .= '[]';
    }

    // html
    echo '<select id="' . $field['name'] . '" class="' . $field['class'] . '" name="' . $field['name'] . '" ' . $multiple . ' >';

    // null
    if($field['allow_null'] == '1')
    {
      echo '<option value="null"> - Select - </option>';
    }


    if( bbp_has_forums() ){
      while ( bbp_forums() ) : bbp_the_forum();

          $key = bbp_get_forum_id();
          $value = bbp_get_forum_title();
          $selected = '';

          if(is_array($field['value']))
          {
            // 2. If the value is an array (multiple select), loop through values and check if it is selected
            if(in_array($key, $field['value']))
            {
              $selected = 'selected="selected"';
            }
          }
          else
          {
            // 3. this is not a multiple select, just check normaly
            if($key == $field['value'])
            {
              $selected = 'selected="selected"';
            }
          }

          echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';

      endwhile;
    }

    echo '</select>';
  }



  /*--------------------------------------------------------------------------------------
  *
  * get_value_for_api
  * - called from your template file when using the API functions (get_field, etc).
  * This function is useful if your field needs to format the returned value
  *
  * @params
  * - $post_id (int) - the post ID which your value is attached to
  * - $field (array) - the field object.
  *
  * @author Elliot Condon
  * @since 3.0.0
  *
  *-------------------------------------------------------------------------------------*/

  function get_value_for_api($post_id, $field)
  {
    // get value
    $value = parent::get_value($post_id, $field);

    // format value

    if(!$value)
    {
      return false;
    }

    if($value == 'null')
    {
      return false;
    }

    if(is_array($value))
    {
      foreach($value as $k => $v)
      {
        $form = bbp_get_forum($v);
        $value[$k] = array();
        $value[$k] = $form;

      }
    }
    else
    {
      $value = bbp_get_forum($value);
    }

    // return value
    return $value;

  }

}

?>