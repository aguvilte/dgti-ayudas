
selectSeccion = document.getElementById('movimientossearch-id_tipo_movimiento');
selectUsuario = document.getElementById('movimientossearch-id_usuario');
inputFecha = document.getElementById('movimientossearch-fecha');
inputFecha2 = document.getElementById('rango-fecha-2');

selectSeccion.value = '';
selectUsuario.value = '';
inputFecha.value = '';
inputFecha2.value = '';

var form = document.getElementById('btn-buscar');
form.addEventListener('click', function() {
    var date = inputFecha.value;
    var date2 = inputFecha2.value;
    var newdate = date.split('/').reverse().join('-');
    var newdate2 = date2.split('/').reverse().join('-');
    document.getElementById('movimientossearch-fecha').value = newdate;
    document.getElementById('rango-fecha-2').value = newdate2;
    if(document.getElementById('movimientossearch-fecha').value != '') {
        if(document.getElementById('rango-fecha-2').value != '')
            document.getElementById('movimientossearch-fecha').value += ' - ' + document.getElementById('rango-fecha-2').value;
        else
            document.getElementById('movimientossearch-fecha').value += ' - ' + document.getElementById('movimientossearch-fecha').value;
    }
});

