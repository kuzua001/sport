<?php

namespace common\component\Parsers;

use common\component\Parsers\Model\CrawledDataInterface;

interface ProjectLoaderInterface {
    /**
     * @return CrawledDataInterface[]
     */
    public function getCrawledDataCollection(): array;
}