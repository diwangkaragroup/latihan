<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $Id
 * @property string $Product
 * @property string|null $Description
 * @property float $Price
 * @property int $Stock
 * @property int|null $StatId
 * @property string $Remark
 *
 * @property ProductStatus $stat
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Description'], 'string'],
            [['Price', 'Stock'], 'required'],
            [['Price'], 'number'],
            [['Stock', 'StatId'], 'integer'],
            [['Product', 'Remark'], 'string', 'max' => 100],
            [['StatId'], 'exist', 'skipOnError' => true, 'targetClass' => ProductStatus::className(), 'targetAttribute' => ['StatId' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'Product' => 'Product',
            'Description' => 'Description',
            'Price' => 'Price',
            'Stock' => 'Stock',
            'StatId' => 'Stat ID',
            'Remark' => 'Remark',
        ];
    }

    /**
     * Gets query for [[Stat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStat()
    {
        return $this->hasOne(ProductStatus::className(), ['Id' => 'StatId']);
    }
}
