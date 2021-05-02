<?php

use yii\helpers\Html;
?>
<div class="row justify-content-center">
    <div class="site-error formulario col-md-6" style="margin-bottom: 30.1vw;">

        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>

        <p>
            The above error occurred while the Web server was processing your request.
        </p>
        <p>
            Please contact us if you think this is a server error. Thank you.
        </p>

    </div>
</div>
