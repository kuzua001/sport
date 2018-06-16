<?php

namespace common\component\Parsers\Model\Parsers;

use common\component\Parsers\SourceSettings;
use common\component\Utils\Json;
use common\models\project\Source;
use Exception;
use Yii;

class ArrayParser extends BasicParser
{
    private const URL_PLACEHOLDER = '{URL}';

    /** @var  array */
    private $data;

    /** @var array  */
    protected static $allowedSourceIds = [
        SourceSettings::TYPE_ICOBAZAAR_SETTINGS
    ];

    public function setupDataForParsing(array $data)
    {
        $this->data = $data;
    }

    public function parseProjectName(): ?string
    {
        return Json::extractStringByPath($this->data, $this->projectNamePath);
    }

    public function parseProjectDescription(): ?string {
        return Json::extractStringByPath($this->data, $this->projectDescriptionPath);
    }

    public function parseProjectData(): array
    {
        $result = [];
        foreach ($this->projectDataFieldsPaths as $key => $path) {
            $result[$key] = Json::extractDataByPath($this->data, $path);
        }

        return $result;
    }

    public function parseLogoUrl(): ?string
    {
        return Json::extractStringByPath($this->data, $this->logoUrlPath);
    }

    public function parseWebsiteUrl(): ?string
    {
        return Json::extractStringByPath($this->data, $this->projectWebsiteUrlPath);
    }

    /**
     * @return null|string
     * @throws Exception
     */
    public function parseExternalUrl(): ?string
    {
        if ($this->externalUrlPath === null) {
            if ($this->externalUrlPlaceholderPath === null || $this->externalUrlPattern === null) {
                throw new Exception('Not provided url placeholder and/or url pattern in case extracted url is combined'); // todo сделать свой эксепшен
            }

            $url = Json::extractStringByPath($this->data, $this->externalUrlPlaceholderPath);

            return str_replace(self::URL_PLACEHOLDER, $url, $this->externalUrlPattern);
        }

        return $this->externalUrlPath;
    }

    protected static function obtainParserSettings(Source $source): array
    {
        return Yii::$app->params['crawling']['json_settings'][$source->getName()];
    }
}