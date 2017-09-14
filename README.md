# yii2-dingtalk

[![Latest Stable Version](https://poser.pugx.org/xutl/yii2-dingtalk/v/stable.png)](https://packagist.org/packages/xutl/yii2-dingtalk)
[![Total Downloads](https://poser.pugx.org/xutl/yii2-dingtalk/downloads.png)](https://packagist.org/packages/xutl/yii2-dingtalk)
[![Dependency Status](https://www.versioneye.com/php/xutl:yii2-dingtalk/dev-master/badge.png)](https://www.versioneye.com/php/xutl:yii2-dingtalk/dev-master)
[![License](https://poser.pugx.org/xutl/yii2-dingtalk/license.svg)](https://packagist.org/packages/xutl/yii2-dingtalk)


Installation
------------

Next steps will guide you through the process of installing using [composer](http://getcomposer.org/download/). Installation is a quick and easy three-step process.

### Step 1: Install component via composer

Either run

```
composer require --prefer-dist xutl/yii2-dingtalk
```

or add

```json
"xutl/yii2-dingtalk": "~1.0.0"
```

to the `require` section of your composer.json.

### Step 2: Configuring your application

Add following lines to your main configuration file:

```php
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => 'xutl\dingtalk\DingTalkTarget',
                    'dingTalk' => 'dingTalk',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'dingTalk' => [
            'class' => 'xutl\dingtalk\DingTalk',
            'accessToken' => '1234567890',
        ],
    ],
```

### Step 3: Start using

```php
Yii::$app->dingTalk->sendText('我其实是一个机器人');
Yii::$app->dingTalk->sendLink('我其实是一个机器人','我其实是一个机器人我其实是一个机器人我其实是一个机器人我其实是一个机器人！','','https://www.dingtalk.com/');
Yii::$app->dingTalk->sendMarkdown('我其实是一个机器人','我其实是一个机器人');
Yii::$app->dingTalk->sendActionCard......
```

Read [https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.p2lr6t&treeId=257&articleId=105733&docType=1](https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.p2lr6t&treeId=257&articleId=105733&docType=1) to continue

## License

This is released under the MIT License. See the bundled [LICENSE.md](LICENSE.md)
for details.
