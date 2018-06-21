<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="AssignmentStyleSheet.css" />
        <meta charset="utf-8">

        <title>Sign Up Page</title>
    </head>

    <body class = "SP">



        <h1 class= "SP">

            The Spider's Web - Sign Up
        </h1>
        <section>
            <hr>
        </section>
        <br>
        <h3 class = SP><q> Join us, prosper among the threads!</q> <br> -Shrey Shah (Creator) </h3>

        <form name="SignUp" action = "SignUpP.php" method = "post" enctype="multipart/form-data">
            <input type="hidden" name="submittedS" value="1"/>
            <div class="containerSP">
                <div class = "contSP2">
                    <p>Please fill in this form to create an account.</p>

                    <hr>

                    <table>

                        <tr><td>Email: </td><td> <input type="text" id = "email" name="email" size="30" required placeholder="xxx@yyy.zzz"/></td></tr>
                        <tr><td></td><td><label  class="err_msg"></label></td></tr>
                        <tr><td>Username: </td><td> <input type="text" id = "username" name="username" size="30" required placeholder="No Spaces or Special Char."/></td></tr>
                        <tr><td></td><td><label  class="err_msg"></label></td></tr>
                        <tr><td>Date of Birth: </td><td> <input type="text" id = "dob"name="dob" size="30" placeholder="mm/dd/yyyy" required/></td></tr>
                        <tr><td><label for="fileToUpload">Image</label></td><td><input type="file" name="fileToUpload" id="fileToUpload"></td></tr>
                        <tr><td>Password: </td><td> <input type="password" id = "pass" name="pass" size="30" placeholder="Enter Password"required/></td></tr>
                        <tr><td></td><td><label  class="err_msg"></label></td></tr>
                        <tr><td>Confirm Password: </td><td> <input type="password" id = "pass2" name="pass2" size="30" placeholder="Same as above" required/></td></tr>
                        <tr><td></td><td><label class="err_msg"></label></td></tr>

                    </table>

                    <p><input type="submit" value="Sign up"/><input type="reset" value="Reset"/></p>

                    </form>



                    </body>
                    </html>
