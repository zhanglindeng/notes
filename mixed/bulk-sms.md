# Bulk SMS

### 安装依赖

```shell
composer install cmtelecom/messaging-php
composer install php-http/guzzle6-adapter
```

### 添加配置

#### .env
```shell
BULK_SMS_PRODUCT_TOKEN=<your product token>
```

#### config/services.php
```php
'bulk_sms_product_token' => env('BULK_SMS_PRODUCT_TOKEN', null),
```

### 添加代码

#### app/Helpers/BulkSmsApi.php
```php
<?php

namespace App\Helpers;

use CM\Messaging\Client;
use CM\Messaging\Exception\BadRequestException;
use CM\Messaging\Message;
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Http\Client\Exception\TransferException;

class BulkSmsApi
{
    /**
     * @var string
     */
    protected $productToken;

    /**
     * @var string
     */
    protected $from;

    /**
     * @var string|array
     */
    protected $to;

    /**
     * @var string
     */
    protected $body;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var array|string
     */
    protected $allowedChannels;

    /**
     * @var string
     */
    protected $appKey;

    /**
     * @var int
     */
    protected $minimumNumberOfMessageParts;


    /**
     * @var int
     */
    protected $maximumNumberOfMessageParts;

    /**
     * @var int
     */
    protected $dcs;

    public function __construct($productToken)
    {
        $this->productToken = $productToken;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function setMinimumNumberOfMessageParts($minimumNumberOfMessageParts)
    {
        $this->minimumNumberOfMessageParts = $minimumNumberOfMessageParts;
    }

    public function setMaximumNumberOfMessageParts($maximumNumberOfMessageParts)
    {
        $this->maximumNumberOfMessageParts = $maximumNumberOfMessageParts;
    }

    public function setDcs($dcs)
    {
        $this->dcs = $dcs;
    }

    public function setAppKey($appKey)
    {
        $this->appKey = $appKey;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    public function setAllowedChannels($allowedChannels)
    {
        $this->allowedChannels = $allowedChannels;
    }

    public function send()
    {
        $message = (new Message())
            ->setFrom($this->from)
            ->setTo($this->to)
            ->setBody($this->body)
            ->setReference($this->reference)
            ->setAllowedChannels($this->allowedChannels)
            ->setAppKey($this->appKey)
            ->setMinimumNumberOfMessageParts($this->minimumNumberOfMessageParts)
            ->setMaximumNumberOfMessageParts($this->maximumNumberOfMessageParts)
            ->setDcs($this->dcs);

        try {
            $adapter = new GuzzleAdapter(new GuzzleClient());
            $client = new Client($adapter, $this->productToken);
            $result = $client->send($message);

            if ($result->isAccepted()) {
                // All messages were accepted
                return true;
            } else {
                // Not all messages were accepted
                $this->errors = $result->getFailed();
            }
        } catch (BadRequestException $e) {
            // The request failed because of an invalid value, all messages has not been send
            $this->errors = [$e->getMessage()];
        } catch (TransferException $e) {
            // Something unexpected happened
            $this->errors = [$e->getMessage()];
        }

        return false;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
```

#### app/Helpers/BulkSms.php
```php
<?php

namespace App\Helpers;


use CM\Messaging\Settings\AllowedChannel;

class BulkSms
{
    /**
     * @var BulkSmsApi
     */
    protected $provider;

    private function __construct()
    {
        $this->provider = new BulkSmsApi(config('services.bulk_sms_product_token'));
    }

    /**
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * @param $from string
     * @return $this
     */
    public function from($from)
    {
        $this->provider->setFrom($from);

        return $this;
    }

    /**
     * @param $to string|array
     * @return $this
     */
    public function to($to)
    {
        $this->provider->setTo($to);

        return $this;
    }

    /**
     * @param $body string
     * @return $this
     */
    public function body($body)
    {
        $this->provider->setBody($body);

        return $this;
    }

    /**
     * @param array $options
     * @return bool
     */
    public function send(array $options = [])
    {
        $this->setOptions($options);

        return $this->provider->send();
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->provider->getErrors();
    }

    protected function setOptions(array $options)
    {
        $options = array_merge($this->getDefaultOptions(), $options);

        $this->provider->setReference($options['reference']);
        $this->provider->setAllowedChannels($options['allowedChannels']);
        $this->provider->setAppKey($options['appKey']);
        $this->provider->setDcs($options['dcs']);
        $this->provider->setMinimumNumberOfMessageParts($options['minimumNumberOfMessageParts']);
        $this->provider->setMaximumNumberOfMessageParts($options['maximumNumberOfMessageParts']);
    }

    protected function getDefaultOptions()
    {
        return [
            'reference'                   => '',
            'allowedChannels'             => [AllowedChannel::SMS, AllowedChannel::PUSH, AllowedChannel::VOICE],
            'appKey'                      => '',
            'dcs'                         => 8,
            'minimumNumberOfMessageParts' => 1,
            'maximumNumberOfMessageParts' => 8,
        ];
    }
}
```

### 使用示例
```php
<?php

$sms = \App\Helpers\BulkSms::create();

if ($sms->from('developer')->to(['+8618100000000'])->body('这是一条测试信息，This is a test message')->send([
    'reference'                   => 'test_reference',
    'dcs'                         => 8,
    'minimumNumberOfMessageParts' => 1,
    'maximumNumberOfMessageParts' => 8,
])
) {
    echo 'OK';
} else {
    var_dump($sms->getErrors());
}
```
