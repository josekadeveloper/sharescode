<?php
use yii\helpers\Html;

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
<?php
$css = <<<'EOT'
    .header {
        background-color: #00b5db;
        border-radius: 10px;
        margin-bottom: 6px;
    }
    .body {
        border-radius: 10px;
        border: 1px solid black;
        padding: 10px;
    }
EOT;
$this->registerCss($css);
?>
</head>
<body>
    <div class="container">
        <div class="header">
            <?= $header ?>
        </div>
        <div class="body">
            <?= $body ?>
        </div>
    </div>
</body>
</html>
