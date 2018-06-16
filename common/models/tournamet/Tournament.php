<?php


namespace common\models\project;

use common\component\Parsers\Model\CrawledDataInterface;
use common\component\Utils\UtilsHelper;
use yii\db\ActiveRecord;

/**
 * Class Project
 * @property $name                string
 * @property $source_id           integer
 * @property $logo_url            string
 * @property $site_id             integer
 * @property $project_id          integer
 * @property $description         string
 * @property $source_external_id  string
 * @property $source_external_url string
 * @property $project_data        string
 * @property $website             string
 * @package common\models\project
 */
class Tournament extends ActiveRecord {

    public static function tableName():string {
        return 'data.projects';
    }

    public static function findOrCreate(Source $source, CrawledDataInterface $data): string {
        $siteId = ProjectWebsite::findOrCreate($data->getWebsiteUrl());

        $record = self::find()
            ->where('site_id = :site_id AND source_id = :source_id', [
                'site_id' => $siteId,
                'source_id' => $source->getSourceId()
            ])->one();

        if ($record === null) {
            $record = new self();
        }

        $record->site_id = $siteId;
        $record->source_id = $source->getSourceId();
        $record->source_external_id = $data->getExternalId();
        $record->source_external_url = $data->getExternalUrl();

        $record->name = $data->getName();
        $record->description = $data->getDescription();
        $record->logo_url = $data->getLogoUrl();
        $record->project_data = $data->getProjectData();
        $record->website = $data->getWebsiteUrl();

        $record->save(false);

        return $record->project_id;
    }
}