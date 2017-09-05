/* Developed by Juno_okyo */
function getPath() {
  let url = new URL(window.top.location.href),
    arr = url.pathname.split('/');

  arr.pop(); // remove the last item
  return url.origin + arr.join('/') + '/';
}

jQuery(document).ready(function($) {
  const $messages = $('#messages');
  const $count = $('#count');
  const $modal = $('#modal-share');
  const $currentMessageId = $('#current_message_id');
  const $formShare = $('#form-share');
  const $caption = $('#caption');
  const $btnShare = $('#btn-share');

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

  $messages.on('click', '.btn-share', function(event) {
    // event.preventDefault();

    let $this = $(this);
    $currentMessageId.val($this.data('id'));
    $modal.modal('toggle');
  });

  $formShare.submit(function(event) {
    event.preventDefault();

    $btnShare.button('loading');

    $.ajax({
      url: 'ajax.php?action=share',
      type: 'POST',
      dataType: 'json',
      data: {
        id: $currentMessageId.val(),
        caption: $caption.val(),
        path: getPath()
      },
    }).done(function(json) {
      if (json.success && json.id) {
        window.top.location.href = 'https://www.facebook.com/' + json.id;
      } else {
        sweetAlert('Oops...', 'Something went wrong!', 'error');
      }
    }).fail(function() {
      sweetAlert('Oops...', 'Something went wrong!', 'error');
    }).always(function() {
      $btnShare.button('reset');
    });
  });

  $modal.on('shown.bs.modal', function() {
    $caption.val('').focus();
  });
});