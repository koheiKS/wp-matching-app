<?php
/*
Plugin Name: Schedule Calendar
Plugin URI: http://www.example.com/plugin/
Description: ログインしたユーザーがスケジュールを登録できる
Author: Shima
Author URI: http://www.example.com
Version: 1.0
*/
?>
<?php

require_once(dirname(__FILE__). '/service/ScModelService.php');
require_once(dirname(__FILE__). '/controller/ScheduleController.php');
require_once(dirname(__FILE__). '/controller/BookingController.php');
require_once(dirname(__FILE__). '/controller/CoretimeAndWeekController.php');

add_action('init', 'ScheduleCalendar::init');

class ScheduleCalendar {

	static function init() {
		return new self();
	}

	const VERSION               = '1.0';
	const PLUGIN_ID             = 'schedule-calendar';
	const NEW_ACTION            = self::PLUGIN_ID . '-new-nonce-action';
	const NEW_NAME              = self::PLUGIN_ID . '-new-nonce-key';
	const NEW_DEFAULT_ACTION    = self::PLUGIN_ID . '-new-default-nonce-action';
	const NEW_DEFAULT_NAME      = self::PLUGIN_ID . '-new-default-nonce-key';
	const NEW_BOOKING_ACTION    = self::PLUGIN_ID . '-new-booking-nonce-action';
	const NEW_BOOKING_NAME      = self::PLUGIN_ID . '-new-booking-nonce-key';
	const CANCEL_BOOKING_ACTION = self::PLUGIN_ID . '-cxl-booking-nonce-action';
	const CANCEL_BOOKING_NAME   = self::PLUGIN_ID . '-cxl-booking-nonce-key';

	private $model;
	private $schedule_controller;
	private $booking_controller;
	private $coretime_controller;

	function __construct() {
		$this->model = new ScModelService();
		$this->schedule_controller = new ScheduleController();
		$this->booking_controller  = new BookingController();
		$this->coretime_controller = new CoretimeAndWeekController();

		add_action('wp_enqueue_scripts', [$this, 'sc_load_scripts']);
		add_action('template_redirect', [$this->schedule_controller, 'create_schedule']);
		add_action('template_redirect', [$this, 'create_default_schedule']);
		add_action('template_redirect', [$this, 'create_booking']);
		add_action('template_redirect', [$this, 'cancel_booking']);
		add_shortcode('sc-new-schedule', [$this->schedule_controller, 'sc_new_schedule']);
		add_shortcode('sc-new-default-schedule', [$this, 'sc_new_default_schedule']);
		add_shortcode('sc-show-schedule', [$this, 'sc_show_schedule']);
		add_shortcode('sc-show-agenda-week', [$this, 'sc_show_agenda_week']);
		add_shortcode('sc-new-booking', [$this, 'sc_new_booking']);
		add_shortcode('sc-show-customer-booking', [$this, 'sc_show_customer_booking']);
		add_shortcode('sc-show-supplier-schedule', [$this, 'sc_show_supplier_schedule']);
	}

	// カレンダーに必要なjs、cssタグを入れる
	function sc_load_scripts() {
		wp_enqueue_style('full_calendar_main_css', plugins_url('/full_calendar/lib/main.css', __FILE__));
		wp_enqueue_script('full_calendar_main_js', plugins_url('/full_calendar/lib/main.js', __FILE__));
		wp_enqueue_script('schedule_calendar_scripts', plugins_url( '/js/schedule_calendar.js', __FILE__ ));
		wp_enqueue_script('agenda_week_scripts', plugins_url('/js/agenda_week.js', __FILE__));
	}

	function sc_new_default_schedule() {
		$file        = dirname(__FILE__). "/templates/coretime-form.php";
		$user_id     = get_current_user_id();
		$nonce_field = wp_nonce_field(self::NEW_DEFAULT_ACTION, self::NEW_DEFAULT_NAME);
		$atts        = array("user_id" => $user_id, "nonce_field" => $nonce_field);
		$this->model->display_template($file, $atts);
	}

