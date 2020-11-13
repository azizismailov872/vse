<?php 

namespace backend\themes\gentella\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class BootstrapAsset extends AssetBundle
{
    public function init()
    {
        parent::init();
        $this->publishOptions['forceCopy'] = true;
    }
    
    public $baseUrl = '@app/themes/gentella';
    public $sourcePath = '@app/themes/gentella';
    public $css = [
  	     'vendors/bootstrap/dist/css/bootstrap.min.css',
         'vendors/font-awesome/css/font-awesome.min.css',
         'https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css',
    ];
    public $js = [
	    'vendors/jquery/dist/jquery.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jquery.pjax/2.0.1/jquery.pjax.min.js',
        'vendors/bootstrap/dist/js/bootstrap.bundle.min.js',
        'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
    ];
}