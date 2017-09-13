<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace xutl\dingtalk;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Exception;

/**
 * Class DingTalk
 * @package xutl\dingtalk
 */
class DingTalk extends Component
{
    /**
     * @var string 访问令牌
     */
    public $accessToken;

    /**
     * 机器人路径
     * @var string
     */
    public $baseUrl = 'https://oapi.dingtalk.com';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty ($this->accessToken)) {
            throw new InvalidConfigException ('The "accessToken" property must be set.');
        }
    }

    /**
     * 整体跳转ActionCard类型
     * @param string $title
     * @param string $content
     * @param string $singleURL
     * @param int $hideAvatar
     * @param int $btnOrientation
     * @param string $singleTitle
     * @return array
     */
    public function sendActionCard($title, $content, $singleURL, $hideAvatar = 0, $btnOrientation = 0, $singleTitle = '阅读原文')
    {
        $request = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $content,
                'hideAvatar' => $hideAvatar,
                'btnOrientation' => $btnOrientation,
                'singleTitle' => $singleTitle,
                'singleURL' => $singleURL
            ],
        ];
        return $this->send($request);
    }

    /**
     * 发送MarkDown 消息
     * @param string $title
     * @param string $content
     * @param array $atMobiles
     * @param bool $isAtAll
     * @return array
     */
    public function sendMarkdown($title, $content, array $atMobiles = [], $isAtAll = false)
    {
        $request = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $title,
                'text' => $content,
            ],
            'at' => [
                'isAtAll' => $isAtAll
            ],
        ];
        if ($atMobiles) {
            $request['at']['atMobiles'] = $atMobiles;
        }
        return $this->send($request);
    }


    /**
     * 发送链接
     * @param string $title
     * @param string $text
     * @param string $picUrl
     * @param string $messageUrl
     * @return array
     */
    public function sendLink($title, $text, $picUrl = '', $messageUrl)
    {
        $request = [
            'msgtype' => 'link',
            'link' => [
                'title' => $title,
                'text' => $text,
                'picUrl' => $picUrl,
                'messageUrl' => $messageUrl
            ],
        ];
        return $this->send($request);
    }

    /**
     * 发送文本消息
     * @param string $content
     * @param array $atMobiles
     * @param bool $isAtAll
     * @return array
     */
    public function sendText($content, array $atMobiles = [], $isAtAll = false)
    {
        $request = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content,
            ],
            'at' => [
                'isAtAll' => $isAtAll
            ],
        ];
        if ($atMobiles) {
            $request['at']['atMobiles'] = $atMobiles;
        }
        return $this->send($request);
    }

    /**
     * 发送请求
     * @param $request
     * @return array
     * @throws Exception
     */
    public function send($request)
    {
        $response = $this->getHttpClient()->createRequest()
            ->setUrl(['robot/send', 'access_token' => $this->accessToken])
            ->setMethod('POST')
            ->setData($request)
            ->send();
        if (!$response->isOk) {
            throw new Exception('Request fail. response: ' . $response->content, $response->statusCode);
        }
        return $response->data;
    }

    /**
     * @var Client
     */
    private $_httpClient;

    /**
     * 获取Http Client
     * @return Client
     */
    public function getHttpClient()
    {
        if (!is_object($this->_httpClient)) {
            $this->_httpClient = new Client([
                'baseUrl' => $this->baseUrl,
                'requestConfig' => [
                    'format' => Client::FORMAT_JSON,
                    'options' => [
                        'timeout' => 30,
                    ]
                ],
                'responseConfig' => [
                    'format' => Client::FORMAT_JSON
                ],
            ]);
        }
        return $this->_httpClient;
    }
}