<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Beneficiarios;
use app\models\TiposAyudas;
use app\models\Estados;

/* @var $this yii\web\View */
/* @var $model app\models\Ayudas */

$this->title = 'Ver Ayuda';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="ayudas-view">


    <div class="row cabecera-contenido text-right">
      <a class="btn btn-pdf" target="_blank" href="?r=ayudas%2Fpdf_ayuda&id=<?php echo $id; ?>" title="Exportar" aria-label="Exportar">
        <span class="glyphicon glyphicon-stats"></span> Exportar Informe
      </a>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Apellido y Nombre',
                'attribute'=>'id_persona',
                'value'=>function ($model) {
                   if (!empty($model->id_persona))
                   {
                      $persona = beneficiarios::findOne($model->id_persona);
                      if ($persona !== null) {
                          return $persona->apeynom;
                      }
                   }
                },
              ],
              [
                'label' => 'Documento',
                'attribute'=>'id_persona',
                'value'=>function ($model) {
                   if (!empty($model->id_persona))
                   {
                      $persona = Beneficiarios::findOne($model->id_persona);
                      if ($persona !== null) {
                          return $persona->documento;
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
                'attribute'=>'entrega_dni',
                'value'=>function ($model) {
                   if (!empty($model->entrega_dni))
                   {
                    $entrega_dni=$model->entrega_dni;
                     if($entrega_dni == '1') {
                         return $entrega_dni = 'Sin entregar'; // or return false;
                      } else if($entrega_dni == '2') {
                         return $entrega_dni = 'Entregado'; // or return false;
                      }
                   }
                },
              ],
            [
                'label' => 'Entrega CUIL',
                'attribute'=>'entrega_cuil',
                'value'=>function ($model) {
                   if (!empty($model->entrega_cuil))
                   {
                    $entrega_cuil=$model->entrega_cuil;
                     if($entrega_cuil == '1') {
                         return $entrega_cuil = 'Sin entregar'; // or return false;
                      } else if($entrega_cuil == '2') {
                         return $entrega_cuil = 'Entregado'; // or return false;
                      }
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
            'area',
            'encargado',
        ],
    ]) ?>

    <table class="table table-striped table-bordered detail-view">
      <tbody>
        <tr><th>Pdf DOCUMENTACIÓN ADJUNTA</th>
            <td>
              <?php if(!empty($model->pdf_doc_adjunta))
                {
                echo '<iframe src="/ayudas/web/'.$model->pdf_doc_adjunta.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="/ayudas/web/'.$model->pdf_doc_adjunta.'" target="_blank">Ver Documento Completo</a>';
                echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdf_doc_adjunta&id='.$model->id_ayuda.'" target="_blank" title="Actualizar PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
              }else {
                 echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdf_doc_adjunta&id='.$model->id_ayuda.'" target="_blank" title="Subir PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
              }?>
            </td>
        </tr>
        <tr><th>Pdf GESTOR</th>
            <td>
              <?php if(!empty($model->pdf_gestor))
                {
                echo '<iframe src="/ayudas/web/'.$model->pdf_gestor.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="/ayudas/web/'.$model->pdf_gestor.'" target="_blank">Ver Documento Completo</a>';
                echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdfgestor&id='.$model->id_ayuda.'" target="_blank" title="Actualizar PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }else {
                   echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdfgestor&id='.$model->id_ayuda.'" target="_blank" title="Subir PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }?>
            </td>
        </tr>
        <tr><th>Pdf NOTA SOLICITUD</th>
            <td>
              <?php if(!empty($model->pdf_nota))
                {
                echo '<iframe src="/ayudas/web/'.$model->pdf_nota.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="/ayudas/web/'.$model->pdf_nota.'" target="_blank">Ver Documento Completo</a>';
                echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdfnota&id='.$model->id_ayuda.'" target="_blank" title="Actualizar PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }else {
                   echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdfnota&id='.$model->id_ayuda.'" target="_blank" title="Subir PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }?>
            </td>
        </tr>
        <tr><th>Pdf DOMICILIO</th>
            <td>
              <?php if(!empty($model->pdf_domicilio))
                {
                echo '<iframe src="/ayudas/web/'.$model->pdf_domicilio.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="/ayudas/web/'.$model->pdf_domicilio.'" target="_blank">Ver Documento Completo</a>';
                echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdfdomicilio&id='.$model->id_ayuda.'" target="_blank" title="Actualizar PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }else {
                   echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdfdomicilio&id='.$model->id_ayuda.'" target="_blank" title="Subir PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }?>
            </td>
        </tr>
      </tbody>
    </table>

</div>
