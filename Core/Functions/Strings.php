<?php
function escape(string $String = null, bool $UseStripTags = true) {
    return (($String !== null) ? (($UseStripTags === true) ? htmlentities(stripTags($String, false), ENT_QUOTES, "UTF-8") : htmlentities($String, ENT_QUOTES, "UTF-8")) : "");
}

function stripTags(string $String = null, $UseEscape = true) {
    return (($String !== null) ? (($UseEscape === true) ? escape(strip_tags($String)): strip_tags($String)) : "");
}

function lowercase(string $String = null, bool $UseEscape = true) {
    return (($String !== null) ? (($UseEscape === true) ? escape(strtolower($String)) : strtolower($String)) : "");
}

function uppercase(string $String = null, bool $UseEscape = true) {
    return (($String !== null) ? (($UseEscape === true) ? escape(strtoupper($String)) : strtoupper($String)) : "");
}

function capitalise(string $String = null, bool $UseEscape = true) {
    return (($String !== null) ? (($UseEscape === true) ? ucfirst(lowercase($String)) : ucfirst($String)) : "");
}

function capitaliseWords(array $WordList = array(), bool $UseEscape = true, $IncludeSpaces = false) {
    $String = "";
    
    if(is_array($WordList) && count($WordList) > 0) {
        foreach($WordList as $Word) {
            $String .= capitalise(lowercase($Word, false), $UseEscape) . (($IncludeSpaces === true) ? " " : "");
        }
    }

    return($String);
}

function getLanguage() {
    return ((isset($_SERVER["HTTP_ACCEPT_LANGUAGE"])) ? escape(substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2)) : "en");
}

function startsWith(string $String = null, string $CheckString = null) {
    return (($String !== null && $CheckString !== null && (str_starts_with($String, $CheckString) === true)) ? true : false);
}

function endsWith(string $String = null, string $CheckString = null) {
    return (($String !== null && $CheckString !== null && (str_ends_with($String, $CheckString) === true)) ? true : false);
}

function tabIndent(string $Text = null, bool $UseEscape = true) {
    return (($Text !== null) ? "&nbsp&nbsp&)nbsp&nbsp" . (($UseEscape === true) ? escape($Text) : $Text) : "");
}
?>