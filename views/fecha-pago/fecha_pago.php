<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Buscar por fechas';

?>

<div class="ayudas-index">

    <div class="body-content">
        <div class="row">
            <?php  echo $this->render('_searchfecha_pago', ['model' => $searchModel]); ?>
        </div>
    </div>

</div>

<script>
inputFecha = document.getElementById('ayudassearch-fecha_pago');
inputFecha2 = document.getElementById('rango-fecha-2');

var form = document.getElementById('w0');
form.addEventListener('submit', function() {
    var date = inputFecha.value;
    var date2 = inputFecha2.value;
    var newdate = date.split('/').reverse().join('-');
    var newdate2 = date2.split('/').reverse().join('-');
    document.getElementById('ayudassearch-fecha_pago').value = newdate;
    document.getElementById('rango-fecha-2').value = newdate2;
    if(document.getElementById('ayudassearch-fecha_pago').value != '') {
        if(document.getElementById('rango-fecha-2').value != '')
            document.getElementById('ayudassearch-fecha_pago').value += ' - ' + document.getElementById('rango-fecha-2').value;
        else
            document.getElementById('ayudassearch-fecha_pago').value += ' - ' + document.getElementById('ayudassearch-fecha_pago').value;
    }
});
/*
var inputFechas = [];

function getValores() {

    fechasToSplit = document.getElementById('ayudassearch-fecha_nota').value;
    if(fechasToSplit != '') {
        fechasToFormat = fechasToSplit.split(' - ');
        inputFechas[0] = fechasToFormat[0].split('-').reverse().join('/'); 
        inputFechas[1] = fechasToFormat[1].split('-').reverse().join('/'); 
    }

}

var form = document.getElementById('w0');
form.addEventListener('submit', function() {
    alert();
});

var botonVerTodo = document.getElementsByClassName('btn-success')[0];
botonVerTodo.addEventListener('click', function() {
    sessionStorage.removeItem('search-input-fechas');
});*/

</script>
