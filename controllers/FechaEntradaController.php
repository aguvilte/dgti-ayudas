<?php

namespace app\controllers;

use Yii;
use app\models\Usuarios;
use yii\filters\AccessControl;
use app\models\Ayudas;
use app\models\AyudasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;
use app\models\Beneficiarios;
use app\models\Movimientos;
use app\components\RegistroMovimientos;

/**
 * AyudasController implements the CRUD actions for Ayudas model.
 */
class FechaEntradaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
              return [
                  'access' => [
                      'class' => AccessControl::className(),
                      'only' => ['fechas','view','fecha_entrada','mpdffecha_entrada'],
                      'rules' => [
                        [
                            //El administrador tiene permisos sobre las siguientes acciones
                            'actions' => ['fechas','view','fecha_entrada','mpdffecha_entrada'],
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
                            'actions' => ['fechas','fecha_entrada','mpdffecha_entrada'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                               return Usuarios::isFechaEntrada(Yii::$app->user->identity->id);
                           },
                         ],
                     ],
                  ],
              ];
          }

    /**
     * Lists all Ayudas models.
     * @return mixed
     */
    public function actionFechas()
    {
        $searchModel = new AyudasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize=20;

        return $this->render('fechas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Ayudas model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'id' => $id,
        ]);
    }

    /**
     * Creates a new Ayudas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    /**
     * Updates an existing Ayudas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionMpdffecha_entrada()
    {
        $searchModel  = new AyudasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        $content = $this->renderPartial('mpdffecha_entrada', ['dataProvider' => $dataProvider,'searchModel'  => $searchModel]);
        
        $arrayMeses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');

        $arrayDias = array( 'Domingo', 'Lunes', 'Martes',
              'Miercoles', 'Jueves', 'Viernes', 'Sabado');

        ini_set('date.timezone','America/Argentina/La_Rioja');
        $hora = date("g:i A");

         $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8, 
            'format' => Pdf::FORMAT_A4, 
            'orientation' => Pdf::ORIENT_LANDSCAPE, 
            'destination' => Pdf::DEST_BROWSER, 
            'content' => $content,  
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => '.kv-heading-1{font-size:18px}', 
            'options' => ['title' => 'Ayudas'],
            'methods' => [ 
                          'SetHeader' => [$arrayDias[date('w')].", ".date('d')." de ".$arrayMeses[date('m')-1]." de ".date('Y').", ".$hora],
                          'SetFooter' => ['Desarrollo: Dirección General de Tecnologia Informatica.'],
            ]
        ]); 
        
        return $pdf->render(); 
    }


    /**
     * Deletes an existing Ayudas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    
    public function actionFecha_entrada()
    {
        $searchModel = new AyudasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize=20;

        return $this->render('fecha_entrada', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Ayudas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ayudas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ayudas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
