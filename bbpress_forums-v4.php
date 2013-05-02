<?php

class acf_field_bbpress_forums_field extends acf_field
{
	// vars
	var $settings, // will hold info such as dir / path
		  $defaults; // will hold default field options


	/*
	*  __construct
	*
	*  Set name / label needed for actions / filters
	*
	*  @since	3.6
	*  @date	23/01/13
	*/

	function __construct()
	{
		// vars
		$this->name = 'bbpress_forums';
		$this->label = __('bbPress Forums');
		$this->category = __("Basic",'acf'); // Basic, Content, Choice, etc
		$this->defaults = array();


		// do not delete!
    parent::__construct();

    die("construct bbpress v4");

    	// settings
		$this->settings = array(
			'path' => apply_filters('acf/helpers/get_path', __FILE__),
			'dir' => apply_filters('acf/helpers/get_dir', __FILE__),
			'version' => '1.0.0'
		);

	}


	/*
	*  create_options()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field	- an array holding all the field's data
	*/

	function create_options( $field )
	{
		// defaults?
		$field['multiple'] = isset($field['multiple']) ? $field['multiple'] : '0';
    $field['allow_null'] = isset($field['allow_null']) ? $field['allow_null'] : '0';


		// key is needed in the field names to correctly save the data
		$key = $field['name'];


		// Create Field Options HTML
		?>
		 <tr class="field_option field_option_<?php echo $this->name; ?>">
      <td class="label">
        <label><?php _e("Allow Null?",'acf'); ?></label>
      </td>
      <td>
<?php
				do_action('acf/create_field', array(
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
        do_action('acf/create_field', array(
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


	/*
	*  create_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/

	function create_field( $field )
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







	/*
	*  load_value()
	*
	*  This filter is appied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value found in the database
	*  @param	$post_id - the $post_id from which the value was loaded from
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the value to be saved in te database
	*/

	function load_value( $value, $post_id, $field )
	{
		// Note: This function can be removed if not used
		return $value;
	}


	/*
	*  update_value()
	*
	*  This filter is appied to the $value before it is updated in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value - the value which will be saved in the database
	*  @param	$post_id - the $post_id of which the value will be saved
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$value - the modified value
	*/

	function update_value( $value, $post_id, $field )
	{
		// Note: This function can be removed if not used
		return $value;
	}


	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed to the create_field action
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/

	function format_value( $value, $post_id, $field )
	{
		// defaults?
		/*
		$field = array_merge($this->defaults, $field);
		*/

		// perhaps use $field['preview_size'] to alter the $value?


		// Note: This function can be removed if not used
		return $value;
	}


	/*
	*  format_value_for_api()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is passed back to the api functions such as the_field
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value	- the value which was loaded from the database
	*  @param	$post_id - the $post_id from which the value was loaded
	*  @param	$field	- the field array holding all the field options
	*
	*  @return	$value	- the modified value
	*/

	function format_value_for_api( $value, $post_id, $field )
	{
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


	/*
	*  load_field()
	*
	*  This filter is appied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - the field array holding all the field options
	*
	*  @return	$field - the field array holding all the field options
	*/

	function load_field( $field )
	{
		// Note: This function can be removed if not used
		return $field;
	}


	/*
	*  update_field()
	*
	*  This filter is appied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field - the field array holding all the field options
	*  @param	$post_id - the field group ID (post_type = acf)
	*
	*  @return	$field - the modified field
	*/

	function update_field( $field, $post_id )
	{
		// Note: This function can be removed if not used
		return $field;
	}


}


// create field
new acf_field_bbPress_forums_field();

?>