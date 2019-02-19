<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TiposAyudasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos de Ayudas Economicas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-ayudas-index">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a('Crear Nuevo tipo de Ayuda', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id_tipo',
            'nombre',

            [
             'class' => 'yii\grid\ActionColumn',
             'template' => '{update} {delete}',
             'buttons' => [
                           'view' => function ($url, $model)
                                    {
                                       return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [ 'title' => Yii::t('app', 'Ver'),'class' => 'btn btn-success btn-xs', ]);
                                     },
                          'update' => function ($url, $model)
                                    {
                                       return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [ 'title' => Yii::t('app', 'Editar'),'class' => 'btn btn-primary btn-xs', ]);
                                    },
                          ],
            'options' => ['class' => 'tbl-col-btn'],
            ],
        ],
        'options' => ['class' => 'tbl-completa'],
    ]); ?>
</div>
