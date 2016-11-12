<?php
namespace mirkhamidov\alert;

use mirkhamidov\alert\assets\AlertAssets;
use Yii;
use yii\web\View;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * Yii::$app->session->setFlash('error', 'This is the message');
 * Yii::$app->session->setFlash('success', 'This is the message');
 * Yii::$app->session->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * Yii::$app->session->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class Alert extends \yii\bootstrap\Widget
{
    /**
     * @var array the alert types configuration for the flash messages.
     * This array is setup as $key => $value, where:
     * - $key is the name of the session flash variable
     * - $value is the bootstrap alert type (i.e. danger, success, info, warning)
     */
    public $alertTypes = [
        'error'   => 'alert-danger',
        'danger'  => 'alert-danger',
        'success' => 'alert-success',
        'info'    => 'alert-info',
        'warning' => 'alert-warning'
    ];
    /**
     * @var array the options for rendering the close button tag.
     */
    public $closeButton = [];

    /**
     * @var null|int milliseconds for auto hide alert message, if null - auto-hide disabled
     */
    public $delay = null;


    public function init()
    {
        parent::init();

        $session = Yii::$app->session;
        $flashes = $session->getAllFlashes();
        $appendCss = isset($this->options['class']) ? ' ' . $this->options['class'] : '';


        foreach ($flashes as $type => $data) {
            if (isset($this->alertTypes[$type])) {
                $data = (array) $data;
                foreach ($data as $i => $message) {
                    /* initialize css class for each alert box */
                    $this->options['class'] = $this->alertTypes[$type] . $appendCss;

                    /* assign unique id to each alert box */
                    $this->options['id'] = $this->getId() . '-' . $type . '-' . $i;

                    /* initialize auto-hide functionality if it enabled */
                    $this->initAutoHide();

                    echo \yii\bootstrap\Alert::widget([
                        'body' => $message,
                        'closeButton' => $this->closeButton,
                        'options' => $this->options,
                    ]);
                }

                $session->removeFlash($type);
            }
        }
    }

    /**
     * Check, if alert initialized with delay option
     * @return bool
     */
    public function getIsDelayed()
    {
        return (!empty($this->delay) && is_int($this->delay));
    }

    /**
     * Initialize javascript function for autoHide
     */
    protected function initAutoHide()
    {
        if ($this->getIsDelayed() === false) {
            return null;
        }

        /** @var \yii\web\View $view */
        $view = $this->getView();

        $view->registerJs($this->makeJs(), View::POS_READY);

        AlertAssets::register($view);
    }

    private function makeJs()
    {
        $id = 'timeout_' . str_replace('-', '_', $this->options['id']);
        $selector = $this->options['id'];
        $delay = $this->delay;
        return <<<EOF
(function () {
    'use strict';
    
    // set timer
    var {$id} = setTimeout(function () {
        $('#{$selector}').slideUp(200);
        clearTimeout({$id});
    }, {$delay});
    
    // set timer-close
    $('.close', '#{$selector}').attr("timer", {$id});
    $('.close', '#{$selector}').attr("onclick", "closeTimeout(this);");
})();
EOF;
    }
}