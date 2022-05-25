<?php

namespace backend\models\nomenclators;

use Yii;
use backend\models\BaseModel;
use yii\helpers\StringHelper;
use common\models\GlobalFunctions;
use yii\helpers\Html;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $description
 * @property int $type
 * @property string|null $link
 * @property int $status
 * @property string $created_at
 * @property string $updated_at

 */
class News extends BaseModel
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'image', 'link'], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('backend', 'Nombre'),
            'image' => Yii::t('backend', 'Imagen'),
            'description' => Yii::t('backend', 'Descripción'),
            'type' => Yii::t('backend', 'Tipo'),
            'link' => Yii::t('backend', 'Vínculo'),
            'status' => Yii::t('backend', 'Estado'),
            'created_at' => Yii::t('backend', 'Fecha de creación'),
            'updated_at' => Yii::t('backend', 'Fecha de actualización'),
        ];
    }

    /** :::::::::::: START > Abstract Methods and Overrides ::::::::::::*/

    /**
    * @return string The base name for current model, it must be implemented on each child
    */
    public function getBaseName()
    {
        return StringHelper::basename(get_class($this));
    }

    /**
    * @return string base route to model links, default to '/'
    */
    public function getBaseLink()
    {
        return "/news";
    }

    /**
    * Returns a link that represents current object model
    * @return string
    *
    */
    public function getIDLinkForThisModel()
    {
        $id = $this->getRepresentativeAttrID();
        if (isset($this->$id)) {
            $name = $this->getRepresentativeAttrName();
            return Html::a($this->$name, [$this->getBaseLink() . "/view", 'id' => $this->getId()]);
        } else {
            return GlobalFunctions::getNoValueSpan();
        }
    }

    /** :::::::::::: END > Abstract Methods and Overrides ::::::::::::*/

    /**
     * @return boolean true if exists stored image
     */
    public function hasImage()
    {
        return (isset($this->image) && !empty($this->image) && $this->image !== '');
    }

    /**
     * fetch stored image file name with complete path
     * @return string
     */
    public function getImageFile()
    {
        if(!file_exists("uploads/news/") || !is_dir("uploads/news/")){
            try{
                FileHelper::createDirectory("uploads/news/", 0777);
            }catch (\Exception $exception){
                Yii::info("Error handling Carrousel folder resources");
            }

        }
        if(isset($this->image) && !empty($this->image) && $this->image !== '')
            return "uploads/news/{$this->image}";
        else
            return null;

    }

    /**
     * fetch stored image url
     * @return string
     */
    public function getImageUrl()
    {
        if($this->hasImage()){
            return "uploads/news/{$this->image}";
        }else{
            return GlobalFunctions::getNoImageDefaultUrl();
        }

    }

    /**
     * Process upload of image
     * @return mixed the uploaded image instance
     */
    public function uploadImage() {
        // get the uploaded file instance. for multiple file uploads
        // the following data will return an array (you may need to use
        // getInstances method)
        $image = UploadedFile::getInstance($this, 'image');

        // if no logo was uploaded abort the upload
        if (empty($image)) {
            return false;
        }

        // store the source file name
        // $this->filename = $image->name;
        $explode= explode('.',$image->name);
        $ext = end($explode);
        $hash_name = GlobalFunctions::generateRandomString(10);
        $this->image = "{$hash_name}.{$ext}";

        // the uploaded logo instance
        return $image;
    }

    /**
     * Process deletion of logo
     * @return boolean the status of deletion
     */
    public function deleteImage() {
        $file = $this->getImageFile();

        // check if file exists on server
        if (empty($file) || !file_exists($file)) {
            return false;
        }

        // check if uploaded file can be deleted on server
        try{
            if (!unlink($file)) {
                return false;
            }
        }catch (\Exception $exception){
            Yii::info("Error deleting image on news: " . $file);
            Yii::info($exception->getMessage());
            return false;
        }

        // if deletion successful, reset your file attributes
        $this->image = null;

        return true;
    }

    /**
     * @return string
     */
    public function getPreview()
    {
        if(isset($this->image) && !empty($this->image))
        {
            $path_url = GlobalFunctions::getFileUrlByNamePath('news',$this->image);
        }
        else
        {
            $path_url = '/'.GlobalFunctions::getNoImageDefaultUrl();
        }

        return $path_url;
    }
}
