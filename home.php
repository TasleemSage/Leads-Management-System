<?php
session_start();
require_once 'class.user.php';
$user_home = new USER();

if(!$user_home->is_logged_in())
{
	$user_home->redirect('index.php');
}

$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$employee = $row['userEmail'];
?>
<?php
require_once 'class.user.php';
$user_home = new USER();
$stmt = $user_home->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
$stmt->execute(array(":uid"=>$_SESSION['userSession']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$employee = $row['userEmail'];

include_once 'dbcrud.php';
$con = new connect();

if(isset($_POST['btn-save']))
{
 $first_name = $_POST['first_name'];
 $last_name = $_POST['last_name'];
 $city = $_POST['city_name'];
 $consultant = $_POST['$employee'];
 $con->setdata("INSERT INTO leads(first_name,last_name,user_city,Consultant) VALUES('$first_name','$last_name','$city','$consultant')");
 header("Location: index.php");
}

if(isset($_GET['delete_id']))
{
 $con->delete("DELETE FROM leads WHERE leads_id=".$_GET['delete_id']);
 header("Location: index.php");
}
// delete condition


// code for fetch user data via QueryString URL 
if(isset($_GET['edit_id']))
{
 $res=$con->getdata("SELECT * FROM leads WHERE leads_id=".$_GET['edit_id']);
 $row=mysql_fetch_array($res);
}
// code for fetch user data via QueryString URL 

// data update condition
if(isset($_POST['btn-update']))
{
 $con->setdata("UPDATE leads SET first_name='".$_POST['first_name']."',
           last_name='".$_POST['last_name']."',
           user_city='".$_POST['city_name']."'
          WHERE leads_id=".$_GET['edit_id']);
 header("Location: index.php");
}
// data update condition
?>
<!DOCTYPE html> 
<html> 
    <head> 
        <title>
            <?php echo $row['userEmail']; ?>
        </title>         
        <!-- Bootstrap -->         
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
        <link href="assets/styles.css" rel="stylesheet" media="screen"> 
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->         
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->         
        <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
        <link href="custom.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="components/pg.blocks/css/blocks.css">
        <link rel="stylesheet" href="components/pg.blocks/css/plugins.css">
        <link rel="stylesheet" href="components/pg.blocks/css/style-library-1.css">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic">
    </head>     
    <body>
        <header>
</header>
        <div class="nav-side-menu">
            <div class="brand">Audi LMS</div>
            <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
            <div class="menu-list">
                <ul id="menu-content" class="menu-content collapse out">
                    <li>
                        <a href="#"><i class="fa fa-dashboard fa-lg"></i> Dashboard</a>
                    </li>
                    <li data-toggle="collapse" data-target="#user" class="collapsed">
                        <a href="#"><i class="fa fa-user fa-lg"></i><?php echo $row[ 'userEmail']; ?><span class="arrow"></span></a>
                    </li>
                    <ul class="sub-menu collapse" id="user">
                        <li>
                            <a tabindex="-1" href="logout.php">Logout</a> 
                        </li>
                    </ul>
                    <li data-toggle="collapse" data-target="#service" class="collapsed">
                        <a href="#"><i class="fa fa-globe fa-lg"></i> Services <span class="arrow"></span></a>
                    </li>                     
                    <ul class="sub-menu collapse" id="service">
                        <li>New Service 1</li>
                        <li>New Service 2</li>
                        <li>New Service 3</li>
                    </ul>
                    <li data-toggle="modal" data-target="#leadForm" class="collapsed">
                        <a href="#"><i class="fa fa-car fa-lg"></i> New <span class="arrow"></span></a>
                    </li>
                    <ul class="sub-menu collapse" id="new">
                        <li>New New 1</li>
                        <li>New New 2</li>
                        <li>New New 3</li>
                    </ul>
                    <li>
                        <a href="#"><i class="fa fa-user fa-lg"></i> Profile</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-users fa-lg"></i> Users</a>
                    </li>
                </ul>
            </div>
        </div>
        <section class="dashRow1">
            <div class="container">
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1 col-sm-5 col-md-9 col-sm-offset-4 col-md-offset-3">
                            <table align="center">
                            <tr>
                                <th colspan="5">
                                    <button type="button" class="btn btn-default black bg-sienna-hover" data-target="#leadForm" data-toggle="modal">New Lead</button>
                                </th>
                            </tr>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>City Name</th>
                                <th colspan="2">Operations</th>
                            </tr>
                            <?php
                            $res=$con->getdata("SELECT * FROM leads");
                            if(mysql_num_rows($res)==0)
                            {
                             ?>
                                <tr>
                                    <td colspan="5">Nothing Found Here !</td>
                                </tr>
                                <?php
                            }
                            else
                            {
                             while($row=mysql_fetch_array($res))
                             {
                              ?>
                                    <tr>
                                        <td><?php echo $row['first_name'];  ?></td>
                                        <td><?php echo $row['last_name'];  ?></td>
                                        <td><?php echo $row['user_city'];  ?></td>
                                        <td align="center">
                                            <a href="javascript:edt_id('<?php echo $row['leads_id']; ?>')"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        </td>
                                        <td align="center">
                                            <a href="javascript:delete_id('<?php echo $row['leads_id']; ?>')"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                <?php
                             }
                            }
                            ?>
                        </table>                         
                    </div>
                    <div class="container modalContainer">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <form method="post">
                                    <table align="center">
                                        <tr>
                                            <td>
                                                <input type="text" name="first_name" placeholder="First Name" value="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="last_name" placeholder="Last Name" value="" required />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="city_name" placeholder="City" value="" required />
                                            </td>
                                        </tr>
										<tr>
										<td>
										<p><?php echo $employee; ?></p>
										</td>
										</tr>
                                        <tr> 
										<td>
										<button type="submit" name="btn-save">
										</td>
										</tr>
                                        
                                            <strong>SAVE</strong>
                                        </button>
                                    </table>
                                </form>                                 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/.fluid-container-->         
        <script type="text/javascript">
            function edt_id(id)
            {
             if(confirm('Sure to edit ?'))
             {
              window.location.href='insert-update.php?edit_id='+id;
             }
            }
            function delete_id(id)
            {
             if(confirm('Sure to Delete ?'))
             {
              window.location.href='home.php?delete_id='+id;
             }
            }
        </script>
        <script>
            $('#myModal').on('shown.bs.modal', function () {
 			 $('#myInput').focus()
				})
        </script>
        <script src="bootstrap/js/jquery-1.9.1.min.js"></script>         
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>         
        <script src="assets/scripts.js"></script>         
        <script type="text/javascript" src="components/pg.blocks/js/plugins.js"></script>
        <script type="text/javascript" src="components/pg.blocks/js/bskit-scripts.js"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <div class="modal fade text-center pg-show-modal" id="leadForm" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="true">
            <div class="modal-dialog modal-lg"> 
                <div class="modal-content"> 
                    <div class="modal-header"> 
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>                         
                        <h4 class="modal-title">New Lead Form</h4> 
                    </div>                     
                    <div class="modal-body"> 
                        <div class="container modalContainer">
                            <div class="row">
                                <div class="col-md-6">
                                    <form method="post">
                                        <table align="center">
                                            <tr>
                                                <td>
                                                    <input type="text" name="first_name" placeholder="First Name" value="" required />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="last_name" placeholder="Last Name" value="" required />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="text" name="city_name" placeholder="City" value="" required />
                                                </td>
                                            </tr>
                                            <tr> 
</tr>
                                        </table>
                                    </form>                                     
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="btn-save">
                            <strong>SAVE</strong>
                        </button>                         
                    </div>                     
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                         
                        <button type="button" class="btn btn-primary">Save changes</button>                         
                    </div>                     
                </div>                 
            </div>             
        </div>
    </body>     
</html>