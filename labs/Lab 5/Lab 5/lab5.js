var defaultCommentsText = "Please enter your comments";

function trimValue(value) {
  return value.replace(/^\s+|\s+$/g, "");
}

function clearComments(textarea) {
  if (textarea.value === defaultCommentsText) {
    textarea.value = "";
  }
}

function restoreComments(textarea) {
  if (trimValue(textarea.value) === "") {
    textarea.value = defaultCommentsText;
  }
}

function showNickname() {
  var firstName = trimValue(document.getElementById("firstName").value);
  var lastName = trimValue(document.getElementById("lastName").value);
  var nickname = trimValue(document.getElementById("nickname").value);

  alert(firstName + " " + lastName + " is " + nickname);
}

function validateForm() {
  var firstName = document.getElementById("firstName");
  var lastName = document.getElementById("lastName");
  var email = document.getElementById("email");
  var phone = document.getElementById("phone");
  var nickname = document.getElementById("nickname");
  var comments = document.getElementById("comments");

  if (trimValue(firstName.value) === "") {
    alert("First Name cannot be blank.");
    firstName.focus();
    return false;
  }

  if (trimValue(lastName.value) === "") {
    alert("Last Name cannot be blank.");
    lastName.focus();
    return false;
  }

  if (trimValue(email.value) === "") {
    alert("Email cannot be blank.");
    email.focus();
    return false;
  }

  if (trimValue(phone.value) === "") {
    alert("Phone cannot be blank.");
    phone.focus();
    return false;
  }

  if (trimValue(nickname.value) === "") {
    alert("Nickname cannot be blank.");
    nickname.focus();
    return false;
  }

  if (trimValue(comments.value) === "" || comments.value === defaultCommentsText) {
    alert("Comments cannot be blank.");
    comments.focus();
    return false;
  }

  alert("Form saved successfully.");
  return false;
}

window.onload = function() {
  document.getElementById("firstName").focus();
};