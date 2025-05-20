<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Application</title>

    <style>
        body{
            background-color: rgba(145, 148, 150, 0.325);
            font-family: Arial, sans-serif;
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            font-size: 16px;    
        }
        .container{
            background-color: white;
            width: 500px;
            padding: 10px; 
            margin-bottom: 15px auto 0; 
            border-top: 5px solid blue;           
        }
        .container h1{
            padding-bottom: 6px;
            text-align: center;
        }
        .name{
            width: 90%;
            position: relative;
            margin: 10px auto ;
            
        }
        .box{
            width: 92%;
            height: 35px;
            padding: 0px 15px
        }
        .name label{
            font-weight: bold;
        } 

        .checkbox-group{
            margin-top: 3px;
        }

        .goal{
            display: inline-block;
            width: 100%;
            height: 35px;
            padding: 0px 15px;
            cursor: pointer;
            
        }

        .submit{
            background-color: blue;
            color: white;
            width: 100%;
            height: 35px;
            border: none;
            font-size: 14px;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <h1>Gym registration form</h1>

        <div class="name">
        <p > Fill out the information below to sing up for our gym facilities.</p>
        </div>

        <form method="POST" action="">

            <div class="name">
                
                    <label for="fn" >Name:</label>
                    <input type=" text" name="fn" id="fn" required placeholder="Enter your full name" class="box">
            </div> 

            <div class="name">
                <label for="em">Email Address:</label>
                <input type="email" name="em" id="em" required placeholder="Enter your email" class="box">
           </div> 

           <div class="name">
                <label for="pn">Phone Number:</label>
                <input type="number" name="pn" id="pn" required placeholder="Enter your phone number" class="box">
            </div>

            <div class="name">
                <label for="ag">Date of Birth:</label>
                <input type="date" name="ag" id="ag" required placeholder="DD.MM.YYYY" class="box">
            </div>

            <div class="name">
                <label >Fitness Goal:</label>
                <select name="goal" class="goal" >
                    <option value=""disabled selected>Select your fitness goal</option>
                    <option value="Weight Loss">Weight loss</option>
                    <option value="Muscle Gain">Muscle Gain</option>
                    <option value="Endurance">Endurance</option>
                </select>
            </div>

            <div class="name">
                <label>Preferred Workout Time:</label>
                <div class="checkbox-group">
                    <input type="radio" name="time" value="morning"> Morning
                    <input type="radio" name="time" value="afternoon"> Afternoon
                    <input type="radio" name="time" value="evening"> Evening
                    <input type="radio" name="time" value="night"> Night
                    <input type="radio" name="time" value="other"> Other time
                </div>
            </div>

            <div class="name">
                <p>Please read and accept all the terms and conditions to proceed with the registration.</p>
            </div>

            <div class="name">
                 <input type="checkbox" name="terms" class="checkbox-type"> I accept the terms and conditions.
            </div>
            
            <div class="name">
                 <button class="submit">Submit Registration</button>
            <div>
            
        </form>
    </div>

    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Connect to DB
        $conn = new mysqli("localhost", "root", "", "gym_db");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Form values
        $name  = $_POST['fn'];
        $email = $_POST['em'];
        $phone = $_POST['pn'];
        $dob   = $_POST['ag'];
        $goal  = $_POST['goal'];
        $time  = $_POST['time'];
        $terms = isset($_POST['terms']) ? 1 : 0;

        // Insert into DB
        $sql = "INSERT INTO registration (name, email, phone, dob, goal, time, accepted_terms)
                VALUES ('$name', '$email', '$phone', '$dob', '$goal', '$time', '$terms')";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>✅ Registration successful!</p>";
        } else {
            echo "<p style='color:red;'>❌ Error: " . $conn->error . "</p>";
        }

        $conn->close();
     }
    ?>

</body>
</html>