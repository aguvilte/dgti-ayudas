<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'SRA - Sistema de Registración de Ayudas';

?>
<div class="site-index">

    <div class="_jumbotron">
       <h2 class="titulo-area">Sistema de Registración de Ayudas Economicas</h2>
       <hr>
    </div>

    <div class="body-content">
        <div>
            <div class="panel panel-primary">
              <div class="panel-heading">
                    <h2 class="titulo-seccion">Administrador</h2>
              </div>
              <div class="panel-body">
                            <article class="grid col-one-quarter mq3-col-full">
                             <div class="ipanel_icon "><?= Html::a(Html::img('@web/img/ico_beneficiarios.png') . Yii::t('app','PERSONAS'), ['/personas/index']) ?></div>
                            </article>

                            <article class="grid col-one-quarter mq3-col-full">
                                <div class="ipanel_icon"><?= Html::a(Html::img('@web/img/ico_beneficiarios.png'). Yii::t('app','USUARIOS'), ['/usuarios/index']) ?></div>
                            </article>
 
              </div>
            </div>

        </div>
    </div>
</div>