	function sc_show_schedule($atts) {
		extract(shortcode_atts(array(
			'user_id' => 0,
		), $atts));
		$events_data = $this->get_user_schedule($user_id);
		$events = array();
		$event_keys = ["title", "url", "start", "end", "start_time", "end_time"];
		for($i = 0; $i < count($events_data); $i++) {
			$title = $this->calc_status($events_data[$i]['status']);
			$url = $this->get_url($user_id, $events_data[$i]['status']);
			$event_values = array(
				$title,
				$url,
				$events_data[$i]['start_date'],
				$events_data[$i]['end_date'],
				$events_data[$i]['start_time'],
				$events_data[$i]['end_time']
			);
			$event = array_combine($event_keys, $event_values);
			array_push($events, $event);
		}
		$events = json_encode($events, JSON_UNESCAPED_UNICODE);
		$core_time = json_encode($this->get_user_coretime($user_id), JSON_UNESCAPED_UNICODE);
		$core_week = json_encode($this->get_coreweek_values($user_id), JSON_UNESCAPED_UNICODE);

		$customer_id = get_current_user_id();
		$service_id = get_the_ID();
		$need_time = get_field('time');
		$new_booking = $this->sc_new_booking($customer_id, $service_id);
		$is_loggedin = is_user_logged_in();
		return <<< HTML
$new_booking
<div id="calendar" data-events=$events data-needtime=$need_time data-coretime=$core_time data-coreweek=$core_week data-is_loggedin=$is_loggedin></div>
HTML;
	}

	function sc_show_agenda_week($atts) {
		$html = <<<HTML
<div class="card p-3 m-auto">
	<div id="agenda_week_calendar"></div>
</div>
HTML;
		return $html;
	}

	function sc_new_booking($customer_id, $service_id) {
		$file        = dirname(__FILE__). "/templates/booking-modal.php";
		$nonce_field = wp_nonce_field(self::NEW_BOOKING_ACTION, self::NEW_BOOKING_NAME);
                $atts        = array("customer_id" => $customer_id, "service_id" => $service_id, "nonce_field" => $nonce_field);
                $this->model->display_template($file, $atts);
	}

	function sc_show_customer_booking($atts) {
		extract(shortcode_atts(array(
                        'user_id' => 0,
		), $atts));
		$nonce_field = wp_nonce_field(self::CANCEL_BOOKING_ACTION, self::CANCEL_BOOKING_NAME);
		$html = <<< SCRIPT
<script>
function cancel_booking(booking_id) {
	var is_canceled = window.confirm('キャンセルしても宜しいですか？');
	if(is_canceled) {
		let f       = document.createElement('form');
		f.method    = 'post';
		f.action    = '';
		f.innerHTML = '$nonce_field';
		f.innerHTML += '<input name="booking_id" value=' + booking_id + ' />';
		document.body.append(f);
		f.submit();
	}
}
</script>
SCRIPT;
		$bookings = $this->get_customer_booking($user_id);
		foreach($bookings as $booking) {
			$file = dirname(__FILE__). "/templates/customer-booking-card.php";
			$atts = array(
				"booking_id"    => $booking['booking_id'],
				"service_title" => $booking['service_title'],
				"service_url"   => $booking['service_url'],
				"service_img"   => $booking['service_img'],
				"chat_room_url" => $this->get_chat_room_url($booking['booking_id']),
				"date"          => $booking['date'],
				"start_time"    => $booking['start_time'],
				"end_time"      => $booking['end_time']
			);
			$this->model->display_template($file, $atts);
		}
	}

