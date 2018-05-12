<?php


namespace common\component\Parsers\Model;

use common\component\Parsers\Model\Parsers\ArrayParser;
use common\models\project\Source;

class CrawledJson implements CrawledDataInterface {
    /** @var string */
    private $json;

    /** @var array */
    private $data;

    /** @var ArrayParser */
    private $parser;

    /** @var string|null */
    private $name;

    /** @var string */
    private $externalUrl;

    /** @var string */
    private $externalId;

    /** @var string|null */
    private $websiteUrl;

    /** @var string|null */
    private $logoUrl;

    /** @var array */
    private $projectData;

    /** @var string|null */
    private $description;

    private $isInited = false;

    /** @var boolean */
    private $isValid = true;

    public function __construct($json, ArrayParser $parser) {
        $this->json = $json;
        $this->parser = $parser;
    }

    private function init(): void {
        $this->data = json_decode($this->json, true);
        if ($this->data === null) {
            $this->isValid = false;
            return;
        }

        $this->websiteUrl = $this->parser->parseWebsiteUrl($this->data);
        $this->externalUrl = $this->parser->parseExternalUrl($this->data);
        $this->externalId = $this->parser->getExternalId();
        $this->name = $this->parser->parseProjectName($this->data);

        if ($this->externalUrl === null ||
            $this->name === null ||
            $this->websiteUrl === null ) {
            $this->isValid = false;
            return;
        }

        $this->description = $this->parser->parseProjectDescription($this->data);
        $this->logoUrl = $this->parser->parseLogoUrl($this->data);
        $this->projectData = $this->parser->parseProjectData($this->data);
    }

    private function lazyInit(): void {
        if (!$this->isInited) {
            $this->init();
        }

        $this->isInited = true;
    }

    public function getType(): string {
        return CrawledDataInterface::TYPE_JSON;
    }

    public function getExternalId(): string {
        $this->lazyInit();
        return $this->externalId;
    }

    public function getExternalUrl(): string {
        $this->lazyInit();
        return $this->externalUrl;
    }

    public function getName(): string {
        $this->lazyInit();
        return $this->name;
    }

    public function getDescription(): ?string {
        $this->lazyInit();
        return $this->description;
    }

    public function getWebsiteUrl(): ?string {
        $this->lazyInit();
        return $this->websiteUrl;
    }

    public function getLogoUrl(): ?string {
        $this->lazyInit();
        return $this->logoUrl;
    }

    public function hasValidData(): bool {
        $this->lazyInit();
        return $this->isValid;
    }

    public function getProjectData(): array {
        $this->lazyInit();
        return $this->projectData;
    }


}