<?php 

namespace backend\themes\gentella\assets;

use yii\web\AssetBundle;
use backend\themes\gentella\assets\BootstrapAsset;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public function init()
    {
        parent::init();
        $this->publishOptions['forceCopy'] = true;
    }
    
    public $baseUrl = '@app/themes/gentella';
    public $sourcePath = '@app/themes/gentella';
    public $css = [
        'vendors/bootstrap-daterangepicker/daterangepicker.css',
        'build/css/custom.min.css',
        'vendors/switchery/dist/switchery.min.css',
    ];
    public $js = [
        'js/admin.js',
	    'vendors/fastclick/lib/fastclick.js',
        'vendors/skycons/skycons.js',
        'build/js/custom.min.js',
        'vendors/switchery/dist/switchery.min.js',
        'js/mask/jquery.inputmask.js',
        'js/mask/inputmask.js',
        'js/mask/inputmask.binding.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'backend\themes\gentella\assets\BootstrapAsset',
    ];
}