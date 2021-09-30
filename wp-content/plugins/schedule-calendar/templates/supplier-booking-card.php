<?php
?>
<div class="card p-3 m-auto col-md-6 shadow">
	<div class="card-body text-center my-1">
		<h2 class="card-title my-1">予約詳細</h2>
	</div>
	<figure class="m-0 card-img-frame">
		<img src="<?php echo $atts["service_img"];?>" class="img-fluid card-img-style" alt="" style="height: 230px;" />
	</figure>
	<ul class="list-group list-group-flush mx-0 my-0">
		<li class="list-group-item mx-0"><b>サービス名　</b>
			<a href="<?php echo $atts["service_url"];?>"><?php echo $atts["service_title"];?></a>
		</li>
		<li class="list-group-item mx-0"><b>お客様名　　</b>
			<a href="<?php echo $atts["customer_url"];?>"><?php echo $atts["customer_name"];?></a>
		</li>
		<li class="list-group-item mx-0"><b>チャット　　</b>
			<a href="<?php echo $atts["chat_room_url"];?>">ここをクリック</a>
		</li>
		<li class="list-group-item mx-0"><b>予約状態　　</b><?php echo $atts["booking_status"];?></li>
		<li class="list-group-item mx-0"><b>予約年月日　</b><?php echo $atts["start_date"];?></li>
		<li class="list-group-item mx-0"><b>開始時間　　</b><?php echo $atts["start_time"];?></li>
		<li class="list-group-item mx-0"><b>終了時間　　</b><?php echo $atts["end_time"];?></li>
	</ul>
	<div class="card-body">
		<a href="https://source.oysterworld.jp/matching-app/?page_id=466">スケジュール一覧に戻る</a>
	</div>
</div>
