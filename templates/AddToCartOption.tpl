<span id="cart_checkout_btn_top" style="padding-left: 6px;">{$form.add_to_cartcheckout.html}</span>
{literal}
<script type="text/javascript">
  CRM.$(function($) {
    $("#cart_checkout_btn_top").appendTo("div.payment_processor-section div.content").show();

    var hidePayLater = {/literal}"{$cartcheckoutHidePayLater}"{literal};
    if (hidePayLater == '1') {
      $('label[for=CIVICRM_QFID_0_payment_processor_id], input#CIVICRM_QFID_0_payment_processor_id').hide();
    }

    function showHidePaymentMethodOptions(isHide) {
      if (isHide) {
        $("input[name='payment_processor_id']").each(function() {
          var eid = $(this).attr('id');
          $(this).hide();
          $("label[for='" + eid + "']").hide();
        });
      } else {
        $("input[name='payment_processor_id']").each(function() {
          var eid = $(this).attr('id');
          var keepPayLaterHidden = (eid == 'CIVICRM_QFID_0_payment_processor_id' && hidePayLater == '1');
          if (!keepPayLaterHidden) {
            $(this).show();
            $("label[for='" + eid + "']").show();
          }
        });
      }
    }

    // when back button is used, and cart option is selected
    if ($("input[name='add_to_cartcheckout']").is(':checked')) {
      showHidePaymentMethodOptions(1);
      // pay later would already be set behind the scenes
    }

    $("input[name='add_to_cartcheckout']").on('change', function( event ) {
      if ($(this).is(':checked')) {
        showHidePaymentMethodOptions(1);
        // set pay later behind the scene
        $("#CIVICRM_QFID_0_payment_processor_id").prop("checked", true).trigger('change');
      } else {
        $("input[name='payment_processor_id']").each(function() {
          showHidePaymentMethodOptions(0);
          // billing block might already be hidden due to pay later
          // just uncheck the paylater option without trigger('change')
          cj('input[name="payment_processor_id"]').removeProp('checked');
        });
      }
    });

  });
</script>
{/literal}

