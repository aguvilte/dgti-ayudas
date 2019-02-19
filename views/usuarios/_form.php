<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Rol;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
$id=$_GET["id"];
$documento=$_GET["documento"];

?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['placeholder' => 'Anombre','maxlength' => true, 'required' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['placeholder' => '1234', 'disabled' => true]) ?>

    <?= $form->field($model, 'password')->textInput(['value' => '1234', 'type'=>"hidden"])->label(false) ?>

    <div class="form-group">
      <label class="control-label">Rol</label>
        <?php
        foreach($roles as $role) {
          echo '<p class="auto-style3"><input name="id_rol" type="radio" value="'. $role->id_rol.'"/>'.$role->nombre.'</p> ';
          }
          ?>
    </div>

    <div  class="form-group" id="div1" style="display:none;"> 
        <label class="control-label">Secciones</label>
        <?php
        foreach($secciones as $seccion) {
          if($seccion->id_rol==2){
          echo '<p class="auto-style3"><input name="id_seccion[]" type="checkbox" value="'. $seccion->id_seccion.'"/>'.$seccion->nombre.'</p> ';
          }
        }
        ?>
    </div>

    <div  class="form-group" id="div2" style="display:none;">
      <label class="control-label">Secciones</label>
        <?php
        foreach($secciones as $seccion) {
          if($seccion->id_rol==3){
          echo '<p class="auto-style3"><input name="id_seccion[]" type="checkbox" value="'. $seccion->id_seccion.'"/>'.$seccion->nombre.'</p> ';
          }
        }
        ?>
    </div>

    <?= $form->field($model, 'id_persona')->textInput(['placeholder' => $documento, 'disabled' => true])->label('Nro Documento Persona') ?>

    <?= $form->field($model, 'id_persona')->textInput(['value' => $id, 'type'=>"hidden"])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
<script>
$(document).ready(function() {
    $("input[type=radio]").click(function(event){
        var valor = $(event.target).val();
        if(valor =="2"){
            $("#div1").show();
            $("#div2").hide();
        } else if (valor == "3") {
            $("#div1").hide();
            $("#div2").show();
        } else {
          $("#div1").hide();
          $("#div2").hide();
        }
    });
});
</script>
