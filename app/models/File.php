<?php
class File {
    private $_errors = array();

    public function force_download($dir, $file) {
        if ((isset($dir))&&(!empty($dir))&&(isset($file))&&(file_exists($dir.$file))) {
           header("Content-type: application/force-download");
           header('Content-Disposition: inline; filename="' . $dir.$file . '"');
           header("Content-Transfer-Encoding: Binary");
           header("Content-length: ".filesize($dir.$file));
           header('Content-Type: application/octet-stream');
           header('Content-Disposition: attachment; filename="' . $file . '"');
           readfile("$dir$file");
           return true;
        }

        return false;
    }

    public function save($file, $save_dir, $save_name, $remote = false, $overwrite = true, $disallowed = array(), $maxsize = null) {
        $this->_errors = array();
        //save name no extension
        //save dir relative path from root
        $extension = end(explode('.', $file));
        $save_name = $save_name.'.'.$extension;

        if(isset($file) && isset($save_dir) && isset($save_name)) {
            if($remote == true) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $file);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_NOBODY, true);
                curl_exec($ch);
                $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
            } else {
                $size = filesize($file);
            }

            if(!file_exists(Config::get('url/inc_root') . '/'.$save_dir)) {
                $this->addError('save directory does not exists');
                return $this;
            }

            if($size == 0) {
                $this->addError('this file does not exist');
                return $this;
            }

            if($overwrite == false) {
                if(file_exists(Config::get('url/inc_root') . '/'.$save_dir.$save_name)) {
                    $this->addError('file already exsists');
                    return $this;
                }
            }

            if(sizeof($disallowed) != 0) {
                if(in_array($extension, $disallowed)) {
                    $this->addError('this filetype is not allowed');
                    return $this;
                }
            }

            if(isset($maxsize)) {
                if($size > $maxsize) {
                    $this->addError('filesize is too great');
                    return $this;
                }
            }

            $file = file_get_contents($file);

            file_put_contents(Config::get('url/inc_root') . '/'.$save_dir.$save_name, $file);
            return $this;
        }

        return false;
    }

    private function addError($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return $this->_errors;
    }

    public function delete($dir, $file) {
        if ((isset($dir))&&(!empty($dir))&&(isset($file))&&(file_exists($dir.$file))) {
            unlink($dir.$file);
            return true;
        }

        return false;
    }
}
