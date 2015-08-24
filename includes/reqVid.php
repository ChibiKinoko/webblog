<?php

function checkVid($video)
{
	if (filter_var($video, FILTER_VALIDATE_URL)) 
	{
		if(strpos($video, "youtube"))
		{
			//echo "<script>alert(\"Je suis la !!\")</script>";	
			$video = str_replace("watch?v=", "embed/", $video);
			return $video;
		}
		elseif(strpos($video, "dailymotion")) 
		{
			//echo "<script>alert(\"Je suis la !!\")</script>";			
			$video = str_replace("video", "embed/video", $video);
			return $video;
		}
		else
		{
			$video = "";
			//echo "<script>alert(\"URL non valide !\")</script>";
			return $video;
		}
	} 
	else 
	{
		$video = "";
		//echo "<script>alert(\"filtre URL non valide !\")</script>";
		return $video;
	}
	
}
?>
