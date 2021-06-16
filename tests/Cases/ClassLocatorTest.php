<?php

namespace Prokl\WpCycleOrmBundle\Tests\Cases;

use Prokl\TestingTools\Base\BaseTestCase;
use Prokl\WpCycleOrmBundle\Services\ClassLocator;

/**
 * Class ClassLocatorTest
 * @package Prokl\WpCycleOrmBundle\Tests\Cases
 */
class ClassLocatorTest extends BaseTestCase
{
    /**
     * @var ClassLocator $obTestObject
     */
    protected $obTestObject;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->obTestObject = new ClassLocator(
            $_SERVER['DOCUMENT_ROOT'] . '/src/Entities'
        );
    }

    /**
     * @return void
     */
    public function testGetLocator() : void
    {
        $result = $this->obTestObject->getLocator();
        $classes = $result->getClasses();

        $this->assertNotEmpty($classes);
    }
}