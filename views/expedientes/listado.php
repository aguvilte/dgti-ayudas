<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Areas;
use app\models\Ayudas;
use app\models\Beneficiarios;
use app\models\Estados;
use app\models\Referentes;
use app\models\TiposAyudas;

$this->title = 'Listado';

?>

<div class="pdf-ayudas">

    <!-- <img src="img/encabezado-listados.png"> -->

    <br>
    <br>
    <h1 style="text-align: center;"><?= 'Expediente ' . $numeroExp ?> </h1>
    <br>
    <br>

    <?php
        $montoTotal = 0;
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $modelAyudasExp,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'id_ayuda',
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Nombre y apellido',
                'value' => function($model) {
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if (!empty($ayuda->id_beneficiario)) {
                        $beneficiario = Beneficiarios::findOne($ayuda->id_beneficiario);
                        if ($beneficiario !== null) {
                            return $beneficiario->apeynom;
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'DNI',
                'value' => function($model) {
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if (!empty($ayuda->id_beneficiario))
                    {
                        $beneficiario = Beneficiarios::findOne($ayuda->id_beneficiario);
                        if ($beneficiario !== null) {
                            return number_format($beneficiario->documento, 0, ',', '.');
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Tipo de ayuda',
                'value' => function($model){
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if(!empty($ayuda->id_tipo)){
                        $tipo = TiposAyudas::findOne($ayuda->id_tipo);
                        if ($tipo !== null) {
                            return $tipo->nombre;
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Estado',
                'value' => function($model){
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if(!empty($ayuda->id_estado)){
                        $estado = Estados::findOne($ayuda->id_estado);
                        if ($estado !== null) {
                            return $estado->nombre;
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Area',
                'value' => function($model){
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if(!empty($ayuda->id_area)){
                        $area = Areas::findOne($ayuda->id_area);
                        if ($area !== null) {
                            return $area->nombre;
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Referente',
                'value' => function($model){
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    if(!empty($ayuda->id_referente)){
                        $referente = Referentes::findOne($ayuda->id_referente);
                        if ($referente !== null) {
                            return $referente->apeynom;
                        }
                    }
                },
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'header' => 'Monto',
                'value' => function($model){
                    $ayuda = Ayudas::findOne($model->id_ayuda);
                    return number_format($ayuda->monto, 2, ',', '.');
                    $montoTotal = $montoTotal + $ayuda->monto;
                },
            ],
        ],
    ]); ?>

    <p>
        <b>Monto total: $<?php echo number_format($montoExp, 0, ',', '.') ?> </b>
    </p>
</div>
