<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ReferentesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Referentes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referentes-index">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear referente', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'apeynom',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Ver/Editar/Borrar',
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'title' => Yii::t('app', 'Ver'),'class' => 'btn btn-success btn-xs', ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'title' => Yii::t('app', 'Editar'),'class' => 'btn btn-primary btn-xs', ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id_referente], [
                            'class' => 'btn btn-danger btn-xs',
                            'data' => [
                            'confirm' => '¿Estás seguro de que quieres eliminar este referente?',
                            'method' => 'post',
                            ],
                        ]);
                    },
                ],
                'options' => ['class' => 'tbl-col-btn-ben'],
            ],
        ],
    ]); ?>
</div>
