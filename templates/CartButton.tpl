<span id="cart_checkout_btn_bottom" class="crm-button">{ts}Add to Cart{/ts}</span>
<span id="cart_checkout_btn_top" class="crm-button">{ts}Add to Cart{/ts}</span>
{literal}
<script type="text/javascript">
  CRM.$(function($) {
    //buildPaymentBlock(0);
    $("#cart_checkout_btn_bottom").appendTo("#crm-submit-buttons");
    $("#cart_checkout_btn_top").appendTo("div.payment_processor-section div.content");

    // when back button is used for a cart method
    if ($("input[name='add_to_cartcheckout']").val()) {
      // if back button is used, unset payment method, so user could re-select a different
      // method if required. Or continue again with cart.
      $('input[name="payment_processor_id"]').removeProp('checked');
      // unset hidden value, so if other method is used, we don't add to Cart
      $("input[name='add_to_cartcheckout']").val('');
    }

    // cart button clicked
    $("#cart_checkout_btn_bottom, #cart_checkout_btn_top").click(function( event ) {
      // hide payment method block
      showHidePayment(1);
      // set pay later
      $("#CIVICRM_QFID_0_payment_processor_id").prop("checked", true);
      // set cart method for hidden field
      $("input[name='add_to_cartcheckout']").val(1);
      // submit form
      //$("form[id='formId'").submit();
      $("#crm-submit-buttons").closest("form").submit();
    });
  });
</script>
{/literal}

