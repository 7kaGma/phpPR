<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>アンケート</title>
  <style>
    div {
      margin-block: 20px;
      display: flex;
      justify-content: flex-start;
      align-items: center;
      gap: 10px;
    }

    button {
      margin-block: 30px;
    }

    .textarea {
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: flex-start;
    }

    img {
      display: block;
      margin-block: 10px 30px;
    }
  </style>
</head>

<body>
  <h2>アニメのPVに関する調査</h2>
  <form action="./write.php" method="post">
    <div><label for="name">1.名前:</label><input type="text" id="name" name="name"></div>
    <div><label for="age">2.年齢:</label>
      <select name="age" id="age"></select>
    </div>
    <div>
      <label for="gender">3.性別:</label>
      <input type="radio" value="男性" name="gender">男性
      <input type="radio" value="女性" name="gender">女性
    </div>

    <div>
      <label for="expectation">4.下記リンクよりアニメのPVを視聴いただき、作品の期待度を5段階評価で教えてください:</label>
      <select name="expectation" id="expectation"></select>
    </div>
    <a href="https://youtu.be/BieXc0yy76I?si=8O9uWTlNBgm2-bv_">該当動画の視聴はこちらから</a>

    <div class="textarea">
      <label for="thoughts">5.このPVを観て想像したアニメのストーリーを教えてください</label>
      <textarea name="thoughts"  id="thoughts"></textarea>
    </div>

    <button type="submit">送信する</button>
  </form>
  <a href="./read.php">集計結果表示</a>

  <script>
    for (i = 1; i <= 6; i++) {
      const option = document.createElement('option');
      if(i===6){
      option.textContent = `${i}0代以上`;
    }else{
      option.textContent = `${i}0代`;
    }
      option.setAttribute("value", `${i}0代`);
      document.getElementById('age').appendChild(option);
    }
    for (i = 1; i <= 5; i++) {
      const option = document.createElement('option');
      option.textContent = i;
      option.setAttribute("value", i);
      document.getElementById('expectation').appendChild(option);
    }
  </script>
</body>

</html>