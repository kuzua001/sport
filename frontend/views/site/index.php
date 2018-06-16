<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

/** @var \common\models\project\Tournament[] $projects */
$projects = \common\models\project\Tournament::find()->limit(10)->all();
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Projects!</h1>


    </div>

    <style>
      .project-card {

      }
    </style>

    <div>
      <?php foreach ($projects as $item) { ?>
          <div class="project-card">
            <h2 class="name"><?= $item->name ?></h2>
            <div class="descrioption">
              <?= $item->description ?>
            </div>
            <img src="<?= $item->logo_url ?>">
          </div>
      <?php } ?>
    </div>
</div>
