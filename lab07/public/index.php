<?php
require_once('_config.php');
?>

<div id="output">--</div>
<button id="version">Version</button>

<script>
    const output = document.getElementById("output");
    const version = document.getElementById("version");
    version.onclick = function(e) {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == XMLHttpRequest.DONE) {
                if (xmlhttp.status == 200) {
                    output.innerHTML = xmlhttp.responseText;
                }
            }
        };
        xmlhttp.open("GET", "/api.php", true);
        xmlhttp.send();
    }
</script>