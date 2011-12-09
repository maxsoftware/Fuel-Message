Fuel-Message
============

A flashdata wrapper for FuelPHP.

Usage:

```php
Message::Notice("This is a notice");
```
```php
Message::Get(); => stdClass {
	"notice" => array(
		"This is a notice"
	);
}
```