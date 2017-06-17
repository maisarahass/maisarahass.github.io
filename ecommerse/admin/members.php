<?php

/*
========================================================================
== Manage members page
== you can add | edit | delete memmbers from here
==============================================================
*/

session_start();

$pageTitle = 'Members';

if (isset($_SESSION['username']))
{
   
     include 'init.php';
    
    
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    
    //start manage page
    if ($do == 'Manage'){// mange page 
        
        $query = ''; //  عملت متغير سميتو كويري
        
        if(isset($_GET['page']) && ($_GET['page']) =='panding') // قلتلو لو القت لجاية من الصفحة فيها قيمة اسمها بيج
           {
            $query = 'AND RegistarStatuas = 0'; // خلي الكويري تعمل اضافة عجملة السلكت انو يظهر جميع المستخدمين من الداتا لمجموعتهم مش واحد وكمان حالة التسجيل تعتهم صفر
        }

      $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query"); // هان حكتلو روح جبلي كل البيانات من جدول اليوزر بس بشرط ميكونش القروب ايدي 1 لانو الواحد خاص بالادمن وانا مش عاوز اجيب بيانات الادمن
      $stmt->execute();  
      
       $rows = $stmt->fetchAll();// وهان بقلو بعد متحضر البيانات حطهم بمتغير اسموروز

    ?>
        
             <h1 class="text-center">Manege Members</h1>

               <div class="container">
                   <div class="table-responsive">
                      <table class="table maneg-tab text-center table-bordered">
                        <tr>
                            <td>#ID</td>
                            <td>UserName</td>
                            <td>Email</td>
                            <td>Full name</td>
                            <td>Registered Date</td>
                            <td>Controles</td>
                       </tr>
                          <?php
                          foreach($rows as $row){
                              echo "<tr>";
                                 echo "<td>" .$row['UserID'] . "</td>";
                                 echo "<td>" .$row['UserName'] . "</td>";
                                 echo "<td>" .$row['Email'] . "</td>";
                                 echo "<td>" .$row['FullName'] . "</td>";
                                 echo "<td>" .$row['Date'] . "</td>";
                                 echo "<td> <a href='members.php?do=Edit&userid=". $row['UserID'] ."' class='btn btn-success'><i                 class='fa fa-edit'></i>Edit</a>
                                            <a href='members.php?do=Delete&userid=".$row['UserID']."' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";
                              
                                            if($row['RegistarStatuas'] == 0) // /قلتلو هان روح شيك على حالة التسجيل اذا صفر يعني مش مفعل العضو
                                            {
                                             echo "<a href='members.php?do=Activate&userid=".$row['UserID']."' class='btn btn-info activet'><i class='fa fa-toggle-on'></i>Active</a>";// وبما انو مش مفعل روح إظهرلو زر التفعيل
                                            }
                                echo "</td>";
                              echo "</tr>";
                          }
                           ?>

                       </table>  
                   
                   </div>
                  <a href="members.php?do=Add" class="btn btn-primary"> <i class="fa fa-plus"></i> Add New Memmbers</a>
               </div>
        
        
        
        
  <?php  } elseif($do == 'Add'){// Add Members Page ?>
        
        
      <h1 class="text-center">Add Member</h1>

                      <div class="container">
                          <form class="form-horizontal" action="?do=Insert" method="POST">
                              <!--Start username faild -->
                             <div class="form-group form-group-lg">
                               <label class="col-sm-2 control-label">User Name</label>
                               <div class="col-sm-10">
                                <input type="text" name="username" class="form-control" autocomplete="off"  placeholder="Enete UserName to Member" required="required" />

                                </div>
                             </div>
                              <!--End Password faild -->
                                 <!--Start username faild -->
                             <div class="form-group form-group-lg">
                               <label class="col-sm-2 control-label">Password</label>
                               <div class="col-sm-10">
                                <input type="password" name="password" class="password form-control" autocomplete="new-password"  placeholder="Enter User Password" required="required"/>
                                   <li class="show-pass fa fa-eye fa-2x" ></li>

                                </div>
                             </div>
                              <!--End Password faild -->
                                 <!--Start Email faild -->
                             <div class="form-group form-group-lg">
                               <label class="col-sm-2 control-label">Email</label>
                               <div class="col-sm-10">
                                <input type="email" name="email" class="form-control"  placeholder="Enter Email Member" required="required"/>

                                </div>
                             </div>
                              <!--End Email faild -->
                                 <!--Start Full Name faild -->
                             <div class="form-group form-group-lg">
                               <label class="col-sm-2 control-label">Full Name</label>
                               <div class="col-sm-10">
                                <input type="text" name="fullname" class="form-control" autocomplete="off"  placeholder="Enter Full Name To Member" required="required"/>

                                </div>
                             </div>
                              <!--End Full Name faild -->
                                 <!--Start Save faild -->
                             <div class="form-group form-group-lg">
                               <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Add New Member" class="btn btn-primary btn-lg" />

                                </div>
                             </div>
                              <!--End Save faild -->
                          </form>

                        </div>
        
        
    
        
   <?php
        }elseif ($do == 'Insert'){// Insert Page
        
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
           echo "<h1 class='text-center'>Update Member</h1>";
           echo "<div class='container'>"; // حطينها بدف الكونتينر تاع البوتستراب عشان نستفيد من خصائص البوتستراب في الفلديشن
            
            // لو لقا جاي من الفورم بدي روح يجيب القيم من الانبوت المدخلات في الفورم
             
            
             $name = $_POST['username'];
             $pass = $_POST['password'];
             $email = $_POST['email'];
             $full = $_POST['fullname'];
              
              $shapassword = sha1($_POST['password']); // هان عشان يحفظ الباسورد مشفر 
           
            
            // هنا بدنا نعمل الفاليديشن الخاص بحقول الادخال يعني نبرمجهم برمجة بلغة الphp
            // مهم جدا انك تعرف انو برمجة الفاليديشن لازم تكون قبل الاتصال بقاعدة البيانات
            $fromerrore = array(); // هنا عملنا مصفوفة بدنا نحط كل رسائل الايرور فيها
            if(empty($name)){
                $fromerrore[] ='this name cant be empty'; 
            }
            if(empty($pass)){
                $fromerrore[] ='this password cant be empty';
            }
            if(empty($email)){
                $fromerrore[] ='this email cant be empty';
            }
            if(empty($full)){
                $fromerrore[] ='this full name cant be empty';
            }
            
            foreach($fromerrore as $error)
            {
                echo '<div class="alert alert-danger">' .  $error . '</div>' ;  // استخدمنا ديف الاليرت من البوتستراب عشان نظهر رسالة خطأ بطريقة جميلة
            }
            
            if(empty($fromerrore)) // هنا انا قلتلو لو كانت مصفوفة الاخطاء خالية من اي خطا توكل عالله وفوت بمرحلة التعديل لكن لو في خطا اظهرو ومتعملش تعديل
            {
                
                // اول حاجة متل مقلنا بدي اشيك عالاسم المدخل هل موجود فعليا بالداتا ولا لا
                $check = checkitem("UserName" , "users" ,$name);
                if($check === 1)
                {
                    
                       echo "<div class='container'>";
              $themsg = '<div class="alert alert-danger">this username is exeite</div>';
              
              redirecthome($themsg,'back'); // لو خليتها هيك حتعملك ايرور لانو اصلا الانسيرت ملوش صفحة جاي منها
              echo "</div>";
                        
                }
                
                else
                        {
                        //هالقيت بعد ميجيبهم بدو يروح يحفظهم بالداتا
                        $stmt = $con->prepare("INSERT INTO users(UserName , Password , Email , FullName , RegistarStatuas , Date)
                                              VALUES(:zusername ,:zpassword ,:zemail ,:zfullname , 1 , now())");// استخدمت اسماء عادية من راسي ملهاش علاقة بحاجة وبعدين بربطهم بالمتغيرات لاستخدمتهن فوق
                                            // ولاحظ عملنا ريجسترستيت  1 لانو بدنا لمن الادمن يضيف يعضو يكون عطول مفعل لكن لو العضو عمل حساب ميكونش مفعل الا لمن الادمن يوافق علي
                         $stmt->execute(array(
                             'zusername' =>  $name,
                             'zpassword' =>  $shapassword,
                             'zemail'    =>  $email,
                             'zfullname' =>  $full
                         ));


                       $themsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Recored Inserted </div>'; //وهنا قلنالو رجعلي عدد الاسطر لصار عليها تغيير في الدتا
                             redirecthome($themsg , 'back');
                    }
            
            }

                       
        }else{
              
              echo "<div class='container'>";
              $themsg = '<div class="alert alert-danger">sorry you dont login</div>';
              
              redirecthome($themsg , 'back'); // لو خليتها هيك حتعملك ايرور لانو اصلا الانسيرت ملوش صفحة جاي منها
              echo "</div>";
        }
        
        echo "</div>"; 
                         
        }elseif ($do == 'Edit'){//Edit Page
        
        $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; // دالة اف المختصرة نفس فعالية اف لتحت
                 // بعد متجيب رقم اليوزر روح على قاعدة اليانات واعمل سلكت لجميع عناصر المستخدم 
        $stmt = $con->prepare("SELECT * 
                    FROM users 
                    WHERE UserID = ?
                    LIMIT 1");
                    $stmt->execute(array( $userid));
                    $row = $stmt->fetch(); //هنا بروح بيجلب البيانات وبرجعهم بمصفوفة
                    $count = $stmt->rowCount(); // هنا احنا عملنا فحص وتاكدنا من وجود البيانات بالداتا بيز
                    if ($stmt->rowCount() > 0) //اذا صار تغيير اظهر فورمة التعديل
                    {
                   
        /*
    
     if(isset($_GET['userid']) && is_numeric($_GET['userid'])) // لو القت لجيلك حامل يوزر ايدي وبشرط يكون رقم
     {
         echo intval($_GET['userid']); // اطبع قيمة الانتجر
     } else {
         echo 0;
     }

   */

        ?>
        
                    <h1 class="text-center">Edit Member</h1>

                      <div class="container">
                          <form class="form-horizontal" action="?do=Update" method="POST">
                              <input name="userid" type="hidden" value="<?php echo $userid ?>"/>
                              <!--Start username faild -->
                             <div class="form-group form-group-lg">
                               <label class="col-sm-2 control-label">User Name</label>
                               <div class="col-sm-10">
                                <input type="text" name="username" class="form-control" value="<?php echo $row['UserName'] ?>" autocomplete="off" required="required" />

                                </div>
                             </div>
                              <!--End Password faild -->
                                 <!--Start username faild -->
                             <div class="form-group form-group-lg">
                               <label class="col-sm-2 control-label">Password</label>
                               <div class="col-sm-10">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>"/>
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Live this blank if you dont want change" />

                                </div>
                             </div>
                              <!--End Password faild -->
                                 <!--Start Email faild -->
                             <div class="form-group form-group-lg">
                               <label class="col-sm-2 control-label">Email</label>
                               <div class="col-sm-10">
                                <input type="email" name="email" class="form-control" value="<?php echo $row['Email'] ?>" required="required"/>

                                </div>
                             </div>
                              <!--End Email faild -->
                                 <!--Start Full Name faild -->
                             <div class="form-group form-group-lg">
                               <label class="col-sm-2 control-label">Full Name</label>
                               <div class="col-sm-10">
                                <input type="text" name="fullname" class="form-control" value="<?php echo $row['FullName'] ?>" required="required"/>

                                </div>
                             </div>
                              <!--End Full Name faild -->
                                 <!--Start Save faild -->
                             <div class="form-group form-group-lg">
                               <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-primary btn-lg" />

                                </div>
                             </div>
                              <!--End Save faild -->
                          </form>

                        </div>
        
        
     <?php
               
        } else { // لو لا محدثش تغيير
              
              echo "<div class='container'>";
              $themsg = '<div class="alert alert-danger">Theres Is not such ID</div>';
              
              redirecthome($themsg); // لو خليتها هيك حتعملك ايرور لانو اصلا الانسيرت ملوش صفحة جاي منها
              echo "</div>";
                        
        }
                    
                    
                    
        } elseif ($do == 'Update') {
      
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo "<h1 class='text-center'>Update Member</h1>";
        echo "<div class='container'>"; // حطينها بدف الكونتينر تاع البوتستراب عشان نستفيد من خصائص البوتستراب في الفلديشن
            
            // لو لقا جاي من الفورم بدي روح يجيب القيم من الانبوت المدخلات في الفورم
             
            $id = $_POST['userid'];
             $name = $_POST['username'];
             $email = $_POST['email'];
             $full = $_POST['fullname'];
           
            
            // هنا حتة الترك تاعت الباسورد
            
             $pass = '';
             if(empty($_POST['newpassword'])){ // هان لو لقا انو الانتب تاع الباسورد اتساب فاضي بروح بياخد كلمة المرور القديمة المحفوظة في الاولد باسورد
                 
                 $pass = $_POST['oldpassword'];
             }else{
                 
                 $pass = sha1($_POST['newpassword']); // الشاون هاد عشان تشفر كلمة المرور في الداتا
             }
            
            // هنا بدنا نعمل الفاليديشن الخاص بحقول الادخال يعني نبرمجهم برمجة بلغة الphp
            // مهم جدا انك تعرف انو برمجة الفاليديشن لازم تكون قبل الاتصال بقاعدة البيانات
            $fromerrore = array(); // هنا عملنا مصفوفة بدنا نحط كل رسائل الايرور فيها
            if(empty($name)){
                $fromerrore[] ='this name cant be empty'; // استخدمنا ديف الاليرت من البوتستراب عشان نظهر رسالة خطأ بطريقة جميلة
            }
            if(empty($email)){
                $fromerrore[] ='this email cant be empty';
            }
            if(empty($full)){
                $fromerrore[] ='this full name cant be empty';
            }
            
            foreach($fromerrore as $error)
            {
                echo '<div class="alert alert-danger">' . $error . '</div>' ;
            }
            
            if(empty($fromerrore)) // هنا انا قلتلو لو كانت مصفوفة الاخطاء خالية من اي خطا توكل عالله وفوت بمرحلة التعديل لكن لو في خطا اظهرو ومتعملش تعديل
            {
                //هالقيت بعد ميجيبهم بدو يروح يحطهم بالداتا بدل القيم القديمة يعني يعمل تحديث
           $stmt = $con->prepare("UPDATE users SET UserName = ? , Email = ?, FullName = ?, Password = ? WHERE UserID = ? "); // اعمل تحديث للقيم في قاعدة البيانات بناء على القيم الجديدة
          $stmt->execute(array($name , $email , $full , $pass, $id)); // هنا انا اعطيتو القيم الجديدة
          $themsg =  "<div class='alert alert-success'>" . $stmt->rowCount() . 'Recored Updated </div>'; //وهنا قلنالو رجعلي عدد الاسطر لصار عليها تغيير في الدتا
                 redirecthome($themsg , 'back');
                  
            }
            
            

                       
        }else{
            
            echo "<div class='container'>";
              $themsg = '<div class="alert alert-danger">sorry you dont login</div>';
              
              redirecthome($themsg); // لو خليتها هيك حتعملك ايرور لانو اصلا الانسيرت ملوش صفحة جاي منها
              echo "</div>";
            
             
        }
        
        echo "</div>";
        
        
    }elseif($do == 'Delete'){
        
        // Delete member Page
         echo "<h1 class='text-center'>Delete Member</h1>";
        echo "<div class='container'>"; // حطينها بدف الكونتينر تاع البوتستراب عشان نستفيد من خصائص البوتستراب في الفلديشن
            
        

                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; //دالة اف المختصرة ت
                         // بعد متجيب رقم اليوزر روح على قاعدة اليانات واعمل سلكت لجميع عناصر المستخدم 
                            /*
                           $stmt = $con->prepare("SELECT * 
                            FROM users 
                            WHERE UserID = ?
                            LIMIT 1");
                            $stmt->execute(array( $userid));
                            $count = $stmt->rowCount(); // هنا احنا عملنا فحص وتاكدنا من وجود البيانات بالداتا بيز
                            */
                           $chek = checkitem('userid','users',$userid); // استعضنا عن الطريقة لفوق بفنكشن التشيك لانها بتوفر وقت وكود
                           
                            if ($chek > 0) //اذا صار تغيير اظهر فورمة التعديل
                            {

                                  $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser"); // هنا قلتلو احذف اليوزر من جدول اليوزر عندما يكون رقم المستخدم نفس الرقم لجيني من فوق في البوست
                                  $stmt->bindparam(":zuser" ,$userid );  // طبعا هنا انت عرفت الداتا بالمتغير لاسمو زدنيم

                                  $stmt->execute(); // هالقيت نفذ يمعلم
                                  $themsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Recored Deleted </div>'; 
                                   redirecthome($themsg , 'back');
                                
                            }else
                            {
                                
                                echo "<div class='container'>";
                               $themsg = '<div class="alert alert-danger">This user not found</div>';
              
                              redirecthome($themsg); // لو خليتها هيك حتعملك ايرور لانو اصلا الانسيرت ملوش صفحة جاي منها
                               echo "</div>";
            
                            }
        
         echo '</div>';
    }
    
    elseif($do == 'Activate'){
        
           echo "<h1 class='text-center'>Active Member</h1>";
        
        
            echo "<div class='container'>"; // حطينها بدف الكونتينر تاع البوتستراب عشان نستفيد من خصائص البوتستراب في الفلديشن
            
        

                $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0; //دالة اف المختصرة ت
                         // بعد متجيب رقم اليوزر روح على قاعدة اليانات واعمل سلكت لجميع عناصر المستخدم 
                            /*
                           $stmt = $con->prepare("SELECT * 
                            FROM users 
                            WHERE UserID = ?
                            LIMIT 1");
                            $stmt->execute(array( $userid));
                            $count = $stmt->rowCount(); // هنا احنا عملنا فحص وتاكدنا من وجود البيانات بالداتا بيز
                            */
        
                          $chek = checkitem('userid','users',$userid); // استعضنا عن الطريقة لفوق بفنكشن التشيك لانها بتوفر وقت وكود
                           
                            if ($chek > 0) //اذا صار تغيير اظهر فورمة التعديل
                            {

                                  $stmt = $con->prepare("UPDATE users SET RegistarStatuas = 1  WHERE UserID = ?"); // هنا قلتلو احذف اليوزر من جدول اليوزر عندما يكون رقم المستخدم نفس الرقم لجيني من فوق في البوست
                                  $stmt->execute(array($userid )); // هالقيت اعطي اليوزر ايدي لفوق قيمة اليوزر ايدي ونفذ
                              $themsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'Recored Activay </div>'; 
                                   redirecthome($themsg , 'back');
                                
                            }else
                            {
                                
                                echo "<div class='container'>";
                               $themsg = '<div class="alert alert-danger">This user not found</div>';
              
                              redirecthome($themsg); // لو خليتها هيك حتعملك ايرور لانو اصلا الانسيرت ملوش صفحة جاي منها
                               echo "</div>";
            
                            }
        
         echo '</div>';
        
    }

    
     include $tpl . 'footer.php';
}else


{
    header('Location: index.php');
    exit();
}