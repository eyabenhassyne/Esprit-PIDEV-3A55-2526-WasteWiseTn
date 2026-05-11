<?php

namespace Symfony\Config\UxMap;

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class GoogleMapsConfig 
{
    private $defaultMapId;
    private $_usedProperties = [];

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function defaultMapId($value): static
    {
        $this->_usedProperties['defaultMapId'] = true;
        $this->defaultMapId = $value;

        return $this;
    }

    public function __construct(array $value = [])
    {
        if (array_key_exists('default_map_id', $value)) {
            $this->_usedProperties['defaultMapId'] = true;
            $this->defaultMapId = $value['default_map_id'];
            unset($value['default_map_id']);
        }

        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['defaultMapId'])) {
            $output['default_map_id'] = $this->defaultMapId;
        }

        return $output;
    }

}
