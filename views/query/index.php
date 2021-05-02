<?php

use yii\widgets\ListView;

?>
<div class="row mt-5">
</div>
<div class="query-index">
      <?= ListView::widget([
          'summary' => false,
          'itemOptions' => ['tag' => null],
          'dataProvider' => $dataProvider,
          'itemView' => '_post',
      ]); ?>
</div>
