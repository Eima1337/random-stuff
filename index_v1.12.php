<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Sprint 1</title>
    <style>
        form {
            display: inline;
        }

        button {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
            font-size: 1em;
            font-family: serif;
        }

        button:focus {
            outline: none;
        }

        button:active {
            color: red;
        }
    </style>
</head>

<body>

    <?php

    print('<br>');

    // ============ printing relative path on the top of page ============
    if (isset($_POST['dirName'])) {
        $openedDir = substr($_POST['dirName'], strlen(getcwd()));
        print(dirname($_SERVER['REQUEST_URI']) . str_replace('\\', '/', $openedDir));
    } else {
        print(dirname($_SERVER['REQUEST_URI']));
    }

    print('<hr>');

    // ============ printing files and folder of the opened path ============
    foreach (getFiles() as $file) {
        $dir = getDir();
        if (is_dir($dir . '\\' . $file)) {
            if ($file == '.') {
                continue;
            } elseif ($file == '..') {
                print('<div class="main"><img src="img/back.gif" alt="">');
                print('<form action="' . $_SERVER['PHP_SELF'] . '" method="POST"">');
                if ($dir == __DIR__) {
                    print('<input type="hidden" name="dirName" value="' . $dir . '">');
                } else {
                    print('<input type="hidden" name="dirName" value="' . dirname($dir) . '">');
                }
                print('<button type="submit">Parent folder</button>');
                print('</form></div>');
            } else {
                print('<div class="main"><img src="img/folder.gif" alt="">');
                print('<form action="' . $_SERVER['PHP_SELF'] . '" method="POST"">');
                print('<input type="hidden" name="dirName" value="' . $dir . '\\' . $file . '">');
                print('<button type="submit">' . $file . '</button>');
                print('</form></div>');
            }
        } elseif (is_file($dir . '\\' . $file)) {
            print('<div class="main"><img src="img/text.gif" alt="">');
            print('<button>' . $file . '</button>');
            print('</div>');
        }
    }

    print('<hr>');

    function getFiles() {
        $dir = getDir();
        return scandir($dir);
    }

    function getDir() {
        if (isset($_POST['dirName']) && basename($_POST['dirName']) != basename(dirname($_SERVER['REQUEST_URI']))) {
            return $_POST['dirName'];
        } else {
            return __DIR__;
        }
    }

    ?>

</body>

</html>