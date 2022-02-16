<?php
#Dados para o Post
$dataPost = [
    'user_email' => 'vhmarini@gmail.com',
    'user_password' => 'Zokt322.'
];

$dataJson = json_encode($dataPost);


#Dados do header
$headers = array(
    "Content-Type: application/json",
    "authorization: eyJraWQiOiJYYXhiNW1nN1lRdGZ6UzlUc3Y5Z2NzWXBUT3QyVFlQV0lKVGFidTNZeldNPSIsImFsZyI6IlJTMjU2In0.eyJlbmRfZGF0ZSI6IjAzXC8wNlwvMjAyMSIsImNvbXBhbnlfdHlwZSI6ImluZHVzdHJ5Iiwic3ViIjoiNDE2M2NlNzctZDk3NS00N2FmLWJjNzQtNjdiMTk1NTI2NzNjIiwiaXNzIjoiaHR0cHM6XC9cL2NvZ25pdG8taWRwLnVzLWVhc3QtMS5hbWF6b25hd3MuY29tXC91cy1lYXN0LTFfa2xhZUJWMDJLIiwic2VjcmV0IjoiV0lDVlI2UlU1SFRSM0tXWCIsImNvZ25pdG86cm9sZXMiOlsiNjIwNDU3ZjMzYWMwMGMwMDBhYzk4MmZlX0FETUlOIl0sInRyYW5zYWN0aW9uX3Bhc3N3b3JkIjpudWxsLCJhdXRoX3RpbWUiOjE2NDQ1Mzc2ODYsImNvbXBhbnkiOiI2MjA0NTdmMzNhYzAwYzAwMGFjOTgyZmVfVEVDTk9HRVJBfCIsImV4cCI6MTY0NDU0MTI4NiwiaWF0IjoxNjQ0NTM3Njg2LCJlbWFpbCI6InZobWFyaW5pQGdtYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwidHJ1Y2twYWRfaWQiOiI2MjA0NTZlYWQ3NzU0YTc5ZjBjNjRkMTUiLCJwaG9uZV9udW1iZXJfdmVyaWZpZWQiOnRydWUsImNvZ25pdG86dXNlcm5hbWUiOiI0MTYzY2U3Ny1kOTc1LTQ3YWYtYmM3NC02N2IxOTU1MjY3M2MiLCJzZXJ2aWNlcyI6IiIsImF1ZCI6IjJmbG45NjMxbHJodDZxdjE3ZXBpMjVrdm5nIiwiZXZlbnRfaWQiOiIzNzE3ODI4Ni03M2M5LTQ0NTUtODVhYi02ODVkM2Y2MTVjYmIiLCJoYXNfdG9fdXBkYXRlIjoidHJ1ZSIsImRheXNfdG9fdXBkYXRlIjoiMCIsInRva2VuX3VzZSI6ImlkIiwiZmluYW5jaWFsX2hvbWUiOiJmYWxzZSIsIm5hbWUiOiJWSVRPUiBIVUdPIE5VTkVTIE1BUklOSSIsInBob25lX251bWJlciI6Iis1NTE4OTk3ODkxMjYxIiwiY3VzdG9tOmNwZiI6IjQwMzIyNDM0ODQwIiwic3RhdHVzIjpudWxsfQ.lc-IQpw4FX_3P0yaCasCqhF1OUtqSQCYARw3GieBv4jCqRasEcDGse6E2zMqu0JHPCPn1xDwxK4QbmTk13S_u4lqnpWvylxU9GWHS4tQBgOJ4bdiSEnnYRSr1jvz8jlwYjYes9kqrDAT0uGuDEHiVzC5eMBSfpefGOPo_S6pfFRQixJG-jASKHkN2rKj_PsliOPb-6h6m0vl8KG-VA6nfKYMNki56Yo1cyGUyvy82YdHDIGcMLQWWRKp8OqYR_m22tMiZVEpPHfup40rkkAxLnIKZSEnKdC2Anf1wFSs1MWey5v271fCiIV1BUnG7CNryMRuSZ6MqYL_G8GnU9zQeQ",
    "company: 620457f33ac00c000ac982fe"
 );
$curl = curl_init();

// Configura
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://ciot.api.staging.truckpay.io/login/external',    
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => 1,    
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POSTFIELDS => $dataJson
]);
// Envio e armazenamento da resposta
$response = curl_exec($curl);

// Fecha e limpa recursos

curl_getinfo($curl);
// curl_errno($curl);
curl_close($curl);
// print"<pre>";
print_r($response);
exit; 