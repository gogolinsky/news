function generateHtmlTree(node)
{
    // Выводим листы
    if (node.children === undefined) {
        return '<li><a class="js-link" href="' + node.url + '">' + node.label + '</a></li>';
    }

    var result = '';

    // Пропускаем корневую ноду
    if (node.depth > 0) {
        result += '<li><a class="js-link" href="' + node.url + '">' + node.label + '</a>';
    }

    // Выводим потомков
    result += '<ul>';
    node.children.forEach(function(item) {
        result += generateHtmlTree(item);
    });
    result += '</ul>';

    // Пропускаем корневую ноду
    if (node.depth > 0) {
        result += '</li>';
    }

    return result;
}

function initCatalog()
{
    $.get('/catalog/tree', {}, function(tree) {
        var htmlTree = generateHtmlTree(tree);
        $('.js-catalog').removeClass('is-loading').append(htmlTree);
    });
}

function setList(url)
{
    $.get(url, {}, function(news) {
        if (news.length === 0) {
            $('.js-content').html('');
            return;
        }

        var html = '';

        news.forEach(function(item) {
            html += '<h2>' + item.title + '</h2>';
            html += '<div class="content">' + item.text + '</div>';

            if (item.categories !== undefined) {
                html += '<p class="categories">';
                item.categories.forEach(function(category) {
                    html += '<span class="label label-default mr-5">' + category + '</span>';
                });
                html += '</p>';
            }

            $('.js-content').html(html);
        }, news);
    });
}

function initList()
{
    setList('/catalog');
}

$(function()
{
    initCatalog();
    initList();

    $(document).on('click', '.js-link', function() {
        setList($(this).attr('href'));

        return false;
    });
});