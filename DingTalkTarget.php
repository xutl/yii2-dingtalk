<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\dingtalk;

use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\log\Target;

/**
 * DingTalkTarget sends selected log messages to the specified dingTalk.
 *
 * etc.:
 *
 * ```php
 * 'components' => [
 *     'log' => [
 *          'targets' => [
 *              [
 *                  'class' => 'xutl\dingtalk\DingTalkTarget',
 *                  'dingTalk' => 'dingTalk',
 *                  'levels' => ['error', 'warning'],
 *              ],
 *          ],
 *     ],
 * ],
 * ```
 *
 * In the above `dingTalk` is ID of the component that sends message and should be already configured.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DingTalkTarget extends Target
{
    /**
     * @var DingTalk|array|string the dingTalk object or the application component ID of the dingTalk object.
     * After the DingTalkTarget object is created, if you want to change this property, you should only assign it
     * with a dingTalk object.
     */
    public $dingTalk = 'dingTalk';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->dingTalk = Instance::ensure($this->dingTalk, 'xutl\dingtalk\DingTalk');
    }

    /**
     * Sends log messages to specified dingTalk.
     */
    public function export()
    {
        $messages = array_map([$this, 'formatMessage'], $this->messages);
        $body = wordwrap(implode("\n", $messages), 70);
        $this->dingTalk->sendText($body);
    }
}