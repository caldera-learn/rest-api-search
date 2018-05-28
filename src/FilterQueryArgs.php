<?php


namespace CalderaLearn\RestSearch;

abstract class FilterQueryArgs implements ModifyQueryArgsContract
{

	use UsesPreparedPostTypes;

	/**
	 * @var \WP_REST_Request
	 */
	private $request;


	/**
	 * @return \WP_REST_Request
	 */
	protected function getRequest() : \WP_REST_Request
	{
		return $this->request;
	}

	/**
	 * @param \WP_REST_Request $request
	 * @return $this
	 */
	protected function setRequest(\WP_REST_Request $request)
	{
		$this->request = $request;
		return $this;
	}
}
