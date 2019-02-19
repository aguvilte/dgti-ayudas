<?php    
namespace app\components;
use Yii;
use app\models\Movimientos;

class RegistroMovimientos
{
    public function init(){
        parent::init();
    }

    public function registrarMovimiento($idTipo, $descripcion, $idDato) {
        $modelMovimientos = new Movimientos();
        $modelMovimientos->id_tipo_movimiento = $idTipo;
        $modelMovimientos->descripcion = $descripcion;
        $modelMovimientos->id_dato_modificado = $idDato;
        $modelMovimientos->id_usuario = Yii::$app->user->identity->id;
        $modelMovimientos->fecha = date('Y-m-d');
        $modelMovimientos->hora = date("H:i:s");
        $modelMovimientos->save();
    }
}