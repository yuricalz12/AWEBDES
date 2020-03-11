 <?php
 include "db.php";

  	////////////////////////
	//Schedule to Student///
	///////////////////////


  //Get Subject for Students based on course//
  if($_POST['action'] == 'getSubject'){
  	 $student = $_POST['student'];
  	 $stmt = $db->prepare("SELECT * FROM  user where user_id = ?");
	 $stmt->bind_param('i', $student);
	 $stmt->execute();
     $result = $stmt->get_result()->fetch_assoc();
     $stmt = $db->prepare("SELECT * FROM  subject WHERE course_id = ?");
     $stmt->bind_param("i",$result['course_id']);
     $stmt->execute();
     $info = $stmt->get_result();
     $output= '<option disabled selected="selected">Subject Name</option>';
		while ($value = $info->fetch_assoc()) {
		  $output.= "<option value=".$value['subject_id']." >".$value['subject_name']."</option>";
		}
               

     echo $output;
  }


  	//Get Room for Students//
    if($_POST['action'] == 'getRoom'){
     $start = $_POST['start'];
     $end = $_POST['end'];
   	 $subject = $_POST['subject'];
   	 $classType = $_POST['classType'];
   	 $student = $_POST['student'];
   	 $day = $_POST['day'];
   	 $count = 0;

	foreach (range($start, $end-1) as $key) {
		$count++;
	}
	while ($count  != 0) {
	 	$timeID[] = $start++;

	 	$count--;
	}

	$searchID = implode(',', $timeID);

	

   	$stmt = $db->prepare("SELECT * FROM schedule WHERE day =? AND (start_time_id IN (".$searchID.") OR end_time_id IN (".$searchID.") )");
   	$stmt->bind_param('s', $day);
   	$stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0){
    	 $stmt2 = $db->prepare("SELECT * FROM  room");
	     $stmt2->execute();
	     $rooms = $stmt2->get_result();
	     $output= '<option disabled selected="selected">Room Name</option>';
			 while ($value = $rooms->fetch_assoc()) {
			         $output.= "<option value=".$value['room_id']." >".$value['room_name']."</option>";
			 }
    }else{
    	while ($value = $result->fetch_assoc()) {
		$filter[] = $value['room_id'];
		}

		 $searchID2 = implode(',', $filter);
	     $stmt2 = $db->prepare("SELECT * FROM  room WHERE room_id NOT IN (".$searchID2.")");
	     $stmt2->execute();
	     $rooms = $stmt2->get_result();
	     $output= '<option disabled selected="selected">Room Name</option>';
			 while ($value = $rooms->fetch_assoc()) {
			         $output.= "<option value=".$value['room_id']." >".$value['room_name']."</option>";
			 }
    }
    
    echo $output;
     
  }

  //Get Class for Students//
  if($_POST['action'] == 'getClassType'){
  	 $output= '<option disabled selected="selected">Class Type</option>';
	 $output.= "<option value='lecture' >Lecture</option>";
	 $output.= "<option value='laboratory' >Laboratory</option>";
	

     echo $output;
  }

  //Get Day for Students//
  if($_POST['action'] == 'getDay'){
  	$output = '<option disabled selected="selected">Day</option>';
  	$output.= "<option value='monday' >Monday</option>";
	$output.= "<option value='tuesday' >Tuesday</option>";
	$output.= "<option value='wednesday' >Wednesday</option>";
	$output.= "<option value='thursday' >Thursday</option>";
	$output.= "<option value='friday' >Friday</option>";
  	echo $output;
  }
 
  //Get Start Time for Students//
  if($_POST['action'] == 'getStartTime'){
  	 $student = $_POST['student'];
  	 $stmt = $db->prepare("SELECT * FROM schedule where user_id = ?");
  	 $stmt->bind_param('i',$student);
  	 $stmt->execute();
  	 $result = $stmt->get_result();
  	 if($result->num_rows == 0){
	  		$stmt = $db->prepare("SELECT * FROM  time");
		    $stmt->execute();
	 }else{
	  	while ($value = $result->fetch_assoc()) {
			foreach (range($value['start_time_id']+1, $value['end_time_id']) as $key) {
				$time[] = $value['start_time_id']++;
			}
		}

		$searchID = implode(',', $time);


		$stmt = $db->prepare("SELECT * FROM  time where time_id NOT IN (".$searchID.") AND time_id != 29");
		$stmt->execute();
		    
	}
	  	
	$info = $stmt->get_result();
	$output= '<option disabled selected="selected">Start Time</option>';
	while ($value = $info->fetch_assoc()) {
		$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
	}

     echo $output;
  }


  //Get End Time for Students//
   if($_POST['action'] == 'getEndTime'){
   	 $start = $_POST['start'];
   	 $subject = $_POST['subject'];
   	 $classType = $_POST['classType'];
   	 $student = $_POST['student'];
   	 $stmt = $db->prepare("SELECT * FROM  subject where subject_id = ?");
   	 $stmt->bind_param('i', $subject);
	 $stmt->execute();
	 $info = $stmt->get_result()->fetch_assoc();
	 $timeID = array();
	 $output = '';
	 $time = array();

	 if($classType == 'lecture'){
	 	$stmt = $db->prepare("SELECT * FROM  schedule where subject_id = ? AND class_type = ? AND user_id = ?");
	 	$stmt->bind_param('isi', $subject, $classType, $student);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = 0;
		while ($schedule = $result->fetch_assoc()) {
			foreach (range($schedule['start_time_id']+1, $schedule['end_time_id']) as $key) {
				$count++;
			}
		}

	 	$nextID = $start + 1;
	 	$counter = ($info['subject_lecture_hour'] / 0.5) - $count;

	 	 $stmt3 = $db->prepare("SELECT * FROM schedule where user_id = ?");
	  	 $stmt3->bind_param('i',$student);
	  	 $stmt3->execute();
	  	 $result3 = $stmt3->get_result();

	  	if($result3->num_rows == 0){
	  		if($counter == 0){
		 		$output = 0;
		 	}else{
		 		while ($counter  != 0) {
		 			if(in_array($nextID, $time, TRUE)){
		 				break;
		 			}
		 		$timeID[] = $nextID++;

		 		$counter--;
			 	}

			 	$searchID = implode(',', $timeID);
			 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
					}
		 	}
	  	}else{
	  		while ($value3 = $result3->fetch_assoc()) {
			foreach (range($value3['start_time_id']+1, $value3['end_time_id']) as $key) {
					$time[] = ($value3['start_time_id']++)+1;
				}
			}

			$searchID3 = implode(',', $time);

		 	if($counter == 0){
		 		$output = 0;
		 	}else{
		 		while ($counter  != 0) {
		 			if(in_array($nextID, $time, TRUE)){
		 				break;
		 			}
		 		$timeID[] = $nextID++;

		 		$counter--;
			 	}

			 	$searchID = implode(',', $timeID);
			 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.") AND time_id NOT IN (".$searchID3.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
					}
		 	}
	  	}
  	
	  	
	 	
	 }else{
	 	$stmt = $db->prepare("SELECT * FROM  schedule where subject_id = ? AND class_type = ? AND user_id = ?");
	 	$stmt->bind_param('isi', $subject, $classType, $student);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = 0;
		while ($schedule = $result->fetch_assoc()) {
			foreach (range($schedule['start_time_id']+1, $schedule['end_time_id']) as $key) {
				$count++;
			}
		}

	 	$nextID = $start + 1;
	 	$counter = ($info['subject_lab_hour'] / 0.5) - $count;

		$stmt3 = $db->prepare("SELECT * FROM schedule where user_id = ?");
	  	$stmt3->bind_param('i',$student);
	  	$stmt3->execute();
	  	$result3 = $stmt3->get_result();

	  	if($result3->num_rows == 0){
	  		if($counter == 0){
		 		$output = 1;
		 	}else{
		 		while ($counter  != 0) {
		 			if(in_array($nextID, $time, TRUE)){
		 				break;
		 			}
		 		$timeID[] = $nextID++;

		 		$counter--;
			 	}

			 	$searchID = implode(',', $timeID);
			 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
					}
		 	}
	  	}else{
	  		while ($value3 = $result3->fetch_assoc()) {
			foreach (range($value3['start_time_id']+1, $value3['end_time_id']) as $key) {
					$time[] = ($value3['start_time_id']++)+1;
				}
			}

			$searchID3 = implode(',', $time);

		 	if($counter == 0){
		 		$output = 1;
		 	}else{
		 		while ($counter  != 0) {
		 			if(in_array($nextID, $time, TRUE)){
		 				break;
		 			}
		 		$timeID[] = $nextID++;

		 		$counter--;
			 	}

			 	$searchID = implode(',', $timeID);
			 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.") AND time_id NOT IN (".$searchID3.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
					}
		 	}
	  	}

	}

     echo $output;
  }


  //Get Schedule Time for Students//
  if($_POST['action'] == 'getSchedule'){
  	$stmt = $db->prepare("SELECT * FROM schedule WHERE user_id = ?");
  	$stmt->bind_param('i', $_POST['student']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($value = $result->fetch_assoc()) {
    	$stmt2 = $db->prepare("SELECT * FROM subject WHERE subject_id = ?");
	  	$stmt2->bind_param('i', $value['subject_id']);
	    $stmt2->execute();
	    $subject = $stmt2->get_result()->fetch_assoc();

	    $stmt3 = $db->prepare("SELECT * FROM room WHERE room_id = ?");
	  	$stmt3->bind_param('i', $value['room_id']);
	    $stmt3->execute();
	    $room = $stmt3->get_result()->fetch_assoc();
	    foreach (range($value['start_time_id'], $value['end_time_id']-1) as $key) {
				$time[] = array(
					"time_id" => $value['start_time_id']++
				);
			}
    	$schedule[] = array(
    				   "subject" => $subject['subject_name'],
    				   "day" => $value['day'],
    				   "room" => $room['room_name'],
    				   "classType" => $value['class_type'],
    				   "color" =>$subject['subject_color'],
    				   "time" => $time
    				   );

    	unset($time);
    }
    	if(isset($schedule)){
    		echo json_encode($schedule);
    	}else{
    		echo 0;
    	}
	  
	}



	////////////////////////
	//Schedule to Teacher //
	///////////////////////


	//Get Subject for teachers based on department
	  if($_POST['action'] == 'getSubjectTeacher'){
	  	 $teacher = $_POST['teacher'];
	  	 $stmt = $db->prepare("SELECT * FROM  user where user_id = ?");
		 $stmt->bind_param('i', $teacher);
		 $stmt->execute();
	     $result = $stmt->get_result()->fetch_assoc();
	     $stmt = $db->prepare("SELECT * FROM  subject WHERE department_id = ?");
	     $stmt->bind_param("i",$result['department_id']);
	     $stmt->execute();
	     $info = $stmt->get_result();
	     $output= '<option disabled selected="selected">Subject Name</option>';
			while ($value = $info->fetch_assoc()) {
			  $output.= "<option value=".$value['subject_id']." >".$value['subject_name']."</option>";
			}
	               

	     echo $output;
	  }

    //Get Class Type for teachers
	if($_POST['action'] == 'getClassTypeTeacher'){
	  	 $output= '<option disabled selected="selected">Class Type</option>';
		 $output.= "<option value='lecture' >Lecture</option>";
		 $output.= "<option value='laboratory' >Laboratory</option>";
		

	     echo $output;
	  }

    //Get Day for teachers
    if($_POST['action'] == 'getDayTeacher'){
	  	$output = '<option disabled selected="selected">Day</option>';
	  	$output.= "<option value='monday' >Monday</option>";
		$output.= "<option value='tuesday' >Tuesday</option>";
		$output.= "<option value='wednesday' >Wednesday</option>";
		$output.= "<option value='thursday' >Thursday</option>";
		$output.= "<option value='friday' >Friday</option>";
	  	echo $output;
	}

    //Get Start Time for teachers
	if($_POST['action'] == 'getStartTimeTeacher'){
	    $teacher = $_POST['teacher'];
	    $stmt = $db->prepare("SELECT * FROM schedule where user_id = ?");
	 	$stmt->bind_param('i',$teacher);
	  	$stmt->execute();
	  	$result = $stmt->get_result();

	  	if($result->num_rows == 0){
	  		$stmt = $db->prepare("SELECT * FROM  time");
		    $stmt->execute();
	  	}else{
	  		while ($value = $result->fetch_assoc()) {
			foreach (range($value['start_time_id']+1, $value['end_time_id']) as $key) {
					$time[] = $value['start_time_id']++;
				}
			}

			$searchID = implode(',', $time);


		  	$stmt = $db->prepare("SELECT * FROM  time where time_id NOT IN (".$searchID.") AND time_id != 29");
		    $stmt->execute();
		    
	  	}
	  	
	  	$info = $stmt->get_result();
		$output= '<option disabled selected="selected">Start Time</option>';
		while ($value = $info->fetch_assoc()) {
			$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
		}

	     echo $output;
	 }

    //Get End Time for teachers
	 if($_POST['action'] == 'getEndTimeTeacher'){
   	 $start = $_POST['start'];
   	 $subject = $_POST['subject'];
   	 $classType = $_POST['classType'];
   	 $teacher = $_POST['teacher'];
   	 $stmt = $db->prepare("SELECT * FROM  subject where subject_id = ?");
   	 $stmt->bind_param('i', $subject);
	 $stmt->execute();
	 $info = $stmt->get_result()->fetch_assoc();
	 $timeID = array();
	 $output = '';
	 $time = array();

	 if($classType == 'lecture'){
	 	$stmt = $db->prepare("SELECT * FROM  schedule where subject_id = ? AND class_type = ? AND user_id = ?");
	 	$stmt->bind_param('isi', $subject, $classType, $teacher);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = 0;
		while ($schedule = $result->fetch_assoc()) {
			foreach (range($schedule['start_time_id']+1, $schedule['end_time_id']) as $key) {
				$count++;
			}
		}

	 	$nextID = $start + 1;
	 	$counter = ($info['subject_lecture_hour'] / 0.5) - $count;

	 	 $stmt3 = $db->prepare("SELECT * FROM schedule where user_id = ?");
	  	 $stmt3->bind_param('i',$teacher);
	  	 $stmt3->execute();
	  	 $result3 = $stmt3->get_result();

	  	if($result3->num_rows == 0){
	  		if($counter == 0){
		 		$output = 0;
		 	}else{
		 		while ($counter  != 0) {
		 			if(in_array($nextID, $time, TRUE)){
		 				break;
		 			}
		 		$timeID[] = $nextID++;

		 		$counter--;
			 	}

			 	$searchID = implode(',', $timeID);
			 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
					}
		 	}
	  	}else{
	  		while ($value3 = $result3->fetch_assoc()) {
			foreach (range($value3['start_time_id']+1, $value3['end_time_id']) as $key) {
					$time[] = ($value3['start_time_id']++)+1;
				}
			}

			$searchID3 = implode(',', $time);

		 	if($counter == 0){
		 		$output = 0;
		 	}else{
		 		while ($counter  != 0) {
		 			if(in_array($nextID, $time, TRUE)){
		 				break;
		 			}
		 		$timeID[] = $nextID++;

		 		$counter--;
			 	}

			 	$searchID = implode(',', $timeID);
			 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.") AND time_id NOT IN (".$searchID3.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
					}
		 	}
	  	}
  	
	  	
	 	
	 }else{
	 	$stmt = $db->prepare("SELECT * FROM  schedule where subject_id = ? AND class_type = ? AND user_id = ?");
	 	$stmt->bind_param('isi', $subject, $classType, $teacher);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = 0;
		while ($schedule = $result->fetch_assoc()) {
			foreach (range($schedule['start_time_id']+1, $schedule['end_time_id']) as $key) {
				$count++;
			}
		}

	 	$nextID = $start + 1;
	 	$counter = ($info['subject_lab_hour'] / 0.5) - $count;

		$stmt3 = $db->prepare("SELECT * FROM schedule where user_id = ?");
	  	$stmt3->bind_param('i',$teacher);
	  	$stmt3->execute();
	  	$result3 = $stmt3->get_result();

	  	if($result3->num_rows == 0){
	  		if($counter == 0){
		 		$output = 1;
		 	}else{
		 		while ($counter  != 0) {
		 			if(in_array($nextID, $time, TRUE)){
		 				break;
		 			}
		 		$timeID[] = $nextID++;

		 		$counter--;
			 	}

			 	$searchID = implode(',', $timeID);
			 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
					}
		 	}
	  	}else{
	  		while ($value3 = $result3->fetch_assoc()) {
			foreach (range($value3['start_time_id']+1, $value3['end_time_id']) as $key) {
					$time[] = ($value3['start_time_id']++)+1;
				}
			}

			$searchID3 = implode(',', $time);

		 	if($counter == 0){
		 		$output = 1;
		 	}else{
		 		while ($counter  != 0) {
		 			if(in_array($nextID, $time, TRUE)){
		 				break;
		 			}
		 		$timeID[] = $nextID++;

		 		$counter--;
			 	}

			 	$searchID = implode(',', $timeID);
			 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.") AND time_id NOT IN (".$searchID3.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
					}
		 	}
	  	}

	}

      echo $output;
   }

   // Get Room for teachers
   if($_POST['action'] == 'getRoomTeacher'){
     $start = $_POST['start'];
     $end = $_POST['end'];
   	 $subject = $_POST['subject'];
   	 $classType = $_POST['classType'];
   	 $teacher = $_POST['teacher'];
   	 $day = $_POST['day'];
   	 $count = 0;

	foreach (range($start, $end-1) as $key) {
		$count++;
	}
	while ($count  != 0) {
	 	$timeID[] = $start++;

	 	$count--;
	}

	$searchID = implode(',', $timeID);

	

   	$stmt = $db->prepare("SELECT * FROM schedule WHERE day =? AND (start_time_id IN (".$searchID.") OR end_time_id IN (".$searchID.") )");
   	$stmt->bind_param('s', $day);
   	$stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0){
    	 $stmt2 = $db->prepare("SELECT * FROM  room");
	     $stmt2->execute();
	     $rooms = $stmt2->get_result();
	     $output= '<option disabled selected="selected">Room Name</option>';
			 while ($value = $rooms->fetch_assoc()) {
			         $output.= "<option value=".$value['room_id']." >".$value['room_name']."</option>";
			 }
    }else{
    	while ($value = $result->fetch_assoc()) {
		$filter[] = $value['room_id'];
		}

		 $searchID2 = implode(',', $filter);
	     $stmt2 = $db->prepare("SELECT * FROM  room WHERE room_id NOT IN (".$searchID2.")");
	     $stmt2->execute();
	     $rooms = $stmt2->get_result();
	     $output= '<option disabled selected="selected">Room Name</option>';
			 while ($value = $rooms->fetch_assoc()) {
			         $output.= "<option value=".$value['room_id']." >".$value['room_name']."</option>";
			 }
    }
    
    echo $output;
     
  }

	  if($_POST['action'] == 'getScheduleTeacher'){
	  	$stmt = $db->prepare("SELECT * FROM schedule WHERE user_id = ?");
	  	$stmt->bind_param('i', $_POST['teacher']);
	    $stmt->execute();
	    $result = $stmt->get_result();
	    while ($value = $result->fetch_assoc()) {
	    	$stmt2 = $db->prepare("SELECT * FROM subject WHERE subject_id = ?");
		  	$stmt2->bind_param('i', $value['subject_id']);
		    $stmt2->execute();
		    $subject = $stmt2->get_result()->fetch_assoc();

		    $stmt3 = $db->prepare("SELECT * FROM room WHERE room_id = ?");
		  	$stmt3->bind_param('i', $value['room_id']);
		    $stmt3->execute();
		    $room = $stmt3->get_result()->fetch_assoc();
		    foreach (range($value['start_time_id'], $value['end_time_id']-1) as $key) {
					$time[] = array(
						"time_id" => $value['start_time_id']++
					);
				}
	    	$schedule[] = array(
	    				   "subject" => $subject['subject_name'],
	    				   "day" => $value['day'],
	    				   "room" => $room['room_name'],
	    				   "classType" => $value['class_type'],
	    				   "color" =>$subject['subject_color'],
	    				   "time" => $time
	    				   );

	    	unset($time);
	    }

	  echo json_encode($schedule);
	}


	if($_POST['action'] == 'tableReset'){
		echo '<table id="table" class="table  table-bordered " style="table-layout: auto;">
              <thead  class="bg-primary" style="color:white;"> 
                <tr> 
                  <th colspan="2">Time</th>
                  <th colspan="5">Days </th>
                </tr>
                <tr>
                  <td colspan="2"></td> 
                  <td>Monday</td> 
                  <td>Tuesday</td> 
                  <td>Wednesday</td> 
                  <td>Thursday</td> 
                  <td>Friday</td> 
                </tr>
              </thead> 
              <tbody> 
                <tr>
                  <td>7:00</td><td>7:30</td><td id="monday-1"></td><td id="tuesday-1"></td><td id="wednesday-1"></td><td id="thursday-1"></td><td id="friday-1"></td>
                </tr> 
                <tr>
                  <td>7:30</td><td>8:00</td><td id="monday-2"></td><td id="tuesday-2"></td><td id="wednesday-2"></td><td id="thursday-2"></td><td id="friday-2"></td>
                </tr> 
                <tr>
                  <td>8:00</td><td>8:30</td><td id="monday-3"></td><td id="tuesday-3"></td><td id="wednesday-3"></td><td id="thursday-3"></td><td id="friday-3"></td>
                </tr> 
                <tr>
                  <td>8:30</td><td>9:00</td><td id="monday-4"></td><td id="tuesday-4"></td><td id="wednesday-4"></td><td id="thursday-4"></td><td id="friday-4"></td>
                </tr> 
                <tr>
                  <td>9:00</td><td>9:30</td><td id="monday-5"></td><td id="tuesday-5"></td><td id="wednesday-5"></td><td id="thursday-5"></td><td id="friday-5"></td>
                </tr> 
                <tr>
                  <td>9:30</td><td>10:00</td><td id="monday-6"></td><td id="tuesday-6"></td><td id="wednesday-6"></td><td id="thursday-6"></td><td id="friday-6"></td>
                </tr> 
                <tr>
                  <td>10:00</td><td>10:30</td><td id="monday-7"></td><td id="tuesday-7"></td><td id="wednesday-7"></td><td id="thursday-7"></td><td id="friday-7"></td>
                </tr> 
                <tr>
                  <td>10:30</td><td>11:00</td><td id="monday-8"></td><td id="tuesday-8"></td><td id="wednesday-8"></td><td id="thursday-8"></td><td id="friday-8"></td>
                </tr> 
                <tr>
                  <td>11:00</td><td>11:30</td><td id="monday-9"></td><td id="tuesday-9"></td><td id="wednesday-9"></td><td id="thursday-9"></td><td id="friday-9"></td>
                </tr>
                <tr>
                  <td>11:30</td><td>12:00</td><td id="monday-10"></td><td id="tuesday-10"></td><td id="wednesday-10"></td><td id="thursday-10"></td><td id="friday-10"></td>
                </tr> 
                <tr>
                  <td>12:00</td><td>12:30</td><td id="monday-11"></td><td id="tuesday-11"></td><td id="wednesday-11"></td><td id="thursday-11"></td><td id="friday-11"></td>
                </tr> 
                <tr>
                  <td>12:30</td><td>1:00</td><td id="monday-12"></td><td id="tuesday-12"></td><td id="wednesday-12"></td><td id="thursday-12"></td><td id="friday-12"></td>
                </tr> 
                <tr>
                  <td>1:00</td><td>1:30</td><td id="monday-13"></td><td id="tuesday-13"></td><td id="wednesday-13"></td><td id="thursday-13"></td><td id="friday-13"></td>
                </tr> 
                <tr>
                  <td>1:30</td><td>2:00</td><td id="monday-14"></td><td id="tuesday-14"></td><td id="wednesday-14"></td><td id="thursday-14"></td><td id="friday-14"></td>
                </tr> 
                <tr>
                  <td>2:00</td><td>2:30</td><td id="monday-15"></td><td id="tuesday-15"></td><td id="wednesday-15"></td><td id="thursday-15"></td><td id="friday-15"></td>
                </tr>
                <tr>
                  <td>2:30</td><td>3:00</td><td id="monday-16"></td><td id="tuesday-16"></td><td id="wednesday-16"></td><td id="thursday-16"></td><td id="friday-16"></td>
                </tr> 
                <tr>
                  <td>3:00</td><td>3:30</td><td id="monday-17"></td><td id="tuesday-17"></td><td id="wednesday-17"></td><td id="thursday-17"></td><td id="friday-17"></td>
                </tr> 
                <tr>
                  <td>3:30</td><td>4:00</td><td id="monday-18"></td><td id="tuesday-18"></td><td id="wednesday-18"></td><td id="thursday-18"></td><td id="friday-18"></td>
                </tr> 
                <tr>
                  <td>4:00</td><td>4:30</td><td id="monday-19"></td><td id="tuesday-19"></td><td id="wednesday-19"></td><td id="thursday-19"></td><td id="friday-19"></td>
                </tr>
                <tr>
                  <td>4:30</td><td>5:00</td><td id="monday-20"></td><td id="tuesday-20"></td><td id="wednesday-20"></td><td id="thursday-20"></td><td id="friday-20"></td>
                </tr> 
                <tr>
                  <td>5:00</td><td>5:30</td><td id="monday-21"></td><td id="tuesday-21"></td><td id="wednesday-21"></td><td id="thursday-21"></td><td id="friday-21"></td>
                </tr> 
                <tr>
                  <td>5:30</td><td>6:00</td><td id="monday-22"></td><td id="tuesday-22"></td><td id="wednesday-22"></td><td id="thursday-22"></td><td id="friday-22"></td>
                </tr> 
                <tr>
                  <td>6:00</td><td>6:30</td><td id="monday-23"></td><td id="tuesday-23"></td><td id="wednesday-23"></td><td id="thursday-23"></td><td id="friday-23"></td>
                </tr> 
                <tr>
                  <td>6:30</td><td>7:00</td><td id="monday-24"></td><td id="tuesday-24"></td><td id="wednesday-24"></td><td id="thursday-24"></td><td id="friday-24"></td>
                </tr> 
                <tr>
                  <td>7:00</td><td>7:30</td><td id="monday-25"></td><td id="tuesday-25"></td><td id="wednesday-25"></td><td id="thursday-25"></td><td id="friday-25"></td>
                </tr>
                <tr>
                  <td>7:30</td><td>8:00</td><td id="monday-26"></td><td id="tuesday-26"></td><td id="wednesday-26"></td><td id="thursday-26"></td><td id="friday-26"></td>
                </tr> 
                <tr>
                  <td>8:00</td><td>8:30</td><td id="monday-27"></td><td id="tuesday-27"></td><td id="wednesday-27"></td><td id="thursday-27"></td><td id="friday-27"></td>
                </tr> 
                <tr>
                  <td>8:30</td><td>9:00</td><td id="monday-28"></td><td id="tuesday-28"></td><td id="wednesday-28"></td><td id="thursday-28"></td><td id="friday-28"></td>
                </tr> 
              </tbody>
            </table>';
	}



	//////GET SUBJECt



	if($_POST['action'] == 'getSubjectStatistic'){
		$stmt = $db->prepare("SELECT * FROM subject WHERE course_id = ? AND semester_id = ? AND year_level_id = ?");
	  	$stmt->bind_param('iii', $_POST['course'], $_POST['semester'], $_POST['year']);
	    $stmt->execute();
	    $result = $stmt->get_result();
	    $stats = array();
	    if($result->num_rows > 0){
		    while($subject = $result->fetch_assoc()){
		    	$stmt2 = $db->prepare("SELECT DISTINCT user_id FROM schedule WHERE subject_id = ?");
		    	$stmt2->bind_param('i', $subject['subject_id']);
		    	$stmt2->execute();
		    	$result2 = $stmt2->get_result();
		    	$stats[] = array("subject" => $subject['subject_name'],
		    					 "count" => $result2->num_rows);
		    }
		   echo json_encode($stats);
		}else{
			echo 0;
		}

	    
	}





	if($_POST['action'] == 'getSectionSubject'){
     $stmt = $db->prepare("SELECT * FROM  subject");
     $stmt->execute();
     $info = $stmt->get_result();
     $output= '<option disabled selected="selected">Subject Name</option>';
		while ($value = $info->fetch_assoc()) {
		  $output.= "<option value=".$value['subject_id']." >".$value['subject_name']."</option>";
		}
               

     echo $output;
  }

   if($_POST['action'] == 'getSectionStartTime'){
  	 $section = $_POST['section'];
  	 $day = $_POST['day'];
  	 $stmt = $db->prepare("SELECT * FROM section_schedule where section_id = ? AND day = ?");
  	 $stmt->bind_param('is',$section,$day);
  	 $stmt->execute();
  	 $result = $stmt->get_result();
  	 if($result->num_rows == 0){
	  		$stmt = $db->prepare("SELECT * FROM  time WHERE time_id != 29");
		    $stmt->execute();
	 }else{
	  	while ($value = $result->fetch_assoc()) {
			foreach (range($value['start_time_id']+1, $value['end_time_id']) as $key) {
				$time[] = $value['start_time_id']++;
			}
		}

		$searchID = implode(',', $time);


		$stmt = $db->prepare("SELECT * FROM  time where time_id NOT IN (".$searchID.") AND time_id != 29");
		$stmt->execute();
		    
	}
	  	
	$info = $stmt->get_result();
	$output= '<option disabled selected="selected">Start Time</option>';
	while ($value = $info->fetch_assoc()) {
		$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
	}

     echo $output;
  }
  if($_POST['action'] == 'getSectionEndTime'){
   	 $start = $_POST['start'];
   	 $subject = $_POST['subject'];
   	 $classType = $_POST['classType'];
   	 $section = $_POST['section'];
   	 $day = $_POST['day'];
   	 $stmt = $db->prepare("SELECT * FROM  subject where subject_id = ?");
   	 $stmt->bind_param('i', $subject);
	 $stmt->execute();
	 $info = $stmt->get_result()->fetch_assoc();
	 $timeID = array();
	 $output = '';
	 $time = array();

	 if($classType == 'lecture'){
	 	$stmt = $db->prepare("SELECT * FROM  section_schedule where subject_id = ? AND class_type = ? AND section_id = ?");
	 	$stmt->bind_param('isi', $subject, $classType, $section);
		$stmt->execute();

		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$count = 0;
			while ($schedule = $result->fetch_assoc()) {
				foreach (range($schedule['start_time_id']+1, $schedule['end_time_id']) as $key) {
					$count++;
				}
			}

		 	$nextID = $start + 1;
		 	$counter = ($info['subject_lecture_hour'] / 0.5) - $count;

		 	 $stmt3 = $db->prepare("SELECT * FROM section_schedule where section_id = ? AND day = ?");
		  	 $stmt3->bind_param('is',$section,$day);
		  	 $stmt3->execute();
		  	 $result3 = $stmt3->get_result();
		  	if($result3->num_rows == 0){
		  		if($counter == 0){
			 		$output = 0;
			 	}else{
			 		while ($counter  != 0) {
			 			if(in_array($nextID, $time, TRUE)){
			 				break;
			 			}
			 		$timeID[] = $nextID++;

			 		$counter--;
				 	}

				 	$searchID = implode(',', $timeID);
				 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.")");
				    $stmt2->execute();
					$info = $stmt2->get_result();
					$output = '<option disabled selected="selected">End Time</option>';
						while ($value = $info->fetch_assoc()) {
							$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
						}
			 	}
		  	}else{
		  		while ($value3 = $result3->fetch_assoc()) {
				foreach (range($value3['start_time_id']+1, $value3['end_time_id']) as $key) {
						$time[] = ($value3['start_time_id']++)+1;
					}
				}

				$searchID3 = implode(',', $time);
			 	if($counter == 0){
			 		$output = 0;
			 	}else{
			 		while ($counter  != 0) {
			 			if(in_array($nextID, $time, TRUE)){
			 				break;
			 			}
			 		$timeID[] = $nextID++;

			 		$counter--;
				 	}

				 	$searchID = implode(',', $timeID);
				 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.") AND time_id NOT IN (".$searchID3.")");
				    $stmt2->execute();
					$info = $stmt2->get_result();
					$output = '<option disabled selected="selected">End Time</option>';
						while ($value = $info->fetch_assoc()) {
							$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
						}
			 	}
		  	 }
		}else{

			$counter = ($info['subject_lecture_hour'] / 0.5);
			$nextID = $start + 1;
			while ($counter  != 0) {
			 			if(in_array($nextID, $time, TRUE)){
			 				break;
			 			}
			 		$timeID[] = $nextID++;

			 		$counter--;
				 	}

				 	$searchID = implode(',', $timeID);
			 $searchID;
			$stmt2 = $db->prepare("SELECT * FROM  time WHERE time_id != $start AND time_id in (".$searchID.") ");
			$stmt2->execute();
		    $info = $stmt2->get_result();
			$output = '<option disabled selected="selected">End Time</option>';
				while ($value = $info->fetch_assoc()) {
					$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
				}
		}	

	 	
	 }else{
	 	$stmt = $db->prepare("SELECT * FROM  section_schedule where subject_id = ? AND class_type = ? AND section_id = ?");
	 	$stmt->bind_param('isi', $subject, $classType, $section);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = 0;
		while ($schedule = $result->fetch_assoc()) {
			foreach (range($schedule['start_time_id']+1, $schedule['end_time_id']) as $key) {
				$count++;
			}
		}

	 	$nextID = $start + 1;
	 	$counter = ($info['subject_lab_hour'] / 0.5) - $count;

		$stmt3 = $db->prepare("SELECT * FROM section_schedule where section_id = ? AND day = ?");
	  	$stmt3->bind_param('is',$section,$day);
	  	$stmt3->execute();
	  	$result3 = $stmt3->get_result();

	  	if($result3->num_rows == 0){
	  		if($counter == 0){
		 		$output = 1;
		 	}else{
		 		while ($counter  != 0) {
		 			if(in_array($nextID, $time, TRUE)){
		 				break;
		 			}
		 		$timeID[] = $nextID++;

		 		$counter--;
			 	}

			 	$searchID = implode(',', $timeID);
			 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
					}
		 	}
	  	}else{
	  		while ($value3 = $result3->fetch_assoc()) {
			foreach (range($value3['start_time_id']+1, $value3['end_time_id']) as $key) {
					$time[] = ($value3['start_time_id']++)+1;
				}
			}

			$searchID3 = implode(',', $time);

		 	if($counter == 0){
		 		$output = 1;
		 	}else{
		 		while ($counter  != 0) {
		 			if(in_array($nextID, $time, TRUE)){
		 				break;
		 			}
		 		$timeID[] = $nextID++;

		 		$counter--;
			 	}

			 	$searchID = implode(',', $timeID);
			 	$stmt2 = $db->prepare("SELECT * FROM  time where time_id IN (".$searchID.") AND time_id NOT IN (".$searchID3.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['time_id'].">".$value['time']."</option>";
					}
		 	}
	  	}

	}

     echo $output;
  }

  if($_POST['action'] == 'getSectionRoom'){
     $start = $_POST['start'];
     $end = $_POST['end'];
   	 $subject = $_POST['subject'];
   	 $classType = $_POST['classType'];
   	 $section = $_POST['section'];
   	 $day = $_POST['day'];
   	 $count = 0;

	foreach (range($start, $end-1) as $key) {
		$count++;
	}
	$start++;
	$count--;
	while ($count  != 0) {
	 	$timeID[] = $start++;

	 	$count--;
	}

	$searchID = implode(',', $timeID);

	

   	$stmt = $db->prepare("SELECT * FROM section_schedule WHERE day =? AND (start_time_id IN (".$searchID.") OR end_time_id IN (".$searchID.") )");
   	$stmt->bind_param('s', $day);
   	$stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0){
    	 $stmt2 = $db->prepare("SELECT * FROM  room");
	     $stmt2->execute();
	     $rooms = $stmt2->get_result();
	     $output= '<option disabled selected="selected">Room Name</option>';
			 while ($value = $rooms->fetch_assoc()) {
			         $output.= "<option value=".$value['room_id']." >".$value['room_name']."</option>";
			 }
    }else{
    	while ($value = $result->fetch_assoc()) {
		$filter[] = $value['room_id'];
		}

		 $searchID2 = implode(',', $filter);
	     $stmt2 = $db->prepare("SELECT * FROM  room WHERE room_id NOT IN (".$searchID2.")");
	     $stmt2->execute();
	     $rooms = $stmt2->get_result();
	     $output= '<option disabled selected="selected">Room Name</option>';
			 while ($value = $rooms->fetch_assoc()) {
			         $output.= "<option value=".$value['room_id']." >".$value['room_name']."</option>";
			 }
    }
    
    echo $output;
     
  }

  if($_POST['action'] == 'getSectionSchedule'){
	  	$stmt = $db->prepare("SELECT * FROM section_schedule WHERE section_id = ?");
	  	$stmt->bind_param('i', $_POST['section']);
	    $stmt->execute();
	    $result = $stmt->get_result();

	    while ($value = $result->fetch_assoc()) {
	    	$stmt2 = $db->prepare("SELECT * FROM subject WHERE subject_id = ?");
		  	$stmt2->bind_param('i', $value['subject_id']);
		    $stmt2->execute();
		    $subject = $stmt2->get_result()->fetch_assoc();

		    $stmt3 = $db->prepare("SELECT * FROM room WHERE room_id = ?");
		  	$stmt3->bind_param('i', $value['room_id']);
		    $stmt3->execute();
		    $room = $stmt3->get_result()->fetch_assoc();
		    foreach (range($value['start_time_id'], $value['end_time_id']-1) as $key) {
					$time[] = array(
						"time_id" => $value['start_time_id']++
					);
				}
	    	$schedule[] = array(
	    				   "subject" => $subject['subject_name'],
	    				   "day" => $value['day'],
	    				   "room" => $room['room_name'],
	    				   "classType" => $value['class_type'],
	    				   "color" =>$subject['subject_color'],
	    				   "time" => $time
	    				   );

	    	unset($time);
	    }

	  echo json_encode($schedule);
	}

	if($_POST['action'] == 'scheduleMultiple'){
		foreach ($_POST['students'] as $key => $student_id) {
			$stmt = $db->prepare("SELECT * FROM section_schedule WHERE section_id = ?");
		  	$stmt->bind_param('i', $_POST['section']);
		    $stmt->execute();
		    $result = $stmt->get_result();
		    while ($schedule = $result->fetch_assoc()) {
		    	$stmt2 = $db->prepare("INSERT INTO schedule (subject_id, room_id, user_id, dpd_id, class_type, day, start_time_id, end_time_id) VALUES (?,?,?,?,?,?,?,?)");
			    $stmt2->bind_param("iiiissii", $schedule['subject_id'], $schedule['room_id'], $student_id, $schedule['dpd_id'], $schedule['class_type'], $schedule['day'], $schedule['start_time_id'], $schedule['end_time_id']);
			    if($stmt2->execute()){

			    }else{
					$error[] = $db->error;
			    }    
		    }
		}

		if(empty($error)){
			echo 1;
		}else{
			echo 0;
		}
	}

	if($_POST['action'] == 'getStudentSubject'){
  	 $student = $_POST['student'];
  	 $stmt = $db->prepare("SELECT DISTINCT subject_id FROM  schedule WHERE user_id = ?");
  	 $stmt->bind_param("i",$student);
	 $stmt->execute();
	 $result = $stmt->get_result();
	 if($result->num_rows > 0){
	 	while($value = $result->fetch_assoc()){
	 		$filter[] = $value['subject_id'];
	 	}
	 	$searchID = implode(',', $filter);
	 	$stmt2 = $db->prepare("SELECT DISTINCT subject_id FROM  section_schedule WHERE subject_id NOT IN (".$searchID.")");
		$stmt2->execute();
		$output= '<option disabled selected="selected">Subject Name</option>';

	    $result2 = $stmt2->get_result();
	    while ($value2 = $result2->fetch_assoc()) {
	     	 $stmt3 = $db->prepare("SELECT * FROM  subject WHERE subject_id = ?");
		     $stmt3->bind_param("i",$value2['subject_id']);
		     $stmt3->execute();
		     $info = $stmt3->get_result()->fetch_assoc();
		     $output.= "<option value=".$info['subject_id']." >".$info['subject_name']."</option>";
				
	     }
	 }else{
	 	$stmt2 = $db->prepare("SELECT DISTINCT subject_id FROM  section_schedule");
		$stmt2->execute();
		$output= '<option disabled selected="selected">Subject Name</option>';

	    $result2 = $stmt2->get_result();
	    while ($value2 = $result2->fetch_assoc()) {
	     	 $stmt3 = $db->prepare("SELECT * FROM  subject WHERE subject_id = ?");
		     $stmt3->bind_param("i",$value2['subject_id']);
		     $stmt3->execute();
		     $info = $stmt3->get_result()->fetch_assoc();
		     $output.= "<option value=".$info['subject_id']." >".$info['subject_name']."</option>";
				
	     }
	 }
  	 
     echo $output;
  }

  if($_POST['action'] == 'getSubjectSection'){
  	 $subject = $_POST['subject'];
  	 $student = $_POST['student'];

    $stmt = $db->prepare("SELECT * FROM  schedule WHERE user_id = ?");
    $stmt->bind_param("i",$student);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
    	while($value = $result->fetch_assoc()){
    	    $count = 0;
		  	$start = $value['start_time_id'];
		  	$end = $value['end_time_id'];
		
		     foreach (range($start, $end) as $key) {
				$count++;
			}		
			while ($count  != 0) {
			 	$timeID[] = $start++;

			 	$count--;
			}	

    }
    		$searchID = implode(',', $timeID);

    		$stmt2 = $db->prepare("SELECT DISTINCT section_id FROM  section_schedule WHERE subject_id = ?");
    		$stmt2->bind_param("i",$subject);
		    $stmt2->execute();
		    $result2 = $stmt2->get_result();
		    $conflict = 0;
			while($value2 = $result2->fetch_assoc()){
				$stmt3 = $db->prepare("SELECT * FROM  section_schedule WHERE subject_id = ? AND section_id = ?");
	    		$stmt3->bind_param("ii",$subject,$value2['section_id']);
			    $stmt3->execute();
			    $result3 = $stmt3->get_result();
			    while($value3 = $result3->fetch_assoc()){
			    	$stmt4 = $db->prepare("SELECT * FROM  section_schedule WHERE subject_id = ? AND section_id = ? AND day = ? AND between_time_id NOT IN (".$searchID.")");
		    		$stmt4->bind_param("isi",$subject,$value3['day'],$value3['section_id']);
				    $stmt4->execute();
				    $result4 = $stmt4->get_result();
				    if($result4->num_rows > 0){
				    	if($result3->num_rows == $result4->num_rows){
				    	$sectionFilter[] = $value3['section_id'];
					    }else{
					    	$conflict++;
					    }
				    }else if($result4->num_rows == 0){
				    	$conflict++;
				    }
				    
			    }
			}

			if($conflict > 0){
				$stmt2 = $db->prepare("SELECT DISTINCT section_id FROM  section_schedule WHERE subject_id = ?");
    		$stmt2->bind_param("i",$subject);
		    $stmt2->execute();
		    $result2 = $stmt2->get_result();
		    $conflict = 0;
		    $conflict2 = 0;
			while($value2 = $result2->fetch_assoc()){
				$stmt3 = $db->prepare("SELECT * FROM  section_schedule WHERE subject_id = ? AND section_id = ?");
	    		$stmt3->bind_param("ii",$subject,$value2['section_id']);
			    $stmt3->execute();
			    $result3 = $stmt3->get_result();
			    while($value3 = $result3->fetch_assoc()){
			    	$stmt4 = $db->prepare("SELECT * FROM  section_schedule WHERE subject_id = ? AND section_id = ? AND between_time_id NOT IN (".$searchID.")");
		    		$stmt4->bind_param("ii",$subject,$value3['section_id']);
				    $stmt4->execute();
				    $result4 = $stmt4->get_result();
				    if($result4->num_rows > 0){
				    	if($result3->num_rows == $result4->num_rows){
				    	$sectionFilter[] = $value3['section_id'];
					    }else{
					    	$conflict2++;
					    }
				    }else if($result4->num_rows == 0){
				    	$conflict++;
				    }
				    
			     }
				}
			}
			if(isset($sectionFilter)){
				$searchID2 = array_unique($sectionFilter);
				$output= '<option disabled selected="selected">Section</option>';
				foreach ($searchID2 as $key => $value4) {
				       $stmt5 = $db->prepare("SELECT * FROM  section WHERE section_id = ?");
				       $stmt5->bind_param("i",$value4);
			 	       $stmt5->execute();
				       $info = $stmt5->get_result()->fetch_assoc();
				       $output.= "<option value=".$info['section_id']." >".$info['section_name']."</option>";
				}

				echo $output;
			}else if($conflict2 > 0){
				$output = '<option disabled selected="selected">Section</option>';
				if($conflict == 0){
					$stmt5 = $db->prepare("SELECT DISTINCT section_id FROM  section_schedule WHERE subject_id = ?");
				    $stmt5->bind_param("i",$subject);
			 	    $stmt5->execute();
			 	    echo $conflict;
				    $result5 = $stmt5->get_result();
				    while($value5 = $result5->fetch_assoc()){
				    	$stmt6 = $db->prepare("SELECT * FROM section WHERE section_id = ?");
				    	$stmt6->bind_param("i", $value5['section_id']);
				    	$stmt6->execute();
				    	$result6 = $stmt6->get_result();
				    	while($info = $result6->fetch_assoc()){
				    		$output.= "<option value=".$info['section_id']." >".$info['section_name']."</option>";
				    	}
				    	
				    }
				    
				}

				echo $output;
			}else{
				$output = '<option disabled selected="selected">Section</option>';
				if($conflict == 0){
					$stmt5 = $db->prepare("SELECT DISTINCT section_id FROM  section_schedule WHERE subject_id = ?");
				    $stmt5->bind_param("i",$subject);
			 	    $stmt5->execute();
			 	    echo $conflict;
				    $result5 = $stmt5->get_result();
				    while($value5 = $result5->fetch_assoc()){
				    	$stmt6 = $db->prepare("SELECT * FROM section WHERE section_id = ?");
				    	$stmt6->bind_param("i", $value5['section_id']);
				    	$stmt6->execute();
				    	$result6 = $stmt6->get_result();
				    	while($info = $result6->fetch_assoc()){
				    		$output.= "<option value=".$info['section_id']." >".$info['section_name']."</option>";
				    	}
				    	
				    }
				    
				}

				echo $output;
			}
			

		}else{
			$stmt2 = $db->prepare("SELECT DISTINCT section_id FROM  section_schedule WHERE subject_id = ?");
		    $stmt2->bind_param("i",$subject);
			$stmt2->execute();
			$output= '<option disabled selected="selected">Section</option>';

		  	  $result2 = $stmt2->get_result();
		  	 while ($value2 = $result2->fetch_assoc()) {
		  	    $stmt3 = $db->prepare("SELECT * FROM  section WHERE section_id = ?");
			    $stmt3->bind_param("i",$value2['section_id']);
		 	    $stmt3->execute();
			    $info = $stmt3->get_result()->fetch_assoc();
			    $output.= "<option value=".$info['section_id']." >".$info['section_name']."</option>";
					
		  	   }
				echo $output;

		}
    

	
  }



 ?>