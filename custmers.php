<?php
$dataDir = 'data';
$customers = [];

// Check if directory exists and handle errors
if (is_dir($dataDir)) {
    $files = glob($dataDir . '/customer_*.json');
    foreach ($files as $file) {
        $json = @file_get_contents($file); // Suppress errors and handle them manually
        if ($json === false) {
            error_log("Error reading file: $file");
            continue;
        }
        $data = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE) { // Check for JSON parsing errors
            $customers[] = $data;
        } else {
            error_log("Invalid JSON in file: $file");
        }
    }
} else {
    error_log("Directory $dataDir does not exist.");
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>قائمة العملاء - تيجان للخياطة</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Tajawal', sans-serif;
      background-color: #f0f0f0;
      padding: 30px;
    }
    h1 {
      color: #0A2463;
      text-align: center;
      margin-bottom: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    th, td {
      padding: 15px;
      border-bottom: 1px solid #eee;
      text-align: right;
    }
    th {
      background-color: #0A2463;
      color: white;
    }
    tr:hover {
      background-color: #f1f1f1;
    }
    .btn {
      background-color: #0A2463;
      color: white;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 5px;
      display: inline-block;
      margin-top: 20px;
    }
  </style>
</head>
<body>

  <h1><i class="fas fa-users"></i> قائمة العملاء</h1>

  <?php if (count($customers) > 0): ?>
    <table>
      <thead>
        <tr>
          <th>الاسم</th>
          <th>رقم الجوال</th>
          <th>العنوان</th>
          <th>تاريخ الإضافة</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($customers as $cust): ?>
          <tr>
            <td><?= htmlspecialchars($cust['name'] ?? 'غير معروف') ?></td>
            <td><?= htmlspecialchars($cust['phone'] ?? 'غير معروف') ?></td>
            <td><?= htmlspecialchars($cust['address'] ?? 'غير معروف') ?></td>
            <td><?= htmlspecialchars($cust['created_at'] ?? 'غير معروف') ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p style="text-align:center;">لا يوجد عملاء مسجلين بعد.</p>
  <?php endif; ?>

  <div style="text-align:center;">
    <a class="btn" href="add-customer.html"><i class="fas fa-user-plus"></i> إضافة عميل جديد</a>
  </div>

</body>
</html>
