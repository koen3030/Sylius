<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Sylius\Bundle\ApiBundle\ApiPlatform;

use ApiPlatform\Core\Metadata\Resource\ResourceMetadata;

trigger_deprecation(
    'sylius/api-bundle',
    '1.14',
    'The "%s" class is deprecated and will be removed in Sylius 2.0.',
    ResourceMetadataPropertyValueResolver::class,
);
/** @deprecated since Sylius 1.14 and will be removed in Sylius 2.0. */
final class ResourceMetadataPropertyValueResolver implements ResourceMetadataPropertyValueResolverInteface
{
    public function __construct(private ApiResourceConfigurationMergerInterface $apiResourceConfigurationMerger)
    {
    }

    /**
     * @return mixed
     */
    public function resolve(
        string $propertyName,
        ResourceMetadata $parentResourceMetadata,
        array $childResourceMetadata,
    ) {
        $parentPropertyValue = $parentResourceMetadata->{'get' . ucfirst($propertyName)}();

        $childPropertyValue = $childResourceMetadata[$propertyName];

        if (null === $childPropertyValue) {
            return $parentPropertyValue;
        }

        if (null === $parentPropertyValue) {
            return $childPropertyValue;
        }

        if (is_array($parentPropertyValue)) {
            if (!is_array($childPropertyValue)) {
                throw new \InvalidArgumentException(sprintf(
                    'Invalid child property value type for property "%s", expected array',
                    $propertyName,
                ));
            }

            return $this->apiResourceConfigurationMerger->mergeConfigs($parentPropertyValue, $childPropertyValue);
        }

        return $childPropertyValue;
    }
}
