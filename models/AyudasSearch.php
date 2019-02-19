<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ayudas;

/**
 * AyudasSearch represents the model behind the search form about `app\models\Ayudas`.
 */
class AyudasSearch extends Ayudas
{
    /**
     * @inheritdoc
     */
    public $globalSearch;

    public function rules()
    {
        return [
            [['id_tipo', 'id_ayuda', 'id_estado', 'entrega_dni', 'entrega_cuil', 'id_persona'], 'integer'],
            [['asunto', 'monto', 'fecha_nota', 'fecha_entrada', 'fecha_pago', 'doc_adjunta', 'area', 'encargado', 'pdf_doc_adjunta', 'pdf_nota', 'pdf_gestor', 'pdf_domicilio', 'globalSearch'], 'safe'],
            [['id_persona'], 'number'],
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
        $query = Ayudas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>[
                'defaultOrder'=>['id_ayuda'=> SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('idBeneficiarios');

        // grid filtering conditions
        $query->andFilterWhere([
            'id_ayuda' => $this->id_ayuda,
            //'entrega_dni' => $this->entrega_dni,
            //'entrega_cuil' => $this->entrega_cuil,
            //'id_persona' => $this->id_persona,
            'id_tipo' => $this->id_tipo,
            'id_estado' => $this->id_estado,
            //'beneficiarios.documento' => $this->id_persona,

        ]);

        $query->andFilterWhere(['like', 'asunto', $this->asunto])
            ->andFilterWhere(['like', 'monto', $this->monto])
            //->andFilterWhere(['like', 'fecha_nota', $this->fecha_nota])
            //->andFilterWhere(['like', 'fecha_entrada', $this->fecha_entrada])
            //->andFilterWhere(['like', 'fecha_pago', $this->fecha_pago])
            ->andFilterWhere(['like', 'doc_adjunta', $this->doc_adjunta])
            ->andFilterWhere(['like', 'area', $this->area])
            ->andFilterWhere(['like', 'encargado', $this->encargado])
            ->andFilterWhere(['like', 'pdf_doc_adjunta', $this->pdf_doc_adjunta])
            ->andFilterWhere(['like', 'pdf_nota', $this->pdf_nota])
            ->andFilterWhere(['like', 'pdf_gestor', $this->pdf_gestor])
            ->andFilterWhere(['like', 'pdf_domicilio', $this->pdf_domicilio])
            ->andFilterWhere(['like', 'beneficiarios.documento', $this->id_persona]);

    $query->orFilterWhere(['like', 'beneficiarios.documento', $this->globalSearch]);

    if (!is_null($this->fecha_entrada) && 
        strpos($this->fecha_entrada, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->fecha_entrada);
            $query->andFilterWhere(['between', 'date(fecha_entrada)', $start_date, $end_date]);
        }

    if (!is_null($this->fecha_pago) && 
        strpos($this->fecha_pago, ' - ') !== false ) {
            list($start_date, $end_date) = explode(' - ', $this->fecha_pago);
            $query->andFilterWhere(['between', 'date(fecha_pago)', $start_date, $end_date]);
        }
        
    return $dataProvider;
    }
}
