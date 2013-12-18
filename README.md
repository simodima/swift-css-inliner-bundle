swift-css-inliner-bundle
========================
[![Latest Stable Version](https://poser.pugx.org/trt/swift-css-inliner-bundle/v/stable.png)](https://packagist.org/packages/trt/swift-css-inliner-bundle)
[![Build Status](https://travis-ci.org/toretto460/swift-css-inliner-bundle.png)](https://travis-ci.org/toretto460/swift-css-inliner-bundle)


When HTML emails are viewed in browser-based email apps (like YahooMail!, Gmail, Hotmail, etc), those applications strip out the HEAD and BODY tags by default, so the only way to style the content is to place inline the CSS within the style attribute.
This is a dirty work for frontenders.
This plugin provides exactly the CSS processing to fille the style attributes.

#1.  Installation

####Add the dependency within the ```composer.json```

```json
    "require": {
        "trt/swift-css-inliner-bundle": "dev-master"
    }
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
    CssInlinerPlugin::CSS_HEADER_KEY,  //The key that say to the plugin "Apply this CSS"
    ".text{ color: red; }"
);
```

####Send the message.

``` php
$this->get('mailer')->send($message);
```
