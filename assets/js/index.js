jQuery( document ).ready( function() {
    //filter
    jQuery( '#tgt-order' ).on( 'change', function() {
        var value = jQuery( '#tgt-order' ).val();
        var latest = jQuery( '#latest' ).is(":checked");
        jQuery.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'tgt_rating_filter',
                nonce: myAjax.nonce,
                rating: value,
                latest: latest
            },
            success: function( data ){

                jQuery( '#tgt-loop' ).html( data );
              }
        })
    });
    //latest
    jQuery( '#latest' ).on( 'click', function() {
        var latest = jQuery( '#latest' ).is(':checked');
        var rating = jQuery( '#tgt-order' ).val();
        jQuery.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'tgt_rating_filter',
                nonce: myAjax.nonce,
                rating: rating,
                latest: latest,
            },
            success: function( data ){

                jQuery( '#tgt-loop' ).html( data );
              }
        })
    });
    //pagination
    jQuery( '#paginationAjax' ).on( 'click', '.pagination', function(e) {
        e.preventDefault();
        var value = jQuery(this).attr('value');
        jQuery.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'tgt_pagination',
                nonce: myAjax.nonce,
                page: value
            },
            success: function( data ){
                //jQuery(this).addClass('active');
                jQuery( '#tgt-loop' ).html( data );
              }
        })
    });
} );