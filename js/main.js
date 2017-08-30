/* Developed by Juno_okyo */
jQuery(document).ready(function($) {
  const $messages = $('#messages');
  const $count = $('#count');
  
  $messages.on('click', '.close', function(event) {
    // event.preventDefault();

    let $this = $(this);

    swal({
      title: 'Are you sure?',
      text: 'You will not be able to recover this message!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Yes, delete it!',
      closeOnConfirm: true
    }, function() {
      let id = $this.data('id');
      $.ajax({
        url: 'ajax.php?action=delete',
        type: 'POST',
        dataType: 'json',
        data: {
          id: id
        }
      }).done(function(json) {
        if (json.success) {
          // Update counter
          $count.text(parseInt($count.text()) - 1);

          // Remove message from page
          $('#message-' + id).fadeOut('fast', function() {
            $(this).remove();

            if (parseInt($count.text()) === 0) {
              $messages.parent().text('There are no messages yet.');
            }
          });
        } else {
          sweetAlert('Oops...', 'Something went wrong!', 'error');
        }
      }).fail(function() {
        sweetAlert('Oops...', 'Something went wrong!', 'error');
      });
    });
  });
});