<?php
include 'db.php';

if (isset($_POST['save'])){

   $name   = $_POST['name'];
   $email  = $_POST['email'];
   $mobile = $_POST['mobile'];
   $status = $_POST['status'];

   //PHP Validation

   if (empty($name) || empty($email) || empty($mobile)){
      echo "All fields are required";
      exit;
   }
    
   if(isset($_FILES['photo']) && $_FILES['photo']['error']==0){
      $file_name = $_FILES['photo']['name'];
      $photo_path = "photos/" .$file_name;

      move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
   }

   $conn->query("INSERT INTO students (photo,name, email, mobile, status)
   VALUES ('$photo_path','$name', '$email', '$mobile', '$status')");

   header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Add Student</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
      <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.min.css" rel="stylesheet">
   </head>
   <body>
      <div class="container mt-5">
         <div class="row">
            <div class="d-flex justify-content-between">
               <h3>Add New Student</h3>
               <a href="index.php" class="btn btn-warning">View Students</a>
            </div>
         </div>
         <form id="studentForm" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
               <label class="form-label">Photo<i class="text-danger">*</i></label>
               <input type="file" class="form-control" name="photo" id="photo">
            </div>
            <div class="mb-3">
               <label class="form-label">Name<i class="text-danger">*</i></label>
               <input type="text" class="form-control" name="name" id="name">
                
               <small class="text-danger" id="name_error"></small>
            </div>
            <div class="mb-3">
               <label class="form-label">Email<i class="text-danger">*</i></label>
               <input type="text" class="form-control" name="email" id="email">
                  
               <small class="text-danger" id="email_error"></small>
            </div>
            <div class="mb-3">
               <label class="form-label">Mobile<i class="text-danger">*</i></label>
               <input type="text" class="form-control" name="mobile" id="mobile">
                 
               <small class="text-danger" id="mobile_error"></small>
            </div>
            <div class="mb-3">
               <label class="form-label">Status<i class="text-danger">*</i></label>
               <select class="form-select" name="status" id="status">
                  <option value="">-- Select Status --</option>
                  <option value="1" >Active</option>
                  <option value="0" >Inactive</option>
               </select>
               <small class="text-danger" id="status_error"></small>
            </div>
            <button type="submit" name="save" class="btn btn-primary">Submit</button>
            <a href="create.php" class="btn btn-secondary">Back</a>
         </form>
      </div>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script>
         $("#studentForm").submit(function(e){
         
             // Clear old error messages
             $("small.text-danger").text("");
         
             let isValid = true;
         
             let name   = $('#name').val().trim();
             let email  = $('#email').val().trim();
             let mobile = $('#mobile').val().trim();
             let status = $('#status').val();
         
             if(name === ""){
                 Swal.fire('Error','Name is required !')
                 isValid = false;
             }
         
             if(email === ""){
                 Swal.fire('Error','Email is required !')
                 isValid = false;
             } else {
                 let pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                 if(!pattern.test(email)){
                     $("#email_error").text("Enter a valid email!");
                     isValid = false;
                 }
             }
         
             if(mobile === ""){
                 Swal.fire('Error','Mobile is required !')
                 isValid = false;
             } else if(!/^[0-9]{10}$/.test(mobile)){
                 $("#mobile_error").text("Mobile must be 10 digits!");
                 isValid = false;
             }
         
             if(status === ""){
                 $("#status_error").text("Select a status!");
                 isValid = false;
             }
         
             if(!isValid){
                 e.preventDefault(); // stop submit if client-side invalid
             }
         
            //  $.ajax({
            //      url: '',
            //      type: 'POST',
            //      data: $(this).serialize()+'&save=1',
            //      dataType:'json',
            //      success: function(response){
            //          if(response.status === 'success'){
            //              Swal.fire('Success',response.message, 'success');
            //              $('#studentForm')[0].reset();
            //          }
            //          else{
            //              Swal.fire('Error',response.message, 'success');
            //          }
            //      },
            //      error: function(){
            //          Swal.fire('Error','Something went wrong !', 'error');
            //      }
            //  });
         });
      </script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.3/dist/sweetalert2.all.min.js"></script>
   
      <!-- <script>
         Swal.fire({
             title: "Success!",
             text: "Student added successfully!",
             icon: "success",
             confirmButtonText: "OK"
         }).then(() => {
             window.location.href = "index.php";
         });
      </script> -->
    
   </body>
</html>