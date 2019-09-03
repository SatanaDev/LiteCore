<?php

/*
 * _      _ _        _____               
 *| |    (_) |      / ____|              
 *| |     _| |_ ___| |     ___  _ __ ___ 
 *| |    | | __/ _ \ |    / _ \| '__/ _ \
 *| |____| | ||  __/ |___| (_) | | |  __/
 *|______|_|\__\___|\_____\___/|_|  \___|
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author genisyspromcpe
 * @link https://github.com/genisyspromcpe/LiteCore
 *
 *
*/

namespace pocketmine\entity;

class AttributeMap implements \ArrayAccess {
	/** @var Attribute[] */
	private $attributes = [];

	/**
	 * @param Attribute $attribute
	 */
	public function addAttribute(Attribute $attribute){
		$this->attributes[$attribute->getId()] = $attribute;
	}

	/**
	 * @param int $id
	 *
	 * @return Attribute|null
	 */
	public function getAttribute(int $id){
		return $this->attributes[$id] ?? null;
	}

	/**
	 * @return array
	 */
	public function getAll() : array{
		return $this->attributes;
	}

	/**
	 * @return Attribute[]
	 */
	public function needSend() : array{
		return array_filter($this->attributes, function(Attribute $attribute){
			return $attribute->isSyncable() and $attribute->isDesynchronized();
		});
	}

	/**
	 * @param mixed $offset
	 *
	 * @return bool
	 */
	public function offsetExists($offset){
		return isset($this->attributes[$offset]);
	}

	/**
	 * @param mixed $offset
	 *
	 * @return float
	 */
	public function offsetGet($offset){
		return $this->attributes[$offset]->getValue();
	}

	/**
	 * @param mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value){
		$this->attributes[$offset]->setValue($value);
	}

	/**
	 * @param mixed $offset
	 */
	public function offsetUnset($offset){
		throw new \RuntimeException("Could not unset an attribute from an attribute map");
	}
}
