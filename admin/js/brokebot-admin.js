(function( $ ) {
  "use strict";

  $(document).ready(function() {
    $("select").select2({ width: "resolve" });

    $("#reset-cookies-button").click(function() {
      $(".reset-cookies-field").val(1);

      $("#brokebot-settings-form").submit();
    });

    $("#support_submit_button").click(function() {
		$('#support-message').html('Sending...');
		$.ajax({
			type: "post",
			url: brokebot_ajax.ajax_url,
			data: {
				full_name: $('#full-name').val(),
				email: $('#email').val(),
				subject: $('#subject').val(),
				message: $('#message').val(),
				action: 'submit_support_form'
			},
			success: function(data){				
				$('#support-message').html(data);				
			}
		});
	});
  });
})( jQuery );
