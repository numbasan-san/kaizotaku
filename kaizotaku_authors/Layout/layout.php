<?php

class Layout {

    private $isRoot;
    private $isLogged;

    public function __construct($isRoot = false, $isLogged = false, $isTitle = false, $title = '') {
        $this->isRoot = $isRoot;
        $this->isLogged = $isLogged;
        $this->isTitle = $isTitle;
        $this->title = $title;
    }

    public function printHeader() {
        $directory = ($this->isRoot) ? "" : "../";
        $logout_link = ($this->isLogged) ? "<a href=" . $directory . "Functions/logout.php>logout</a>" : ""; // Texto de enlace para login o logout según el estado de inicio de sesión
        $title_name = ($this->isTitle) ? $this->title : "Kaizotaku - Noticias Otaku y Gamer";
        $header = <<<EOF
            <!DOCTYPE html>
            <html>
                <head>
                    <meta charset="UTF-8">
                    <title>{$title_name}</title>
                    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' https://cdn.jsdelivr.net; style-src 'self' https://cdn.jsdelivr.net; font-src 'self' https://cdn.jsdelivr.net; img-src 'self'; frame-src 'self'; child-src 'none';" />
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
                </head>
                <body>
                    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
                        <div class="container-fluid">
                            <a class="navbar-brand" href="{$directory}index.php">Kaizotaku</a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse float-end" id="navbarCollapse">
                                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                                    <li>
                                        {$logout_link}
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
