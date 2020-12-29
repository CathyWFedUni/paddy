<?php
    require_once "include/auth.php"; 

    $DB_DSN = "mysql:host=localhost;dbname=paddy";

    $DB_USER = "root";
    $DB_PASSWORD = "";

    function storeSessionDB($sessionTime, $numberOfParticipants, $sessionDate, $sessionName){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        $query =    "
                    INSERT INTO session (session_start_time, session_size, session_date, session_name)
                    VALUES (?, ?, ?, ?);
                    ";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $stmt = $conn->prepare($query);
        $stmt->bindValue(1, $sessionTime);
        $stmt->bindValue(2, $numberOfParticipants);
        $stmt->bindValue(3, $sessionDate);
        $stmt->bindValue(4, $sessionName);
        if($stmt->execute()){
            //echo "<script> alert('". $sessionName ."') </script>";
            return true;
        } else {
            echo "<script> alert('Database Error') </script>";
            return false;
        }
    }

     //Delete Session
     function deleteSessionDB($sessionID){         
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        $users = array();
        $query0 =   "
                    SELECT participant_user_id 
                    FROM sessionparticipants
                    WHERE participant_session_id = ?
                    ";
        $conn0 = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $stmt0 = $conn0->prepare($query0);
        $stmt0->bindValue(1, $sessionID);
        if($stmt0->execute()){
            foreach($stmt0 as $row){
                array_push($users, $row['participant_user_id']);
            }
        }
        $query =    "
                    DELETE FROM `sessionparticipants` WHERE `participant_session_id` = ?;
                    DELETE FROM `session` WHERE `session`.`session_id` = ?;                   
                    ";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $stmt = $conn->prepare($query);
        $stmt->bindValue(1, $sessionID); 
        $stmt->bindValue(2, $sessionID);      
        if($stmt->execute()){
            foreach($users as $user){
                $isDummy = isDummy($user);
                if($isDummy == 1){
                    deleteUserAccountDB($user);
                }
            }
            return true;
        } else {
            echo "<script> alert('Database Error') </script>";
            return false;
        }
    }

    // update profile picture 
    function updateProfilePic($name){       
        global $DB_DSN, $DB_USER, $DB_PASSWORD; 
        $fileNameCurrentQuery = "select user_profile_picture_unimplemented FROM useraccount WHERE user_name =?";  
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);              
        $stmt = $conn->prepare($fileNameCurrentQuery);
        $stmt->bindValue(1, $name);
        if($stmt->execute()){
            foreach ($stmt as $row) {
                if ($row) {   
                    $fileNameCurrent =$row['user_profile_picture_unimplemented'];
                    echo htmlspecialchars($fileNameCurrent);
                    unlink('uploads/'.$fileNameCurrent);                     
                }
            }        
            
        }
    }

    // update profile picture 
    function updatePic($name, $fileNameNew){ 
        global $DB_DSN, $DB_USER, $DB_PASSWORD;    
        $updateImageSQL = "UPDATE useraccount set  user_profile_picture_unimplemented='$fileNameNew' WHERE user_name =?";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);  
        $stmt = $conn->prepare($updateImageSQL);
        $stmt->bindValue(1, $name);
        $stmt->execute();             
            
        
    }

    
    //auth.php page session ID

    function sessionLogin($username){ 
        global $DB_DSN, $DB_USER, $DB_PASSWORD;    
        $sql = "select user_id from useraccount where user_name =?";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);  
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $username);
        $stmt->execute();
        foreach ($stmt as $row) {

            $_SESSION['user_id'] = $row['user_id'];

        }

        $imageQuery = "	SELECT user_profile_picture_unimplemented
        FROM useraccount
        WHERE user_name = ?";
        $stmt = $conn->prepare($imageQuery);
        $stmt->bindValue(1, $username);
        $stmt->execute();
        
        foreach ($stmt as $row) {
            if ($row['user_profile_picture_unimplemented'] != null) {
                //echo htmlspecialchars($row['userImgeRef']);
                echo "<div>";
                $_SESSION['user_profile_picture_unimplemented'] = "uploads/" . $row['user_profile_picture_unimplemented'];
                //if image no found, use default image refrence to call image
            } else {
                //echo "No image Found";
                $_SESSION['user_profile_picture_unimplemented'] = "uploads/profiledefault.jpg";
                //   echo htmlspecialchars($imageName) . "<br>";
                echo "</div>";
            }
        
        }
    }

    //function login.php
    function isDummy($userID){
        //initilise variables 
        $db_password = "";  
        $isOrganiser = ""; 
        $isDummy = "";  
        //declare global connection variables          
        global $DB_DSN, $DB_USER, $DB_PASSWORD;  
      
        $query = " SELECT u.user_name, u.user_id, u.user_password, us.isOrganiser, us.user_is_dummy
                    FROM useraccount u, usersettings us
                    WHERE us.user_settings_user_id = u.user_id and u.user_id=?";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD); 

        global $db_password, $isOrganiser;

        $stmt = $conn->prepare($query);
        $stmt->bindValue(1, $userID);
        // If the execution works properly
        if ($stmt->execute()) {
            // Grab the first row
            $row = $stmt->fetch();
            // If it exists
            if ($row) {
                // Get the stored password
                $db_password = $row['user_password'];
                $isOrganiser = $row['isOrganiser'];
                $isDummy = $row['user_is_dummy'];
                $userID = $row['user_id'];
                //return  $db_password;
                //return  $isOrganiser;
                //return $userID;
                return $isDummy;

            }
           
        }
    }

    
    //registration.php
    function checkUser($username,$email, $errors){
        global $DB_DSN, $DB_USER, $DB_PASSWORD; 
        $user_check_query = "SELECT user_email, user_name FROM useraccount WHERE user_name=? OR user_email = ?";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD); 
        $stmt = $conn->prepare($user_check_query);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $email);
        //echo "<script> alert('" . $user_check_query . "') </script>";
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            if ($row) {
                echo "<script> alert(\"Username or Email exists\")</script>";
                array_push($errors, "Username or Email exists");
            }
        } else {
            echo "<script> alert(\"Database Connection Error\")</script>";
        }
    }

    function createUser($username, $email, $primarylagSelected, $password){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;         
        $query = "INSERT INTO useraccount( user_name, user_email, $primarylagSelected, user_password) VALUES(?, ?, '3', '$password')";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD); 
        //echo htmlspecialchars($query) . "<br>";
        $stmt = $conn->prepare($query);
        //$stmt = $conn->prepare($isOrganiser);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $email);
        if ($stmt->execute()) {

            $query0 = "select user_id from useraccount where user_name = ?";
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD); 
            //echo htmlspecialchars($query0) . "<br>";
            $stmt0 = $conn->prepare($query0);
            $stmt0->bindParam(1, $username);
            if ($stmt0->execute()) {
                foreach ($stmt0 as $row) {
                    $query1 = "INSERT INTO usersettings(user_settings_user_id, isOrganiser, user_is_dummy) VALUES (?,'0', ?) ";
                    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD); 
                    $stmt1 = $conn->prepare($query1);
                    $stmt1->bindValue(1, $row['user_id']);
                    if(isset($_POST['dummyAccount'])){
                        $stmt1->bindValue(2, $_POST['dummyAccount']);
                    } else{
                        $stmt1->bindValue(2, '0');
                    }
                    $stmt1->execute();              

                }
                if ($stmt0->execute()) {
                    //  echo "<script> alert('User setting updated ') </script>";
                    echo "<script> alert(\"Account created successfully\")</script>";
                    header('location: Login');
                }

            } else {
                echo "<script> alert(\"Record failed\")</script>";
            }
         
        } 
    }


    //inbox.php
    function inbox() {  

        $query_user_id = "";
        $user_name = "";
        $user_email = "";
        $query_date = "";
        $query_header = "";
        $query_body = "";     
                         
        global $DB_DSN, $DB_USER, $DB_PASSWORD;   
        $query = '
        SELECT
        q.query_user_id, u.user_name, q.query_header, q.query_body, q.query_date, u.user_email, u.user_japanese_skill, u.user_english_skill
        FROM useraccount u
        INNER JOIN userquery q
        ON
            u.user_id = q.query_user_id		
                        
        ORDER BY q.query_date desc;
        ';

        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        global  $query_user_id, $user_name, $user_email, $query_date, $query_header,  $query_body; 
             
        $stmt = $conn->prepare($query);
     
        if ($stmt->execute()) {
            return $stmt->fetchAll();

        } else {
            return null;
        }        
   
            
        }
    

