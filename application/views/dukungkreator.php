<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-_CFR2SVXSaEXWU_d"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <title>Dukung Kreator</title>
</head>

<body>
    <nav class="navbar navbar-light bg-dark">
        <h3 class="text-white">Dukung Kreator</h3>
    </nav>

    <form id="payment-form" method="post" action="<?= site_url() ?>/snap/finish">
        <input type="hidden" name="result_type" id="result-type" value=""></div>
        <input type="hidden" name="result_data" id="result-data" value=""></div>
        <div class="container mt-5  ">
            <label for="nama-kreator">Nama Kreator</label>
            <div class="form-group">
                <input type="text" name="nama-kreator" class="form-control" id="nama-kreator" value= '<?php echo urldecode($nama); ?>'>
            </div>
            <label for="jumlah">Jumlah Bayar</label>
            <div class="form-group">
                <input type="number" name="jumlah" class="form-control" id="jumlah-bayar"  value= '<?php echo $jumlah; ?>'>
            </div>
            <div class="form-group">
                <button class="btn btn-primary form-control" id="pay-button">Dukung Kreator</button>
            </div>
        </div>
    </form>

    <script type="text/javascript">
        $('#pay-button').click(function(event) {
            event.preventDefault();
            $(this).attr("disabled", "disabled");

            var nama = $("#nama-kreator").val();
            var jumlahBayar = $("#jumlah-bayar").val();

            $.ajax({
                type: 'POST',
                url: '<?= site_url() ?>/snap/token',
                data: {
                    nama: nama,
                    jumlahBayar: jumlahBayar
                },
                cache: false,

                success: function(data) {
                    //location = data;

                    console.log('token = ' + data);
                    

                    var resultType = document.getElementById('result-type');
                    var resultData = document.getElementById('result-data');

                    function changeResult(type, data) {
                        $("#result-type").val(type);
                        $("#result-data").val(JSON.stringify(data));
                        //resultType.innerHTML = type;
                        //resultData.innerHTML = JSON.stringify(data);
                    }

                    snap.pay(data, {

                        onSuccess: function(result) {
                            changeResult('success', result);
                            console.log(result.status_message);
                            console.log(result);
                            $("#payment-form").submit();
                        },
                        onPending: function(result) {
                            changeResult('pending', result);
                            console.log(result.status_message);
                            $("#payment-form").submit();
                        },
                        onError: function(result) {
                            changeResult('error', result);
                            console.log(result.status_message);
                            $("#payment-form").submit();
                        }
                    });
                }
            });
        });
    </script>


</body>

</html>