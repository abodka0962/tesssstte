<?php
// تحديد مسار الملف الذي يحتوي على بيانات المبيعات
$file = 'data/sales.json';

// التأكد من أن الملف موجود
if (!file_exists($file)) {
    file_put_contents($file, json_encode([])); // إنشاء الملف في حال عدم وجوده
}

// الحصول على البيانات المدخلة من النموذج
$customerName = $_POST['customerName'] ?? '';
$product = $_POST['product'] ?? '';
$saleDate = $_POST['saleDate'] ?? '';
$amount = $_POST['amount'] ?? '';
$paymentMethod = $_POST['paymentMethod'] ?? '';

// التحقق من صحة البيانات المدخلة
if (empty($customerName) || empty($product) || empty($saleDate) || empty($amount) || empty($paymentMethod)) {
    die('يرجى تعبئة جميع الحقول.');
}

// قراءة البيانات الموجودة في الملف
$data = json_decode(file_get_contents($file), true);

// إضافة البيع الجديد إلى البيانات
$newSale = [
    'customerName' => $customerName,
    'product' => $product,
    'saleDate' => $saleDate,
    'amount' => $amount,
    'paymentMethod' => $paymentMethod,
    'createdAt' => date('Y-m-d H:i:s')
];

// إضافة البيع الجديد إلى البيانات
$data[] = $newSale;

// حفظ البيانات المحدثة في الملف
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

// إعادة التوجيه إلى صفحة المبيعات أو عرض رسالة تأكيد
header('Location: sales.html');
exit();
?>
