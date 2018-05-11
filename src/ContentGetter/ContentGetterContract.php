<?php

namespace CalderaLearn\RestSearch\ContentGetter;

/**
 * Defines the contract for each content getter implementation.
 * @package CalderaLearn\RestSearch\ContentGetter
 */
interface ContentGetterContract
{
	/**
	 * Handles getting the content for the search query.
	 *
	 * @param int $quantity Number to get.
	 *
	 * @return array
	 */
	public function getContent( $quantity = 4 ) : array;
}
