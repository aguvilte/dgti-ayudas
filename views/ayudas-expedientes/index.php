<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AyudasExpedientesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ayudas Expedientes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ayudas-expedientes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ayudas Expedientes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_ayuda',
            'id_expediente',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
