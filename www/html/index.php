<? require_once('./php/library.php'); ?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>DockBox</title>
        <link rel="shortcut icon" href="./assets/images/favicon.svg" type="image/svg+xml">
        <link rel="stylesheet" href="./assets/css/bulma.min.css">
        <style>
            .min-vh-container {
                min-height: 100vh;
            }
        </style>
    </head>
    <body>
        <div class="container is-flex is-flex-direction-column min-vh-container">
            <section class="hero is-medium is-link">
                <div class="hero-body">
                    <div class="container has-text-centered">
                        <h1 class="title is-1">
                            dockBox
                        </h1>
                        <h2 class="subtitle is-4">
                            Your local development environment
                        </h2>
                    </div>
                </div>
            </section>
            <section class="section is-flex-grow-1">
                <div class="container">
                    <div class="columns">
                        <div class="column">
                            <? echo getEnviroment(); ?>
                            <? echo getTools(); ?>
                        </div>
                        <div class="column">
                            <? echo getQuickLinks(); ?>
                            <? echo getProjects(); ?>
                        </div>
                    </div>
                </div>
            </section>
            <? echo getFooter(); ?>
        </div>
    </body>
</html>
