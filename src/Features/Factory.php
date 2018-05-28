<?php


namespace CalderaLearn\RestSearch\Features;

use CalderaLearn\RestSearch\FilterQueryArgs;
use CalderaLearn\RestSearch\FilterSchema;
use CalderaLearn\RestSearch\ModifyQueryArgsContract;
use CalderaLearn\RestSearch\ModifySchemaContract;

class Factory
{

	/**
	 * Create Search system
	 *
	 * @param array $argumentsToAdd
	 * @param array $postTypesToSupport
	 * @return Search
	 */
	public static function searchFromArguments(array $argumentsToAdd, array $postTypesToSupport)
	{
		foreach ($argumentsToAdd as $argumentName => $argument) {
			$schemaModify = new class( $postTypesToSupport ) extends FilterSchema {
				/**
				 * @var array
				 */
				protected $arguments = [];
				/**
				 * @var array
				 */
				protected $postTypesToSupport = [];
				public function __construct(array $postTypesToSupport)
				{
					$this->postTypesToSupport = $postTypesToSupport;
				}


				public function addArgument(string $argumentName, array $argument = null)
				{
					$this->arguments[$argumentName] = $argument;
					return $this;
				}

				public function getAdditionalSchemaArguments(): array
				{
					return $this->arguments;
				}

				public function shouldFilter(string $postTypeSlug): bool
				{
					return in_array($postTypeSlug, $this->postTypesToSupport);
				}
			};

			$queryModify = new class( $postTypesToSupport ) extends FilterQueryArgs {
				/**
				 * @var array
				 */
				protected $arguments = [];
				/**
				 * @var array
				 */
				protected $postTypesToSupport = [];
				public function __construct(array $postTypesToSupport)
				{
					$this->postTypesToSupport = $postTypesToSupport;
				}

				public function addArgument(string $argumentName, $default)
				{
					$this->arguments[$argumentName] = $default;
					return $this;
				}

				public function getAdditionalQueryArguments(): array
				{
					return $this->arguments;
				}

				public function shouldFilter(string $postTypeSlug): bool
				{
					return in_array($postTypeSlug, $this->postTypesToSupport);
				}
			};

			$schemaModify->addArgument($argumentName, $argument['schema']);
			$queryModify->addArgument($argumentName, $argument['default']);
			return self::search($queryModify, $schemaModify);
		}
	}

	/**
	 * @param ModifyQueryArgsContract $queryModify
	 * @param ModifySchemaContract $schemaModify
	 * @return Search
	 */
	public static function search(ModifyQueryArgsContract$queryModify, ModifySchemaContract $schemaModify): Search
	{
		return new Search($queryModify, $schemaModify);
	}
}
