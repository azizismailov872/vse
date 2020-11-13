<?php

namespace common\modules\content\models;

use Yii;
use common\modules\content\models\MenuCategory;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "menu".
 *
 * @property int $id
 * @property string $title
 * @property int|null $parent_id
 * @property string|null $icon
 * @property string $url
 * @property int $category_id
 * @property int $status
 *
 * @property MenuCategory $category
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'url', 'category_id', 'status'], 'required'],
            [['parent_id', 'category_id', 'status'], 'integer'],
            [['parent_id'],'default','value' => 0],
            [['title', 'icon', 'url'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'parent_id' => 'Родитель',
            'icon' => 'Иконка',
            'url' => 'Ссылка',
            'category_id' => 'Категория',
            'status' => 'Статус',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(MenuCategory::className(), ['id' => 'category_id']);
    }


    //Получение списка категорий меню
    public static function getCategoriesList()
    {   
        $categoriesList = MenuCategory::find()->asArray()->all();

        return ArrayHelper::map($categoriesList,'id','title');
    }


    //Меню для Панели администратора
    public static function getAdminMenuList($parent = 0)
    {   
        $category = MenuCategory::find()->where(['title' => 'admin-menu'])->one();

        $menuList = self::find()->where(['category_id' => $category])->asArray()->all();

        $result = [];

        foreach($menuList as $item)
        {
            if($item['parent_id'] == $parent)
            {
                $result[] = [
                    'label' => $item['title'],
                    'url' => ['/'.$item['url']],
                    'template' => '<a href="{url}" class="nav-link"><i class="'.$item['icon'].'"></i>{label}</a>',
                    'items' => self::getAdminMenuList($item['id']),
                ];
            }

            
        }
        return $result;
    }


    //Имя родительского меню
    public static function getParentMenuName($parent_id)
    {
        $menu = self::find()->where(['id' => $parent_id])->one();

        return $menu->title;
    }


    //Получение списка меню
    public static function getMenuList()
    {
        return ArrayHelper::map(self::find()->asArray()->all(),'id','title');
    }

    public static function getSidebarMenuList()
    {
        $category = MenuCategory::find()->where(['title' => 'sidebar'])->one();

        $menuList = self::find()->where(['category_id' => $category->id])->asArray()->all();

        $result = [];

        foreach($menuList as $item)
        {
            $result[] = [
                'title' => $item['title'],
                'icon' => $item['icon'],
                'url' => $item['url'],
            ];
        }

        return $result;
    }

}
