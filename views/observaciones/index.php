<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ObservacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Observaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="observaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Observaciones', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_observacion',
            'id_ayuda',
            'descripcion',
            'id_usuario',
            [
                'attribute' => 'fecha_observacion',
                'format' => ['date', 'php:d/m/Y']
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
