<?php 
/**
 * Funcion para determinar si es un llamado Ajax o no
 *
 * @access  public
 * @param   string
 * @return  boolean
 */

if( ! function_exists('is_xhr'))
{ 
    function is_xhr()
    {
        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) && empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
            return FALSE;
        }else{
            if($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest' ){
                return TRUE;
            }
        }
        return FALSE;
        
    }
}

/**
 * Crea una etiqueta anchor, solo es necesario agregar en el href los segmentos despues
 * del index.phtml
 *
 * @access  public
 * @param   string
 * @return  string
 */

if ( ! function_exists('anchor'))
{   
    function anchor($href = '', $text = '', $attrs = array(), $external = FALSE)
    {
        $form_attrs = array();

        foreach ($attrs as $key => $val)
        {
            $form_attrs[] = "$key='$val'";
        }

        $attrs = ' '.implode(' ', $form_attrs);

        $anchor = '<a';
        $anchor .= ' href ="' . (($external !== FALSE) ? '' : get_url()) . ((substr($href,0,1) == '/') ? '' : '/' ) . $href . '" ';
        $anchor .= $attrs;    
        $anchor .= '>';
        $anchor .= $text;
        $anchor .= '</a>';
        return $anchor;
    }
}

/**
 * Devuelve la url del sitio, dependiendo del archivo config/config.phtml, devuelve
 * la direccion con o sin la cadena del archivo index.phtml
 *
 * @access  public
 * @param   string
 * @return  string
 */

if( ! function_exists('get_url'))
{
    function get_url()
    {
        $host = item('base_url');
        $index = item('index_page');
        
        if(empty($index)){
           $host = substr($host,0,-1);
        }
        return $host . $index ;
    }
}

/**
 * Devuelve el dominio del servidor.
 *
 * @access  public
 * @param   string
 * @return  string
 */

if( ! function_exists('base_url'))
{
    function base_url()
    {
        return item('base_url');
    }
}

/**
 * Redirige hacia alguna pagina, disponible con refresh o solo location.
 *
 * @access  public
 * @param   string
 * @return  string
 */

if( ! function_exists('redirect'))
{
    function redirect($page = '', $method = 'location', $http_response_code = 302)
    {
        switch($method)
        {
            case 'refresh'  : header("Refresh:0;url=".$page);
                break;
            default         : header("Location: ".$page, TRUE, $http_response_code);
                break;
        }
        exit;
    }
}