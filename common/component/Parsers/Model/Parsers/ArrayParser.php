<?php

namespace common\component\Parsers\Model\Parsers;

use common\component\Parsers\SourceSettings;
use common\component\Utils\Json;
use common\models\project\Source;
use Exception;
use Yii;

class ArrayParser {
    protected const WEBSITE_PATH         = 'website_path';
    protected const NAME_PATH            = 'name_path';
    protected const DESCRIPTION_PATH     = 'description_path';
    protected const URL_PATH             = 'url_path';
    protected const URL_PLACEHOLDER_PATH = 'url_placeholder_path';
    protected const URL_PATTERN          = 'url_pattern';
    protected const LOGO_PATH            = 'logo_path';

    private const URL_PLACEHOLDER = '{URL}';

    protected static $allowedSourceIds = [
        SourceSettings::TYPE_ICOBAZAAR_SETTINGS
    ];

    private static $fieldsMapping = [
        self::WEBSITE_PATH => 'projectWebsiteUrlPath',
        self::NAME_PATH => 'projectNamePath',
        self::DESCRIPTION_PATH => 'projectDescriptionPath',
        self::URL_PATH => 'externalUrlPath',
        self::URL_PLACEHOLDER_PATH => 'externalUrlPlaceholderPath',
        self::URL_PATTERN => 'externalUrlPattern',
        self::LOGO_PATH => 'logoUrlPath'
    ];

    /** @var string[] */
    private $projectDataFieldsPaths;

    /** @var string */
    private $externalId;

    /** @var string */
    private $projectWebsiteUrlPath;
    
    /** @var string */
    private $projectNamePath;

    /** @var string */
    private $projectDescriptionPath;

    /** @var string|null */
    private $externalUrlPath;

    /** @var string|null */
    private $externalUrlPlaceholderPath;
    
    /** @var string|null */
    private $externalUrlPattern;
    
    /** @var string|null */
    private $logoUrlPath;


    public static function getInstance(Source $source, string $externalId): ?self {
        if (\in_array($source->getSourceId(), self::$allowedSourceIds, true)) {
            $settings = Yii::$app->params['crawling']['json_settings'][$source->getName()];
            return new self($settings, $externalId);
        }

        return null;
    }

    public function parseProjectName(array $data): ?string {
        return Json::extractStringByPath($data, $this->projectNamePath);
    }

    public function parseProjectDescription(array $data): ?string {
        return Json::extractStringByPath($data, $this->projectDescriptionPath);
    }

    public function parseProjectData(array $data): array {
        $result = [];
        foreach ($this->projectDataFieldsPaths as $key => $path) {
            $result[$key] = Json::extractDataByPath($data, $path);
        }

        return $result;
    }

    public function parseLogoUrl(array $data): ?string {
        return Json::extractStringByPath($data, $this->logoUrlPath);
    }

    public function parseWebsiteUrl(array $data): ?string {
        return Json::extractStringByPath($data, $this->projectWebsiteUrlPath);
    }
    /**
     * @return string
     */
    public function getExternalId(): string {
        return $this->externalId;
    }

    /**
     * @param array $data
     *
     * @return null|string
     * @throws Exception
     */
    public function parseExternalUrl(array $data): ?string {
        if ($this->externalUrlPath === null) {
            if ($this->externalUrlPlaceholderPath === null || $this->externalUrlPattern === null) {
                throw new Exception('Not provided url placeholder and/or url pattern in case extracted url is combined'); // todo сделать свой эксепшен
            }

            $url = Json::extractStringByPath($data, $this->externalUrlPlaceholderPath);

            return str_replace(self::URL_PLACEHOLDER, $url, $this->externalUrlPattern);
        }

        return $this->externalUrlPath;
    }

    protected function __construct(array $settings, string $externalId) {
        $this->externalId = $externalId;
        $this->initFields($settings);
    }

    private function initFields(array $settings): void {
        $this->projectDataFieldsPaths = $settings['fields_paths'];
        foreach (self::$fieldsMapping as $key => $field) {
            if (property_exists($this, $field)) {
                $this->$field = $settings[$key] ?? null;
            }
        }
    }
}