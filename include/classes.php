<?php
require_once "functions.php";
require_once "utils.php";
require_once "auth.php";
require_once "api\data.php";

//User Class
class User {
    //Properties
    private $id;
    private $userName = "Default";
    private $userEmail;
    private $userJapSkill;
    private $userEngSkill;
    private $userImageRef = "profiledefault";
    private $userCustomInfo;
    private $isOrganiser;
    private $recentPairings = array();
     
    function __construct($id, $userName, $userEmail, $userJapanSkill, $userEnglishSkill){
        $this->id = $id;
        $this->userName = $userName;
        $this->userEmail = $userEmail;
        $this->userJapSkill = $userJapanSkill;
        $this->userEngSkill = $userEnglishSkill;
    }
    
    //Static method to call constructor
    static function constructUserFromDB($id){
        $userDetails = getCurrentUserDB($id);
        $userName = $userDetails[1];
        $userEmail = $userDetails[2];
        $userJapanSkill = $userDetails[3]; 
        $userEnglishSkill = $userDetails[4];
        $userImageRef = $userDetails[5];
        $userCustomInfo = $userDetails[6];
        $isOrganiser = $userDetails[7];
        $userCreated = $userDetails[8];
        $user = new User($id, $userName, $userEmail, $userJapanSkill, $userEnglishSkill);   
        $user->isOrganiser = $isOrganiser;
        $user->userCustomInfo = $userCustomInfo;
        
        if (strlen($userImageRef) > 2) {
            $user->userImageRef = $userImageRef;
        } else {
            $user->userImageRef = "profiledefault.jpg";
        }
       
        $user->userCreated = $userCreated;
        return $user;
    }

    function updateUserInDB($user){
        
    }

     

    //Prints user details used for testing
    public function toString() {
        echo "<br>" . $this->getUserName() . "<br>" . "Japanese Skill: " . 
            $this->getJapSkillString() . "<br>" . "English Skill: " . $this->getEngSkillString() . "<br>";
    }

    //Methods
    public function getID(){
        return $this->id;
    }

    public function getUserName(){
        return $this->userName;
    }

    public function getUserEmail(){
        return $this->userEmail;
    }


    public function langSkillToString($skillLevel){
        switch ($skillLevel) {
            case 0:
                return "Beginner";
                break;
            case 1:
                return "Intermediate";
                break;
            case 2:
                return "Fluent";
                break;
            case 3:
                return "Primary";
                break;
            default:
                return "Data Error";
        }
    }

    public function getNativeLanguage(){
        if($this->getUserJapSkill() == 3){
            return "Japanese";
        } else {
            return "English";
        }
    }

    public function getUserJapSkill(){
        return $this->userJapSkill;
    }
    public function getJapSkillString(){
        $skillLevel = $this->getUserJapSkill();
        $skillText = $this->langSkillToString($skillLevel);
        return $skillText;
    }
    public function getUserEngSkill(){
        return $this->userEngSkill;
    }
    public function getEngSkillString(){
        $skillLevel = $this->getUserEngSkill();
        return $this->langSkillToString($skillLevel);
    }

    public function getUserImageRef(){
        return $this->userImageRef;
    }

    public function getUserCustomInfo(){
        return $this->userCustomInfo;
    }

    public function getRecentPairings(){
        return $this->recentPairings;
    }

    public function getIsOrganiser(){
        return $this->isOrganiser;
    }

}

//Contains users
class Group {
    
    private $validPairing;
    private $participants = array();
    private $hasJapNat;
    private $hasEngNat;
    //Construct default empty group.
    public function __construct(){
        $this->validPairing = false;
        $this->hasJapNat = false;
        $this->hasEngNat = false;
    }

    public function getParticipants(){
        return $this->participants;
    }
    
    public function setParticipants($bool){
        $this->participants = $bool;
    }

    public function setHasJapNat($bool){
        $this->hasJapNat = $bool;
    }
    
    public function getHasJapNat(){
        return $this->hasJapNat;
    }

