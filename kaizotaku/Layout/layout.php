<?php

class Layout
{

    private $isRoot;

    public function __construct($utilities, $isRoot = false, $isTitle = false, $title = '')
    {
        $this->isRoot = $isRoot;
		$this->utilities = $utilities;
		$this->isTitle = $isTitle;
		$this->title = $title;
    }

    public function printHeader()
    {
        $directory = ($this->isRoot) ? "" : "../";
        $utilities = ($this->utilities);
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
					<div class="container float-center">
						<a class="navbar-brand" href="{$directory}index.php"><h2>Kaizotaku</h2></a>
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse row" id="navbarSupportedContent">
							<div class="col-md-2">
								<ul class="navbar-nav">
									<li class="nav-item dropdown">
										<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
											Temas
										</a>
										<ul class="dropdown-menu">
EOF;

		// Agregar el bucle foreach para imprimir los temas
		foreach ($utilities->temas as $id => $value) {
			$header .= "<li><a class=\"dropdown-item\" href=\"{$directory}Views/search_news.php?tema={$id}\">{$value}</a></li>";
		}

		// Parte del footer hasta el final del heredoc
		$header .= <<<EOF
										</ul>
									</li>
								</ul>
							</div>
							
							<div class="col-md-8">
								<div class="d-flex container-fluid">
									<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">									
									<button class="btn btn-outline-success" type="submit">Search</button>
								</div>
							</div>
							
							<div class="col-md-2">
								<ul class="navbar-nav me-auto mb-2 mb-lg-0 float-end">
									<li class="nav-item">
										<a class="nav-link" href="#">
											<img class="d-inline-block align-text-top" style="width: 30px; height: 30px;" src="https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/discord-white-icon.png"  />
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#">
											<img class="d-inline-block align-text-top" style="width: 30px; height: 30px;" src="https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/youtube-app-white-icon.png"  />
										</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="#">
											<img class="d-inline-block align-text-top" style="width: 30px; height: 30px;" src="https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/instagram-white-icon.png"  />
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</nav>
				<main class="container">
EOF;

	// Imprimir el header
	echo $header;
}

    public function printFooter()
    {

        $directory = ($this->isRoot) ? "" : "../";
        $footer = <<<EOF
            </main>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
            
            </div>
        </body>
    </html>
EOF;

        print $footer;
    }
}
?>
