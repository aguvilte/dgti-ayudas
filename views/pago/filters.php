<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Areas;

?>

<div class="archivos-filters">
    <p>
        <a class="btn btn-success" href="?r=pago/index">
            Ver todas las ayudas
        </a>
    </p>

    <h1 style="text-align: center;"><?= Html::encode($this->title) ?></h1>
    <br>
    <br>
    
    <div class="body-content">
        <div class="row">
            <?php  echo $this->render('_search', ['model' => $searchModel, 'modelExp' => $searchModelExp]); ?>
        </div>
    </div>
</div>

<script src='js/pago/filters.js'></script>