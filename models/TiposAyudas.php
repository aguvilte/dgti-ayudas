<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_ayudas".
 *
 * @property integer $id_tipo
 * @property string $nombre
 */
class TiposAyudas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipos_ayudas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_tipo' => 'Id Tipo',
            'nombre' => 'Nombre',
        ];
    }
}
