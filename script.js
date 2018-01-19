//Global variable
var g = {};

/*
* Remove events from an element
*/
function removeEvent(obj, type, fnName){
    if (obj.removeEventListener) {
        obj.removeEventListener(type, fnName);
    } 
    else if (obj.detachEvent) {
        obj.detachEvent(type, fnName);
    }
    else{
        alert("Browser not compatible with application");   
    }
}

/*
* Add events to an element
*/
function addEvent(obj, type, fnName){

    if(obj.addEventListener){
        obj.addEventListener(type, fnName, false);
    }   
    else if(obj.attachEvent){
        obj.attachEvent("on" + type, fnName);
    }
    else{
        alert("Browser not compatible with application");
    }   
}

/*
* Creates an XML http request
*/
function createRequestObject(){
    if (window.XMLHttpRequest) 
    {
        g.request = new XMLHttpRequest();
    } 
    else 
    {
        g.request = new ActiveXObject();
    }
}


/*
* Function called when creating a sticky note
* Invoked when clicking on the create button
*/
function createStickyNote(e){
	var content = $.trim($("#noteTextArea").val());
	
	if(content != ""){ //Check not empty
        if(content.length <= 250){ //Check that smaller than 250 character long
            //Requesting to create note in database and display
			createRequestObject();
            serverRequestCreate(getParamsCreate(content), true);
        }
        else
			$("#errorMsgCreate").text("Maximum 250 characters");
    }
    else{
        $("#errorMsgCreate").text("Please write something down");
    }
}

/*
* Function called when deleting a sticky note
* Invoked when clicking on the x button on the top right of each note
*/
function deleteStickyNote(e){
    var evt = e || window.Event;
    var target = evt.target || evt.srcElement;
    var id = target.id;
	
	//Request to delete note from database and hide it
    createRequestObject();
    serverRequestDelete(getParamsDelete(id), true);
}

/*
* Function called when registering a user, does validation
* Invoked when clicking on the register button
*/
function register(e){
    var username = $.trim($('#registerUsername').val());
    var password = $.trim($('#registerPassword').val());
    var password2 = $.trim($('#registerPassword2').val());
	
	//Check not empty
    if(username != "" && password != "" && password2 != ""){
        var isValid = true;
        var errMsg;
		
		//Check confirmation matches the password
        if(password2 != password){ 
           errMsg = "Passwords do not match";
           isValid = false; 
        }
		
		//Check password is greater than 8 char long
        if(password.length < 8){
           errMsg = "Password must be atleast 8 characters";
           isValid = false; 
        }
		
		//Check username is greater than 5 and under 25 char long
        if(username.length > 25 || username.length < 5){
            errMsg = "Username must be atleast 5 characters and less than 25";
            isValid = false;
        }
		
		//Checks that everything was valid
        if(isValid){
			//Create server request, store new user in database
            createRequestObject();
            serverRequestRegister(getParamsUser(username, password), true);
        }
        else{
            $("#errorMsgRegister").text(errMsg);
        }
    }
    else{
        $("#errorMsgRegister").text("You left a field empty");
    }
}

/*
* Function called when attempting to login as a specific user, does validation
* Invoked when clicking on the login button
*/
function login(e){
    var username = $.trim($('#loginUsername').val());
    var password = $.trim($('#loginPassword').val());

    var isValid = true;
    var errMsg;

	//Check that password is not empty
    if(password == ""){
        errMsg = "You left the password field empty";
        isValid = false;
    }

	//Check that username is not empty
    if(username == ""){
        errMsg = "You left the username field empty";
        isValid = false;
    }

	//Check everything was valid
    if(isValid){
		//Create a server request for login
        createRequestObject();
        serverRequestLogin(getParamsUser(username, password), true);
    }
    else{
        $("#errorMsgLogin").text(errMsg);
    }
}

/*
* Function invoked when logging out of the session
* Invoked when clicking on the logout anchor
*/
function logout(e){
	//Create a server request for logout
    createRequestObject();
    serverRequestLogout(true);
}


/*
* Function invoked when dragging a note to another position
*/
function modifyStickyNote(noteId, positionX, positionY){
	//Create a server request for modifying
    createRequestObject();
    serverRequestModify(getParamsModify(noteId, positionX, positionY), true);
}


