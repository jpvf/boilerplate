<?php

function _post($item = NULL)
{
	if (is_null($item) OR ! input::getInstance()->post($item))
	{
		return FALSE;
	}
	return db::getInstance()->escape_str(input::getInstance()->post($item), TRUE);
}

function _set_token()
{
	$token = config::getInstance()->get('token');
	
	session::getInstance()->set($token, $token);
	
	return $token;	
}

function _check_token()
{
	$session = session::getInstance();
	$token   = input::getInstance()->post('token');
	$check   = $session->get($token) !== FALSE ? TRUE : FALSE ;
	$session->unset_var($token);
	if ($check === FALSE)
	{
		redirect(get_url());
	}
	return TRUE;
}