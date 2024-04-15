<?php 
    include_once "db.php";
    include "function.php";


    if(isset($_POST['submit'])){

        if($_POST['cat'] == 'login'){
              $email = $_POST['logEmail'];
              $password = $_POST['logPassword'];
            if(login($email, md5($password))){
                session_start();
                $_SESSION['email'] = $email;
                
                echo "loging in...";
                echo "you will be redirect shortly";
                header("refresh:3;url=../index.php"); 
            }else{
                echo "emailId or password incorrect! Please try again!";
                header("refresh:2;url=../index.php");
            }
        }
        else if($_POST['cat']=='regUser'){
                $email = $_POST['email'];
                $company = $_POST['company'];
                $password = $_POST['password'];
                $contact = $_POST['contact'];
                $image = $_POST['image'];
             if(!reg_new_user($company, $email, $contact, md5($password), $image)){
                echo "Error while creating new user";
                header("Location: ../login.php");
            }else{
                echo "User created Please login to continue";
                header("refresh:3; url= ../login.php");
                
            }

        }
        else if($_POST['cat'] == 'RegStaff'){
               $name = $_POST['name'];
               $email = $_POST['email'];
               $contact = $_POST['contact'];
               $category = $_POST['category'];

               if(!reg_new_staff($name,$email,$contact,$category)){
                    echo "Error while adding new employee";
                    header("Location: ../admin/index.php");
               }else{
                    header("Location: ../admin/staff.php");

               }
        }else if($_POST['cat'] == 'AddAppointment'){
            session_start();
            $date = $_POST['date'];
            $service = $_POST['service'];
            
            $user = $_SESSION['email'];
            $note = $_POST['note'];
            if(book_appointment($user,$date,$note)){
                    echo "Appointment booked.";
                    header("refresh:3; url= ../customer/index.php");       
            }else{
                echo "Error while booking appointment";
                header("refresh:3; url= ../customer/index.php");
            }
        }
        else if($_POST['cat']=="loginAdmin"){
            $email = $_POST['logEmailAdmin'];
            $password = $_POST['logPasswordAdmin'];
            if(!login_admin($email,md5($password))){
                echo "Login Faild..";
                header("refresh:1; url= ../index.html");
            }else{
                echo "Welcome Admin";
                header("refresh:1; url= ../admin/index.php");
            }
        }
        else if($_POST['cat'] == "addBreakdown"){
            session_start();
            $problem = $_POST['problem'];
            $note = $_POST['note'];
            $user = $_SESSION['email'];
            
            if(report_breakdown($user,$problem,$note)){
                echo "Breakdown Reported You will get in touch shortly";
                header("refresh:5; url= ../customer/index.php");
            }else{
                echo "Error while reporting..";
                header("refresh:2; url= ../customer/index.php");
            }
        }
        else if($_POST['cat'] == "addOrder"){
            session_start();            
            $user = $_SESSION['email'];
            $item = $_POST['item'];
            $qty = $_POST['qty'];
            $total = $_POST['total'];
            $address = $_POST['address'];

            if(add_order($item,$qty,$total,$address,$user)){
                echo "Your order is placed you will be contact soon";
                header("refresh:1; url= ../customer/index.php");
            }else{
                echo "Error while placing order!";
                header("refresh:5; url= ../customer/index.php");
            }
        }
        else if($_POST['cat'] == "guestOrder"){
            
            $name  = $_POST['cxName'];
            $email = $_POST['cxEmail'];
            $phone = $_POST['cxPhone'];
            $address = $_POST['cxAddress'];
            $item = $_POST['item'];
            $total = $_POST['total'];
        
            if(guest_order($name, $email, $phone, $address, $item, $total)){
                echo "<h2 style='font-family:monospace'>Thank you for placing order.  you will be contact soon</h2>";
                header("refresh:5; url= ../index.php");
            }else{
                echo "Error while placing order!";
                header("refresh:5; url= ../index.php");
            }
        }else if($_POST['cat']=="guestMaintain"){

            $company = $_POST['cname'];
            $phone = $_POST['cphone'];
            $email = $_POST['cemail'];
            $equipments	= $_POST['equipments'];
            $comment = $_POST['comment'];
            
            if(create_guest_maintain($company,$phone,$email,$equipments,$comment)){
                echo "<h2 style='font-family:monospace'>Thank you for business. We received your request for machine maintainance. You will be contact soon. </h2>";
                header("refresh:5; url= ../reg_maintainence.html");
            }else{
                echo "Error while processing your request";
                header("refresh:5; url= ../reg_maintainence.html");
            }


        }else if($_POST['cat']=="guestBreakdown"){
            
            $company = $_POST['cname'];
            $phone = $_POST['cphone'];
            $email = $_POST['cemail'];
            $equipments	= $_POST['equipments'];
            $comment = $_POST['comment'];

            if(create_guest_breakdown($company,$phone,$email,$equipments,$comment)){
                echo "<h2 style='font-family:monospace'>Thank you for business. We received your request for machine breakdown. You will be contact soon. </h2>";
                header("refresh:5; url= ../machine_breakdown.html");
            }else{
                echo "Error while processing your request";
                header("refresh:5; url= ../machine_breakdown.html");
            }
            

        }else if($_POST['cat']=="sendMsg"){
            $cxname = $_POST['name'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $msg	= $_POST['message'];
         
            if(send_msg($cxname, $email , $subject , $msg)){
                echo "<h2 style='font-family:monospace'>Thank you we received your message. </h2>";
                header("refresh:5; url= ../index.php");
            }else{
                echo "<h2 style='font-family:monospace'>Something went wrong Please try again later. </h2>";
                header("refresh:5; url= ../index.php");
            }
        }
        
        
        else if($_POST['cat']=="guestWorker"){

            $company = $_POST['cname'];
            $phone = $_POST['cphone'];
            $email = $_POST['cemail'];
            $worktype	= $_POST['worker'];
            $comment = $_POST['comment'];
            
            if(create_guest_worker($company,$phone,$email,$worktype,$comment)){
                echo "<h2 style='font-family:monospace'>Thank you for business. We received your request for machine breakdown. You will be contact soon. </h2>";
                header("refresh:5; url= ../Skilled_worker.html");
            }else{
                echo "Error while processing your request";
                header("refresh:5; url= ../Skilled_worker.html");
            }

        }else{
            echo "Error in selection";
        }
        

    }

?>