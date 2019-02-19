<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Beneficiario;

/* @var $this yii\web\View */
/* @var $model app\models\Beneficiario */
$this->title = 'Listado por estado de ayudas economicas';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="beneficiario-create">
    <div class="jumbotron">
       <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>
       <hr>
    </div>

    <div class="alert alert-danger">
      <?php echo $mensajeError ; ?>
    </div>

</div>
