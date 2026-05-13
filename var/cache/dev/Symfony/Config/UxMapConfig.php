<?php

namespace Symfony\Config;

require_once __DIR__.\DIRECTORY_SEPARATOR.'UxMap'.\DIRECTORY_SEPARATOR.'GoogleMapsConfig.php';

use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * This class is automatically generated to help in creating a config.
 */
class UxMapConfig implements \Symfony\Component\Config\Builder\ConfigBuilderInterface
{
    private $renderer;
    private $googleMaps;
    private $_usedProperties = [];

    /**
     * @default null
     * @param ParamConfigurator|mixed $value
     * @return $this
     */
    public function renderer($value): static
    {
        $this->_usedProperties['renderer'] = true;
        $this->renderer = $value;

        return $this;
    }

    /**
     * @default {"default_map_id":null}
    */
    public function googleMaps(array $value = []): \Symfony\Config\UxMap\GoogleMapsConfig
    {
        if (null === $this->googleMaps) {
            $this->_usedProperties['googleMaps'] = true;
            $this->googleMaps = new \Symfony\Config\UxMap\GoogleMapsConfig($value);
        } elseif (0 < \func_num_args()) {
            throw new InvalidConfigurationException('The node created by "googleMaps()" has already been initialized. You cannot pass values the second time you call googleMaps().');
        }

        return $this->googleMaps;
    }

    public function getExtensionAlias(): string
    {
        return 'ux_map';
    }

    public function __construct(array $value = [])
    {
        if (array_key_exists('renderer', $value)) {
            $this->_usedProperties['renderer'] = true;
            $this->renderer = $value['renderer'];
            unset($value['renderer']);
        }

        if (array_key_exists('google_maps', $value)) {
            $this->_usedProperties['googleMaps'] = true;
            $this->googleMaps = new \Symfony\Config\UxMap\GoogleMapsConfig($value['google_maps']);
            unset($value['google_maps']);
        }

        if ([] !== $value) {
            throw new InvalidConfigurationException(sprintf('The following keys are not supported by "%s": ', __CLASS__).implode(', ', array_keys($value)));
        }
    }

    public function toArray(): array
    {
        $output = [];
        if (isset($this->_usedProperties['renderer'])) {
            $output['renderer'] = $this->renderer;
        }
        if (isset($this->_usedProperties['googleMaps'])) {
            $output['google_maps'] = $this->googleMaps->toArray();
        }

        return $output;
    }

}
