function tagSearch()
{
	var valid = true
	if(document.getElementById('tags').value == "")
	{
		document.tagSearch.tags.placeholder = "Entrez un tag";
		document.tagSearch.tags.style.backgroundColor = "pink";
		valid = false;
	}
	return valid;
}
