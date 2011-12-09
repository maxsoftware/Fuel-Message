<?php

/**
 * Message
 * 
 * @package Message
 * @author Michael Heap
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
