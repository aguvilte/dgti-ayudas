<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Ayudas;
use app\models\Beneficiarios;
use app\models\TiposAyudas;
use app\models\Areas;
use app\models\Referentes;
use app\models\Estados;


/* @var $this yii\web\View */
/* @var $model app\models\Devoluciones */

$this->title = 'Observaciones';
$this->params['breadcrumbs'][] = ['label' => 'Ayudas', 'url' => ['/pago/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="devoluciones-view">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>


    <h4><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Observaciones para la ayuda.</h4>
    <p>
        <?= Html::a('Crear Nueva Observacion', ['create', 'id' => $model->id_ayuda], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
      foreach($Observaciones as $Observacion) {

          echo "<div class='panel panel-default'>";
          echo DetailView::widget([
                 'model' => $Observacion,
                 'attributes' => [
            'descripcion',
            [
                'attribute' => 'fecha_observacion',
                'format' => ['date', 'php:d-m-Y']
            ],
                 ],
             ]);
      echo "</div>";
    }
    ?>

    <h4><i class="glyphicon glyphicon-unchecked"></i>&nbsp;&nbsp;Ayuda Económica</h4>

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
      </tbody>
    </table>

</div>

