<!doctype html>
<html lang="eng">
<head>
    <?php require_once "./php/header.php"; ?>
    <title>SBCC License Request Form</title>
</head>
<body>
    <?php require_once "./php/navbar.php"; ?>
    <?php 
        ini_set('display_errors', 1); 
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL); 

        require_once "./php/SqlDB.php"; 
    ?>

    <?php 
        $query_str = array();
        parse_str($_SERVER['QUERY_STRING'], $query_str);
        // var_dump( $query_str['contact_name'] );
        // var_dump( $query_str['contact_email'] );


        // if ( isset($_POST['contact_name']) &&  isset($_POST['contact_email']) ){ 
        if ( isset($query_str['contact_name']) &&  isset($query_str['contact_email']) ){ 
            $db = new SqlDB();
            $contact_name   = $query_str['contact_name'];
            $contact_email  = $query_str['contact_email'];

            $query = "SELECT * FROM customers WHERE contact_email='$contact_email'";

            $data = $db->query( $query )->fetchAll();
            $data_count = count($data);
            // var_dump( $data[0]['school_name'] );
            // echo $data_count ? $data[0]['school_name'] : 'data_count false';
                
        }else{
            $data_count = 0; 
            $contact_name = "";
            $contact_email = "";
        }
    ?>

    <input id="new-user-hidden" type="hidden" value="<?php echo $data_count ? 0 : 1 ?>">

    <input id="school-name-hidden" type="hidden" value="<?php echo $data_count ? $data[0]['school_name'] : ''; ?>" >
    <input id="street-address-hidden" type="hidden" value="<?php echo $data_count ? $data[0]['street_address'] : ''; ?>" >
    <input id="city-hidden" type="hidden" value="<?php echo $data_count ? $data[0]['city'] : ''; ?>" >
    <input id="state-hidden" type="hidden" value="<?php echo $data_count ? $data[0]['state'] : ''; ?>" >
    <input id="zip-code-hidden" type="hidden" value="<?php echo $data_count ? $data[0]['zip_code'] : ''; ?>" >
    <input id="contact-name-hidden" type="hidden" name="contact_name" value="<?php echo $data_count ? $data[0]['contact_name'] : $contact_name; ?>" >
    <input id="contact-email-hidden" type="hidden" name="contact_email" value="<?php echo $data_count ? $data[0]['contact_email'] : $contact_email ?>" > 
    <input id="contact-phone-hidden" type="hidden" name="contact_phone" value="<?php echo $data_count ? $data[0]['contact_phone'] : ''; ?>" >
    <input id="purchased-from-hidden" type="hidden" name="purchased_from" value="<?php echo $data_count ? $data[0]['purchased_from'] : ''; ?>" >

    <!-- <script src="./libs/jquery&#45;validation&#45;1.15.0/dist/jquery.validate.min.js"></script> -->

    <div id="main-area">
        <header id="main-header">
            <h1>ScreenBeam Classroom Commander License</h1>
        </header><br/>

        <p>*All fields required</p>

        <div id="form"></div>

    </div> <!-- #main-area end -->

    <br/><br/>

    <!-- Note: when deploying, replace "development.js" with "production.min.js". -->
    <script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>

    <!-- <script src="https://unpkg.com/react@16/umd/react.production.min.js" crossorigin></script> -->
    <!-- <script src="https://unpkg.com/react&#45;dom@16/umd/react&#45;dom.production.min.js" crossorigin></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/reaptcha@1.1.0-beta.1"></script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- Load our React component. -->
    <script type="text/babel" src="./js/form.js"></script>
    <script type="text/javascript" src="./js/test.js"></script>

    <?php require_once "./php/footer.php"; ?>

</body>
</html>
