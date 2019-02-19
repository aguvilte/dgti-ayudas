<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UsuariosSecciones;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
$id=$_GET["id"];
$id_rol=$model->id_rol;

$UsuariosSecciones = UsuariosSecciones::find()
                                        ->where(['id_usuario'=>$model->id])
                                        ->all();
$i=0;
$array2 = array();
foreach($UsuariosSecciones as $UsuariosSeccion) {    
  $i=$i+1;
  $array2[$i] = $UsuariosSeccion->id_seccion;
}

/*GESTION PUBLICA*/
$array1 = array();
foreach($secciones as $seccion) {
  if($seccion->id_rol==2){  
    $i=$i+1;
    $array1[$i] = $seccion->id_seccion; 
    }
} 
$resultado1 = array_diff($array1, $array2);

/*CONTADURIA*/
$array3 = array();
foreach($secciones as $seccion) {
  if($seccion->id_rol==3){  
    $i=$i+1;
    $array3[$i] = $seccion->id_seccion; 
    }
} 
$resultado2 = array_diff($array3, $array2);

?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['required' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['required' => true,'type'=>"text"]) ?> 

    <div class="form-group">
      <label class="control-label">Rol</label>
        <?php
        foreach($roles as $role) {
          if($id_rol==$role->id_rol){
           echo '<p class="auto-style3"><input checked name="id_rol" type="radio" value="'. $role->id_rol.'"/>'.$role->nombre.'</p> ';
          }else{    
           echo '<p class="auto-style3"><input name="id_rol" type="radio" value="'. $role->id_rol.'"/>'.$role->nombre.'</p> ';
          }
         }
        ?>
    </div>

    <div  class="form-group" id="div1" style="display:none;"> 
        <label class="control-label">Secciones</label>
        <?php 
        foreach($UsuariosSecciones as $UsuariosSeccion) {   
            foreach($secciones as $seccion) {
                if($seccion->id_rol==2){  
                    if($seccion->id_seccion==$UsuariosSeccion->id_seccion){
                         echo '<p class="auto-style3"><input checked name="id_seccion[]" type="checkbox" value="'. $seccion->id_seccion.'"/>'.$seccion->nombre.'</p> '; 
                    }
                }    
            }              
        }
        
        foreach($resultado1 as $resultados) {   
            foreach($secciones as $seccion) {
                if($seccion->id_seccion==$resultados){
                     echo '<p class="auto-style3"><input name="id_seccion[]" type="checkbox" value="'. $seccion->id_seccion.'"/>'.$seccion->nombre.'</p> '; 
                }
            }              
        } 
        
        ?>
    </div>

    <div  class="form-group" id="div2" style="display:none;">
      <label class="control-label">Secciones</label>
        <?php 
        foreach($UsuariosSecciones as $UsuariosSeccion) {   
            foreach($secciones as $seccion) {
                if($seccion->id_rol==3){  
                    if($seccion->id_seccion==$UsuariosSeccion->id_seccion){
                         echo '<p class="auto-style3"><input checked name="id_seccion[]" type="checkbox" value="'. $seccion->id_seccion.'"/>'.$seccion->nombre.'</p> '; 
                    }
                }    
            }              
        }
         
        foreach($resultado2 as $resultados) {   
            foreach($secciones as $seccion) {
                if($seccion->id_seccion==$resultados){
                     echo '<p class="auto-style3"><input name="id_seccion[]" type="checkbox" value="'. $seccion->id_seccion.'"/>'.$seccion->nombre.'</p> '; 
                }
            }              
        } 
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
