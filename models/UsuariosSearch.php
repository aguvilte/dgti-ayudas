<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuarios;

/**
 * UsuariosSearch represents the model behind the search form about `app\models\Usuarios`.
 */
class UsuariosSearch extends Usuarios
{
    /**
     * @inheritdoc
     */
    public $globalSearch;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['id_persona'], 'string', 'max' => 45],
            [['username', 'ultimo_acceso_fecha','globalSearch'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Usuarios::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>['id'=> SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('idPersona');

        $query->andFilterWhere(['like', 'usuarios.ultimo_acceso_fecha', $this->ultimo_acceso_fecha])
              ->andFilterWhere(['like', 'usuarios.username', $this->username])
              ->andFilterWhere(['like', 'personas.documento', $this->id_persona]);

        $query->orFilterWhere(['like', 'personas.documento', $this->globalSearch]);

        return $dataProvider;
    }
}
