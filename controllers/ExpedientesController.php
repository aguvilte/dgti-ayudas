<?php

namespace app\controllers;

use Yii;
use app\models\Usuarios;
use yii\filters\AccessControl;
use app\models\Expedientes;
use app\models\ExpedientesSearch;
use app\models\AyudasExpedientes;
use app\models\AyudasExpedientesSearch;
use app\models\Ayudas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use app\components\RegistroMovimientos;

class ExpedientesController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view','ayudas','update','index','listado','create'],
                'rules' => [
                [
                    //El administrador tiene permisos sobre las siguientes acciones
                    'actions' => ['view','ayudas','update','index','listado','create'],
                    //Esta propiedad establece que tiene permisos
                    'allow' => true,
                    //Usuarios autenticados, el signo ? es para invitados
                    'roles' => ['@'],
                    //Este método nos permite crear un filtro sobre la identidad del usuario
                    //y así establecer si tiene permisos o no
                    'matchCallback' => function ($rule, $action) {
                        //Llamada al método que comprueba si es un administrador
                        return Usuarios::isUserAdmin(Yii::$app->user->identity->id);
                    },
                ],
                [
                    //Los usuarios simples tienen permisos sobre las siguientes acciones
                    'actions' => ['view','ayudas','update','index','listado','create'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Usuarios::isExpedientes(Yii::$app->user->identity->id);
                    },
                ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ExpedientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $searchModelAyudasExp = new AyudasExpedientesSearch();
        $dataProviderAyudasExp = $searchModelAyudasExp->search(Yii::$app->request->queryParams);
        $dataProviderAyudasExp->query->andWhere('id_expediente = ' . $id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'modelAyudasExp' => $searchModelAyudasExp,
            'dataProviderAyudasExp' => $dataProviderAyudasExp,
        ]);
    }

    public function actionCreate()
    {
        $model = new Expedientes();

        if ($model->load(Yii::$app->request->post())) {
            $model->monto_total = 0;
            $model->estado = 1;
            $model->fecha_alta = Date('Y-m-d');
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_expediente]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_expediente]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionAyudas($id)
    {
        $model = new Expedientes();
        $ayuda = Ayudas::findOne($id);

        if ($model->load(Yii::$app->request->post())) {
            $ayudasExpedientesModel = new AyudasExpedientes();
            $ayudasExpedientesModel->id_ayuda = $id;

            // trae el id_expediente como numero. no sé por qué
            $idExpediente = $model->numero;

            $ayudasExpedientesModel->id_expediente = $idExpediente;
            $ayudasExpedientesModel->save();

            $expedienteToActualizar = Expedientes::findOne($idExpediente);
            $expedienteToActualizar->monto_total = $expedienteToActualizar->monto_total + $ayuda->monto;
            $expedienteToActualizar->save();

            $descripcion='ASIGNACIÓN A Exp. nº'.$expedienteToActualizar->numero;
            RegistroMovimientos::registrarMovimiento(5, $descripcion, $ayudasExpedientesModel->id_ayuda);

            return $this->redirect(['index']);
        } else {
            return $this->render('ayudas', [
                'model' => $model,
                'ayuda' => $ayuda,
            ]);
        }
    }

    public function actionQuitar($id)
    {
        $ayudasExpedientes = AyudasExpedientes::find()
            ->where(['id_ayuda'=>$id])
            ->one();

        $ayuda = Ayudas::findOne($id);
        $expedienteToActualizar = Expedientes::findOne($ayudasExpedientes->id_expediente);

        $ayudasExpedientes->delete();

        $expedienteToActualizar->monto_total = $expedienteToActualizar->monto_total - $ayuda->monto;
        $expedienteToActualizar->save();

        $descripcion='DISLIGACIÓN A Exp. nº'.$expedienteToActualizar->numero;
        RegistroMovimientos::registrarMovimiento(5, $descripcion, $ayuda->id_ayuda);      

        return $this->redirect(['/expedientes/view','id'=>$expedienteToActualizar->id_expediente]);
    }

    public function actionListado($id)
    {
        $searchModel  = new AyudasExpedientesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere('id_expediente = ' . $id);

        $numeroExpediente = Expedientes::findOne($id)->numero;
        $montoExpediente = Expedientes::findOne($id)->monto_total;

        $dataProvider->pagination  = false;
        $content = $this->renderPartial(
            'listado',
            [
                'dataProvider' => $dataProvider,
                'searchModel'  => $searchModel,
                'numeroExp' => $numeroExpediente,
                'montoExp' => $montoExpediente,
            ]
        );
            
        $pdf = new Pdf([
            'format' => Pdf::FORMAT_A4, 
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            'destination' => Pdf::DEST_BROWSER, 
            'content' => $content,  
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}', 
            'options' => ['title' => 'Krajee Report Title'],
            'methods' => [ 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
        
        return $pdf->render(); 
    }

    public function actionCerrar($id)
    {
        $model = $this->findModel($id);
        $model->estado = 0;
        $model->fecha_cierre = Date('Y-m-d');
        $model->save();

        return $this->redirect(['view', 'id' => $model->id_expediente]);
    }

    protected function findModel($id)
    {
        if (($model = Expedientes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
