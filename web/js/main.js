$(function(){
  //obtengo el clickpara abrir el modal y crear nueva jurisdicciones
  $('#modalButton').click(function (){
    $('#modal').modal('show')
      .find('#modalContent')
      .load($(this).attr('value'));
  });
});
 
