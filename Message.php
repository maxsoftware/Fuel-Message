<?php
/*
Copyright (C) 2011 by Max Software Ltd

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

/**
 * Message
 * 
 * @package Message
 * @author Maxsoftware
 */
class Message {
	
	protected static $_messages = array();

	/**
	 * Message::_init()
	 * 
	 */
	public static function _init()
	{
		$current = Session::get('_messages');
        
		if ($current)
		{
			self::$_messages = unserialize($current);
		}
		else
		{
			self::reset();
		}
	}

	/**
	 * Message::notice()
	 * 
	 * @param string $m
	 */
	public static function notice($m)
	{
		self::_add('notice', $m);
	}

	/**
	 * Message::error()
	 * 
	 * @param string $m
	 */
	public static function error($m)
	{
		self::_add('error', $m);
	}

	/**
	 * Message::info()
	 * 
	 * @param string $m
	 */
	public static function info($m)
	{
		self::_add('info', $m);
	}

	/**
	 * Message::add()
	 * 
	 * @param string $type (notice, error, info)
	 * @param string $message
	 */
	protected static function _add($type, $message)
	{
		self::$_messages->{$type}[] = $message;
		self::write();
	}

	/**
	 * Message::get()
	 * 
	 */
	public static function get()
	{
		$messages = self::$_messages;
		foreach ($messages as $k => $v)
		{
			if ( ! count($v))
			{
				unset($messages->{$k});
			}
		}

		self::reset();
		self::write();

		return count((array) $messages) == 0 ? null : $msgs;
	}

	/**
	 * Message::reset()
	 * 
	 */
	public static function reset()
	{
		self::$_messages = (object) array(
			'notice' => array(),
			'error' => array(),
			'info' => array()
		);
	}

	/**
	 * Message::write()
	 * 
	 */
	public static function write()
	{
		Session::set('_messages', serialize(self::$_messages));
	}
}
