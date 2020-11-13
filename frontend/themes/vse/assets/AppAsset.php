<?php 

namespace frontend\themes\vse\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
	public function init()
    {
        parent::init();
        $this->publishOptions['forceCopy'] = true;
    }
    
    public $baseUrl = '@app/themes/vse';
    public $sourcePath = '@app/themes/vse';
    public $css = [
        'css/main.min.css',
      	/*'css/style.min.css',
      	'css/order.min.css',
      	'css/profile.min.css',
      	'css/popup.min.css',
      	'css/message.min.css',*/
      	'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,500;0,600;0,800;0,900;1,500&display=swap',
      	//icons
      	'https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css',
      	'fonts/typicons.min.css',
      	'fonts/fontawesome-all.min.css',
      	'fonts/typicons.min.css',
      	'fonts/font-awesome.min.css',
      	'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
    ];
    public $js = [
        'js/mask/inputmask.binding.js',
        'js/mask/inputmask.js',
        'js/mask/jquery.inputmask.js',
        /*'js/script.js',
        'js/popup.js',
        'js/message.js',
        'js/order.js',*/
        'js/main.js'

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}