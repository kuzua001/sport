<?php

use common\component\Utils\Web;

require_once "phpQuery.php";

$data = file_get_contents(__DIR__ . '/../data/icobazaar-links');
$links = [];

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

//$startFrom = ''

foreach (json_decode(file_get_contents(__DIR__ . '/links.json')) as $link) {
    $url = 'https://icobench.com' . $link;
    $html = Web::getContents($url);
    $path = __DIR__ . '/../data/icobench/' . str_replace('ico/','', $link) . '.json';
    file_put_contents($path, $html);
}