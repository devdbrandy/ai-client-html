<?php

namespace Aimeos\Client\Html\Catalog\Stock;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2015-2020
 */
class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $context;


	protected function setUp() : void
	{
		$this->context = \TestHelperHtml::getContext();

		$this->object = new \Aimeos\Client\Html\Catalog\Stock\Standard( $this->context );
		$this->object->setView( \TestHelperHtml::getView() );
	}


	protected function tearDown() : void
	{
		unset( $this->object );
	}


	public function testGetHeader()
	{
		$output = $this->object->getHeader();
		$this->assertNotNull( $output );
	}


	public function testGetHeaderException()
	{
		$object = $this->getMockBuilder( \Aimeos\Client\Html\Catalog\Stock\Standard::class )
			->setConstructorArgs( array( $this->context, [] ) )
			->setMethods( array( 'addData' ) )
			->getMock();

		$object->expects( $this->once() )->method( 'addData' )
			->will( $this->throwException( new \RuntimeException() ) );

		$object->setView( \TestHelperHtml::getView() );

		$this->assertEquals( null, $object->getHeader() );
	}


	public function testGetBody()
	{
		$prodid = \Aimeos\MShop::create( $this->context, 'product' )->find( 'CNC' )->getId();

		$view = $this->object->getView();
		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $view, array( 's_prodid' => $prodid ) );
		$view->addHelper( 'param', $helper );

		$output = $this->object->getBody();
		$this->assertRegExp( '/"' . $prodid . '".*stock-high/', $output );
	}


	public function testGetBodyException()
	{
		$object = $this->getMockBuilder( \Aimeos\Client\Html\Catalog\Stock\Standard::class )
			->setConstructorArgs( array( $this->context, [] ) )
			->setMethods( array( 'addData' ) )
			->getMock();

		$object->expects( $this->once() )->method( 'addData' )
			->will( $this->throwException( new \RuntimeException() ) );

		$object->setView( \TestHelperHtml::getView() );

		$this->assertEquals( null, $object->getBody() );
	}


	public function testGetSubClientInvalid()
	{
		$this->expectException( '\\Aimeos\\Client\\Html\\Exception' );
		$this->object->getSubClient( 'invalid', 'invalid' );
	}


	public function testGetSubClientInvalidName()
	{
		$this->expectException( '\\Aimeos\\Client\\Html\\Exception' );
		$this->object->getSubClient( '$$$', '$$$' );
	}
}
