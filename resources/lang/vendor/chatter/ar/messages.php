<?php

return [
    'words' => [
        'cancel'  => 'إلغاء',
        'delete'  => 'حذف',
        'edit'    => 'تصحيح',
        'yes'     => 'نعم فعلا',
        'no'      => 'لا',
        'minutes' => '1 دقيقة | :count دقيقة',
    ],

    'discussion' => [
        'new'          => 'مناقشة جديدة '.mb_strtolower(trans('chatter::intro.titles.discussion')),
        'all'          => 'كل مناقشة '.mb_strtolower(trans('chatter::intro.titles.discussions')),
        'create'       => 'إنشاء مناقشة '.mb_strtolower(trans('chatter::intro.titles.discussion')),
        'posted_by'    => 'منشور من طرف',
        'head_details' => 'نشر في الفئة',

    ],
    'response' => [
        'confirm'     => 'هل أنت متأكد أنك تريد حذف هذا الرد؟',
        'yes_confirm' => 'نعم احذفها',
        'no_confirm'  => 'لا شكرا',
        'submit'      => 'إرسال الرد',
        'update'      => 'تحديث الرد',
    ],

    'editor' => [
        'title'               => 'عنوان المناقشة'.mb_strtolower(trans('chatter::intro.titles.discussion')),
        'select'              => 'اختر تصنيف',
        'tinymce_placeholder' => 'اكتب محادثتك هنا ... '.mb_strtolower(trans('chatter::intro.titles.discussion')),
        'select_color_text'   => 'اختر لونًا لهذه المناقشة (اختياري) '.mb_strtolower(trans('chatter::intro.titles.discussion')),
    ],

    'email' => [
        'notify' => 'أعلمني عندما يرد شخص ما '.mb_strtolower(trans('chatter::intro.titles.discussion')),
    ],

    'auth' => 'يرجى <a href="/:home/login"> تسجيل الدخول </a>
                أو <a href="/:home/register"> التسجيل </a>
                لترك الرد.',

];
