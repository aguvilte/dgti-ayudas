<?php
/**
 * Descripción de la clase:
 *      MovimientosSearch representa el modelo detrás del formulario
 *      de búsqueda del modelo Movimientos
 *
 * Últ. modificación:
 *      20/09/2018
 */

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Movimientos;

/**
 * MovimientosSearch represents the model behind the search form of `app\models\Movimientos`.
 */
class MovimientosSearch extends Movimientos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_movimiento', 'id_tipo_movimiento', 'id_usuario', 'id_dato_modificado'], 'integer'],
            [['descripcion', 'fecha', 'hora'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Movimientos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>['id_movimiento'=> SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_movimiento' => $this->id_movimiento,
            'id_tipo_movimiento' => $this->id_tipo_movimiento,
            'id_usuario' => $this->id_usuario,
            'id_dato_modificado' => $this->id_dato_modificado,
            // 'fecha' => $this->fecha,
            'hora' => $this->hora,
        ]);

        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        if (!is_null($this->fecha) && 
        strpos($this->fecha, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->fecha);
            $query->andFilterWhere(['between', 'date(fecha)', $start_date, $end_date]);
        }

        return $dataProvider;
    }
}
