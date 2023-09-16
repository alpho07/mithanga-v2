<?php
// Database connection details
$hostname = "localhost";
$username = "knwhkflt_water_services";
$password = "Water@Services2024!";
$database = "knwhkflt_water_services";

// JSON data
$jsonData = '{
    "TransactionType": "Pay Bill",
    "TransID": "RI6035DTLE",
    "TransTime": "20230906181906",
    "TransAmount": "15500.00",
    "BusinessShortCode": "4085189",
    "BillRefNumber": "PVA012",
    "InvoiceNumber": "",
    "OrgAccountBalance": "85400.00",
    "ThirdPartyTransID": "",
    "MSISDN": "254729688801",
    "FirstName": "Samuel",
    "MiddleName": "ngugi",
    "LastName": "muturi"
}';

// Decode JSON data
$data = json_decode($jsonData, true);

try {
    // Create a PDO connection
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

    // Prepare the SQL INSERT statement
    $sql = "INSERT INTO Transactions (TransactionType, TransID, TransTime, TransAmount, BusinessShortCode, BillRefNumber, InvoiceNumber, OrgAccountBalance, ThirdPartyTransID, MSISDN, FirstName, MiddleName, LastName)
            VALUES (:TransactionType, :TransID, :TransTime, :TransAmount, :BusinessShortCode, :BillRefNumber, :InvoiceNumber, :OrgAccountBalance, :ThirdPartyTransID, :MSISDN, :FirstName, :MiddleName, :LastName)";

    // Prepare the SQL statement
    $stmt = $pdo->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bindParam(':TransactionType', $data['TransactionType']);
    $stmt->bindParam(':TransID', $data['TransID']);
    $stmt->bindParam(':TransTime', $data['TransTime']);
    $stmt->bindParam(':TransAmount', $data['TransAmount']);
    $stmt->bindParam(':BusinessShortCode', $data['BusinessShortCode']);
    $stmt->bindParam(':BillRefNumber', $data['BillRefNumber']);
    $stmt->bindParam(':InvoiceNumber', $data['InvoiceNumber']);
    $stmt->bindParam(':OrgAccountBalance', $data['OrgAccountBalance']);
    $stmt->bindParam(':ThirdPartyTransID', $data['ThirdPartyTransID']);
    $stmt->bindParam(':MSISDN', $data['MSISDN']);
    $stmt->bindParam(':FirstName', $data['FirstName']);
    $stmt->bindParam(':MiddleName', $data['MiddleName']);
    $stmt->bindParam(':LastName', $data['LastName']);
    
    // Execute the statement
    $stmt->execute();
    
    echo "Data inserted successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

