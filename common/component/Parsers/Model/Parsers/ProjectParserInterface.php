<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 5/13/18
 * Time: 3:10 PM
 */

namespace common\component\Parsers\Model\Parsers;


interface ProjectParserInterface
{
    public function parseProjectName(): ?string;
    public function parseProjectDescription(): ?string;
    public function parseProjectData(): array;
    public function parseLogoUrl(): ?string;
    public function parseWebsiteUrl(): ?string;
    public function parseExternalUrl(): ?string;
}