<?php

use yii\helpers\Html;


$this->title = 'Agregar ayuda a expediente';
$this->params['breadcrumbs'][] = ['label' => 'Expedientes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expedientes-ayudas">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form_ayudas', [
        'model' => $model,
        'ayuda' => $ayuda,
    ]) ?>

</div>

<script src='js/expedientes/ayudas.js'></script>