<?php
header('Content-Type: application/json');
// Allow submissions from your development/live domain
header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// 1. Define the Recipient and Subject
$to = 'dng200411@gmail.com';
$subject = 'New Demo Request from Consultheon Website';

// 2. Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 3. Collect and Sanitize Data
    $company = filter_input(INPUT_POST, 'Company Name', FILTER_SANITIZE_STRING);
    $field = filter_input(INPUT_POST, 'Field of Work', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'Location', FILTER_SANITIZE_STRING);
    $time = filter_input(INPUT_POST, 'Time for Demo', FILTER_SANITIZE_STRING);
    
    // 4. Build the Email Content
    $email_content = "Website Demo Request Details:\n\n";
    $email_content .= "Company Name: $company\n";
    $email_content .= "Field of Work: $field\n";
    $email_content .= "Location: $location\n";
    $email_content .= "Preferred Time: $time\n";
    
    // 5. Set Headers (Important for deliverability)
    $email_headers = "From: Website Contact <noreply@yourdomain.com>\r\n";
    $email_headers .= "Reply-To: noreply@yourdomain.com\r\n";
    
    // 6. Send the Email using PHP's built-in mail() function
    if (mail($to, $subject, $email_content, $email_headers)) {
        // Success response for JavaScript
        http_response_code(200);
        echo json_encode(['success' => true, 'message' => 'Email sent successfully.']);
    } else {
        // Error response
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Mail function failed.']);
    }
    
} else {
    // If not a POST request, send an error
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed.']);
}
?>