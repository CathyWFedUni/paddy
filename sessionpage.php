<!DOCTYPE html>
<html lang="en">

<head>
  <title>Session</title>
</head>

<body>


<!-- <div class="background_homepage"> -->
<div class="grid-container">
  <?php
  //var_dump($_POST);
    include "include/sidebar.php";
    
    require_once "api\data.php";

  ?>
  <?php
    if(isset($_POST['joinAction']) && isset($_POST['sessionID'])){
      $userID = logged_in_user_ID();
      $sessionID = htmlentities($_POST['sessionID']);
      joinSessionSQL($userID, $sessionID);
    }
  ?>
  
  <?php 
  if(isset($_POST['sessionID'])){
    $sessionID = $_POST['sessionID'];
    $_SESSION['currentSession'] = $sessionID;
  } else {
    $sessionID = $_SESSION['currentSession'];
  }

  if(isset($_POST['pairUsers'])){
    if($_POST['pairUsers'] =='true'){
      pairUsersSQL($sessionID);
    }
  }

  if(isset($_POST['moveUser']) && isset($_POST['id']) && $_POST['group']){
      moveUserToGroup($_SESSION['currentSession'], $_POST['id'], $_POST['group']);
  }
  
  
  $getCurrentSessionDetail = getCurrentSessionDetail($sessionID);
  $noParticipants = $getCurrentSessionDetail[0];
  $sessionSize = $getCurrentSessionDetail[1];
  $sessionID = $getCurrentSessionDetail[2];
  $sessionName = $getCurrentSessionDetail[3];
              
              
  ?>

  <main class="main">
    <div class="main-cards">
    <div class="leftSideCards">
      <div class="card">
        <h1><?php echo $sessionName; ?></h1>
        <h2>Members <?php echo $noParticipants; ?>/<?php echo $sessionSize; ?></h2>
        <h2>Session Status: Waiting</h2>

        <div class="background-form-btn">
          <form action='' method ='POST'>
            <input type = 'hidden' name="joinAction" value='true'>
            <input type = "hidden" name="sessionID" value="<?php echo $sessionID;?>">
            <button name="join" class="joinbutton" type='submit'>Join Session</button>
          </form>
        </div>
        <?php if(is_Organiser()):?>
        <div class="buttonset">

          <form action='' method='POST'>
            <input type = 'hidden' value='true' name='pairUsers'>
            <input type = "hidden" name="sessionID" value="<?php echo $sessionID;?>">
            <button type='submit' name='pairButton' class="inline-button">Pair Members</button>
          </form>

            <button name="addGuest" class="inline-button" onclick="document.getElementById('popupForm').style.display='block'" style="width:auto;">Create Guest</button>
          
          <!-- Add guest -->
          <div id='popupForm' class="guestForm">
            <span onclick="document.getElementById('popupForm').style.display='none'" class="guestFormExit" title="Close Form">&times;</span>
              <form action='dummyFunction.php' method='POST'  class='guestForm-content'>
              
                <div class="addGuestFormWindow">
                  <span class="login_form-title">
                    Add Guest
                  </span>
                  <hr>
                  <label for="username"><b>Username</b></label>
                  <input required class="input" type="text" name="username" placeholder="Username">
                  <input type = "hidden" name="sessionID" value="<?php echo $sessionID;?>">
                  <select required class="input" name="primarylag">
						          <option value="" disabled selected hidden>Preferred Language</option>
							        <option value="English">English</option>
							        <option value="Japanese">Japanese</option>
                  </select>
                  <input class="input" type="hidden" name="dummyAccount" value ="1">
                  <div class="background-form-btn">
                    <button class="login_form-btn" type="submit" class="btn" name="reg_user" value="true">
                      Register
                    </button>
                  </div>
                </div>
              </form>
          </div>
       


          

          <!--
          <button name="Join" class="inline-button">Kick</button>
          <button name="Join" class="inline-button">Ban</button>
            -->
        </div>
        <?php endif; ?>

      
<!-- Need to made external -->
        <script>
          function searchName() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
              td = tr[i].getElementsByTagName("td")[0];
              if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                  tr[i].style.display = "";
                } else {
                  tr[i].style.display = "none";
                }
              }
            }
          }
        </script>

        <input class="input" type="text" id="myInput" onkeyup="searchName() " placeholder="Search for names.." title="Type in a name">
        
        
        <table class="sessiontable" id="myTable">
          <thead>
            <tr>
              <th>Username&nbsp;</th>
              <th>&nbsp;Email</th>
              <th>Preferred Language&nbsp;</th>
              <th>Role&nbsp;</th>
              <th>Pair&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $participants = getSessionParticipants($sessionID);
              if($participants != null){
                foreach($participants as $row3){
                  $prefLang;
                  if($row3['user_japanese_skill'] > $row3['user_english_skill']){
                    $prefLang = "Japanese";
                  } elseif($row3['user_japanese_skill'] < $row3['user_english_skill']) {
                    $prefLang = "English";
                  } else {
                    $prefLang = "None";
                  }
                  $role;
                  if($row3['isOrganiser'] == 1){
                    $role = "Organiser";
                  } else {
                      if($row3['user_is_dummy'] == 1){
                          $role = "Guest";
                      } else {
                          $role = 'User';
                      }
                    
                  }
                  echo
                  "
                  <tr>
                    <td>" . htmlentities($row3['user_name']). "</td>
                    <td>" .   htmlentities($row3['user_email']). "</td>
                    <td>" .   htmlentities($prefLang). "</td>
                    <td>" .   htmlentities($role). "</td>
                    <td>" .   htmlentities($row3['pair_id']). "</td>
                    <td>
                      <form action='' method='POST'>                   
                        <select name='group' >
                          <option value=''>Select...</option>
                          "; 
                            $groupList = getSessionGroupNumbers($_SESSION['currentSession']);
                            //var_dump($groupList);
                            $groupNumber = count($groupList);
                            $i;
                            for($i = 1; $i <= $groupNumber; $i++){
                              echo 
                                "
                                  <option value = '" . htmlentities($i) . "'>" . 
                                    htmlentities($i)
                                  ."</option>
                                ";
                            }
                            echo 
                                "
                                  <option value = '" . htmlentities($i) . "'>" . 
                                    'Create Group'
                                  ."</option>
                                ";
                          echo 
                          "
                        </select>                     
                        <input type='hidden' name='id' value='". htmlentities($row3['user_id']) ."' >  
                        <input type='submit' class='table-button' name='moveUser' value='Move'></input>                    
                      </form>
                    </td>
                  </tr>
                  ";
                }
              }
            ?>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
      <?php
      //echo var_dump($_POST);
    include "include/rSideBar.php";
  ?>  
    </div>

  </main>

</div>
<!-- </div> -->




</body>

</html>