/*
* Get parameters (key-value pairs) needed for a create server request
*/
function getParamsCreate(content){
	return "content=" + content;
}

/*
* Get parameters (key-value pairs) needed for a delete server request
*/
function getParamsDelete(noteId){
    return "noteId=" + noteId;
}

/*
* Get parameters (key-value pairs) needed for a delete server request
*/
function getParamsModify(noteId, positionX, positionY){
    return "noteId=" + noteId + "&positionX=" + positionX + "&positionY=" + positionY;
}

/*
* Get parameters (key-value pairs) needed for user related server requests
*/
function getParamsUser(username, password){
    return "username=" + username + "&password=" + password;
}

/*
* Create server request for creating a note
*/
function serverRequestCreate(params, async){
    g.request.open("POST", "createStickyNote.php", async);
    g.request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    g.request.onreadystatechange = processServerDataAdd;
    g.request.send(params);
}

/*
* Create server request for retrieving the notes of a user
*/
function serverRequestRetrieve(async){
    g.request.open("POST", "retrieveUserStickyNotes.php", async);
    g.request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    g.request.onreadystatechange = processServerData;
    g.request.send();
}

/*
* Create server request for deleting a note
*/
function serverRequestDelete(params, async){
    g.request.open("POST", "deleteStickyNote.php", async);
    g.request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    g.request.onreadystatechange = processServerDataDelete;
    g.request.send(params);
}

/*
* Create server request for when modifying position of a note
*/
function serverRequestModify(params, async){
    g.request.open("POST", "modifyStickyNote.php", async);
    g.request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    g.request.send(params);
}

/*
* Create server request for when user attempts to register
*/
function serverRequestRegister(params, async){
    g.request.open("POST", "registerUser.php", async);
    g.request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    g.request.onreadystatechange = processServerDataRegister;
    g.request.send(params);
}

/*
* Create server request when user tries and login
*/
function serverRequestLogin(params, async){
    g.request.open("POST", "userLogin.php", async);
    g.request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    g.request.onreadystatechange = processServerDataLogin;
    g.request.send(params);
}

/*
* Create server request when a user logs out
*/
function serverRequestLogout(async){
    g.request.open("POST", "userLogout.php", async);
    g.request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    g.request.onreadystatechange = processServerDataLogout;
    g.request.send();
}

/*
* Process server data for when retrieving notes and creating a single note
*/
function processServerDataAdd(){
	var response;

    if(g.request.readyState == 4 && g.request.status == 200){
		//Hides the pop-up form, in bootstrap modal is a a pop-up
        $('#createStickyNoteModal').modal('hide');
        response = g.request.responseText;
		//Parse into JSON
        g.json = JSON.parse(response);
		$("#stickyNoteArea").empty();
		displayStickyNote();
    }
}

/*
* Process server data for when retrieving notes and creating a single note
*/
function processServerData(){
	var response;

    if(g.request.readyState == 4 && g.request.status == 200){
		//Hides the pop-up form, in bootstrap modal is a a pop-up
        $('#createStickyNoteModal').modal('hide');
        response = g.request.responseText;
		//Parse into JSON
        g.json = JSON.parse(response);
		displayStickyNote();
    }
}

/*
* Process server data for when deleting a note
*/
function processServerDataDelete(){
    var response;
    
	//checks ready state is ready and status is OK
    if(g.request.readyState == 4 && g.request.status == 200){
		//Response contains the note id of the deleted id
        response = g.request.responseText;
		
		if(response != -1){
			$("#stickyNoteArea").empty();
			retrieveUserStickyNotes();
		}	
    }
}

/*
* Process server data for when user registers
*/
function processServerDataRegister(){
    var response;
    
	//checks ready state is ready and status is OK
    if(g.request.readyState == 4 && g.request.status == 200){
		//response will be the note id or either a 0
		//0 = invalid username
        response = g.request.responseText;
		
        if(response == 0){ //represents that username is invalid, already in use
            $("#errorMsgRegister").text("Username already in use");
        }
        else{
			//hides the pop-up register form
            $('#registerModal').modal('hide');
        }
    }
}

