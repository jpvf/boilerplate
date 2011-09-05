<?php 
function sanitize_output($buffer)
{
    $search = array(
        '/\>[^\S ]+/s', //strip whitespaces after tags, except space
        '/[^\S ]+\</s', //strip whitespaces before tags, except space
        '/(\s)+/s'  // shorten multiple whitespace sequences
        );
    $replace = array(
        '>',
        '<',
        '\\1'
        );
  $buffer = preg_replace($search, $replace, $buffer);
    return $buffer;
}

function salt_it($str = '')
{
    if($str == ''){
        return FALSE;
    }
    $salt = item('salt');
    $salt = md5(sha1($salt));
    $str  = sha1(md5($str));
    $str  = md5(sha1(md5($salt . $str . $salt)));
    return $str;
}


function get_rand_id($length)
{
    $validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ+-*#&@!?";
    $validCharNumber = strlen($validCharacters);
 
    $result = "";
 
    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
 
    return $result;
}


function send_mail($email = '' , $name = '', $subject = '', $alt = '', $body = '')
{
    if($subject == '' OR $name == '' OR $email == '' OR $body == ''){
       return;
    }
	$load = loader::getInstance();
	$load->library('mailer');
	$load->library('mailer.smtp');
	
    $mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch

	try 
	{
        $mail->CharSet    =   "UTF-8";
        $mail->AddAddress($email, $name);
        $mail->SetFrom(item('admin_email'), 'SAGA');
        $mail->Subject = $subject;
        $mail->AltBody = ($alt != '') ? $alt : 'To view the message, please use an HTML compatible email viewer!';
        $mail->MsgHTML($body);
        $mail->Send();
        echo "Mensaje enviado a " . $email . br();
	} 
	catch (phpmailerException $e) 
	{
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} 
	catch (Exception $e) 
	{
        echo $e->getMessage(); //Boring error messages from anything else!
	}

}

	
	
	
	
	function diff($d1, $d2)
	{
	    $d1 = (is_string($d1) ? strtotime($d1) : $d1);
	    $d2 = (is_string($d2) ? strtotime($d2) : $d2);
	
	    $diff_secs = abs($d1 - $d2);
	    $base_year = min(date("Y", $d1), date("Y", $d2));
	
	    $diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	    return array(
	        "years" => date("Y", $diff) - $base_year,
	        "months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
	        "months" => date("n", $diff) - 1,
	        "days_total" => floor($diff_secs / (3600 * 24)),
	        "days" => date("j", $diff) - 1,
	        "hours_total" => floor($diff_secs / 3600),
	        "hours" => date("G", $diff),
	        "minutes_total" => floor($diff_secs / 60),
	        "minutes" => (int) date("i", $diff),
	        "seconds_total" => $diff_secs,
	        "seconds" => (int) date("s", $diff)
	    );
	}
	
	
	

	
	function item($item = null)
	{
		include(RUTA_CONFIG . 'config' .EXT);
		return $config[$item];
	}
	
	function create_hash($id = '')
	{
		return sha1(md5(sha1($id . date('Y-m-d h:i:s a') )));
	}
	

	
	function reverse_strrchr($haystack, $needle)
    {
        $pos = strrpos($haystack, $needle);
        if ($pos === false) {
            return $haystack;
        }
        return substr($haystack, 0, $pos );
    }
    
    function format_size($size)
    {
      $sizes = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
      if ($size == 0) { return('n/a'); } else {
      return (round($size/pow(1024, ($i = floor(log($size, 1024)))), $i > 1 ? 2 : 0) . $sizes[$i]); }
    }
    
    function array_cmp($a, $b)
    {
        $al = strtolower($a->consecutivo);
        $bl = strtolower($b->consecutivo);
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? +1 : -1;
    }

    function clean_downloads_name($name = '')
    {
        if($name == ''){
            return;
        }
        $ext = strrchr($name,'.');
        $name = reverse_strrchr($name,'.');
        $name = reverse_strrchr($name,'-');
        return $name . $ext;
    }
    
    function files_identical($fn1, $fn2) {
        if(filetype($fn1) !== filetype($fn2))
            return FALSE;
    
        if(filesize($fn1) !== filesize($fn2))
            return FALSE;
    
        if(!$fp1 = fopen($fn1, 'rb'))
            return FALSE;
    
        if(!$fp2 = fopen($fn2, 'rb')) {
            fclose($fp1);
            return FALSE;
        }
    
        $same = TRUE;
        while (!feof($fp1) and !feof($fp2))
            if(fread($fp1, READ_LEN) !== fread($fp2, READ_LEN)) {
                $same = FALSE;
                break;
            }
    
        if(feof($fp1) !== feof($fp2))
            $same = FALSE;
    
        fclose($fp1);
        fclose($fp2);
    
        return $same;
    }
	
    
    function formato_monto($monto = 0)
    {
        return '$ ' . number_format($monto);
    }
	

	
/* End of file helpers.phtml */
/* Location: /includes/helpers.phtml */