	function sc_show_supplier_schedule($atts) {
		extract(shortcode_atts(array(
                        'user_id' => 0,
		), $atts));
		$events = $this->get_supplier_schedule($user_id);
		$events = json_encode($events, JSON_UNESCAPED_UNICODE);
		$coretime = $this->get_user_coretime($user_id);
		$coretime = json_encode($coretime, JSON_UNESCAPED_UNICODE);
		if (isset($_GET['booking_id'])) {
			$booking_id = $_GET['booking_id'];
			return $this->sc_show_supplier_booking($booking_id);
		}
		return <<< HTML
<div class="card p-3 m-auto">
	<div id="agenda_week_calendar" data-events=$events data-coretime=$coretime></div>
</div>
HTML;
	}

	function sc_show_supplier_booking($booking_id) {
		$booking = $this->get_booking_detail($booking_id);
		$file    = dirname(__FILE__). "/templates/supplier-booking-card.php";
		$atts    = array(
			"service_title"   => $booking['service_title'],
			"service_img"     => $booking['service_img'],
			"service_url"     => $booking['service_url'],
			"start_date"      => $booking['start_date'],
			"start_time"      => $booking['start_time'],
			"end_time"        => $booking['end_time'],
			"customer_name"   => $booking['customer_name'],
			"chat_room_url"   => $this->get_chat_room_url($booking_id),
			"customer_avatar" => $booking['customer_avatar'],
			"customer_url"    => $booking['customer_url'],
			"booking_status"  => $booking['is_canceled'] == '0' ? '受注中' : 'キャンセル'
		);
		$this->model->display_template($file, $atts);
	}

	/* DBからデータ取得(SELECT文)、リポジトリ */
	// user_idより
	function get_user_schedule($user_id) {
		global $wpdb;
		$table = $wpdb->prefix . 'sc_user_schedule';
		$data = $wpdb->get_results("SELECT * FROM ". $table . " WHERE user_id=" . $user_id, ARRAY_A);
		return $data;
	}

	function get_user_coretime($user_id) {
		global $wpdb;
		$table = $wpdb->prefix . 'sc_user_coretime';
		$data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE user_id=" . $user_id, ARRAY_A);
		$data = isset($data[0]) ? $data[0] : null;
		return $data;
	}

	function get_user_coreweek($user_id) {
		global $wpdb;
		$table = $wpdb->prefix . 'sc_user_coreweek';
		$data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE user_id=" . $user_id, ARRAY_A);
		$data = isset($data[0]) ? $data[0] : null;
		return $data;
	}

	function get_user_display_name($user_id) {
		return get_userdata($user_id)->display_name;
	}

	function get_user_email($user_id) {
		return get_userdata($user_id)->user_email;
	}

	function get_user_nicename($user_id) {
		return get_userdata($user_id)->user_nicename;
	}

	function get_profile_url($user_id) {
		$nicename = $this->get_user_nicename($user_id);
		return 'https://source.oysterworld.jp/matching-app/?page_id=52&um_user=' . $nicename;
	}

	function get_customer_booking_data($user_id) {
		global $wpdb;
		$table = $wpdb->prefix . 'sc_booking';
		$data  = $wpdb->get_results("SELECT * FROM " .$table. " WHERE user_id=" .$user_id. " AND is_canceled=0", ARRAY_A);
		return $data;
	}

	// service_idより
        function get_service_needtime($service_id) {
                return get_post($service_id)->time;
        }

        function get_service_title($service_id) {
                return get_post($service_id)->post_title;
        }

        function get_service_url($service_id) {
                return get_permalink($service_id);
        }

        function get_service_img($service_id) {
                return wp_get_attachment_image_src(get_post($service_id)->pic, 'medium-large')[0];
        }

        function get_supplier_id($service_id) {
                return get_post($service_id)->post_author;
	}

	// booking_idより
	function get_booking_data($booking_id) {
		global $wpdb;
		$table = $wpdb->prefix . 'sc_booking';
		$data  = $wpdb->get_results("SELECT * FROM " .$table. " WHERE id=" .$booking_id, ARRAY_A);
		$data  = isset($data[0]) ? $data[0] : null;
                return $data;
	}

