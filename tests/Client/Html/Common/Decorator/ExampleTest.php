<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2014
 * @copyright Aimeos (aimeos.org), 2015-2026
 */


namespace Aimeos\Client\Html\Common\Decorator;


abstract class CatalogFilterStub extends \Aimeos\Client\Html\Catalog\Filter\Standard
{
	abstract public function testMethod();
}


class ExampleTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $context;
	private $view;


	protected function setUp() : void
	{
		$this->view = \TestHelper::view();
		$this->context = \TestHelper::context();

		$client = new \Aimeos\Client\Html\Catalog\Filter\Standard( $this->context, [] );

		$this->object = new \Aimeos\Client\Html\Common\Decorator\Example( $client, $this->context, [] );
		$this->object->setView( $this->view );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->context, $this->view );
	}


	public function testCall()
	{
		$client = $this->getMockBuilder( CatalogFilterStub::class )
			->onlyMethods( ['testMethod'] )
			->setConstructorArgs( array( $this->context, [] ) )
			->getMock();

		$client->expects( $this->once() )->method( 'testMethod' )->willReturn( true );

		$object = new \Aimeos\Client\Html\Common\Decorator\Example( $client, $this->context, [] );
		$object->setView( $this->view );

		$this->assertTrue( $object->testMethod() );
	}


	public function testGetSubClient()
	{
		$this->assertInstanceOf( '\\Aimeos\\Client\\Html\\Iface', $this->object->getSubClient( 'tree' ) );
	}


	public function testHeader()
	{
		$client = $this->getMockBuilder( \Aimeos\Client\Html\Catalog\Filter\Standard::class )
			->onlyMethods( ['header'] )
			->setConstructorArgs( array( $this->context, [] ) )
			->getMock();

		$client->expects( $this->once() )->method( 'header' )->willReturn( 'header' );

		$object = new \Aimeos\Client\Html\Common\Decorator\Example( $client, $this->context, [] );
		$object->setView( $this->view );

		$this->assertEquals( 'header', $object->header() );
	}


	public function testBody()
	{
		$client = $this->getMockBuilder( \Aimeos\Client\Html\Catalog\Filter\Standard::class )
			->onlyMethods( ['body'] )
			->setConstructorArgs( array( $this->context, [] ) )
			->getMock();

		$client->expects( $this->once() )->method( 'body' )->willReturn( 'body' );

		$object = new \Aimeos\Client\Html\Common\Decorator\Example( $client, $this->context, [] );
		$object->setView( $this->view );

		$this->assertEquals( 'body', $object->body() );
	}


	public function testGetView()
	{
		$this->assertInstanceOf( '\\Aimeos\\Base\\View\\Iface', $this->view );
	}


	public function testSetView()
	{
		$this->view = new \Aimeos\Base\View\Standard();
		$this->object->setView( $this->view );

		$this->assertSame( $this->view, $this->view );
	}


	public function testModifyBody()
	{
		$this->assertEquals( 'test', $this->object->modify( 'test', 1 ) );
	}


	public function testInit()
	{
		$this->expectNotToPerformAssertions();
		$this->object->init();
	}


	public function testResponse()
	{
		$this->assertInstanceOf( '\Psr\Http\Message\ResponseInterface', $this->object->response() );
	}


	public function testSetObject()
	{
		$this->assertInstanceOf( \Aimeos\Client\Html\Iface::class, $this->object->setObject( $this->object ) );
	}

}
