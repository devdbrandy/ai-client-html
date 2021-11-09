<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018-2021
 */


namespace Aimeos\Client\Html\Account\Subscription\Detail;


class StandardTest extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $context;


	protected function setUp() : void
	{
		$this->context = \TestHelperHtml::getContext();

		$view = \TestHelperHtml::getView();
		$view->standardBasket = \Aimeos\MShop::create( $this->context, 'order/base' )->create();

		$this->object = new \Aimeos\Client\Html\Account\Subscription\Detail\Standard( $this->context );
		$this->object->setView( $view );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->context );
	}


	public function testBody()
	{
		$customer = $this->getCustomerItem( 'test@example.com' );
		$this->context->setUserId( $customer->getId() );

		$view = \TestHelperHtml::getView();
		$param = array(
			'sub_action' => 'detail',
			'sub_id' => $this->getSubscriptionItem( $customer->getId() )->getId()
		);

		$helper = new \Aimeos\MW\View\Helper\Param\Standard( $view, $param );
		$view->addHelper( 'param', $helper );

		$this->object->setView( $this->object->data( $view ) );

		$output = $this->object->body();

		$this->assertStringStartsWith( '<div class="account-subscription-detail common-summary', $output );

		$this->assertStringContainsString( 'Our Unittest', $output );
		$this->assertStringContainsString( 'Example company', $output );

		$this->assertStringContainsString( 'Cafe Noire Expresso', $output );
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


	/**
	 * @param string $code
	 */
	protected function getCustomerItem( $code )
	{
		$manager = \Aimeos\MShop\Customer\Manager\Factory::create( $this->context );
		$search = $manager->filter();
		$search->setConditions( $search->compare( '==', 'customer.code', $code ) );

		if( ( $item = $manager->search( $search )->first() ) === null ) {
			throw new \RuntimeException( sprintf( 'No customer item with code "%1$s" found', $code ) );
		}

		return $item;
	}


	protected function getSubscriptionItem( $customerid )
	{
		$manager = \Aimeos\MShop::create( $this->context, 'subscription' );

		$search = $manager->filter();
		$search->setConditions( $search->compare( '==', 'order.base.customerid', $customerid ) );

		if( ( $item = $manager->search( $search )->first() ) === null ) {
			throw new \RuntimeException( sprintf( 'No subscription item for customer with ID "%1$s" found', $customerid ) );
		}

		return $item;
	}
}
