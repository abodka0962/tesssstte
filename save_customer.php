<?php
// عرض الأخطاء أثناء التطوير (يمكن تعطيله لاحقاً في الإنتاج)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// اسم مجلد حفظ البيانات
$dataDir = 'data';

// التأكد من وجود المجلد، إذا لم يكن موجوداً يتم إنشاؤه
if (!is_dir($dataDir)) {
    mkdir($dataDir, 0777, true);
}

// استلام البيانات من النموذج عبر POST
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';

// التحقق من إدخال الحقول الإلزامية
if ($name === '' || $phone === '') {
    die("الرجاء إدخال الاسم ورقم الجوال.");
}

// إعداد البيانات في مصفوفة
$customerData = [
    'name' => $name,
    'phone' => $phone,
    'address' => $address,
    'created_at' => date('Y-m-d H:i:s')
];

// إنشاء اسم ملف فريد باستخدام الوقت
$filename = $dataDir . '/customer_' . time() . '.json';

// حفظ البيانات داخل الملف بصيغة JSON
file_put_contents($filename, json_encode($customerData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

// إعادة التوجيه إلى صفحة العملاء بعد حفظ البيانات
header("Location: customers.php");
exit;
?>
