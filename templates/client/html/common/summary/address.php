<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2015-2025
 */

/* Available data:
 * - addresses : Order address items
 */


$enc = $this->encoder();

foreach( $this->addresses as $addr )
{
	echo preg_replace( ["/\n+/m", '/ +/'], ['<br>', ' '], trim( $enc->html( sprintf(
		/// Address format with company (%1$s), salutation (%2$s), title (%3$s), first name (%4$s), last name (%5$s),
		/// address part one (%6$s, e.g street), address part two (%7$s, e.g house number), address part three (%8$s, e.g additional information),
		/// postal/zip code (%9$s), city (%10$s), state (%11$s), country (%12$s), language (%13$s),
		/// e-mail (%14$s), phone (%15$s), facsimile/telefax (%16$s), mobile number (%17$s), web site (%18$s), vatid (%19$s)
		$this->translate( 'client', '%1$s
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
%19$s
'
		),
		$addr->getCompany(),
		$this->translate( 'mshop/code', $addr->getSalutation() ),
		$addr->getTitle(),
		$addr->getFirstName(),
		$addr->getLastName(),
		$addr->getAddress1(),
		$addr->getAddress2(),
		$addr->getAddress3(),
		$addr->getPostal(),
		$addr->getCity(),
		$addr->getState(),
		$this->translate( 'country', $addr->getCountryId() ),
		$this->translate( 'language', $addr->getLanguageId() ),
		$addr->getEmail(),
		$addr->getTelephone(),
		$addr->getTelefax(),
		$addr->getMobile(),
		$addr->getWebsite(),
		$addr->getVatID()
	) ) ) );
}
