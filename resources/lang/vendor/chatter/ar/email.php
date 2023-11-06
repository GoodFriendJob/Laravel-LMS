<?php

return [
    'preheader'       => 'أردت فقط أن أخبرك أن شخصًا ما قد استجاب لنشر منتدى.',
    'greeting'        => 'مرحبا،,',
    'body'            => 'أردت فقط أن أخبركم بأن شخصًا ما قد استجاب لنشر منتدى في '.mb_strtolower(trans('chatter::intro.titles.discussion')),
    'view_discussion' => 'عرض المناقشة. '.mb_strtolower(trans('chatter::intro.titles.discussion')),
    'farewell'        => 'أتمنى لك يوما عظيما!.',
    'unsuscribe'      => [
        'message' => 'إذا لم تعد ترغب في أن يتم إعلامك عندما يستجيب شخص ما لهذا المنشور ، فتأكد من إلغاء تحديد إعداد الإشعارات في أسفل الصفحة :)',
        'action'  => 'لا أحب هذه رسائل البريد الإلكتروني؟',
        'link'    => 'إلغاء الاشتراك في هذه المناقشة. '.mb_strtolower(trans('chatter::intro.titles.discussion')),
    ],
];
