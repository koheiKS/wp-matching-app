<?php
?>
<div class="card mb-3 col-12 mx-auto px-0 shadow">
	<div class="row no-gutters">
		<div class="col-md-4 col-12">
			<figure class="m-0 card-img-frame">
			<img src="<?php echo $atts["service_img"];?>" class="img-fluid card-img-style" alt="" style="height: 250px; width:100%;"/>
			</figure>
		</div>
		<div class="col-md-8 col-12 px-0 py-0">
			<ul class="list-group mx-0 my-0 px-0">
				<li class="list-group-item mx-0"><b>サービス名　</b>
					<a href="<?php echo $atts["service_url"];?>"><?php echo $atts["service_title"];?></a>
				</li>
				<li class="list-group-item mx-0"><b>チャット　　</b><a href="<?php echo $atts["chat_room_url"];?>">ここをクリック</a></li>
				<li class="list-group-item mx-0"><b>予約年月日　</b><?php echo $atts["date"];?></li>
				<li class="list-group-item mx-0"><b>開始時間　　</b><?php echo $atts["start_time"];?></li>
				<li class="list-group-item mx-0"><b>終了時間　　</b><?php echo $atts["end_time"];?></li>
			</ul>
			<div class="text-right my-1 mr-3">
				<button type="button" class="btn btn-danger" onclick="cancel_booking(<?php echo $atts["booking_id"];?>)">キャンセルする</button>
			</div>
		</div>
	</div>
</div>
