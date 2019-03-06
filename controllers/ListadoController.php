<?php

namespace app\controllers;

use Yii;
use app\models\Areas;
use app\models\Ayudas;
use app\models\AyudasExpedientes;
use app\models\AyudasSearch;
use app\models\Beneficiarios;
use app\models\Devoluciones;
use app\models\Estados;
use app\models\Expedientes;
use app\models\Referentes;
use app\models\TiposAyudas;
use app\models\Usuarios;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ListadoController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','excel_general_ayudas','excel_iniciados','excel_en_proceso','excel_inconvenientes','excel_pagadas'],
                'rules' => [
                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['index','excel_general_ayudas','excel_iniciados','excel_en_proceso','excel_inconvenientes','excel_pagadas'],
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
                        'actions' => ['index','excel_general_ayudas','excel_iniciados','excel_en_proceso','excel_inconvenientes','excel_pagadas'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Usuarios::isListado(Yii::$app->user->identity->id);
                        },
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        return $this->render('index', [
        ]);
    }

    public function actionExcel_general_ayudas()
    {

        $ayudas = Ayudas::find()
            ->orderBy(['id_ayuda'=>SORT_DESC])   
            ->all();

        $filename = 'Informe General de Ayudas-'.Date('YmdGis').'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=" . $filename);
        echo '<table border="1" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Apellido y Nombre</th>
                    <th>Documento</th>
                    <th>Tipo Ayuda</th>
                    <th>Estado</th>
                    <th>Monto</th>
                    <th>Area</th>
                    <th>Referente</th
                    <th>Fecha de Pago</th>
                    <th>Fecha de Entrada</th>
                    <th>Fecha de Nota</th>
                    <th>Nro Expediente</th>

                </tr>
            </thead>';

        $i=0;
        foreach($ayudas as $ayuda) {
            $i++;

            /*BUSCO DATOS DEL Beneficiario*/
            $idBeneficiario = $ayuda->id_beneficiario;

            $beneficiario = Beneficiarios::find()
                ->where(['id_beneficiario'=>$idBeneficiario])
                ->one();

            $tipoAyuda = TiposAyudas::findOne($ayuda->id_tipo);
            if ($tipoAyuda) {
                $tipoAyuda = $tipoAyuda->nombre;
            } else {
                $tipoAyuda = '';
            } 

            $estado = Estados::findOne($ayuda->id_estado);
            if ($estado) {
                $estado = $estado->nombre;
            } else {
                $estado='';
            }

            $area = Areas::findOne($ayuda->id_area);
            if ($area) {
            $area = $area->nombre;
            } else {
                $area = '';
            }

            $referente = Referentes::findOne($ayuda->id_referente);
            if ($referente) {
            $referente = $referente->apeynom;
            } else {
                $referente = '';
            }

            $ayudaExpediente = AyudasExpedientes::find()
                ->where(['id_ayuda'=>$ayuda->id_ayuda])
                ->one();

            if ($ayudaExpediente) {
                $expediente = Expedientes::findOne($ayudaExpediente->id_expediente);
                $expediente = $expediente->numero;  
            } else {
                $expediente = '';
            }                
            
            echo '
                <tr>
                    <td>'.$i.'</td>
                    <td>'.$beneficiario['apeynom'].'</td>
                    <td>'.$beneficiario['documento'].'</td>
                    <td>'.$tipoAyuda.'</td>
                    <td>'.$estado.'</td>
                    <td>'.$ayuda['monto'].'</td>
                    <td>'.$area.'</td>
                    <td>'.$referente.'</td>
                    <td>'.$ayuda['fecha_pago'].'</td>
                    <td>'.$ayuda['fecha_entrada'].'</td>
                    <td>'.$ayuda['fecha_nota'].'</td>
                    <td>'.$expediente.'</td>
                </tr>
            ';
        }
        echo '</table>';
    }

    public function actionExcel_iniciados()
    {
        $ayudas = Ayudas::find()
            ->where(['id_estado' => 1])
            ->orderBy(['id_ayuda' => SORT_DESC])   
            ->all();

        $filename = 'Informe General de Ayudas-'.Date('YmdGis').'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=" . $filename);
        echo '
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Apellido y Nombre</th>
                        <th>Documento</th>
                        <th>Tipo Ayuda</th>
                        <th>Estado</th>
                        <th>Monto</th>
                        <th>Area</th>
                        <th>Referente</th
                        <th>Fecha de Pago</th>
                        <th>Fecha de Entrada</th>
                        <th>Fecha de Nota</th>
                        <th>Nro Expediente</th>

                    </tr>
                </thead>
        ';

        $i=0;
        foreach($ayudas as $ayuda) {
        $i++;

        /*BUSCO DATOS DEL Beneficiario*/
        $idBeneficiario=$ayuda->id_beneficiario;

        $beneficiario = Beneficiarios::find()
            ->where(['id_beneficiario' => $idBeneficiario])
            ->one();

        $tipoAyuda = TiposAyudas::findOne($ayuda->id_tipo);
        if ($tipoAyuda) {
            $tipoAyuda = $tipoAyuda->nombre;
        } else {
            $tipoAyuda = '';
        } 

        $estado = Estados::findOne($ayuda->id_estado);
        if ($estado) {
            $estado = $estado->nombre;
        } else {
            $estado = '';
        }

        $area = Areas::findOne($ayuda->id_area);
        if ($area) {
            $area = $area->nombre;
        } else {
            $area = '';
        }

        $referente = Referentes::findOne($ayuda->id_referente);
        if ($referente) {
            $referente = $referente->apeynom;
        } else {
            $referente = '';
        }

        $ayudaExpediente = AyudasExpedientes::find()
            ->where(['id_ayuda' => $ayuda->id_ayuda])
            ->one();
            
        if ($ayudaExpediente) {
            $expediente = Expedientes::findOne($ayudaExpediente->id_expediente);
            $expediente = $expediente->numero;  
        } else {
            $expediente = '';
        }                
        
        echo '
            <tr>
                <td>'.$i.'</td>
                <td>'.$beneficiario['apeynom'].'</td>
                <td>'.$beneficiario['documento'].'</td>
                <td>'.$tipoAyuda.'</td>
                <td>'.$estado.'</td>
                <td>'.$ayuda['monto'].'</td>
                <td>'.$area.'</td>
                <td>'.$referente.'</td>
                <td>'.$ayuda['fecha_pago'].'</td>
                <td>'.$ayuda['fecha_entrada'].'</td>
                <td>'.$ayuda['fecha_nota'].'</td>
                <td>'.$expediente.'</td>
            </tr>
        ';
        }

    echo '</table>';
    }

    public function actionExcel_en_proceso()
    {

        $ayudas = Ayudas::find()
            ->where(['id_estado' => 2])
            ->orderBy(['id_ayuda' => SORT_DESC])   
            ->all();

        $filename = 'Informe General de Ayudas-'.Date('YmdGis').'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=".$filename);
        echo '
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Apellido y Nombre</th>
                        <th>Documento</th>
                        <th>Tipo Ayuda</th>
                        <th>Estado</th>
                        <th>Monto</th>
                        <th>Area</th>
                        <th>Referente</th
                        <th>Fecha de Pago</th>
                        <th>Fecha de Entrada</th>
                        <th>Fecha de Nota</th>
                        <th>Nro Expediente</th>

                    </tr>
                </thead>
        ';

        $i=0;

        foreach($ayudas as $ayuda) {
            $i++;

            /*BUSCO DATOS DEL Beneficiario*/
            $idBeneficiario=$ayuda->id_beneficiario;

            $beneficiario = Beneficiarios::find()
                ->where(['id_beneficiario'=>$idBeneficiario])
                ->one();

            $tipoAyuda = TiposAyudas::findOne($ayuda->id_tipo);
            if ($tipoAyuda) {
                $tipoAyuda = $tipoAyuda->nombre;
            } else {
                $tipoAyuda = '';
            } 

            $estado = Estados::findOne($ayuda->id_estado);
            if ($estado) {
                $estado = $estado->nombre;
            } else {
                $estado= '';
            }

            $area = Areas::findOne($ayuda->id_area);
            if ($area) {
                $area = $area->nombre;
            } else {
                $area = '';
            }

            $referente = Referentes::findOne($ayuda->id_referente);
            if ($referente) {
                $referente = $referente->apeynom;
            } else {
                $referente = '';
            }

            $ayudaExpediente = AyudasExpedientes::find()
                ->where(['id_ayuda'=>$ayuda->id_ayuda])
                ->one();
            if($ayudaExpediente){
                $expediente = Expedientes::findOne($ayudaExpediente->id_expediente);
                $expediente = $expediente->numero;  
            } else {
                $expediente = '';
            }                
            
            echo '
                <tr>
                    <td>'.$i.'</td>
                    <td>'.$beneficiario['apeynom'].'</td>
                    <td>'.$beneficiario['documento'].'</td>
                    <td>'.$tipoAyuda.'</td>
                    <td>'.$estado.'</td>
                    <td>'.$ayuda['monto'].'</td>
                    <td>'.$area.'</td>
                    <td>'.$referente.'</td>
                    <td>'.$ayuda['fecha_pago'].'</td>
                    <td>'.$ayuda['fecha_entrada'].'</td>
                    <td>'.$ayuda['fecha_nota'].'</td>
                    <td>'.$expediente.'</td>
                </tr>
            ';
        }

    echo '</table>';
    }

    public function actionExcel_inconvenientes()
    {
        $ayudas = Ayudas::find()
            ->where(['id_estado' => 3])
            ->orderBy(['id_ayuda'=>SORT_DESC])   
            ->all();

        $filename = 'Informe General de Ayudas-'.Date('YmdGis').'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=".$filename);
        echo '
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Apellido y Nombre</th>
                        <th>Documento</th>
                        <th>Tipo Ayuda</th>
                        <th>Estado</th>
                        <th>Monto</th>
                        <th>Area</th>
                        <th>Referente</th
                        <th>Fecha de Pago</th>
                        <th>Fecha de Entrada</th>
                        <th>Fecha de Nota</th>
                        <th>Nro Expediente</th>

                    </tr>
                </thead>
        ';

        $i=0;
            
        foreach($ayudas as $ayuda) {
            $i++;

            /*BUSCO DATOS DEL Beneficiario*/
            $idBeneficiario=$ayuda->id_beneficiario;

            $beneficiario = Beneficiarios::find()
                ->where(['id_beneficiario'=>$idBeneficiario])
                ->one();

            $tipoAyuda = TiposAyudas::findOne($ayuda->id_tipo);
            if ($tipoAyuda) {
                $tipoAyuda = $tipoAyuda->nombre;
            } else {
                $tipoAyuda = '';
            } 

            $estado = Estados::findOne($ayuda->id_estado);
            if ($estado) {
                $estado = $estado->nombre;
            } else {
                $estado= '';
            }

            $area = Areas::findOne($ayuda->id_area);
            if ($area) {
                $area = $area->nombre;
            } else {
                $area = '';
            }

            $referente = Referentes::findOne($ayuda->id_referente);
            if ($referente) {
                $referente = $referente->apeynom;
            } else {
                $referente = '';
            }

            $ayudaExpediente = AyudasExpedientes::find()
                ->where(['id_ayuda'=>$ayuda->id_ayuda])
                ->one();

            if($ayudaExpediente) {
                $expediente = Expedientes::findOne($ayudaExpediente->id_expediente);
                $expediente = $expediente->numero;  
            } else {
                $expediente = '';
            }                
        
            echo '
                <tr>
                    <td>'.$i.'</td>
                    <td>'.$beneficiario['apeynom'].'</td>
                    <td>'.$beneficiario['documento'].'</td>
                    <td>'.$tipoAyuda.'</td>
                    <td>'.$estado.'</td>
                    <td>'.$ayuda['monto'].'</td>
                    <td>'.$area.'</td>
                    <td>'.$referente.'</td>
                    <td>'.$ayuda['fecha_pago'].'</td>
                    <td>'.$ayuda['fecha_entrada'].'</td>
                    <td>'.$ayuda['fecha_nota'].'</td>
                    <td>'.$expediente.'</td>
                </tr>
            ';
        }

        echo '</table>';
    }

    public function actionExcel_canceladas()
    {

        $ayudas = Ayudas::find()
            ->where(['id_estado' => 4])
            ->orderBy(['id_ayuda'=>SORT_DESC])   
            ->all();

        $filename = 'Informe General de Ayudas-'.Date('YmdGis').'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=".$filename);
        echo '
            <table border="1" width="100%">
                  <thead>
                      <tr>
                          <th></th>
                          <th>Apellido y Nombre</th>
                          <th>Documento</th>
                          <th>Tipo Ayuda</th>
                          <th>Estado</th>
                          <th>Monto</th>
                          <th>Area</th>
                          <th>Referente</th
                          <th>Fecha de Pago</th>
                          <th>Fecha de Entrada</th>
                          <th>Fecha de Nota</th>
                          <th>Nro Expediente</th>

                      </tr>
                  </thead>
        ';

        $i=0;

        foreach($ayudas as $ayuda){
            $i++;

            /*BUSCO DATOS DEL Beneficiario*/
            $idBeneficiario=$ayuda->id_beneficiario;

            $beneficiario = Beneficiarios::find()
                ->where(['id_beneficiario'=>$idBeneficiario])
                ->one();

            $tipoAyuda = TiposAyudas::findOne($ayuda->id_tipo);
            if ($tipoAyuda) {
                $tipoAyuda = $tipoAyuda->nombre;
            } else {
                $tipoAyuda = '';
            } 

            $estado = Estados::findOne($ayuda->id_estado);
            if ($estado) {
                $estado = $estado->nombre;
            } else {
                $estado= '';
            }

            $area = Areas::findOne($ayuda->id_area);
            if ($area) {
                $area = $area->nombre;
            } else {
                $area = '';
            }

            $referente = Referentes::findOne($ayuda->id_referente);
            if ($referente) {
                $referente = $referente->apeynom;
            } else {
                $referente = '';
            }

            $ayudaExpediente = AyudasExpedientes::find()
                ->where(['id_ayuda'=>$ayuda->id_ayuda])
                ->one();
            if($ayudaExpediente){
                $expediente = Expedientes::findOne($ayudaExpediente->id_expediente);
                $expediente = $expediente->numero;  
            } else {
                $expediente = '';
            }                
            
            echo '
                <tr>
                    <td>'.$i.'</td>
                    <td>'.$beneficiario['apeynom'].'</td>
                    <td>'.$beneficiario['documento'].'</td>
                    <td>'.$tipoAyuda.'</td>
                    <td>'.$estado.'</td>
                    <td>'.$ayuda['monto'].'</td>
                    <td>'.$area.'</td>
                    <td>'.$referente.'</td>
                    <td>'.$ayuda['fecha_pago'].'</td>
                    <td>'.$ayuda['fecha_entrada'].'</td>
                    <td>'.$ayuda['fecha_nota'].'</td>
                    <td>'.$expediente.'</td>
                </tr>
            ';
        }

        echo '</table>';
    }

    public function actionExcel_autorizadas()
    {
        $ayudas = Ayudas::find()
            ->where(['id_estado' => 5])
            ->orderBy(['id_ayuda' => SORT_DESC])   
            ->all();

        $filename = 'Informe General de Ayudas-'.Date('YmdGis') . '.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=" . $filename);
        echo '
            <table border="1" width="100%">
                  <thead>
                      <tr>
                          <th></th>
                          <th>Apellido y Nombre</th>
                          <th>Documento</th>
                          <th>Tipo Ayuda</th>
                          <th>Estado</th>
                          <th>Monto</th>
                          <th>Area</th>
                          <th>Referente</th
                          <th>Fecha de Pago</th>
                          <th>Fecha de Entrada</th>
                          <th>Fecha de Nota</th>
                          <th>Nro Expediente</th>

                      </tr>
                  </thead>
        ';

        $i=0;

        foreach($ayudas as $ayuda) {
        $i++;

            /*BUSCO DATOS DEL Beneficiario*/
            $idBeneficiario=$ayuda->id_beneficiario;
            $beneficiario = Beneficiarios::find()
                ->where(['id_beneficiario'=>$idBeneficiario])
                ->one();

            $tipoAyuda = TiposAyudas::findOne($ayuda->id_tipo);
            if ($tipoAyuda) {
                $tipoAyuda = $tipoAyuda->nombre;
            } else {
                $tipoAyuda = '';
            } 

            $estado = Estados::findOne($ayuda->id_estado);
            if ($estado) {
                $estado = $estado->nombre;
            } else {
                $estado= '';
            }

            $area = Areas::findOne($ayuda->id_area);
            if ($area) {
                $area = $area->nombre;
            } else {
                $area = '';
            }

            $referente = Referentes::findOne($ayuda->id_referente);
            if ($referente) {
                $referente = $referente->apeynom;
            } else {
                $referente = '';
            }

            $ayudaExpediente = AyudasExpedientes::find()
                ->where(['id_ayuda'=>$ayuda->id_ayuda])
                ->one();
            if($ayudaExpediente){
                $expediente = Expedientes::findOne($ayudaExpediente->id_expediente);
                $expediente = $expediente->numero;  
            } else {
                $expediente = '';
            }                

            echo '
                <tr>
                    <td>'.$i.'</td>
                    <td>'.$beneficiario['apeynom'].'</td>
                    <td>'.$beneficiario['documento'].'</td>
                    <td>'.$tipoAyuda.'</td>
                    <td>'.$estado.'</td>
                    <td>'.$ayuda['monto'].'</td>
                    <td>'.$area.'</td>
                    <td>'.$referente.'</td>
                    <td>'.$ayuda['fecha_pago'].'</td>
                    <td>'.$ayuda['fecha_entrada'].'</td>
                    <td>'.$ayuda['fecha_nota'].'</td>
                    <td>'.$expediente.'</td>
                </tr>
            ';
        }

    echo '</table>';
    }

    public function actionExcel_pagadas()
    {

        $ayudas = Ayudas::find()
            ->where(['id_estado' => 6])
            ->orderBy(['id_ayuda'=>SORT_DESC])   
            ->all();

        $filename = 'Informe General de Ayudas-'.Date('YmdGis').'.xls';
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=".$filename);
        echo '
            <table border="1" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th>Apellido y Nombre</th>
                        <th>Documento</th>
                        <th>Tipo Ayuda</th>
                        <th>Estado</th>
                        <th>Monto</th>
                        <th>Area</th>
                        <th>Referente</th
                        <th>Fecha de Pago</th>
                        <th>Fecha de Entrada</th>
                        <th>Fecha de Nota</th>
                        <th>Nro Expediente</th>

                    </tr>
                </thead>
        ';

        $i=0;

        foreach($ayudas as $ayuda) {
            $i++;

            /*BUSCO DATOS DEL Beneficiario*/
            $idBeneficiario=$ayuda->id_beneficiario;

            $beneficiario = Beneficiarios::find()
                ->where(['id_beneficiario'=>$idBeneficiario])
                ->one();

            $tipoAyuda = TiposAyudas::findOne($ayuda->id_tipo);
            if ($tipoAyuda) {
                $tipoAyuda = $tipoAyuda->nombre;
            } else {
                $tipoAyuda = '';
            } 

            $estado = Estados::findOne($ayuda->id_estado);
            if ($estado) {
                $estado = $estado->nombre;
            } else {
                $estado= '';
            }

            $area = Areas::findOne($ayuda->id_area);
            if ($area) {
                $area = $area->nombre;
            } else {
                $area = '';
            }

            $referente = Referentes::findOne($ayuda->id_referente);
            if ($referente) {
                $referente = $referente->apeynom;
            } else {
                $referente = '';
            }

            $ayudaExpediente = AyudasExpedientes::find()
                ->where(['id_ayuda'=>$ayuda->id_ayuda])
                ->one();
            if($ayudaExpediente){
                $expediente = Expedientes::findOne($ayudaExpediente->id_expediente);
                $expediente = $expediente->numero;  
            } else {
                $expediente = '';
            }                
            
            echo '
                <tr>
                    <td>'.$i.'</td>
                    <td>'.$beneficiario['apeynom'].'</td>
                    <td>'.$beneficiario['documento'].'</td>
                    <td>'.$tipoAyuda.'</td>
                    <td>'.$estado.'</td>
                    <td>'.$ayuda['monto'].'</td>
                    <td>'.$area.'</td>
                    <td>'.$referente.'</td>
                    <td>'.$ayuda['fecha_pago'].'</td>
                    <td>'.$ayuda['fecha_entrada'].'</td>
                    <td>'.$ayuda['fecha_nota'].'</td>
                    <td>'.$expediente.'</td>
                </tr>
            ';
        }

    echo '</table>';
    }
}

