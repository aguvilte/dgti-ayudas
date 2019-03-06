<?php
use app\models\TiposAyudas;
use app\models\Beneficiarios;
use app\models\Ayudas;
use app\models\Estados;
use app\models\Areas;
use app\models\Referentes;


$arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

$arrayDias = array( 'Domingo', 'Lunes', 'Martes',
      'Miercoles', 'Jueves', 'Viernes', 'Sabado');

ini_set('date.timezone','America/Argentina/La_Rioja');
$hora = date("g:i A");

  
  if (!empty($beneficiario->pdf_dni))
     {
            $pdf_dni = 'SI'; // or return false;
        } else {
            $pdf_dni = 'NO'; // or return false;
        }

    if (!empty($beneficiario->pdf_cuil))
     {
            $pdf_cuil = 'SI'; // or return false;
        } else {
            $pdf_cuil = 'NO'; // or return false;
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
  if (!empty($ayuda->id_area))
  {
     if ((Areas::findOne($ayuda->id_area)) !== null) {
        $area = Areas::findOne($ayuda->id_area)->nombre;
     }else{
        $area = '';
     }
  }
  if (!empty($ayuda->id_referente))
  {
     if ((Referentes::findOne($ayuda->id_referente)) !== null) {
        $referente = Referentes::findOne($ayuda->id_referente)->apeynom;
     }else{
        $referente = '';
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
<h3 style="text-align: center;"><a name="top"></a>GOBERNADOR</h3>
<h2 style="text-align: center;"><a name="top"></a>Cr. SERGIO GUILLERMO CASAS</h2>
<h4 style="text-align: letf;"><a name="top"></a>PERSONA FÍSICA - ORGANISMO NO GUBERNAMENTALES Y/O PARA ESTATALES - OTROS ORGANISMOS PROVINCIALES Y/O MUNICIPALES.</h4>
<p style="text-align: letf;" class="titulo-area">Recibí de la Dirección General de Administración.</p>
<p style="text-align: letf;" class="titulo-area">CHEQUE Nº <b>'.$ayuda->nro_cheque.' </b>, Librado contra Nuevo Banco de la Rioja S.A. por la suma de pesos: ($<b>'.$ayuda->monto.'</b>),
 Pesos en Letras: (..........................................................................................), en concepto de Asistencia Económica y/o Transferencia de Fondo, a favor de <b>'.$beneficiario->apeynom.'.</b></p>
<p style="text-align: letf;" class="titulo-area">De conformidad a los términos de Resolución S.G.yL.G. Nº.....................................</p>
<h5 style="text-align: letf;"><a name="top"></a>Con cargo de oportuna rendición de cuentas, Art. 223 a 228; 229 a 241 y 242 a 260 de la Resolución del Tribulan de Cuentas Nº 11/11.</h5>
<br>
<p style="text-align: letf;" class="titulo-area">Fecha de Pago: '.$ayuda->fecha_pago.'</p>
<p style="text-align: letf;" class="titulo-area">Domicilio: '.$beneficiario->domicilio.'</p>
<br>
<br>
<br>
<br>


<pre style="text-align: letf;" class="titulo-area">
................           ................           ................
     Firma               Aclaración de Firma              D.N.I Nº
</pre>


   ');
$mpdf->WriteHTML("</body>");
$mpdf->Output($filename,'I');
exit;
?>
