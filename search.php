<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>書籍検索</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="col text-center">検索結果の表示</h3>
                    </div>
                    <div class="card-body">

                        <table class="table">
                            <tr>
                                <th>書籍名</th>
                                <th>著者名</th>
                                <th>出版社名</th>
                                <th>コメント</th>
                            </tr>
<?php
                    if (!empty($status)) {
                        while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
?>
                            <tr>
                                <td><?php echo htmlspecialchars($result['indate'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($result['bookname'], ENT_QUOTES); ?></td>
                                <td><?php echo htmlspecialchars($result['bookurl'], ENT_QUOTES); ?></td>
                                <td><?php echo nl2br(htmlspecialchars($result['bookcomment'], ENT_QUOTES)); ?></td>
                            </tr>
<?php
                        }
                    }    
?>
                        </table>
                    </div>
                    <div class="card-footer">
                        <p class="col text-center"><a href="./index.php">アンケートフォームへ戻る</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>