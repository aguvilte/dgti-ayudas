<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->apeynom;
$this->params['breadcrumbs'][] = ['label' => 'Beneficiarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="beneficiarios-view">

    <h2 class="titulo-area"><?= Html::encode($this->title) ?></h2>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->id_beneficiario], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->id_beneficiario], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'apeynom',
            'documento',
            'cuil',
            'fecha_nacimiento',
            'lugar_nacimiento',
            'domicilio',
            'telefono_fijo',
            'telefono_celular',
            [
                'attribute' => 'file',
                'label' => 'Archivo PDF de DNI',
                'format' => 'raw',
                'value' => function ($model) {
                    if (!empty($model->ruta_pdf))
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $model->file, [ 'title' => Yii::t('app', 'Ver PDF'),'target'=>'_blank','class' => 'btn btn-success btn-xs']) .' '. Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['updatepdfdni', 'id' => $model->id_beneficiario ],['title' => Yii::t('app', 'Actualizar PDF'),'class' => 'btn btn-warning btn-xs']);
                    else
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['updatepdfdni', 'id' => $model->id_beneficiario ],['title' => Yii::t('app', 'Subir PDF'),'class' => 'btn btn-success btn-xs']);
                },
                'options' => ['class' => 'tbl-col-pdf-ben'],
            ],
            [
                'attribute' => 'file1',
                'label' => 'Archivo PDF de CUIL',
                'format' => 'raw',
                'value' => function ($model) {
                    if (!empty($model->ruta_pdf))
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $model->file, [ 'title' => Yii::t('app', 'Ver PDF'),'target'=>'_blank','class' => 'btn btn-success btn-xs']) .' '. Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['updatepdfcuil', 'id' => $model->id_beneficiario ],['title' => Yii::t('app', 'Actualizar PDF'),'class' => 'btn btn-warning btn-xs']);
                    else
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', ['updatepdfcuil', 'id' => $model->id_beneficiario ],['title' => Yii::t('app', 'Subir PDF'),'class' => 'btn btn-success btn-xs']);
                },
                'options' => ['class' => 'tbl-col-pdf-ben'],
            ],
        ],
    ]) ?>

    <!-- <table class="table table-striped table-bordered detail-view">
        <tbody>
            <tr><th>Apellido y Nombre</th><td><?php echo $model->apeynom; ?></td></tr>
            <tr><th>Documento</th><td><?php echo $model->documento; ?></td></tr>
            <tr><th>Cuil</th><td><?php echo $model->cuil; ?></td></tr>
            <tr><th>Fecha de Nacimiento</th><td><?php echo $model->fecha_nacimiento; ?></td></tr>
            <tr><th>Lugar Nacimiento</th><td><?php echo $model->lugar_nacimiento; ?></td></tr>
            <tr><th>Domicilio</th><td><?php echo $model->domicilio; ?></td></tr>
            <tr><th>Telefono Fijo</th><td><?php echo $model->telefono_fijo; ?></td></tr>
            <tr><th>Telefono Celular</th><td><?php echo $model->telefono_celular; ?></td></tr>
            <tr><th>Pdf DNI</th>
            <td>
                <?php 
                if(!empty($model->pdf_dni)) {
                    echo '
                        <iframe src="/' . $model->pdf_dni.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                        <br>
                        <a href="/'.$model->pdf_dni.'" target="_blank">Ver Documento Completo</a>
                    ';
                }
                else {
                    echo '<a class="btn btn-success btn-xs" href="/index.php?r=beneficiarios%2Fupdatepdfdni&id='.$model->id_beneficiario.'" target="_blank" title="Subir PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }
                ?>
            </td>
        </tr>
        <tr><th>Pdf CUIL</th>
            <td>
              <?php if(!empty($model->pdf_cuil))
                {
                echo '<iframe src="/'.$model->pdf_cuil.'" style="width:300px; height:300px;" frameborder="0"></iframe>
                <br>
                <a href="/'.$model->pdf_cuil.'" target="_blank">Ver Documento Completo</a>';
                }else {
                   echo '<a class="btn btn-success btn-xs" href="/index.php?r=beneficiarios%2Fupdatepdfcuil&id='.$model->id_beneficiario.'" target="_blank" title="Subir PDF"><span class="glyphicon glyphicon-arrow-up"></span></a>';
                }?>
            </td>
        </tr>
      </tbody>
    </table> -->
</div>
