<html>
<head>
<title>Create a Task</title>
	<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<?php

if (isset($_POST["submit"])) {

/* Remember to change the permissions on the XML file
   to allow write access by everyone

   N.B. <xmp> tag now deprecated, but a useful way of displaying the XML code on the page
*/

   $file = "task.xml";
   $fp = fopen($file, "rb") or die("Error - cannot open XML file");
   $str = fread($fp, filesize($file));

   $xml = new DOMDocument();
   $xml->formatOutput = true;
   $xml->preserveWhiteSpace = false;
   $xml->loadXML($str) or die("Error - cannot load XML data");

   // get document element
   $root= $xml->documentElement;
   $nextIDNode=$root->childNodes->item(0);
   $tasks= $root->childNodes->item(1);

   // find first book element
   $firstTask=$tasks->childNodes->item(0);

   // get values for new book element
   $newID=(int)$root->childNodes->item(0)->nodeValue;
   $newTitle=$_POST["title"];
   $newTaskLeader=$_POST["task_leader"];
   $newAddParticipants=$_POST["add_participants"];
   $newCompletionDate=$_POST["completion_date"];
   $newSummary=$_POST["summary"];
   $newUrl=$_POST["url"];
   $newStatus=$_POST["status"];
   $newID++;

   // create the title element
   $titleNode=$xml->createElement("title");
   $titleTextNode=$xml->createTextNode("$newTitle");
   $titleNode->appendChild($titleTextNode);

   // create the task leader element
   $taskLeaderNode=$xml->createElement("task_leader");
   $taskLeaderTextNode=$xml->createTextNode("$newTaskLeader");
   $taskLeaderNode->appendChild($taskLeaderTextNode);
   
   // create the additional participants element
   $addParticipantsNode=$xml->createElement("add_participants");
   $addParticipantsTextNode=$xml->createTextNode("$newAddParticipants");
   $addParticipantsNode->appendChild($addParticipantsTextNode);
   
   // create the completion date element
   $completionDateNode=$xml->createElement("completion_date");
   $completionDateTextNode=$xml->createTextNode("$newCompletionDate");
   $completionDateNode->appendChild($completionDateTextNode);
   
   // create the summary element
   $summaryNode=$xml->createElement("summary");
   $summaryTextNode=$xml->createTextNode("$newSummary");
   $summaryNode->appendChild($summaryTextNode);
   
   // create the url element
   $urlNode=$xml->createElement("url");
   $urlTextNode=$xml->createTextNode("$newUrl");
   $urlNode->appendChild($urlTextNode);

   // create the status element
   $statusNode=$xml->createElement("status");
   $statusTextNode=$xml->createTextNode("$newStatus");
   $statusNode->appendChild($statusTextNode);
   
   // create the new task
   $newTaskNode=$xml->createElement("task");
   $newTaskNode->setAttribute("id",$newID);
   $newTaskNode->appendChild($titleNode);
   $newTaskNode->appendChild($taskLeaderNode);
   $newTaskNode->appendChild($addParticipantsNode);
   $newTaskNode->appendChild($completionDateNode);
   $newTaskNode->appendChild($summaryNode);
   $newTaskNode->appendChild($urlNode);
   $newTaskNode->appendChild($statusNode);

   // add new book to the data set
   $tasks->insertBefore($newTaskNode,$firstTask);
   
   // save new XML file
   echo "<div class='successMessage'>You have successfully added a new task!</div> ".
			"<div><a href='addTask.php'><img src='back-button.jpg' alt='Back' class='backButton'>Click here to create another new task.</a></div>";
   $xml->save("task.xml");

} else {
?>


<body>
<div class="header">
	  <h1>Project Management Tool</h1>
  </div>
  
  <div class="topnav">
	  <a href="task.xml">All Tasks</a>
	  <a href="addTask.php">Create Task</a>
	  <a href="searchHome.html">Search Tasks</a>
	  <a href="updateStatus.php">Update Progress</a>
  </div>
  <div class="container">
  <div class="formLayout">
	<form method="post" action="addTask.php">
	  <label>Title: </label><br><input type="text" id="title" name="title" placeholder="Title"><br>
	  <label>Task Leader: </label><br><input type="text" name="task_leader" placeholder="Task Leader"><br>
	  <label>Additional Participants: </label><br><input type="text" name="add_participants" placeholder="Additional Participants"><br>
	  <label>Completion Date: </label><br><input type="text" name="completion_date" placeholder="Completion Date"><br>
	  <label>Summary: </label><br><input type="text" name="summary" placeholder="Summary"><br>
	  <label>URL: </label><br><input type="text" name="url" placeholder="URL"><br>
	  <label>Progress: </label><br>
	  <select name="status" placeHolder="Progress">
	    <option value="New">New</option>
	    <option value="In Progress">In Progress</option>
	    <option value="Complete">Complete</option>
      </select><br>
	  <input type="submit" name="submit" value="Add" action="taskAddedSuccess.html">
	</form>
</div>
</div>

</body>

</html>
<?php
}
?>