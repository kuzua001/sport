<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 5/13/18
 * Time: 2:09 PM
 */

namespace common\component\Utils;


class Web
{
    public static function getContents(string $url): string
    {
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_USERAGENT      => "spider",
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 120,
            CURLOPT_TIMEOUT        => 120,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_SSL_VERIFYPEER => false
        ];

        $ch      = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
//        $err     = curl_errno($ch);
//        $errmsg  = curl_error($ch);
//        $header  = curl_getinfo($ch);
        curl_close($ch);

        /** todo think about
        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;
        */

        return $content;
    }
}