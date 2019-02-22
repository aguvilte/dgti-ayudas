<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Beneficiarios;
use app\models\TiposAyudas;
use app\models\Estados;
use app\models\Areas;
use app\models\Referentes;

/* @var $this yii\web\View */
/* @var $model app\models\Ayudas */

$this->title = 'Ver Ayuda';
$this->params['breadcrumbs'][] = ['label' => 'Pago', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="ayudas-view">


    <p class="row cabecera-contenido text-right">
      <a class="btn btn-pdf" target="_blank" href="?r=pago%2Fpdf_ayuda&id=<?php echo $id; ?>" title="Exportar" aria-label="Exportar">
        <span class="glyphicon glyphicon-stats"></span> Exportar Informe
      </a>
     <?php if($model->id_estado==5) {?> 
      <a class="btn btn-pdf" target="_blank" href="?r=pago%2Fpdf_recibo&id=<?php echo $id; ?>" title="Exportar Recibo" aria-label="Exportar Recibo">
        <span class="glyphicon glyphicon-stats"></span> Exportar Recibo
      </a>
      <?php }?>
    </p>

<?php if($model->id_estado==2) {?>
    <p>
      <a class="btn btn-info" href="?r=pago%2Fautorizacion&id=<?php echo $id; ?>" title="Autorizar Pago" aria-label="Autorizar">
        <span class="glyphicon glyphicon-thumbs-up"></span> Autorizar
      </a>
      <a class="btn btn-danger" href="?r=devoluciones%2Fcreate&id=<?php echo $id; ?>" title="Regresar ayuda al área que realizó el envío" aria-label="Exportar">
        <span class="glyphicon glyphicon-thumbs-down"></span> Regresar
      </a>
    </p>
    <?php }?>

<?php if($model->id_estado==5) {?>
    <p>
      <a class="btn btn-info" href="?r=pago%2Fpago&id=<?php echo $id; ?>" title="Realizar pago" aria-label="Pago">
        <span class="glyphicon glyphicon-usd"></span> Pagar
      </a>
    </p>
    <?php }?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Apellido y Nombre',
                'attribute'=>'id_beneficiario',
                'value'=>function ($model) {
                   if (!empty($model->id_beneficiario))
                   {
                      $beneficiario = Beneficiarios::findOne($model->id_beneficiario);
                      if ($beneficiario !== null) {
                          return $beneficiario->apeynom;
                      }
                   }
                },
              ],
              [
                'label' => 'Documento',
                'attribute'=>'id_beneficiario',
                'value'=>function ($model) {
                   if (!empty($model->id_beneficiario))
                   {
                      $beneficiario = Beneficiarios::findOne($model->id_beneficiario);
                      if ($beneficiario !== null) {
                          return $beneficiario->documento;
                      }
                   }
                },
              ],
            //'id_ayuda',
            [
                'label' => 'Tipo de Ayuda',
                'attribute'=>'id_tipo',
                'value'=>function ($model) {
                   if (!empty($model->id_tipo))
                   {
                      $tipo = TiposAyudas::findOne($model->id_tipo);
                      if ($tipo !== null) {
                          return $tipo->nombre;
                      }
                   }
                },
              ],
            [
                'label' => 'Estado del trámite',
                'attribute'=>'id_estado',
                'value'=>function ($model) {
                   if (!empty($model->id_estado))
                   {
                      $Estado = Estados::findOne($model->id_estado);
                      if ($Estado !== null) {
                          return $Estado->nombre;
                      }
                   }
                },
              ],
            [
                'label' => 'Entrega DNI',
                'attribute'=>'id_beneficiario',
                'value'=>function ($model) {

                  $beneficiario = Beneficiarios::findOne($model->id_beneficiario);
                  if (!empty($beneficiario->pdf_dni))
                       {
                                return $pdf_dni = 'SI'; // or return false;
                            } else {
                               return $pdf_dni = 'NO'; // or return false;
                            }
                   },
              ],
            [
                'label' => 'Entrega CUIL',
                'attribute'=>'id_beneficiario',
                'value'=>function ($model) {

                  $beneficiario = Beneficiarios::findOne($model->id_beneficiario);
                  if (!empty($beneficiario->pdf_cuil))
                       {
                               return $pdf_cuil = 'SI'; // or return false;
                            } else {
                               return $pdf_cuil = 'NO'; // or return false;
                            }
                   },
              ],
            'asunto',
            'monto',
            [
                'attribute' => 'fecha_nota',
                'format' => ['date', 'php:d-m-Y']
            ],
            [
                'attribute' => 'fecha_entrada',
                'format' => ['date', 'php:d-m-Y']
            ],
            [
                'attribute' => 'fecha_pago',
                'format' => ['date', 'php:d-m-Y']
            ],
            'doc_adjunta',
            [
                'label' => 'Area',
                'attribute'=>'id_area',
                'value'=>function ($model) {
                   if (!empty($model->id_area))
                   {
                      $area = Areas::findOne($model->id_area);
                      if ($area !== null) {
                          return $area->nombre;
                      }
                   }
                },
              ],
                        [
                'label' => 'Referente',
                'attribute'=>'id_referente',
                'value'=>function ($model) {
                   if (!empty($model->id_referente))
                   {
                      $referente = Referentes::findOne($model->id_referente);
                      if ($referente !== null) {
                          return $referente->apeynom;
                      }
                   }
                },
              ],
        ],
    ]) ?>

    <table class="table table-striped table-bordered detail-view">
      <tbody>
        <tr><th>Pdf DOCUMENTACIÓN ADJUNTA</th>
            <td>
              <?php if(!empty($model->pdf_doc_adjunta))
                {
                echo '<iframe src="'.$model->pdf_doc_adjunta.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="'.$model->pdf_doc_adjunta.'" target="_blank">Ver Documento Completo</a>';
              }?>
            </td>
        </tr>
        <tr><th>Pdf GESTOR</th>
            <td>
              <?php if(!empty($model->pdf_gestor))
                {
                echo '<iframe src="'.$model->pdf_gestor.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="'.$model->pdf_gestor.'" target="_blank">Ver Documento Completo</a>';
                }?>
            </td>
        </tr>
        <tr><th>Pdf NOTA SOLICITUD</th>
            <td>
              <?php if(!empty($model->pdf_nota))
                {
                echo '<iframe src="'.$model->pdf_nota.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="'.$model->pdf_nota.'" target="_blank">Ver Documento Completo</a>';
                }?>
            </td>
        </tr>
        <tr><th>Pdf DOMICILIO</th>
            <td>
              <?php if(!empty($model->pdf_domicilio))
                {
                echo '<iframe src="'.$model->pdf_domicilio.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="'.$model->pdf_domicilio.'" target="_blank">Ver Documento Completo</a>';
                }?>
            </td>
        </tr>
      <?php if($model->id_estado==6) { ?>
        <tr><th>Pdf RECIBO</th>
            <td>
              <?php if(!empty($model->pdf_recibo))
                {
                echo '<iframe src="'.$model->pdf_recibo.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="'.$model->pdf_recibo.'" target="_blank">Ver Documento Completo</a>';
                }?>
            </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>

</div>
