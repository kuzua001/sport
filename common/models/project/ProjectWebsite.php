<?php


namespace common\models\project;

use yii\db\ActiveRecord;

/**
 * Class Project
 * @property $site_id            integer
 * @property $url                string
 * @property $selected_source_id integer
 */
class ProjectWebsite extends ActiveRecord {

    public static function tableName(): string {
        return 'data.projects_websites';
    }

    public static function findOrCreate(string $url): int {
        $record = self::find()
            ->where('url = :url', [
              'url' => $url
            ])->one();

        if ($record === null) {
            $record = new self();
            $record->url = $url;
            $record->save(false);
            $record->refresh();
        }

        return $record->site_id;
    }
}