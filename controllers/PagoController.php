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
class PagoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
              return [
                  'access' => [
                      'class' => AccessControl::className(),
                      'only' => ['view','index','pago','mpdf','pdf_ayuda'],
                      'rules' => [
                        [
                            //El administrador tiene permisos sobre las siguientes acciones
                            'actions' => ['view','index','pago','mpdf','pdf_ayuda'],
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
                            'actions' => ['view','index','pago','mpdf','pdf_ayuda'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                               return Usuarios::isPago(Yii::$app->user->identity->id);
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
    public function actionIndex()
    {
        $searchModel = new AyudasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize=20;
        
        return $this->render('index', [
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

    public function actionAutorizacion($id)
    {

      $ayuda = Ayudas::find()
            ->where(['id_ayuda'=>$id])
            ->one();

      //Ayudas::updateAllCounters(['id_estado' => 1]);
      $ayuda->id_estado=5; //estado autorizado
      $ayuda->save(false);

      RegistroMovimientos::registrarMovimiento(3, 'AUTORIZACIÓN', $ayuda->id_ayuda);

      return $this->render('view', [
            'model' => $this->findModel($id),
            'id' => $id,
        ]);
    }

    public function actionPago($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {


          if($model->fecha_pago!= NULL) {


               //$NombrePdf = $model->nro_decreto;
                $NombrePdf = str_replace("/","-", $model->id_ayuda);
                $NombrePdf = $model->id_ayuda.'-'.$NombrePdf;

                $model->file4 = UploadedFile::getInstance($model,'file4');
                if(!empty($model->file4)){
                    /*Guardamos pdf en carpeta uploads*/ 
                    $model->file4->saveAs( 'uploads/Pdf-RECIBO/'.$NombrePdf.'.'.$model->file4->extension );

                    /*Le asignamos en la db la ruta donde esta el pdf*/ 
                    $model->pdf_recibo = 'uploads/Pdf-RECIBO/'.$NombrePdf.'.'.$model->file4->extension;
                 
                  $model->id_estado=6;
                  $model->save(false);

                  RegistroMovimientos::registrarMovimiento(3, 'PAGO', $model->id_ayuda);

                  return $this->redirect(['view', 'id' => $model->id_ayuda]);
                } else {
                  throw new NotFoundHttpException('Es requerido que complete el campo de PDF Recibo para realizar la operación.');
                }
            }else {
              throw new NotFoundHttpException('Es requerido que complete el campo de Fecha de Pago para realizar la operación.');
            }
        } else {
            return $this->render('pago', [
                'model' => $model,
            ]);
        }
    }


    public function actionMpdf()
    {
        $searchModel  = new AyudasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        $content = $this->renderPartial('mpdf', ['dataProvider' => $dataProvider,'searchModel'  => $searchModel]);
        
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

    public function actionPdf_ayuda($id)
    {

      /*BUSCO DATOS DE LA AYUDA*/

      $ayuda = Ayudas::find()
                  ->where(['id_ayuda'=>$id])
                  ->one();
      $beneficiario = Beneficiarios::find()
                ->where(['id_beneficiario'=>$ayuda->id_beneficiario])
                ->one();

      return $this->render('pdf_ayuda', [
                'ayuda' => $ayuda,
                'beneficiario'=>$beneficiario,
          ]);

    }

    public function actionPdf_recibo($id)
    {

      /*BUSCO DATOS DE LA AYUDA*/

      $ayuda = Ayudas::find()
                  ->where(['id_ayuda'=>$id])
                  ->one();
      $beneficiario = Beneficiarios::find()
                ->where(['id_beneficiario'=>$ayuda->id_beneficiario])
                ->one();

      return $this->render('pdf_recibo', [
                'ayuda' => $ayuda,
                'beneficiario'=>$beneficiario,
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
