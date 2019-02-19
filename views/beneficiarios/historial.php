<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use app\models\Beneficiarios;
use app\models\Ayudas;
use app\models\TiposAyudas;
use app\models\Estados;

/* @var $this yii\web\View */
/* @var $model app\models\Beneficiario */
$this->title = 'Historial';
$this->params['breadcrumbs'][] = ['label' => 'Beneficiarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$titulo = $persona->apeynom ;
$id= $persona->id_persona;

?>
<div class="beneficiario-view">
    <div>
       <h2 class="titulo-area"><?= Html::encode($titulo) ?></h2>
       <hr>
    </div>

   <h4 class="margin-t-md"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;&nbsp;Información Basica</h4>

   <div class="panel panel-default">
    <?= DetailView::widget([
        'model' => $persona,
        'attributes' => [
            //'id_persona',
            'documento',
            'apeynom',
        ],
    ]) ?>
    </div>

    <div class="padding-v-md">
      <div class="line line-dashed"></div>
    </div>

    <h4><i class="glyphicon glyphicon-folder-open"></i>&nbsp;&nbsp;Historial de Ayudas Económicas</h4>

    <?php
      foreach($ayudas as $ayuda) {

        echo "<div class='panel panel-default'>";
          echo DetailView::widget([
                 'model' => $ayuda,
                 'attributes' => [
                     [
                'label' => 'Tipo de Ayuda',
                'attribute'=>'id_tipo',
                'value'=>function ($ayuda) {
                   if (!empty($ayuda->id_tipo))
                   {
                    $tipo= TiposAyudas::find()
                          ->where(['id_tipo'=>$ayuda->id_tipo])
                          ->one();

                    return $tipo->nombre;
                   }
                },
              ],
            [
                'label' => 'Estado del Trámite',
                'attribute'=>'id_estado',
                'value'=>function ($estado) {
                   if (!empty($estado->id_estado))
                   {
                    $estado= Estados::find()
                          ->where(['id_estado'=>$estado->id_estado])
                          ->one();

                    return $estado->nombre;
                   }
                },
              ],
            [
                'label' => 'Entrega DNI',
                'attribute'=>'entrega_dni',
                'value'=>function ($ayuda) {
                   if (!empty($ayuda->entrega_dni))
                   {
                    $entrega_dni=$ayuda->entrega_dni;
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
                'value'=>function ($ayuda) {
                   if (!empty($ayuda->entrega_cuil))
                   {
                    $entrega_cuil=$ayuda->entrega_cuil;
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
             ]);
      echo "</div>";
      
    ?>

  <table class="table table-striped table-bordered detail-view">
      <tbody>
        <tr><th>Pdf DOCUMENTACIÓN ADJUNTA</th>
            <td>
              <?php if(!empty($ayuda->pdf_doc_adjunta))
                {
                echo '<iframe src="/'.$ayuda->pdf_doc_adjunta.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="/'.$ayuda->pdf_doc_adjunta.'" target="_blank">Ver Documento Completo</a>';
                echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdf_doc_adjunta&id='.$ayuda->id_ayuda.'" target="_blank" title="Actualizar PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
              }else {
                 echo '<a class="btn btn-success btn-xs" href="/index.php?r=ayudas%2Fupdatepdf_doc_adjunta&id='.$ayuda->id_ayuda.'" target="_blank" title="Subir PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
              }?>
            </td>
        </tr>
        <tr><th>Pdf GESTOR</th>
            <td>
              <?php if(!empty($ayuda->pdf_gestor))
                {
                echo '<iframe src="/'.$ayuda->pdf_gestor.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="/'.$ayuda->pdf_gestor.'" target="_blank">Ver Documento Completo</a>';
                echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdfgestor&id='.$ayuda->id_ayuda.'" target="_blank" title="Actualizar PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }else {
                   echo '<a class="btn btn-success btn-xs" href="/index.php?r=ayudas%2Fupdatepdfgestor&id='.$ayuda->id_ayuda.'" target="_blank" title="Subir PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }?>
            </td>
        </tr>
        <tr><th>Pdf NOTA SOLICITUD</th>
            <td>
              <?php if(!empty($ayuda->pdf_nota))
                {
                echo '<iframe src="/'.$ayuda->pdf_nota.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="/'.$ayuda->pdf_nota.'" target="_blank">Ver Documento Completo</a>';
                echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdfnota&id='.$ayuda->id_ayuda.'" target="_blank" title="Actualizar PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }else {
                   echo '<a class="btn btn-success btn-xs" href="/index.php?r=ayudas%2Fupdatepdfnota&id='.$ayuda->id_ayuda.'" target="_blank" title="Subir PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }?>
            </td>
        </tr>
        <tr><th>Pdf DOMICILIO</th>
            <td>
              <?php if(!empty($ayuda->pdf_domicilio))
                {
                echo '<iframe src="/'.$ayuda->pdf_domicilio.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="/'.$ayuda->pdf_domicilio.'" target="_blank">Ver Documento Completo</a>';
                echo '<a class="btn btn-success btn-xs" href="/ayudas/web/index.php?r=ayudas%2Fupdatepdfdomicilio&id='.$ayuda->id_ayuda.'" target="_blank" title="Actualizar PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }else {
                   echo '<a class="btn btn-success btn-xs" href="/index.php?r=ayudas%2Fupdatepdfdomicilio&id='.$ayuda->id_ayuda.'" target="_blank" title="Subir PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }?>
            </td>
        </tr>
      </tbody>
    </table>

    <?php
    echo '<br><div class="padding-v-md">
              <div class="line line-dashed"></div>
            </div>';
      }

      ?>

</div>
