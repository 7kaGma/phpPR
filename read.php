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
    $k =["time","name","age","gender","expect","thoughts"];
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
<p>男女比</p>
<canvas id="mychart"></canvas>
<p>作品期待度:<span id="avg"></span></p>
<p>回答一覧</p>
<div>
  <table id="table">
    <tr id="first">
      <th>id</th>
    </tr>
  </table>
</div>

<!-- JSの記述 -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
/*==========
jsonデータの受け取り
=========*/
const data = JSON.parse('<?php echo $jsonRe; ?>');
console.dir(data);

/*==========
表の作成
==========*/
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

/*==========
平均の算出
==========*/
function avg(){
  const place = document.getElementById("avg");
  let valAvg = average();
  place.textContent = valAvg;
}

function average(){
  let total =0;
  for(i=1;i<=Object.keys(data).length;i++){
    total+=parseInt(data[`data${i}`].expect,10);
  }
  let average =(Math.floor((total/Object.keys(data).length)*10)/10);
  return average;
}

/*==========
円グラフの作成
==========*/
let genderRate={
  male:0,
  female:0
}

function calc(){
  let genderArray=[];
  let counts={
    total:0,
    male:0,
    female:0
  };
  // 関数の実行
  pushGender(genderArray);
  countGender(genderArray,counts);
  // 割合の計算
  genderRate.male=Math.floor((counts.male/counts.total)*100);
  genderRate.female=Math.floor((counts.female/counts.total)*100);
  console.log(genderRate);
}

// 男性と女性の数を数える
// 引数で参照渡してその引数の値を更新させたいとき、オブジェクトなら更新が反映できる(あるいは戻り値を使う)
function countGender(genderArray,counts){
  counts.total = genderArray.length;
  counts.male = genderArray.filter((element)=>element==="男性").length;
  counts.female = genderArray.filter((element)=>element==="女性").length;
}

function pushGender(genderArray){
  Object.keys(data).forEach(key=>{
    const value = data[key].gender;
    genderArray.push(value);
  });
}

/*=========
実行関数
==========*/
table();
avg();
calc();

</script> 
</body>
</html>
