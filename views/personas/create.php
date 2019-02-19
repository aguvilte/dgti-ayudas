<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Personas */

$this->title = 'Crear Persona';
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personas-create">

    <div class="jumbotron">
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
