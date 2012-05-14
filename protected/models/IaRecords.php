<?php

/**
 * This is the model class for table "ia_records".
 *
 * The followings are the available columns in table 'ia_records':
 * @property integer $id
 * @property string $identifier
 * @property string $base_id
 * @property integer $fulltext_available
 * @property string $url_link
 * @property string $datestamp
 * @property string $Title
 * @property string $Volume
 * @property string $Creator
 * @property string $Subject
 * @property string $Publisher
 * @property string $Pub_Date
 * @property string $Language
 * @property string $Sponsor
 * @property string $Contributor
 * @property string $MediaType
 * @property string $Updatedate
 */
class IaRecords extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return IaRecords the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ia_records';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fulltext_available', 'required'),
			array('fulltext_available', 'numerical', 'integerOnly'=>true),
			array('identifier, datestamp, Updatedate', 'length', 'max'=>50),
			array('base_id, url_link, Title, Volume, Creator, Subject, Publisher, Pub_Date, Language, Sponsor, Contributor', 'length', 'max'=>255),
			array('MediaType', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, identifier, base_id, fulltext_available, url_link, datestamp, Title, Volume, Creator, Subject, Publisher, Pub_Date, Language, Sponsor, Contributor, MediaType, Updatedate', 'safe', 'on'=>'search'),
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
			'identifier' => 'Identifier',
			'base_id' => 'Base',
			'fulltext_available' => 'Fulltext Available',
			'url_link' => 'Url Link',
			'datestamp' => 'Datestamp',
			'Title' => 'Title',
			'Volume' => 'Volume',
			'Creator' => 'Creator',
			'Subject' => 'Subject',
			'Publisher' => 'Publisher',
			'Pub_Date' => 'Pub Date',
			'Language' => 'Language',
			'Sponsor' => 'Sponsor',
			'Contributor' => 'Contributor',
			'MediaType' => 'Media Type',
			'Updatedate' => 'Updatedate',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('identifier',$this->identifier,true);
		$criteria->compare('base_id',$this->base_id,true);
		$criteria->compare('fulltext_available',$this->fulltext_available);
		$criteria->compare('url_link',$this->url_link,true);
		$criteria->compare('datestamp',$this->datestamp,true);
		$criteria->compare('Title',$this->Title,true);
		$criteria->compare('Volume',$this->Volume,true);
		$criteria->compare('Creator',$this->Creator,true);
		$criteria->compare('Subject',$this->Subject,true);
		$criteria->compare('Publisher',$this->Publisher,true);
		$criteria->compare('Pub_Date',$this->Pub_Date,true);
		$criteria->compare('Language',$this->Language,true);
		$criteria->compare('Sponsor',$this->Sponsor,true);
		$criteria->compare('Contributor',$this->Contributor,true);
		$criteria->compare('MediaType',$this->MediaType,true);
		$criteria->compare('Updatedate',$this->Updatedate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}