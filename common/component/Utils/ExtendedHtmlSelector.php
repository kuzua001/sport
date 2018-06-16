<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 5/13/18
 * Time: 3:37 PM
 */

namespace common\component\Utils;


$selector = [
    'team' => [
        'type' => 'list',
        'root' => '#team > .row > div',
        'properties' => [
            'name' => 'h3',
            'job' => 'h4',
            'linkedin' => ['.socials a', 'href', 'Attribute::Same']
        ],

    ]
];

var_dump($selector);

class ExtendedHtmlSelector
{
    public const TYPE_VALUE   = 'value';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_LIST    = 'list';

    private $dataType;

    private $selector;

    private $modificator;

    private $fullSelector;
}