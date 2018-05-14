<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 5/13/18
 * Time: 3:37 PM
 */

namespace common\component\Utils;


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