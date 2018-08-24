window.onload = start;
var listOfPersons = [];
var asyncRequest;

function start() {
    registerListeners();
    retrievePersonsWithOrder('id');
}

function registerListeners(){
    var addBtn = document.getElementById("add_btn");
    addBtn.addEventListener("click", startNewEventWindow, false);

    var select = document.getElementById("orderOptions");
    select.addEventListener("change", onChangeSelect, false);

}
function startNewEventWindow(){
    window.location.href = "add_person.html";
}
function onChangeSelect(){
    var select = document.getElementById("orderOptions");
    orderBy = select.options[select.selectedIndex].value;
    retrievePersonsWithOrder(orderBy);

}

function retrievePersonsWithOrder(orderBy) {
    try {
        asyncRequest = new XMLHttpRequest();
        asyncRequest.addEventListener("readystatechange", parseData, false);
        asyncRequest.open('GET', 'backend/show_persons.php?orderBy='+orderBy, true);
        asyncRequest.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
        asyncRequest.send();
    }
    catch (exception) {
        alert("Request failed");
        console.log(exception);
    }
}

function parseData() {
    if (asyncRequest.readyState == 4 && asyncRequest.status == 200) {
var remove = asyncRequest.responseText;
console.log(remove);
        var data = JSON.parse(asyncRequest.responseText);
        console.log(data);
        createPersonsTable(data);
    }
}
createPersonsTable = function (persons) {
    var table = document.getElementById('persons_table');
    table.innerHTML = "";

    table.appendChild(createTableHeader());
    for (var i = 0; i < persons.length; i++) {
        var person = persons[i];
        table.appendChild(createRowWithChildren(person));
    }
}
function createTableHeader() {
    var tr = document.createElement('tr');
    tr.appendChild(createHeaderCol("Id"));
    tr.appendChild(createHeaderCol("First Name"));
    tr.appendChild(createHeaderCol("Last Name"));
    tr.appendChild(createHeaderCol("E-mail"));
    tr.appendChild(createHeaderCol("Phone Number"));
    return tr;
}
function createRowWithChildren(person) {
    var tr = document.createElement('tr');
    tr.appendChild(createColumn(person.id));
    tr.appendChild(createColumn(person.firstName));
    tr.appendChild(createColumn(person.lastName));
    tr.appendChild(createColumn(person.email));
    tr.appendChild(createColumn(person.phoneNumber));

    //btns
    tr.appendChild(createColWithBtn
        (person.id, "Change", changeRow));
    tr.appendChild(createColWithBtn
        (person.id, "Delete", deleteRow));
    return tr;
}
function createHeaderCol(str) {
    var th = document.createElement('th');
    th.appendChild(document.createTextNode(str));
    return th;
}
function createColumn(str) {
    var td = document.createElement('td');
    td.appendChild(document.createTextNode(str));
    return td;
}
function createColWithBtn(id, btnStr, callBack) {
    var td = document.createElement('td');
    var btn = document.createElement('button');
    btn.innerHTML = btnStr;
    //btn.setAttribute("id", textForId);
    btn.setAttribute("class", "btnInsideRow");
    td.appendChild(btn);
    btn.addEventListener("click", function () { callBack(id) });
    return td;
}
var delAsyncRequest;
function deleteRow(id) {
    //send to server which to remove this row.
    var param = { "id": id };
    //xhr.send(JSON.stringify(param));

    delAsyncRequest = new XMLHttpRequest();
    delAsyncRequest.addEventListener("readystatechange", affirmDelete, false);
    delAsyncRequest.open("POST", 'backend/delete_person.php', true);
    delAsyncRequest.setRequestHeader("Content-type", "application/json")
    delAsyncRequest.send(JSON.stringify(param));

    //Send the proper header information along with the request
    // xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    //accept true or false
    //if true => remove row from html (how? either by complete update, or by removing tr element)
    //if false => something went wrong try to update whole table why alert("something went wrong while removing row")
}
function affirmDelete() {
    if (delAsyncRequest.readyState == XMLHttpRequest.DONE && delAsyncRequest.status == 200) {
        console.log(delAsyncRequest.responseText);

        //update list => expensive operation, should perhaps just delete one row in list?
        start();
    }
}
function changeRow(contactId) {
    //stores variable as global, it can now be accessed from other html page.
    localStorage["idContact"] = contactId;
    window.location.href = "change_contact.html?id=" + contactId;
}
