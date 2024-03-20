<?php

    class utilities {

        public $temas = [
            1 => "Anime",
            2 => "Cultura",
            3 => "Manga",
            4 => "Mercancía",
            5 => "Tecnología",
            6 => "Videojuegos",
            7 => "Japón"
        ];

        public function GetLastElement($list) {
            $lastIndex = count($list) - 1;
            return $list[$lastIndex];
        }

        public function SearchProperty($list, $property, $value) {
            $filters = [];
            foreach ($list as $key => $item) {
                if ($item->$property === $value) {
                    array_push ($filters, $item);
                }
            }
            return $filters;
        }

        public function GetIndexElement($list, $property, $value) {
            foreach ($list as $key => $item) {
                if ($item->$property === $value) {
                    return $key;
                    break;
                }
            }
            return null;
        }
    }

?>