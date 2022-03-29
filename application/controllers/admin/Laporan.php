<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata("nama") == null) {
			redirect("admin/login");
		}
	}

	public function index()
	{
		$posyandu_id = $this->session->userdata("posyandu_id");

		$bayi = $this->db->get_where("bayi", ["posyandu_id" => $posyandu_id])->result_array();

		$data = array(
			'title' => "Data Bayi",
			'data' => $bayi
		);
		$this->load->view('laporan', $data);
	}

	public function getJumlahPerStatus($posyandu_id, $date, $status)
	{
		if ($status) {
			$bayi = $this->db->query(
				"SELECT * FROM pengukuran as p
				LEFT JOIN bayi as b
				ON p.bayi_id = b.id
				WHERE b.posyandu_id = $posyandu_id AND SUBSTRING(p.tanggal_ukur, 1, 7) = '$date' AND status_berat_badan = '$status'"
			)->result_array();
		} else {
			$bayi = $this->db->query(
				"SELECT * FROM pengukuran as p
				LEFT JOIN bayi as b
				ON p.bayi_id = b.id
				WHERE b.posyandu_id = $posyandu_id AND SUBSTRING(p.tanggal_ukur, 1, 7) = '$date'"
			)->result_array();
		}

		$p11 = [];
		$l11 = [];
		$p23 = [];
		$l23 = [];
		$p59 = [];
		$l59 = [];
		foreach ($bayi as $key) {
			$tanggal_ukur = new DateTime($key["tanggal_ukur"]);
			$tanggal_lahir = new DateTime($key["tanggal_lahir"]);
			$interval = $tanggal_lahir->diff($tanggal_ukur);

			$u = $interval->y*12+$interval->m;
			if ($u >= 0 && $u <= 11) {
				if ($key["jenis_kelamin"] == 'Perempuan') {
					$p11[] = $key;
				} else {
					$l11[] = $key;
				}
			} elseif ($u >= 12 && $u <= 23) {
				if ($key["jenis_kelamin"] == 'Perempuan') {
					$p23[] = $key;
				} else {
					$l23[] = $key;
				}
			} elseif ($u >= 24 && $u <= 59) {
				if ($key["jenis_kelamin"] == 'Perempuan') {
					$p59[] = $key;
				} else {
					$l59[] = $key;
				}
			}
		}

		$data = [
			"l11" => count($l11),
			"p11" => count($p11),
			"l23" => count($l23),
			"p23" => count($p23),
			"l59" => count($l59),
			"p59" => count($p59)
		];

		return $data;
	}

	public function getJumlah($posyandu_id)
	{
		$bayi = $this->db->query(
			"SELECT * FROM bayi WHERE posyandu_id = $posyandu_id"
		)->result_array();

		$p5 = [];
		$l5 = [];
		$p6 = [];
		$l6 = [];
		foreach ($bayi as $key) {
			$tanggal_ukur = new DateTime();
			$tanggal_lahir = new DateTime($key["tanggal_lahir"]);
			$interval = $tanggal_lahir->diff($tanggal_ukur);

			$u = $interval->y*12+$interval->m;
			if ($u >= 0 && $u <= 5) {
				if ($key["jenis_kelamin"] == 'Perempuan') {
					$p5[] = $key;
				} else {
					$l5[] = $key;
				}
			} elseif ($u == 6) {
				if ($key["jenis_kelamin"] == 'Perempuan') {
					$p6[] = $key;
				} else {
					$l6[] = $key;
				}
			}
		}

		$data = [
			"l5" => count($l5),
			"p5" => count($p5),
			"l6" => count($l6),
			"p6" => count($p6)
		];

		return $data;
	}

	public function getJumlahAsi($posyandu_id)
	{
		$bayi = $this->db->query(
			"SELECT * FROM pengukuran as p
			LEFT JOIN bayi as b
			ON p.bayi_id = b.id
			WHERE b.posyandu_id = $posyandu_id AND p.asi = 1"
		)->result_array();

		$p5 = [];
		$l5 = [];
		$p6 = [];
		$l6 = [];
		foreach ($bayi as $key) {
			$tanggal_ukur = new DateTime($key["tanggal_ukur"]);
			$tanggal_lahir = new DateTime($key["tanggal_lahir"]);
			$interval = $tanggal_lahir->diff($tanggal_ukur);

			$u = $interval->y*12+$interval->m;
			if ($u >= 0 && $u <= 5) {
				if ($key["jenis_kelamin"] == 'Perempuan') {
					$p5[] = $key;
				} else {
					$l5[] = $key;
				}
			} elseif ($u == 6) {
				if ($key["jenis_kelamin"] == 'Perempuan') {
					$p6[] = $key;
				} else {
					$l6[] = $key;
				}
			}
		}

		$data = [
			"l5" => count($l5),
			"p5" => count($p5),
			"l6" => count($l6),
			"p6" => count($p6)
		];

		return $data;
	}

	public function getJumlahImd($posyandu_id, $date)
	{
		$bayi = $this->db->query(
			"SELECT * FROM pengukuran as p
			LEFT JOIN bayi as b
			ON p.bayi_id = b.id
			WHERE b.posyandu_id = $posyandu_id AND p.imd = 1 AND SUBSTRING(tanggal_ukur, 1, 7) <= $date"
		)->result_array();

		$p = [];
		$l = [];
		foreach ($bayi as $key) {
			if ($key["jenis_kelamin"] == 'Perempuan') {
				$p[] = $key;
			} else {
				$l[] = $key;
			}
		}

		$data = [
			"l" => count($l),
			"p" => count($p)
		];

		return $data;
	}

	public function export(){

		$date = $this->input->post("date");

		$posyandu_id = $this->session->userdata("posyandu_id");
		
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
		$style_col = [
		  'font' => ['bold' => true], // Set font nya jadi bold
		  'alignment' => [
			'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];
		// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
		$style_row = [
		  'alignment' => [
			'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
		  ],
		  'borders' => [
			'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
			'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
			'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
			'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
		  ]
		];
        
		$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing();
        $drawing->setImageResource(imagecreatefrompng(base_url("assets/img/logo_puskesmas.png")));
        $drawing->setCoordinates('A1');
        $drawing->setWidthAndHeight(100, 100);
        $drawing->setRenderingFunction(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_JPEG);
        $drawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
        $drawing->setOffsetX(25);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
					
		$sheet->mergeCells('A1:B1');

		$sheet->setCellValue('C1', "Pemerintah Kabupaten Buleleng");
		$sheet->mergeCells('C1:P1');
		$sheet->getStyle('C1')->getFont()->setBold(true);

		$sheet->setCellValue('C2', "Dinas Kesehatan");
		$sheet->mergeCells('C2:P2');
		$sheet->getStyle('C2')->getFont()->setBold(true);

		$sheet->setCellValue('C3', "UPTD Puskesmas Puskesmas Gerokgak II");
		$sheet->mergeCells('C3:P3');
		$sheet->getStyle('C3')->getFont()->setBold(true);

		$sheet->setCellValue('A8', "LAPORAN HASIL KEGIATAN");
		$sheet->mergeCells('A8:P8');
		$sheet->getStyle('A8')->getFont()->setBold(true);

		$sheet->setCellValue('A10', "Dasar Penugasan");
		$sheet->mergeCells('A10:B10');
		$sheet->setCellValue('C10', ":");

		$sheet->setCellValue('A11', "Nama Pekerjaan");
		$sheet->mergeCells('A11:B11');
		$sheet->setCellValue('C11', ":");
		$sheet->setCellValue('D11', "Pelayan Posyandu");
		$sheet->mergeCells('D11:P11');

		$sheet->setCellValue('A12', "Kegiatan/Penyedia");
		$sheet->mergeCells('A12:B12');
		$sheet->setCellValue('C12', ":");
		$sheet->setCellValue('D12', "Bantuan Operasional Kesehatan Pusksesmas PUSKESMAS GEROKGAK II (DAK Non Fisik 2022)");
		$sheet->mergeCells('D12:P12');

		$sheet->setCellValue('A13', "Tanggal Pelaksanaan");
		$sheet->mergeCells('A13:B13');
		$sheet->setCellValue('C13', ":");
		$sheet->mergeCells('D13:P13');

		$sheet->setCellValue('A14', "Lokasi");
		$sheet->mergeCells('A14:B14');
		$sheet->setCellValue('C14', ":");
		$sheet->setCellValue('D14', "");
		$sheet->mergeCells('D14:P14');

		$sheet->setCellValue('A14', "Hasil Kunjungan");
		$sheet->mergeCells('A14:B14');
		$sheet->setCellValue('C14', ":");
		$sheet->mergeCells('D14:P14');

		// A. Kegiatan Penimbangan
		$sheet->setCellValue('A17', "A.");
		$sheet->getStyle('A17')->getFont()->setBold(true);
		$sheet->setCellValue('B17', "Kegiatan Penimbangan");
		$sheet->getStyle('B17')->getFont()->setBold(true);
		
		$sheet->setCellValue('J17', "0-11 Bulan");
		$sheet->mergeCells('J17:K17');

		$sheet->setCellValue('L17', "12-23 Bulan");
		$sheet->mergeCells('L17:M17');
		
		$sheet->setCellValue('N17', "24-59 Bulan");
		$sheet->mergeCells('N17:O17');

		$sheet->setCellValue('J18', "Lk");
		$sheet->setCellValue('K18', "Lp");
		
		$sheet->setCellValue('L18', "Lk");
		$sheet->setCellValue('M18', "Lp");

		$sheet->setCellValue('N18', "Lk");
		$sheet->setCellValue('O18', "Lp");

		$numrow_a = 19;
		for ($i=1; $i <= 17; $i++) { 
			$sheet->setCellValue('A'.$numrow_a++, $i);
		}

		// Jumlah semua balita yang di timbang bulan ini mencapai umur 36 bulan
		$bayi_ditimbang = $this->db->query(
			"SELECT * FROM pengukuran as p
			LEFT JOIN bayi as b
			ON p.bayi_id = b.id
			WHERE b.posyandu_id = $posyandu_id"
		)->result_array();

		$balita_lebih_36bulan = [];
		foreach ($bayi_ditimbang as $key) {
			$tanggal_ukur = new DateTime($key["tanggal_ukur"]);
			$tanggal_lahir = new DateTime($key["tanggal_lahir"]);
			$interval = $tanggal_lahir->diff($tanggal_ukur);

			$umur = $interval->y*12+$interval->m;
			if ($umur >= 36) {
				$balita_lebih_36bulan[] = $key;
			}
		}

		// Jumlah semua balita yang ada di Posyandu bulan ini
		// Not implemented yet
		$s = $this->getJumlahPerStatus($posyandu_id, $date, '');
		$sheet->setCellValue('B19', "Jumlah semua balita yang ada di Posyandu bulan ini");
		$sheet->mergeCells('B19:G19');
		$sheet->setCellValue('H19', "(S)");
		$sheet->setCellValue('I19', ":");
		$sheet->setCellValue('J19', $s["l11"]);
		$sheet->setCellValue('K19', $s["l11"]);
		$sheet->setCellValue('L19', $s["l23"]);
		$sheet->setCellValue('M19', $s["l23"]);
		$sheet->setCellValue('N19', $s["l59"]);
		$sheet->setCellValue('O19', $s["l59"]);


		// Jumlah balita yang terdaftar dan mempunyai kms bulan ini
		// Not implemented yets
		$k = $this->getJumlahPerStatus($posyandu_id, $date, 'k');
		$sheet->setCellValue('B20', "Jumlah balita yang terdaftar dan mempunyai kms bulan ini");
		$sheet->mergeCells('B20:G20');
		$sheet->setCellValue('H20', "(K)");
		$sheet->setCellValue('I20', ":");
		$sheet->setCellValue('J20', $k["l11"]);
		$sheet->setCellValue('K20', $k["l11"]);
		$sheet->setCellValue('L20', $k["l23"]);
		$sheet->setCellValue('M20', $k["l23"]);
		$sheet->setCellValue('N20', $k["l59"]);
		$sheet->setCellValue('O20', $k["l59"]);


		// Jumlah balita yang naik berat badannya bulan ini
		$n = $this->getJumlahPerStatus($posyandu_id, $date, 'n');
		$sheet->setCellValue('B21', "Jumlah balita yang naik berat badannya bulan ini");
		$sheet->mergeCells('B21:G21');
		$sheet->setCellValue('H21', "(N)");
		$sheet->setCellValue('I21', ":");
		$sheet->setCellValue('J21', $n["l11"]);
		$sheet->setCellValue('K21', $n["l11"]);
		$sheet->setCellValue('L21', $n["l23"]);
		$sheet->setCellValue('M21', $n["l23"]);
		$sheet->setCellValue('N21', $n["l59"]);
		$sheet->setCellValue('O21', $n["l59"]);


		// Jumlah balita yang tidak naik berat badannya bulan ini
		$t = $this->getJumlahPerStatus($posyandu_id, $date, 't');
		$sheet->setCellValue('B22', "Jumlah balita yang tidak naik berat badannya bulan ini");
		$sheet->mergeCells('B22:G22');
		$sheet->setCellValue('H22', "(T)");
		$sheet->setCellValue('I22', ":");
		$sheet->setCellValue('J22', $t["l11"]);
		$sheet->setCellValue('K22', $t["l11"]);
		$sheet->setCellValue('L22', $t["l23"]);
		$sheet->setCellValue('M22', $t["l23"]);
		$sheet->setCellValue('N22', $t["l59"]);
		$sheet->setCellValue('O22', $t["l59"]);


		// Jumlah balita yang ditimbang bulan ini, tetapi tidak di timbang bulan lalu
		$o = $this->getJumlahPerStatus($posyandu_id, $date, 'o');
		$sheet->setCellValue('B23', "Jumlah balita yang ditimbang bulan ini, tetapi tidak di timbang bulan lalu");
		$sheet->mergeCells('B23:G23');
		$sheet->setCellValue('H23', "(O)");
		$sheet->setCellValue('I23', ":");
		$sheet->setCellValue('J23', $o["l11"]);
		$sheet->setCellValue('K23', $o["l11"]);
		$sheet->setCellValue('L23', $o["l23"]);
		$sheet->setCellValue('M23', $o["l23"]);
		$sheet->setCellValue('N23', $o["l59"]);
		$sheet->setCellValue('O23', $o["l59"]);


		// Jumlah balita yang pertama kali hadir di posyandu bulan ini
		$b = $this->getJumlahPerStatus($posyandu_id, $date, 'b');
		$sheet->setCellValue('B24', "Jumlah balita yang pertama kali hadir di posyandu bulan ini");
		$sheet->mergeCells('B24:G24');
		$sheet->setCellValue('H24', "(B)");
		$sheet->setCellValue('I24', ":");
		$sheet->setCellValue('J24', $b["l11"]);
		$sheet->setCellValue('K24', $b["l11"]);
		$sheet->setCellValue('L24', $b["l23"]);
		$sheet->setCellValue('M24', $b["l23"]);
		$sheet->setCellValue('N24', $b["l59"]);
		$sheet->setCellValue('O24', $b["l59"]);


		// Jumlah semua balita yang di timbang bulan ini
		// Not implemented yet
		$d = $this->getJumlahPerStatus($posyandu_id, $date, 'd');
		$sheet->setCellValue('B25', "Jumlah semua balita yang di timbang bulan ini");
		$sheet->mergeCells('B25:G25');
		$sheet->setCellValue('H25', "(D)");
		$sheet->setCellValue('I25', ":");
		$sheet->setCellValue('J24', $d["l11"]);
		$sheet->setCellValue('K24', $d["l11"]);
		$sheet->setCellValue('L24', $d["l23"]);
		$sheet->setCellValue('M24', $d["l23"]);
		$sheet->setCellValue('N24', $d["l59"]);
		$sheet->setCellValue('O24', $d["l59"]);

		$sheet->setCellValue('B26', "Jumlah semua balita yang di timbang bulan ini mencapai umur 36 bulan");
		$sheet->mergeCells('B26:G26');
		$sheet->setCellValue('I26', ":");
		$sheet->setCellValue('J26', count($balita_lebih_36bulan));

		$sheet->setCellValue('B27', "Jumlah semua balita yang di timbang bulan ini mencapai umur 36 bulan dengan berat 11.5Kg atau lebih");
		$sheet->mergeCells('B27:G27');
		$sheet->setCellValue('H27', "(L)");
		$sheet->setCellValue('I27', ":");

		$sheet->setCellValue('B28', "Jumlah semua balita yang tidak hadir di Posyandu bulan ini");
		$sheet->mergeCells('B28:G28');
		$sheet->setCellValue('I28', ":");

		$sheet->setCellValue('B29', "Jumlah semua balita yang ada di bawah garis merah");
		$sheet->mergeCells('B29:G29');
		$sheet->setCellValue('I29', ":");

		$sheet->setCellValue('B30', "Jumlah semua balita yang menerima vitamin A bulan ini");
		$sheet->mergeCells('B30:G30');
		$sheet->setCellValue('I30', ":");

		$sheet->setCellValue('B31', "Jumlah semua bayi 0-5 bulan");
		$sheet->mergeCells('B31:G31');
		$sheet->setCellValue('I31', ":");
		$sheet->setCellValue('J31', "Lk");
		$sheet->setCellValue('K31', ":".$this->getJumlah($posyandu_id)["l5"]);
		$sheet->setCellValue('L31', "Pr");
		$sheet->setCellValue('M31', ":".$this->getJumlah($posyandu_id)["p5"]);

		$sheet->setCellValue('B32', "Jumlah semua bayi 6 bulan");
		$sheet->mergeCells('B32:G32');
		$sheet->setCellValue('I32', ":");
		$sheet->setCellValue('J32', "Lk");
		$sheet->setCellValue('K32', ":".$this->getJumlah($posyandu_id)["l6"]);
		$sheet->setCellValue('L32', "Pr");
		$sheet->setCellValue('M32', ":".$this->getJumlah($posyandu_id)["p6"]);

		$sheet->setCellValue('B33', "Jumlah semua bayi ASI Ekslusif Proses (0-5 bulan)");
		$sheet->mergeCells('B33:G33');
		$sheet->setCellValue('I33', ":");
		$sheet->setCellValue('J33', "Lk");
		$sheet->setCellValue('K33', ":".$this->getJumlahAsi($posyandu_id)["l5"]);
		$sheet->setCellValue('L33', "Pr");
		$sheet->setCellValue('M33', ":".$this->getJumlahAsi($posyandu_id)["p5"]);

		$sheet->setCellValue('B34', "Jumlah semua bayi ASI Ekslusif Lulus (6 bulan)");
		$sheet->mergeCells('B34:G34');
		$sheet->setCellValue('I34', ":");
		$sheet->setCellValue('J34', "Lk");
		$sheet->setCellValue('K34', ":".$this->getJumlahAsi($posyandu_id)["l6"]);
		$sheet->setCellValue('L34', "Pr");
		$sheet->setCellValue('M34', ":".$this->getJumlahAsi($posyandu_id)["p6"]);

		$bayi_imd = $this->getJumlahImd($posyandu_id, $date);
		$sheet->setCellValue('B35', "Jumlah semua bayi lahir dengan Inisiasi Menyusui Dini (IMD)");
		$sheet->mergeCells('B35:G35');
		$sheet->setCellValue('I35', ":");
		$sheet->setCellValue('J35', "Lk");
		$sheet->setCellValue('K35', ":".$bayi_imd["l"]);
		$sheet->setCellValue('L35', "Pr");
		$sheet->setCellValue('M35', ":".$bayi_imd["p"]);

		// B. Laporan Balita dibawah -2SD sampai -3SD
		// $sheet->setCellValue('A37', "B.");
		// $sheet->getStyle('A37')->getFont()->setBold(true);
		// $sheet->setCellValue('B37', "Laporan Balita dibawah -2SD sampai -3SD");
		// $sheet->getStyle('B37')->getFont()->setBold(true);

		// $sheet->setCellValue('A38', "No");
		// $sheet->setCellValue('B38', "Nama Balita");
		// $sheet->setCellValue('C38', "Jenis Kelamin");
		// $sheet->setCellValue('D38', "Nama Orang Tua");
		// $sheet->setCellValue('E38', "Tgl Lahir");
		// $sheet->setCellValue('F38', "Usia");
		// $sheet->setCellValue('G38', "BB");
		// $sheet->setCellValue('H38', "TB");
		// $sheet->setCellValue('I38', "BBU");
		// $sheet->setCellValue('J38', "PBU");
		// $sheet->setCellValue('K38', "BBPB");

		// $numrow_b = 39;

		// Balita dibawah -2SD sampai -3SD
		// Not implemented yet
		// $bayi_b = $this->db->query(
		// 	"SELECT * FROM pengukuran as p
		// 	LEFT JOIN bayi as b
		// 	ON p.bayi_id = b.id
		// 	WHERE b.posyandu_id = $posyandu_id AND SUBSTRING(p.tanggal_ukur, 1, 7) = '$date'"
		// )->result();

		// foreach ($bayi_b as $i => $bayi) {
		// 	$sheet->setCellValue('A'.$numrow_b, $i+1);
		// 	$sheet->setCellValue('B'.$numrow_b, $bayi->nama);
		// 	$sheet->setCellValue('C'.$numrow_b, $bayi->jenis_kelamin);
		// 	$sheet->setCellValue('D'.$numrow_b, $bayi->nama_ibu);
		// 	$sheet->setCellValue('E'.$numrow_b, $bayi->tanggal_lahir);
		// 	$sheet->setCellValue('F'.$numrow_b, "Usia");
		// 	$sheet->setCellValue('G'.$numrow_b, "BB");
		// 	$sheet->setCellValue('H'.$numrow_b, "TB");
		// 	$sheet->setCellValue('I'.$numrow_b, "BBU");
		// 	$sheet->setCellValue('J'.$numrow_b, "PBU");
		// 	$sheet->setCellValue('K'.$numrow_b, "BBPB");
		// 	$numrow_b++;
		// }

		// C. Laporan Balita BGM (dibawah -3SD)
		// $sheet->setCellValue('A'.$numrow_b+2, "C.");
		// $sheet->getStyle('A'.$numrow_b+2)->getFont()->setBold(true);
		// $sheet->setCellValue('A'.$numrow_b+2, "Laporan Balita BGM (dibawah -3SD)");
		// $sheet->getStyle('A'.$numrow_b+2)->getFont()->setBold(true);

		// $sheet->setCellValue('A'.$numrow_b+3, "No");
		// $sheet->setCellValue('B'.$numrow_b+3, "Nama Balita");
		// $sheet->setCellValue('C'.$numrow_b+3, "Jenis Kelamin");
		// $sheet->setCellValue('D'.$numrow_b+3, "Nama Orang Tua");
		// $sheet->setCellValue('E'.$numrow_b+3, "Tgl Lahir");
		// $sheet->setCellValue('F'.$numrow_b+3, "Usia");
		// $sheet->setCellValue('G'.$numrow_b+3, "BB");
		// $sheet->setCellValue('H'.$numrow_b+3, "TB");
		// $sheet->setCellValue('I'.$numrow_b+3, "BBU");
		// $sheet->setCellValue('J'.$numrow_b+3, "PBU");
		// $sheet->setCellValue('K'.$numrow_b+3, "BBPB");

		// $numrow_c = $numrow_b+4;

		// Laporan Balita BGM (dibawah -3SD)
		// Not implemented yet
		// $bayi_c = $this->db->query(
		// 	"SELECT * FROM pengukuran as p
		// 	LEFT JOIN bayi as b
		// 	ON p.bayi_id = b.id
		// 	WHERE b.posyandu_id = $posyandu_id AND SUBSTRING(p.tanggal_ukur, 1, 7) = '$date'"
		// )->result();

		// foreach ($bayi_c as $i => $bayi) {
		// 	$sheet->setCellValue('A'.$numrow_c, $i+1);
		// 	$sheet->setCellValue('B'.$numrow_c, $bayi->nama);
		// 	$sheet->setCellValue('C'.$numrow_c, $bayi->jenis_kelamin);
		// 	$sheet->setCellValue('D'.$numrow_c, $bayi->nama_ibu);
		// 	$sheet->setCellValue('E'.$numrow_c, $bayi->tanggal_lahir);
		// 	$sheet->setCellValue('F'.$numrow_c, "Usia");
		// 	$sheet->setCellValue('G'.$numrow_c, "BB");
		// 	$sheet->setCellValue('H'.$numrow_c, "TB");
		// 	$sheet->setCellValue('I'.$numrow_c, "BBU");
		// 	$sheet->setCellValue('J'.$numrow_c, "PBU");
		// 	$sheet->setCellValue('K'.$numrow_c, "BBPB");
		// 	$numrow_c++;
		// }

		// D. Laporan Balita 2T
		// $sheet->setCellValue('A'.$numrow_c+2, "D.");
		// $sheet->getStyle('A'.$numrow_c+2)->getFont()->setBold(true);
		// $sheet->setCellValue('A'.$numrow_c+2, "Laporan Balita 2T");
		// $sheet->getStyle('A'.$numrow_c+2)->getFont()->setBold(true);

		// $sheet->setCellValue('A'.$numrow_c+3, "No");
		// $sheet->setCellValue('B'.$numrow_c+3, "Nama Balita");
		// $sheet->setCellValue('C'.$numrow_c+3, "Jenis Kelamin");
		// $sheet->setCellValue('D'.$numrow_c+3, "Nama Orang Tua");
		// $sheet->setCellValue('E'.$numrow_c+3, "Tgl Lahir");
		// $sheet->setCellValue('F'.$numrow_c+3, "Usia");
		// $sheet->setCellValue('G'.$numrow_c+3, "BB");
		// $sheet->setCellValue('H'.$numrow_c+3, "TB");

		// $numrow_d = $numrow_c+4;

		// Laporan Balita 2T
		// Not implemented yet
		// $bayi_d = $this->db->query(
		// 	"SELECT * FROM pengukuran as p
		// 	LEFT JOIN bayi as b
		// 	ON p.bayi_id = b.id
		// 	WHERE b.posyandu_id = $posyandu_id AND SUBSTRING(p.tanggal_ukur, 1, 7) = '$date'"
		// )->result();

		// foreach ($bayi_d as $i => $bayi) {
		// 	$sheet->setCellValue('A'.$numrow_d, $i+1);
		// 	$sheet->setCellValue('B'.$numrow_d, $bayi->nama);
		// 	$sheet->setCellValue('C'.$numrow_d, $bayi->jenis_kelamin);
		// 	$sheet->setCellValue('D'.$numrow_d, $bayi->nama_ibu);
		// 	$sheet->setCellValue('E'.$numrow_d, $bayi->tanggal_lahir);
		// 	$sheet->setCellValue('F'.$numrow_d, "Usia");
		// 	$sheet->setCellValue('G'.$numrow_d, "BB");
		// 	$sheet->setCellValue('H'.$numrow_d, "TB");
		// 	$numrow_d++;
		// }

		// Buat header tabel nya pada baris ke 3
		// $sheet->setCellValue('A4', "NO"); // Set kolom A4 dengan tulisan "NO"
		// $sheet->setCellValue('B4', "NIS"); // Set kolom B4 dengan tulisan "NIS"
		// $sheet->setCellValue('C4', "NAMA"); // Set kolom C4 dengan tulisan "NAMA"
		// $sheet->setCellValue('D4', "JENIS KELAMIN"); // Set kolom D4 dengan tulisan "JENIS KELAMIN"
		// $sheet->setCellValue('E4', "ALAMAT"); // Set kolom E4 dengan tulisan "ALAMAT"
		// Apply style header yang telah kita buat tadi ke masing-masing kolom header
		// $sheet->getStyle('A4')->applyFromArray($style_col);
		// $sheet->getStyle('B4')->applyFromArray($style_col);
		// $sheet->getStyle('C4')->applyFromArray($style_col);
		// $sheet->getStyle('D4')->applyFromArray($style_col);
		// $sheet->getStyle('E4')->applyFromArray($style_col);
		// Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
		$siswa = $this->db->get("bayi")->result();
		$no = 1; // Untuk penomoran tabel, di awal set dengan 1
		$numrow = 6; // Set baris pertama untuk isi tabel adalah baris ke 4

		$sheet->getRowDimension('1')->setRowHeight(25);
		// Set width kolom
		$sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
		$sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
		$sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
		$sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
		$sheet->getColumnDimension('E')->setWidth(30); // Set width kolom E
		
		// Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
		$sheet->getDefaultRowDimension()->setRowHeight(-1);
		// Set orientasi kertas jadi LANDSCAPE
		$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
		// Set judul file excel nya
		$sheet->setTitle("Laporan Posyandu");
		// die;
		// Proses file excel
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="Laporan Posyandu.xlsx"'); // Set nama file excel nya
		header('Cache-Control: max-age=0');
		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
	}
}
