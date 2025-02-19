<?php

shell_exec('sudo chmod -R 775 /var/www'); 

function getToolVersion($command) {
    $output = shell_exec("$command 2>&1");
    
    if ($output === null) {
        return 'non installato';
    }

    if (preg_match('/(\d+\.\d+\.\d+)/', $output, $matches)) {
        return $matches[0];
    }

    return 'formato non riconosciuto';
}

function getEnviroment() {

    $apache_version = apache_get_version();
    $php_version = phpversion();

    $link = mysqli_connect("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], null);

    if (mysqli_connect_errno()) {
        $db_version = mysqli_connect_error();
    } else {
        $db_version = mysqli_get_server_info($link);
    }

    mysqli_close($link);

    return <<<EOF
        <h3 class="subtitle is-4 has-text-centered">Environment</h3>
        <hr>
        <div class="content">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <tbody>
                    <tr>
                        <td>PHP</td>
                        <td>$php_version</td>
                    </tr>
                    <tr>
                        <td>Webserver</td>
                        <td>$apache_version</td>
                    </tr>
                    <tr>
                        <td>Database</td>
                        <td>$db_version</td>
                    </tr>
                </tbody>
            </table>
        </div>
    EOF;
}

function getTools() {

    $out = '';

    $ver = [
        'Git' => getToolVersion('git --version'),
        'Composer' => getToolVersion('composer --version'),
        'Node.js' => getToolVersion('node --version'),
        'Npm' => getToolVersion('npm --version 2>&1'),
        'Yarn' => shell_exec('yarn --version 2>&1'),
    ];

    foreach ($ver as $k => $v) {
        $out .= '<tr><td>' . $k . '</td><td>'. $v . '</td></tr>';
    }

    return <<<EOF
        <h3 class="subtitle is-4 has-text-centered">Tools</h3>
        <hr>
        <div class="content">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <tbody>$out</tbody>
            </table>
        </div>
    EOF;
}

function getQuickLinks() {
    return <<<EOF
        <h3 class="subtitle is-4 has-text-centered">Quick Links</h3>
        <hr>
        <div class="content">
            <ul>
                <li><a href="./php/phpinfo.php">phpinfo()</a></li>
                <li><a href="./php/test_db.php">Test DB Connection with mysqli</a></li>
                <li><a href="./php/test_db_pdo.php">Test DB Connection with PDO</a></li>
            </ul>
        </div>
    EOF;
}

function getProjects() {

    $out = '';

    $projects = array_map('basename', glob('../projects/*', GLOB_ONLYDIR));
    $protocol = getenv('SSL_TYPE') === 'plain' ? 'http://' : 'https://';
    $port = getenv('SSL_TYPE') === 'plain' ? getenv('HOST_MACHINE_UNSECURE_HOST_PORT') : getenv('HOST_MACHINE_SECURE_HOST_PORT');

    if($projects) {

        $out .= '<ul>';

        foreach($projects as $p) {

            $connection = @fsockopen("$p." . getenv('DOMAIN'), $port, $errno, $errstr, 2);

            if ($connection) {

                fclose($connection);
                $folders = array_map('basename', glob("../projects/$p/*", GLOB_ONLYDIR));

                if(getenv('MAIN_FOLDER')) {

                    $temp = "<li class=\"has-text-warning\">Create '" . getenv('MAIN_FOLDER') . "' folder in www/projects/$p.</li>";

                    foreach($folders as $f) {

                        if($f === getenv('MAIN_FOLDER')) {
                            $temp = "<li class=\"has-text-success\"><a href=\"$protocol$p." . getenv('DOMAIN') . "\" target=\"_blank\">$p." . getenv('DOMAIN') . "</a></li>";
                            break;
                        }

                    }

                    $out .= $temp;

                } else {
                    $out .= "<li class=\"has-text-success\"><a href=\"$protocol$p." . getenv('DOMAIN') . "\" target=\"_blank\">$p." . getenv('DOMAIN') . "</a></li>";
                }


            } else {
                $out .= "<li class=\"has-text-warning\">Host: 127.0.0.1 $p." . getenv('DOMAIN') . '</li>';
            }

        }

        $out .= '</ul>';

    } else {
        $out = '<p class="has-text-warning">Create your folder\'s project in www/projects.</p>';
    }
                
    return <<<EOF
        <hr>
        <div class="content">
            <pre>$out</pre>
        </div>
    EOF;
}

function getFooter() {

    $version = 'v0.1.5';

    return <<<EOF
        <footer class="footer">
            <div class="content has-text-centered">
                <p>
                    <strong><a href="https://github.com/rocco-giandomenico" target="_blank">© 2024 - Rocco Giuseppe Giandomenico</a></strong><br>
                    The source code is released under the <a href="./php/mit.php" target="_blank">MIT license</a>.<br>
                    <strong>$version</strong>
                </p>
            </div>
        </footer>
    EOF;
}
