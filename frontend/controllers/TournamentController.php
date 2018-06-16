<?php
namespace frontend\controllers;

use frontend\models\Tournaments;
use yii\web\Controller;

/**
 * Site controller
 */
class TournamentController extends Controller
{
    public function actionIndex()
    {
        $tournaments = Tournaments::find()->all();

        return $this->render('list.php', [
            'tournaments' => $tournaments,
        ]);
    }

    public function actionDetail($alias)
    {
       // $name =
    }
}