    public function setHasEngNat($bool){
        $this->hasEngNat = $bool;
    }
    
    public function getHasEngNat(){
        return $this->hasEngNat;
    }

    //Used to check if the pair has both a Primary japanese user and an english user.
    public function isValidPairing(){
        return $this->validPairing;
    }

    //Set group validity
    public function setValidPairing($bool){
        $this->validPairing = $bool;
    }

    //Check if appropriate Primary type is already in a group
    public function alreadyHasNat($user, $group){
        $hasNat = false;
        if ($user->getUserJapSkill() == 3) {
            $participants = $this->getParticipants();
            if($participants != NULL){
                foreach ($participants as $participant) {
                    if ($participant->getUserJapSkill() == 3) {
                        $hasNat = true;
                    }
                }
            }
        } else if ($user->getUserEngSkill() == 3) {
            $participants = $this->getParticipants();
            if($participants != NULL){
                foreach ($participants as $participant) {
                    if ($participant->getUserEngSkill() == 3) {
                        $hasNat = true;
                    }
                }
            }
        }
        return $hasNat;
    }
    
    
    public function checkPairHistory($user, $group){
        $pairedRecently = false;
        if($user->getRecentPairings() != null){
            $participants = $this->getParticipants();
            if($participants != NULL){
                foreach ($participants as $participant) {
                    if (in_array($participant->getID(), $user->getRecentPairings())) {
                        $pairedRecently = true;
                    }
                }
            }
        }
        return $pairedRecently;
    }
}

//Session containing groups
class Session {
    
    private $sessionName;
    private $sessionTime;
    private $sessionDate;
    private $numberOfParticipants;
    private $groupsArray = array();
    
    //Constructor for a session object
    public function __construct($time, $date, $numberOfParticipants, $sessionName){
        $this->groupsArray = array(new Group());
        $this->setSessionName($sessionName);
        $this->setSessionTime($time);
        $this->setSessionDate($date);
        $this->setNumberOfParticipants($numberOfParticipants);
        
    }

    //Adds users to the session by sorting them into the groups.
    public function addUsers($userArray){
        $userArray = randomiseArray($userArray);
        $unsortedUsers = array();
        
        //Iterates through users
        if($userArray != NULL){
            
            for ($i = 0; $i < count($userArray); $i++) {
                $user = $userArray[$i];
    
                //Boolean to control while loop, is user paired?
                $userPaired = false;
    
                //Keep looping
                while (!$userPaired) {
    
                    //Loops through groups
                    $groupsArray = $this->getGroupArray();
                    
                    $groupNo = 0;
                    foreach ($groupsArray as $group) {
                        
                        //Checks if group already has a valid pair, one Nat Japanese and one Nat English user
                        if ($group->isValidPairing()) {
                            //Do nothing
                        } else {
                            //Check if the group already has a Primary language speaker the same as user or if the users have been paired recently.
                            if ($group->alreadyHasNat($user, $group) || $group->checkPairHistory($user, $group)) {
                                //Do nothing
    
                            } else {
                                //Add user to the group
                                $groupParts = $group->getParticipants();
                                $groupParts[] = $user;
                                $group->setParticipants($groupParts);                          
    
    
                                //Logic for pairing history goes here!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                                
                                //Set group boolean to have this Nat type
                                if ($user->getUserJapSkill() == 3) {
                                    $group->setHasJapNat(true);
                                } else if ($user->getUserEngSkill() == 3) {
                                    $group->setHasEngNat(true);
                                }
                                //Set group to valid if it has both Nat types
                                if ($group->getHasJapNat() == true && $group->getHasEngNat() == true) {
                                    $group->setValidPairing(true);
                                }
    
                                //Remove User from the userArray
                                //unset($userArray[$i]);
                                
                                //Update group array
                                $this->setGroupArray($groupsArray);
                                
                                //Exit while loop
                                $userPaired = true;
                                break;
                            }
                        }
                        
                        if($groupNo == (count($groupsArray) - 1)){
                            $groupsArray[] = new Group();
                        }
                        $groupNo++;
                    }
                    $this->setGroupArray($groupsArray);
                }
            }
            //Dissolve inValid groups for resorting
            $groupsArray = $this->getGroupArray();
            $validGroups = array();
            for ($i = 0; $i < count($groupsArray); $i++) {
                $group = $groupsArray[$i];
                if ($group->isValidPairing()) {
                    $validGroups[] = $group;
                } else {
                    if($group->getParticipants() != NUll) {
                        foreach ($group->getParticipants() as $participant) {
                            $unsortedUsers[] = $participant;
                        }
                        /*
                        if ($group->isValidPairing()) {
                            $validGroups[] = $group;
                        }
                        */
                        //unset($groupsArray[$i]);
                    }
                }
            }
            
            $this->setGroupArray($validGroups);
            
        }
        return $unsortedUsers;
    }
    
