"use strict";

function verifCo()
{
	var valid=true;
	if(document.getElementById("login").value == "")
	{
		document.connexion.login.placeholder = "login incorrect.";
		document.connexion.login.style.backgroundColor = "pink";
		/*document.connexion.login.style.borderColor = "red";*/
		valid=false;
	}
	if(!(/[a-zA-Z0-9_]{4,}/).test(connexion.login.value))
	{
		document.connexion.login.value = "";
		document.connexion.login.placeholder = "4 caracteres minimum";
		document.connexion.login.style.backgroundColor = "pink";
		valid=false;
	}
	if(document.getElementById("password").value == "")
	{
		document.connexion.password.placeholder = "saisie incorrecte";
		document.connexion.password.style.backgroundColor = "pink";
		valid=false;
	}
	if(!(/[a-zA-Z0-9@\.;:!_\-^<>`]{6,}/).test(connexion.password.value))
	{
		document.connexion.password.value = "";
		document.connexion.password.placeholder = "6 caracteres minimum";
		document.connexion.password.style.backgroundColor = "pink";
		valid=false;
	}
	return valid;
}

var form = document.getElementById("connexionForm");

form.onsubmit = verifCo;