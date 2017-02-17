<?php
namespace App\Phase\Transformers;

class InvoiceTransformer extends Transformers
{
	public static function transform($invoice)
	{
		return [
			'data' 	=> $invoice,
		];
	}
}