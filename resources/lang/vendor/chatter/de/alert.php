<?php

return [
    'success' => [
        'title'  => 'Well done!',
        'reason' => [
            'submitted_to_post'       => 'Antwort erfolgreich zur '.mb_strtolower(trans('chatter::intro.titles.discussion')).' hinzugefügt.',
            'updated_post'            => 'Die ' .mb_strtolower(trans('chatter::intro.titles.discussion')).' wurde erfolgreich geändert.',
            'destroy_post'            => 'Antwort und '.mb_strtolower(trans('chatter::intro.titles.discussion')).' wurden erfolgreich gelöscht.',
            'destroy_from_discussion' => 'Antwort wurde erfolgreich von der '.mb_strtolower(trans('chatter::intro.titles.discussion')).' entfernt.',
            'created_discussion'      => 'Die '.mb_strtolower(trans('chatter::intro.titles.discussion')).' wurde erfolgreich erstellt.',
        ],
    ],
    'info' => [
        'title' => 'Info',
    ],
    'warning' => [
        'title' => 'Warnung',
    ],
    'danger'  => [
        'title'  => 'Achtung',
        'reason' => [
            'errors'            => 'Bitte beheben Sie die folgenden Fehler:',
            'prevent_spam'      => 'Um Spam zu verhindern müssen Sie mindestens :minutes Minuten warten bevor Sie weitere Inhalte veröffentlichen können.',
            'trouble'           => 'Beim Verarbeiten Ihrer Antwort ist ein fehler aufgetreten.',
            'update_post'       => 'Die Antwort wurde nicht verändert. Modifizierst du etwa das Formular?',
            'destroy_post'      => 'Die Antwort wurde nicht gelöscht. Modifizierst du etwa das Formular?',
            'create_discussion' => 'Bei der Erstellung Ihrer '.mb_strtolower(trans('chatter::intro.titles.discussion')).' scheint ein fehler aufgetreten zu sein.',
        	'title_required'    => 'Bitte gib einen Titel an. ',
        	'title_min'		    => 'Der Titel muss mindestens :min zeichen lang sein.',
        	'title_max'		    => 'Der Titel darf maximal :max zeichen lang sein.',
        	'content_required'  => 'Bitte gib einen Inhalt an.',
        	'content_min'  		=> 'The content has to have at least :min characters',
        	'category_required' => 'Please choose a category',
        ],
    ],
];
