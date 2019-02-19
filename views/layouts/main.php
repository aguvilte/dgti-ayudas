<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container">
    <header id="navtop">
		<a class="logo fleft">
			<img src="/img/logo-lar (1).png" alt="La Rioja - Argentina">
		</a>
    <a href="./index.php">
      <h2 class="titulo-principal">Sistema de Registración de Ayudas Económicas</h2>
    </a>
		<a class="logo fright">
			<img src="/img/escudo-lar.png" alt="La Rioja - Argentina">
		</a>
	</header>

    <div class="home-page main">
        <header>
          <?php if (!Yii::$app->user->isGuest) { echo '<b>Usuario Activo:</b> ';  echo Html::a(Yii::$app->user->identity->username, ['usuarios-perfil/view', 'id' => Yii::$app->user->identity->id,'title' => 'Mi Perfil'])  ; } ?>
        </header>

        <div class="row cabecera-contenido">
            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="form-group">
                  <button type="button" class="btn btn-default"  onclick="history.go(-1)" title="Volver a la pagina principal de la intranet">
                    <span class="glyphicon glyphicon-arrow-left"></span> Volver atrás
                 </button>
              </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6">
              <div class="form-group text-right">
                  <?php if(!Yii::$app->user->getIsGuest()){ ?>

                    <?= Html::a('Cerrar Sesión', ['site/logout'], ['data-method' => 'post', 'class'=>'btn btn-primary']) ?>

                  <?php } ?>
              </div>

              <div class="form-group text-right">
                  <?php if(!Yii::$app->user->getIsGuest()){ ?>

                    <?= Html::a('Administrador', ['site/administrador'], ['data-method' => 'post', 'class'=>'btn btn-default']) ?>

                  <?php } ?>
              </div>
            </div>
        </div>

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>

    </div>
</div>


<div class="divide-top">
    <footer class="grid-wrap">
        <p class="footer-copyright">
		    Desarrollo: Dirección General de Tecnología e Informática - Subsecretaría Legal, Técnica y de Gestión Pública
			Copyright &copy; <?= date('Y') ?> <br>
			Gobierno del Pueblo de La Rioja. Todos los derechos reservados.
		</p>
	</footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
