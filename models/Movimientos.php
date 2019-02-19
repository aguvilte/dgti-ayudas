<?php
/**
 * Descripción de la clase:
 *      Movimientos es el modelo para la tabla "movimientos"
 *
 * Últ. modificación:
 *      20/09/2018
 */

namespace app\models;

use Yii;

/**
 * This is the model class for table "movimientos".
 *
 * @property int $id_movimiento
 * @property int $id_tipo_movimiento
 * @property string $descripcion
 * @property int $id_usuario
 * @property string $fecha
 * @property string $hora
 */
class Movimientos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'movimientos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo_movimiento', 'descripcion', 'id_dato_modificado', 'id_usuario', 'fecha', 'hora'], 'required'],
            [['id_tipo_movimiento', 'id_dato_modificado', 'id_usuario'], 'integer'],
            [['fecha', 'hora'], 'safe'],
            [['descripcion'], 'string', 'max' => 40],

            [['id_tipo_movimiento'], 'exist', 'skipOnError' => true, 'targetClass' => TiposMovimientos::className(), 'targetAttribute' => ['id_tipo_movimiento' => 'id_tipo_movimiento']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_movimiento' => 'Id Movimiento',
            'id_tipo_movimiento' => 'Tipo de movimiento',
            'descripcion' => 'Descripción',
            'id_dato_modificado' => 'Archivo modificado',
            'id_usuario' => 'Usuario',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
        ];
    }

    public function getTiposMovimientos()
    {
        return $this->hasOne(TiposMovimientos::className(), ['id_tipo_movimiento' => 'id_tipo_movimiento']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'id_usuario']);
    }
}
