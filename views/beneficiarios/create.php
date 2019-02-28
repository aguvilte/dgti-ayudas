<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Beneficiarios */

$this->title = 'Crear Persona';
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="beneficiarios-create">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<script src="js/beneficiarios/create.js"></script>
