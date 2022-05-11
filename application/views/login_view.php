<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login</title>
        <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 11]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="google-site-verification" content="xAcZDDaR7KVD98VRh0kTOXqm9sD5GV7RUeQ-BgL6H1Q" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="" />
        <meta name="keywords" content="">
        <meta name="author" content="Phoenixcoded" />
        <!-- Favicon icon -->
        <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
        <!-- vendor css -->
        <link rel="stylesheet" href="assets/css/style.css">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
        <meta name="google-signin-client_id" content="556874224753-10a4flvvk04ugmm3ag2fq4bov3t8gpl5.apps.googleusercontent.com">

        <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
        <script type="text/javascript">           

            function onSignIn(googleUser) {
                var profile = googleUser.getBasicProfile();
                console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
                console.log('Name: ' + profile.getName());
                console.log('Image URL: ' + profile.getImageUrl());
                console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.

                $.post("login/get_login", { "ID": profile.getId(), "vc_foto": profile.getImageUrl() }, function(data) {
                    if (data > 0){
                        window.location = "console";
                        return false;
                    }
                });
            }

            function signOut() {
                var auth2 = gapi.auth2.getAuthInstance();
                auth2.signOut().then(function () {
                  console.log('User signed out.');
                });
            }

        </script>

    </head>
    <body>
        <!-- [ auth-signin ] start -->
        <div class="auth-wrapper">
            <div class="auth-content">
                <div class="card">
                    <div class="row align-items-center text-center">
                        <div class="col-md-12">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="g-signin2" id="login" data-onsuccess="onSignIn"></div>
                                    <a href="javascript:void(0);" onclick="signOut();" data-toggle="tooltip" title="Logout" class="text-danger"><i class="feather icon-power"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ auth-signin ] end -->
        <!-- Required Js -->
        <script src="assets/js/vendor-all.min.js"></script>
        <script src="assets/js/plugins/bootstrap.min.js"></script>
        <script src="assets/js/ripple.js"></script>
        <script src="assets/js/pcoded.min.js"></script>
    </body>
</html>