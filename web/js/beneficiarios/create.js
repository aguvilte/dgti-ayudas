var inputFecha = document.getElementById('beneficiarios-fecha_nacimiento');
    form = document.getElementById('w0');

form.addEventListener('submit', function() {
    var date = inputFecha.value;
    var newdate = date.split('/').reverse().join('-');
    document.getElementById('beneficiarios-fecha_nacimiento').value = newdate;
});
