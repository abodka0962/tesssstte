<?php
// تحديد مسار الملف الذي يحتوي على البيانات
$file = 'data/orders.json';

// التأكد من أن الملف موجود
if (!file_exists($file)) {
    file_put_contents($file, json_encode([])); // إنشاء الملف في حال عدم وجوده
}

// الحصول على البيانات المدخلة من النموذج
$customerName = $_POST['customerName'] ?? '';
$phone = $_POST['phone'] ?? '';
$deliveryDate = $_POST['deliveryDate'] ?? '';
$orderDetails = $_POST['orderDetails'] ?? '';

// التحقق من صحة البيانات المدخلة
if (empty($customerName) || empty($phone) || empty($deliveryDate) || empty($orderDetails)) {
    die('يرجى تعبئة جميع الحقول.');
}

// قراءة البيانات الموجودة في الملف
$data = json_decode(file_get_contents($file), true);

// إضافة الطلب الجديد إلى البيانات
$newOrder = [
    'customerName' => $customerName,
    'phone' => $phone,
    'deliveryDate' => $deliveryDate,
    'orderDetails' => $orderDetails,
    'orderDate' => date('Y-m-d H:i:s')
];

// إضافة الطلب الجديد إلى البيانات
$data[] = $newOrder;

// حفظ البيانات المحدثة في الملف
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

// إعادة التوجيه إلى صفحة الطلبات أو عرض رسالة تأكيد
header('Location: orders.html');
exit();
?>
