<?php

$data = file_get_contents(__DIR__ . '/../data/links/icobazaar-links');

foreach (explode("\n", $data) as $id) {
  $link = 'https://api.icobazaar.com/api/v2/icolist?link=' . $id . '&limit=1';
  $path = __DIR__ . '/../data/icobazaar/' . $id . '.json';
  copy($link, $path);
}