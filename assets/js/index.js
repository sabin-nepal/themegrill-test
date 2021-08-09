jQuery( document ).ready( function() {
    //filter
    jQuery( '#tgt-order, #latest' ).on( 'change', function() {
        var value = jQuery( '#tgt-order' ).val();
        var latest = jQuery( '#latest' ).is(":checked");
        jQuery('#tgt-reviews #tgt-loop').hide();
        jQuery('.tgt-loader').show();
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
                jQuery( '#tgt-reviews' ).html( data );
                jQuery('#tgt-reviews #tgt-loop').show();
                jQuery('.tgt-loader').hide();
              }
        })
    });
    //pagination
    jQuery('body').on( 'click', '#paginationAjax .pagination', function(e) {
        e.preventDefault();
        var value = jQuery(this).attr('value');
        var latest = jQuery( '#latest' ).is(":checked");
        jQuery('#tgt-reviews #tgt-loop').hide();
        jQuery('.tgt-loader').show();
        jQuery.ajax({
            url: myAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'tgt_pagination',
                nonce: myAjax.nonce,
                page: value,
                latest: latest,
            },
            success: function( data ){
                jQuery( '#tgt-loop' ).html( data );
                jQuery('#tgt-reviews #tgt-loop').show();
                jQuery('.tgt-loader').hide();
              }
        })
    });
} );