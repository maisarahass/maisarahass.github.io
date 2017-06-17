<?php
session_start();
$nonavbar='';
$pageTitle='Login';
if (isset($_SESSION['username'])){
    header('Location: dashboard.php'); // يعني اذا في سشن متسجلة في الصفحة حولني علوحة التحكم عطول من دون معيد تسجيل الدخول
}
include "init.php";


// للتأكد من أن المستخدم قادم من الفورم مش داخل مباشرة عالصفحة
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $username = $_POST['user'];
    $password = $_POST['pass'];
    $hashedpass = sha1($password);  // خاصة بتشفيير الباسورد
  
    // هالقيت بدنا نفحص ان كان اليوزر موجود بالداتا بس ولا لا
    
    $stmt = $con->prepare("SELECT UserID , UserName , Password 
    FROM users 
    WHERE UserName = ?
    AND Password = ? 
    AND GroupID = 1 
    LIMIT 1");
    $stmt->execute(array($username , $hashedpass));
    $row = $stmt->fetch(); //هنا بروح بيجلب البيانات وبرجعهم بمصفوفة
    $count = $stmt->rowCount(); // هنا احنا عملنا فحص وتاكدنا من وجود البيانات بالداتا بيز
    
    // اذا كان عدد السطور الى راجعة من الدتا اكبر من صفر يعني اليوزر موجود بالداتا 
    
    if($count > 0)
    {
        
       $_SESSION['username'] = $username; // تسجيل سضن باسم المستخدم لفايت
       $_SESSION['UserID'] = $row[UserID]; // بسجل اي دي المستخدم عشان بصفحة التعديل اعدل عالمستخدم المطلوب من الايدي تعتو    
       header('Location: dashboard.php'); // تحويل المستخدم لصفحة التحكم
        exit(); // اغلاق الفنكشن لتجنب حدوث اي مشاكل
    }
}

?>

   <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
       <h4 class="text-center">Admin Login</h4>
   <input class="form-control" type="text" name="user" placeholder="UserName" autocomplete="off"/>
    <input class="form-control" type="password" name="pass" placeholder="password" autocomplete="new-password"/>
    <input class="btn btn-primary btn-block" type="submit" value="Login"/>   




   </form>

<?php

include $tpl . 'footer.php';?>