<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019-2021
 * @package Client
 * @subpackage Html
 */


namespace Aimeos\Client\Html\Account\Profile\Address;


/**
 * Default implementation of acount profile address HTML client.
 *
 * @package Client
 * @subpackage Html
 */
class Standard
	extends \Aimeos\Client\Html\Common\Client\Summary\Base
	implements \Aimeos\Client\Html\Common\Client\Factory\Iface
{
	/** client/html/account/profile/address/subparts
	 * List of HTML sub-clients rendered within the account profile address section
	 *
	 * The output of the frontend is composed of the code generated by the HTML
	 * clients. Each HTML client can consist of serveral (or none) sub-clients
	 * that are responsible for rendering certain sub-parts of the output. The
	 * sub-clients can contain HTML clients themselves and therefore a
	 * hierarchical tree of HTML clients is composed. Each HTML client creates
	 * the output that is placed inside the container of its parent.
	 *
	 * At first, always the HTML code generated by the parent is printed, then
	 * the HTML code of its sub-clients. The address of the HTML sub-clients
	 * determines the address of the output of these sub-clients inside the parent
	 * container. If the configured list of clients is
	 *
	 *  array( "subclient1", "subclient2" )
	 *
	 * you can easily change the address of the output by readdressing the subparts:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1", "subclient2" )
	 *
	 * You can also remove one or more parts if they shouldn't be rendered:
	 *
	 *  client/html/<clients>/subparts = array( "subclient1" )
	 *
	 * As the clients only generates structural HTML, the layout defined via CSS
	 * should support adding, removing or readdressing content by a fluid like
	 * design.
	 *
	 * @param array List of sub-client names
	 * @since 2019.07
	 * @category Developer
	 */
	private $subPartPath = 'client/html/account/profile/address/subparts';
	private $subPartNames = [];


	/**
	 * Returns the HTML code for insertion into the body.
	 *
	 * @param string $uid Unique identifier for the output if the content is placed more than once on the same page
	 * @return string HTML code
	 */
	public function body( string $uid = '' ) : string
	{
		$view = $this->getView();

		$html = '';
		foreach( $this->getSubClients() as $subclient ) {
			$html .= $subclient->setView( $view )->body( $uid );
		}
		$view->addressBody = $html;

		/** client/html/account/profile/address/template-body
		 * Relative path to the HTML body template of the account profile address client.
		 *
		 * The template file contains the HTML code and processing instructions
		 * to generate the result shown in the body of the frontend. The
		 * configuration string is the path to the template file relative
		 * to the templates directory (usually in client/html/templates).
		 *
		 * You can overwrite the template file configuration in extensions and
		 * provide alternative templates. These alternative templates should be
		 * named like the default one but with the string "standard" replaced by
		 * an unique name. You may use the name of your project for this. If
		 * you've implemented an alternative client class as well, "standard"
		 * should be replaced by the name of the new class.
		 *
		 * @param string Relative path to the template creating code for the HTML page body
		 * @since 2019.07
		 * @category Developer
		 * @see client/html/account/profile/address/template-header
		 */
		$tplconf = 'client/html/account/profile/address/template-body';
		$default = 'account/profile/address-body-standard';

		return $view->render( $view->config( $tplconf, $default ) );
	}


	/**
	 * Returns the sub-client given by its name.
	 *
	 * @param string $type Name of the client type
	 * @param string|null $name Name of the sub-client (Default if null)
	 * @return \Aimeos\Client\Html\Iface Sub-client object
	 */
	public function getSubClient( string $type, string $name = null ) : \Aimeos\Client\Html\Iface
	{
		/** client/html/account/profile/address/decorators/excludes
		 * Excludes decorators added by the "common" option from the account profile address html client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to remove a decorator added via
		 * "client/html/common/decorators/default" before they are wrapped
		 * around the html client.
		 *
		 *  client/html/account/profile/address/decorators/excludes = array( 'decorator1' )
		 *
		 * This would remove the decorator named "decorator1" from the list of
		 * common decorators ("\Aimeos\Client\Html\Common\Decorator\*") added via
		 * "client/html/common/decorators/default" to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2019.07
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/account/profile/address/decorators/global
		 * @see client/html/account/profile/address/decorators/local
		 */

		/** client/html/account/profile/address/decorators/global
		 * Adds a list of globally available decorators only to the account profile address html client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap global decorators
		 * ("\Aimeos\Client\Html\Common\Decorator\*") around the html client.
		 *
		 *  client/html/account/profile/address/decorators/global = array( 'decorator1' )
		 *
		 * This would add the decorator named "decorator1" defined by
		 * "\Aimeos\Client\Html\Common\Decorator\Decorator1" only to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2019.07
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/account/profile/address/decorators/excludes
		 * @see client/html/account/profile/address/decorators/local
		 */

		/** client/html/account/profile/address/decorators/local
		 * Adds a list of local decorators only to the account profile address html client
		 *
		 * Decorators extend the functionality of a class by adding new aspects
		 * (e.g. log what is currently done), executing the methods of the underlying
		 * class only in certain conditions (e.g. only for logged in users) or
		 * modify what is returned to the caller.
		 *
		 * This option allows you to wrap local decorators
		 * ("\Aimeos\Client\Html\Account\Decorator\*") around the html client.
		 *
		 *  client/html/account/profile/address/decorators/local = array( 'decorator2' )
		 *
		 * This would add the decorator named "decorator2" defined by
		 * "\Aimeos\Client\Html\Account\Decorator\Decorator2" only to the html client.
		 *
		 * @param array List of decorator names
		 * @since 2019.07
		 * @category Developer
		 * @see client/html/common/decorators/default
		 * @see client/html/account/profile/address/decorators/excludes
		 * @see client/html/account/profile/address/decorators/global
		 */

		return $this->createSubClient( 'account/profile/address/' . $type, $name );
	}


	/**
	 * Processes the input, e.g. store given values.
	 *
	 * A view must be available and this method doesn't generate any output
	 * besides setting view variables if necessary.
	 */
	public function init()
	{
		$view = $this->getView();

		if( !$view->param( 'address/save' ) && !$view->param( 'address/delete' ) ) {
			return parent::init();
		}

		$cntl = \Aimeos\Controller\Frontend::create( $this->getContext(), 'customer' );
		$addrItems = $cntl->uses( ['customer/address'] )->get()->getAddressItems();
		$cntl->add( $view->param( 'address/payment', [] ) );
		$map = [];

		foreach( $view->param( 'address/delivery/customer.address.id', [] ) as $pos => $id )
		{
			foreach( $view->param( 'address/delivery', [] ) as $key => $list )
			{
				if( array_key_exists( $pos, $list ) ) {
					$map[$pos][$key] = $list[$pos];
				}
			}
		}

		if( $pos = $view->param( 'address/delete' ) ) {
			unset( $map[$pos] );
		}

		foreach( $map as $pos => $data )
		{
			$addrItem = $addrItems->get( $pos ) ?: $cntl->createAddressItem();
			$cntl->addAddressItem( $addrItem->fromArray( $data ), $pos );
			$addrItems->remove( $pos );
		}

		foreach( $addrItems as $addrItem ) {
			$cntl->deleteAddressItem( $addrItem );
		}

		$cntl->store();

		parent::init();
	}


	/**
	 * Sets the necessary parameter values in the view.
	 *
	 * @param \Aimeos\MW\View\Iface $view The view object which generates the HTML output
	 * @param array &$tags Result array for the list of tags that are associated to the output
	 * @param string|null &$expire Result variable for the expiration date of the output (null for no expiry)
	 * @return \Aimeos\MW\View\Iface Modified view object
	 */
	public function data( \Aimeos\MW\View\Iface $view, array &$tags = [], string &$expire = null ) : \Aimeos\MW\View\Iface
	{
		$context = $this->getContext();
		$config = $context->getConfig();
		$cntl = \Aimeos\Controller\Frontend::create( $context, 'customer' );

		/** client/html/common/address/salutations
		 * List of salutions the customers can select from in the HTML frontend
		 *
		 * The following salutations are available:
		 *
		 * * empty string for "unknown"
		 * * company
		 * * mr
		 * * ms
		 *
		 * You can modify the list of salutation codes and remove the ones
		 * which shouldn't be used or add new ones.
		 *
		 * @param array List of available salutation codes
		 * @since 2021.04
		 * @see client/html/account/profile/address/salutations
		 */
		$salutations = $config->get( 'client/html/common/address/salutations', ['', 'company', 'mr', 'ms'] );

		/** client/html/account/profile/address/salutations
		 * List of salutions the customers can select from in their account
		 *
		 * The following salutations are available:
		 *
		 * * empty string for "unknown"
		 * * company
		 * * mr
		 * * ms
		 *
		 * You can modify the list of salutation codes and remove the ones
		 * which shouldn't be used or add new ones.
		 *
		 * @param array List of available salutation codes
		 * @since 2021.04
		 * @see client/html/common/address/salutations
		 */
		$salutations = $config->get( 'client/html/account/profile/address/salutations', $salutations );

		$localeManager = \Aimeos\MShop::create( $context, 'locale' );
		$languages = $localeManager->search( $localeManager->filter( true ) )
			->col( 'locale.languageid', 'locale.languageid' );


		$deliveries = [];
		$addr = $view->profileCustomerItem->getPaymentAddress();

		if( !$addr->getLanguageId() ) {
			$addr->setLanguageId( $context->getLocale()->getLanguageId() );
		}

		$billing = $addr->toArray();
		$billing['string'] = $this->getAddressString( $view, $addr );

		foreach( $view->profileCustomerItem->getAddressItems() as $pos => $address )
		{
			$delivery = $address->toArray();
			$delivery['string'] = $this->getAddressString( $view, $address );
			$deliveries[$pos] = $delivery;
		}


		$view->addressBilling = $billing;
		$view->addressDelivery = $deliveries;
		$view->addressCountries = $view->config( 'client/html/checkout/standard/address/countries', [] );
		$view->addressStates = $view->config( 'client/html/checkout/standard/address/states', [] );
		$view->addressSalutations = $salutations;
		$view->addressLanguages = $languages;

		return parent::data( $view, $tags, $expire );
	}


	/**
	 * Returns the address as string
	 *
	 * @param \Aimeos\MW\View\Iface $view The view object which generates the HTML output
	 * @param \Aimeos\MShop\Common\Item\Address\Iface $addr Order address item
	 * @return string Address as string
	 */
	protected function getAddressString( \Aimeos\MW\View\Iface $view, \Aimeos\MShop\Common\Item\Address\Iface $addr )
	{
		return preg_replace( "/\n+/m", "\n", trim( sprintf(
			/// Address format with company (%1$s), salutation (%2$s), title (%3$s), first name (%4$s), last name (%5$s),
			/// address part one (%6$s, e.g street), address part two (%7$s, e.g house number), address part three (%8$s, e.g additional information),
			/// postal/zip code (%9$s), city (%10$s), state (%11$s), country (%12$s), language (%13$s),
			/// e-mail (%14$s), phone (%15$s), facsimile/telefax (%16$s), web site (%17$s), vatid (%18$s)
			$view->translate( 'client', '%1$s
%2$s %3$s %4$s %5$s
%6$s %7$s
%8$s
%9$s %10$s
%11$s
%12$s
%13$s
%14$s
%15$s
%16$s
%17$s
%18$s
'
			),
			$addr->getCompany(),
			$view->translate( 'mshop/code', (string) $addr->getSalutation() ),
			$addr->getTitle(),
			$addr->getFirstName(),
			$addr->getLastName(),
			$addr->getAddress1(),
			$addr->getAddress2(),
			$addr->getAddress3(),
			$addr->getPostal(),
			$addr->getCity(),
			$addr->getState(),
			$view->translate( 'country', (string) $addr->getCountryId() ),
			$view->translate( 'language', (string) $addr->getLanguageId() ),
			$addr->getEmail(),
			$addr->getTelephone(),
			$addr->getTelefax(),
			$addr->getWebsite(),
			$addr->getVatID()
		) ) );
	}


	/**
	 * Returns the list of sub-client names configured for the client.
	 *
	 * @return array List of HTML client names
	 */
	protected function getSubClientNames() : array
	{
		return $this->getContext()->getConfig()->get( $this->subPartPath, $this->subPartNames );
	}
}
