<!DOCTYPE html>
<html lang="en">

<head>
  <title>User Management</title>
</head>


<body>

  <div class="grid-container">
    <?php include "include/sidebar.php";
    if (is_Organiser()) {
    } else {
      header("Location: homepage.php");
    }
    
    ?>
    <main class="main">

      <div class="main-cards">
        <div class="card">
          <h1>User Management</h1>
          <input class="input" type="text" id="myInput" onkeyup="searchName() " placeholder="Search for names.." title="Type in a name">

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

        <div class="ResponsiveTable">
          <table class="sessiontable" id="myTable">
            <thead>
              <tr>
                <th>Username&nbsp;</th>
                <th>&nbsp;Email</th>
                <th>Language&nbsp;</th>
                <th>&nbsp;Language Level</th>
                <th>Role&nbsp;</th>
                <th>&nbsp;Update Role</th>
                <th>Actions&nbsp;</th>
              </tr>
            </thead>
            <tbody>

              <?php             
              // Get the list of results for this user
              $users = getUserListDB();

              //echo htmlspecialchars($query);           
              
              foreach ($users as $row) :
                    $userID = htmlentities($row['user_id']);
                    $userName = htmlentities($row['user_name']);
                    $userEmail = htmlentities($row['user_email']);
                    $isOrganiser = htmlentities($row['isOrganiser']);
                    $userJapSkill = htmlentities($row['user_japanese_skill']);
                    $userEngSkill = htmlentities($row['user_english_skill']);

              ?>

              <tr>
                <td><?php echo $userName ?></td>
                <td><?php echo $userEmail ?></td>
                <td><?php
                //adding check so only non-primary language level shows  
                          if ($userEngSkill != 3) {                              
                            switch ($userEngSkill) {
                              case 0:
                                echo "English - Beginner";
                                break;
                              case 1:
                                echo "English - Intermediate";
                                break;
                              case 2:
                                echo "English - Fluent";
                                break;
                              }

                          }elseif($userJapSkill != 3) {

                            switch ($userJapSkill) {

                              case 0:
                                echo "Japanese - Beginner";
                                break;
                              case 1:
                                echo "Japanese - Intermediate";
                                break;
                              case 2:
                                echo "Japanese - Fluent";
                                break;                    
                            }
                          
                          } ?>
                </td>
                <td>
                  <form action="" method="POST">                   
                    <select name="lag_Level" >
                      <option value='' disabled selected hidden>Select...</option>
                      <option value="2">Fluent</option>
                      <option value="1">Intermediate</option>
                      <option value="0">Beginner</option>
                    </select>                     
                    <input type="hidden" name="id" value='<?php echo $userID ?>' >  
                    <input type="submit" class="table-button" name="changeLanguageLevel" value="Update">                    
                  </form> 
                </td>
                <td><?php if ($isOrganiser == 1) {
                      echo "Organiser";
                    } else {
                      echo "Member";
                    } ?>
                </td>
                <td>
                  <form action="" method="POST">                   
                    <select name="role" >
                      <option value="">--- Select ---</option>
                      <option value="1">Organiser</option>
                      <option value="0">member</option>
                    </select>                     
                    <input type="hidden" name="id" value='<?php echo $userID ?>' >  
                    <input type="submit" class="table-button" name="changeRole" value="Update">                    
                  </form> 
                </td>
                <td>
                  <form action="" method="POST">
                    <input type="hidden" name="id" value='<?php echo $userID ?>' >
                    <input type="submit" class="delete-user-button" name="delete" value="Delete" onClick="return confirm('Are you sure you want to delete?')">
                    </form> 
                </td>
              </tr>

              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        </div>
        <?php
        include "include/rSideBar.php";
       
        ?>
      </div>

    </main>

  </div>

</body>

</html>