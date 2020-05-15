<?php
    class FileUploader 
    {
        private static $target_directory = "uploads/";
        private static $size_limit = 50000;
        private $uploadOk = false;
        private $file_original_name;
        private $file_type;
        private $file_size;
        private $final_file_name;

        public function setOriginalName($name)
        {
            $this->file_original_name = $name;
        }

        public function setFileType($type)
        {
            $this->file_type = $type;
        }

        public function getFileType()
        {
            return $this->file_type;
        }

        public function setFileSize($size)
        {
            $this->file_size = $size;
        }

        public function getFileSize()
        {
            return $this->file_size;
        }

        public function setFinalFileName($final_name)
        {
            $this->final_file_name = $final_name;
        }

        public function getFinalFileName()
        {
            return $this->final_file_name;
        }

        public function uploadFile($file): bool
        {
            $this->setFileSize($file["size"]);
            $this->setOriginalName(FileUploader::$target_directory . basename($file["name"]));
            $this->setFileType(pathinfo($this->file_original_name,PATHINFO_EXTENSION));
            if (!getimagesize($file["tmp_name"])) {
                return false;
            }
            if ($this->fileAlreadyExists()) {
                $this->displayError("This file already exists");
                return false;   
            }
            if (!$this->fileSizeIsCorrect()) {
                $this->displayError("This file is too large. Maximum upload size is 50KB");
                return false;
            }
            if (!$this->fileTypeIsCorrect()) {
                $this->displayError("Incorrect file type. Accepted file types are .jpg, .jpeg, png and gif");
                return false;
            }
            $this->setFinalFileName($this->file_original_name);
            $this->uploadOk = $this->moveFile($file["tmp_name"]);
            return $this->uploadOk;
        }

        public function displayError(string $message)
        {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['form_errors'] = $message;
        }        

        public function fileAlreadyExists(): bool
        {
            return file_exists($this->file_original_name);
        }
        
        public function saveFilePathTo()
        {
            
        }

        public function moveFile(string $file_tmp_name): bool
        {
            return move_uploaded_file($file_tmp_name,   $this->getFinalFileName());
        }

        public function fileTypeIsCorrect(): bool
        {
            $acceptedPattern = "/jpe?g|png|gif/";
            return preg_match($acceptedPattern,$this->getFileType());
        }

        public function fileSizeIsCorrect(): bool
        {
            return $this->getFileSize() <= FileUploader::$size_limit;
        }

        public function fileWasSelected()
        {
            
        }
    }
    
?>