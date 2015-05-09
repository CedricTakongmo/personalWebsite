<?php
/**
 * @package     Donate Elite
 * @subpackage  mod_donate_elite
 * @copyright   Copyright (C) 2013 Elite Developers All rights reserved.
 * @license   	GNU/GPL v3 http://www.gnu.org/licenses/gpl.html
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

	$doncd = '<div align="center">' ;

	$langSite = substr($params->get( 'locale' ) , 0 , 2 );
	if ( $langSite != '' ) {
		$langSite .= '/' ; 
	}
	
	$introtext = '' ;
	if ( $params->get( 'show_text' , 1 ) ) {
		$introtext = '<p>' . $params->get( 'intro_text' , '' ) . '</p>' . "\n" ;
	}
	$doncd .= "\n" ;
	$amountLine = '' ;
	if ( !$params->get( 'show_amount' ) ) {
		$amountLine .= '<input type="hidden" name="amount" value="' . $params->get( 'amount' ) . '" />' . "\n" ; 
	} else {
		$amountLine .= JText::_( '' ) . '<input type="text" name="amount" placeholder="Amount" class="input-mini" maxlength="6" value="' . $params->get( 'amount' ) . '" style="text-align:right;" />' . "\n" ; 
	}
	$currencies = explode( ',' , $params->get( 'currencies' ) );
	$availableCurrencies = Array( 'EUR' , 'USD' , 'GBP' , 'CHF' , 'AUD' , 'HKD' , 'CAD' , 'JPY' , 'NZD' , 'SGD' , 'SEK' , 'DKK' , 'PLN' , 'NOK' , 'HUF' , 'CZK' , 'ILS' , 'MXN' );
	$sizeOfCurr = sizeof( $currencies );
	for ( $i = 0 ; $i < $sizeOfCurr ; $i++ ) {
		for ( $j = 0; $j < sizeof( $availableCurrencies ); $j++ ) {
			if ( $currencies[$i] === $availableCurrencies[$j] ) { 
				$isOk = 1 ;
				break ;
			}	
		}
		if ( !$isOk ) {
			unset( $currencies[$i] );
		}
		$isOk = 0;
	}
	if ( sizeof( $currencies ) == 0 ) {
		$amountLine = '<p class="error">' . JText::_('Error - no currencies selected!') . '<br/>' . JText::_('Please check the backend parameters!') . '</p>' ;
		$fe_c = '' ;
	} 
	else if ( sizeof( $currencies ) == 1 ) {
		$doncd .= $introtext ;
		$fe_c = '<input type="hidden" name="currency_code" class="input-small" value="' . $currencies[0] . '" />' . "\n" ;
		if ( $params->get( 'show_amount' , 1 ) ) {
			$fe_c .= '&nbsp;' . $currencies[0] . "\n" ;
		}
	} 
	else if ( sizeof( $currencies ) > 1 ) {
		$doncd .= $introtext ;
		if ( $params->get( 'show_amount' , 1 ) ) { 
			$fe_c = '<select name="currency_code" class="input-small">' . "\n" ;
			foreach( $currencies as $row ) {
				$fe_c .= '<option value="' . $row . '">' . $row . '</option>' . "\n" ;	
			}
			$fe_c .= '</select>' . "\n" ;
		} 
		else {
			$fe_c = '<input type="hidden" name="currency_code" class="input-small" value="' . $currencies[0] . '" />' . "\n" ;	
		}
	}
	$target = '' ;
	if ( $params->get( 'open_new_window' , 1 ) ) {
		$target = 'target="paypal"' ;
	}
	$sabx = '' ;
	$busn = '' ;
	if ( $params->get( 'use_sandbox' , 1 ) ) {
		$sabx = '.sandbox' ;
		$busn = $params->get( 'sandbox' , '' ) ;
	} 
	else {
		$busn = $params->get( 'business' , '' ) ;
	}
	$doncd .= '<form action="https://www' . $sabx . '.paypal.com/' . $langSite . 'cgi-bin/webscr" method="post" ' . $target . '>'
	. '<input type="hidden" name="cmd" value="_donations" />'
	. '<input type="hidden" name="business" value="' . $busn . '" />'
	. '<input type="hidden" name="return" value="' . ( $params->get( 'return' , '' ) ) . '" />'
	. '<input type="hidden" name="undefined_quantity" value="0" />'
	. '<input type="hidden" name="item_name" value="' . ( $params-> get( 'item_name' , '' ) ) . '" />' ;
	$doncd .= $amountLine . $fe_c ;
	$doncd .= '<input type="hidden" name="charset" value="utf-8" />'
	. '<input type="hidden" name="no_shipping" value="1" />'
	. '<input type="hidden" name="image_url" value="' . ( $params->get( 'image_url' , '' ) ) . '" />'
	. '<input type="hidden" name="cancel_return" value="' . ( $params->get( 'cancel_return' , '' )) . '" />'
	. '<input type="hidden" name="no_note" value="0" /><br /><br />' ;
	if ( $fe_c != '' ) {
		$doncd .= '<input type="image" src="http://www.paypal.com/' . $params->get( 'locale' ) . '/i/btn/' . $params->get( 'pp_image' ) . '" name="submit" alt="PayPal secure payments." />' ;
	}
	$doncd .= '</form></div>' ;
	if ( $moduleclass_sfx ) {
		$doncd = '<div class="ads' . $moduleclass_sfx . '">' . $doncd . '</div>' ;
	}
	echo $doncd ;
?>