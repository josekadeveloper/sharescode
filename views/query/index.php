<?php

use yii\widgets\ListView;

?>
<div class="row index">
    <div class="text-info">
        <h2>In sharecode you can find everything you are looking for about the world of web programming</h2>
    </div>
    <div class="col-md-6 col-sm-6 mt-5">
        <div class="input-group">
            <div class="form-outline">
                <label class="form-label" for="search"><strong>What are you looking for:</strong></label>
                <input type="search" id="search" class="form-control" placeholder="Search" aria-label="Search" />
            </div>
            <button type="button" class="btn btn-primary">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>
<div class="query-index">
    <?= ListView::widget([
        'summary' => false,
        'itemOptions' => ['tag' => null],
        'dataProvider' => $dataProvider,
        'itemView' => '_post',
    ]); ?>
</div>