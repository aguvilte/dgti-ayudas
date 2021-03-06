<?php
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
            <?php 
            if ($model->id_rol == 1 or $model->id_rol == 2) {
                echo '
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="titulo-seccion">Área de Carga de Ayudas</h2>
                        </div>
                        <div class="panel-body">
                ';

                foreach ($UsuariosSecciones as $UsuariosSeccion) {

                    if ($UsuariosSeccion->id_seccion == 1) {
                        echo '
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon ">
                        ';
                        echo Html::a(Html::img('@web/img/ico_beneficiarios.png') . Yii::t('app','BENEFICIARIOS'), ['/beneficiarios/index']);
                        echo '
                                </div>
                            </article>
                        ';
                    }

                    if ($UsuariosSeccion->id_seccion == 2) {
                        echo '
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon ">
                        ';
                        echo Html::a(Html::img('@web/img/ico_consulta.png') . Yii::t('app','AYUDAS'), ['/ayudas/index']);
                        echo '
                                </div>
                            </article>
                        ';
                    }

                    if ($UsuariosSeccion->id_seccion == 10) {
                        echo '
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon ">
                        ';
                        echo Html::a(Html::img('@web/img/ico_informes.png') . Yii::t('app','LISTADOS'), ['/listado/index']);
                        echo '
                                </div>
                            </article>
                        ';
                    }
                }
                echo '</div>';
            ?>

            <?php
                echo '<div class="panel-body">';

                foreach ($UsuariosSecciones as $UsuariosSeccion) {
                    if ($UsuariosSeccion->id_seccion == 5) {
                        echo '
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon ">
                        ';
                        echo Html::a(Html::img('@web/img/ico_movimientos.png') . Yii::t('app','MOVIMIENTOS DE USUARIOS'), ['/movimientos/index']);
                        echo '
                                </div>
                            </article>
                        ';
                    }
                }
                echo '</div>';
            }
            ?>

        </div>
        <div>


            <?php
            if ($model->id_rol==1 or $model->id_rol == 3) {
                echo '
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2 class="titulo-seccion">Área de Pago de Ayudas</h2>
                        </div>
                    <div class="panel-body">
                ';

                foreach ($UsuariosSecciones as $UsuariosSeccion) {

                    if ($UsuariosSeccion->id_seccion == 6) {
                        echo '
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon ">
                        ';
                        echo Html::a(Html::img('@web/img/ico_orden_pago.png') . Yii::t('app','PAGOS'), ['/pago/index']);
                        echo '
                                </div>
                            </article>
                        ';
                    }

                    if ($UsuariosSeccion->id_seccion == 11) {
                        echo '
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon ">
                        ';
                        echo Html::a(Html::img('@web/img/ico_informes.png') . Yii::t('app','LISTADOS'), ['/listado/index']);
                        echo '
                                </div>
                            </article>
                        ';
                    }

                    if ($UsuariosSeccion->id_seccion == 12) {
                        echo '
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon ">
                        ';
                        echo Html::a(Html::img('@web/img/ico_expedientes.png') . Yii::t('app','EXPEDIENTES'), ['/expedientes/index']);
                        echo '
                                </div>
                            </article>
                        ';
                    }
                   
                }
                echo '</div>';
            ?>

            <?php
                echo '<div class="panel-body">';

                foreach ($UsuariosSecciones as $UsuariosSeccion) {
                    if ($UsuariosSeccion->id_seccion == 11) {
                        echo '
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon ">
                        ';
                        echo Html::a(Html::img('@web/img/ico_areas.png') . Yii::t('app','TIPOS DE AYUDAS'), ['/tipos-ayudas/index']);
                        echo '
                                </div>
                            </article>
                        ';
                    }

                    if ($UsuariosSeccion->id_seccion == 13) {
                        echo '
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon ">
                        ';
                        echo Html::a(Html::img('@web/img/ico_estructuras.png') . Yii::t('app','ÁREAS'), ['/areas/index']);
                        echo '
                                </div>
                            </article>
                        ';
                    }

                    if ($UsuariosSeccion->id_seccion == 14) {
                        echo '
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon ">';
                        echo Html::a(Html::img('@web/img/ico_no_escalafonados.png') . Yii::t('app','REFERENTES'), ['/referentes/index']);
                        echo '
                                </div>
                            </article>
                        ';
                    }
                }
                echo '</div>';
            ?>

            <?php
                echo '<div class="panel-body">';

                foreach ($UsuariosSecciones as $UsuariosSeccion) {
                    if ($UsuariosSeccion->id_seccion == 9) {
                        echo '
                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon ">';
                        echo Html::a(Html::img('@web/img/ico_movimientos.png') . Yii::t('app','MOVIMIENTOS DE USUARIOS'), ['/movimientos/index']);
                        echo '
                                </div>
                            </article>
                        ';
                    }
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>
