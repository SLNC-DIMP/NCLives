<?php

/**
 * This is the model class for table "cdm_records".
 *
 * The followings are the available columns in table 'cdm_records':
 * @property integer $id
 * @property string $collection
 * @property string $pointer
 * @property string $Title
 * @property string $Creator
 * @property string $Item_Date
 * @property string $Time_Period
 * @property string $Subjects
 * @property string $Description
 * @property string $Rights
 * @property string $Characteristics
 * @property string $Formats
 * @property string $DCR_Collection
 * @property string $Digital_Collection
 * @property string $Format
 * @property string $Audience
 * @property string $Archival_Coll_Creator
 * @property string $Local
 * @property string $Type
 * @property string $Language
 * @property string $Themes
 * @property string $Url
 * @property string $Created
 * @property string $Modified
 */
class Cdm extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cdm the static model class
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
		return 'cdm_records';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('collection, Audience, Type, Language, Created, Modified', 'length', 'max'=>25),
			array('pointer', 'length', 'max'=>10),
			array('Title, Subjects, Characteristics, Themes, Url', 'length', 'max'=>500),
			array('Creator, Time_Period, Rights, Formats, DCR_Collection, Digital_Collection, Format, Archival_Coll_Creator, Local', 'length', 'max'=>255),
			array('Item_Date', 'length', 'max'=>50),
			array('Description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, collection, pointer, Title, Creator, Item_Date, Time_Period, Subjects, Description, Rights, Characteristics, Formats, DCR_Collection, Digital_Collection, Format, Audience, Archival_Coll_Creator, Local, Type, Language, Themes, Url, Created, Modified', 'safe', 'on'=>'search'),
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
			'collection' => 'Collection',
			'pointer' => 'Pointer',
			'Title' => 'Title',
			'Creator' => 'Creator',
			'Item_Date' => 'Item Date',
			'Time_Period' => 'Time Period',
			'Subjects' => 'Subjects',
			'Description' => 'Description',
			'Rights' => 'Rights',
			'Characteristics' => 'Characteristics',
			'Formats' => 'Formats',
			'DCR_Collection' => 'Dcr Collection',
			'Digital_Collection' => 'Digital Collection',
			'Format' => 'Format',
			'Audience' => 'Audience',
			'Archival_Coll_Creator' => 'Archival Coll Creator',
			'Local' => 'Local',
			'Type' => 'Type',
			'Language' => 'Language',
			'Themes' => 'Themes',
			'Url' => 'Url',
			'Created' => 'Created',
			'Modified' => 'Modified',
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
		$criteria->compare('collection',$this->collection,true);
		$criteria->compare('pointer',$this->pointer,true);
		$criteria->compare('Title',$this->Title,true);
		$criteria->compare('Creator',$this->Creator,true);
		$criteria->compare('Item_Date',$this->Item_Date,true);
		$criteria->compare('Time_Period',$this->Time_Period,true);
		$criteria->compare('Subjects',$this->Subjects,true);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('Rights',$this->Rights,true);
		$criteria->compare('Characteristics',$this->Characteristics,true);
		$criteria->compare('Formats',$this->Formats,true);
		$criteria->compare('DCR_Collection',$this->DCR_Collection,true);
		$criteria->compare('Digital_Collection',$this->Digital_Collection,true);
		$criteria->compare('Format',$this->Format,true);
		$criteria->compare('Audience',$this->Audience,true);
		$criteria->compare('Archival_Coll_Creator',$this->Archival_Coll_Creator,true);
		$criteria->compare('Local',$this->Local,true);
		$criteria->compare('Type',$this->Type,true);
		$criteria->compare('Language',$this->Language,true);
		$criteria->compare('Themes',$this->Themes,true);
		$criteria->compare('Url',$this->Url,true);
		$criteria->compare('Created',$this->Created,true);
		$criteria->compare('Modified',$this->Modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}