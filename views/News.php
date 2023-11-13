<?php

namespace PHPMaker2023\new2023;

// Page object
$News = &$Page;
?>
<?php
$Page->showMessage();
?>
<!-- Begin of Timelime -->
<div class="row">
  <div class="col-md-12">
	<!-- The time line -->
	<div class="timeline">
	  <!-- timeline time label -->
	  <div class="time-label">
		<span class="bg-red">12 sd 15 Februari 2023</span>
	  </div>
	  <!-- /.timeline-label -->
	  <!-- timeline item -->
	  <div>
		<i class="fas fa-user bg-green"></i>
		<div class="timeline-item shadow-sm">
		  <h3 class="timeline-header">Upload Proposal</h3>
		  <div class="timeline-body">
			<p class="card-text">Informasi Lebih Lengkap pada pentunjuk berikut :.</p>
                  <a href="http://simpel.uncen.ac.id/panduan/Panduan Penelitian PNBP Tahun 2023.pdf" class="btn btn-primary" target="_blank" title="simpel uncen">Panduan Penelitian 2023</a>
		          <a href="http://simpel.uncen.ac.id/panduan/Panduan Pengabdian PNBP Tahun 2023.pdf" class="btn btn-primary" target="_blank" title="simpel uncen">Panduan Pengabdian 2023</a>
          </div>
		  <div class="timeline-footer"></div>
		</div>
	  </div>
	  <!-- END timeline item -->
	  <!-- timeline time label -->
	  <div class="time-label">
		<span class="bg-green">15 Februari 2023</span>
	  </div>
	  <!-- /.timeline-label -->
	  <!-- timeline item -->
	  <div>
		<i class="fa fa-camera bg-purple"></i>
		<div class="timeline-item shadow-sm">
		  <h3 class="timeline-header">Tawaran Penelitian</h3>
		  <div class="timeline-body">
			<p class="card-text">Silahkan Klik link dibawah ini untuk melihat tawaran penelitian dan Panduan aplikasi</p>
               <a href="http://simpel.uncen.ac.id/panduan/Tawaran Penelitian dan Pengabdian Kepada Masyarakat.pdf" class="btn btn-primary" target="_blank" title="simpel uncen">Tawaran Penelitian 2023</a>
               <a href="http://simpel.uncen.ac.id/panduan/petunjuk aplikasi simpel.pdf" class="btn btn-danger" target="_blank" title="simpel uncen">Panduan Penggunaan Aplikasi SIMPEL 2023</a>
		  </div>
		</div>
	  </div>
	  <!-- END timeline item -->
	  <div>
		<i class="fas fa-clock bg-gray"></i>
	  </div>
	</div>
  </div> <!-- /.col -->
</div> <!-- /.row -->
<!-- End of Timelime -->

<?php CurrentPage()->showMessage(); ?>

<?= GetDebugMessage() ?>
