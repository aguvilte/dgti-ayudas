<?php

namespace app\models;

use Yii;

class Expedientes extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'expedientes';
    }

    public function rules()
    {
        return [
            [['numero', 'monto_total', 'estado', 'fecha_alta'], 'required'],
            [['monto_total'], 'number'],
            [['estado'], 'integer'],
            [['fecha_alta', 'fecha_cierre'], 'safe'],
            [['numero'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id_expediente' => 'Id Expediente',
            'numero' => 'Número',
            'monto_total' => 'Monto Total',
            'estado' => 'Estado',
            'fecha_alta' => 'Fecha de alta',
            'fecha_cierre' => 'Fecha de cierre',
        ];
    }
}
