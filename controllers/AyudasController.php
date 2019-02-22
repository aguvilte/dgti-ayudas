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
use app\models\TiposAyudas;
use app\models\Estados;
use app\models\Areas;
use app\models\Movimientos;
use app\models\AyudasExpedientes;
use app\components\RegistroMovimientos;

class AyudasController extends Controller
{
    public function behaviors()
    {
              return [
                  'access' => [
                      'class' => AccessControl::className(),
                      'only' => ['view','enviar','update','index','mensaje_exito','create','mpdf','pdf_ayuda','updatepdf_doc_adjunta','updatepdfgestor','updatepdfnota','updatepdfdomicilio'],
                      'rules' => [
                        [
                            //El administrador tiene permisos sobre las siguientes acciones
                            'actions' => ['view','enviar','update','index','mensaje_exito','create','mpdf','pdf_ayuda','updatepdf_doc_adjunta','updatepdfgestor','updatepdfnota','updatepdfdomicilio'],
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
                            'actions' => ['view','enviar','update','index','mensaje_exito','create','mpdf','pdf_ayuda','updatepdf_doc_adjunta','updatepdfgestor','updatepdfnota','updatepdfdomicilio'],
                            'allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                               return Usuarios::isAyudas(Yii::$app->user->identity->id);
                           },
                         ],
                     ],
                  ],
              ];
          }

    public function actionIndex()
    {
        $searchModel = new AyudasSearch();
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
            'id' => $id,
        ]);
    }

     public function actionEnviar($id)
    {

      $ayuda = Ayudas::find()
            ->where(['id_ayuda'=>$id])
            ->one();

      //Ayudas::updateAllCounters(['id_estado' => 1]);
      $ayuda->id_estado=2; //estado en proceso, lo que permite mostrarse en la otra seccion y evita que se realicen modificaciones o eliminacion de la ayuda
      $ayuda->save(false);

      RegistroMovimientos::registrarMovimiento(2, 'ENVIO', $ayuda->id_ayuda);

      return $this->render('mensaje_exito');
    }

    public function actionCancelar($id)
    {

      $ayuda = Ayudas::find()
            ->where(['id_ayuda'=>$id])
            ->one();

      //Ayudas::updateAllCounters(['id_estado' => 1]);
      $ayuda->id_estado=4; //estado cancelado.
      $ayuda->save(false);

      $ayudaExpediente = AyudasExpedientes::find()
                        ->where(['id_ayuda'=>$id])
                        ->one();
       if(!empty($ayudaExpediente)){                 
                $ayudaExpediente->delete();
            }

      RegistroMovimientos::registrarMovimiento(2, 'CANCELADO', $ayuda->id_ayuda);

      return $this->render('mensaje_cancelado');
    }

    public function actionMensaje_exito()
    {
      return $this->render('mensaje_exito');
    }

    public function actionCreate($id,$documento)
    {
        $model = new Ayudas();

        if ($model->load(Yii::$app->request->post())) {

            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $fecha = Date('Y-m-d');
            $model->fecha_entrada=$fecha;

            $model->id_beneficiario=$id;
            $model->id_estado=1; //estado iniciado

            //$NombrePdf = $model->nro_decreto;
            $NombrePdf = str_replace("/","-", $model->id_beneficiario.'-'.$model->fecha_entrada);

                $model->file = UploadedFile::getInstance($model,'file');
                if(!empty($model->file)){
                    /*Guardamos pdf en carpeta uploads*/ 
                    $model->file->saveAs( 'uploads/Pdf-DOC-ADJUNTA/'.$NombrePdf.'.'.$model->file->extension );

                    /*Le asignamos en la db la ruta donde esta el pdf*/ 
                    $model->pdf_doc_adjunta = 'uploads/Pdf-DOC-ADJUNTA/'.$NombrePdf.'.'.$model->file->extension;
                }

            //$NombrePdf = $model->nro_decreto;
            $NombrePdf = str_replace("/","-", $model->id_beneficiario.'-'.$model->fecha_entrada);

                $model->file1 = UploadedFile::getInstance($model,'file1');
                if(!empty($model->file1)){
                    /*Guardamos pdf en carpeta uploads*/ 
                    $model->file1->saveAs( 'uploads/Pdf-GESTOR/'.$NombrePdf.'.'.$model->file1->extension );

                    /*Le asignamos en la db la ruta donde esta el pdf*/ 
                    $model->pdf_gestor = 'uploads/Pdf-GESTOR/'.$NombrePdf.'.'.$model->file1->extension;
                }

            //$NombrePdf = $model->nro_decreto;
            $NombrePdf = str_replace("/","-", $model->id_beneficiario.'-'.$model->fecha_entrada);

                $model->file2 = UploadedFile::getInstance($model,'file2');
                if(!empty($model->file2)){
                    /*Guardamos pdf en carpeta uploads*/ 
                    $model->file2->saveAs( 'uploads/Pdf-NOTA/'.$NombrePdf.'.'.$model->file2->extension );

                    /*Le asignamos en la db la ruta donde esta el pdf*/ 
                    $model->pdf_nota = 'uploads/Pdf-NOTA/'.$NombrePdf.'.'.$model->file2->extension;
                }

            //$NombrePdf = $model->nro_decreto;
            $NombrePdf = str_replace("/","-", $model->id_beneficiario.'-'.$model->fecha_entrada);

            $model->file3 = UploadedFile::getInstance($model,'file3');
            if(!empty($model->file3)){
                /*Guardamos pdf en carpeta uploads*/ 
                $model->file3->saveAs( 'uploads/Pdf-DOMICILIO/'.$NombrePdf.'.'.$model->file3->extension );

                /*Le asignamos en la db la ruta donde esta el pdf*/ 
                $model->pdf_domicilio = 'uploads/Pdf-DOMICILIO/'.$NombrePdf.'.'.$model->file3->extension;
            }

            $model->save();

            RegistroMovimientos::registrarMovimiento(2, 'CREACIÓN', $model->id_ayuda);

            return $this->redirect(['view', 'id' => $model->id_ayuda]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'id' => $id,
                'documento' => $documento,
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


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

              RegistroMovimientos::registrarMovimiento(2, 'ACTUALIZACION', $model->id_ayuda);

            return $this->redirect(['view', 'id' => $model->id_ayuda]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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

    public function actionDelete($id) {
        $model = $this->findModel($id);

        $estado = $model->id_estado;

        if ($estado==1) {
            $pdf_doc_adjunta=$model->pdf_doc_adjunta;

            if (empty($pdf_doc_adjunta)) {
            } else {
                unlink($pdf_doc_adjunta);
            }

            $model = $this->findModel($id);
            $pdf_gestor=$model->pdf_gestor;

            if (empty($pdf_gestor)) {
            } else {
                unlink($pdf_gestor);
            }

            $model = $this->findModel($id);
            $pdf_nota=$model->pdf_nota;

            if (empty($pdf_nota)) {
            } else {
                unlink($pdf_nota);
            }

            $model = $this->findModel($id);
            $pdf_domicilio=$model->pdf_domicilio;

            if (empty($pdf_domicilio)) {
            } else {
                unlink($pdf_domicilio);
            }

            RegistroMovimientos::registrarMovimiento(2, 'ELIMINACION', $model->id_ayuda);

            $this->findModel($id)->delete();

            return $this->redirect(['index']);
        } else {
            throw new NotFoundHttpException('No se puede eliminar una ayuda que no esté en estado iniciada.');
        }
    }

    public function actionUpdatepdf_doc_adjunta($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $NombrePdf1 = str_replace("/","-", $model->id_ayuda);
            $NombrePdf1 = $model->id_ayuda.'-'.$NombrePdf1;
            $model->file = UploadedFile::getInstance($model,'file');

            if(!empty($model->file)){
                /*Guardamos pdf en carpeta uploads*/
                $model->file->saveAs( 'uploads/Pdf-DOC-ADJUNTA/'.$NombrePdf1.'.'.$model->file->extension );

                /*Le asignamos en la db la ruta donde esta el pdf*/
                $model->pdf_doc_adjunta = 'uploads/Pdf-DOC-ADJUNTA/'.$NombrePdf1.'.'.$model->file->extension;

                //ACTUALIZAMOS EL PDF
                $pdf_doc_adjunta=$model->pdf_doc_adjunta;
                $id_ayuda=$model->id_ayuda;

                $condition = ['and',
                ['=', 'id_ayuda', $id_ayuda],
                ];

                Ayudas::updateAll(['pdf_doc_adjunta' => $pdf_doc_adjunta],$condition);

                RegistroMovimientos::registrarMovimiento(2, 'Actualización PDF doc. adjunta', $model->id_ayuda);

                return $this->redirect(['view', 'id' => $model->id_ayuda]);
            } else {
                throw new NotFoundHttpException('Seleccione un archivo');
            }
        } else {
            return $this->render('updatepdf_doc_adjunta', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdatepdfgestor($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $NombrePdf1 = str_replace("/","-", $model->id_ayuda);
            $NombrePdf1 = $model->id_ayuda.'-'.$NombrePdf1;
            $model->file1 = Uploadedfile::getInstance($model,'file1');

            if(!empty($model->file1)){
                /*Guardamos pdf en carpeta uploads*/
                $model->file1->saveAs( 'uploads/Pdf-GESTOR/'.$NombrePdf1.'.'.$model->file1->extension );

                /*Le asignamos en la db la ruta donde esta el pdf*/
                $model->pdf_gestor = 'uploads/Pdf-GESTOR/'.$NombrePdf1.'.'.$model->file1->extension;

                //ACTUALIZAMOS EL PDF
                $pdf_gestor=$model->pdf_gestor;
                $id_ayuda=$model->id_ayuda;

                $condition = ['and',
                    ['=', 'id_ayuda', $id_ayuda],
                ];

                Ayudas::updateAll(['pdf_gestor' => $pdf_gestor],$condition);

                RegistroMovimientos::registrarMovimiento(2, 'Actualización PDF gestor', $model->id_ayuda);

                return $this->redirect(['view', 'id' => $model->id_ayuda]);
            } else {
                throw new NotFoundHttpException('Seleccione un archivo');
            }
        } else {
            return $this->render('updatepdfgestor', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdatepdfnota($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $NombrePdf1 = str_replace("/","-", $model->id_ayuda);
            $NombrePdf1 = $model->id_ayuda.'-'.$NombrePdf1;
            $model->file2 = Uploadedfile::getInstance($model,'file2');

            if(!empty($model->file2)){
                /*Guardamos pdf en carpeta uploads*/
                $model->file2->saveAs( 'uploads/Pdf-NOTA/'.$NombrePdf1.'.'.$model->file2->extension );

                /*Le asignamos en la db la ruta donde esta el pdf*/
                $model->pdf_nota = 'uploads/Pdf-NOTA/'.$NombrePdf1.'.'.$model->file2->extension;

                //ACTUALIZAMOS EL PDF
                $pdf_nota=$model->pdf_nota;
                $id_ayuda=$model->id_ayuda;

                $condition = ['and',
                ['=', 'id_ayuda', $id_ayuda],
                ];

                Ayudas::updateAll(['pdf_nota' => $pdf_nota],$condition);

                RegistroMovimientos::registrarMovimiento(2, 'Actualización PDF nota', $model->id_ayuda);

                return $this->redirect(['view', 'id' => $model->id_ayuda]);
            } else {
                throw new NotFoundHttpException('Seleccione un archivo');
            }
        } else {
            return $this->render('updatepdfnota', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdatepdfdomicilio($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $NombrePdf1 = str_replace("/","-", $model->id_ayuda);
            $NombrePdf1 = $model->id_ayuda.'-'.$NombrePdf1;
            $model->file3 = UploadedFile::getInstance($model,'file3');

            if(!empty($model->file3)){
                /*Guardamos pdf en carpeta uploads*/
                $model->file3->saveAs( 'uploads/Pdf-DOMICILIO/'.$NombrePdf1.'.'.$model->file3->extension );

                /*Le asignamos en la db la ruta donde esta el pdf*/
                $model->pdf_domicilio = 'uploads/Pdf-DOMICILIO/'.$NombrePdf1.'.'.$model->file3->extension;

                //ACTUALIZAMOS EL PDF
                $pdf_domicilio=$model->pdf_domicilio;
                $id_ayuda=$model->id_ayuda;

                $condition = ['and',
                    ['=', 'id_ayuda', $id_ayuda],
                ];

                Ayudas::updateAll(['pdf_domicilio' => $pdf_domicilio],$condition);

                RegistroMovimientos::registrarMovimiento(2, 'Actualización PDF domicilio', $model->id_ayuda);

                return $this->redirect(['view', 'id' => $model->id_ayuda]);
            } else {
                throw new NotFoundHttpException('Seleccione un archivo');
            }
        } else {
            return $this->render('updatepdfdomicilio', [
                'model' => $model,
            ]);
        }
    }

    public function actionFilters()
    {
        $searchModel = new AyudasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('filters', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionListado()
    {
        $searchModel  = new AyudasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination  = false;
        $content = $this->renderPartial(
            'listado',
            [
                'dataProvider' => $dataProvider,
                'searchModel'  => $searchModel
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

    public function actionExcel() {
        $ayudas = Ayudas::find()
            ->orderBy(['id_ayuda' => SORT_DESC])   
            ->all();

        $filename = 'ayudas-'.Date('YmdGis').'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=" . $filename);
        echo '
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Apellido y nombre</th>
                        <th>Documento</th>
                        <th>Tipo de ayuda</th>
                        <th>Estado</th>
                        <th>Monto</th>
                        <th>Área</th>
                        <th>Fecha de pago</th>
                        <th>Fecha de eEntrada</th>
                        <th>Fecha de nota</th>
                    </tr>
                </thead>
        ';

        $i=0;
        foreach($ayudas as $ayuda){
            $i++;

            /*BUSCO DATOS DEL Beneficiario*/
            $idbeneficiario = $ayuda->id_beneficiario;

            $beneficiario = Beneficiarios::find()
                ->where(['id_beneficiario' => $idbeneficiario])
                ->one();

            $tipoAyuda = TiposAyudas::findOne($ayuda->id_tipo);
            if ($tipoAyuda !== null)
                $tipoAyuda = $tipoAyuda->nombre;
            else
                $tipoAyuda = '';

            $estado = Estados::findOne($ayuda->id_estado);
            if ($estado !== null)
                $estado = $estado->nombre;
            else
                $estado = '';

            $area = Areas::findOne($ayuda->id_area);
            if ($area !== null)
                $area = $area->nombre;
            else
                $area = '';

            echo '
                <tr>
                    <td>' . $i . '</td>
                    <td>' . $beneficiario['apeynom'] . '</td>
                    <td>' . $beneficiario['documento'] . '</td>
                    <td>' . $tipoAyuda . '</td>
                    <td>' . $estado . '</td>
                    <td>' . $ayuda['monto'] . '</td>
                    <td>' . $area . '</td>
                    <td>' . $ayuda['fecha_pago'] . '</td>
                    <td>' . $ayuda['fecha_entrada'] . '</td>
                    <td>' . $ayuda['fecha_nota'] . '</td>
                </tr>
            ';
        }
        echo '</table>';
    }

    protected function findModel($id)
    {
        if (($model = Ayudas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
