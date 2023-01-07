<?php  
 
class CI_Mylibrary
{
 
    public function __construct()
    {
        $this->ci =& get_instance();
    }
 
    function do_in_background($url, $params)
    {  

        $post_string = http_build_query($params);
        $parts = parse_url($url);
        $errno = 0;
        $errstr = "";
        //$referer = $parts['host'];

        //For secure server
        $fp = fsockopen('ssl://' . $parts['host'], isset($parts['port']) ? $parts['port'] : 443, $errno, $errstr, 30);
        //For localhost and un-secure server
        //$fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30);

        if(!$fp)
        {
            die("There are Some Problem");    
        }

        if(1) {

            $out = "GET ".$parts['path']."?".$post_string." HTTP/1.1\r\n";
            $out.= "Host: ".$parts['host']."\r\n";
            $out.= "Connection: Close\r\n\r\n";

        } else {

            $out = "POST ".$parts['path']." HTTP/1.1\r\n";
            $out.= "Host: ".$parts['host']."\r\n";
            $out.= "Content-Type: application/x-www-form-urlencoded\r\n";
            $out.= "Content-Length: ".strlen($post_string)."\r\n";
            $out.= "Connection: Close\r\n\r\n";

            if (isset($post_string)){
                $out.= $post_string;
            }
        }

       // print '<br> end <br>'; print '<pre>'; print_r($out); print '<br>'; //  die;   
             
        fwrite($fp, $out);

        while (!feof($fp)) {
            echo fgets($fp);
        }

        fclose($fp);
    }
}
?>