<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TiposAyudas */

$this->title = 'Crear nuevo tipo de ayuda económica';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipos-ayudas-create">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