	/* ロジック、サービス */
	function calc_status($status_number) {
		$status = '';
		switch ($status_number) {
			case "0":
				$status = '予約不可';
				break;
			case "1":
                                $status = '予約済み';
                                break;
                        case "2":
                                $status = '予約可能';
                                break;
		}
		return $status;
	}

	function get_url($user_id, $status_number) {
		$url = '';
		if($status_number == '2') {
			$url = 'https://source.oysterworld.jp/matching-app/?p=371&?id=' . $user_id; 
		}
		return $url;
	}

	function get_supplier_schedule_url($booking_id) {
		if($booking_id == '0') {
			return '';
		}
		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$url .= '&booking_id=' . $booking_id;
		return $url;
	}

	function get_coreweek_values($user_id) {
		$data = $this->get_user_coreweek($user_id);
		if (is_null($data)) {
			return array_fill(0, 8, 0);
		}
		$data = array_slice(array_values($data), 1);
		$data_sun = $data[6];
		$data_hol = $data[7];
		$cw = array($data_sun);
		$cw = array_merge($cw, array_slice($data, 0, 6));
		array_push($cw, $data_hol);
		return $cw;
	}

	function get_customer_booking($user_id) {
		$bookings = array();
		$booking_keys = ["booking_id", "service_title", "service_img", "service_url", "date", "start_time", "end_time"];
		$datalist = $this->get_customer_booking_data($user_id);
		foreach($datalist as $data) {
			$booking_id     = $data['id'];
			$service_title  = $this->get_service_title($data['service_id']);
			$service_img    = $this->get_service_img($data['service_id']);
			$service_url    = $this->get_service_url($data['service_id']);
			$date           = $data['start_date'];
			$start_time     = $data['start_time'];
			$end_time       = $data['end_time'];
			$booking_values = array(
				$booking_id,
				$service_title,
				$service_img,
                                $service_url,
                                $date,
				$start_time,
				$end_time,
			);
                        $booking = array_combine($booking_keys, $booking_values);
                        array_push($bookings, $booking);
		}
		$this->sort_booking($bookings);
		return $bookings;
	}
	function sort_booking($bookings) {
		usort($bookings, 'compare_booking_datetime');
	}

	function compare_booking_datetime($a, $b) {
		$a_datetime = $this->calc_datetime_val($a['date'], $a['start_time']);
		$b_datetime = $this->calc_datetime_val($b['date'], $b['start_time']);
		if ($a_datetime === $b_datetime) {
			return 0;
		}
		return ($a_datetime < $b_datetime) ? -1 : 1;
	}

	function calc_datetime_val($date, $time) {
		$date_str     = str_replace('-', '', $date);
		$time_str     = str_replace(':', '', $time);
		$datetime_str = $date_str + $time_str;
		$datetime_val = (int) $datetime_str;
		return $datetime_val;
	}

	function get_supplier_schedule($user_id) {
		$datas     = $this->get_user_schedule($user_id);
		$event_keys = ['title', 'url', 'start', 'end'];
		$events = array();
		foreach($datas as $data) {
			$title        = $this->calc_status($data['status']);
			$url          = $this->get_supplier_schedule_url($data['booking_id']);
			$start        = $data['start_date'] .'T'. $data['start_time'];
			$end          = $data['end_date'] .'T'. $data['end_time'];
			$event_values = [$title, $url, $start, $end];
			$event = array_combine($event_keys, $event_values);
			array_push($events, $event);	
		}
		return $events;
	}

