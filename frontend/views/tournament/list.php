<?php
/**
 * @var $tournaments \frontend\models\Tournaments[]
 */
?>
<div class="tournaments-list-element">
    <?php foreach ($tournaments as $tournament) { ?>
        <div class="tournament-element">
          <a href="<?= $tournament->getUrl(); ?>" ><img src="<?= $tournament->getImageUrl(); ?>" style="max-width: 200px;"></a>
          <h2><?= $tournament->name ?></h2>
          <p>
              <?= $tournament->description ?>
          </p>
        </div>
    <?php } ?>
</div>
