<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ayudas */

$this->title = 'Actualizar Ayuda';
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="ayudas-update">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_formupdate', [
        'model' => $model,
    ]) ?>

</div>

<script>
form = document.getElementById('w0')
    inputFecha = document.getElementById('ayudas-fecha_nota')

    function formatFechaToUser() {    //cambia fecha yyyy-mm-dd a dd/mm/yyyy
    var date = inputFecha.value;
    var newdate = date.split('-').reverse().join('-');
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
    var newdate = date.split('-').reverse().join('-');
    document.getElementById('ayudas-fecha_nota').value = newdate;
});

formatFechaToUser()
</script>