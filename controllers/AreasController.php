<?php

namespace app\controllers;

use Yii;
use app\components\RegistroMovimientos;
use app\models\Areas;
use app\models\AreasSearch;
use app\models\Usuarios;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AreasController extends Controller
{
     public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view','update','index','create'],
                'rules' => [
                [
                    //El administrador tiene permisos sobre las siguientes acciones
                    'actions' => ['view','update','index','create'],
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
                    'actions' => ['view','update','index','create'],
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => function ($rule, $action) {
                        return Usuarios::isAreas(Yii::$app->user->identity->id);
                    },
                ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new AreasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Areas();

        if ($model->load(Yii::$app->request->post())) {
            $model->estado = 1;
            $model->save();
           
            RegistroMovimientos::registrarMovimiento(6, 'CREACION', $model->id_area);  

            return $this->redirect(['view', 'id' => $model->id_area]);
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
            RegistroMovimientos::registrarMovimiento(6, 'ACTUALIZACION', $model->id_area);  
            return $this->redirect(['view', 'id' => $model->id_area]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $areaToInactiva = $this->findModel($id);
        $areaToInactiva->estado = 0;
        $areaToInactiva->save();
        
        RegistroMovimientos::registrarMovimiento(6, 'ELIMINACION', $model->id_area);  

        // Yii::info('se eliminó un área (id=' . Yii::$app->user->getId() . ')', 'eliminacion_area');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Areas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
