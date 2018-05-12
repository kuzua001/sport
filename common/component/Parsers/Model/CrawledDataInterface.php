<?php

namespace common\component\Parsers\Model;

interface CrawledDataInterface {
    public const TYPE_JSON   = 'json';
    public const TYPE_HTML   = 'html';
    public const TYPE_DB_ROW = 'db_row';

    public function getType(): string;

    public function getName(): string;

    public function getExternalId(): string;

    public function getExternalUrl(): string;

    public function getDescription(): ?string;

    public function getWebsiteUrl(): ?string;

    public function getLogoUrl(): ?string;

    public function hasValidData(): bool;

    public function getProjectData(): array;
}