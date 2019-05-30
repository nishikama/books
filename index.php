<?php

// セッション変数を使うことを宣言する
session_start();
session_regenerate_id(true);

// もしセッション変数に定義がある場合は、入力した内容をセットする
$bookname = $_SESSION['bookname'] ?? '';
$bookurl = $_SESSION['bookurl'] ?? '';
$bookcomment = $_SESSION['bookcomment'] ?? '';

// サニタイズする
$bookname = htmlspecialchars($bookname, ENT_QUOTES);
$bookurl = htmlspecialchars($bookurl, ENT_QUOTES);
$bookcomment = htmlspecialchars($bookcomment, ENT_QUOTES);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>書籍検索</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="col text-center">書籍検索</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="bookKeywords">キーワード：</label>
                                <div class="col-sm-10">
                                    <input type="text" id="bookKeywords" name="bookKeywords" value="<?php echo $bookKeywords; ?>" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-2">
                                    <input type="submit" id="submit" value="送信" class="btn btn-primary">
                                </div>
                            </div>
                        </form>
                        <div id="results"></div>
                        <div id="pager"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        let  page = 1;
        $(() => {

            // こうやれば、リロードしてもアラートが出ない？かも？
            $('#submit').on('click', (e) => {
                e.preventDefault();
                $.ajax({
                    url: './getBookdata.php',
                    type: 'GET',
                    data: {
                        "bookKeywords": $('#bookKeywords').val(),
                        "page": page
                    },
                    dataType: 'JSON'
                }).done((data, textStatus, jqXHR) => {
                    let $table = $('<table class="table">');
                    $table.append('<tr><th>書籍名</th><th>著者名</th><th>出版社名</th><th>出版日</th></tr>');
                    $.each(data.items, (i, item) => {
                        let authors = item.volumeInfo.authors;
                        $table.append(`<tr><td>${item.volumeInfo.title ? item.volumeInfo.title : ''}</td><td>${item.volumeInfo.authors ? item.volumeInfo.authors : ''}</td><td>${item.volumeInfo.publisher ? item.volumeInfo.publisher : ''}</td><td>${item.volumeInfo.publishedDate ? item.volumeInfo.publishedDate : ''}</td></tr>`);
                    });
                    $('#results').html($table);

                    if (page > 1) {
                        $('#pager').append('<a id="prev" href="javascript:void(0);">前へ</a>');
                    } 
                    if (page < data.totalItems) {
                        $('#pager').append('<a id="next" href="javascript:void(0);">次へ</a>');
                    }
                });
            });

            $('#prev').on('click', (e) => {
                e.preventDefault();
                page--;
                $('#submit').trigger('click');
            });

            $('#next').on('click', (e) => {
                e.preventDefault();
                page++;
                $('#submit').trigger('click');
            });
        });
    </script>
</body>

</html>