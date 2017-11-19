How to install this module:

Step1: Add flowing line to require part of `composer.json` :
```
"aminkt/yii2-bootstrap-ajax-modal-widget": "*",
```

And after that run bellow command in your composer :
```
Composer update aminkt/yii2-bootstrap-ajax-modal-widget
```

Step2: Add flowing lines in your application admin config in module part:

```
'userAccounting' => [
    'class' => \aminkt\userAccounting\UserAccounting::className(),
    'controllerNamespace' => \aminkt\userAccounting\UserAccounting::ADMIN_CONTROLLER_NAMESPACE,
    'transactionModel' => '\your\transaction-model\class',
    'userModel' => '\your\user-model\User',
],
```

Step3: Add flowing lines in your application view file:

```
echo \aminkt\bootstrap\ajaxModal\AjaxModal::widget([
    'id'=>'bot-details-content',
    'modalOptions'=>[
        'header'=>'<h4>نمایش اطلاعات ربات</h4>',
        'id'=>'bot-details',
        'size'=>'modal-lg',
    ]
]);
```