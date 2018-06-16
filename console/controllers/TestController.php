<?php

namespace console\controllers;

use frontend\models\Tournaments;
use DateTime;
use \yii\base\Controller;

class TestController extends Controller {

    public function actionTest() {
        $list = Tournaments::findByDates(1, new DateTime('2018-01-01'), new DateTime('2019-01-01'));


        foreach ($list as $item) {
            var_dump($item->getImageUrl());
        }
    }
}