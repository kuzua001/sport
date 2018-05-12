<?php

require_once "phpQuery.php";

$data = file_get_contents(__DIR__ . '/../data/icobazaar-links');
$links = [];

function get_web_page( $url )
{
    $options = array(
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_USERAGENT      => "spider", // who am i
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}

/**
 * pre-parse
 */
//for ($id = 1; $id < 263; $id ++) {
//    $data = get_web_page('https://icobench.com/icos?page=' . $id);
//    $dom = phpQuery::newDocument($data['content']);
//    foreach ($dom['.ico_list td a.name'] as $link) {
//        $links[] = pq($link)->attr('href');
//    }
//}

foreach (json_decode(file_get_contents(__DIR__ . '/links.json')) as $link) {
    $url = 'https://icobench.com' . $link;
    $data = get_web_page($url);
    $path = __DIR__ . '/../data/icobench/' . str_replace('ico/','', $link) . '.json';
    file_put_contents($path, $data['content']);
}