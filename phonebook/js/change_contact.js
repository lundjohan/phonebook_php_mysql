var asyncRequest;
window.onload = fillFormWithData;

function fillFormWithData() {
  //id = localStorage["idContact"];
  id = retrieveId();

  //set id as a hidden value. This will later be used to send id to backend via html form.
  document.getElementsByName("id")[0].value = id;

  //retrieve data from database by using id
  try {
    asyncRequest = new XMLHttpRequest();
    asyncRequest.addEventListener("readystatechange", retrieveForm, false);
    asyncRequest.open('GET', 'backend/show_contact.php?id=' + id, true);
    asyncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    asyncRequest.send();
  } catch (exception) {
    alert("Request failed");
    console.log(exception);
  }
}

function retrieveId() {
  return localStorage["idContact"];
}

function retrieveForm() {
  if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
    var data = asyncRequest.responseText;
    var parsed;
    try {
      parsed = JSON.parse(data);
    } catch (e) {
      console.log("failed asyncRequest.responseText: " + data);
      console.log(e);
    }
    fillFormWithContact(parsed);
  }
}

function fillFormWithContact(contact) {
  document.getElementsByName("first_name")[0].value = contact.first_name;
  document.getElementsByName("last_name")[0].value = contact.last_name;
  document.getElementsByName("e_mail")[0].value = contact.email_address;
  document.getElementsByName("phone_nr")[0].value = contact.phone_number;
}

function addListeners() {
  document.getElementsByName("submit")[0].addEventListener("click", submitUpdateForm, false);
}
