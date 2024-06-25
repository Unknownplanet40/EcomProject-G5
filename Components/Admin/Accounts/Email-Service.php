<?php
session_start();
include_once('../../../Databases/DB_Configurations.php');

$login = false;
$Username = 'Undefined';
$UserRole = 'Undefined';
$Theme = 'light';

if (isset($_SESSION['User_Data'])) {
    if ($_SESSION['User_Data']['Is_user_logged_in'] == 1) {
        $login = true;
        $Username = $_SESSION['User_Data']['First_Name'] . ' ' . $_SESSION['User_Data']['Last_Name'];
        $Last_Login = date('F j, Y', strtotime($_SESSION['User_Data']['Last_Login']));
        $UserRole = $_SESSION['User_Data']['Role'];
        $Theme = $_SESSION['User_Data']['User_Settings']['Theme'];
        echo '<script>var Is_User_Logged_In = true;</script>';
        echo '<script>var User_ID = "' . $_SESSION['User_Data']['user_ID'] . '";</script>';
    }
} else {
    echo '<script>var Is_User_Logged_In = false;</script>';
    echo '<script>var User_ID = 0;</script>';
}

// if user is not logged in, redirect to homepage
if (!$login) {
    header('Location: ../../Home/Homepage.php');
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="<?php echo $Theme; ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('../../../Utilities/Third-party/Import-ThirdParty_Admin.php') ?>
    <link rel="stylesheet" href="../../../Utilities/Stylesheets/Admin/SidebarStyle.css">
    <title>Email Service</title>
    <?php include_once('../../../Assets/Icons/Icon_Assets.php'); ?>
    <script>
        // clear specific local storage
        localStorage.removeItem('FileName');
        //get file mame and set it as the title
        var FileName = document.location.pathname.split('/').slice(-1)[0];
        // save to local storage
        localStorage.setItem('FileName', FileName);
    </script>
</head>

<body class="d-md-flex">
    <?php
    include_once('../sidebar/Sidebar.php');
    include_once('../../Modal/Admin/AccountINFO.php');
    ?>

    <div class="container-fluid mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Email Service</h4>
                        <p>This information below will be used to send notifications and updates to users via the SMTP server.</p>
                    </div>
                    <div class="card-body">
                        <?php

                        $stmt = $conn->prepare("SELECT Credential FROM secret_keys WHERE ID = 2");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $Email_Add = $row['Credential'];
                        $stmt->close();

                        $stmt = $conn->prepare("SELECT Credential FROM secret_keys WHERE ID = 1");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $Email_Pass = $row['Credential'];
                        $stmt->close();

                        // convert the password to &dot; for security reasons
                        $Email_Pass_new = str_repeat('&bull;', strlen($Email_Pass));
                        ?>

                        <div class="row mb-3 g-3 row-cols-1 row-cols-md-2">
                            <div class="col-md-6 text-center">
                                <p class="">Email Address</p>
                                <h3 class="mb-3" id="Email_Add"><?php echo $Email_Add; ?></h3>
                            </div>
                            <div class="col-md-6 text-center" id="showtemp">
                                <p class="">Temporary Password <small class="text-secondary">(Hover to show)</small></p>
                                <h3 class="mb-3" id="Email_Pass_temp"><?php echo $Email_Pass_new; ?></h3>
                                <h3 class="mb-3 visually-hidden" id="Email_Pass"><?php echo $Email_Pass; ?></h3>
                            </div>
                            <div class="col-md-12 text-center">
                                <butto class="btn btn-primary btn-gradient w-50" id="Email_Data" data-bs-toggle="modal" data-bs-target="#EmailData">Update Service Information</button>
                            </div>
                            <div class="col-md-12">
                                <div class="accordion accordion-flush" id="Accord1">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                Before you update your email service, please read this first.
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#Accord1">
                                            <div class="accordion-body">
                                                <div class="row row-cols-1 row-cols-md-2 g-3">
                                                    <div class="col-md-4">
                                                        <h4 class="text-secondary">Please make sure that you don't use your <b>real password</b> for security reasons. <br><br> You can use a temporary password for this purpose by watching this video.</h4>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="d-flex justify-content-center align-items-center">
                                                            <iframe class="rounded" style="border: 1px solid #ccc; border-radius: 5px; box-shadow: 0 0 5px 0 #ccc; width: 100%; height: 265px; max-width: 560px;" src="https://www.youtube.com/embed/74QQfPrk4vE?si=GcBznV-oqfJPXiW4&amp;controls=0" title="Setup App Password" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    document.getElementById('Email_Data').addEventListener('click', function() {
        var Email_Add = document.getElementById('Email_Add').innerText;
        var Email_Pass = document.getElementById('Email_Pass').innerText;
        var modalEmail = document.getElementById('SMTP_Email');
        var modalPass = document.getElementById('SMTP_Password');

        modalEmail.value = Email_Add;
        modalPass.value = Email_Pass;
    });

    document.getElementById('SMTPEye').addEventListener('click', function() {
        var modalPass = document.getElementById('SMTP_Password');
        if (modalPass.type === "password") {
            modalPass.type = "text";
            document.getElementById('SMTP-label').innerHTML = '<use xlink:href="#Visible-off" />';
        } else {
            modalPass.type = "password";
            document.getElementById('SMTP-label').innerHTML = '<use xlink:href="#Visible" />';
        }
    });

    document.getElementById('SaveSMTP').addEventListener('click', async function() {
        var modalEmail = document.getElementById('SMTP_Email').value;
        var modalPass = document.getElementById('SMTP_Password').value;


        if (modalEmail == '' || modalPass == '') {
            alert('Please fill in all the fields');
            return;
        }

        if (modalEmail.length < 5) {
            document.getElementById('SaveSMTP').classList.add('shack');
            setTimeout(() => {
                document.getElementById('SaveSMTP').classList.remove('shack');
            }, 1000);
            return;
        }

        if (modalPass.length < 5) {
            document.getElementById('SaveSMTP').classList.add('shack');
            setTimeout(() => {
                document.getElementById('SaveSMTP').classList.remove('shack');
            }, 1000);
            return;
        }

        document.getElementById('SaveSMTP').disabled = true;
        document.getElementById('SaveSMTP').innerHTML = '<div class="spinner-border spinner-border-sm" role="status"></div> Saving...';

        var data = {
            Email: modalEmail,
            Password: modalPass
        };

        try {
            const response = await fetch('../../../Utilities/api/MailService.php', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }


            const result = await response.json();

            if (result.status == 'error') {
                alert(result.message);
                document.getElementById('SaveSMTP').disabled = false;
                document.getElementById('SaveSMTP').innerHTML = 'Not Saved';

                setTimeout(() => {
                    document.getElementById('SaveSMTP').innerHTML = 'Save Changes';
                }, 3000);
                return;
            }

            if (result.status == 'success') {
                document.getElementById('SaveSMTP').disabled = false;
                document.getElementById('SaveSMTP').innerHTML = 'Service Updated';

                setTimeout(() => {
                    document.getElementById('SaveSMTP').innerHTML = 'Save Changes';
                    location.reload();
                }, 2000);
            }
        } catch (error) {
            console.error(error);
        }
    });

    document.getElementById('showtemp').addEventListener('mouseover', function() {
        document.getElementById('Email_Pass_temp').classList.add('visually-hidden');
        document.getElementById('Email_Pass').classList.remove('visually-hidden');
    });

    document.getElementById('showtemp').addEventListener('mouseout', function() {
        document.getElementById('Email_Pass_temp').classList.remove('visually-hidden');
        document.getElementById('Email_Pass').classList.add('visually-hidden');
    });
</script>

</html>