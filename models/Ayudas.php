<?php

namespace app\models;

use Yii;

class Ayudas extends \yii\db\ActiveRecord
{
    public $file;
    public $file1;
    public $file2;
    public $file3;

    public static function tableName()
    {
        return 'ayudas';
    }

    public function rules()
    {
        return [
            [['id_estado', 'id_beneficiario', 'id_tipo', 'id_area', 'id_referente'], 'integer'],
            [['fecha_entrada', 'id_beneficiario', 'id_tipo', 'monto', 'id_estado'], 'required'],
            [['fecha_nota', 'fecha_entrada', 'fecha_pago'], 'safe'],
            [['monto'], 'string', 'max' => 45],
            [['asunto'], 'string', 'max' => 100],
            [['file','file1','file2','file3'],'file'],
            [['id_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => TiposAyudas::className(), 'targetAttribute' => ['id_tipo' => 'id_tipo']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['id_estado' => 'id_estado']],
            [['id_beneficiario'], 'exist', 'skipOnError' => true, 'targetClass' => Beneficiarios::className(), 'targetAttribute' => ['id_beneficiario' => 'id_beneficiario']],
            [['id_area'], 'exist', 'skipOnError' => true, 'targetClass' => Areas::className(), 'targetAttribute' => ['id_area' => 'id_area']],
            [['id_referente'], 'exist', 'skipOnError' => true, 'targetClass' => Referentes::className(), 'targetAttribute' => ['id_referente' => 'id_referente']],
            [['doc_adjunta', 'pdf_doc_adjunta', 'pdf_nota', 'pdf_gestor', 'pdf_domicilio'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_ayuda' => 'Id Ayuda',
            'id_tipo' => 'Tipo de ayuda',
            'id_estado' => 'Estado del trámite',
            'asunto' => 'Asunto',
            'monto' => 'Monto',
            'fecha_nota' => 'Fecha de nota',
            'fecha_entrada' => 'Fecha de entrada',
            'fecha_pago' => 'Fecha de pago',
            'doc_adjunta' => 'Documentación adjunta',
            'id_area' => 'Área',
            'id_referente' => 'Encargado del área',
            'file' => 'PDF de documentación adjunta',
            'file1' => 'PDF de gestor',
            'file2' => 'PDF de nota',
            'file3' => 'PDF de domicilio',
            'id_beneficiario' => 'Id Persona',
        ];
    }

    public function getEstados()
    {
        return $this->hasOne(Estados::className(), ['id_estado' => 'id_estado']);
    }

    public function getTiposAyudas()
    {
        return $this->hasOne(TiposAyudas::className(), ['id_tipo' => 'id_tipo']);
    }

    public function getIdBeneficiarios()
    {
        return $this->hasOne(Beneficiarios::className(), ['id_beneficiario' => 'id_beneficiario']);
    }

    public function getAreas()
    {
        return $this->hasOne(Areas::className(), ['id_area' => 'id_area']);
    }

    public function getReferentes()
    {
        return $this->hasOne(Referentes::className(), ['id_referente' => 'id_referente']);
    }
}
