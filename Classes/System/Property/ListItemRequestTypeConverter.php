<?php

/*
 * 
 * Seems we dont need a custom TypeConverter
 

class Tx_List_System_Property_ListItemRequestTypeConverter extends Tx_Extbase_Property_TypeConverter_AbstractTypeConverter {
	/**
	 * @var array<string>
	 
	protected $sourceTypes = array('array');

	/**
	 * @var string
	 
	protected $targetType = 'Tx_List_Core_ListItemRequest';

	/**
	 * @var integer
	 
	protected $priority = 100;
	
	/**
	 * Actually convert from $source to $targetType, taking into account the fully
	 * built $convertedChildProperties and $configuration.
	 *
	 * @param string $source
	 * @param string $targetType
	 * @param array $convertedChildProperties
	 * @param Tx_Extbase_Property_PropertyMappingConfigurationInterface $configuration
	 * @return string
	 * @api
	 
	public function convertFrom($source, $targetType, array $convertedChildProperties = array(), Tx_Extbase_Property_PropertyMappingConfigurationInterface $configuration = NULL) {
		return $source;
	}
}

*/