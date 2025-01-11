<?php
      require '../../../../db.php';
      if (isset($_POST['id'])) {
          $id = $_POST['id']; 
  
          $query = "DELETE FROM users WHERE id = ?";
          $stmt = $conn->prepare($query);
          $stmt->bind_param("i", $id);
  
          if ($stmt->execute()) {
              header("Location: ../../web/admin-user.php");
              exit();
          } else {
              echo "Error deleting user.";
          }
      }
?>
