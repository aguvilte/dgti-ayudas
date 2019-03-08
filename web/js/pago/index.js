$(document).ready(function () {
    
    btnPDF = document.getElementById('btn-pdf');
    inputTituloListado = document.getElementById('input-nombre-listado');

    var url_string = window.location.href;
    var url = new URL(url_string).search;
    urlSplitted = url.split('&');
    
    dniBeneficiario = urlSplitted[0].split('=')[1];
    idTipo = urlSplitted[1].split('=')[1];
    idEstado = urlSplitted[2].split('=')[1];
    idArea = urlSplitted[3].split('=')[1];
    idReferente = urlSplitted[4].split('=')[1];
    monto = urlSplitted[5].split('=')[1];
    idUsuario = urlSplitted[6].split('=')[1];
   
    $.ajax({
        url: "./index.php?r=ayudas/ajaxq",
        data: {
            idTipo: idTipo,
            idEstado: idEstado,
            idArea: idArea,
            idReferente: idReferente,
            idUsuario: idUsuario,
        },
        success: function(data) {
            respuestaData = data;
        }
    });

    btnPDF.addEventListener('click', function() {
        var searchParams = new URLSearchParams(window.location.search);
        searchParams.set('r', 'pago/listado');
        searchParams.set('dni', dniBeneficiario);
        searchParams.set('tipo', respuestaData[0]);
        searchParams.set('estado', respuestaData[1]);
        searchParams.set('area', respuestaData[2]);
        searchParams.set('referente', respuestaData[3]);
        searchParams.set('usuario', respuestaData[4]);
        searchParams.set('monto', monto);
        var newParams = searchParams.toString()
        
        var nuevaURL = location.protocol + '//' + location.host + location.pathname + '?' + newParams;
        window.open(nuevaURL, '_blank');
    });
});