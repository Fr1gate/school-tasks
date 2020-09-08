<?php
//      Основная проблема  - это сохранение разметки статьи. Если просто отрезать 200 символов, то можно оказаться
//  внутри тега. Например <a href="in
//      Есть два пути, по которым можно пойти:
//  1) Взять статью и удалить из нее все html теги с помощью функции strip_tags()
//  2) Обрезать по последнему пробелу, убедившись, что пробел не находится внутри тега. Закрыть все открытые теги.
//      Для того чтобы закрыть теги существует библиотека Tidy. Можно это попытаться сделать самостоятельно с помощью
//  регулярного выражения. Но HTML позволяет свободно использовать любое количество пробелов и аттрибутов внутри тегов и выражение
//  получается огромным. 
//  В статье может быть меньше трех слов.
//  В последних трех словах может быть тег, тогда получится <a> qwer <b> qwer qwer </a> что невалидно и будет иправлено браузером



//      Находимся ли мы внутри тега? Если да, то режем его
function trimUnfinishedTag($str) 
{
    $lastLeftBracketPos = 0;
    $lastRightBracketPos = 0;
    
    for ($i = strlen($str) - 1; $i >= 0; $i--) { 
        if ($str[$i] == '<') { 
            $lastLeftBracketPos = $i;
            break;
        }
    }

    for ($i = strlen($str) - 1; $i >= 0; $i--) { 
        if ($str[$i] == '>') {
            $lastRightBracketPos = $i;
            break;
        }
    }

    if ($lastLeftBracketPos > $lastRightBracketPos) {
        $str = substr_replace($str, '', $lastLeftBracketPos); // обрезаем до конца строки
    } 

    return $str;
}

//  Добавляем многоточие и ссылку в статью
function addLink($str, $link) 
{
    $str = trimUnfinishedTag($str); // убираем незаконченный тег, если он есть
    $str = trim($str);  //  обрезаем пробелы
    $count = 0;
    for ($i = strlen($str) - 1; $i >= 0; $i--) { 

        if ($str[$i] == ' ' || $str[$i] == '\n') {
            $count++;
            
            if ($count === 3) { //  нашли пробел перед третьим словом с конца
                $str = substr_replace($str, "<a href=\"{$link}\">" , $i, 0);
                break;
            }
        }

        if ($i == 0) { //   дошли до первого символа и не насчитали три пробела
            //Вставляем ссылку просто в начало
            $str = substr_replace($str, "<a href=\"{$link}\">" , $i, 0);
        }
    }

    $str .= "...</a>";
    
    return $str;
}

$articleLink = "./article.html";

// В данном примере 200й символ находится внутри тега ссылки. И между последними тремя словами есть закрывающий тег
$articleText = "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.<b> Quisque tincidunt elit non vehicula imperdiet.</b> <i>Ut urna urna, pretium sed <b>tincidunt sed, auctor eget ex.</b> Donec eleifend, <a href=\"#\"> orci gravida placerat </a> tristique, mi ante placerat lorem, vitae aliquam magna magna nec mauris. Nam vel dictum ante. Cras porta nunc vel miporttitor tincidunt. Maecenas pretium metus id bibendum molestie. Phasellus molestie enim ut gravida porttitor.Suspendisse consequat facilisis aliquet.</i> Maecenas tristique, diam ut mollis vulputate, eros nisl ullamcorperneque, ac volutpat nibh enim sed orci. Vivamus in consectetur arcu. Lorem ipsum dolor sit amet, consecteturadipiscing elit. Suspendisse laoreet metus mi, eu tempus diam convallis ut. Nam fermentum pellentesque justoeget tincidunt.</p>";

$articlePreview = substr($articleText, 0, 199); // отрезали 200 символов
$articlePreview = addLink($articlePreview, "article.html");
$articlePreview = tidy_repair_string($articlePreview, array(
    'output-xml' => true,       // XML так как не хотим, чтобы нам сгенерировало полноценный документ с <title> и прочим
    'input-xml' => true
));

echo $articlePreview;