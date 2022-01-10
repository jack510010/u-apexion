<?php require __DIR__ . "/__connect_db.php";
$title = '周邊商品';
$pageName = 'product';
?>
<?php require __DIR__ . "/__html_head.php"; ?>
<div class="d-flex">
  <?php require __DIR__ . "/__navbar.php"; ?>
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light pt-3 shadow ">
      <div class="container-fluid"><i class="fas fa-laptop-house text-warning"></i>
        <a class="navbar text-warning" href="product.php" style="text-decoration:none;">所有商品</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                女生
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">外套</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">T恤</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">帽子</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                男生
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="#">外套</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">T恤</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">帽子</a></li>
              </ul>
            </li>
          </ul>
          <button type="button" class="btn btn-info"><a class="text-dark" href="product_new.php" style="text-decoration:none;">新增商品</a></button>
          <form class="d-flex align-items-center ms-2">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-warning" type="submit">Search</button>
          </form>
        </div>
      </div>
    </nav>
    <!-- 下方新增表單列表 -->
    <div class="d-flex">
      <form class="container pt-5 mx-2" name="productForm" onsubmit="sendData(); return false;">
        <div class="form-row text-light">
          <div class="mb-3">
            <label for="product_name">商品名稱</label>
            <input type="text" class="product-wrap form-control" id="product_name" name="product_name" placeholder="名稱" required>
            <div class="text-warning"></div>
          </div>
          <div class=" mb-3">
            <label for="category">產品分類</label>
            <select class="custom-select d-block w-100 form-control" id="category" name="category" required="">
              <option value="">
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">選擇...</font>
                </font>
              </option>
              <option>
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">女生</font>
                </font>
              </option>
              <option>
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">男生</font>
                </font>
              </option>
              <option>
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">孩童</font>
                </font>
              </option>
              <option>
                <font style="vertical-align: inherit;">
                  <font style="vertical-align: inherit;">配件</font>
                </font>
              </option>
            </select>
          </div>
          <div class=" mb-3">
            <label for="img">產品照片</label>
            <div class="input-group">
              <input accept="image/*" type='file' id="imgInp" class="form-control" name="img" placeholder="照片" aria-describedby="inputGroupPrepend2">
            </div>
          </div>
          <div class=" mb-3">
            <label for="quantity">庫存數量</label>
            <div class="input-group">
              <input type="number" class="form-control" id="quantity" name="quantity" placeholder="請填入數字" aria-describedby="inputGroupPrepend2">
            </div>
          </div>
          <div class=" mb-3">
            <label for="price">價格</label>
            <div class="input-group">
              <input type="number" class="form-control" id="price" name="price" placeholder="請填入數字" aria-describedby="inputGroupPrepend2">
            </div>
          </div>
        </div>
        <div class="d-flex">
          <div class="m-1">
            <label class="text-light">尺寸</label>
            <select class="mb-3" id="size" name="size">
              <option value="F">F</option>
              <option value="S">S</option>
              <option value="M">M</option>
              <option value="L">L</option>
              <option value="其他">其他</option>
            </select>
          </div>
          <div class="m-1">
            <label class="text-light">顏色</label>
            <select class="mb-3" id="size" name="style">
              <option value="黑色">黑色</option>
              <option value="白色">白色</option>
              <option value="藍色">藍色</option>
            </select>
          </div>
        </div>

        <button class="btn btn-outline-info" type="submit">資料送出</button>

      </form>
      <div class="pt-4 mx-2">
        <img class="img-fluid " id="product_blah" width="75" height="75">
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . "/__scripts.php"; ?>
<script>
  const product_name = document.querySelector('#product_name');
  const quantity = document.querySelector('#quantity');


  function sendData() {
    product_name.nextElementSibling.innerHTML = '';

    let isPass = true;
    //檢查表單資料
    if (product_name.value.length < 2) {
      isPass = false;
      product_name.nextElementSibling.innerHTML = "請輸入正確商品名稱";
    }

    if (quantity.value.length < 0) {
      isPass = false;
      product_name.nextElementSibling.innerHTML = "請輸入庫存數量";
    }

    //拿取輸入的資料
    const fd = new FormData(document.productForm);

    fetch('product_new_api.php', {
        method: 'POST',
        body: fd,
      }).then(r => r.json())
      .then(obj => {
        console.log(obj);
        if (obj.success) {
          alert('新增成功');
          //新增完跳回商品頁
          location.href = 'product.php';
        } else {
          alert(obj.error || '資料新增發生錯誤');
        }
      })
  }
  //圖片預覽
  const imgInp = document.querySelector('#imgInp');
  imgInp.onchange = evt => {
    const [file] = imgInp.files
    if (file) {
      product_blah.src = URL.createObjectURL(file)
    }
  }
</script>

<?php require __DIR__ . "/__html_foot.php"; ?>