<?php
session_start();

if (isset($_SESSION['username']))
{
    $pageTitle='Dashbooard';
     include 'init.php'; 
/*Start Dashbord page*/

    $latest = 5; 
$getlets = (lastitem("*","users","UserID",$latest));
    
    
       
    
?>
    
         <div class="home-stats">
                 <div class="container  text-center">
                         <h1 >Dashbord Page</h1>
                         <div class="row">
                             <div class="col-md-3">
                               <div class="stat st-memb">
                                   Total Members
                                   <span><a href="members.php"><?php echo getcount('UserID' , 'users') ?></a></span>
                                 </div>
                             </div>
                             <div class="col-md-3">
                             <div class="stat st-pand">
                                 Panding Members
                                 <span><a href="members.php?do=Manage&page=panding"><?php echo checkitem("RegistarStatuas","users",0) ?></a></span>
                                 </div>
                             </div>
                             <div class="col-md-3">
                             <div class="stat st-item">
                                 Total Items
                                 <span>1200</span>
                                 </div>
                             </div>
                             <div class="col-md-3">
                             <div class="stat st-comment">
                                 Total Comments
                                 <span>1500</span>
                                 </div>
                             </div>


                        </div> 

                 </div>
    </div>         

     <div class="latest">
             <div class="container ">
                 <div class="row">
                     <div class="col-sm-6">
                      <div class="panel panel-default">
                          
                       <?php
                        // هان عملت متغير بسير منو اتحكم بعدد اللمت لانا بدي يجيبو
                        //$latest = 5;  // طلعتو فوق باول الصفحة
                          ?> 
                       <div class="panel-heading">
                         <i class="fa fa-users"></i>
                           Latest <?php echo $latest  ?> Registerd Users

                             </div>
                          <div class="panel-body">
                             <?php
                           //$getlets = (lastitem("*","users","UserID",$latest)); // طلعتها فوق باول الصفحة
                           // عملنا فور ايش لانا بدنا نرجع قيم على شكل مصفوفة 
                           // بعدين حطينا دالة الفنكشن في قيمة اسمها ميسرة 
                           // بعدين قلنالو اطبع قيم الدالة لصارن موجودات في ميسرة وحط سطر جديد بين كل قيمة واختها
                            echo "<ul class='list-unstyled latest-users'>";
                                
                                foreach ($getlets as $maisara) 
                                {
                                    
                                    echo "<li>";
                                    echo $maisara['UserName'];
                                    echo '<a href="members.php?do=Edit&userid=' . $maisara['UserID'] . ' ">';
                                            echo "<span class='btn btn-success'><i class='fa fa-edit'>Edit";
                                            echo "</i></span>";
                                    if($maisara['RegistarStatuas'] == 0) // /قلتلو هان روح شيك على حالة التسجيل اذا صفر يعني مش مفعل العضو
                                                    {
                                                     echo "<a href='members.php?do=Activate&userid=".$maisara['UserID']."' class='btn btn-info activet pull-right'><i class='fa fa-toggle-on'></i>Active</a>";// وبما انو مش مفعل روح إظهرلو زر التفعيل
                                                    }
                                    echo "</a>";
                                    echo "</li>";
                                   
                                }
                                
                            echo "</ul>";
         
                           ?>
                          </div>

                         </div>

                     </div>
                     
                      <div class="col-sm-6">
                      <div class="panel panel-default">
                       <div class="panel-heading">
                         <i class="fa fa-tag"></i>
                           Latest Items Added

                             </div>
                          <div class="panel-body">
                          Test
                          </div>

                         </div>

                     </div>

                 </div>
             </div>
   </div>
    
      
<?php
    /*End Dashbord page*/
    
     include $tpl . 'footer.php';
}
else
{
    header('Location: index.php');
    exit();
}