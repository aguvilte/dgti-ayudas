btnPDF = document.getElementById('btn-pdf');
inputTituloListado = document.getElementById('input-nombre-listado');
btnPDF.addEventListener('click', function() {
    var searchParams = new URLSearchParams(window.location.search);
    searchParams.set('r','pago/listado')
    var newParams = searchParams.toString()
    
    var nuevaURL = location.protocol + '//' + location.host + location.pathname + '?' + newParams;
    window.open(nuevaURL, '_blank');
});