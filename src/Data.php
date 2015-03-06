<?php namespace Astroanu\SEOGen;

use Illuminate\Support\Facades\Config;

class Data {

	private $data = [];

	public function __construct()
	{
		$this->data['title'] =  Config::get('astroanu.seogen.meta.default_title');
	}

	public function __get($key)
	{
		return  $this->data[$key];
	}

	public function __set($key, $value)
	{
		$this->data[$key] = $value;
		return $this;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function mergeData($data)
	{
		$this->data = array_merge($this->data, $data);
	}
}
