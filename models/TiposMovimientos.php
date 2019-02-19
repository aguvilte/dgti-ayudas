<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_movimientos".
 *
 * @property int $id_tipo_movimiento
 * @property string $nombre
 */
class TiposMovimientos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos_movimientos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_movimiento' => 'Id Tipo Movimiento',
            'nombre' => 'Nombre',
        ];
    }
}
