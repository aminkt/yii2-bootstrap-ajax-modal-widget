<?php
namespace ajaxModal;


use yii\base\Widget;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;

class AjaxModal extends Widget
{

    /**
     * @var array $modalOptions Bootstrap modal options.
     */
    public $modalOptions = [];
    /**
     * @var string $ajaxContainerId Container id
     */
    public $ajaxContainerId;

    /**
     * @var string $loadingMessage Loading message
     */
    public $loadingMessage = '   لطفا کمی صبر کنید ...';

    private $assetBundle;

    public function init()
    {
        parent::init();

        if(!$this->ajaxContainerId)
            $this->ajaxContainerId = $this->id;
        if(count($this->modalOptions)==0){
            $this->modalOptions = [
                'header'=>'<h4>Modal title</h4>',
                'id'=>'modal-'.$this->id,
                'size'=>Modal::SIZE_DEFAULT,
            ];
        }
        $this->assetBundle = Assets::register($this->view);

        $this->renderModalHeader();
    }

    public function run()
    {
        parent::run();
        $this->renderModalFooter();
        $this->renderJavaCodes();
    }

    /**
     * Render Modal header
     */
    private function renderModalHeader(){
        Modal::begin($this->modalOptions);
        echo Html::beginTag('div', ['class'=>'loading hidden']).PHP_EOL;
        echo Html::tag('img', '', ['src'=>$this->assetBundle->baseUrl."/loading-spinner-grey.gif"]).PHP_EOL;
        echo Html::tag('div', $this->loadingMessage, ['class'=>'loading-message']).PHP_EOL;
        echo Html::endTag('div');
        echo Html::beginTag('div', ['id'=>$this->ajaxContainerId]).PHP_EOL;
    }

    /**
     * Render Modal footer
     */
    private function renderModalFooter(){
        echo Html::endTag('div');
        Modal::end();
    }


    /**
     * Register js codes
     */
    private function renderJavaCodes(){
        $containerId = $this->ajaxContainerId;
        $js = <<<JS
        
function response(data, status, modal) {
    if(status == "success"){
        modal.find(".loading").addClass("hidden");   
        modal.find('#$containerId').html(data);
    }                    
    if(status == "error"){
        console.error("Error: "+ xhr.status + ": "+ xhr.statusText);
        modal.find(".loading").addClass("hidden");
        modal.find('#$containerId').text('خطا در بارگزاری اطلاعات!');
    }
}
$(".modal").on("show.bs.modal", function(e) {
var link = $(e.relatedTarget);
var modal = $(this);
var ajaxDisable = modal.data('ajax-disable')?true:false;
// console.log('data-ajax-disable:'+ajaxDisable);
if(!ajaxDisable){
    modal.show();
    modal.find(".loading").removeClass("hidden");
    $(link.data('#$containerId')).empty();
    var url = link.data('url');
    var get = link.data('get');
    var post = link.data('post');
    if(get){
        $.get(url, get , function(data, status){
            response(data, status, modal);
        });
    }else if(post){
        $.post(url, post , function(data, status){
            response(data, status, modal);
        });
    }
    
}
});
    
    // $('.modal').on('hide.bs.modal', function (e) {
    //     var modal = $(this);
    //     modal.data('ajax-disable', false);
    //     var parent = modal.find('#pay-status-parent-modal').val();
    //     if(parent){
    //         $(parent).data('ajax-disable', true);
    //         $(parent).modal('show');
    //     }
    // })
    
JS;
        \Yii::$app->getView()->registerJs($js);
    }
}