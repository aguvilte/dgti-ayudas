<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permisos".
 *
 * @property integer $id_permiso
 * @property string $nombre
 * @property string $descripcion
 * @property integer $role
 */
class Permisos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'permisos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'descripcion', 'role'], 'required'],
            [['role'], 'integer'],
            [['nombre', 'descripcion'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_permiso' => 'Id Permiso',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'role' => 'Role',
        ];
    }
}
