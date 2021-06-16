<?php

namespace Prokl\WpCycleOrmBundle;

use Prokl\WpCycleOrmBundle\DependencyInjection\WpCycleOrmExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class WpCycleOrmBundle
 * @package Prokl\WpCycleOrmBundle
 *
 * @since 16.06.2021
 */
class WpCycleOrmBundle extends Bundle
{
   /**
   * @inheritDoc
   */
    public function getContainerExtension()
    {
        if ($this->extension === null) {
            $this->extension = new WpCycleOrmExtension();
        }

        return $this->extension;
    }
}
