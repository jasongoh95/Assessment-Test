<?php
/**
 * Function To encode with openssl
 * @param - string - text
 * @param - string - key
 * @return - string - encoded text
 */
function opensslEncode($sData) {
    if (empty($sData))
        return $sData;

    $sPrivateKey = "Management@System";
	
    $iResult = urlencode(openssl_encrypt($sData,"AES-128-ECB",$sPrivateKey));

    return $iResult;
}

/**
 * Function To decode with openssl
 * @param - string - text
 * @param - string - key
 * @return - string - encoded text
 */
function opensslDecode($sData) {
    if (empty($sData))
        return $sData;

    $sPrivateKey = "Management@System";

    $iResult = openssl_decrypt(urldecode($sData), "AES-128-ECB",$sPrivateKey);

    return $iResult;
}
?>