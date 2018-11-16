<div id="getTrialModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Get trial</h4>
            </div>
            <div class="modal-body">
                <p>You must have an active PayPal Billing Agreement to get a free trial.
                    <br><br>
                    Please press 'OK' to be redirected to the PayPal Billing Agreement sign up page,
                    or press 'Cancel' to go back to your cart.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="{$baseUrl}paypalbilling.php?redirectToCart=1" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>
<div id="getTrialModalForUnathorized" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Get trial</h4>
            </div>
            <div class="modal-body">
                <p>Please login to get your free trial. If you do not have an account with us,
                    please <a href="{$baseUrl}register.php?redirectToCartAfterLogin=1">create an account</a> to continue with your free trial.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="{$baseUrl}register.php?redirectToCartAfterLogin=1" class="btn btn-success">Sign Up</a>
                <a href="{$baseUrl}clientarea.php?redirectToCartAfterLogin=1" class="btn btn-primary">Log In</a>
            </div>
        </div>
    </div>
</div>