<?php

/*=======================================================
=            Manual changing the ACF backend            =
=======================================================*/



add_filter( 'gettext', 'wpse_change_error_string', 10, 3 );

function wpse_change_error_string( $translation, $text, $domain ) {
    // The 'default' text domain is reserved for the WP core. If no text domain
    // is passed to a gettext function, the 'default' domain will be used.

    /*
    Template for translating a sentence:

    if ( 'acf' === $domain && 'Old text' === $text ) {
        $translation = "New text";
    }
    

    */

	

	if($lang = (get_option('wplang')) == 'da_DK' ):
	  	/*----------  General  ----------*/

	  	if ( 'acf' === $domain && 'Validation failed' === $text ) {
	  	    $translation = "Fejl i indhold";
	  	}
	  
	  	if ( 'acf' === $domain && '%d fields require attention' === $text ) {
	  	    $translation = "%d felter har fejl";
	  	}
	  	if ( 'acf' === $domain && '1 field requires attention' === $text ) {
	  	    $translation = "1 felt har fejl";
	  	}
	  	/*----------  File  ----------*/

	    if ( 'acf' === $domain && 'No file selected' === $text ) {
	        $translation = "Ingen fil valgt";
	    }

	    if ( 'acf' === $domain && 'Add File' === $text ) {
	        $translation = "Vælg fil";
	    }

	    /*----------  Link  ----------*/

	    if ( 'acf' === $domain && 'Select Link' === $text ) {
	        $translation = "Indsæt link";
	    }

	    /*----------  Relationship  ----------*/
	    
	    if ( 'acf' === $domain && 'Select taxonomy' === $text ) {
	        $translation = "Vælg kategori";
	    }
	    if ( 'acf' === $domain && 'Search...' === $text ) {
	        $translation = "Søg...";
	    }
	    if ( 'acf' === $domain && 'Select post type' === $text ) {
	        $translation = "Vælg indholdstype";
	    }


	    /*----------  oEmbed  ----------*/
	    if ( 'acf' === $domain && 'Enter URL' === $text ) {
	        $translation = "Indsæt URL";
	    }


	    /*----------  Time  ----------*/

	    if ( 'acf' === $domain && 'Choose Time' === $text ) {
	        $translation = "Vælg tidspunkt";
	    }

	    /*----------  Repeater  ----------*/
		if ( 'acf' === $domain && 'Add row' === $text ) {
	        $translation = 'Tilføj række';
	    }
	    if ( 'acf' === $domain && 'Remove row' === $text ) {
            $translation = 'Slet række';
        }
	    if ( 'acf' === $domain && 'Drag to reorder' === $text ) {
            $translation = 'Træk for at ændre rækkefølge';
        }


	    /*----------  Image  ----------*/
	    
	    if ( 'acf' === $domain && 'No image selected' === $text ) {
	        $translation = "Intet billede valgt";
	    }

	    if ( 'acf' === $domain && 'Add Image' === $text ) {
	        $translation = "Tilføj billede";
	    }
		if ( 'acf' === $domain && 'Edit' === $text ) {
            $translation = 'Rediger';
        }

	    /*----------  Gallery  ----------*/
	    
		if ( 'acf' === $domain && 'Add to gallery' === $text ) {
            $translation = "Tilføj til galleriet";
        }

        /*----------  Flexible content  ----------*/
		if ( 'acf' === $domain && 'Click the "%s" button below to start creating your layout' === $text ) {
            $translation = 'Klik på "%s" knappen for at begynde at bygge din side';
        }

		if ( 'acf' === $domain && 'Remove layout' === $text ) {
            $translation = 'Slet sektion';
        }

		if ( 'acf' === $domain && 'Are you sure?' === $text ) {
            $translation = 'Er du sikker?';
        }

		if ( 'acf' === $domain && 'Remove' === $text ) {
            $translation = 'Slet';
        }

		if ( 'acf' === $domain && 'Cancel' === $text ) {
            $translation = 'Annuller';
        }

		if ( 'acf' === $domain && 'Add layout' === $text ) {
            $translation = 'Tilføj sektion';
        }
		if ( 'acf' === $domain && 'Click to toggle' === $text ) {
            $translation = 'Klik for at folde';
        }

    endif;

    return $translation;
}