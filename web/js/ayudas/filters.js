var inputFechaEntrada = document.getElementById('ayudassearch-fecha_entrada');
    inputFechaEntrada2 = document.getElementById('rango-fecha-2');
    inputFechaPago = document.getElementById('ayudassearch-fecha_pago');
    inputFechaPago2 = document.getElementById('rango-fecha-4');

var form = document.getElementById('w0');
form.addEventListener('submit', function() {
    var dateEntrada = inputFechaEntrada.value;
    var dateEntrada2 = inputFechaEntrada2.value;
    var datePago = inputFechaPago.value;
    var datePago2 = inputFechaPago2.value;

    var newdateEntrada = dateEntrada.split('/').reverse().join('-');
    var newdateEntrada2 = dateEntrada2.split('/').reverse().join('-');
    var newdatePago = datePago.split('/').reverse().join('-');
    var newdatePago2 = datePago2.split('/').reverse().join('-');

    document.getElementById('ayudassearch-fecha_entrada').value = newdateEntrada;
    document.getElementById('rango-fecha-2').value = newdateEntrada2;
    document.getElementById('ayudassearch-fecha_pago').value = newdatePago;
    document.getElementById('rango-fecha-4').value = newdatePago2;

    if(document.getElementById('ayudassearch-fecha_entrada').value != '') {
        if(document.getElementById('rango-fecha-2').value != '')
            document.getElementById('ayudassearch-fecha_entrada').value += ' - ' + document.getElementById('rango-fecha-2').value;
        else
            document.getElementById('ayudassearch-fecha_entrada').value += ' - ' + document.getElementById('ayudassearch-fecha_entrada').value;
    }

    if(document.getElementById('ayudassearch-fecha_pago').value != '') {
        if(document.getElementById('rango-fecha-4').value != '')
            document.getElementById('ayudassearch-fecha_pago').value += ' - ' + document.getElementById('rango-fecha-4').value;
        else
            document.getElementById('ayudassearch-fecha_pago').value += ' - ' + document.getElementById('ayudassearch-fecha_pago').value;
    }
});