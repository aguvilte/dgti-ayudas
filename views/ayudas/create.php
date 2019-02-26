<?php

use yii\helpers\Html;
use app\models\Beneficiarios;
use app\models\Ayudas;


/* @var $this yii\web\View */
/* @var $model app\models\Ayudas */

$persona = Beneficiarios::find()
				->where(['id_beneficiario'=>$id])
				->one();
$this->title = $persona->apeynom.' DNI: '.$persona->documento;			
$this->params['breadcrumbs'][] = ['label' => 'Personas', 'url' => ['/beneficiarios/index']];
$this->params['breadcrumbs'][] = 'Crear Ayuda';

$idpersona=$persona->id_beneficiario;

$countayudas=Ayudas::find()
            ->where(['id_beneficiario'=>$idpersona])
            ->count();


if($countayudas>0) {
$ayuda = Ayudas::find()
    ->where(['id_beneficiario'=>$idpersona])
    ->orderBy(['id_ayuda'=>SORT_DESC])
    ->one();

    $fecha_entrada= 'Última Ayuda: '.$ayuda->fecha_entrada;
} else {
    $fecha_entrada= 'Última Ayuda: NO REGISTRA';
}

?>
<div class="ayudas-create">

	<h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <h3 class="titulo-area"><?= Html::encode($fecha_entrada) ?></h3>

	<?= Html::a('Ver Tipos de Ayudas', ['/tipos-ayudas/index'], ['class' => 'btn btn-success', 'target'=>"_blank"]) ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

<script>
form = document.getElementById('w0')
    inputFecha = document.getElementById('ayudas-fecha_nota')

    function formatFechaToUser() {    //cambia fecha yyyy-mm-dd a dd/mm/yyyy
    var date = inputFecha.value;
    var newdate = date.split('/').reverse().join('-');
    document.getElementById('ayudas-fecha_nota').value = newdate;
}

function formatFechaToDb() {    //cambia fecha dd/mm/yyyy a yyyy-mm-dd para guardarlo en la db
    var date = inputFecha.value;
    var countSlash = date.split('/').length;
    if(countSlash <= 2)
        date += '/1';
}

form.addEventListener('submit', function() {
    //formatFechaToDb();
    inputFecha = document.getElementById('ayudas-fecha_nota')
    var date = inputFecha.value;
    var newdate = date.split('/').reverse().join('-');
    document.getElementById('ayudas-fecha_nota').value = newdate;
});

formatFechaToUser()
</script>
