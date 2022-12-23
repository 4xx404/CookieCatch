<?php require_once("Core/init.php"); ?>
<!DOCTYPE html>
<html lang="<?php echo getLanguage(); ?>">
<head>
    <title><?php echo Config::Get("AppData/Name"); ?></title>
    <link rel="shortcut icon" type="image/png" href="Favicon.png"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="Css/Generic.css" />
    <link rel="stylesheet" type="text/css" href="Css/Dashboard.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="JavaScript/Base/Generic.js"></script>
</head>
<body>
    <?php echo HTMLBuilder::DashboardHeader(false); ?>

    <div id="content-container" class="content-container">
        <?php 
            HTMLBuilder::GetResponseContainer(["success", "error"]);

            HTMLBuilder::DashboardContainers();
        ?>
    </div>

    <?php echo HTMLBuilder::GetFooter(); ?>
</body>
</html>