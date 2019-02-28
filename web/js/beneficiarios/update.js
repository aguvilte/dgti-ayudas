var inputFecha = document.getElementById('beneficiarios-fecha_nacimiento');
    form = document.getElementById('w0');

function formatFechaToUser() {    //cambia fecha yyyy-mm-dd a dd/mm/yyyy
    var date = inputFecha.value;
    var newdate = date.split('-').reverse().join('/');
    document.getElementById('beneficiarios-fecha_nacimiento').value = newdate;
}

formatFechaToUser();

form.addEventListener('submit', function() {
    var date = inputFecha.value;
    var newdate = date.split('/').reverse().join('-');
    document.getElementById('beneficiarios-fecha_nacimiento').value = newdate;
});
