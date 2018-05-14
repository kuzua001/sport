<?php

namespace common\component\Parsers\Model\Parsers;

use common\models\project\Source;

abstract class BasicParser implements ProjectParserInterface
{
    protected const WEBSITE_PATH         = 'website_path';
    protected const NAME_PATH            = 'name_path';
    protected const DESCRIPTION_PATH     = 'description_path';
    protected const URL_PATH             = 'url_path';
    protected const URL_PLACEHOLDER_PATH = 'url_placeholder_path';
    protected const URL_PATTERN          = 'url_pattern';
    protected const LOGO_PATH            = 'logo_path';

    protected static $fieldsMapping = [
        self::WEBSITE_PATH => 'projectWebsiteUrlPath',
        self::NAME_PATH => 'projectNamePath',
        self::DESCRIPTION_PATH => 'projectDescriptionPath',
        self::URL_PATH => 'externalUrlPath',
        self::URL_PLACEHOLDER_PATH => 'externalUrlPlaceholderPath',
        self::URL_PATTERN => 'externalUrlPattern',
        self::LOGO_PATH => 'logoUrlPath'
    ];

    /** @var string[] */
    protected $projectDataFieldsPaths;

    /** @var string */
    protected $externalId;

    /** @var string */
    protected $projectWebsiteUrlPath;

    /** @var string */
    protected $projectNamePath;

    /** @var string */
    protected $projectDescriptionPath;

    /** @var string|null */
    protected $externalUrlPath;

    /** @var string|null */
    protected $externalUrlPlaceholderPath;

    /** @var string|null */
    protected $externalUrlPattern;

    /** @var string|null */
    protected $logoUrlPath;

    /**
     * @return string
     */
    public function getExternalId(): string {
        return $this->externalId;
    }

    protected static $allowedSourceIds = [];

    public static function getInstance(Source $source, string $externalId) {
        if (\in_array($source->getSourceId(), self::$allowedSourceIds, true)) {
            $settings = self::obtainParserSettings($source);
            return new static($settings, $externalId);
        }

        return null;
    }

    abstract protected static function obtainParserSettings(Source $source): array;

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