/*
* Process server data for when logging in
*/
function processServerDataLogin(){
    var response;
    
	//checks ready state is ready and status is OK
    if(g.request.readyState == 4 && g.request.status == 200){
		//Response will be a status code
		//0 -> User does not exist
		//1 -> Password is wrong
		//2 -> First initial message when user exceeds password attempting
		//3 -> Password is right, but displays that account is blocked
		//4 -> represents that login is successful
        response = g.request.responseText;

        switch (response) {
            case '0':
                $("#errorMsgLogin").text("Username does not exist");
                break;
            case '1':
                $("#errorMsgLogin").text("Password is wrong");
                break;
            case '2':
                $("#errorMsgLogin").text("Too many bad attempts, please try again in 30 minutes");
                break;   
            case '3':
                $("#errorMsgLogin").text("Account has been timed out for a certain time");
                break;
            case '4':
				//refresh the page
                location.reload();
                break;
        }
    }    
}

/*
* Process server data for when logging out
*/
function processServerDataLogout(){
	var response;
	
	//checks ready state is ready and status is OK
    if(g.request.readyState == 4 && g.request.status == 200){
		//refresh the page
        location.reload();
    }
}

/*
* Display the sticky notes onto the screen
*/
function displayStickyNote(){
		//Loop through all the notes in the JSON response
        for(var cntr = 0; cntr < g.json.length; cntr++){
            var noteId = g.json[cntr].noteId;
			
			//Creates the div for one sticky note
            var stickyNote = "<div id=\"" + noteId + "\" class=\"stickyNote\"> " +
                                "<a id=\"" + noteId + "\" class=\"deleteButton\">x</a> " +
                                "<br> " +
                                "<div class=\"noteContent\"> " +
                                    "<p>" + g.json[cntr].contents + "</p> " +
                                "</div> " +
                             "</div>";

            //Append to div that contains all the sticky notes
			$("#stickyNoteArea").append(stickyNote);
			
			//Style the sticky note
			$("#" + noteId).css({'position' : "absolute",
							  'left' : g.json[cntr].positionX +'px',
							  'top' : g.json[cntr].positionY +'px',
							  'zIndex' : noteId
							});
        }
		//Add events to make the sticky notes functional
        makeNotesDraggable();
        addDeleteEvent();
}

/*
* Makes the notes draggable
* In addition adds the listener for when user invokes a mouse up,
* which saves the new coordinates in the database for the particular note
*/
function makeNotesDraggable(){
    $('.stickyNote').draggable({ containment:'window' });
    $('.stickyNote').mouseup(function(){
        var noteId = $(this).attr('id');
        var positionX = $('#' + noteId).offset().left;
        var positionY = $('#' + noteId).offset().top;
		
        modifyStickyNote(noteId, positionX, positionY);
    });
}

/*
* Create a server request to retrieve the user's sticky notes
*/
function retrieveUserStickyNotes(){
    createRequestObject();
    serverRequestRetrieve(true);
}

/*
* Adds the delete events onto all the elements with the class name
* "deleteButton" which will be triggered by a mouse click
*/
function addDeleteEvent(){
    g.deleteButtons = document.getElementsByClassName('deleteButton');
    for(var cntr = 0; cntr < g.deleteButtons.length; cntr++) {
        addEvent(g.deleteButtons[cntr], "click", deleteStickyNote);
    }
}

/*
* Resets the text fields of forms and removes previous error messages
* when they are closed
*/
function resetFormWhenClosed(){
    $('.modal').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
        $(".errMsg").text("");
    });
}

/*
* Takes care of adding the necessary functionality to each button
* and anchors
*/
function addNecessaryEvents(){
	//Get all buttons and necessary anchors
    g.submitButton = document.getElementById('submitButton');
    g.registerButton = document.getElementById('registerButton');
    g.loginButton = document.getElementById('loginButton');
    g.logoutAnchor = document.getElementById('logoutAnchor');

	//Adding events to the buttons
    addEvent(g.submitButton, "click", createStickyNote);
    addEvent(g.registerButton, "click", register);
    addEvent(g.loginButton, "click", login);
    addEvent(g.logoutAnchor, "click", logout);
}

/*
* Function that is first run when the webpage loads up.
* Initializes everything that is needed
*/
function init(){
	addNecessaryEvents();
	resetFormWhenClosed();
    retrieveUserStickyNotes();
}

window.onload = init;