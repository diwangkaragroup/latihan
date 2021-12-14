<?php

namespace common\models;

use Yii;

class Member extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['TypeId', 'Billing'], 'required'],
            [['TypeId', 'StatId', 'Referral', 'Point','TrxCount'], 'integer'],
            [['JoinDate'], 'safe'],
            [['Balance', 'Billing','TrxOmzet'], 'number'],
            [['MemberId','RefCode','Referer'], 'string', 'max' => 18],
            [['PIN'], 'string', 'max' => 6],
            [['Remark'], 'string', 'max' => 160],
            [['MemberId'], 'unique'],
            [['TypeId'], 'exist', 'skipOnError' => true, 'targetClass' => MemberType::className(), 'targetAttribute' => ['TypeId' => 'Id']],
            [['StatId'], 'exist', 'skipOnError' => true, 'targetClass' => MemberStatus::className(), 'targetAttribute' => ['StatId' => 'Id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'MemberId' => 'Member ID',
            'TypeId' => 'Type ID',
            'StatId' => 'Stat ID',
            'JoinDate' => 'Join Date',
            'Referral' => 'Referral',
            'Point' => 'Point',
            'Balance' => 'Balance',
            'Billing' => 'Billing',
            'Remark' => 'Remark',
        ];
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(MemberType::className(), ['Id' => 'TypeId']);
    }

    /**
     * Gets query for [[Stat]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(MemberStatus::className(), ['Id' => 'StatId']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['MemberId' => 'MemberId']);
    }

     public function getData()
    {
        return $this->hasOne(MemberData::className(), ['MemberId' => 'MemberId']);
    }

    public function getAddress()
    {
        return $this->hasMany(MemberAddress::className(), ['MemberId' => 'MemberId']);
    }

    public function genMemberId()
    {
        $prefix=Yii::$app->params['siteID'];
        
        $max = $this::find()->select('max(MemberId)')->andFilterWhere(['like','MemberId',$prefix])->scalar(); 
                
        if ($max != ''){
            
            $last=substr($max,strlen($prefix),8) + 1;
            if($last<10){
                $id=$prefix.'000000'.$last;}
            elseif($last<100){
                $id=$prefix.'00000'.$last;}
            elseif($last<1000){
                $id=$prefix.'0000'.$last;}
            elseif($last<10000){
                $id=$prefix.'000'.$last;}
            elseif($last<100000){
                $id=$prefix.'00'.$last;}
            elseif($last<1000000){
                $id=$prefix.'0'.$last;}
            elseif($last<10000000){
                $id=$prefix.$last;}
        }
        else{
            $id=$prefix.'0000001';
        }
        
        return $this->MemberId=$id;
    }

    function showBadgeLevel(){
        
        switch($this->TypeId){
            
            case 1:
                $class='<span class="badge badge-danger"><i class="fa fa-user-secret"></i> '.$this->type->Type.' </span>';
                break;
            case 2:
                $class='<span class="badge badge-danger"><i class="fa fa-user-ninja"></i> '.$this->type->Type.' </span>';
                break;
            case 3:
                $class='<span class="badge badge-primary"><i class="fa fa-user-tie"></i> '.$this->type->Type.' </span>';
                break;
            case 4:
                $class='<span class="badge badge-success"><i class="fa fa-user-tag"></i> '.$this->type->Type.' </span>';
                break;
            case 5:
                $class='<span class="badge badge-info"><i class="fa fa-building"></i> '.$this->type->Type.' </span>';
                break;
            case 6:
                $class='<span class="badge badge-warning"><i class="fa fa-store"></i> '.$this->type->Type.' </span>';
                break;
            case 7:
                $class='<span class="badge badge-secondary"><i class="fa fa-shopping-basket"></i> '.$this->type->Type.' </span>';
                break;
            
        }
        
        return $class;
    }
}
