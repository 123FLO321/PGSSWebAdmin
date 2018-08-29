
<style>
    html, body {
        max-width: 100%;
        overflow-x: hidden;
    }
    pre {
        padding: 10px 16px;
        counter-reset: line;
        font-family: monospace;
        font-size: 13px;
    }
    pre span {
        text-align: left;
        float: left;
        clear: left;
    }
    pre span:before {
        counter-increment: line;
        content: counter(line);
        border-right: 2px solid #ddd;
        padding: 0 .5em;
        margin-right: .5em;
        color: #888;
        left:0;
        width:50px;
        text-align:right;
        float: left;
    }
</style>

<?php
$fullFilename = PGSS_ROOT_DIR.'/logs/'.$file;
?>

<pre><?php
    $handle = fopen($fullFilename, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            print '<span>'.$line.'</span>';
        }
        fclose($handle);
    } else {
        die("Failed to read log,");
    }
?></pre>