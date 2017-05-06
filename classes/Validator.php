<?php

class validator {

    public function GenrateVerificationCode($vr1, $vr2) {
        return substr(md5($vr1 . '7sala' . $vr2), 20);
    }

    public function hashData($inputData) {
        $inputData = sha1($inputData);
        return $inputData;
    }

    public function secureData($data) {
        if (!empty($data)) {
            $data = trim(strip_tags(stripslashes(mysqli_real_escape_string($data))));
            return $data;
        }
    }

    public function ContainsNumbers($String) {
        if (preg_match("'^[a-zA-Z]+$'", $String)) {
            return True;
        } else {
            return False;
        }
    }

    public function alphaNumeric($string) {
        if (preg_match("'^[a-zA-Z0-9]+$'", $string)) {
            return True;
        } else {
            return False;
        }
    }

}

?>