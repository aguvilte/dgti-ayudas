<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Beneficiario;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BeneficioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listados';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beneficio-create">

    <div>
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>
    <p>
        <?= Html::a('Excel General de Ayudas Economicas', ['excel_general_ayudas'], ['class' => 'btn btn-success']) ?>
    </p>
    <p>
        <?= Html::a('Excel de Ayudas Iniciadas', ['excel_iniciados'], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a('Excel de Ayudas En Proceso', ['excel_en_proceso'], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a('Excel de Ayudas con Inconvenientes', ['excel_inconvenientes'], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a('Excel de Ayudas Canceladas', ['excel_canceladas'], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a('Excel de Ayudas Autorizadas', ['excel_autorizadas'], ['class' => 'btn btn-primary']) ?>
    </p>
    <p>
        <?= Html::a('Excel de Ayudas Pagadas', ['excel_pagadas'], ['class' => 'btn btn-primary']) ?>
    </p>

</div>
