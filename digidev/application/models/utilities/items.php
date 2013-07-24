<?php

class dgdev_utility_items {

	private $item_type;

	public function __construct($item_type=null)
	{
		$this->item_type = $item_type;

	}

	public function get_value($item_name)
	{
		$query="select item_value
				from items
				where item_type='".$this->item_type."'
				and item_name='".$item_name."'";

		return Zend_Registry::get('database')->get_dgdev_adapter()->fetchOne($query);
	}

	public function get_text($item_name)
	{
		$query="select item_text
				from items
				where item_type='".$this->item_type."'
				and item_name='".$item_name."'";

		return Zend_Registry::get('database')->get_dgdev_adapter()->fetchOne($query);
	}

	public function get_attribute1($item_name){
		$query="select item_attribute1
				from items
				where item_type='".$this->item_type."'
				and item_name='".$item_name."'";

		return Zend_Registry::get('database')->get_dgdev_adapter()->fetchOne($query);
	}

	public function get_attribute2($item_name){
		$query="select item_attribute2
				from items
				where item_type='".$this->item_type."'
				and item_name='".$item_name."'";

		return Zend_Registry::get('database')->get_dgdev_adapter()->fetchOne($query);
	}
}

?>