<?php

return [
    'success' => [
        'title'  => 'أحسنت!',
        'reason' => [
            'submitted_to_post'       => 'تم تقديم الرد بنجاح للمناقشة. '.mb_strtolower(trans('chatter::intro.titles.discussion')),
            'updated_post'            =>  trans('chatter::intro.titles.discussion').' تم تحديث المناقشة بنجاح.',
            'destroy_post'            => 'تم حذف الرد والمناقشة بنجاح. '.mb_strtolower(trans('chatter::intro.titles.discussion')),
            'destroy_from_discussion' => 'تم حذف الرد بنجاح من المناقشة. '.mb_strtolower(trans('chatter::intro.titles.discussion')),
            'created_discussion'      => 'تم إنشاء مناقشة جديدة بنجاح. '.mb_strtolower(trans('chatter::intro.titles.discussion')),
        ],
    ],
    'info' => [
        'title' => 'انتباه!',
    ],
    'warning' => [
        'title' => 'ووه أوه!',
    ],
    'danger'  => [
        'title'  => 'يا سناب!',
        'reason' => [
            'errors'            => 'يرجى تصحيح الأخطاء التالية:',
            'prevent_spam'      => 'لمنع البريد العشوائي ، يرجى السماح على الأقل :minutes بين إرسال المحتوى.',
            'trouble'           => 'عذرًا ، يبدو أنه كانت هناك مشكلة في إرسال ردك.',
            'update_post'       => 'آه آه آه ... لا يمكن تحديث ردكم. تأكد من أنك لا تفعل أي شيء شادي.',
            'destroy_post'      => 'آه آه آه ... لا يمكن حذف الرد. تأكد من أنك لا تفعل أي شيء شادي.',
            'create_discussion' => 'عفوًا :( يبدو أن هناك مشكلة في إنشاء مناقشتك. '.mb_strtolower(trans('chatter::intro.titles.discussion')).'. :(',
        	'title_required'    => 'يرجى كتابة العنوان',
        	'title_min'		    => 'يجب أن يكون العنوان على الأقل: أحرف :min.',
        	'title_max'		    => 'يجب ألا يزيد العنوان عن: أحرف :max.',
        	'content_required'  => 'يرجى كتابة بعض المحتوى',
        	'content_min'  		=> 'يجب أن يحتوي المحتوى على الأقل: أحرف :min',
        	'category_required' => 'يرجى اختيار فئة',
        	
        ],
    ],
];