	function get_booking_detail($booking_id) {
		$data         = $this->get_booking_data($booking_id);
		$booking      = null;
		$booking_keys = [
			'service_title',
			'service_img',
			'service_url',
			'customer_name',
			'customer_avatar',
			'customer_url',
			'start_date',
			'start_time',
			'end_date',
			'end_time',
			'is_canceled'
		];
		if(isset($data)) {
			$service_title   = $this->get_service_title($data['service_id']);
			$service_img     = $this->get_service_img($data['service_id']);
			$service_url     = $this->get_service_url($data['service_id']);
			$customer_name   = $this->get_user_display_name($data['user_id']);
			$customer_avatar = get_avatar($data['user_id']);
			$customer_url    = $this->get_profile_url($data['user_id']);
			$start_date      = $data['start_date'];
			$start_time      = $data['start_time'];
			$end_date        = $data['end_date'];
			$end_time        = $data['end_time'];
			$is_canceled     = $data['is_canceled'];
			$booking_values  = [
				$service_title,
				$service_img,
				$service_url,
				$customer_name,
				$customer_avatar,
				$customer_url,
				$start_date,
				$start_time,
				$end_date,
				$end_time,
				$is_canceled
			];
			$booking         = array_combine($booking_keys, $booking_values);
		}
		return $booking;
	}

	function get_supplier_email($booking_id){
		$booking_data   = $this->get_booking_data($booking_id);
		$supplier_id    = $this->get_supplier_id($booking_data['service_id']);
		$supplier_email = $this->get_user_email($supplier_id);
		return $supplier_email;
        }

	function send_booking_mail($booking_id) {
		$booking_text = $this->get_booking_text($booking_id);
		$message      = <<< TEXT
以下のサービス予約がございましたので、ご報告致します。
ご確認宜しくお願い致します。
$booking_text
TEXT;
		$to_email = $this->get_supplier_email($booking_id);
		$subject  = 'サービス予約のご報告';
		wp_mail($to_email, $subject, $message);
	}

	function send_cancel_mail($booking_id) {
		$booking_text = $this->get_booking_text($booking_id); 
		$message      = <<< TEXT
以下のサービス予約がお客様のご希望でキャンセルされましたので、ご報告致します。
ご確認宜しくお願い致します。
$booking_text
TEXT;
		$to_email = $this->get_supplier_email($booking_id);
		$subject  = 'サービス予約キャンセルのご報告';
		wp_mail($to_email, $subject, $message);
	}

	function get_booking_text($booking_id) {
		$booking       = $this->get_booking_detail($booking_id);
                $service_title = $booking['service_title'];
                $customer_name = $booking['customer_name'];
                $start_date    = $booking['start_date'];
                $start_time    = $booking['start_time'];
                $end_time      = $booking['end_time'];
                return <<< TEXT
--------------------------------------------
サービス名：$service_title
お客様名　：$customer_name
予約年月日：$start_date
開始時間　：$start_time
終了時間　：$end_time
--------------------------------------------
TEXT;
	}

	function get_chat_room_url($booking_id) {
		$booking_data = $this->get_booking_data($booking_id);
		$supplier_id  = $this->get_supplier_id($booking_data['service_id']);
		$customer_id  = $booking_data['user_id'];
		$url          = "https://source.oysterworld.jp/matching-app/?page_id=414&supplier_id={$supplier_id}&customer_id={$customer_id}";
		return $url;
	}

	/* DB登録・更新、リポジトリ */
	function create_schedule() {
		global $wpdb;
		$table = $wpdb->prefix . 'sc_user_schedule';
		if(isset($_POST[self::NEW_NAME]) && $_POST[self::NEW_NAME]) {
			if(check_admin_referer(self::NEW_ACTION, self::NEW_NAME)) {
				$user_id = $_POST['user_id'];
				$start_date = $_POST['start_date'];
				$start_time = $_POST['start_time'];
				$end_date = $_POST['end_date'];
				$end_time = $_POST['end_time'];
				$status = $_POST['status'];
				$wpdb->insert(
					$table,
					array(
						'user_id'    => $user_id,
						'start_date' => $start_date,
						'start_time' => $start_time,
						'end_date'   => $end_date,
						'end_time'   => $end_time,
						'status'     => $status,
						'booking_id' => '0'
					)
				);
			}
		}
	}

