<?php

namespace app\controllers;

use Yii;
use app\models\Usuarios;
use yii\filters\AccessControl;
use app\models\Referentes;
use app\models\ReferentesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\RegistroMovimientos;

class ReferentesController extends Controller
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
                        return Usuarios::isReferentes(Yii::$app->user->identity->id);
                    },
                ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new ReferentesSearch();
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
        $model = new Referentes();

        if ($model->load(Yii::$app->request->post())) {
            $model->estado = 1;
            $model->save();

            RegistroMovimientos::registrarMovimiento(7, 'CREACION', $model->id_referente);  

            return $this->redirect(['view', 'id' => $model->id_referente]);
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
            RegistroMovimientos::registrarMovimiento(7, 'ACTUALIZACION', $model->id_referente);  
            return $this->redirect(['view', 'id' => $model->id_referente]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $referenteToInactivo = $this->findModel($id);
        $referenteToInactivo->estado = 0;
        $referenteToInactivo->save();
        
        RegistroMovimientos::registrarMovimiento(7, 'ELIMINACION', $model->id_referente);  

        // RegistroMovimientos::registrarMovimiento(4, 'ELIMINACIÓN', $areaToInactiva->id_area);

        // Yii::info('se eliminó un área (id=' . Yii::$app->user->getId() . ')', 'eliminacion_area');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Referentes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
