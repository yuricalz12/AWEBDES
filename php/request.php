 <?php
 include "db.php";

  	////////////////////////
	//Schedule to Student///
	///////////////////////


  //Get Subject for Students based on course//
  if($_POST['action'] == 'getSubject'){
  	 $student = $_POST['student'];
  	 $stmt = $db->prepare("SELECT * FROM  user where id = ?");
	 $stmt->bind_param('i', $student);
	 $stmt->execute();
     $result = $stmt->get_result()->fetch_assoc();
     $stmt = $db->prepare("SELECT * FROM  subject WHERE course = ?");
     $stmt->bind_param("i",$result['course']);
     $stmt->execute();
     $info = $stmt->get_result();
     $output= '<option disabled selected="selected">Subject Name</option>';
		while ($value = $info->fetch_assoc()) {
		  $output.= "<option value=".$value['id']." >".$value['subject_name']."</option>";
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

	foreach (range($start+1, $end-1) as $key) {
		$count++;
	}
	$start++;
	while ($count  != 0) {
	 	$timeID[] = $start++;

	 	$count--;
	}

	$searchID = implode(',', $timeID);

	

   	$stmt = $db->prepare("SELECT * FROM schedule WHERE day =? AND (start_time IN (".$searchID.") OR end_time IN (".$searchID.") )");
   	$stmt->bind_param('s', $day);
   	$stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0){
    	 $stmt2 = $db->prepare("SELECT * FROM  room");
	     $stmt2->execute();
	     $rooms = $stmt2->get_result();
	     $output= '<option disabled selected="selected">Room Name</option>';
			 while ($value = $rooms->fetch_assoc()) {
			         $output.= "<option value=".$value['id']." >".$value['room_name']."</option>";
			 }
    }else{
    	while ($value = $result->fetch_assoc()) {
		$filter[] = $value['room_id'];
		}

		 $searchID2 = implode(',', $filter);
	     $stmt2 = $db->prepare("SELECT * FROM  room WHERE id NOT IN (".$searchID2.")");
	     $stmt2->execute();
	     $rooms = $stmt2->get_result();
	     $output= '<option disabled selected="selected">Room Name</option>';
			 while ($value = $rooms->fetch_assoc()) {
			         $output.= "<option value=".$value['id']." >".$value['room_name']."</option>";
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
			foreach (range($value['start_time']+1, $value['end_time']) as $key) {
				$time[] = $value['start_time']++;
			}
		}

		$searchID = implode(',', $time);


		$stmt = $db->prepare("SELECT * FROM  time where id NOT IN (".$searchID.") AND id != 29");
		$stmt->execute();
		    
	}
	  	
	$info = $stmt->get_result();
	$output= '<option disabled selected="selected">Start Time</option>';
	while ($value = $info->fetch_assoc()) {
		$output.= "<option value=".$value['id'].">".$value['time']."</option>";
	}

     echo $output;
  }


  //Get End Time for Students//
   if($_POST['action'] == 'getEndTime'){
   	 $start = $_POST['start'];
   	 $subject = $_POST['subject'];
   	 $classType = $_POST['classType'];
   	 $student = $_POST['student'];
   	 $stmt = $db->prepare("SELECT * FROM  subject where id = ?");
   	 $stmt->bind_param('i', $subject);
	 $stmt->execute();
	 $info = $stmt->get_result()->fetch_assoc();
	 $timeID = array();
	 $output = '';
	 $time = array();

	 if($classType == 'lecture'){
	 	$stmt = $db->prepare("SELECT * FROM  schedule where subject_id = ? AND type = ? AND user_id = ?");
	 	$stmt->bind_param('isi', $subject, $classType, $student);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = 0;
		while ($schedule = $result->fetch_assoc()) {
			foreach (range($schedule['start_time']+1, $schedule['end_time']) as $key) {
				$count++;
			}
		}

	 	$nextID = $start + 1;
	 	$counter = ($info['lecture_hour'] / 0.5) - $count;

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
			 	$stmt2 = $db->prepare("SELECT * FROM  time where id IN (".$searchID.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['id'].">".$value['time']."</option>";
					}
		 	}
	  	}else{
	  		while ($value3 = $result3->fetch_assoc()) {
			foreach (range($value3['start_time']+1, $value3['end_time']) as $key) {
					$time[] = ($value3['start_time']++)+1;
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
			 	$stmt2 = $db->prepare("SELECT * FROM  time where id IN (".$searchID.") AND id NOT IN (".$searchID3.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['id'].">".$value['time']."</option>";
					}
		 	}
	  	}
  	
	  	
	 	
	 }else{
	 	$stmt = $db->prepare("SELECT * FROM  schedule where subject_id = ? AND type = ? AND user_id = ?");
	 	$stmt->bind_param('isi', $subject, $classType, $student);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = 0;
		while ($schedule = $result->fetch_assoc()) {
			foreach (range($schedule['start_time']+1, $schedule['end_time']) as $key) {
				$count++;
			}
		}

	 	$nextID = $start + 1;
	 	$counter = ($info['lab_hour'] / 0.5) - $count;

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
			 	$stmt2 = $db->prepare("SELECT * FROM  time where id IN (".$searchID.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['id'].">".$value['time']."</option>";
					}
		 	}
	  	}else{
	  		while ($value3 = $result3->fetch_assoc()) {
			foreach (range($value3['start_time']+1, $value3['end_time']) as $key) {
					$time[] = ($value3['start_time']++)+1;
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
			 	$stmt2 = $db->prepare("SELECT * FROM  time where id IN (".$searchID.") AND id NOT IN (".$searchID3.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['id'].">".$value['time']."</option>";
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
    	$stmt2 = $db->prepare("SELECT * FROM subject WHERE id = ?");
	  	$stmt2->bind_param('i', $value['subject_id']);
	    $stmt2->execute();
	    $subject = $stmt2->get_result()->fetch_assoc();

	    $stmt3 = $db->prepare("SELECT * FROM room WHERE id = ?");
	  	$stmt3->bind_param('i', $value['room_id']);
	    $stmt3->execute();
	    $room = $stmt3->get_result()->fetch_assoc();
	    foreach (range($value['start_time'], $value['end_time']-1) as $key) {
				$time[] = array(
					"time_id" => $value['start_time']++
				);
			}
    	$schedule[] = array(
    				   "subject" => $subject['subject_name'],
    				   "day" => $value['day'],
    				   "room" => $room['room_name'],
    				   "classType" => $value['type'],
    				   "color" =>$subject['color'],
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
	  	 $stmt = $db->prepare("SELECT * FROM  user where id = ?");
		 $stmt->bind_param('i', $teacher);
		 $stmt->execute();
	     $result = $stmt->get_result()->fetch_assoc();
	     $stmt = $db->prepare("SELECT * FROM  subject WHERE department = ?");
	     $stmt->bind_param("i",$result['department']);
	     $stmt->execute();
	     $info = $stmt->get_result();
	     $output= '<option disabled selected="selected">Subject Name</option>';
			while ($value = $info->fetch_assoc()) {
			  $output.= "<option value=".$value['id']." >".$value['subject_name']."</option>";
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
			foreach (range($value['start_time']+1, $value['end_time']) as $key) {
					$time[] = $value['start_time']++;
				}
			}

			$searchID = implode(',', $time);


		  	$stmt = $db->prepare("SELECT * FROM  time where id NOT IN (".$searchID.") AND id != 29");
		    $stmt->execute();
		    
	  	}
	  	
	  	$info = $stmt->get_result();
		$output= '<option disabled selected="selected">Start Time</option>';
		while ($value = $info->fetch_assoc()) {
			$output.= "<option value=".$value['id'].">".$value['time']."</option>";
		}

	     echo $output;
	 }

    //Get End Time for teachers
	 if($_POST['action'] == 'getEndTimeTeacher'){
   	 $start = $_POST['start'];
   	 $subject = $_POST['subject'];
   	 $classType = $_POST['classType'];
   	 $teacher = $_POST['teacher'];
   	 $stmt = $db->prepare("SELECT * FROM  subject where id = ?");
   	 $stmt->bind_param('i', $subject);
	 $stmt->execute();
	 $info = $stmt->get_result()->fetch_assoc();
	 $timeID = array();
	 $output = '';
	 $time = array();

	 if($classType == 'lecture'){
	 	$stmt = $db->prepare("SELECT * FROM  schedule where subject_id = ? AND type = ? AND user_id = ?");
	 	$stmt->bind_param('isi', $subject, $classType, $teacher);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = 0;
		while ($schedule = $result->fetch_assoc()) {
			foreach (range($schedule['start_time']+1, $schedule['end_time']) as $key) {
				$count++;
			}
		}

	 	$nextID = $start + 1;
	 	$counter = ($info['lecture_hour'] / 0.5) - $count;

	 	$stmt3 = $db->prepare("SELECT * FROM schedule where user_id = ?");
	  	$stmt3->bind_param('i',$teacher);
	  	$stmt3->execute();
	  	$result3 = $stmt3->get_result();

	  	if($result3->num_rows == 0){
	  		if($counter == 0){
		 		$output = "0";
		 	}else{
		 		while ($counter  != 0) {
		 			if(in_array($nextID, $time, TRUE)){
		 				break;
		 			}
		 		$timeID[] = $nextID++;

		 		$counter--;
			 	}

			 	$searchID = implode(',', $timeID);
			 	$stmt2 = $db->prepare("SELECT * FROM  time where id IN (".$searchID.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['id'].">".$value['time']."</option>";
					}
		 	}
	  	}else{
	  		while ($value3 = $result3->fetch_assoc()) {
			foreach (range($value3['start_time']+1, $value3['end_time']) as $key) {
					$time[] = ($value3['start_time']++)+1;
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
			 	$stmt2 = $db->prepare("SELECT * FROM  time where id IN (".$searchID.") AND id NOT IN (".$searchID3.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['id'].">".$value['time']."</option>";
					}
		 	}
	  	}
  	
	  	
	 	
	 }else{
	 	$stmt = $db->prepare("SELECT * FROM  schedule where subject_id = ? AND type = ? AND user_id = ?");
	 	$stmt->bind_param('isi', $subject, $classType, $teacher);
		$stmt->execute();
		$result = $stmt->get_result();
		$count = 0;
		while ($schedule = $result->fetch_assoc()) {
			foreach (range($schedule['start_time']+1, $schedule['end_time']) as $key) {
				$count++;
			}
		}

	 	$nextID = $start + 1;
	 	$counter = ($info['lab_hour'] / 0.5) - $count;

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
			 	$stmt2 = $db->prepare("SELECT * FROM  time where id IN (".$searchID.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['id'].">".$value['time']."</option>";
					}
		 	}
	  	}else{
	  		while ($value3 = $result3->fetch_assoc()) {
			foreach (range($value3['start_time']+1, $value3['end_time']) as $key) {
					$time[] = ($value3['start_time']++)+1;
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
			 	$stmt2 = $db->prepare("SELECT * FROM  time where id IN (".$searchID.") AND id NOT IN (".$searchID3.")");
			    $stmt2->execute();
				$info = $stmt2->get_result();
				$output = '<option disabled selected="selected">End Time</option>';
					while ($value = $info->fetch_assoc()) {
						$output.= "<option value=".$value['id'].">".$value['time']."</option>";
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

	foreach (range($start+1, $end-1) as $key) {
		$count++;
	}
	$start++;
	while ($count  != 0) {
	 	$timeID[] = $start++;

	 	$count--;
	}

	$searchID = implode(',', $timeID);

	

   	$stmt = $db->prepare("SELECT * FROM schedule WHERE day =? AND (start_time IN (".$searchID.") OR end_time IN (".$searchID.") )");
   	$stmt->bind_param('s', $day);
   	$stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows == 0){
    	 $stmt2 = $db->prepare("SELECT * FROM  room");
	     $stmt2->execute();
	     $rooms = $stmt2->get_result();
	     $output= '<option disabled selected="selected">Room Name</option>';
			 while ($value = $rooms->fetch_assoc()) {
			         $output.= "<option value=".$value['id']." >".$value['room_name']."</option>";
			 }
    }else{
    	while ($value = $result->fetch_assoc()) {
		$filter[] = $value['room_id'];
		}

		 $searchID2 = implode(',', $filter);
	     $stmt2 = $db->prepare("SELECT * FROM  room WHERE id NOT IN (".$searchID2.")");
	     $stmt2->execute();
	     $rooms = $stmt2->get_result();
	     $output= '<option disabled selected="selected">Room Name</option>';
			 while ($value = $rooms->fetch_assoc()) {
			         $output.= "<option value=".$value['id']." >".$value['room_name']."</option>";
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
	    	$stmt2 = $db->prepare("SELECT * FROM subject WHERE id = ?");
		  	$stmt2->bind_param('i', $value['subject_id']);
		    $stmt2->execute();
		    $subject = $stmt2->get_result()->fetch_assoc();

		    $stmt3 = $db->prepare("SELECT * FROM room WHERE id = ?");
		  	$stmt3->bind_param('i', $value['room_id']);
		    $stmt3->execute();
		    $room = $stmt3->get_result()->fetch_assoc();
		    foreach (range($value['start_time'], $value['end_time']-1) as $key) {
					$time[] = array(
						"time_id" => $value['start_time']++
					);
				}
	    	$schedule[] = array(
	    				   "subject" => $subject['subject_name'],
	    				   "day" => $value['day'],
	    				   "room" => $room['room_name'],
	    				   "classType" => $value['type'],
	    				   "color" =>$subject['color'],
	    				   "time" => $time
	    				   );

	    	unset($time);
	    }

	  echo json_encode($schedule);
	}


	if($_POST['action'] == 'tableReset'){
		echo '<thead  class="bg-primary  table-bordered " style="color:white;"> 
                <tr> 
                  <th colspan="2">Time</th>
                  <th colspan="5">Days </th>
                </tr>
                <tr>
                  <th colspan="2"></th> 
                  <th style="width: 15vh">Monday</th> 
                  <th style="width: 15vh">Tuesday</th> 
                  <th style="width: 15vh">Wednesday</th> 
                  <th style="width: 15vh">Thursday</th> 
                  <th style="width: 15vh">Friday</th> 
                </tr>
              </thead> 
              <tbody class=" table-bordered "> 
                <tr>
                  <td>7:00</td><td>7:30</td><td id="monday-1"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>7:30</td><td>8:00</td><td id="monday-2"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>8:00</td><td>8:30</td><td id="monday-3"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>8:30</td><td>9:00</td><td id="monday-4"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>9:00</td><td>9:30</td><td id="monday-5"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>9:30</td><td>10:00</td><td id="monday-6"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>10:00</td><td>10:30</td><td id="monday-7"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>10:30</td><td>11:00</td><td id="monday-8"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>11:00</td><td>11:30</td><td id="monday-9"></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                  <td>11:30</td><td>12:00</td><td id="monday-10"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>12:00</td><td>12:30</td><td id="monday-11"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>12:30</td><td>1:00</td><td id="monday-12"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>1:00</td><td>1:30</td><td id="monday-13"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>1:30</td><td>2:00</td><td id="monday-14"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>2:00</td><td>2:30</td><td id="monday-15"></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                  <td>2:30</td><td>3:00</td><td id="monday-16"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>3:00</td><td>3:30</td><td id="monday-17"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>3:30</td><td>4:00</td><td id="monday-18"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>4:00</td><td>4:30</td><td id="monday-19"></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                  <td>4:30</td><td>5:00</td><td id="monday-20"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>5:00</td><td>5:30</td><td id="monday-21"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>5:30</td><td>6:00</td><td id="monday-22"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>6:00</td><td>6:30</td><td id="monday-23"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>6:30</td><td>7:00</td><td id="monday-24"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>7:00</td><td>7:30</td><td id="monday-25"></td><td></td><td></td><td></td><td></td>
                </tr>
                <tr>
                  <td>7:30</td><td>8:00</td><td id="monday-26"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>8:00</td><td>8:30</td><td id="monday-27"></td><td></td><td></td><td></td><td></td>
                </tr> 
                <tr>
                  <td>8:30</td><td>9:00</td><td id="monday-28"></td><td></td><td></td><td></td><td></td>
                </tr> 
              </tbody>';
	}
 ?>