	function create_booking_schedule($service_id, $booking_date, $start_time, $end_time, $booking_id) {
		global $wpdb;
		$user_id = $this->get_supplier_id($service_id);
		$table = $wpdb->prefix . 'sc_user_schedule';
		$wpdb->insert(
			$table,
			array(
				'user_id'    => $user_id,
                                'start_date' => $booking_date,
                                'start_time' => $start_time,
                                'end_date'   => $booking_date,
                                'end_time'   => $end_time,
				'status'     => '1',
				'booking_id' => $booking_id
			)
		);
	}

	function create_default_schedule() {
		global $wpdb;
		$table_core_time = $wpdb->prefix . 'sc_user_coretime';
		$table_core_week = $wpdb->prefix . 'sc_user_coreweek';
		if(isset($_POST[self::NEW_DEFAULT_NAME]) && $_POST[self::NEW_DEFAULT_NAME]) {
                        if(check_admin_referer(self::NEW_DEFAULT_ACTION, self::NEW_DEFAULT_NAME)) {
				$user_id                  = $_POST['user_id'];
				$count = $wpdb->get_results("SELECT COUNT(*) FROM ". $table_core_time . " WHERE user_id=" . $user_id, ARRAY_A)[0]['COUNT(*)'];
				$core_time_start          = $_POST['core_time_start'];
				$core_time_end            = $_POST['core_time_end'];
				$break_time_start         = $_POST['break_time_start'];
				$break_time_end           = $_POST['break_time_end'];
				$core_week = $_POST['core_week'];
				$core_week_mon = $core_week_tue = $core_week_wed = $core_week_tur = $core_week_fri = $core_week_sat = $core_week_sun = 0;
				for($i = 0; $i < count($core_week); $i++) {
					switch($core_week[$i]) {
						case '0':
							$core_week_mon = '1';
							break;
						case '1':
							$core_week_tue = '1';
							break;
						case '2':
							$core_week_wed = '1';
							break;
						case '3':
							$core_week_tur = '1';
							break;
						case '4':
							$core_week_fri = '1';
							break;
						case '5':
							$core_week_sat = '1';
							break;
						case '6':
							$core_week_sun = '1';
							break;
					}
				}
				$can_on_public_holiday = $_POST['cannot_on_public_holiday'] == '0' ? '1' : '0';
				if ($count == 0) {
					$wpdb->insert(
						$table_core_time,
						array(
							'user_id'          => $user_id,
							'start_time'       => $core_time_start,
							'end_time'         => $core_time_end,
							'start_break_time' => $break_time_start,
							'end_break_time'   => $break_time_end
						)
					);
					$wpdb->insert(
						$table_core_week,
						array(
							'user_id'               => $user_id,
							'can_on_monday'         => $core_week_mon,
							'can_on_tuesday'        => $core_week_tue,
							'can_on_wednesday'      => $core_week_wed,
							'can_on_tursday'        => $core_week_tur,
							'can_on_friday'         => $core_week_fri,
							'can_on_saturday'       => $core_week_sat,
							'can_on_sunday'         => $core_week_sun,
							'can_on_public_holiday' => $can_on_public_holiday
						)
					);
				} else {
					$wpdb->update(
						$table_core_time,
						array(
                                                	'start_time'       => $core_time_start,
                                                	'end_time'         => $core_time_end,
                                                	'start_break_time' => $break_time_start,
                                                	'end_break_time'   => $break_time_end
						),
						array('user_id' => $user_id)
					);
					$wpdb->update(
						$table_core_week,
						array(
                                                	'can_on_monday'         => $core_week_mon,
                                                	'can_on_tuesday'        => $core_week_tue,
                                                	'can_on_wednesday'      => $core_week_wed,
                                                	'can_on_tursday'        => $core_week_tur,
                                                	'can_on_friday'         => $core_week_fri,
                                                	'can_on_saturday'       => $core_week_sat,
							'can_on_sunday'         => $core_week_sun,
							'can_on_public_holiday' => $can_on_public_holiday
						),
						array('user_id' => $user_id)
					);
				}
				set_transient("ok-notices", ["コアタイムを登録しました。"], 10);
			}
		}
	}

