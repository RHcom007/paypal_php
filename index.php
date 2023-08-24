<?php
include __DIR__ . '/payment/database.php';
$item = new db;
if (isset($_POST['item_id'])) {
    require_once 'payment/index.php';

    $pay = new Payment;
    $hitam = $item->readItem($_POST['item_id']);
    $hitam = $hitam[0];
    $pay->createInvoice('123', $hitam['nama'], $hitam['harga']);
} else {
    $itemarray = $item->readItem();
}
?>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Kharismatik World</title>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        body {
            margin: 0;
            font-family: Roboto, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: .8125rem;
            font-weight: 400;
            line-height: 1.5385;
            color: #333;
            text-align: left;
            background-color: #f5f5f5;
        }

        .mt-50 {
            margin-top: 50px;
        }

        .mb-50 {
            margin-bottom: 50px;
        }


        .bg-teal-400 {
            background-color: #26a69a;
        }

        a {
            text-decoration: none !important;
        }


        .fa {
            color: red;
        }
    </style>
</head>

<body className='snippet-body'>
    <div class="container d-flex justify-content-center mt-50 mb-50">

        <div class="row">
            <div class="col-md-10">

                <?php
                foreach ($itemarray as $data) :
                ?>
                    <div class="card card-body mt-3">
                        <div class="media align-items-center align-items-lg-start text-center text-lg-left flex-column flex-lg-row">
                            <div class="mr-2 mb-3 mb-lg-0">

                                <img src="<?php echo $data['url_gambar'] ?>" width="150" height="150" alt="">

                            </div>

                            <div class="media-body">
                                <h6 class="media-title font-weight-semibold">
                                    <a href="#" data-abc="true"><?php echo $data['nama'] ?></a>
                                </h6>

                                <ul class="list-inline list-inline-dotted mb-3 mb-lg-2">
                                    <?php
                                    $category = explode('|', $data['categori']);
                                    foreach ($category as $kategori) :
                                    ?>
                                        <li class="list-inline-item"><a href="#" class="text-muted" data-abc="true"><?php echo $kategori ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>

                                <p class="mb-3"><?php echo $data['deskripsi'] ?></p>
                            </div>

                            <div class="mt-3 mt-lg-0 ml-lg-3 text-center">
                                <h3 class="mb-0 font-weight-semibold">Rp <?php echo $data['harga'] ?></h3>

                                <div>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>

                                </div>

                                <div class="text-muted">1985 reviews</div>

                                <form action="." method="post">
                                    <input type="hidden" name="item_id" value="<?php echo $data['id'] ?>">
                                    <button type="submit" class="btn btn-success mt-4 text-white"><i class="text-white fa fa-shopping-cart mr-2"></i> Beli</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
                ?>


            </div>
        </div>
    </div>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>
    <script type='text/javascript' src='#'></script>
    <script type='text/javascript' src='#'></script>
    <script type='text/javascript' src='#'></script>
    <!-- <script type='text/javascript'>#</script> -->
    <script type='text/javascript'>
        var myLink = document.querySelector('a[href="#"]');
        myLink.addEventListener('click', function(e) {
            e.preventDefault();
        });
    </script>

</body>

</html>