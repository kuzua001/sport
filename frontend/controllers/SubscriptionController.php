<?php


namespace frontend\controllers;


use common\models\subscription\Subscription;
use yii\web\Controller;

class SubscriptionController extends Controller {
    public function actionSubscribe() {
        if (isset($_POST['email'])) {
            Subscription::create($_POST['email'], $_POST['status'] ?? Subscription::TYPE_EXPERT);

            return $this->render('success');
        }
        return $this->render('subscribe');
    }

    public function actionIndex() {
        return $this->render('index');
    }
}