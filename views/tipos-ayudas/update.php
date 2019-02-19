<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TiposAyudas */

$this->title = 'Actualizar tipo de Ayuda: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Beneficiarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id_tipo]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="tipos-ayudas-update">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
