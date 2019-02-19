//OBSERVACIONES TABLA CRUCE
function mostrarOcultar(){

   var ckb = document.getElementById("ver");
   if (ckb.checked) {
   document.getElementById('table').className ='table table-striped table-bordered ocultar_observacion';
   }else{
   document.getElementById('table').className ='table table-striped table-bordered observacion';
   }
}

//ULTIMO REGISTRO DE PAGO TABLA CRUCE
function mostrarOcultarPago(){

   var ckb = document.getElementById("verpago");
   if (ckb.checked) {
   document.getElementById('table').className ='table table-striped table-bordered ocultar_registropago';
   }else{
   document.getElementById('table').className ='table table-striped table-bordered registropago';
   }
}
