<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuarios".
 *
 * @property integer $id_usuario
 * @property string $username
 * @property string $password
 * @property string $ultimo_acceso_fecha
 * @property integer $rol
 * @property integer $id_persona
 *
 *
 * @property Personas $idPersona
 */
class Usuarios extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_rol', 'id_persona'], 'integer'],
            [['username', 'password','ultimo_acceso_fecha'], 'string', 'max' => 45],
            [['authKey'], 'string', 'max' => 50],
            [['id_persona'], 'exist', 'skipOnError' => true, 'targetClass' => Personas::className(), 'targetAttribute' => ['id_persona' => 'id_persona']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id Usuario',
            'username' => 'Usuario',
            'password' => 'Contraseña',
            'authKey' => 'Auth Key',
            'ultimo_acceso_fecha' => 'Ultimo Acceso Fecha',
            'id_rol' => 'Rol',
            'id_persona' => 'Id Persona',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPersona()
    {
        return $this->hasOne(Personas::className(), ['id_persona' => 'id_persona']);
    }

    public function getAuthKey()
    {
      return $this->authKey;
    }

    public function getId()
    {
      return $this->id;
    }

    public function validateAuthKey($authKey)
    {
      return $this->authKey === $authKey;
    }

    public static function findIdentity($id)
    {
      return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
      throw new yii\base\NotSupportedException();

    }

    public static function findByUsername($username)
    {
      return self::findOne(['username'=>$username]);
    }

    public static function validatePassword($password)
    {
      return self::findOne(['password'=>$password]);
    }

    /*DEPENDIENDO EL TIPO DE ROL*/
    public static function isUserAdmin($id)
    {
       if (Usuarios::findOne(['id' => $id, 'id_rol' => 1])){
        return true;
       } else {

        return false;
       }

    }

    /*DEPENDIENDO EL LA SECCION*/
    public static function isBeneficiarios($id)
    {
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 2])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 1])){
         return true;
        }
       } else {
       return false;
       }
    }
    
    public static function isAyudas($id)
    {
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 2])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 2])){
         return true;
        }
       } else {
       return false;
       }
    }

    public static function isFechaPago($id)
    {
      //Verifico que el usuario tenga el rol correcto
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 2])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 3])){
         return true;
        } else {
          return false;
        }
       } else if (Usuarios::findOne(['id' => $id, 'id_rol' => 3])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 7])){
         return true;
        } else {
          return false;
        }
       } else {
       return false;
       }
    }

    public static function isFechaEntrada($id)
    {
      //Verifico que el usuario tenga el rol correcto
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 2])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 4])){
         return true;
        } else {
          return false;
        }
       } else if (Usuarios::findOne(['id' => $id, 'id_rol' => 3])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 8])){
         return true;
        } else {
          return false;
        }
       } else {
       return false;
       }
    }

    public static function isMovimientos($id)
    {
      //Verifico que el usuario tenga el rol correcto
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 2])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 5])){
         return true;
        } else {
          return false;
        }
       } else if (Usuarios::findOne(['id' => $id, 'id_rol' => 3])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 9])){
         return true;
        } else {
          return false;
        }
       } else {
       return false;
       }
    }


    public static function isPago($id)
    {
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 3])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 6])){
         return true;
        }
       } else {
       return false;
       }
    }

    public static function isDevoluciones($id)
    {
      //Verifico que el usuario tenga el rol correcto
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 2])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 2])){
         return true;
        } else {
          return false;
        }
       } else if (Usuarios::findOne(['id' => $id, 'id_rol' => 3])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 6])){
         return true;
        } else {
          return false;
        }
       } else {
       return false;
       }
    }

    public static function isListado($id)
    {
      //Verifico que el usuario tenga el rol correcto
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 2])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 10])){
         return true;
        } else {
          return false;
        }
       } else if (Usuarios::findOne(['id' => $id, 'id_rol' => 3])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 11])){
         return true;
        } else {
          return false;
        }
       } else {
       return false;
       }
    }

    public static function isExpedientes($id)
    {
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 3])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 12])){
         return true;
        }
       } else {
       return false;
       }
    }

    public static function isAreas($id)
    {
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 3])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 13])){
         return true;
        }
       } else {
       return false;
       }
    }

    public static function isReferentes($id)
    {
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 3])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 14])){
         return true;
        }
       } else {
       return false;
       }
    }

    public static function isTiposAyudas($id)
    {
      if (Usuarios::findOne(['id' => $id, 'id_rol' => 3])){
        if (UsuariosSecciones::findOne(['id_usuario' => $id, 'id_seccion' => 15])){
         return true;
        }
       } else {
       return false;
       }
    }



}
