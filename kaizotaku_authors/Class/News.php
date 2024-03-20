
<?php

    class News {
        private $id;
        private $title;
        private $publication_date;
        private $topics;
        private $author;
        private $related_image;
        private $information;
        private $search_code;

        // Constructor
        public function __construct($id, $title, $publication_date, $topics, $author, $related_image, $information, $search_code) {
            $this->id = $id;
            $this->title = $title;
            $this->publication_date = $publication_date;
            $this->topics = $topics;
            $this->author = $author;
            $this->related_image = $related_image;
            $this->information = $information;
            $this->search_code = $search_code;
        }
    }
?>
