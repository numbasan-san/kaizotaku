<?php
	class Layout {

		private $isRoot;

		public function __construct ($isRoot = false) {
			$this->isRoot = $isRoot;
		}

		public function printHeader(){
			$directory = ($this->isRoot) ? "" : "../"; 
			$header = <<<EOF
			<!DOCTYPE html>
	<html>
		<head>
			<meta charset="UTF-8">
			<title>Kaizotaku - Noticas Otaku y Gamer</title>
			<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
		</head>
		<body>
			<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
				<div class="container-fluid">
					<a class="navbar-brand" href="{$directory}index.php">Kaizotaku</a>
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarCollapse">
						<ul class="navbar-nav me-auto mb-2 mb-md-0">
						</ul>
					</div>
				</div>
			</nav>

			<main class="container">
EOF;

			echo $header;

		}

		public function printFooter(){

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