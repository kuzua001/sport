<?php

namespace console\controllers;

use common\component\Calculator\ScamScoreCalculator;
use common\component\Parsers\Model\Loaders\FileProjectLoader;
use common\component\Parsers\SourceSettings;
use common\component\Utils\Json;
use common\models\project\Project;
use common\models\project\Source;
use \yii\base\Controller;

class ProjectLoaderController extends Controller {

    public  function actionLoad(): void {
        $source = Source::getInstance(Source::SOURCE_ICOBAZAAR);
        $loader = new FileProjectLoader('@app/../parsers/icobazaar', $source);
        foreach ($loader->getCrawledDataCollection() as $item) {

            if (!$item->hasValidData()) {
                continue; // add log entry
            }

            Project::findOrCreate($source, $item);
        }
        //echo Json::extractStringByPath([0 => ['hello' => ['name' => 'azaza']]], '[0].hello.name');
    }

    public function actionTest(): void {
        /** @var Project[] $projects */
        $projects = Project::find()->all();
        $rows = [];

        $escaper = function($val) {
            $val = str_replace('"', '\"', $val);
            $val = str_replace("\n", '|', $val);
            return '"' . $val . '"';
        };

        foreach ($projects as $i => $project) {
            $calc = new ScamScoreCalculator($project);
            $res = $calc->calcScore();
            $row = [
                $escaper($project->name),
                $escaper($project->website),
                $escaper($res['score']),
                $escaper($res['comment'])
            ];

            $rows[] = implode(';', $row);
        }

        echo implode("\n", $rows);
    }
}