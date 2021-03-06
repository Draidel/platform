<?php

namespace Oro\Bundle\ApiBundle\Tests\Unit\ApiDoc;

use Oro\Bundle\ApiBundle\ApiDoc\ResourceDocParserInterface;
use Oro\Bundle\ApiBundle\ApiDoc\ResourceDocParserRegistry;
use Oro\Bundle\ApiBundle\Request\RequestType;
use Oro\Bundle\ApiBundle\Util\RequestExpressionMatcher;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ResourceDocParserRegistryTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject|ContainerInterface */
    protected $container;

    protected function setUp()
    {
        $this->container = $this->createMock(ContainerInterface::class);
    }

    /**
     * @param array $resourceDocParsers
     *
     * @return ResourceDocParserRegistry
     */
    private function getResourceDocParserRegistry(array $resourceDocParsers)
    {
        return new ResourceDocParserRegistry(
            $resourceDocParsers,
            $this->container,
            new RequestExpressionMatcher()
        );
    }

    public function testSouldReturnResourceDocParserIfItExistsForSpecificRequestType()
    {
        $registry = $this->getResourceDocParserRegistry([
            ['resourceDocParser1', 'rest&json_api'],
            ['resourceDocParser2', 'rest'],
            ['resourceDocParser3', null]
        ]);

        $resourceDocParser = $this->createMock(ResourceDocParserInterface::class);
        $this->container->expects(self::once())
            ->method('get')
            ->with('resourceDocParser2')
            ->willReturn($resourceDocParser);

        self::assertSame(
            $resourceDocParser,
            $registry->getParser(new RequestType(['rest']))
        );
    }

    public function testSouldReturnDefaultResourceDocParserIfNoParserForSpecificRequestType()
    {
        $registry = $this->getResourceDocParserRegistry([
            ['resourceDocParser1', 'rest&json_api'],
            ['resourceDocParser2', 'rest'],
            ['resourceDocParser3', null]
        ]);

        $resourceDocParser = $this->createMock(ResourceDocParserInterface::class);
        $this->container->expects(self::once())
            ->method('get')
            ->with('resourceDocParser3')
            ->willReturn($resourceDocParser);

        self::assertSame(
            $resourceDocParser,
            $registry->getParser(new RequestType(['another']))
        );
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Cannot find a resource documentation parser for the request "another".
     */
    public function testSouldThrowExceptionIfNoResourceDocParserForSpecificRequestTypeAndNoDefaultParser()
    {
        $registry = $this->getResourceDocParserRegistry([
            ['resourceDocParser1', 'rest&json_api']
        ]);

        $this->container->expects(self::never())
            ->method('get');

        $registry->getParser(new RequestType(['another']));
    }
}
