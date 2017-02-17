<?php
namespace App\Phase\Transformers;

abstract class Transformers
{
	/**
	 * Transform a collection of invoices
	 *
	 * @param $items
	 * @return array
	 */
	public static function transformCollection(array $items)
	{
		return array_map([$this, 'transform'], $items);
	}

	public abstract function transform($items);

}