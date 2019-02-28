<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MovimientosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Movimientos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="movimientos-index">

    
    <div id="form-busqueda">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <p>
        <?= Html::a('Ver todos los movimientos', ['index'], ['class' => 'btn btn-danger']) ?>
    </p>
    
    <br>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_movimiento',
            [
                'attribute' => 'id_tipo_movimiento',
                'label' => 'Sección',
                'value' => 'tiposMovimientos.nombre'
            ],
            'descripcion',
            // 'id_dato_modificado',
            [
                'attribute' => 'id_dato_modificado',
                'label' => 'Modificación',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->id_tipo_movimiento == 1)
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Ver', './index.php?r=beneficiarios/view&id=' . $model->id_dato_modificado);
                    if($model->id_tipo_movimiento == 2)
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Ver', './index.php?r=ayudas/view&id=' . $model->id_dato_modificado);
                    if($model->id_tipo_movimiento == 3)
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Ver', './index.php?r=pago/view&id=' . $model->id_dato_modificado);
                     if($model->id_tipo_movimiento == 4)
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Ver', './index.php?r=tipos-ayudas/view&id=' . $model->id_dato_modificado);
                     if($model->id_tipo_movimiento == 5)
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Ver', './index.php?r=expedientes/view&id=' . $model->id_dato_modificado);
                     if($model->id_tipo_movimiento == 6)
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Ver', './index.php?r=areas/view&id=' . $model->id_dato_modificado);
                     if($model->id_tipo_movimiento == 7)
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> Ver', './index.php?r=referentes/view&id=' . $model->id_dato_modificado);

                    },
                'options' => ['class' => 'tbl-col-pdf-ben'],
            ],
            [
                'attribute' => 'id_usuario',
                'value' => 'usuario.username'
            ],
            [
                'attribute' => 'fecha',
                'format' => ['date', 'php:d/m/Y']
            ],
            [
                'attribute' => 'hora',
                // 'value' => function($model) {
                //     return $model->hora ;
                // }
            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    
    <br>
</div>

<script src='js/movimientos/index.js'></script>
