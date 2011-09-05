<?php 

class Menu {
	
	private static function _get_items()
	{
		$items = array(
			array(
				'title' => 'Dashboard',
				'uri'	=> 'admin/dashboard',
				'segments' => array(
					1 => 'admin',
					2 => 'dashboard'
				),
				'default' => 3
			),

			array(
				'title' => 'Settings',
				'uri'	=> 'admin/settings',
				'segments' => array(
					1 => 'admin',
					2 => 'dashboard'
				)
			),

			array(
				'title' => 'Test',
				'uri'	=> 'admin/test',
				'segments' => array(
					1 => 'admin',
					2 => 'test'
				)
			)
		);

		return $items;
	}

	static function generate()
	{
		$menu = '';
		$class = '';
		$count = 0;

		foreach (self::_get_items() as $item)
		{
			$selected = FALSE;
			
			foreach ($item['segments'] as $key => $val)
			{
				if (uri::getInstance()->get($key) == $val)
				{
					$selected = TRUE;
				}
				else
				{
					$selected = FALSE;
				}
			}

			if (isset($item['default']) AND uri::getInstance()->get($item['default']) == '')
			{
				$selected = TRUE;
			}

			if ($selected === TRUE AND $count == 0)
			{
				$class = ' class="selected"';
				$count++;
			}
			else
			{
				$class = '';
			}
						
			$menu .= "<li{$class}>".anchor($item['uri'], $item['title'])."</li>";

		}
		$menu = "<ul>{$menu}</ul>";

		return $menu;
	}

}