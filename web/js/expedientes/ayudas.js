var inputFecha = document.getElementById('ayudas-fecha_entrada');
    form = document.getElementById('w0');

var date = inputFecha.value;
var newdate = date.split('-').reverse().join('/');
document.getElementById('ayudas-fecha_entrada').value = newdate;