<?php

namespace Prokl\WpCycleOrmBundle\Tests\Cases;

use Cycle\ORM\Schema;
use Prokl\TestingTools\Base\BaseTestCase;
use Prokl\WpCycleOrmBundle\Schemas\WpPosts;
use Prokl\WpCycleOrmBundle\Services\ClassLocator;
use Prokl\WpCycleOrmBundle\Services\Helper\SchemaToPHP;

/**
 * Class SchemaToPHPTest
 * @package Prokl\WpCycleOrmBundle\Tests\Cases
 */
class SchemaToPHPTest extends BaseTestCase
{
    /**
     * @var SchemaToPHP $obTestObject
     */
    protected $obTestObject;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        $post = new WpPosts();
        $schema = new Schema($post->schema());

        $this->obTestObject = new SchemaToPHP($schema);
    }

    /**
     * @return void
     */
    public function testRender() : void
    {
        $result = $this->obTestObject->render();

        $this->assertStringContainsString(
            "Prokl\WpCycleOrmBundle\Entities\Post' => [",
            $result
        );

        $this->assertStringContainsString(
            "Schema::RELATIONS => [",
            $result
        );
    }
}