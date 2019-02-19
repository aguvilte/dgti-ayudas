<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Beneficiarios */

$this->title = 'Actualizar Persona: ' . $model->apeynom;
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->apeynom, 'url' => ['view', 'id' => $model->id_persona]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="beneficiarios-update">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

</div>
