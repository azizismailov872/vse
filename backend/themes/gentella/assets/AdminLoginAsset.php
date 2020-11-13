<?php 

namespace backend\themes\gentella\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminLoginAsset extends AssetBundle
{
    public function init()
    {
        parent::init();
        $this->publishOptions['forceCopy'] = true;
    }
    
    public $baseUrl = '@frontend/themes/vse';
    public $sourcePath = '@frontend/themes/vse';
    public $css = [
		'css/style.min.css',
        'css/login.min.css',
        'fonts/font-awesome.min.css',
        'fonts/typicons.min.css',
        'fonts/fontawesome-all.min.css',
        'fonts/typicons.min.css',
        'https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css',
    ];
    public $js = [
	    'js/script.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}