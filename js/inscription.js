function verifInscript()
{
	var valid=true;
	if(document.getElementById("login").value == "")
	{
		document.inscription.login.placeholder = "login incorrect.";
		document.inscription.login.style.backgroundColor = "pink";
		/*document.inscription.login.style.borderColor = "red";*/
		valid=false;
	}
	if(!(/[a-zA-Z0-9_]{4,}/).test(inscription.login.value))
	{
		document.inscription.login.value = "";
		document.inscription.login.placeholder = "login incorrect : 4 caracteres minimum.";
		document.inscription.login.style.backgroundColor = "pink";
		valid=false;
	}
	if(document.getElementById("email").value == "")
	{
		document.inscription.email.placeholder = "Ex : mon_email@email.fr";
		document.inscription.email.style.backgroundColor = "pink";
		valid=false;
	}
	if(!(/[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}/).test(inscription.email.value))
	{

		/* signe + pour demander à ce qu'il y en ait au moins un 
		Apres @ au moins deux caracteres,
		on echappe le .
		entre 2 et 4 caractere apres le point */
		document.inscription.email.value = "";		
		document.inscription.email.placeholder = "Ex : mon_email@email.fr";		
		document.inscription.email.style.backgroundColor = "pink";
		valid=false;
	}
	if(document.getElementById("password").value == "")
	{
		document.inscription.password.placeholder = "mot de passe incorrect : 6 caracteres minimum";
		document.inscription.password.style.backgroundColor = "pink";
		valid=false;
	}
	if(!(/[a-zA-Z0-9@\.;:!_\-^<>`]{6,}/).test(inscription.password.value))
	{
		document.inscription.password.placeholder = "mot de passe incorrect : 6 caracteres minimum.";
		document.inscription.password.style.backgroundColor = "pink";
		valid=false;
	}
	if(document.getElementById("confirm").value == "")
	{
		document.inscription.confirm.placeholder = "saisie incorrecte";
		document.inscription.confirm.style.backgroundColor = "pink";
		valid=false;
	}
	if(document.getElementById("password").value != "" && /[a-zA-Z0-9@\.;:!_\-^<>`]{6,}/.test(inscription.password.value) && document.getElementById("confirm").value == "")
	{
		if(document.getElementById("confirm").value != document.getElementById("password").value)
		{
			document.inscription.password.style.backgroundColor = "pink";
			document.inscription.confirm.style.backgroundColor = "pink";

			document.inscription.password.value = "";
			document.inscription.confirm.value = "";
			document.inscription.password.placeholder = "mots de passe différents";
			document.inscription.confirm.placeholder = "mots de passe différents";
			valid=false;
		}
	}
	return valid;
}

function verfifLogin()
{
	document.inscription.login.value = "";
	document.inscription.login.placeholder = "login déjà utilisé";
	document.inscription.login.style.backgroundColor = "pink";
}