var inputTipoAyuda = document.getElementById('ayudassearch-id_tipo');
    inputEstado = document.getElementById('ayudassearch-id_estado');
    inputArea = document.getElementById('ayudassearch-id_area');
    inputReferente = document.getElementById('ayudassearch-id_referente');
    inputFechaEntrada1 = document.getElementById('ayudassearch-fecha_entrada');
    inputFechaEntrada2 = document.getElementById('rango-fecha-2');
    inputFechaPago1 = document.getElementById('ayudassearch-fecha_pago');
    inputFechaPago2 = document.getElementById('rango-fecha-4');
    inputBeneficiario = document.getElementById('ayudassearch-id_beneficiario');
    inputExpediente = document.getElementById('expedientessearch-id_expediente');

inputFechaEntrada2.disabled = true;
inputFechaPago2.disabled = true;

inputTipoAyuda.addEventListener('change', function() {
    if(inputTipoAyuda.value > 0)
        deshabilitarExpediente();
    else
        habilitarExpediente();
});

inputEstado.addEventListener('change', function() {
    if(inputEstado.value > 0)
        deshabilitarExpediente();
    else
        habilitarExpediente();
});

inputArea.addEventListener('change', function() {
    if(inputArea.value > 0)
        deshabilitarExpediente();
    else
        habilitarExpediente();
});

inputReferente.addEventListener('change', function() {
    if(inputReferente.value > 0)
        deshabilitarExpediente();
    else
        habilitarExpediente();
});

inputFechaEntrada1.addEventListener('change', function() {
    if(inputFechaEntrada1.value.length > 0) {
        inputFechaEntrada2.disabled = false;
        
    }
    else {
        inputFechaEntrada2.value = '';
        inputFechaEntrada2.disabled = true;
        habilitarExpediente();
    }
})

inputFechaPago1.addEventListener('change', function() {
    if(inputFechaPago1.value.length > 0) {
        inputFechaPago2.disabled = false;
        deshabilitarExpediente();
    }
    else {
        inputFechaPago2.value = '';
        inputFechaPago2.disabled = true;
        habilitarExpediente();
    }
})

inputBeneficiario.addEventListener('change', function() {
    if(inputBeneficiario.value.length > 0)
        deshabilitarExpediente();
    else
        habilitarExpediente();
});

inputExpediente.addEventListener('change', function() {
    if(inputExpediente.value > 0)
        deshabilitarAyudas();
    else
        habilitarAyudas();
});

function deshabilitarExpediente() {
    inputExpediente.options[inputExpediente.selectedIndex].text = '';
    inputExpediente.disabled = true;
}

function habilitarExpediente() {
    if(
        inputTipoAyuda.value == '' &&
        inputEstado.value == '' &&
        inputArea.value == '' &&
        inputReferente.value == '' &&
        inputFechaEntrada1.value == '' &&
        inputFechaEntrada2.value == '' &&
        inputFechaPago1.value == '' &&
        inputFechaPago2.value == '' &&
        inputBeneficiario.value == ''
    ) {
        inputExpediente.disabled = false;
        // deshabilitarAyudas();
    }
}

function deshabilitarAyudas() {
    inputTipoAyuda.disabled = true;
    inputEstado.disabled = true;
    inputArea.disabled = true;
    inputReferente.disabled = true;
    inputFechaEntrada1.disabled = true;
    inputFechaEntrada2.disabled = true;
    inputFechaPago1.disabled = true;
    inputFechaPago2.disabled = true;
    inputBeneficiario.disabled = true;

    inputTipoAyuda.value = '';
    inputEstado.value = '';
    inputArea.value = '';
    inputReferente.value = '';
    inputFechaEntrada1.value = '';
    inputFechaEntrada2.value = '';
    inputFechaPago1.value = '';
    inputFechaPago2.value = '';
    inputBeneficiario.value = '';
}

function habilitarAyudas() {
    inputTipoAyuda.disabled = false;
    inputEstado.disabled = false;
    inputArea.disabled = false;
    inputReferente.disabled = false;
    inputFechaEntrada1.disabled = false;
    inputFechaPago1.disabled = false;
    inputBeneficiario.disabled = false;

    inputTipoAyuda.value = '';
    inputEstado.value = '';
    inputArea.value = '';
    inputReferente.value = '';
    inputFechaEntrada1.value = '';
    inputFechaEntrada2.value = '';
    inputFechaPago1.value = '';
    inputFechaPago2.value = '';
    inputBeneficiario.value = '';
}