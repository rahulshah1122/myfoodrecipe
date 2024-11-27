<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Contributors</title>
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            margin: 20px;
        } */
        h1 {
            text-align: center;
        }
        table {
            margin:30px;
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .coupon-badge img {
            width: 100px; /* Adjust the width as needed */
            height: auto; /* Maintain aspect ratio */
            padding: 5px;
            border-radius: 5px;
            display: block;
            margin: auto;
        }
    </style>
</head>
<body>
<section id="headersection">
    <div>
      <ul id="navigationbar">
        <li><a href="index.php">Home</a></li>
        <li><a href="contact.php">Contact</a></li>
        <?php
    // Check if session is set to admin_id or if any user is logged in
    if (isset($_SESSION['admin_id']) || isset($_SESSION['user_id'])) {
        // Display the "Add Recipe" link
        echo '<li><a href="addrecipe.php">Add Recipe</a></li>';
    }
?>


        <?php
        if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
            echo '<li><a href="logout.php">Logout</a></li>';
        } else {
            echo '<li><a href="login.php">Login</a></li>';
        }
        ?>
        <li><a href="Register.php">Register</a></li> 
        <?php
        // Check if session is set to admin_id
        if (isset($_SESSION['admin_id'])) {
            // Display the "Admin Dashboard" link
            echo '<li><a href="admin_dashboard.php">Admin Dashboard</a></li>';
        }
        ?>
      </ul>
    </div>
  </section>

  <div class="background">
  <h2 style="font-size: 30px; 
  width:140px; 
  color: #fff; 
  margin-top: 10px; 
  margin-bottom: 20px; 
  margin-left: 32px; 
  font-weight: bold; 
  padding: 10px 20px; 
  border: 2px solid #000; 
  background-color:rgba(0, 0, 0, 0.5);">Cuisine</h2>
    <section id="categorybox" class="section-p1">
    </section>
    </div>

    <h1>Top Contributors</h1>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Contact</th>
                <th>Recipe</th>
                <th>Updated Date</th>
                <th>Coupon</th>
            </tr>
        </thead>
        <tbody>
            <?php
            require_once 'connect_db.php';
            session_start();
    
            // Step 1: Retrieve users with recipes having an average rating of 5
            $query = "SELECT u.Username, u.user_contact, r.RecipeName, r.DateSubmitted
                      FROM users u
                      INNER JOIN recipes r ON u.UserID = r.UserID
                      WHERE r.RecipeID IN (
                          SELECT RecipeID
                          FROM ratings
                          GROUP BY RecipeID
                          HAVING AVG(Rating) = 5
                      )";

            $result = mysqli_query($conn, $query);

            if (!$result) {
                die('Query failed: ' . mysqli_error($conn));
            }

            // Step 2: Display the retrieved information in table rows
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['Username']}</td>";
                echo "<td>{$row['user_contact']}</td>";
                echo "<td>{$row['RecipeName']}</td>";
                echo "<td>{$row['DateSubmitted']}</td>";
                
                // Step 3: Display coupon as an attractive badge
                echo "<td class='coupon-badge'><img src='badge.jpeg' alt='Coupon'></td>";
                
                echo "</tr>";
            }

            // Step 4: Free result set
            mysqli_free_result($result);

            // Step 5: Close connection
            mysqli_close($conn);
            ?>
        </tbody>
    </table>

    <footer class="footer-section">
    <h5 style="text-align: center; font-size: 24px; color: #333; margin-top: 20px;">Thank You For Your Visit</h5>
  </footer>
</body>
</html>
