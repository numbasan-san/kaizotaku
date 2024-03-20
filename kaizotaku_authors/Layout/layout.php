<?php

class Layout {

    private $isRoot;
    private $isLogged;

    public function __construct($isRoot = false, $isLogged = false) {
        $this->isRoot = $isRoot;
        $this->isLogged = $isLogged;
    }

    public function printHeader() {
        $directory = ($this->isRoot) ? "" : "../";
        $path = ($this->isLogged) ? "./Functions/" : "./Views/";
        $login_directory = ($this->isRoot) ? $path : "";
        $login_logout = ($this->isLogged) ? "logout.php" : "login.php"; // Cambio de login a logout según el estado de inicio de sesión
        $login_logout_text = ($this->isLogged) ? "logout" : ""; // Texto de enlace para login o logout según el estado de inicio de sesión
        $header = <<<EOF
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="UTF-8">
                    <title>Kaizotaku - Noticias Otaku y Gamer</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
                </head>
                <body>
                    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
                        <div class="container-fluid">
							::before
                            <a class="navbar-brand" href="{$directory}index.php">Kaizotaku</a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse float-end" id="navbarCollapse">
                                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                                    <li>
                                        <a href="{$login_directory}{$login_logout}">{$login_logout_text}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>

                    <main class="container">
EOF;

        echo $header;
    }

    public function printFooter() {
        $directory = ($this->isRoot) ? "" : "../";
        $footer = <<<EOF
                    </main>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
                </body>
            </html>
EOF;

        print $footer;
    }
}

?>
