<?php 

?>
<!DOCTYPE html>
<html>
    <div class="container">
        <h2 class="text-center">ADD NEW STUDENT</h2>
        <form class="contact-form" action="" method="POST">

            <input class="form-control" type="text" name="FirstName" placeholder="First Name..."
                   value="<?php
                   if (isset($FirstName)) {
                       echo $FirstName;
                   }
                   ?>"/>


            <?php if (!empty($FnameError)) { ?>
                <div class="alert alert-danger alert-dismissible" role="start">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                    <?php
                    echo $FnameError;
                    ?>
                </div>
            <?php } ?>


            <input class="form-control" type="text" name="LastName" placeholder="Last Name ..."
                   value="<?php
                   if (isset($LastName)) {
                       echo $LastName;
                   }
                   ?>"/>


            <?php if (!empty($LnameError)) { ?>
                <div class="alert alert-danger alert-dismissible" role="start">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                    <?php
                    echo $LnameError;
                    ?>
                </div>
            <?php } ?>


            <input class="form-control" type="text" name="collegeID" placeholder="ID..."
                   value="<?php
                   if (isset($id)) {
                       echo $id;
                   }
                   ?>"/>


            <?php if (!empty($IdError)) { ?>
                <div class="alert alert-danger alert-dismissible" role="start">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                    <?php
                    echo $IdError;
                    ?>
                </div>
            <?php } ?>


            <input class="form-control" type="email" name="Email" placeholder="Email..."
                   value="<?php
                   if (isset($email)) {
                       echo $email;
                   }
                   ?>"/> 


            <?php if (!empty($emailError)) { ?>
                <div class="alert alert-danger alert-dismissible" role="start">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> 
                    <?php
                    echo $emailError;
                    ?>
                </div>
            <?php } ?>


            <select class="form-control" id="gender" name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <br>
            <select class="form-control input-sm" id="university" name="univeristy" required>

                <option value="Helwan">Helwan</option>
                <option value="Cairo">Cairo</option>
                <option value="Ain Shmas">Ain Shams</option>
                <option value="Mansora">Mansora</option>
                <option value="Assuit">Assuit</option>
                <option value="Zagazig">Zagazig</option>
                <option value="Menia">Menia</option>
                <option value="Fayoum">Fayoum</option>
                <option value="Banha">Banha</option>
                <option value="Minufiya">Minufiya</option>
                <option value="Suez Canal">Suez Canal</option>
                <option value="Masr">Masr</option>
                <option value="October">October</option>
                <option value="Mostakbal">Mostkbal</option>
                <option value="Delta">Delta</option>
            </select>
            <br>
            <input class="btn btn-success btn-block" type="submit" value="ADD" name="add"/>
        </form>
    </div>
</html>