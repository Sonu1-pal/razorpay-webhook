<?php
// Razorpay Webhook: Sends Email + SMS after payment captured

// Read Razorpay webhook POST body
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Razorpay Secret (for validation - optional)
$webhook_secret = "abcd@1234"; // You can set this in Razorpay dashboard

// Proceed only if payment is captured
if (isset($data["event"]) && $data["event"] === "payment.captured") {
    $payment = $data["payload"]["payment"]["entity"];
    $email = $payment["email"];
    $contact = $payment["contact"];

    // --- Send Email ---
    $to = $email;
    $subject = "धन्यवाद! आपकी सेवा एक्टिव हो गई है।";
    $message = "हमसे कॉल करने के लिए कृपया इस नंबर पर संपर्क करें: 9935090880\n\nSonu Electrical and Plumbing Service";
    $headers = "From: sonujiautomatiintechnology@gmail.com";

    mail($to, $subject, $message, $headers);

    // --- Send SMS using Fast2SMS ---
    $apiKey = "YOUR_FAST2SMS_API_KEY"; // Replace with your Fast2SMS API key
    $senderId = "FSTSMS";
    $smsMessage = urlencode("धन्यवाद! आपकी सेवा एक्टिव हो गई है। कॉल करें: 9935090880");
    $route = "q"; // transaction route
    $number = $contact;

    $url = "https://www.fast2sms.com/dev/bulkV2?authorization=$apiKey&sender_id=$senderId&message=$smsMessage&language=unicode&route=$route&numbers=$number";

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    curl_close($curl);
}
?>
