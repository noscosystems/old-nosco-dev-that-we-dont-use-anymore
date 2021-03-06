<?php

/*
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $user_name
 * @property string $password
 * @property integer $active
 * @property string $user_name2
 * @property string $password2
 * @property string $url
 * @property integer $company

 */

namespace application\models\db;

use application\components\db\ActiveRecord;

class User extends ActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_name, password, active, user_name2, password2, url, company', 'required'),
			array('active, company', 'numerical', 'integerOnly'=>true),
			array('user_name, password', 'length', 'max'=>20),
			array('user_name2', 'length', 'max'=>70),
			array('password2, url', 'length', 'max'=>80),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_name, password, active, user_name2, password2, url, email ,company', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_name' => 'User Name',
			'password' => 'Password',
			'active' => 'Active',
			'user_name2' => 'User Name2',
			'password2' => 'Password2',
			'url' => 'Url',
			'company' => 'Company',
			'emal'=>'Email',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('user_name2',$this->user_name2,true);
		$criteria->compare('password2',$this->password2,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('company',$this->company);
		$criteria->compare('email',$this->email);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function verifyPassword($password)
	{
		if($password==$this->password)
			{return true;}
		else {
			return false;
		}
	}
	public function ipAllowed($ip)
	{

	return true;	
	}
}
