<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TiposAyudas */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Beneficiarios', 'url' => ['/beneficiarios/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-ayudas-view">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_tipo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_tipo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro de eliminar este registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id_tipo',
            'nombre',
        ],
    ]) ?>

</div>
