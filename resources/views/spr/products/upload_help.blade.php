<h3>Загрузка товара из файла</h3>
<p>
    Файл должен быть формата Excel. Загрузка начинается со второй строки. Первая строка - шапка таблицы.
</p>
<p>
    Ниже список полей в шапке, которые будут обработаны при загрузке. Названия полей должны быть такими как указаны.
    Расположение полей произвольное.
</p>
<ol>
    <li><span class="bg-warning">article</span></li>
    <li><span class="bg-warning">brand</span></li>
    <li><span class="bg-warning">name_rus</span></li>
    <li><span class="bg-warning">name_eng</span></li>
    <li>weight</li>
    <li>coment</li>
    <li>url</li>
</ol>
<p>
    <span class="bg-warning">имя поля</span> - выделенные поля являются обязательными.
</p>
<p class="text-right">
    <a href="{{ url('templates/upload_products_tpl.xlsx') }}" class="btn btn-outline-primary btn-sm">Скачать шаблон...</a>
</p>

