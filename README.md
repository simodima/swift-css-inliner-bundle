swift-css-inliner-bundle
========================

A Swiftmailer plugin that provides css inline features

#1.  Installation

####Add the dependency within the ```composer.json```

```json
    [...]
    "require": {
        ...
        "trt/swift-css-inliner-bundle": "dev-master"
    }
    [...]
```

run ``` /$ ./composer.phar install```

####Enable the bundle (add the following line within the AppKernel.php)

```php

$bundles = array(
    [...]
    new \Trt\SwiftCssInlinerBundle\TrtSwiftCssInlinerBundle(),
);
```

#2.  Usage

####Create the swiftmailer message.

```php
$message = \Swift_Message::newInstance()
    ->setSubject('Hello Email')
    ->setFrom('send@example.com')
    ->setTo('recipient@example.com')
    ->setContentType('text/html')
    ->setBody('<p class="text"> Hello </p>')
;
```
####Add your style

```php
$message->getHeaders()->addTextHeader(
    CssInlinerPlugin::CSS_HEADER_KEY,
    ".text{ color: red; }"
);
```

####Send the message.

``php
$this->get('mailer')->send($message);
```
