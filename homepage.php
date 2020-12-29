<?php
include "include/sidebar.php";
?>

<!-- Homepage -->
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <div class="grid-container">
    <main class="main">
      <div class="main-cards">
        <div class="leftSideCards">
          <div class="card">
            <h1>Sessions</h1>

            <?php                      
              // delete usession
              if(isset($_POST['deleteSession'])){
                //  User ID in Form
                $sessionID = $_POST['id'];
                deleteSessionDB($sessionID); 
              }

              ?>
                 
            <?php //Redundant Code
            $sessionList = getSessions();
            //var_dump($sessionList);
            if ($sessionList != null) :
              foreach ($sessionList as $row) :
            ?>
                <div class="sessionCard">
                  <div class="sessionText">
                   
                    <?php
                    $date = date_create(htmlentities($row['session_date']));
                    echo date_format($date, "d/m/Y");
                    ?>

                    <?php
                    $time = date_create(htmlentities($row['session_start_time']));
                    echo date_format($time, "g:iA");
                    ?>



                  </div>
                  
                  <!-- Populating Session List -->
                  <form action=ViewSession method="POST">
                    <div class="sessionHeading">

                      <?php echo htmlentities($row['session_name']); ?> <br>
                      Users:
                      
                      <?php
                      echo htmlentities($row['numberOfParticipants']);
                      ?>
                      /
                      <?php
                      echo htmlentities($row['session_size']);
                      ?>

<!-- Where I want to put buttons for mobile<div>
                      <button class="" type="submit">
                        View
                      </button>
                      </div> -->

                      
                    </div>

                    <input type="hidden" name="sessionID" value="<?php echo htmlentities($row['session_id']); ?>">

                    <div>
                      <button class="sessionButton" type="submit">
                        View
                      </button>
                      </div>
                    
                  
                  
                  </form>
                  <?php                 
                  if (is_Organiser()) {                 
                  ?>
                  <form class="SessionForm" action="" method="POST">                

                    <input type="hidden" name="id" value="<?php echo htmlentities($row['session_id']); ?>">
                      <button class="DeleteButton" type="submit" name="deleteSession" value="deleteSession" onClick="return confirm('Are you sure you want to delete?')">
                      ❌
                      </button>
                      
                    

                  </form>
                  <?php
                    }
                ?>

                
                
                </div>

                
                    
                
            
            <?php
              endforeach;
            endif;
            ?>

          </div>
        </div>
        
        <?php
        include "include/rSideBar.php";
        //echo var_dump($_SESSION);
        // echo  $_SESSION['currentUser']->getUserName() . '<br>';
        // echo  $_SESSION['currentUser']->getID() .'<br>';
        // echo  $_SESSION['currentUser']->getUserEmail() . '<br>';
        // echo  $_SESSION['currentUser']->getNativeLanguage();
        ?>

    </main>
  </div>
</body>
</html>