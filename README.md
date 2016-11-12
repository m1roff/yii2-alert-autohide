yii2-alert-autohide 
=
Extended [core widget](https://github.com/yiisoft/yii2-app-advanced/blob/master/common/widgets/Alert.php) with autohide functionality.


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
composer require mirkhamidov/yii2-alert-autohide "*"
```

or add

```
"mirkhamidov/yii2-alert-autohide": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

without auto-hide:
```php
<?= \mirkhamidov\alert\Alert::widget() ?>

```

with auto-hide after `5000ms`:
```php
<?= \mirkhamidov\alert\Alert::widget(['delay' => 5000]) ?>

```