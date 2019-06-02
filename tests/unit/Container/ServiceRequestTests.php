<?php declare(strict_types=1);

namespace UnitTests\Container;

use PHPUnit\Framework\TestCase;
use Stellar\Container\ServiceRequest;
use Stellar\Exceptions\Common\InvalidArgument;
use Stellar\Exceptions\Common\InvalidType;
use Stellar\Exceptions\Testing\AssertException;

/**
 * @coversDefaultClass \Stellar\Container\ServiceRequest
 */
class ServiceRequestTests extends TestCase
{
    use AssertException;

    /**
     * @covers ::__construct
     */
    public function test_invalid_argument()
    {
        $this->expectException(InvalidType::class);
        $this->assertException(function () {
            new ServiceRequest(false);
        });
    }

    /**
     * @covers ::__construct()
     * @covers ::getService()
     */
    public function test_service_construction()
    {
        $service = new \ArrayObject([ 'foo', 'bar', 'test' ]);
        $serviceRequest = new ServiceRequest($service);

        $this->assertSame($service, $serviceRequest->getService());
    }

    /**
     * @covers ::with()
     */
    public function test_service_construction_with_factory()
    {
        $serviceRequest = ServiceRequest::with(new \ArrayObject([ 'foo', 'bar', 'test' ]));
        $this->assertInstanceOf(\ArrayObject::class, $serviceRequest->getService());
    }

    /**
     * @covers ::asSingleton()
     * @covers ::isSingleton()
     */
    public function test_can_set_as_singleton()
    {
        $serviceRequest = new ServiceRequest(new \ArrayObject());
        $serviceRequest->asSingleton();

        $this->assertTrue($serviceRequest->isSingleton());
    }
}
