<?php 

function menu_selected($item = '', $segment = 1, $default = FALSE)
{
	$uri = uri::getInstance();
	return ($uri->get($segment) == $item OR ($uri->get($segment) == '' && $default === TRUE)) ? ' class="selected"' : '';
}