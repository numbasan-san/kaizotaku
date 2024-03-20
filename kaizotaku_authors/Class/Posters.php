
<?php

    class Author {
        private $id;
        private $name;
        private $email;
        private $password;
        private $profile_photo;
        private $posts_history;

        // Constructor
        public function __construct($id, $name, $email, $password, $profile_photo, $posts_history) {
            $this->id = $id;
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
            $this->profile_photo = $profile_photo;
            $this->posts_history = $posts_history;
        }
    }
?>
