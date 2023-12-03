<?php

////   'store-success'                    => 'تم حفظ الوظيفة بنجاح.',
////    'store-failed'                     => 'حدث خطأ أثناء الحفظ, برجاء المحاولة مرة أخري.',
////    'update-success'                   => 'تم تحديث الوظيفة بنجاح.',
////    'update-failed'                    => 'حدث خطأ أثناء التحديث, برجاء المحاولة مرة أخري.',
////    'delete-success'                   => 'تم حذف الوظيفة بنجاح.',
////    'delete-failed'                    => 'حدث خطأ أثناء الحذف, برجاء التأكد ان الوظيفة غير مرتبطة بأي مستخدمبن و المحاولة مرة أخري.',
////    'given_modules_not_available'      => 'بعض الموديولات المعطاة غير متواجدة بالنظام, برجاء التأكد من الموديولات.',
////    'permissions_not_belong_to_module' => 'معرفات التصاريح لا تنتمي إلي الموديول المعطي.',
return [
    'create' => [
        'success' => 'تم تسجيل :module بنجاح.',
        'fail' => 'حدث خطأ أثناء التسجيل, برجاء المحاولة مرة أخري.'
    ],
    'update' => [
        'success' => 'تم تحديث :module بنجاح.',
        'fail' => 'حدث خطأ أثناء التحديث, برجاء المحاولة مرة أخري.',
    ],
    'delete' => [
        'success' => 'تم حذف :module بنجاح.',
        'fail' => 'حدث خطأ أثناء الحذف.',
    ],
    'archive' => [
        'success' => 'The :module archived successfully.',
        'fail' => 'Something went wrong when archive the :module.',
    ],
    'restore' => [
        'success' => 'The :module restored successfully.',
        'fail' => 'Something went wrong when restore the :module.',
    ],
    'send' => [
        'success' => 'The E-Mail sent successfully.',
        'fail' => 'Something went wrong when sending the E-Mail.',
    ],
    'exception' => [
        '400' => 'Something went wrong, please try again later.',
        '401' => 'Unauthenticated.',
        '404' => 'Document or file requested by the client was not found.',
        '403' => 'Access is denied.',
        '413' => 'Payload is too large.',
        '500' => 'Internal Server Error.',
    ],
    'support-email-title' => 'Contact request form for Green Tank',
];
