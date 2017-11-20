(function ($) {
    var handler = StripeCheckout.configure({
        key: key, //'pk_test_rWrMX5GKwDUzMd8zYAohdZHi',
        image: image, //'https://stripe.com/img/documentation/checkout/marketplace.png',
        locale: locale, //'auto',
        token: function(token) {
            // You can access the token ID with `token.id`.
            // Get the token ID to your server-side code for use.
            $('#customStripeForm')
                .append($('<input>')
                .attr({ type: 'hidden', name: 'StripeForm[source]', value: token.id }))
                .submit();
        }
    });

    document.getElementById('customButton').addEventListener('click', function(e) {
        // Open Checkout with further options:
        handler.open({
            name: name, //'Demo Site',
            description: description, //'2 widgets',
            amount: amount //2000
        });
        e.preventDefault();
    });

    // Close Checkout on page navigation:
    window.addEventListener('popstate', function() {
        handler.close();
    });
})(jQuery);