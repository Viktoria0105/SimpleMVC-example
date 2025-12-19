<?php

return [
    // Правило для корневого маршрута (ГЛАВНАЯ СТРАНИЦА)
    // Ключ: паттерн URL '/' 
    // Значение: строка 'ИмяКонтроллера/имяМетода'
    '/' => 'HomeController/index', 

    // Правило для страницы архива
    // Ключ: паттерн URL 'archive' 
    // Значение: строка 'ArchiveController/indexAction'
    'Archive' => 'ArchiveController/indexAction',

    // Правило для страницы просмотра статьи
    // Ключ: паттерн URL 'viewArticle' 
    // Значение: строка 'ViewArticleController/indexAction'
    'viewArticle' => 'ViewArticleController/indexAction'
];