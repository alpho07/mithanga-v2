<?php 
   $jsonData = file_get_contents('php://input');
   $fh = fopen('confirmation.txt', 'a');    
    fwrite($fh,$jsonData); // Write information to the file
    fclose($fh);
    
    

// Database connection details
$hostname = "localhost";
$username = "knwhkflt_water_services";
$password = "Water@Services2024!";
$database = "knwhkflt_water_services";


// Decode JSON data
$data = json_decode($jsonData, true);


try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password); 

    // Prepare the SQL INSERT statement
    $sqlInsert = "INSERT INTO mpesa_transactions (TransactionType, TransID, TransTime, TransAmount, BusinessShortCode, BillRefNumber, InvoiceNumber, OrgAccountBalance, ThirdPartyTransID, MSISDN, FirstName, MiddleName, LastName)
            VALUES (:TransactionType, :TransID, :TransTime, :TransAmount, :BusinessShortCode, :BillRefNumber, :InvoiceNumber, :OrgAccountBalance, :ThirdPartyTransID, :MSISDN, :FirstName, :MiddleName, :LastName)";

    // Prepare the SQL statement
    $stmtInsert = $pdo->prepare($sqlInsert);

    // Bind parameters and execute the INSERT statement
    $stmtInsert->bindParam(':TransactionType', $data['TransactionType']);
    $stmtInsert->bindParam(':TransID', $data['TransID']);
    $stmtInsert->bindParam(':TransTime', $data['TransTime']);
    $stmtInsert->bindParam(':TransAmount', $data['TransAmount']);
    $stmtInsert->bindParam(':BusinessShortCode', $data['BusinessShortCode']);
    $stmtInsert->bindParam(':BillRefNumber', $data['BillRefNumber']);
    $stmtInsert->bindParam(':InvoiceNumber', $data['InvoiceNumber']);
    $stmtInsert->bindParam(':OrgAccountBalance', $data['OrgAccountBalance']);
    $stmtInsert->bindParam(':ThirdPartyTransID', $data['ThirdPartyTransID']);
    $stmtInsert->bindParam(':MSISDN', $data['MSISDN']);
    $stmtInsert->bindParam(':FirstName', $data['FirstName']);
    $stmtInsert->bindParam(':MiddleName', $data['MiddleName']);
    $stmtInsert->bindParam(':LastName', $data['LastName']);
    
    $transid = $data['TransID'];
    $billref = $data['BillRefNumber'];
    
    // Execute the INSERT statement
    $stmtInsert->execute();

    // Check if the insert was successful
    if ($stmtInsert->rowCount() > 0) {
        // Insert was successful, now update the stray_status
        $sqlUpdate = "UPDATE mpesa_transactions t
              SET t.stray_status = CASE
                  WHEN EXISTS (SELECT 1 FROM clients c WHERE c.id = t.BillRefNumber) THEN 1
                  ELSE 0
              END
              WHERE t.BillRefNumber = :BillRefNumber AND t.TransID = :TransID";
        
        // Prepare the SQL update statement
        $stmtUpdate = $pdo->prepare($sqlUpdate);

        // Bind the BillRefNumber parameter
        $stmtUpdate->bindParam(':BillRefNumber', $data['BillRefNumber']);
        $stmtUpdate->bindParam(':TransID', $data['TransID']);

        // Execute the update statement
        $stmtUpdate->execute();
        
     

        // Insert additional data into Transactions table
        $client_id = $data['BillRefNumber'];
        $description = $data['BillRefNumber'] . "." . $data['TransID'];
        $date = date('Y-m-d H:i:s');
        $type = "credit";
        $amount = $data['TransAmount'];
        $reference = $data['TransID'];

        $sqlInsertAdditionalData = "INSERT INTO transactions (client_id, description, date, type, amount, reference)
                                    VALUES (:client_id, :description, :date, :type, :amount, :reference)";

        // Prepare the SQL INSERT statement for additional data
        $stmtInsertAdditionalData = $pdo->prepare($sqlInsertAdditionalData);

        // Bind parameters and execute the INSERT statement for additional data
        $stmtInsertAdditionalData->bindParam(':client_id', $client_id);
        $stmtInsertAdditionalData->bindParam(':description', $description);
        $stmtInsertAdditionalData->bindParam(':date', $date);
        $stmtInsertAdditionalData->bindParam(':type', $type);
        $stmtInsertAdditionalData->bindParam(':amount', $amount);
        $stmtInsertAdditionalData->bindParam(':reference', $reference);
        $stmtInsertAdditionalData->execute();
        
                   $param1 = $data['BillRefNumber'];
$param2 = $data['TransAmount'];

$url = "https://postview-estate.com/sms/{$param1}/{$param2}";

$response = file_get_contents($url);

if ($response === FALSE) {
    echo "Error: Failed to retrieve data from the URL.";
} else {
    echo $response;
}
        
        echo json_encode(['status'=>1,'msg'=>'success']);
    } else {
        echo "Data insertion failed!";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


