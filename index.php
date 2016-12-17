<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="//code.jquery.com/jquery.min.js"></script>
    <title>
        Một triệu đô
    </title>
    <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link href="//cdn.shopify.com/s/files/1/0691/5403/t/123/assets/style.scss.css?13701263572696252361" rel="stylesheet" type="text/css"  media="all"  />
    <link rel="stylesheet" type="text/css" href="notifications.css">
    <script src="notifications.js"></script>
    <script type="text/javascript">
        function notifications(msg,color='#a4c400'){
            $.smallBox({
                title: "Thông Báo",
                content: msg,
                color:color,
                timeout: 4000
            })
        }
    </script>


</head>
<body id="dashboard" class="background-dark template-product" >
<div class="container">
    <div class="row text-centered">
        <div class="col-md-12 text-center">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Created By Team KTBQ</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="account">* Nhập thông tin account :</label>
                        <textarea style='height: 200px;' id="account" placeholder="account1|password1&#10;account2|password2" class="form-control"></textarea>
                    </div>
                    <div class="form-group"><label for="app_id">* Chọn Ứng Dụng :</label>
                        <select id="app_id" class="form-control">
                            <option value="6628568379">Facebook For Iphone</option>
                            <option value="350685531728">Facebook For Android</option>
                            <option value="165907476854626">PAGES MANAGER FOR IOS</option>
                        </select>
                    </div>

                    <div class="form-group text-center">
                        <button id="submit" class="btn btn-sm btn-primary">Lấy Token</button>
                    </div>
                    <div class='total-wrapper' style="padding-bottom: 5px;"> Số tài khoản đã xử lý : <strong class="total">0/0</strong> </div>
                    <div class="form-group text-center" id="load_result" style="display:none">
                        <label for="result">Các ACCESS TOKEN của bạn là :</label>
                        <textarea readonly style='height: auto; min-height: 200px;' id="result"  class="form-control" rows="2"></textarea>
                    </div>
                </div>
            </div>
            <script>
                i=1;
                startnum = 0
                $(document).ready(function(e) {
                    $('button#submit').on('click',function(){
                        $('#load_result').css('display','block');
                        $('button#submit').prop('disabled',true);
                        $('button#submit').text('Đang lấy token cho anh em...');
                        _account = $('textarea#account').val().trim();
                        _app_token = $('#app_id').val().trim();
                        if(_account == ""){
                            notifications("Bạn chưa nhập tài khoản.");
                            $('button#submit').text('Get token lỗi');
                        }else{
                            _account_array = _account.split(/\n/);
                            $(".total").text('0/'+_account_array.length);
                            ajax();
                            function ajax(){
                                var _account = _account_array[startnum];
                                if(_account){
                                    gettoken(_account);
                                    setTimeout(function() {
                                        startnum++;
                                        ajax();
                                    }, 10 * 1000);
                                }
                            }
                            function gettoken(_account){
                                var _x86 = _account.split('|');
                                var _x64 = "|";
                                if (!_x86[0] || !_x86[1]){
                                    notifications('Hãy nhập đúng cú pháp là username|password');
                                    $('button#submit').text('Get token lỗi');
                                    var htmls = $('#result').text();
                                    htmls = htmls+'Hãy nhập đúng cú pháp là username|password'+"\n";
                                    $('#result').text(htmls);
                                }
                                $.post('/full.php', {
                                    app_id : _app_token,
                                    email : _x86[0],
                                    password : _x86[1]
                                },function(graph){
                                    //alert(graph);
                                    data=JSON.parse(graph);
                                    if(data.error_msg){
                                        $('button#submit').text('Get token lỗi');
                                        var htmls = $('#result').text();
                                        htmls = htmls  + data.error_msg  +_account + "\n";
                                        $('#result').text(htmls);
                                        notifications(data.error_msg);
                                    }
                                    if (data.access_token){
                                        notifications('Get token thành công!');
                                        var htmls = $('#result').text();
                                        htmls = htmls+ data.access_token + _x64 + _account  +"\n";
                                        $('#result').text(htmls);
                                        //$.post('kiemtra_token.php', {token : graph.access_token});
                                        if (startnum + 1 == _account_array.length){
                                            $('button#submit').text('Đã get xong token');
                                        }
                                    }
                                });
                                $(".total").text((startnum+1)+'/'+_account_array.length);
                            }
                        }
                    });
                });

            </script>
        </div>
    </div>
</div>
</body>
</html>
<?
