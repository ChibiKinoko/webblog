function verifPost()
{
	var valid=true;
	if(document.getElementById("title").value == "")
	{
		document.addPost.title.placeholder = "Veuillez renseigner un titre";
		document.addPost.title.style.backgroundColor = "pink";
		valid = false;

	}
	if(document.getElementById('content').value == "")
	{
		document.addPost.content.placeholder = "Veuillez rédigez un minimum de contenu";
		document.addPost.content.style.backgroundColor = "pink";
		valid = false;

	}
	if(document.getElementById('video').value != "")
	{
		var str = document.getElementById('video').value;
		if(str.indexOf("https://www.youtube.com/watch?v=") == -1 && str.indexOf("http://youtu.be/") == -1 && str.indexOf("http://www.dailymotion.com/video/") == -1 && str.indexOf("http://dai.ly/") == -1)
		{
			document.addPost.video.value = "";
			document.addPost.video.placeholder = "URL invalide : lien YouTube ou Dailymotion";
			document.addPost.video.style.backgroundColor="pink";
			valid = false;
		}
	}
	return valid;
}

function verifCom()
{
	var valid=true;
	if(document.getElementById('login').value == "")
	{
		document.commentaire.login.placeholder = "Entrez un pseudo";
		document.commentaire.login.style.backgroundColor = "pink";
		valid = false;
	}
	if(document.getElementById('login').value != "")
	{
		if(!(/[a-zA-Z0-9_]{4,}/).test(document.commentaire.login.value))
		{
			document.commentaire.login.value = "";
			document.commentaire.login.placeholder = "4 caractere minimum";
			document.commentaire.login.style.backgroundColor = "pink";
			valid = false;
		}
	}
	if(document.getElementById('content').value == "")
	{
		document.commentaire.content.placeholder = "Ecrire un commentaire";
		document.commentaire.content.style.backgroundColor = "pink";
		valid = false;
	}
	if(document.getElementById('content').value != "")
	{
		if(!(/[a-zA-Z0-9_]{3,}/).test(document.commentaire.content.value))
		{
			document.commentaire.content.value = "";
			document.commentaire.content.placeholder = "commentaire trop court :(";
			document.commentaire.content.style.backgroundColor = "pink";
			valid = false;
		}
	}
	return valid;
}

