<?php
use app\models\TiposAyudas;
use app\models\Beneficiarios;
use app\models\Ayudas;
use app\models\Estados;



$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array( 'Domingo', 'Lunes', 'Martes',
      'Miercoles', 'Jueves', 'Viernes', 'Sabado');

ini_set('date.timezone','America/Argentina/La_Rioja');
$hora = date("g:i A");
  if (!empty($ayuda->entrega_dni))
     {
      $entrega_dni=$ayuda->entrega_dni;
       if($entrega_dni == '1') {
            $entrega_dni = 'Sin entregar'; // or return false;
        } else if($entrega_dni == '2') {
            $entrega_dni = 'Entregado'; // or return false;
        }
     }

  if (!empty($ayuda->entrega_cuil))
       {
        $entrega_cuil=$ayuda->entrega_cuil;
         if($entrega_cuil == '1') {
              $entrega_cuil = 'Sin entregar'; // or return false;
          } else if($entrega_cuil == '2') {
              $entrega_cuil = 'Entregado'; // or return false;
          }
       }

  //DEFINIENDO TIPO DE AYUDA
  if (!empty($ayuda->id_tipo))
  {
     if ((TiposAyudas::findOne($ayuda->id_tipo)) !== null) {
        $tipo = TiposAyudas::findOne($ayuda->id_tipo)->nombre;
     }else{
        $tipo = '';
     }
  }

  if (!empty($ayuda->id_estado))
  {
     if ((Estados::findOne($ayuda->id_estado)) !== null) {
        $estado = Estados::findOne($ayuda->id_estado)->nombre;
     }else{
        $estado = '';
     }
  }

  if(!empty($ayuda->pdf_doc_adjunta))
                {
                $pdf_doc_adjunta='SI';
                }else {
                $pdf_doc_adjunta='NO';
                }
  if(!empty($ayuda->pdf_gestor))
                {
                $pdf_gestor='SI';
                }else {
                $pdf_gestor='NO';
                }
  if(!empty($ayuda->pdf_nota))
                {
                $pdf_nota='SI';
                }else {
                $pdf_nota='NO';
                }
  if(!empty($ayuda->pdf_domicilio))
                {
                $pdf_domicilio='SI';
                }else {
                $pdf_domicilio='NO';
                }
$html = '
<img src="/img/cabecera.png" alt="La Rioja - Argentina">
<h1 style="text-align: center;color:#0078CF;"><a name="top"></a>Ayuda Económica</h1>

<br />

<br/>
';
$mpdf=new mPDF();
$mpdf->allow_charset_conversion=true;
$mpdf->charset_in='UTF-8';
$mpdf->SetHeader($arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').", ".$hora);
$mpdf->SetFooter('Desarrollo: Dirección General de Tecnologia Informatica.');
$mpdf->WriteHTML("<body>");
$mpdf->WriteHTML($html);

    $mpdf->WriteHTML('
      <table class="tbl_pdf">
        <tbody>
        <TR>
           <td COLSPAN="2"><h2 style="text-align: center;color:#0078CF;">Datos Personales</h2></td>
        </TR>
        <tr>
          <td>Apellido y Nombre</td>
          <td>'.$persona->apeynom.'</td>
        </tr>
        <tr>
          <td>Documento</td>
          <td>'.$persona->documento.'</td>
        </tr>
          <TR>
           <td COLSPAN="2"><h2 style="text-align: center;color:#0078CF;">Ayuda Económica</h2></td>
        </TR>
         <tr>
            <td>Fecha Entrada</td>
            <td>'.$ayuda->fecha_entrada.'</td>
          </tr>
          <tr>
            <td>Tipo de Ayuda</td>
            <td>'.$tipo.'</td>
          </tr>
          <tr>
            <td>Estado del Trámite</td>
            <td>'.$estado.'</td>
          </tr>
          <tr>
            <td>Fecha de Pago</td>
            <td>'.$ayuda->fecha_pago.'</td>
          </tr>
          <TR>
           <td COLSPAN="2"><h2 style="text-align: center;color:#0078CF;">Nota de Solicitud</h2></td>
          </TR>
          <tr>
            <td>Asunto</td>
            <td>'.$ayuda->asunto.'</td>
          </tr>
          <tr>
            <td>monto</td>
            <td>'.$ayuda->monto.'</td>
          </tr>
          <tr>
            <td>Fecha Nota</td>
            <td>'.$ayuda->fecha_nota.'</td>
          </tr>
          <tr>
            <td>Documentación Adjunta</td>
            <td>'.$ayuda->doc_adjunta.'</td>
          </tr>
          <TR>
           <td COLSPAN="2"><h2 style="text-align: center;color:#0078CF;">Gestor</h2></td>
          </TR>
          <tr>
            <td>Área</td>
            <td>'.$ayuda->area.'</td>
          </tr>
          <tr>
            <td>Encargado del Área</td>
            <td>'.$ayuda->encargado.'</td>
          </tr>
          <br>
          <TR>
           <td COLSPAN="2"><h2 style="text-align: center;color:#0078CF;">Entrega de PDFs</h2></td>
          </TR>
          <tr>
            <td>DNI</td>
            <td>'.$entrega_dni.'</td>
          </tr>
          <tr>
            <td>CUIL</td>
            <td>'.$entrega_cuil.'</td>
          </tr>
          <tr>
            <td>Documentacion adjunta</td>
            <td>'.$pdf_doc_adjunta.'</td>
          </tr>
          <tr>
            <td>Gestor</td>
            <td>'.$pdf_gestor.'</td>
          </tr>
          <tr>
            <td>Nota de Solicitud</td>
            <td>'.$pdf_nota.'</td>
          </tr>
          <tr>
            <td>Domicilio</td>
            <td>'.$pdf_domicilio.'</td>
          </tr>
        </tbody>
      </table>
      <br /><br />

   ');
$mpdf->WriteHTML("</body>");
$mpdf->Output($filename,'I');
exit;
?>