    public function sortRemainingUsers($unsortedUsers){
        $groupsArray = $this->getGroupArray();
        if(count($unsortedUsers) > 0){
            if(count($unsortedUsers) <2){
                $randomGroupIndex = rand(0, (count($groupsArray)-1));
                $randomGroup = $groupsArray[$randomGroupIndex];
                $parts = $randomGroup->getParticipants();
                $parts[] = $unsortedUsers[0];
                $randomGroup->setParticipants($parts);
                $groupsArray[$randomGroupIndex] = $randomGroup;
            }else{
                //Checks if array length is even
                if(count($unsortedUsers) % 2 == 0){
                    for($i = 0; $i < count($unsortedUsers); $i += 2){
                        $pair = [$unsortedUsers[$i], $unsortedUsers[$i + 1]];
                        $newGroup = new Group();
                        $newGroup->setParticipants($pair);
                        $groupsArray[] = $newGroup;
                        
                    }
                } else {
                    for($i = 0; $i < count($unsortedUsers)-3 ; $i += 2){
                        $pair = [$unsortedUsers[$i], $unsortedUsers[$i + 1]];
                        $newGroup = new Group();
                        $newGroup->setParticipants($pair);
                        $groupsArray[] = $newGroup;
                    }
                    $pair = [$unsortedUsers[$i], $unsortedUsers[$i + 1], $unsortedUsers[$i + 2]];
                    $newGroup = new Group();
                    $newGroup->setParticipants($pair);
                    $groupsArray[] = $newGroup;
                }
            }
            $this->setGroupArray($groupsArray);
        }
    }

    //Stores a new session object in the database
    public function storeObject(){
         return storeSessionDB($this->sessionTime, $this->numberOfParticipants, $this->sessionDate, $this->sessionName);
        /*
            $query =    "
                        INSERT INTO session (session_start_time, session_size, session_date, session_name)
                        VALUES (?, ?, ?, ?);
                        ";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(1, $this->sessionTime);
            $stmt->bindValue(2, $this->numberOfParticipants);
            $stmt->bindValue(3, $this->sessionDate);
            $stmt->bindValue(4, $this->sessionName);
            if($stmt->execute()){
                echo "<script> alert('". $this->getSessionName() ."') </script>";
                return true;
            } else {
                echo "<script> alert('Database Error') </script>";
                return false;
            }
        */

    }

    
    public function getGroupArray(){
        return $this->groupsArray;
    }
    
    public function setGroupArray($array){
        $this->groupsArray = $array;
    }

    public function getSessionName(){
        return $this->sessionName;
    }

    public function setSessionName($sessionName){
        $this->sessionName = $sessionName;
    }

    public function setSessionTime($time){
        $this->sessionTime = $time;
    }

    public function getSessionTime(){
        return $this->sessionTime;
    }

    public function setSessionDate($date){
        $this->sessionDate = $date;
    }

    public function getSessionDate(){
        return $this->sessionDate;
    }

    public function setNumberOfParticipants($number){
        $this->numberOfParticipants = $number;
    }

    public function getNumberOfParticipants(){
        return $this->numberOfParticipants;
    }

}
