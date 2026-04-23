const form = document.querySelector('#guestbookForm');
const wall = document.querySelector('#guestbookWall');
const statusBox = document.querySelector('#pageStatus');
const nameError = document.querySelector('#nameError');
const commentError = document.querySelector('#commentError');
const commentField = document.querySelector('#comment_text');
const commentCount = document.querySelector('#commentCount');
const submitButton = document.querySelector('#submitButton');

function setFieldError(element, message) {
  element.textContent = message;
  element.hidden = message === '';
}

function setStatus(message, type) {
  statusBox.textContent = message;
  statusBox.hidden = message === '';
  statusBox.className = type ? `status status--${type}` : 'status';
}

function updateCommentCount() {
  commentCount.textContent = String(commentField.value.length);
}

function clearErrors() {
  setFieldError(nameError, '');
  setFieldError(commentError, '');
}

updateCommentCount();
commentField.addEventListener('input', updateCommentCount);

form.addEventListener('submit', async (event) => {
  event.preventDefault();
  clearErrors();
  setStatus('', '');
  submitButton.disabled = true;
  submitButton.textContent = 'Posting...';

  try {
    const response = await fetch(form.action, {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: new FormData(form),
    });

    const data = await response.json();

    if (!response.ok) {
      if (data.errors) {
        setFieldError(nameError, data.errors.visitor_name || '');
        setFieldError(commentError, data.errors.comment_text || '');
      }

      setStatus(data.message || 'Something went wrong.', 'error');
      return;
    }

    const emptyState = wall.querySelector('.empty-state');

    if (emptyState) {
      emptyState.remove();
    }

    wall.insertAdjacentHTML('afterbegin', data.entryHtml);
    setStatus(data.message || 'Message posted.', 'success');
    form.reset();
    updateCommentCount();
    document.querySelector('#visitor_name').focus();
  } catch (error) {
    setStatus('Network error. Please try again.', 'error');
  } finally {
    submitButton.disabled = false;
    submitButton.textContent = 'Post Message';
  }
});
