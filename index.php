<?php

//Connecting with data base
$servername = "localhost";
$username = "root";
$password = "";
$database = "projects";

$conn = mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    echo "There is some problem unable to establish a connection". mysqli_connect_error();
}

if (isset($_GET['delete'])) {
  $sno = $_GET['delete'];
  // $delete = true;
  $sql = "DELETE FROM `notes` WHERE `sno` = $sno";
  $result = mysqli_query($conn, $sql);

} 


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if (isset($_POST['snoedit'])) {

    $sno = $_POST['snoedit'];
    $title = $_POST['titleedit'];
    $desc = $_POST['descedit'];

    $updatesql = "UPDATE `notes` SET `title` = '$title', `desc` = '$desc' WHERE `notes`.`sno` = $sno";
    $updateresult = mysqli_query($conn,$updatesql);

    if (!$updateresult) {
        echo mysqli_error($conn);
    }

  } 

  else {
            $title =  $_POST['title'];
            $description =$_POST['desc'];

            $insertsql = "INSERT INTO `notes` (`sno`, `title`, `desc`, `dt`) VALUES (NULL, '$title', '$description', current_timestamp())";

            $insertresult = mysqli_query($conn,$insertsql);
  
 }

  
} 

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

  <title>Magic Notes- A complete solution for saving your notes</title>
</head>

<body>
  <!--Edit Modal-->
  <div class="modal" id="editmodal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Your Notes Here</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- this form is for updating -->
          <form action="/phpprojects/inotes/index.php" method="POST" class="mx-5">
          <input type="hidden" id="snoedit" name="snoedit">
            <div class="mb-3 form-group">
              <label for="titleedit" class="form-label">
                <h5>Title</h5>
              </label>
              <input type="text" class="form-control" id="titleedit" name="titleedit" aria-describedby="emailHelp">
            </div>
            <div class="my-4 form-group">
              <label for="descedit" class="form-label">
                <h5>Add Note Here</h5>
              </label>
              <textarea class="form-control" id="descedit" name="descedit" rows="3"></textarea>
            </div>
            <hr>
            <button type="submit" class="btn btn-primary">Update Edit</button>
            <a href="/phpprojects/inotes/index.php" class="btn btn-secondary">Close</a>
          </form>
        </div>
        <hr>
      </div>
    </div>
  </div>

  <!-- Navbar -->

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Magic Notes</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
        </ul>
        </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" id="search" name="search" placeholder="Search" aria-label="search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>


  <!--Main-Container-->

  <div class="container my-4">
    <form action="/phpprojects/inotes/index.php" method="POST" class="mx-5">
      <div class="mb-3 form-group">
        <label for="title" class="form-label">
          <h2>Title</h2>
        </label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
      </div>
      <div class="my-4 form-group">
        <label for="desc" class="form-label">
          <h3>Add Note Here</h3>
        </label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
      <a href="/phpprojects/inotes/index.php" class="btn btn-primary">Done</a>
    </form>
    <div class="container">

    <table class="table table-striped mt-4">
      <thead>
        <tr>
          <th scope="col">S no.</th>
          <th scope="col">Title</th>
          <th scope="col">Desciption</th>
          <th scope="col">Action</th>
        </tr>
      </thead>

      <tbody>
        <!--This php code block is for fetching data from server and inserting data-->
        <?php

    $searchsql = 'SELECT * FROM `notes`';
    $searchresult = mysqli_query($conn,$searchsql);

    $snum=0;
    while ($row = mysqli_fetch_assoc($searchresult)) {
          $snum++;
        echo "<tr>
        <th scope='row'>".$snum."</th>
        <td>".$row['title']."</td>
        <td>".$row['desc']."</td>
        <td><button class='edit btn btn-sm btn-primary' id=".$row['sno']."> &nbsp Edit &nbsp; </button> <br><br><button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button></td>
      </tr>"; 
    }


    ?>
      </tbody>
    </table>
    </div>


  </div>


  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
    crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    -->
  <script>
//this is for edit button
    edit = document.getElementsByClassName('edit');
    Array.from(edit).forEach((element) => {
      element.addEventListener('click', (e) => {

        snoedit.value=e.target.id;

        //this is to toggle modal only
        var myModal = new bootstrap.Modal(document.getElementById('editmodal'));
        var modalToggle = document.getElementById('editmodal'); // relatedTarget
        myModal.show(modalToggle);
      })
    })

//This is for delete button

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener('click', (e) => {
        sno = e.target.id.substr(1);

        if (confirm("Are you sure you want to delete this")){
          console.log("yes");
          window.location = `/phpprojects/inotes/index.php?delete=${sno}`;
          // window.location = `/phpprojects/inotes/index.php`;
          
        }
        else{
          console.log("You opt for not to delete this item");
        }

      })
    })

  </script>
</body>

</html>