// send message 
        function sendMessageSQL($fromName, $topic, $message) {
            global $DB_DSN, $DB_USER, $DB_PASSWORD; 
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
           

            //$date = date("Y-m-d H:i:s");

            if ($topic == "") {
                echo "<script> alert(\" Please select a topic\")</script>";
            } elseif ($message == "") {
                echo "<script> alert(\" Please enter a message\")</script>";
            } else {
                $userIDSql = "SELECT user_id FROM useraccount WHERE useraccount.user_name = ?";
                $stmt = $conn->prepare($userIDSql);
                $name = $_SESSION['user_name'];
                $stmt->bindValue(1, $name);
                if ($stmt->execute()) {
                    foreach ($stmt as $row) {
                        $query0 = "INSERT INTO userquery(query_user_id, query_header,query_body) Values (?,?,?)";
                        $stmt0 = $conn->prepare($query0);
                        $stmt0->bindValue(1, $row['user_id']);
                        $stmt0->bindValue(2, $topic);
                        $stmt0->bindValue(3, $message);
                        if ($stmt0->execute()) {
                            //echo "<script> alert('Succesful query') </script>";
                        } else {
                            echo "<script> alert(\" We do not have time for you today\")</script>";
                        }
                    }
                } else {
                    echo "<script> alert(\" Who are you\")</script>";
                }

                // echo "Your message has been sent on " . date("Y/m/d");
                echo "<script> alert(\" Message Sent\")</script>";

            }
        }

        function joinSessionSQL($userID, $sessionID){
            global $DB_DSN, $DB_USER, $DB_PASSWORD; 
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $sql = "
                    SELECT participant_session_id, participant_user_id
                    FROM sessionparticipants
                    WHERE participant_session_id = ? AND participant_user_id = ?;";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $sessionID);
            $stmt->bindValue(2, $userID);
            if($stmt->execute()){
                $row = $stmt->fetch();
                if($row){
                } else {
                $sql1 = "
                INSERT INTO sessionparticipants (participant_session_id, participant_user_id)
                VALUES (?, ?);
                        ";
                $stmt1 = $conn->prepare($sql1);
                $stmt1->bindValue(1, $sessionID);
                $stmt1->bindValue(2, $userID);
                if($stmt1->execute()){
                    unset($_POST['reg_user']);
                } else {
                    echo "<script> alert('Action Failed') </script>";
                }
                }
            }
        }

        function pairUsersSQL($sessionID){
            global $DB_DSN, $DB_USER, $DB_PASSWORD; 
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $sql = "SELECT useraccount.user_id, useraccount.user_name, useraccount.user_email, user_japanese_skill, user_english_skill, isOrganiser, pair_id
                    FROM useraccount
                    JOIN sessionparticipants
                    ON useraccount.user_id = sessionparticipants.participant_user_id
                    JOIN usersettings
                    ON useraccount.user_id = usersettings.user_settings_user_id
                    WHERE sessionparticipants.participant_session_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $sessionID);
            $userArray = array();
            $currentSession = new Session('0000-10-10', '20:00:00', '50', 'Session');
            if($stmt->execute()){
                foreach($stmt as $row){
                //if($row['pair_id'] == null){
                    $id = htmlentities($row['user_id']);
                    $userName = htmlentities($row['user_id']);
                    $userEmail = htmlentities($row['user_email']);
                    $userJapSkill = htmlentities($row['user_japanese_skill']);
                    $userEngSkill = htmlentities($row['user_english_skill']);
                    $userArray[] = new User($id, $userName, $userEmail, $userJapSkill, $userEngSkill);
                //}
                }
                if(count($userArray) < 2){
                echo "<script> alert('Not enough participants') </script>";
                } else {
                
                $unsortedUsers = $currentSession->addUsers($userArray);
                $currentSession->sortRemainingUsers($unsortedUsers);
                $groups = $currentSession->getGroupArray();
                $i = 1;
                    foreach($groups as $group){
                        
                        $parts = $group->getParticipants();
                        foreach($parts as $part){
                        $conn1 = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                        $sql1 ="
                                UPDATE sessionparticipants
                                SET pair_id = ?
                                WHERE participant_user_id = ?
                                ";
                        $stmt1 = $conn1->prepare($sql1);
                        $stmt1->bindValue(1, $i);
                        $stmt1->bindValue(2, $part->getID());
                        $stmt1->execute();
                        
                        }
                        $i++;
                    }
                //echo "<script> alert('pairing complete') </script>";
                }
            }
        }
        

        function getCurrentSessionDetail($sessionID){
            $noParticipants;
            $sessionSize;
            global $DB_DSN, $DB_USER, $DB_PASSWORD;
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $sql = "SELECT session_id, session_start_time, session_size, session_name, session_date, (
                        SELECT COUNT(sessionparticipants.participant_id)
                        FROM sessionparticipants 
                        WHERE sessionparticipants.participant_session_id =   
                        session.session_id) AS numberOfParticipants
                    FROM session 
                    WHERE session_id = ?
                    ORDER BY session.session_date 
                    DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(1, $sessionID);
            if($stmt->execute()){
                foreach($stmt as $row){
                    $noParticipants = htmlentities($row['numberOfParticipants']);
                    $sessionSize = htmlentities($row['session_size']);
                    $sessionID = htmlentities($row['session_id']);
                    $sessionName = htmlentities($row['session_name']);
                }
               
            }
            return array($noParticipants, $sessionSize, $sessionID, $sessionName);
        }
    

    function getSessionParticipants($sessionID){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        $table;
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $sql = "SELECT useraccount.user_id, useraccount.user_name, useraccount.user_email, user_japanese_skill, user_english_skill, isOrganiser, user_is_dummy, pair_id
            FROM useraccount
            JOIN sessionparticipants
            ON useraccount.user_id = sessionparticipants.participant_user_id
            JOIN usersettings
            ON useraccount.user_id = usersettings.user_settings_user_id
            WHERE sessionparticipants.participant_session_id = ?
            ORDER BY pair_id ASC";              
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, htmlentities($sessionID));
        if($stmt->execute()){
            return $stmt->fetchAll();
        } else {
            return null;
        }
        
        
    }

    function getCurrentUserDB($id){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $sql = "
                SELECT  user_id, user_name, user_email, user_japanese_skill, user_english_skill, 
                        user_profile_picture_unimplemented, user_custom_description, isOrganiser, 
                        user_created
                FROM    useraccount
                JOIN    usersettings 
                ON      useraccount.user_id = usersettings.user_settings_user_id
                WHERE   user_id = ?
               ";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, htmlentities($id));
        if($stmt->execute()){
            return $result = $stmt->fetchAll()[0];
        }
    }




    
    //userDetail_profile.php 

    function showNonPrimaryLanague($userID){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        global $languageLevel, $languageSkill;
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $sql_engLevel = "   SELECT user_name, user_email, user_japanese_skill, user_english_skill, user_profile_picture_unimplemented, user_custom_description
                        FROM useraccount
                        WHERE useraccount.user_id = ? and user_english_skill= '3'";

        $stmt = $conn->prepare($sql_engLevel);
        $stmt->bindParam(1, $userID);
        //echo "<script> alert('" . $user_check_query . "') </script>";
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            if ($row) {       
                $languageLevel = "Japanese Language Level: ";
                $languageSkill = "user_japanese_skill";
            } else {     
                $languageLevel = "English Language Level: ";
                $languageSkill = "user_english_skill";
                return $languageLevel; 
                return $languageSkill; 
            }
        }
    }
        
    function updateLanguageLevel($userID, $lag_Level){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        global $languageLevel, $languageSkill;
        showNonPrimaryLanague($userID);
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $sql_p = "SELECT user_japanese_skill, user_english_skill FROM useraccount WHERE user_ID =?";
        $stmt = $conn->prepare($sql_p);
        $stmt->bindValue(1, $userID);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            if ($row) {     
                $query = "UPDATE useraccount set $languageSkill='$lag_Level' WHERE user_ID =?";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(1, $userID);
                $stmt->execute();
              //echo "<script>alert('Language level updated');</script>"; 
               header('Location: ./EditDetails?LanguageUpdate=Successful');
              //header("refresh:0; url=./EditDetails?LanguageUpdated");            
               
            } else {
                echo "There is no other profile available";
            }
        }
    }

    function updateEmail($userID, $email){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        global $languageLevel, $languageSkill;
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $sql = "SELECT user_email FROM useraccount WHERE user_ID =?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $userID);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            if ($row) {     
                $updateEmailQuery = "UPDATE useraccount set user_email='$email' WHERE user_ID =?";
                //echo htmlspecialchars($query) . "<br>";
                $stmt = $conn->prepare($updateEmailQuery);
                $stmt->bindValue(1, $userID);
                if($stmt->execute()){  
                //echo "<script> alert(\"email updated\")</script>";
                //update url to indate the changes are made successfully
                header('Location: ./EditDetails?EmailUpdated=Successful');
                }
            } else {
                echo "There is no other profile available";
            }
        }
    }

    function updateEmailLanguage($userID, $email,$lag_Level){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        global $languageLevel, $languageSkill;
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        showNonPrimaryLanague($userID);
        $sql = "SELECT user_email FROM useraccount WHERE user_ID =?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $userID);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            if ($row) {
                $query = "UPDATE useraccount set $languageSkill='$lag_Level', user_email='$email' WHERE user_ID =?";
                // echo htmlspecialchars($query) . "<br>";
                $stmt = $conn->prepare($query);
                $stmt->bindValue(1, $userID);
                if($stmt->execute()){ 
                //echo "<script> alert(\"Both email and language level are updated\")</script>";
                header('Location: ./EditDetails?Language&EmailUpdated=Successful');
                } else {
                    echo "There is no other profile available";
                }
            }
        }
    }

    function updateBio($userID, $user_custom_description){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;       
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $query = "UPDATE useraccount set user_custom_description='$user_custom_description'  WHERE user_ID =?";
        //echo htmlspecialchars($query) . "<br>";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(1, $userID);
        if($stmt->execute()){  
            //echo "<script> alert(\"Bio updated\")</script>";
            header('Location: ./EditDetails?BioUpdated=Successful');
        } else {
            echo "Please enter a value";
        }
    }


    function updatePassword($userID){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        global $languageLevel, $languageSkill;
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
       
        $query = "SELECT user_id, user_password FROM useraccount WHERE user_ID =?";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(1, $userID);
    
        if ($stmt->execute()) {
            //echo htmlspecialchars($query);
            $row = $stmt->fetch();    
            if ($row) {
                $db_password = $row['user_password'];
                $currentPassword = $_POST['currentPassword'];    
                $newPassword = $_POST['newPassword'];
                //encrypt the new password with BCRYPT
                $updatedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                if (password_verify($currentPassword, $db_password)) {
                    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);                   
                    $updatePasswordQuery = 'UPDATE useraccount SET user_password = ? WHERE user_ID = ?';
                    echo htmlspecialchars($updatePasswordQuery);
                    $stmt = $conn->prepare($updatePasswordQuery);
                    $stmt->bindParam(1, $updatedPassword);
                    $stmt->bindParam(2, $userID);
                    if ($stmt->execute()) {
                        header('Location: ./EditDetails?PasswordUpdated=Successful');
                    } else {
    
                    }
    
                } else {
    
                }
            } else {
    
            }
        } else {
    
        }
    }
    

    function deleteUserAccountDB($id){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;   
            //User ID in Form          
            if(logged_in_user_ID() == $id){
              echo "<script> alert('You cannot delete yourself') </script>";
            } else {
              //Using Named Placeholder
              $sql = "
                      DELETE FROM usersettings WHERE user_settings_user_id  = :id;
                      DELETE FROM userquery WHERE query_user_id = :id;
                      DELETE FROM sessionparticipants WHERE participant_user_id = :id;
                      DELETE FROM useraccount WHERE user_id = :id ";
              //Prepared Statement
              $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
              $result = $conn->prepare($sql);
              //Bind ID to Prepared Statment
              $result->bindParam(':id', $id, PDO::PARAM_INT);
              $result->execute();
          
              //Refresh
              echo "<meta http-equiv='refresh' content='0'>";
          
            }
    }


    
    //usermanagement.php    

    function getUserListDB() {

        global $DB_DSN, $DB_USER, $DB_PASSWORD;   
        global $query; 
        $query = '
            SELECT u.user_id, u.user_name, u.user_email, us.isOrganiser, user_english_skill, user_japanese_skill
            FROM useraccount u
            INNER JOIN usersettings us
            ON
            u.user_id = us.user_settings_user_id
                ';
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $stmt = $conn->prepare($query);  
        if($stmt->execute()){
            return $stmt->fetchAll();
        } else {
            return null;
        }

    }

    function chanageLagLelDB($lag_Level, $userID){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;  
        global $languageSkill;
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        //find primary language
        showNonPrimaryLanague($userID);
        //update non-primary language skill level       
        $queryUpdateLagLel = "UPDATE userAccount set $languageSkill='$lag_Level' WHERE user_id = ? ";
        echo htmlspecialchars($queryUpdateLagLel) . "<br>";    
        echo htmlspecialchars($languageSkill) . "<br>";        
        $stmt = $conn->prepare($queryUpdateLagLel);
        //Bind ID to Prepared Statment
        $stmt->bindValue(1, $userID);
        $stmt->execute();            
       // echo "<meta http-equiv='refresh' content='0'>";
        echo htmlspecialchars($queryUpdateLagLel) . "<br>";                                              
        echo "<script> alert(\"User language level updated\")</script>";
        echo htmlspecialchars($queryUpdateLagLel) . "<br>";    

    }


    function changeRoleDB ($isOrganiser, $id){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;  
        $queryRole = "UPDATE usersettings set isOrganiser = $isOrganiser WHERE user_settings_user_id = :id ";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);    
        $stmt = $conn->prepare($queryRole);
        //Bind ID to Prepared Statment
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();            
        echo "<meta http-equiv='refresh' content='0'>";                                        
        echo "<script> alert(\"User role updated\")</script>";

    }

    function createDummy($username, $primarylagSelected){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;       
        $query2 =   "
                        SELECT user_name
                        FROM useraccount
                        ORDER BY user_name ASC;
                    ";
        $conn2 = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $stmt2 = $conn2->prepare($query2);
        if($stmt2->execute()){
            $usernames;
            foreach($stmt2 as $row2){
                $usernames[] = strval($row2['user_name']);
            }
            $usernameInvalid = true;
            $iterator = 0;
            $newName = $username;
            $matchFound = false;
            while($usernameInvalid){  
                $matchFound = false;             
                    if(in_array(strval($newName), $usernames)){
                        $iterator++; 
                        $matchFound = true;
                        $newName =  $username . strval($iterator);
                    }
                if(!$matchFound){
                    $username = $newName;
                    $usernameInvalid = false;
                    break;
                }
                     
            }
            
            $email = $username . "@dummyAccount.com";
            $password = $email;  
            $password = password_hash($password, PASSWORD_BCRYPT);
            $query = "
                        INSERT INTO useraccount( user_name, user_email, $primarylagSelected, user_password) 
                        VALUES(?, ?, '3', '$password')
                        ";
            $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD); 
            $stmt = $conn->prepare($query);
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $email);
            if ($stmt->execute()) {

                $query0 = "select user_id from useraccount where user_name = ?";
                $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD); 
                $stmt0 = $conn->prepare($query0);
                $stmt0->bindParam(1, $username);

                if ($stmt0->execute()) {
                    foreach ($stmt0 as $row) {
                        $query1 = "
                                    INSERT INTO usersettings(user_settings_user_id, isOrganiser, user_is_dummy) 
                                    VALUES (?,'0', ?) 
                                ";
                        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD); 
                        $stmt1 = $conn->prepare($query1);
                        $stmt1->bindValue(1, $row['user_id']);
                        if(isset($_POST['dummyAccount'])){
                            $stmt1->bindValue(2, $_POST['dummyAccount']);
                        } else{
                            $stmt1->bindValue(2, '0');
                        }
                        $stmt1->execute();              
                        joinSessionSQL($row['user_id'], $_POST['sessionID']);
                    }
                    if ($stmt0->execute()) {
                        
                        //  echo "<script> alert('User setting updated ') </script>";
                        unset($_POST);
                        echo "<script> alert(\"Account created successfully\")</script>";
                        header('Location: sessionpage.php');
                    }

                } else {
                    echo "<script> alert(\"Record failed\")</script>";
                }
            
            } 
        }
        
    }

    function getUserIDfromUserName($username){
        $userID = 0;
        global $DB_DSN, $DB_USER, $DB_PASSWORD;  
        $query = "
                  SELECT user_id
                  FROM useraccount
                  WHERE user_name = ?
                 ";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $stmt = $conn->prepare($query);
        $stmt->bindValue(1, $username);
        if($stmt->execute()){
            foreach($stmt as $row){
                $userID = $row['user_id'];
            }
            if($userID > 0){
                return $userID;
            } else {
                return 1;
            }
            
        }
    }

    function getSessions(){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;  
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $sql = "
                    SELECT session_id, session_start_time, session_size, session_name, session_date, (
                      SELECT COUNT(sessionparticipants.participant_id)
                      FROM sessionparticipants 
                      WHERE sessionparticipants.participant_session_id =   
                      session.session_id) AS numberOfParticipants
                    FROM session 
                    ORDER BY session.session_date 
                    DESC
                   ";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute()){
                return $result = $stmt->fetchAll();
            } else {
                return null;
            }
            
    }

    function getSessionGroupNumbers($sessionID){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        $sql = "
                SELECT DISTINCT pair_id 
                FROM sessionparticipants
                WHERE participant_session_id = ? AND pair_id != ''
                ORDER BY pair_id ASC;
               ";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $sessionID);
        if($stmt->execute()){
            return $result = $stmt->fetchAll();
        } else {
            return null;
        }
    }

    function moveUserToGroup($sessionID, $userID, $newGroupID){
        global $DB_DSN, $DB_USER, $DB_PASSWORD;
        $sql = "
                UPDATE sessionparticipants 
                SET pair_id = ? 
                WHERE participant_session_id = ? 
                AND participant_user_id = ?;
               ";
        $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $newGroupID);
        $stmt->bindValue(2, $sessionID);
        $stmt->bindValue(3, $userID);
        if($stmt->execute()){
            return true;
        } else {
            return false;
        }
    }

?>
