# JSON API для сайта объявлений

## Задание

https://docs.google.com/document/d/17x8kmLJVnhUAUVn7IlyumQevT-Twx3_jCNVBMBcw6QM/edit?usp=sharing

## Установка

- cклонировать репозиторий
- composer install
- php artisan migrate 

## Методы

### Получение объявления

<p>URL: api/adverts/get-advert/{id объявления}</p>
<p>Метод запроса: "GET"</p>
Параметры:

- fields (необязательный). Массив. Может содержать значения "description" (вернет описание) и "all_photos" (вернет ссылки на все изображения, первое из которых будет являться главным). 
Пример: api/adverts/get-advert/{id объявления}?fields[]=description&fields[]=all_photos 

### Получение списка объявлений

<p>Возвращает список объявлений и данные для пагинации.</p>
<p>Метод запроса: "GET"</p>

<p>URL: api/adverts/get-adverts</p>
Параметры:

- page (необязательный). Номер страницы. Например api/adverts/get-adverts?page=2
- sort (необязательный). Сортировка. Возможные значения "price" и "date".
- sort_direction (необязательный). Направление сортировки. Возможные значения "asc" и "desc". 

### Создание объявления

<p>URL: api/adverts/create</p>
<p>Метод запроса: "POST" / "GET" (GET сделан для упрощения демонстрации)</p>
Параметры:

- title (обязательный). Заголовок объявления.
- description (обязательный). Описание объявления.
- price (обязательный). Цена объявления.
- photos (обязательный). Массив. Первый элемент является главным фото объявления.
