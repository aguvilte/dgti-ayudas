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

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Referentes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_referente',
            'apeynom',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
