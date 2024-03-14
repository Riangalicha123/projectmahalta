
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mahalta-Staff</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>admin/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<!-- Site wrapper -->
<div class="wrapper">
<?php include(__DIR__ . '/../../Admin/include/loader.php'); ?>
  <!-- Navbar -->
  <?php include(__DIR__ . '/../../Admin/include/navbar.php'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php include(__DIR__ . '/../../Admin/include/logo.php'); ?>

    <!-- Sidebar -->
    <?php include(__DIR__ . '/../../Admin/include/sidebar.php'); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Restaurant Services</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Restaurant Services</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Restaurant Services</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                    Add
                    </button>

                    <!-- Modal -->
                    <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Add Table</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/addserviceTable" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                <div class="form-group">
                                    <label for="VenueName">Venue Name</label>
                                      <select class="custom-select form-control-border" id="VenueName" name="VenueName" required>
                                        <option >Main Restaurant</option>
                                        <option >Venue 2</option>
                                        <option >Venue 3</option>
                                      </select>
                                </div>
                                <div class="form-group">
                                    <label for="VenueCapacity" >Status</label >
                                    <input type="number" class="form-control" id="VenueCapacity" name="VenueCapacity"  required>
                                </div>
                                <div class="form-group">
                                    <label for="AvailableCapacity" >Status</label >
                                    <input type="number" class="form-control" id="AvailableCapacity" name="AvailableCapacity"  required>
                                </div>
                                <div class="form-group">
                                    <label for="Image">Upload</label>
                                    <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" required>
                                </div>
                                
                                
                                
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Room Modal -->
                    <?php foreach ($venues as $venue): ?>
                    <div class="modal fade" id="editModal<?=$venue['VenueID']?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?=$venue['VenueID']?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?=$venue['VenueID']?>">Edit Table</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('/updateserviceTable/') ?>" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                <input type="hidden" name="VenueID" id="VenueID" value="<?=$venue['VenueID']?>">
                                
                                <div class="form-group">
                                    <label for="VenueName">Venue Name</label>
                                      <select class="custom-select form-control-border" id="VenueName" name="VenueName" required>
                                        <option <?= ($venue['VenueName'] == 'Main Restaurant') ? 'selected' : '' ?>>Main Restaurant</option>
                                        <option <?= ($venue['VenueName'] == 'Venue 2') ? 'selected' : '' ?>>Venue 2</option>
                                        <option <?= ($venue['VenueName'] == 'Venue 3') ? 'selected' : '' ?>>Venue 3</option>
                                      </select>
                                </div>
                                <div class="form-group">
                                    <label for="VenueCapacity" >Status</label >
                                    <input type="number" class="form-control" id="VenueCapacity" name="VenueCapacity"  required value="<?=$venue['VenueCapacity']?>">
                                </div>
                                <div class="form-group">
                                    <label for="AvailableCapacity" >Status</label >
                                    <input type="number" class="form-control" id="AvailableCapacity" name="AvailableCapacity"  required value="<?=$venue['AvailableCapacity']?>">
                                </div>
                                <div class="form-group">
                                    <label for="Image">Upload</label>
                                    <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$venue['Image']?>" required>
                                </div>
                                
                              
                                
                                </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Venue Name</th>
                    <th>Venue Capacity</th>
                    <th>Available Capacity</th>
                    <th>Venue Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($venues as $venue): ?>
                  <tr>
                    <td><?=$venue['VenueID']?></td>
                    <td><?=$venue['VenueName']?></td>
                    <td><?=$venue['VenueCapacity']?></td>
                    <td><?=$venue['AvailableCapacity']?></td>
                    <td><img  style="width: 300px; height: 250px;" src="<?=base_url('/uploads/'.$venue['Image'])?>" alt="#"/></td>
                    <th><a class="btn btn-danger" href="/deleteRoom/<?= $venue['VenueID']?>">Delete</a> <a class="btn btn-info" data-toggle="modal" data-target="#editModal<?=$venue['VenueID']?>">Edit</a></th>
                  </tr>
                  <?php endforeach; ?>
                  
                  
                  </tbody>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Restaurant Menu</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Main Menu</h3>
              </div>
              <!-- /.card-header -->
              <div class="card card-solid">
        <div class="card-body pb-0">
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addonModal">
            Add Main Menu
          </button>
          <div class="row">
          <?php foreach ($menumains as $menumain): ?>
            <?php if ($menumain['MenuType'] === 'Main Menu' && $menumain['CategoryID'] >= 1 && $menumain['CategoryID'] <= 11): ?>
              <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-header text-muted border-bottom-0">
                    <b><h4><?=$menumain['CategoryName']?></h4></b>
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b><?=$menumain['ProductName']?></b></h2>
                        <p class="text-muted text-sm"><b>Php: </b> <?=$menumain['ProductPrice']?></p>
                      </div>
                      <div class="col-5 text-center">
                        <img src="<?=base_url('/restaurant/'.$menumain['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                      </div>
                    </div>
                  </div>
                <div class="card-footer">
                <div class="text-right">
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#reformModal<?=$menumain['ProductID']?>">
                    Update 
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="addonModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Main Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addMainMenu/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                          <div class="form-group">
                            <input type="hidden" class="form-control" id="MenuID" name="MenuID" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                                    <label for="CategoryName">Category Name</label>
                                    <select class="custom-select form-control-border" id="CategoryName" name="CategoryName" required>
                                        <option>Pasta</option>
                                        <option>Breakfast</option>
                                        <option>Sizzling</option>
                                        <option>Chicken</option>
                                        <option>Pork</option>
                                        <option>Soup</option>
                                        <option>Meal Deals</option>
                                        <option>Veggies</option>
                                        <option>Solo Meal</option>
                                        <option>Seafood/Fish</option>
                                        <option>Appetizer/Snack</option>
                                    </select>
                          </div>
                          <div class="form-group">
                            <label for="ProductName">Name</label>
                            <input type="text" class="form-control" id="ProductName" name="ProductName" placeholder="Enter Name" >
                          </div>

                          <div class="form-group">
                            <label for="ProductPrice">Price</label>
                            <input type="number" class="form-control" id="ProductPrice" name="ProductPrice" placeholder="Enter Price" >
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" >
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Update Modal -->
                <div class="modal fade" id="reformModal<?=$menumain['ProductID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$menumain['ProductID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$menumain['ProductID']?>">Update Main Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateMainMenu/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                          <input type="hidden" name="ProductID" id="ProductID" value="<?=$menumain['ProductID']?>">
                          <div class="form-group">
                            <input type="hidden" class="form-control" id="MenuID" name="MenuID" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                                    <label for="CategoryName">Category Name</label>
                                    <select class="custom-select form-control-border" id="CategoryName" name="CategoryName" required>
                                        <option <?= ($menumain['CategoryName'] == 'Pasta') ? 'selected' : '' ?>>Pasta</option>
                                        <option <?= ($menumain['CategoryName'] == 'Breakfast') ? 'selected' : '' ?>>Breakfast</option>
                                        <option <?= ($menumain['CategoryName'] == 'Sizzling') ? 'selected' : '' ?>>Sizzling</option>
                                        <option <?= ($menumain['CategoryName'] == 'Chicken') ? 'selected' : '' ?>>Chicken</option>
                                        <option <?= ($menumain['CategoryName'] == 'Pork') ? 'selected' : '' ?>>Pork</option>
                                        <option <?= ($menumain['CategoryName'] == 'Soup') ? 'selected' : '' ?>>Soup</option>
                                        <option <?= ($menumain['CategoryName'] == 'Meal Deals') ? 'selected' : '' ?>>Meal Deals</option>
                                        <option <?= ($menumain['CategoryName'] == 'Veggies') ? 'selected' : '' ?>>Veggies</option>
                                        <option <?= ($menumain['CategoryName'] == 'Solo Meal') ? 'selected' : '' ?>>Solo Meal</option>
                                        <option <?= ($menumain['CategoryName'] == 'Seafood/Fish') ? 'selected' : '' ?>>Seafood/Fish</option>
                                        <option <?= ($menumain['CategoryName'] == 'Appetizer/Snack') ? 'selected' : '' ?>>Appetizer/Snack</option>
                                    </select>
                          </div>
                          <div class="form-group">
                            <label for="ProductName">Name</label>
                            <input type="text" class="form-control" id="ProductName" name="ProductName" placeholder="Enter Name" value="<?=$menumain['ProductName']?>">
                          </div>
                          <div class="form-group">
                            <label for="ProductPrice">Price</label>
                            <input type="number" class="form-control" id="ProductPrice" name="ProductPrice" placeholder="Enter Input" value="<?=$menumain['ProductPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$menumain['Image']?>">
                            </div>
                          </div>
                          
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                      
                    </div>
                  </div>
                </div>
                </div>
              </div>
              
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaddonModal">
            Add Bar Menu
          </button>
          <div class="row">
          <?php foreach ($menubars as $menubar): ?>
            <?php if ($menubar['MenuType'] === 'Bar Menu' && $menubar['CategoryID'] >= 12 && $menubar['CategoryID'] <= 21): ?>
              <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-header text-muted border-bottom-0">
                    <b><h4><?=$menubar['CategoryName']?></h4></b>
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b><?=$menubar['ProductName']?></b></h2>
                        <p class="text-muted text-sm"><b>Php: </b> <?=$menubar['ProductPrice']?></p>
                      </div>
                      <div class="col-5 text-center">
                        <img src="<?=base_url('/restaurant/'.$menubar['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                      </div>
                    </div>
                  </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#rreformModal<?=$menubar['ProductID']?>">
                    Update 
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaddonModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Breakfast</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addBarMenu/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                          <div class="form-group">
                            <input type="hidden" class="form-control" id="MenuID" name="MenuID" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                                    <label for="CategoryName">Category Name</label>
                                    <select class="custom-select form-control-border" id="CategoryName" name="CategoryName" required>
                                        <option>Cocktails</option>
                                        <option>Mocktails</option>
                                        <option>Shooter</option>
                                        <option>Tower(3L)</option>
                                        <option>Juices</option>
                                        <option>Shakes</option>
                                        <option>Red Wines</option>
                                        <option>Beer</option>
                                    </select>
                          </div>
                          <div class="form-group">
                            <label for="ProductName">Name</label>
                            <input type="text" class="form-control" id="ProductName" name="ProductName" placeholder="Enter Name" >
                          </div>

                          <div class="form-group">
                            <label for="ProductPrice">Price</label>
                            <input type="number" class="form-control" id="ProductPrice" name="ProductPrice" placeholder="Enter Price" >
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" >
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Update Modal -->
                <div class="modal fade" id="rreformModal<?=$menubar['ProductID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$menubar['ProductID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$menubar['ProductID']?>">Update Breakfast</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateBarMenu/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="ProductID" id="ProductID" value="<?=$menubar['ProductID']?>">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="MenuID" name="MenuID" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                                    <label for="CategoryName">Category Name</label>
                                    <select class="custom-select form-control-border" id="CategoryName" name="CategoryName" required>
                                        <option <?= ($menubar['CategoryName'] == 'Cocktails') ? 'selected' : '' ?>>Cocktails</option>
                                        <option <?= ($menubar['CategoryName'] == 'Mocktails') ? 'selected' : '' ?>>Mocktails</option>
                                        <option <?= ($menubar['CategoryName'] == 'Shooter') ? 'selected' : '' ?>>Shooter</option>
                                        <option <?= ($menubar['CategoryName'] == 'Tower(3L)') ? 'selected' : '' ?>>Tower(3L)</option>
                                        <option <?= ($menubar['CategoryName'] == 'Juices') ? 'selected' : '' ?>>Juices</option>
                                        <option <?= ($menubar['CategoryName'] == 'Shakes') ? 'selected' : '' ?>>Shakes</option>
                                        <option <?= ($menubar['CategoryName'] == 'Red Wines') ? 'selected' : '' ?>>Red Wines</option>
                                        <option <?= ($menubar['CategoryName'] == 'Beer') ? 'selected' : '' ?>>Beer</option>
                                        <option <?= ($menubar['CategoryName'] == 'Bucket Beers') ? 'selected' : '' ?>>Bucket Beers</option>
                                        
                                    </select>
                          </div>
                          <div class="form-group">
                            <label for="ProductName">Name</label>
                            <input type="text" class="form-control" id="ProductName" name="ProductName" placeholder="Enter Input" value="<?=$menubar['ProductName']?>">
                          </div>
                          <div class="form-group">
                            <label for="ProductPrice">Price</label>
                            <input type="number" class="form-control" id="ProductPrice" name="ProductPrice" placeholder="Enter Input" value="<?=$menubar['ProductPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$menubar['Image']?>">
                            </div>
                          </div>
                          
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                      
                    </div>
                  </div>
                </div>
                </div>
              </div>
              
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaddonModal">
            Add Cafe Menu
          </button>
          <div class="row">
          <?php foreach ($menucafes as $menucafe): ?>
            <?php if ($menucafe['MenuType'] === 'Cafe Menu' && $menucafe['CategoryID'] >= 21 && $menucafe['CategoryID'] <= 24): ?>
              <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-header text-muted border-bottom-0">
                    <b><h4><?=$menucafe['CategoryName']?></h4></b>
                  </div>
                  <div class="card-body pt-0">
                    <div class="row">
                      <div class="col-7">
                        <h2 class="lead"><b><?=$menucafe['ProductName']?></b></h2>
                        <p class="text-muted text-sm"><b>Php: </b> <?=$menucafe['ProductPrice']?></p>
                      </div>
                      <div class="col-5 text-center">
                        <img src="<?=base_url('/restaurant/'.$menucafe['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                      </div>
                    </div>
                  </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#reeeformModal<?=$menucafe['ProductID']?>">
                    Update 
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaddonModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Cafe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addCafeMenu/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="MenuID" name="MenuID" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                                    <label for="CategoryName">Category Name</label>
                                    <select class="custom-select form-control-border" id="CategoryName" name="CategoryName" required>
                                        <option>Iced Coffee</option>
                                        <option>Hot Coffee</option>
                                        <option>Cold Brew</option>
                                    </select>
                          </div>
                          <div class="form-group">
                            <label for="ProductName">Name</label>
                            <input type="text" class="form-control" id="ProductName" name="ProductName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="ProductPrice">Price</label>
                            <input type="number" class="form-control" id="ProductPrice" name="ProductPrice" placeholder="Enter Price" >
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" >
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Update Modal -->
                <div class="modal fade" id="reeeformModal<?=$menucafe['ProductID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$menucafe['ProductID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$menucafe['ProductID']?>">Update Cafe</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateCafeMenu/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="ProductID" id="ProductID" value="<?=$menucafe['ProductID']?>">
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="MenuID" name="MenuID" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                                    <label for="CategoryName">Category Name</label>
                                    <select class="custom-select form-control-border" id="CategoryName" name="CategoryName" required>
                                        <option <?= ($menucafe['CategoryName'] == 'Iced Coffee') ? 'selected' : '' ?>>Iced Coffee</option>
                                        <option <?= ($menucafe['CategoryName'] == 'Hot Coffee') ? 'selected' : '' ?>>Hot Coffee</option>
                                        <option <?= ($menucafe['CategoryName'] == 'Cold Brew') ? 'selected' : '' ?>>Cold Brew</option>
                                        
                                    </select>
                          </div>
                          <div class="form-group">
                            <label for="ProductName">Name</label>
                            <input type="text" class="form-control" id="ProductName" name="ProductName" placeholder="Enter Input" value="<?=$menucafe['ProductName']?>">
                          </div>
                          <div class="form-group">
                            <label for="ProductPrice">Price</label>
                            <input type="number" class="form-control" id="ProductPrice" name="ProductPrice" placeholder="Enter Input" value="<?=$menucafe['ProductPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$menucafe['Image']?>">
                            </div>
                          </div>
                          
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                      
                    </div>
                  </div>
                </div>
                </div>
              </div>
              
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
        
      </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include(__DIR__ . '/../../Admin/include/footer.php'); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?=base_url()?>admin/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>admin/dist/js/adminlte.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?=base_url()?>admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url()?>admin/plugins/jszip/jszip.min.js"></script>
<script src="<?=base_url()?>admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=base_url()?>admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": [""]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
