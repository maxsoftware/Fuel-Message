Fuel-Message
============

A flashdata wrapper for FuelPHP.

Usage:

Message::Notice("This is a notice");
Message::Get(); => stdClass {
	"notice" => array(
		"This is a notice"
	);
}