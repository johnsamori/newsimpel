<?php

namespace PHPMaker2023\new2023;

// Page object
$Home = &$Page;
?>
<?php
$Page->showMessage();
?>
<div class="panel panel-default">
  <div class="panel-heading">Home</div>
  <div class="panel-body">
	<h2>Selamat Datang di Sistem Informasi Penelitian dan Pengabdian LPPM</h2>
	   <p>Aplikasi ini dibuat untuk membantu proses pendataan Penelitian & Pengabdian di LPPM </strong></a>.

  </div>
</div>

<div class="card">
	<div class="card-header">
	<?php if (CurrentLanguageID() == "id") { ?>
		<h5 class="m-0">Panduan</h5>
	<?php } else { ?>
		<h5 class="m-0">Guide</h5>
	<?php } ?>
	</div>
	<div class="card-body">
<?php if (CurrentLanguageID() == "id") { ?>

<h6>Untuk panduan, silahkan klik menu news berikut:</h6>
<h4>Langkah Penggunaan Aplikasi</h4>
<ol>
<li>Daftarkan akun anda dan aktivasi melalui notifikasi yang masuk ke email anda.</li>
<li>Pastikan nama sudah terdaftar pada menu master-->dosen</li>
<li>Input data kelompok penelitan atau pengabdian terdiri dari ketua dan anggota</li>
<li>Pilih Menu Proposal Penelitian atau Pengabdian untuk upload data proposal </li>
<li>Pilih Menu Laporan Penelitian atau Pengabdian untuk upload data Laporan </li>
<li>Format File untuk upload data Proposal dan Laporan adalah *.pdf dengan kapasitas Max 2 Mb </li>
<li>Ubahlah Password anda untuk keamanan data anda</li>
</ol>

<?php } else { ?>

<h6>Untuk panduan, silahkan klik menu news berikut:</h6>
<h4>Langkah Penggunaan Aplikasi</h4>
<ol>
<li>Daftarkan akun anda dan aktivasi melalui notifikasi yang masuk ke email anda.</li>
<li>Pastikan nama sudah terdaftar pada menu master-->dosen</li>
<li>Input data kelompok penelitan atau pengabdian terdiri dari ketua dan anggota</li>
<li>Pilih Menu Proposal Penelitian atau Pengabdian untuk upload data proposal </li>
<li>Format File untuk upload data Proposal dan Laporan adalah *.pdf dengan kapasitas Max 2 Mb</li>
<li>Ubahlah Password anda untuk keamanan data anda</li>
</ol>

<?php } ?>

	</div>
</div>

<?php
	CurrentPage()->ShowMessage();
?>




<?= GetDebugMessage() ?>
