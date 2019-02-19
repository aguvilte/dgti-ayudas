<?php
use app\models\Beneficiario;
use app\models\Jurisdicciones;

$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array( 'Domingo', 'Lunes', 'Martes',
      'Miercoles', 'Jueves', 'Viernes', 'Sabado');

ini_set('date.timezone','America/Argentina/La_Rioja');
$hora = date("g:i A");

$fecha= date("Y") . "-" . date("m") . "-" . date("d");


$html = '
<img src="img/cabecera.png" alt="La Rioja - Argentina">
<h1 style="text-align: center;color:#0078CF;"><a name="top"></a>Listado</h1>

<br />

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" style="border: 0.1mm solid #888888; ">
  <tbody>
    <TR>
       <TH COLSPAN="2"><h2>Datos Generales</h2></TH>
    </TR>
    <tr>
      <td>Total de Registros</td>
      <td>'.$opcion.'</td>
    </tr>
    <tr>
      <td>Cantidad de Registros afectados</td>
      <td>'.$countBeneficios.'</td>
    </tr>
  </tbody>
</table>

<br><br>

<h2 style="text-align: center">Listado de Beneficios / Beneficiarios</h2>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" style="border: 0.1mm solid #888888; ">
  <tr>
    <th>#</th>
    <th>Nombre y Apellido</th>
    <th>Nº Documento</th>
    <th>Nro Decreto</th>
    <th>Jurisdiccion</th>
    <th>Saf</th>
    <th>Fecha Inicio</th>
    <th>Fecha Fin</th>
    <th>Tipo de Beneficio</th>
    <th>Monto</th>
  </tr>
';


$mpdf=new mPDF();
$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='UTF-8';
$mpdf->SetHeader($arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').", ".$hora);
$mpdf->SetFooter('Desarrollo: Dirección General de Tecnologia Informatica.');
$mpdf->WriteHTML("<body>");
$mpdf->WriteHTML($html);
foreach($beneficio as $beneficios){
  $i=$i+1;
  //BUSCO DATOS DEL Beneficio
  $idbeneficiario=$beneficios->id_beneficiario;

  $beneficiario = Beneficiario::find()
              ->where(['id_beneficiario'=>$idbeneficiario])
              ->all();

  //DEFINIENDO TIPOS POSIBLES
  $tipo = $beneficios->tipo;

  if($tipo == 'C') //0 Desactivada
  {
     $tipo = 'Contrato'; // or return true;
  } else if($tipo == 'B') {
     $tipo = 'Beca'; // or return false;
  } else if($tipo == 'P') {
     $tipo = 'Programas Sociales'; // or return false;
  } else if($tipo == 'Z') {
     $tipo = 'Adicional'; // or return false;
  } else if($tipo == 'G') {
     $tipo = 'Guardias'; // or return false;
  } else if($tipo == 'R') {
     $tipo = 'Adicional Retroactivo'; // or return false;
  } else if($tipo == 'E') {
     $tipo = 'Exceptuado'; // or return false;
  } else if($tipo == 'D') {
     $tipo = 'Producción'; // or return false;
  }

  $jurisdiccion = Jurisdicciones::findOne($beneficios->id_jurisdiccion);
  if ($jurisdiccion !== null) {
    $jurisdiccion=$jurisdiccion->nombre;
  }

  foreach($beneficiario as $beneficiarios){
    $mpdf->WriteHTML('
     <tr>
       <td>'.$i.'</td>
       <td>'.$beneficiarios->apeynom.'</td>
       <td>'.$beneficiarios->documento.'</td>
       <td>'.$beneficios->nro_decreto.'</td>
       <td>'.$jurisdiccion.'</td>
       <td>'.$beneficios->saf.'</td>
       <td>'.$beneficios->fecha_inicio.'</td>
       <td>'.$beneficios->fecha_fin.'</td>
       <td>'.$tipo.'</td>
       <td>'.$beneficios->monto.'</td>
     </tr>
    ');
  }
}

$mpdf->WriteHTML("</table></body>");
$mpdf->Output($filename,'I');
exit;


?>
