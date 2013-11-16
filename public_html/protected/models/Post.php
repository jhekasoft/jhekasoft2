<?php

/**
 * This is the model class for table "{{post}}".
 *
 * The followings are the available columns in table '{{post}}':
 * @property integer $author_id
 * @property integer $update_time
 * @property integer $create_time
 * @property string $tags
 * @property integer $status
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $content
 */
class Post extends CActiveRecord
{
    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_ARCHIVED = 3;
    
    private $oldTags;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title, content, status', 'required'),
			array('name, title', 'length', 'max'=>128),
            array('status', 'in', 'range' => array(1,2,3)),
            array('tags', 'match', 'pattern'=>'/^[\w\s,]+$/',
                'message'=>'Tags can only contain word characters.'),
            array('tags', 'normalizeTags'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('author_id, update_time, create_time, tags, status, id, name, title, content', 'safe', 'on'=>'search'),
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
            'author' => array(
                self::BELONGS_TO, 'User', 'author_id'
            ),
            'comments' => array(
                self::HAS_MANY, 'Comment', 'post_id',
                'condition' => 'comments.status='.Comment::STATUS_APPROVED,
                'order' => 'comments.create_time DESC'
            ),
            'commentCount' => array(
                self::STAT, 'Comment', 'post_id',
                'condition' => 'status='.Comment::STATUS_APPROVED
            ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'author_id' => 'Author',
			'update_time' => 'Update Time',
			'create_time' => 'Create Time',
			'tags' => 'Tags',
			'status' => 'Status',
			'id' => 'ID',
			'name' => 'Name',
			'title' => 'Title',
			'content' => 'Content',
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

		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('update_time',$this->update_time);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->create_time = $this->update_time = time();
                $this->author_id = Yii::app()->user->id;
            } else {
                $this->update_time = time();
            }
            return true;
        } else {
            return false;
        }
    }
    
    protected function afterSave()
    {
        parent::afterSave();
        Tag::model()->updateFrequency($this->oldTags, $this->tags);
    }

    protected function afterFind()
    {
        parent::afterFind();
        $this->oldTags = $this->tags;
    }

    public function normalizeTags($attribute,$params)
    {
        $this->tags = Tag::array2string(array_unique(Tag::string2array($this->tags)));
    }
    
    public function getUrl()
    {
        return Yii::app()->createUrl('post/view', array(
            'id' => $this->id,
            'title' => $this->title,
        ));
    }
}
