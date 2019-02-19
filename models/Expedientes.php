<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "expedientes".
 *
 * @property integer $id_expediente
 * @property string $numero
 * @property double $monto_total
 * @property integer $estado
 * @property string $fecha_alta
 * @property string $fecha_cierre
 */
class Expedientes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'expedientes';
    }

    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_expediente' => 'Id Expediente',
            'numero' => 'Numero',
            'monto_total' => 'Monto Total',
            'estado' => 'Estado',
            'fecha_alta' => 'Fecha Alta',
            'fecha_cierre' => 'Fecha Cierre',
        ];
    }
}