	function create_booking() {
		global $wpdb;
                $table = $wpdb->prefix . 'sc_booking';
                if(isset($_POST[self::NEW_BOOKING_NAME]) && $_POST[self::NEW_BOOKING_NAME]) {
			if(check_admin_referer(self::NEW_BOOKING_ACTION, self::NEW_BOOKING_NAME)) {
                                $user_id     = $_POST['customer_id'];
                                $service_id  = $_POST['service_id'];
                                $start_date  = $_POST['booking_date'];
				$start_time  = $_POST['booking_time_start'];
				$end_date    = $_POST['booking_date'];
				$end_time    = $_POST['booking_time_end'];
				$is_canceled = '0';
				$is_accepted = '0';
                                $wpdb->insert(
                                        $table,
                                        array(
                                                'user_id'     => $user_id,
						'service_id'  => $service_id,
						'start_date'  => $start_date,
						'start_time'  => $start_time,
						'end_date'    => $end_date,
						'end_time'    => $end_time,
						'is_canceled' => $is_canceled,
						'is_accepted' => $is_accepted
                                        )
				);
				$booking_id = $wpdb->insert_id; 
				$this->create_booking_schedule($service_id, $start_date, $start_time, $end_time, $booking_id);
				$this->send_booking_mail($booking_id);
			}
                }
	}

	function cancel_booking() {
		global $wpdb;
		$table = $wpdb->prefix . 'sc_booking';
		if(isset($_POST[self::CANCEL_BOOKING_NAME]) && $_POST[self::CANCEL_BOOKING_NAME]) {
			if(check_admin_referer(self::CANCEL_BOOKING_ACTION, self::CANCEL_BOOKING_NAME)) {
				$booking_id = $_POST['booking_id'];
				$wpdb->update(
					$table,
					array(
						'is_canceled' => '1'
					),
					array('id' => $booking_id)
				);
				$this->send_cancel_mail($booking_id);

				$table_sc = $wpdb->prefix . 'sc_user_schedule';
				$wpdb->update(
					$table_sc,
					array(
						'status' => '2'
					),
					array('booking_id' => $booking_id)
				);
			}
		}
	}

	function ok_notices() {
?>
                <?php if ($messages = get_transient( 'ok-notices' ) ): ?>
                <div class="updated">
                        <ul>
                                <?php foreach( $messages as $message ): ?>
                                        <li><?php echo esc_html($message); ?></li>
                                <?php endforeach; ?>
                        </ul>
                </div>
                <?php endif; ?>
<?php
        }
}

/* プラグイン導入 */
register_activation_hook( __FILE__, 'schedule_calendar_activate' );
function schedule_calendar_activate() {
	global $wpdb;
	$table          = $wpdb->prefix . 'sc_user_schedule';
	$table_coretime = $wpdb->prefix . 'sc_user_coretime';
	$table_coreweek = $wpdb->prefix . 'sc_user_coreweek';
	$table_booking  = $wpdb->prefix . 'sc_booking';

	if($wpdb->get_var("SHOW TABLES LIKE '".$table."'") != $table) {
		create_table();
	}
	if($wpdb->get_var("SHOW TABLES LIKE '".$table_coretime."'") != $table_coretime) {
		create_coretime_table();
	}
  	if($wpdb->get_var("SHOW TABLES LIKE '".$table_coreweek."'") != $table_coreweek) {
    		create_coreweek_table();
  	}
  	if($wpdb->get_var("SHOW TABLES LIKE '".$table_booking."'") != $table_booking) {
    		create_booking_table();
  	}
}
function create_table() {
	global $wpdb;
	$data_db_version= '1.0';

	$table = $wpdb->prefix . 'sc_user_schedule';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE ".$table." (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`user_id` int(11),
	`start_date` date NOT NULL,
	`start_time` time NOT NULL,
	`end_date` date NOT NULL,
	`end_time` time NOT NULL,
	`status` char(1) NOT NULL,
	`booking_id` bigint(20) NOT NULL,
	PRIMARY KEY  (id),
	FOREIGN KEY  (user_id) REFERENCES wp_users(ID) ON DELETE CASCADE,
	CHECK (status IN ('0', '1', '2'))
	) ".$charset_collate.";";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'data_db_version', $data_db_version );
}

