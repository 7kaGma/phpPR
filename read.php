<?php
ini_set( 'display_errors', 1 );

/*==========
データの取得と構造化
==========*/
$file = fopen("./data.txt","r");
$i=1;
$getData=[];
$association=[];

while(!feof($file)){
  $text=fgets($file);
  // "/n"によりデータファイルの末端がブランクになるので追加した処理
  // 先に行を読み込ませた上で再度feofの判定をさせて、自身が最終行であれば処理を中断する
  if(!feof($file)){
    $array=explode(",",$text);
  // １回の送信のデータを連想配列化
    $association=[];
    $k =["time","name","age","gender","expext","thoughts"];
    for($a=0;$a<=count($array)-1;$a++){
      $association=array_merge($association,array($k[$a]=>$array[$a]));
    }
  // 全てのデータを連想配列化
    $key = "data".$i;
    $getData =array_merge($getData,array($key=>$association));
    $i+=1;
  }
}

/*==========
データのJSON化
==========*/
$json=json_encode($getData,JSON_UNESCAPED_UNICODE);
// エスケープシークエンスで指定する
$jsonRe =str_replace("\\n","",$json);
?>

<!-- HTMLの記述 -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>アンケート</title>
  <style>
    table{
      border: solid 1px lightgray;
      text-align: center;
    }
    table th{
      border: solid 1px lightgray;
    }
    table td{
      border: solid 1px lightgray;
    }
  </style>
</head>
<body>
<p>年齢比</p>
<p>男女比</p>
<p>作品期待度</p>
<p>回答一覧</p>
<div>
  <table id="table">
    <tr id="first">
      <th>id</th>
    </tr>
  </table>
</div>

<!-- JSの記述 -->
<script>
const data = JSON.parse('<?php echo $jsonRe; ?>');
console.dir(data);

function table(){
  const place =document.getElementById("table");
  firstRowMake();
  Rowmake(place);
}

function firstRowMake(){
  const firstTr=document.getElementById("first");
  for(m=0;m<=Object.keys(data.data1).length-1;m++){
    const thTag=document.createElement("th");
    thTag.textContent=Object.keys(data['data1'])[m];
    firstTr.appendChild(thTag);
  }
}

function Rowmake(place){
  for(i=0;i<=Object.keys(data).length-1;i++){

    const trTag=document.createElement("tr");
    const thTag=document.createElement("th");
    thTag.textContent = Object.keys(data)[i];
    trTag.appendChild(thTag);

    for(m=0;m<=Object.keys(data.data1).length-1;m++){
      const tdTag = document.createElement("td"); 
      tdTag.textContent=Object.values(data[`data${i+1}`])[m];
      trTag.appendChild(tdTag);
    } 
    place.appendChild(trTag);
  }
}

/*=========
実行関数
==========*/
table();

</script> 
</body>
</html>
