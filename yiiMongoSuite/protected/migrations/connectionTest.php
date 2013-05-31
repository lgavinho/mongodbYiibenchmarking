<?php
	
	function checkEncode($string) {
 		if( !mb_check_encoding($string,'UTF-8')) {
    		return mb_convert_encoding($string,'UTF-8','ISO-8859-1');
  		} else {
    		return $string;
  		}
	}


	try {
		$mongoConnetion = new Mongo();
		$mongoDatabase = $mongoConnetion->selectDB('ingresse');
	} catch (MongoConnectionException $e) {
		die("Problem during mongoDb initialization");
	}

	$dbName = 'ingresse';
	$conn = new PDO('mysql:host=localhost;dbname=' . $dbName . ';charset=UTF-8', 'root', 'root'); 
	//$mysqlDb = mysql_select_db($dbName);
	//$mysqlTables = getMyTables($mysqlDb);


	$query  = 'SELECT E.ID as eventID, E.TITLE as eventTitle, E.DESCRIPTION as eventDescription, P.NAME as plannerName, P.LINK as plannerLink,';
	$query .= 'P.EMAIL as plannerEmail, V.NAME as venueName , V.STATE as venueState, TT.NAME as ticketName , GT.TYPE as guestName, GT.PRICE as guestPrice ';
	$query .= 'FROM EVENT E ';
	$query .= 'INNER JOIN USER U ON E.USER_ID = U.ID ';
	$query .= 'INNER JOIN PLANNERUSER PU ON PU.USER_ID = U.ID ';
	$query .= 'INNER JOIN PLANNER P ON P.ID = PU.PLANNER_ID ';
	$query .= 'INNER JOIN VENUES V ON V.ID = E.VENUES_ID ';
	$query .= 'INNER JOIN EVENTDATE ED ON ED.EVENT_ID = E.ID ';
	$query .= 'INNER JOIN TICKETTYPEDATE TD ON TD.EVENT_DATE_ID = ED.ID ';
	$query .= 'INNER JOIN TICKETTYPE TT ON TT.ID = TD.TICKET_TYPE_ID ';
	$query .= 'INNER JOIN GUESTTYPE GT ON GT.TICKET_TYPE_ID = TT.ID ';
	$query .= 'WHERE E.TYPE = "FREESEAT" ';
	$query .= 'AND E.ID BETWEEN 1500 AND 1700 ';
	$query .= 'AND E.STATUS = "PUBLISHED" ';

	$sql = $conn->query($query); 

	while($row = $sql->fetch(PDO::FETCH_ASSOC)) {
		$noSqlData[] = array(
			'eventId'           => $row['eventID'],
			'eventTitle'        => checkEncode($row['eventTitle']),
			'eventDescription'  => checkEncode($row['eventDescription']),
			'planner'           => array('plannerName' => checkEncode($row['plannerName']), 'plannerLink' => $row['plannerLink'], 'plannerEmail' => $row['plannerEmail']),
			'venues'            => array('venueName' => checkEncode($row['venueName']), 'venueState' => $row['venueState']),
			'ticketType'        => array('ticketName' => checkEncode($row['ticketName']), 'guest' => array('guestName' => checkEncode($row['guestName']), 'guestPrice' => $row['guestPrice']))
		);
    }     	
	
    // Starts new collection on mongodb
  	$collection = $mongoDatabase->event;

  	foreach ($noSqlData as $data) {
  		$collection->insert($data);	
  	}
  	
	echo "Alo alo gracas a Deus! " . $row['eventID'];
	die('terminou!');
?>