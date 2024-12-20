<?php 

include_once "db.php";

function is_exist_user($email){
    include "db.php";
    $rsEmails = mysqli_query($conn,"Select * from users where Email='$email'");
    $numEmails = mysqli_num_rows($rsEmails);
    if($numEmails > 0){
        return true;
    }else{
        return false;
    }
}

function login($email,$password){
  include("db.php");
  $sql = "select * from users where email='$email' AND password = '$password'";
  $result = mysqli_query($conn,$sql);
  $is_exist = mysqli_num_rows($result);
  if ($is_exist > 0) {
    $row = mysqli_fetch_assoc($result);
    if($email === $row['Email'] && $password === $row['Password']){
      session_start();
      $_SESSION['user'] = $row['Fname'] ."". $row['Lname'];
      $_COOKIE['todayDate'] = date("Y-m-d");
      return true;
    }else{
      return false;
    }
  }else{
    return false;
  }

}

function reg_new_user($fname, $email, $contact, $p1, $image){
    include("db.php");
    $sql = "INSERT INTO `users`(`Fname`, `Email`, `Contact`, `Password`, `Image`) VALUES 
    ('$fname','$email','$contact','$p1','$image')";
     if(mysqli_query($conn, $sql)){return true;}else{return false;}
}

function reg_new_staff($name, $email, $contact, $category){
    include("db.php");
    $sql = "INSERT INTO `staff`(`Name`, `Email`, `Contact`, `Category`) VALUES ('$name','$email','$contact','$category')";
    if(mysqli_query($conn,$sql)){
      return true;
    }else{
      return false;
    }
}

function get_staff_details(){
  include("db.php");
  $sql = "SELECT * FROM staff";
  $result = mysqli_query($conn,$sql);
  // $data = mysqli_fetch_assoc($result);
  return $result;
}

function get_msg(){

    include("db.php");
    $sql = "SELECT * FROM `messages` ORDER BY ID DESC";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
         return $result;
    } else {
       return 0;
    }
      
      mysqli_close($conn);


}

function send_msg($cxname, $email , $subject , $msg){
    include("db.php");
    $sql = "INSERT INTO `messages`(`Name`, `Email`, `Contact`, `Msg`) 
            VALUES ('$cxname','$email','$subject','$msg')";

    if (mysqli_query($conn, $sql)) {
        return true;
      } else {
        return false;
      }
      
      mysqli_close($conn);

}

function get_user_details($email){
    include("db.php");
    $sql = "select * from users where email = '$email'";
    $result = mysqli_query($conn,$sql);
    $data = mysqli_fetch_assoc($result);
    return $data;
}

function update_user_details($fname, $lname, $email, $contact, $password,$image){
    include("db.php");
    if($password !=0){
      $sql = "UPDATE `users` SET `Fname`='$fname',`Lname`='$lname',`Contact`='$contact',`Password`='$password',`Image`='$image' WHERE `Email`='$email'";
    }else{
      $sql = "UPDATE `users` SET `Fname`='$fname',`Lname`='$lname',`Contact`='$contact',`Image`='$image' WHERE `Email`='$email'";
    }
    
    if(mysqli_query($conn,$sql)){
      return true;
    }else{
      return false;
    }

    
}

