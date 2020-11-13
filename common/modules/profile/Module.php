<?php

namespace common\modules\profile;

/**
 * profile module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\profile\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        if(\Yii::$app->id == 'app-frontend')
        {   
            if(isset(\Yii::$app->params['defaultTheme']))
            {
                $this->layoutPath = \Yii::getAlias(\Yii::$app->params['defaultThemeLayout']);
            }
        }
        else
        {
            $this->layoutPath = \Yii::getAlias('@backend_layouts');
        }
        // custom initialization code goes here
    }
}
