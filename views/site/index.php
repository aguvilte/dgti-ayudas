<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'SRAE - Sistema de Registración de Ayudas Económicas';

?>
<div class="site-index">

    <div class="_jumbotron">
       <h2 class="titulo-area">Sistema de Registración de Ayudas Económicas</h2>
       <hr>
    </div>

    <div class="body-content">
        <div>

              <?php if ($model->id_rol==1 or $model->id_rol==2) {
                echo '
                <div class="panel panel-primary">
                  <div class="panel-heading">
                        <h2 class="titulo-seccion">Área de Carga de Ayudas</h2>
                  </div>
                  <div class="panel-body">';

                foreach ($UsuariosSecciones as $UsuariosSeccion) {

                  if ($UsuariosSeccion->id_seccion==1) {
                    echo '
                    <article class="grid col-one-quarter mq3-col-full">
                     <div class="ipanel_icon ">';
                      echo Html::a(Html::img('@web/img/ico_beneficiarios.png') . Yii::t('app','REGISTRAR'), ['/beneficiarios/index']);
                    echo '
                     </div>
                    </article>';
                  }
                  if ($UsuariosSeccion->id_seccion==2) {
                    echo '
                    <article class="grid col-one-quarter mq3-col-full">
                     <div class="ipanel_icon ">';
                      echo Html::a(Html::img('@web/img/ico_consulta.png') . Yii::t('app','AYUDAS'), ['/ayudas/filters']);
                    echo '
                     </div>
                    </article>';
                  }
                  if ($UsuariosSeccion->id_seccion==3) {
                    echo '
                    <article class="grid col-one-quarter mq3-col-full">
                     <div class="ipanel_icon ">';
                      echo Html::a(Html::img('@web/img/ico_historial.png') . Yii::t('app','CONSULTA POR FECHA DE PAGO'), ['/fecha-pago/fecha_pago']);
                    echo '
                     </div>
                    </article>';
                  }
                  if ($UsuariosSeccion->id_seccion==4) {
                    echo '
                    <article class="grid col-one-quarter mq3-col-full">
                     <div class="ipanel_icon ">';
                      echo Html::a(Html::img('@web/img/ico_historial.png') . Yii::t('app','CONSULTA POR FECHA DE ENTRADA'), ['/fecha-entrada/fecha_entrada']);
                    echo '
                     </div>
                    </article>';
                  }
                }
              echo '</div>';
              ?>

              <?php
                echo '<div class="panel-body">';

                foreach ($UsuariosSecciones as $UsuariosSeccion) {
                  if ($UsuariosSeccion->id_seccion==5) {
                    echo '
                    <article class="grid col-one-quarter mq3-col-full">
                     <div class="ipanel_icon ">';
                      echo Html::a(Html::img('@web/img/ico_movimientos.png') . Yii::t('app','MOVIMIENTOS'), ['/movimientos/index']);
                    echo '
                     </div>
                    </article>';
                  }
                  if ($UsuariosSeccion->id_seccion==10) {
                    echo '
                    <article class="grid col-one-quarter mq3-col-full">
                     <div class="ipanel_icon ">';
                      echo Html::a(Html::img('@web/img/ico_informes.png') . Yii::t('app','LISTADOS'), ['/listado/index']);
                    echo '
                     </div>
                    </article>';
                  }
                }
              echo '</div>';
              ?>

            <?php } ?>

          </div>


            <?php if ($model->id_rol==1 or $model->id_rol==3) {
                echo '
                <div class="panel panel-primary">
                  <div class="panel-heading">
                        <h2 class="titulo-seccion">Área de Pago de Ayudas</h2>
                  </div>
                  <div class="panel-body">';

                foreach ($UsuariosSecciones as $UsuariosSeccion) {

                  if ($UsuariosSeccion->id_seccion==6) {
                      echo '
                      <article class="grid col-one-quarter mq3-col-full">
                       <div class="ipanel_icon ">';
                        echo Html::a(Html::img('@web/img/ico_orden_pago.png') . Yii::t('app','PAGO'), ['/pago/index']);
                      echo '
                       </div>
                      </article>';
                    }
                  if ($UsuariosSeccion->id_seccion==7) {
                    echo '
                    <article class="grid col-one-quarter mq3-col-full">
                     <div class="ipanel_icon ">';
                      echo Html::a(Html::img('@web/img/ico_historial.png') . Yii::t('app','CONSULTA POR FECHA DE PAGO'), ['/fecha-pago/fecha_pago']);
                    echo '
                     </div>
                    </article>';
                  }
                  if ($UsuariosSeccion->id_seccion==8) {
                    echo '
                    <article class="grid col-one-quarter mq3-col-full">
                     <div class="ipanel_icon ">';
                      echo Html::a(Html::img('@web/img/ico_historial.png') . Yii::t('app','CONSULTA POR FECHA DE ENTRADA'), ['/fecha-entrada/fecha_entrada']);
                    echo '
                     </div>
                    </article>';
                  }
                   if ($UsuariosSeccion->id_seccion==9) {
                    echo '
                    <article class="grid col-one-quarter mq3-col-full">
                     <div class="ipanel_icon ">';
                      echo Html::a(Html::img('@web/img/ico_movimientos.png') . Yii::t('app','MOVIMIENTOS'), ['/movimientos/index']);
                    echo '
                     </div>
                    </article>';
                  }
                }
              echo '</div>';
              ?>

              <?php
                echo '<div class="panel-body">';

                foreach ($UsuariosSecciones as $UsuariosSeccion) {

                  if ($UsuariosSeccion->id_seccion==11) {
                    echo '
                    <article class="grid col-one-quarter mq3-col-full">
                     <div class="ipanel_icon ">';
                      echo Html::a(Html::img('@web/img/ico_informes.png') . Yii::t('app','LISTADOS'), ['/listado/index']);
                    echo '
                     </div>
                    </article>';
                  }
                }
              echo '</div>';
              ?>

            <?php } ?>

                            <!--
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon"><?php //Html::a(Html::img('@web/img/ico_modificaciones.png') . Yii::t('app','MODIFICACIÓN'), ['/registros/modificacion']) ?></div>
                            </article>-->

        </div>
    </div>
</div>