function get_appointment_data($date){
  include("db.php");
  $sql = "SELECT * FROM `availability` WHERE `Date` = '$date'";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function set_new_date($date){
  include("db.php");
  $tmp = '[[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0]]';
  $sql = "INSERT INTO `availability`(`Available`, `Date`) VALUES ('$tmp','$date')";
  if(mysqli_query($conn,$sql)){
    return true;
  }else {
    return false;
  }
}

function get_user_appointment($user){
  include("db.php");
  $sql = "SELECT * FROM `appointment` where `userID` = '$user' ";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function get_all_routine(){
  include("db.php");
  $sql = "SELECT * from appointment";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function book_appointment($user, $date, $note){
  include("db.php");
  $sql = "INSERT INTO `appointment`( `userID`, `serviceDate`,`Note`) VALUES ('$user','$date','$note')";
  if(mysqli_query($conn,$sql)){
    return true;
  }else{
    return false;
  }
}

function report_breakdown($user,$desc,$note){
  include("db.php");
  $sql = "INSERT INTO `breakdown`(`user`, `problem`, `note`) VALUES ('$user','$desc','$note')";
  if(mysqli_query($conn,$sql)){
    return true;
  }else{
    return false;
  }

}

function get_breakdownDate($user){
  include("db.php");
  $sql = "SELECT * FROM `breakdown` WHERE `user` = '$user' ";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function get_all_breakdown(){
  include("db.php");
  $sql = "SELECT * FROM `breakdown`";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function get_products(){
  include("db.php");
  $sql = "select * from products";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function add_order($item,$qty,$total,$address,$user){
  include("db.php");
  $sql = "INSERT INTO `orders` (`user_id`,`item_id`, `qty`, `total`, `address`) VALUES ('$user','$item','$qty','$total','$address')";
  if(mysqli_query($conn,$sql)){
    return true;
  }else {
    return false;
  }
}

function get_orders($user){
  include("db.php");
  // SELECT * FROM `orders` WHERE user_id = 'pateldk@gmail.com'
  $sql = "Select * from orders where user_id = '$user' ";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function get_all_orders(){
  include("db.php");
  $sql = "SELECT * from orders";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function update_timeslot($date,$time){
  include("db.php");
  echo $date;
  $sql = "SELECT * from `availability` WHERE `Date` = '$date' ";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_num_rows($result);
  if($row > 0){
    $sql = "UPDATE `availability` SET `Available`='$time'  WHERE `Date` = '$date' ";
    if(mysqli_query($conn,$sql)){
      return true;
    }else {
      return false;
    }
  }else{
    $time = "[[0,0,0,0,0],[0,0,0,0,0],[0,0,0,0,0]]";
    $sql = "INSERT INTO `availability` (`Available`, `Date`) VALUES ('$time','$date')";
    $result = mysqli_query($conn,$sql);
    if($result){return true;}else{echo mysqli_error($conn);  return false;}
  }
  
}

function create_guest_maintain($company,$phone,$email,$equipments,$comment){
  include("db.php");
  $sql = "INSERT INTO `guestMaintain`(`cname`, `cphone`, `cemail`, `equipments`, `comment`) 
          VALUES ('$company','$phone','$email','$equipments','$comment')";
  $result = mysqli_query($conn,$sql);
  if($result){return true;}else{echo mysqli_error($conn);  return false;}
}

function get_guest_maintain(){
  include("db.php");
  $sql = "SELECT * from guestMaintain";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function create_guest_breakdown($company,$phone,$email,$equipments,$comment){
  include("db.php");
  $sql = "INSERT INTO `guestBreakdown`(`cname`, `cphone`, `cemail`, `equipments`, `comment`) 
          VALUES ('$company','$phone','$email','$equipments','$comment')";
  $result = mysqli_query($conn,$sql);
  if($result){return true;}else{echo mysqli_error($conn);  return false;}
}

function get_guest_breakdown(){
  include("db.php");
  $sql = "SELECT * from guestBreakdown";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function create_guest_worker($company,$phone,$email,$worktype,$comment){
  include("db.php");
  $sql = "INSERT INTO `guestWorker`(`cname`, `cphone`, `cemail`, `workerType`, `comment`) 
          VALUES ('$company','$phone','$email','$worktype','$comment')";
  $result = mysqli_query($conn,$sql);
  if($result){return true;}else{echo mysqli_error($conn);  return false;}
}

function get_guest_worker(){
  include("db.php");
  $sql = "SELECT * from guestWorker";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function get_guest_orders(){
  include("db.php");
  $sql = "SELECT * from guestOrder";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function guest_order($name, $email, $phone, $address, $item, $total){
  include("db.php");
  $sql = "INSERT INTO `guestOrder`(`Name`, `Email`, `Phone`, `Address`, `ItemID`, `Total`) 
  VALUES ('$name','$email','$phone','$address','$item','$total')";
   $result = mysqli_query($conn,$sql);
   if($result){return true;}else{echo mysqli_error($conn);  return false;}
}

function get_user_history($email){
  include("db.php");
  $sql = "SELECT * FROM `appointment` where `userID` = '$email' ORDER By `Date` DESC ";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function get_admin_appointment(){
  include("db.php");
  $sql = "SELECT A.Fname , A.Lname, A.Contact, B.Date, B.Note, B.Service, B.TimeSlot FROM users A INNER JOIN appointment B ON A.Email = B.userID ORDER BY `Date` DESC;";
  $result = mysqli_query($conn,$sql);
  return $result;
}

function login_admin($email,$password){
  include("db.php");
  $sql = "select * from admin where Email='$email' AND Password = '$password'";
  $result = mysqli_query($conn,$sql);
  $is_exist = mysqli_num_rows($result);
  if ($is_exist > 0) {
    $row = mysqli_fetch_assoc($result);
    if($email === $row['Email'] && $password === $row['Password']){
      session_start();
      $_SESSION['admin'] = $row['Email'];
      return true;
    }else{
      return false;
    }
  }else{
    return false;
  }
}

?>