<?php

namespace common\component\Parsers\Model\Loaders;

use Closure;
use common\component\Parsers\Exception\FileLoaderException;
use common\component\Parsers\Model\CrawledDataInterface;
use common\component\Parsers\Model\CrawledJson;
use common\component\Parsers\ProjectLoaderInterface;
use common\component\Parsers\Model\Parsers\ArrayParser;
use common\models\project\Source;
use Yii;

class FileProjectLoader implements ProjectLoaderInterface {
    /** @var string  */
    private $path;

    /** @var Closure */
    private $getResourceFn;

    /** @var Source */
    private $source;

    public function __construct(string $pathAlias, Source $source, Closure $getResourceFn = null) {
        $this->path   = Yii::getAlias($pathAlias);
        $this->source = $source;

        if ($this->path === false) {
            throw new FileLoaderException('Wrong parth or alias provided');
        }

        $this->getResourceFn = $getResourceFn;
    }

    /**
     * @return CrawledDataInterface[]
     * @throws \Exception
     */
    public function getCrawledDataCollection(): array {
        $result = [];

        if ($handle = opendir($this->path)) {

            while (false !== ($file = readdir($handle))) {
                $filePath = $this->path . '/' . $file;

                if (!is_file($filePath)) {
                    continue;
                }

                $resourceId = $this->getResourceId($file);
                $json = file_get_contents($filePath);
                $parser = ArrayParser::getInstance($this->source, $resourceId);

                try {
                    $item   = new CrawledJson($json, $parser);
                } catch (\Exception $ex) {
                    continue;
                }

                $result[] = $item;
            }

            closedir($handle);
        }

        return $result;
    }

    private function getResourceId(string $filename): string {
        if ($this->getResourceFn === null || !$this->getResourceFn instanceof Closure) {
            return pathinfo($filename, PATHINFO_FILENAME);
        }

        try {
            return ($this->getResourceFn)($filename);
        } catch (\Exception $ex) {
            throw new \Exception('Unable to execute getResourceFn closure'); // todo change to special exception
        }
    }
}