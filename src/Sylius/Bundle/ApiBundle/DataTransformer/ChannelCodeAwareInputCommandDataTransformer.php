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

namespace Sylius\Bundle\ApiBundle\DataTransformer;

use Sylius\Bundle\ApiBundle\Command\ChannelCodeAwareInterface;
use Sylius\Component\Channel\Context\ChannelContextInterface;

trigger_deprecation(
    'sylius/api-bundle',
    '1.14',
    'The "%s" class is deprecated and will be removed in Sylius 2.0.',
    ChannelCodeAwareInputCommandDataTransformer::class,
);
/** @deprecated since Sylius 1.14 and will be removed in Sylius 2.0. */
final class ChannelCodeAwareInputCommandDataTransformer implements CommandDataTransformerInterface
{
    public function __construct(private ChannelContextInterface $channelContext)
    {
    }

    public function transform($object, string $to, array $context = [])
    {
        $channel = $this->channelContext->getChannel();

        $object->setChannelCode($channel->getCode());

        return $object;
    }

    public function supportsTransformation($object): bool
    {
        return $object instanceof ChannelCodeAwareInterface;
    }
}
