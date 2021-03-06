window.onload = registerListeners;

function registerListeners() {
  var addBtn = document.getElementById("add_btn");
  addBtn.addEventListener("click", startNewEventWindow, false);

  var select = document.getElementById("orderOptions");
  select.addEventListener("change", onChangeSelect, false);

  //change button
  var changeBtns = document.getElementsByClassName("changeBtn");

  //we are dealing with an Arraylike object here (and not a normal array)
  Array.prototype.forEach.call(changeBtns, btn => {
    btn.addEventListener("click", changeBtnClicked, false);
  });

  //delete button
  var deleteBtns = document.getElementsByClassName("deleteBtn");
  Array.prototype.forEach.call(deleteBtns, btn => {
    btn.addEventListener("click", deleteBtnClicked, false);
  });
}

function startNewEventWindow() {
  window.location.href = "contact_data.php";
}

function onChangeSelect() {
  var select = document.getElementById("orderOptions");
  var orderBy = select.options[select.selectedIndex].value;
  //var orderBy evt.target.options[select.selectedIndex].value;
  window.location.href = "show_contacts.php?orderBy=" + orderBy;
}

function changeBtnClicked(evt) {
  var btnId = evt.target.id;
  var contactId = getContactIdFromBtn(btnId);
  window.location.href = "contact_data.php?id=" + contactId;
}

function deleteBtnClicked(evt) {
  var btnId = evt.target.id;
  var contactId = getContactIdFromBtn(btnId);
  window.location.href = "backend/delete_contact.php?id=" + contactId;
}
//somestring_12 -> 12
function getContactIdFromBtn(btnId) {
  return btnId.split('_')[1];
}