function create_coretime_table() {
  	global $wpdb;
	$data_db_version= '1.0';

	$table = $wpdb->prefix . 'sc_user_coretime';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE ".$table." (
	`user_id` bigint(20) UNSIGNED NOT NULL,
	`start_time` time NOT NULL,
	`end_time` time NOT NULL,
  	`start_break_time` time NOT NULL,
  	`end_break_time` time NOT NULL,
  	PRIMARY KEY  (user_id),
	FOREIGN KEY  (user_id) REFERENCES wp_users(ID) ON DELETE CASCADE,
	CHECK (start_time < end_time)
	) ".$charset_collate.";";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'data_db_version', $data_db_version );
}

function create_coreweek_table() {
  	global $wpdb;
  	$data_db_version= '1.0';

	$table = $wpdb->prefix . 'sc_user_coreweek';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE ".$table." (
	`user_id` bigint(20) UNSIGNED NOT NULL,
	`can_on_monday` bool,
	`can_on_tuesday` bool,
	`can_on_wednesday` bool,
	`can_on_tursday` bool,
	`can_on_friday` bool,
	`can_on_saturday` bool,
	`can_on_sunday` bool,
	`can_on_public_holiday` bool,
	PRIMARY KEY (user_id),
	FOREIGN KEY (user_id) REFERENCES wp_users(ID) ON DELETE CASCADE
	) ".$charset_collate.";";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'data_db_version', $data_db_version );
}

function create_booking_table() {
  	global $wpdb;
  	$data_db_version= '1.0';

	$table = $wpdb->prefix . 'sc_booking';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE ".$table." (
  	`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) UNSIGNED NOT NULL,
  	`service_id` bigint(20) UNSIGNED NOT NULL,
	`start_date` date NOT NULL,
	`start_time` time NOT NULL,
	`end_date` date NOT NULL,
	`end_time` time NOT NULL,
  	`is_canceled` bool,
  	`is_accepted` bool,
	PRIMARY KEY (id),
	FOREIGN KEY (user_id) REFERENCES wp_users(ID) ON DELETE CASCADE,
 	FOREIGN KEY (service_id) REFERENCES wp_posts(ID) ON DELETE CASCADE
	) ".$charset_collate.";";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'data_db_version', $data_db_version );
}

/* プラグインアンインストール　*/
register_uninstall_hook( __FILE__, 'schedule_calendar_uninstall' );
function schedule_calendar_uninstall() {
	drop_table();
}
function drop_table() {
	global $wpdb;
	$table_schedule = $wpdb->prefix . 'sc_user_schedule';
	$table_coretime = $wpdb->prefix . 'sc_user_coretime';
	$table_coreweek = $wpdb->prefix . 'sc_user_coreweek';
	$table_booking  = $wpdb->prefix . 'sc_booking';
	$wpdb->query("DROP TABLE IF EXISTS ".$table_name."");
	$wpdb->query("DROP TABLE IF EXISTS ".$table_coretime."");
	$wpdb->query("DROP TABLE IF EXISTS ".$table_coreweek."");
	$wpdb->query("DROP TABLE IF EXISTS ".$table_booking."");
	delete_option( 'data_db_version' );
}

?>
