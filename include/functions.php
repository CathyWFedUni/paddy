<?php 
require_once "config.php";   
require_once "api\data.php";
$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
?>

<?php   
function swapArrayValues($array, $a, $b){
    $x = $array[$a];
    $y = $array[$b];
    $array[$a] = $y;
    $array[$b] = $x;
    return $array;
}
function randomiseArray($array){
    $j = (count($array)-1);
    while($j>1){
        $k = floor(($j) * rand(0, 1));
        $array = swapArrayValues($array, $j, $k);
        $j--;
    }
    return $array;
}

?>

<?php             
 // delete user function from user managment page
 if(isset($_POST['delete'])){
  //  User ID in Form
   $id = $_POST['id'];
   deleteUserAccountDB($id); 
 }
   


if(isset($_POST['changeLanguageLevel']) && ($_POST['changeLanguageLevel'])!= ""){
  //checking primary language
  if(isset($_POST['lag_Level'])){    
    $lag_Level = $_POST['lag_Level'];                    
    $userID = $_POST['id']; 
    chanageLagLelDB($lag_Level, $userID);
   
} else {
    echo "Current language level not found";

  }
}

  // update user role from user managment page             
if(isset($_POST['changeRole'])&& ($_POST['role'])!= ""){              
  if(isset($_POST['role'])){  
      
      $isOrganiser = $_POST['role'];                    
      $id = $_POST['id'];      
      //echo "<script> alert(".htmlspecialchars($isOrganiser).")</script>"; 
      changeRoleDB ($isOrganiser, $id); 
     
  } else {
      echo "Current role not found";
  }
}               
  
?>