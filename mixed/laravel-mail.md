# laravel 5.3 send a mail

### link
- [laravel](https://laravel-china.org/docs/5.3/mail)
- [简书](http://www.jianshu.com/p/8ccb2820df23)

### config/mail.php
```php
'form' => [
  'address' => 'hello@example.com', // the same as .env
  'name' => 'Example',
],
```

### .env
```ini
MAIL_DRIVER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=25
# ssl 465
MAIL_USERNAME=username@example.com
MAIL_PASSWORD=example
MAIL_ENCRYPTION=null
```

### demo
```php
$data = [
    // 'message' => '測試測試xxx郵件abc' . date('Y-m-d H:i:s'),// NOTICE 不能是 message 啊!!!! 5555555
    'msg'     => '測試測試xxx郵件abc' . date('Y-m-d H:i:s'),
];
$result = Mail::send('email.test', $data, function ($message) {
    /**
     * @var $message \Illuminate\Mail\Message
     */
    $message->to('zhanglindeng@163.com', '鄧章林')->subject('測試郵件');
});
```
