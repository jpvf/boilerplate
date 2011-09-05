<?php 

class Admin extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->load->library('menu');
		echo Menu::generate();
		exit;
		$s = new Settings();

		$fields = $s->get_form_settings(); 

		foreach ($fields as $field)
		{
			echo Form::label($field['label'], $field['name']);
			echo $field['field'];
			echo '<p>'.$field['description'].'</p>';
		}

		$this->template->set_content('admin/test')
					   ->render();
	}

	function otra() 
	{
		echo 'espero parametros';

		debug(func_get_args());
	}


}


class Settings {
	
	function get_form_settings()
	{
		$db = db::getInstance();

		$settings = $db->get('settings')->result();

		$fields = array();

		foreach ($settings as $setting)
		{
			$fields[] =  array(
				'field' 	  => $this->form_control($setting),
				'label' 	  => $setting->title,
				'description' => $setting->description,
				'name'		  => $setting->setting
			); 
		}

		return $fields;
	}

	function form_control($setting)
	{
		switch ($setting->type)
		{
			default:
			case 'text':
				$form_control = Form::text(array(
					'id'	=> $setting->setting,
					'name'	=> $setting->setting,
					'value'	=> $setting->value
				));
				break;

			case 'textarea':
				$form_control = Form::textarea(array(
					'id'	=> $setting->setting,
					'name'	=> $setting->setting,
					'value'	=> $setting->value
				));
				break;

			case 'password':
				$form_control = Form::password(array(
					'id'	=> $setting->setting,
					'name'	=> $setting->setting,
					'value'	=> $setting->value,
					'autocomplete' => 'off',
				));
				break;

			case 'select':
				$form_control = form_dropdown($setting->slug, $this->_format_options($setting->options), $setting->value, 'class="width-20"');
				break;

			case 'select-multiple':
				$options = $this->_format_options($setting->options);
				$size = sizeof($options) > 10 ? ' size="10"' : '';
				$form_control = form_multiselect($setting->slug . '[]', $options, explode(',', $setting->value), 'class="width-20"' . $size);
				break;

			case 'checkbox':

				$form_control = '';
				$stored_values = is_string($setting->value) ? explode(',', $setting->value) : $setting->value;

				foreach ($this->_format_options($setting->options) as $value => $label)
				{
					if (is_array($stored_values))
					{
						$checked = in_array($value, $stored_values);
					}
					else
					{
						$checked = FALSE;
					}

					$form_control .= '<label></label>';
					$form_control .= Form::checkbox(array(
						'id'		=> $setting->setting . '_' . $value,
						'name'		=> $setting->setting . '[]',
						'checked'	=> $checked,
						'value'		=> $value
					));
				}
				break;

			case 'radio':

				$form_control = '';
				foreach ($this->_format_options($setting->options) as $value => $label)
				{
					$form_control .= '' . Form::radio(array(
						'id'		=> $setting->setting,
						'name'		=> $setting->setting,
						'checked'	=> $setting->value == $value,
						'value'		=> $value
					)) . ' ' . $label . '';
				}
				break;
		}

		return $form_control;
	}

}