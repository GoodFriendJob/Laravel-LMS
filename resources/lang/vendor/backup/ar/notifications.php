<?php

return [
    'exception_message' => 'رسالة استثناء: :message',
    'exception_trace' => 'تتبع الاستثناء: :trace',
    'exception_message_title' => 'رسالة استثناء',
    'exception_trace_title' => 'تتبع استثناء',

    'backup_failed_subject' => 'فشل النسخ الاحتياطي من application_name:',
    'backup_failed_body' => 'Important: حدث خطأ أثناء النسخ الاحتياطي :application_name',

    'backup_successful_subject' => 'نسخة احتياطية جديدة ناجحة من :application_name',
    'backup_successful_subject_title' => 'نسخة احتياطية جديدة ناجحة!',
    'backup_successful_body' => 'خبر رائع ، تم إنشاء نسخة احتياطية جديدة من application_name: بنجاح على القرص المسمى disk_name:.',

    'cleanup_failed_subject' => 'فشل تنظيف النسخ الاحتياطية لـ :application_name.',
    'cleanup_failed_body' => 'حدث خطأ أثناء تنظيف النسخ الاحتياطية لـ :application_name',

    'cleanup_successful_subject' => 'تنظيف: النسخ الاحتياطية :application_name ناجحة',
    'cleanup_successful_subject_title' => 'تنظيف النسخ الاحتياطية الناجحة!',
    'cleanup_successful_body' => 'تم تنظيف النسخ الاحتياطية لـ :application_name على القرص المسمى :disk_name.',

    'healthy_backup_found_subject' => 'النسخ الاحتياطية لـ :application_name على القرص :disk_name سليمة',
    'healthy_backup_found_subject_title' => 'النسخ الاحتياطية لـ :application_name صحية',
    'healthy_backup_found_body' => 'تعتبر النسخ الاحتياطية لـ :application_name صحية. عمل جيد!',

    'unhealthy_backup_found_subject' => 'هام: النسخ الاحتياطية لـ :application_name غير صحية',
    'unhealthy_backup_found_subject_title' => 'Important: النسخ الاحتياطية لـ :application_name غير صحية. : problem',
    'unhealthy_backup_found_body' => 'النسخ الاحتياطية لـ :application_name على القرص :disk_name غير صحية.',
    'unhealthy_backup_found_not_reachable' => 'لا يمكن الوصول إلى وجهة النسخ الاحتياطي. :error',
    'unhealthy_backup_found_empty' => 'لا توجد نسخ احتياطية لهذا التطبيق على الإطلاق.',
    'unhealthy_backup_found_old' => 'أحدث نسخة احتياطية صنعت في :date تعتبر قديمة جدًا.',
    'unhealthy_backup_found_unknown' => 'آسف ، لا يمكن تحديد السبب الدقيق.',
    'unhealthy_backup_found_full' => 'النسخ الاحتياطية تستخدم الكثير من التخزين. الاستخدام الحالي هو :disk_usage وهو أعلى من الحد المسموح به وهو :disk_limit.',
];
