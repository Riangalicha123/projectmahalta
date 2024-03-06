
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
                                    <label for="Venue">Venue Name</label>
                                      <select class="custom-select form-control-border" id="Venue" name="Venue" required>
                                        <option >Venue 1</option>
                                        <option >Venue 2</option>
                                      </select>
                                </div>
                                <div class="form-group">
                                    <label for="Image">Upload</label>
                                    <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1" >Status</label >
                                    <input type="text" class="form-control" id="" name="AvailabilityStatus"  required>
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
                    <?php foreach ($tables as $table): ?>
                    <div class="modal fade" id="editModal<?=$table['TableID']?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?=$table['TableID']?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel<?=$table['TableID']?>">Edit Table</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="<?= base_url('/updateserviceTable/') ?>" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                <input type="hidden" name="TableID" id="TableID" value="<?=$table['TableID']?>">
                                
                                <div class="form-group">
                                    <label for="Venue">Venue Name</label>
                                      <select class="custom-select form-control-border" id="Venue" name="Venue" required>
                                        <option <?= ($table['Venue'] == 'Venue 1') ? 'selected' : '' ?>>Venue 1</option>
                                        <option <?= ($table['Venue'] == 'Venue 2') ? 'selected' : '' ?>>Venue 2</option>
                                      </select>
                                </div>
                                <div class="form-group">
                                    <label for="Image">Upload</label>
                                    <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$table['Image']?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="exampleInputEmail1" >Status</label >
                                    <input type="text" class="form-control" id="" name="AvailabilityStatus"  value="<?=$table['AvailabilityStatus']?>"required>
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
                    <th>Venue Image</th>
                    <th>Availability</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($tables as $table): ?>
                  <tr>
                    <td><?=$table['TableID']?></td>
                    <td><?=$table['Venue']?></td>
                    <td><img src="<?=base_url('/uploads/'.$table['Image'])?>" alt="#"/></td>
                    <td style="color: red; background-border: #0056b3;" ><?=$table['AvailabilityStatus']?></td>
                    <th><a class="btn btn-danger" href="/deleteRoom/<?= $table['TableID']?>">Delete</a> <a class="btn btn-info" data-toggle="modal" data-target="#editModal<?=$table['TableID']?>">Edit</a></th>
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
            Add Breakfast
          </button>
          <div class="row">
            <?php foreach ($breakfasts as $breakfast): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Breakfast
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$breakfast['BreakfastName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$breakfast['BreakfastPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$breakfast['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#reformModal<?=$breakfast['BreakfastID']?>">
                    Update 
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="addonModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
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
                        <form action="<?= base_url('addBreakfast/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="BreakfastName">Name</label>
                            <input type="text" class="form-control" id="BreakfastName" name="BreakfastName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="BreakfastPrice">Price</label>
                            <input type="number" class="form-control" id="BreakfastPrice" name="BreakfastPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="reformModal<?=$breakfast['BreakfastID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$breakfast['BreakfastID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$breakfast['BreakfastID']?>">Update Breakfast</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateBreakfast/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="BreakfastID" id="BreakfastID" value="<?=$breakfast['BreakfastID']?>">
                          <div class="form-group">
                            <label for="BreakfastName">Name</label>
                            <input type="text" class="form-control" id="BreakfastName" name="BreakfastName" placeholder="Enter Input" value="<?=$breakfast['BreakfastName']?>">
                          </div>
                          <div class="form-group">
                            <label for="BreakfastPrice">Price</label>
                            <input type="number" class="form-control" id="BreakfastPrice" name="BreakfastPrice" placeholder="Enter Input" value="<?=$breakfast['BreakfastPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$breakfast['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaddonModal">
            Add Pasta
          </button>
          <div class="row">
            <?php foreach ($pastas as $pasta): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Pasta
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$pasta['PastaName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$pasta['PastaPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                    <img src="<?=base_url('/restaurant/'.$pasta['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#reformmModal<?=$pasta['PastaID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaddonModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addPasta/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="PastaName">Name</label>
                            <input type="text" class="form-control" id="PastaName" name="PastaName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="PastaPrice">Price</label>
                            <input type="number" class="form-control" id="PastaPrice" name="PastaPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="reformmModal<?=$pasta['PastaID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$pasta['PastaID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$pasta['PastaID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updatePasta/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="PastaID" id="PastaID" value="<?=$pasta['PastaID']?>">
                          <div class="form-group">
                            <label for="PastaName">Name</label>
                            <input type="text" class="form-control" id="PastaName" name="PastaName" placeholder="Enter Input" value="<?=$pasta['PastaName']?>">
                          </div>
                          <div class="form-group">
                            <label for="PastaPrice">Price</label>
                            <input type="number" class="form-control" id="PastaPrice" name="PastaPrice" placeholder="Enter Input" value="<?=$pasta['PastaPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$pasta['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaddonModal">
            Add Sizzling
          </button>
          <div class="row">
            <?php foreach ($sizzlings as $sizzling): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Sizzling
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$sizzling['SizzlingName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$sizzling['SizzlingPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$sizzling['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#reformmmModal<?=$sizzling['SizzlingID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaddonModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addSizzling/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="SizzlingName">Name</label>
                            <input type="text" class="form-control" id="SizzlingName" name="SizzlingName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="SizzlingPrice">Price</label>
                            <input type="number" class="form-control" id="SizzlingPrice" name="SizzlingPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="reformmmModal<?=$sizzling['SizzlingID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$sizzling['SizzlingID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$sizzling['SizzlingID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateSizzling/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="SizzlingID" id="SizzlingID" value="<?=$sizzling['SizzlingID']?>">
                          <div class="form-group">
                            <label for="SizzlingName">Name</label>
                            <input type="text" class="form-control" id="SizzlingName" name="SizzlingName" placeholder="Enter Input" value="<?=$sizzling['SizzlingName']?>">
                          </div>
                          <div class="form-group">
                            <label for="SizzlingPrice">Price</label>
                            <input type="number" class="form-control" id="SizzlingPrice" name="SizzlingPrice" placeholder="Enter Input" value="<?=$sizzling['SizzlingPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image"  name="Image" accept="Image/*" value="<?=$sizzling['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaddonnModal">
            Add Chicken
          </button>
          <div class="row">
            <?php foreach ($chickens as $chicken): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Towers (3L)
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$chicken['ChickenName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$chicken['ChickenPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$chicken['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#reforrmmmModal<?=$chicken['ChickenID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaddonnModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addChicken/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="ChickenName">Name</label>
                            <input type="text" class="form-control" id="ChickenName" name="ChickenName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="ChickenPrice">Price</label>
                            <input type="number" class="form-control" id="ChickenPrice" name="ChickenPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="reforrmmmModal<?=$chicken['ChickenID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$chicken['ChickenID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$chicken['ChickenID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateChicken/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="ChickenID" id="ChickenID" value="<?=$chicken['ChickenID']?>">
                          <div class="form-group">
                            <label for="ChickenName">Name</label>
                            <input type="text" class="form-control" id="ChickenName" name="ChickenName" placeholder="Enter Input" value="<?=$chicken['ChickenName']?>">
                          </div>
                          <div class="form-group">
                            <label for="ChickenPrice">Price</label>
                            <input type="number" class="form-control" id="ChickenPrice" name="ChickenPrice" placeholder="Enter Input" value="<?=$chicken['ChickenPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$chicken['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaddonnnModal">
            Add Pork
          </button>
          <div class="row">
            <?php foreach ($porks as $pork): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Pork
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$pork['PorkName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$pork['PorkPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$pork['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#rreforrmmmModal<?=$pork['PorkID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaddonnnModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addPork/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="PorkName">Name</label>
                            <input type="text" class="form-control" id="PorkName" name="PorkName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="PorkPrice">Price</label>
                            <input type="number" class="form-control" id="PorkPrice" name="PorkPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="rreforrmmmModal<?=$pork['PorkID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$pork['PorkID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$pork['PorkID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updatePork/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="PorkID" id="PorkID" value="<?=$pork['PorkID']?>">
                          <div class="form-group">
                            <label for="PorkName">Name</label>
                            <input type="text" class="form-control" id="PorkName" name="PorkName" placeholder="Enter Input" value="<?=$pork['PorkName']?>">
                          </div>
                          <div class="form-group">
                            <label for="PorkPrice">Price</label>
                            <input type="number" class="form-control" id="PorkPrice" name="PorkPrice" placeholder="Enter Input" value="<?=$pork['PorkPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$pork['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaddoonnnModal">
            Add Soup
          </button>
          <div class="row">
            <?php foreach ($soups as $soup): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Soup
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$soup['SoupName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$soup['SoupPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$soup['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#rreforrrmmmModal<?=$soup['SoupID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaddoonnnModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addSoup/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="SoupName">Name</label>
                            <input type="text" class="form-control" id="SoupName" name="SoupName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="SoupPrice">Price</label>
                            <input type="number" class="form-control" id="SoupPrice" name="SoupPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="rreforrrmmmModal<?=$soup['SoupID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$soup['SoupID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$soup['SoupID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateSoup/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="SoupID" id="SoupID" value="<?=$soup['SoupID']?>">
                          <div class="form-group">
                            <label for="SoupName">Name</label>
                            <input type="text" class="form-control" id="SoupName" name="SoupName" placeholder="Enter Input" value="<?=$soup['SoupName']?>">
                          </div>
                          <div class="form-group">
                            <label for="SoupPrice">Price</label>
                            <input type="number" class="form-control" id="SoupPrice" name="SoupPrice" placeholder="Enter Input" value="<?=$soup['SoupPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$soup['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaddoonnnnnModal">
            Add Veggies
          </button>
          <div class="row">
            <?php foreach ($veggies as $veggie): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Veggies
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$veggie['VeggiesName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$veggie['VeggiesPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$veggie['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#rreffoorrrmmmModal<?=$veggie['VeggiesID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaddoonnnnnModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addVeggies/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="VeggiesName">Name</label>
                            <input type="text" class="form-control" id="VeggiesName" name="VeggiesName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="VeggiesPrice">Price</label>
                            <input type="number" class="form-control" id="VeggiesPrice" name="VeggiesPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="rreffoorrrmmmModal<?=$veggie['VeggiesID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$veggie['VeggiesID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$veggie['VeggiesID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateVeggies/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="VeggiesID" id="VeggiesID" value="<?=$veggie['VeggiesID']?>">
                          <div class="form-group">
                            <label for="VeggiesName">Name</label>
                            <input type="text" class="form-control" id="VeggiesName" name="VeggiesName" placeholder="Enter Input" value="<?=$veggie['VeggiesName']?>">
                          </div>
                          <div class="form-group">
                            <label for="VeggiesPrice">Price</label>
                            <input type="number" class="form-control" id="VeggiesPrice" name="VeggiesPrice" placeholder="Enter Input" value="<?=$veggie['VeggiesPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$veggie['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaaddoonnnnnModal">
            Add Solo Meal
          </button>
          <div class="row">
            <?php foreach ($solomeals as $solomeal): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Solo Meals
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$solomeal['SolomealName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$solomeal['SolomealPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$solomeal['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#rrreffoorrrmmmModal<?=$solomeal['SolomealID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaaddoonnnnnModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addSolomeal/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="SolomealName">Name</label>
                            <input type="text" class="form-control" id="SolomealName" name="SolomealName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="SolomealPrice">Price</label>
                            <input type="number" class="form-control" id="SolomealPrice" name="SolomealPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="rrreffoorrrmmmModal<?=$solomeal['SolomealID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$solomeal['SolomealID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$solomeal['SolomealID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="<?= base_url('/updateSolomeal/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="SolomealID" id="SolomealID" value="<?=$solomeal['SolomealID']?>">
                          <div class="form-group">
                            <label for="SolomealName">Name</label>
                            <input type="text" class="form-control" id="SolomealName" name="SolomealName" placeholder="Enter Input" value="<?=$solomeal['SolomealName']?>">
                          </div>
                          <div class="form-group">
                            <label for="SolomealPrice">Price</label>
                            <input type="number" class="form-control" id="SolomealPrice" name="SolomealPrice" placeholder="Enter Input" value="<?=$solomeal['SolomealPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$solomeal['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaaaddoonnnnnModal">
            Add Seafood
          </button>
          <div class="row">
            <?php foreach ($seafoods as $seafood): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Seafood
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$seafood['SeafoodName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$seafood['SeafoodPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$seafood['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#rrrreffoorrrmmmModal<?=$seafood['SeafoodID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaaaddoonnnnnModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addSeafood/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="SeafoodName">Name</label>
                            <input type="text" class="form-control" id="SeafoodName" name="SeafoodName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="SeafoodPrice">Price</label>
                            <input type="number" class="form-control" id="SeafoodPrice" name="SeafoodPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="rrrreffoorrrmmmModal<?=$seafood['SeafoodID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$seafood['SeafoodID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$seafood['SeafoodID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateSeafood/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="SeafoodID" id="SeafoodID" value="<?=$seafood['SeafoodID']?>">
                          <div class="form-group">
                            <label for="SeafoodName">Name</label>
                            <input type="text" class="form-control" id="SeafoodName" name="SeafoodName" placeholder="Enter Input" value="<?=$seafood['SeafoodName']?>">
                          </div>
                          <div class="form-group">
                            <label for="SeafoodPrice">Price</label>
                            <input type="number" class="form-control" id="SeafoodPrice" name="SeafoodPrice" placeholder="Enter Input" value="<?=$seafood['SeafoodPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$seafood['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaaaaddoonnnnnModal">
            Add Appetizer/Snack
          </button>
          <div class="row">
            <?php foreach ($snacks as $snack): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Appetizer/Snack
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$snack['SnackName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$snack['SnackPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$snack['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#rrrrreffoorrrmmmModal<?=$snack['SnackID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaaaaddoonnnnnModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addSnack/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="SnackName">Name</label>
                            <input type="text" class="form-control" id="SnackName" name="SnackName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="SnackPrice">Price</label>
                            <input type="number" class="form-control" id="SnackPrice" name="SnackPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="rrrrreffoorrrmmmModal<?=$snack['SnackID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$snack['SnackID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$snack['SnackID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateSnack/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="SnackID" id="SnackID" value="<?=$snack['SnackID']?>">
                          <div class="form-group">
                            <label for="SnackName">Name</label>
                            <input type="text" class="form-control" id="SnackName" name="SnackName" placeholder="Enter Input" value="<?=$snack['SnackName']?>">
                          </div>
                          <div class="form-group">
                            <label for="SnackPrice">Price</label>
                            <input type="number" class="form-control" id="SnackPrice" name="SnackPrice" placeholder="Enter Input" value="<?=$snack['SnackPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$snack['Image']?>">
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Menu Bar</h3>
              </div>
              <!-- /.card-header -->
              <div class="card card-solid">
        <div class="card-body pb-0">
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addModal">
            Add Cocktails
          </button>
          <div class="row">
            <?php foreach ($cocktails as $cocktail): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Cocktails
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$cocktail['CocktailsName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$cocktail['CocktailsPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$cocktail['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#updateModal<?=$cocktail['CocktailsID']?>">
                    Update 
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Cocktails</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addCocktails/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="CocktailsName">Name</label>
                            <input type="text" class="form-control" id="CocktailsName" name="CocktailsName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="CocktailsPrice">Price</label>
                            <input type="number" class="form-control" id="CocktailsPrice" name="CocktailsPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="updateModal<?=$cocktail['CocktailsID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$cocktail['CocktailsID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$cocktail['CocktailsID']?>">Update Cocktails</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateCocktails/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="CocktailsID" id="CocktailsID" value="<?=$cocktail['CocktailsID']?>">
                          <div class="form-group">
                            <label for="CocktailsName">Name</label>
                            <input type="text" class="form-control" id="CocktailsName" name="CocktailsName" placeholder="Enter Input" value="<?=$cocktail['CocktailsName']?>">
                          </div>
                          <div class="form-group">
                            <label for="CocktailsPrice">Price</label>
                            <input type="number" class="form-control" id="CocktailsPrice" name="CocktailsPrice" placeholder="Enter Input" value="<?=$cocktail['CocktailsPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$cocktail['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaddModal">
            Add Mocktails
          </button>
          <div class="row">
            <?php foreach ($mocktails as $mocktail): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Mocktails
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$mocktail['MocktailsName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$mocktail['MocktailsPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                    <img src="<?=base_url('/restaurant/'.$mocktail['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#uupdateModal<?=$mocktail['MocktailsID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaddModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addMocktails/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="MocktailsName">Name</label>
                            <input type="text" class="form-control" id="MocktailsName" name="MocktailsName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="MocktailsPrice">Price</label>
                            <input type="number" class="form-control" id="MocktailsPrice" name="MocktailsPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="uupdateModal<?=$mocktail['MocktailsID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$mocktail['MocktailsID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$mocktail['MocktailsID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateMocktails/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="MocktailsID" id="MocktailsID" value="<?=$mocktail['MocktailsID']?>">
                          <div class="form-group">
                            <label for="MocktailsName">Name</label>
                            <input type="text" class="form-control" id="MocktailsName" name="MocktailsName" placeholder="Enter Input" value="<?=$mocktail['MocktailsName']?>">
                          </div>
                          <div class="form-group">
                            <label for="MocktailsPrice">Price</label>
                            <input type="number" class="form-control" id="MocktailsPrice" name="MocktailsPrice" placeholder="Enter Input" value="<?=$mocktail['MocktailsPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$mocktail['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#adddModal">
            Add Shooter
          </button>
          <div class="row">
            <?php foreach ($shooters as $shooter): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Shooters
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$shooter['ShootersName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$shooter['ShootersPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$shooter['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#uppdateModal<?=$shooter['ShootersID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="adddModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addShooters/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="ShootersName">Name</label>
                            <input type="text" class="form-control" id="ShootersName" name="ShootersName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="ShootersPrice">Price</label>
                            <input type="number" class="form-control" id="ShootersPrice" name="ShootersPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="uppdateModal<?=$shooter['ShootersID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$shooter['ShootersID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$shooter['ShootersID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateShooters/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="ShootersID" id="ShootersID" value="<?=$shooter['ShootersID']?>">
                          <div class="form-group">
                            <label for="ShootersName">Name</label>
                            <input type="text" class="form-control" id="ShootersName" name="ShootersName" placeholder="Enter Input" value="<?=$shooter['ShootersName']?>">
                          </div>
                          <div class="form-group">
                            <label for="ShootersPrice">Price</label>
                            <input type="number" class="form-control" id="ShootersPrice" name="ShootersPrice" placeholder="Enter Input" value="<?=$shooter['ShootersPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image"  name="Image" accept="Image/*" value="<?=$shooter['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aadddModal">
            Add Tower
          </button>
          <div class="row">
            <?php foreach ($towers as $tower): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Towers (3L)
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$tower['TowerName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$tower['TowerPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$tower['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#uuppdateModal<?=$tower['TowerID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aadddModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addTower/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="TowerName">Name</label>
                            <input type="text" class="form-control" id="TowerName" name="TowerName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="TowerPrice">Price</label>
                            <input type="number" class="form-control" id="TowerPrice" name="TowerPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="uuppdateModal<?=$tower['TowerID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$tower['TowerID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$tower['TowerID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateTower/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="TowerID" id="TowerID" value="<?=$tower['TowerID']?>">
                          <div class="form-group">
                            <label for="TowerName">Name</label>
                            <input type="text" class="form-control" id="TowerName" name="TowerName" placeholder="Enter Input" value="<?=$tower['TowerName']?>">
                          </div>
                          <div class="form-group">
                            <label for="TowerPrice">Price</label>
                            <input type="number" class="form-control" id="TowerPrice" name="TowerPrice" placeholder="Enter Input" value="<?=$tower['TowerPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$tower['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaddddModal">
            Add Juice
          </button>
          <div class="row">
            <?php foreach ($juices as $juice): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Juices
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$juice['JuicesName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$juice['JuicesPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$juice['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#uupppdateModal<?=$juice['JuicesID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaddddModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addJuices/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="JuicesName">Name</label>
                            <input type="text" class="form-control" id="JuicesName" name="JuicesName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="JuicesPrice">Price</label>
                            <input type="number" class="form-control" id="JuicesPrice" name="JuicesPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="uupppdateModal<?=$juice['JuicesID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$juice['JuicesID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$juice['JuicesID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateJuices/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="JuicesID" id="JuicesID" value="<?=$juice['JuicesID']?>">
                          <div class="form-group">
                            <label for="JuicesName">Name</label>
                            <input type="text" class="form-control" id="JuicesName" name="JuicesName" placeholder="Enter Input" value="<?=$juice['JuicesName']?>">
                          </div>
                          <div class="form-group">
                            <label for="JuicesPrice">Price</label>
                            <input type="number" class="form-control" id="JuicesPrice" name="JuicesPrice" placeholder="Enter Input" value="<?=$juice['JuicesPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$juice['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaddddModal">
            Add Shake
          </button>
          <div class="row">
            <?php foreach ($shakes as $shake): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Shakes
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$shake['ShakesName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$shake['ShakesPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$shake['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#uuupppdateModal<?=$shake['ShakesID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaddddModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addShakes/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="ShakesName">Name</label>
                            <input type="text" class="form-control" id="ShakesName" name="ShakesName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="ShakesPrice">Price</label>
                            <input type="number" class="form-control" id="ShakesPrice" name="ShakesPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="uuupppdateModal<?=$shake['ShakesID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$shake['ShakesID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$shake['ShakesID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateShakes/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="ShakesID" id="ShakesID" value="<?=$shake['ShakesID']?>">
                          <div class="form-group">
                            <label for="ShakesName">Name</label>
                            <input type="text" class="form-control" id="ShakesName" name="ShakesName" placeholder="Enter Input" value="<?=$shake['ShakesName']?>">
                          </div>
                          <div class="form-group">
                            <label for="ShakesPrice">Price</label>
                            <input type="number" class="form-control" id="ShakesPrice" name="ShakesPrice" placeholder="Enter Input" value="<?=$shake['ShakesPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$shake['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaaddddModal">
            Add Liquor
          </button>
          <div class="row">
            <?php foreach ($liquors as $liquor): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Liquors
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$liquor['LiquorsName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$liquor['LiquorsPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$liquor['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#uuuupppdateModal<?=$liquor['LiquorsID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaaddddModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addLiquors/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="LiquorsName">Name</label>
                            <input type="text" class="form-control" id="LiquorsName" name="LiquorsName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="LiquorsPrice">Price</label>
                            <input type="number" class="form-control" id="LiquorsPrice" name="LiquorsPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="uuuupppdateModal<?=$liquor['LiquorsID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$liquor['LiquorsID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$liquor['LiquorsID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateLiquors/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="LiquorsID" id="LiquorsID" value="<?=$liquor['LiquorsID']?>">
                          <div class="form-group">
                            <label for="LiquorsName">Name</label>
                            <input type="text" class="form-control" id="LiquorsName" name="LiquorsName" placeholder="Enter Input" value="<?=$liquor['LiquorsName']?>">
                          </div>
                          <div class="form-group">
                            <label for="LiquorsPrice">Price</label>
                            <input type="number" class="form-control" id="LiquorsPrice" name="LiquorsPrice" placeholder="Enter Input" value="<?=$liquor['LiquorsPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$liquor['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaadddddModal">
            Add Red Wine
          </button>
          <div class="row">
            <?php foreach ($redwines as $redwine): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Red Wine
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$redwine['RedwineName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$redwine['RedwinePrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$redwine['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#uuuuppppdateModal<?=$redwine['RedwineID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaadddddModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addRedwine/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="RedwineName">Name</label>
                            <input type="text" class="form-control" id="RedwineName" name="RedwineName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="RedwinePrice">Price</label>
                            <input type="number" class="form-control" id="RedwinePrice" name="RedwinePrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="uuuuppppdateModal<?=$redwine['RedwineID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$redwine['RedwineID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$redwine['RedwineID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateRedwine/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="RedwineID" id="RedwineID" value="<?=$redwine['RedwineID']?>">
                          <div class="form-group">
                            <label for="RedwineName">Name</label>
                            <input type="text" class="form-control" id="RedwineName" name="RedwineName" placeholder="Enter Input" value="<?=$redwine['RedwineName']?>">
                          </div>
                          <div class="form-group">
                            <label for="RedwinePrice">Price</label>
                            <input type="number" class="form-control" id="RedwinePrice" name="RedwinePrice" placeholder="Enter Input" value="<?=$redwine['RedwinePrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$redwine['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaaadddddModal">
            Add Beer
          </button>
          <div class="row">
            <?php foreach ($beers as $beer): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Beers
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$beer['BeerName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$beer['BeerPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$beer['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#uuuuuppppdateModal<?=$beer['BeerID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaaadddddModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addBeer/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="BeerName">Name</label>
                            <input type="text" class="form-control" id="BeerName" name="BeerName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="BeerPrice">Price</label>
                            <input type="number" class="form-control" id="BeerPrice" name="BeerPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="uuuuuppppdateModal<?=$beer['BeerID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$beer['BeerID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$beer['BeerID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateBeer/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="BeerID" id="BeerID" value="<?=$beer['BeerID']?>">
                          <div class="form-group">
                            <label for="BeerName">Name</label>
                            <input type="text" class="form-control" id="BeerName" name="BeerName" placeholder="Enter Input" value="<?=$beer['BeerName']?>">
                          </div>
                          <div class="form-group">
                            <label for="BeerPrice">Price</label>
                            <input type="number" class="form-control" id="BeerPrice" name="BeerPrice" placeholder="Enter Input" value="<?=$beer['BeerPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$beer['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aaaaaadddddModal">
            Add Bucket
          </button>
          <div class="row">
            <?php foreach ($buckets as $bucket): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Bucket
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$bucket['BucketName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$bucket['BucketPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$bucket['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#uuuuuuppppdateModal<?=$bucket['BucketID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aaaaaadddddModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addBucket/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="BucketName">Name</label>
                            <input type="text" class="form-control" id="BucketName" name="BucketName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="BucketPrice">Price</label>
                            <input type="number" class="form-control" id="BucketPrice" name="BucketPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="uuuuuuppppdateModal<?=$bucket['BucketID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$bucket['BucketID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$bucket['BucketID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateBucket/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="BucketID" id="BucketID" value="<?=$bucket['BucketID']?>">
                          <div class="form-group">
                            <label for="BucketName">Name</label>
                            <input type="text" class="form-control" id="BucketName" name="BucketName" placeholder="Enter Input" value="<?=$bucket['BucketName']?>">
                          </div>
                          <div class="form-group">
                            <label for="BucketPrice">Price</label>
                            <input type="number" class="form-control" id="BucketPrice" name="BucketPrice" placeholder="Enter Input" value="<?=$bucket['BucketPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$bucket['Image']?>">
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
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Menu Cafe</h3>
              </div>
              <!-- /.card-header -->
              <div class="card card-solid">
        <div class="card-body pb-0">
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#aattachModal">
            Add Iced Coffee
          </button>
          <div class="row">
            <?php foreach ($iced as $ice): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Iced Coffee
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$ice['IcedName']?></b></h2>
                      <p class="text-muted text-sm"><b>Tall Php: </b> <?=$ice['IcedPriceTall']?></p>
                      <p class="text-muted text-sm"><b>Grande Php: </b> <?=$ice['IcedPriceGrande']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$ice['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#moddifyModal<?=$ice['IcedID']?>">
                    Update 
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="aattachModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Iced</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addIced/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="IcedName">Name</label>
                            <input type="text" class="form-control" id="IcedName" name="IcedName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="IcedPriceTall">Price Tall</label>
                            <input type="number" class="form-control" id="IcedPriceTall" name="IcedPriceTall" placeholder="Enter Price" >
                          </div>
                          <div class="form-group">
                            <label for="IcedPriceGrande">Price Grande</label>
                            <input type="number" class="form-control" id="IcedPriceGrande" name="IcedPriceGrande" placeholder="Enter Price" >
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
                <div class="modal fade" id="moddifyModal<?=$ice['IcedID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$ice['IcedID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$ice['IcedID']?>">Update Iced</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateIced/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="IcedID" id="IcedID" value="<?=$ice['IcedID']?>">
                          <div class="form-group">
                            <label for="IcedName">Name</label>
                            <input type="text" class="form-control" id="IcedName" name="IcedName" placeholder="Enter Input" value="<?=$ice['IcedName']?>">
                          </div>
                          <div class="form-group">
                            <label for="IcedPriceTall">Price Tall</label>
                            <input type="number" class="form-control" id="IcedPriceTall" name="IcedPriceTall" placeholder="Enter Input" value="<?=$ice['IcedPriceTall']?>">
                          </div>
                          <div class="form-group">
                            <label for="IcedPriceGrande">Price Grande</label>
                            <input type="number" class="form-control" id="IcedPriceGrande" name="IcedPriceGrande" placeholder="Enter Input" value="<?=$ice['IcedPriceGrande']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$ice['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#attachModal">
            Add Hot Coffee
          </button>
          <div class="row">
            <?php foreach ($hots as $hot): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Hot Coffee
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$hot['HotName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$hot['HotPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                    <img src="<?=base_url('/restaurant/'.$hot['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modifyModal<?=$hot['HotID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="attachModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addHot/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="HotName">Name</label>
                            <input type="text" class="form-control" id="HotName" name="HotName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="HotPrice">Price</label>
                            <input type="number" class="form-control" id="HotPrice" name="HotPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="modifyModal<?=$hot['HotID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$hot['HotID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$hot['HotID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateHot/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="HotID" id="HotID" value="<?=$hot['HotID']?>">
                          <div class="form-group">
                            <label for="HotName">Name</label>
                            <input type="text" class="form-control" id="HotName" name="HotName" placeholder="Enter Input" value="<?=$hot['HotName']?>">
                          </div>
                          <div class="form-group">
                            <label for="HotPrice">Price</label>
                            <input type="number" class="form-control" id="HotPrice" name="HotPrice" placeholder="Enter Input" value="<?=$hot['HotPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image" id="inputImage" name="Image" accept="Image/*" value="<?=$hot['Image']?>">
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
            <?php endforeach; ?>
          </div>
          <hr>
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#attachhModal">
            Add Cold Coffee
          </button>
          <div class="row">
            <?php foreach ($colds as $cold): ?>
            <div class="col-12 col-sm-6 col-md-3 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                Cold Coffee
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="lead"><b><?=$cold['ColdName']?></b></h2>
                      <p class="text-muted text-sm"><b>Php: </b> <?=$cold['ColdPrice']?></p>
                    </div>
                    <div class="col-5 text-center">
                      <img src="<?=base_url('/restaurant/'.$cold['Image'])?>" alt="user-avatar" class="img-circle img-fluid" style="width:100px;height:100px;">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <div class="text-right">
                  
                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modifyyModal<?=$cold['ColdID']?>">
                    Update
                  </button>
                </div>
                <!-- Add Modal -->
                <div class="modal fade" id="attachhModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Add Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('addCold/') ?>" method="post" enctype="multipart/form-data" id="addForm">
                        <div class="card-body">
                        
                          <div class="form-group">
                            <label for="ColdName">Name</label>
                            <input type="text" class="form-control" id="ColdName" name="ColdName" placeholder="Enter Name" >
                          </div>
                          <div class="form-group">
                            <label for="ColdPrice">Price</label>
                            <input type="number" class="form-control" id="ColdPrice" name="ColdPrice" placeholder="Enter Price" >
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
                <div class="modal fade" id="modifyyModal<?=$cold['ColdID']?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?=$cold['ColdID']?>" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel<?=$cold['ColdID']?>">Update Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <!-- Add your form inputs here -->
                        <form action="<?= base_url('/updateCold/') ?>" method="post" enctype="multipart/form-data" id="updateForm">
                          <div class="card-body">
                        <input type="hidden" name="ColdID" id="ColdID" value="<?=$cold['ColdID']?>">
                          <div class="form-group">
                            <label for="ColdName">Name</label>
                            <input type="text" class="form-control" id="ColdName" name="ColdName" placeholder="Enter Input" value="<?=$cold['ColdName']?>">
                          </div>
                          <div class="form-group">
                            <label for="ColdPrice">Price</label>
                            <input type="number" class="form-control" id="ColdPrice" name="ColdPrice" placeholder="Enter Input" value="<?=$cold['ColdPrice']?>">
                          </div>
                          <div class="form-group">
                            <label for="Image">Upload</label>
                            <input type="file" class="form-control" id="Image"  name="Image" accept="Image/*" value="<?=$cold['Image']?>">
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
