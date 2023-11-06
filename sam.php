<?php
// PHP code here, if needed

// Define the secret code here (e.g., "mysecretcode")
$secretCode = "500";

if (isset($_POST['security_code'])) {
    $enteredCode = $_POST['security_code'];
    if ($enteredCode === $secretCode) {
        // Code is correct, show the content container
        $showContainer = true;
    } else {
        // Code is incorrect
        $error = "Invalid Code";
    }
}

$javascriptCode = '
var currentIndex = 0;
var count = 0;

// JavaScript code here
// ...

function startOpeningAndClosingLinks() {
    var linksInput = document.getElementById("linksInput").value;
    var links = linksInput.split(",").map(link => link.trim());

    if (links.length === 0) {
        alert("Please enter at least one link.");
        return;
    }

    openAndCloseLinks(links);
}
function openAndCloseLinks(links) {
    if (count < 100000) {
        for (var i = 0; i < 25; i++) {
            var link = links[currentIndex];
            var newWindow = window.open(link)
;
            count++;
            if (currentIndex < links.length - 1) {
                currentIndex++;
            } else {
                currentIndex = 0;
            }

            // Close the tab after 5 seconds
            setTimeout(function(tabToClose) {
                return function() {
                    if (tabToClose && !tabToClose.closed) {
                        tabToClose.close();
                    }
                };
            }(newWindow), 5000);
        }

        // Open a new batch of tabs every 1 second
        setTimeout(function() {
            openAndCloseLinks(links);
        }, 1000); // 1000 milliseconds (1 second)
    }
}
';

// Base64 encode the JavaScript code
$base64EncodedJS = base64_encode($javascriptCode);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tab Opener and Closer</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        
        .container {
            display: <?= isset($showContainer) ? 'block' : 'none' ?>;
            margin: 100px auto;
            width: 900px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
        
        label {
            display: block;
            margin-bottom: 10px;
        }
        
        textarea {
            width: 100%;
            height: 450px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container" id="content-container">
        <h2>Link Opener and Closer</h2>
        <label for="linksInput">Enter Links:</label>
        <textarea id="linksInput" placeholder="Paste links separated by commas" oninput="colorizeLinks()"></textarea>
        <button onclick="startOpeningAndClosingLinks()">Submit</button>
    </div>

    <script>
        // Decode and execute the JavaScript code
        var decodedJS = atob("<?php echo $base64EncodedJS; ?>");
        eval(decodedJS);
    </script>
</body>

</html>