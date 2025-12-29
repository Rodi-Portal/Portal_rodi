<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="<?= $this->session->userdata('lang') ?: 'es'; ?>">
<head>
  <meta charset="utf-8">
  <title><?= t('legal_page_title'); ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
  <style>
    .section-card { border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,.06); }
    h1,h2,h3 { scroll-margin-top: 80px; }
    .muted { color:#6c757d; }
    .ol-tight > li { margin-bottom:.5rem; }
    .plan-table th, .plan-table td { vertical-align: middle; }
  </style>
</head>
<body>

<div class="container my-4 my-md-5">

  <header class="mb-4">
    <h1 class="mb-1"><?= t('legal_terms_title'); ?></h1>
    <p class="muted mb-0">
      <?= t('legal_last_update'); ?>: <?= date('F Y'); ?>
    </p>
  </header>

  <!-- PLANES -->
  <div class="card section-card mb-4">
    <div class="card-body">
      <h2 class="h4"><?= t('legal_plans_modules'); ?></h2>
      <p class="mb-3"><?= t('legal_modules_desc'); ?></p>

      <div class="table-responsive">
        <table class="table table-bordered plan-table">
          <thead class="thead-light">
            <tr>
              <th><?= t('legal_table_plan'); ?></th>
              <th><?= t('legal_table_users'); ?></th>
              <th><?= t('legal_table_modules'); ?></th>
              <th><?= t('legal_table_price'); ?></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>Light</strong></td>
              <td>1</td>
              <td><?= t('legal_plan_light_modules'); ?></td>
              <td>USD $80 / <?= t('legal_month'); ?></td>
            </tr>
            <tr>
              <td><strong>Standard</strong></td>
              <td>5</td>
              <td><?= t('legal_plan_standard_modules'); ?></td>
              <td>USD $130 / <?= t('legal_month'); ?></td>
            </tr>
            <tr>
              <td><strong>Plus</strong></td>
              <td>5</td>
              <td><?= t('legal_plan_plus_modules'); ?></td>
              <td>USD $250 / <?= t('legal_month'); ?></td>
            </tr>
          </tbody>
        </table>
      </div>

      <p class="mb-0">
        <small class="muted"><?= t('legal_extra_users_note'); ?></small>
      </p>
    </div>
  </div>

  <!-- TERMINOS -->
  <div class="card section-card mb-5">
    <div class="card-body">

      <h2 class="h4"><?= t('legal_s1_title'); ?></h2>
      <ol class="ol-tight">
        <li><?= t('legal_s1_p1'); ?></li>
        <li><?= t('legal_s1_p2'); ?></li>
      </ol>

      <h2 class="h4 mt-4"><?= t('legal_s2_title'); ?></h2>
      <ol class="ol-tight" start="3">
        <li><?= t('legal_s2_p1'); ?></li>
        <li><?= t('legal_s2_p2'); ?></li>
      </ol>

      <h2 class="h4 mt-4"><?= t('legal_s3_title'); ?></h2>
      <ol class="ol-tight" start="5">
        <li><?= t('legal_s3_p1'); ?></li>
        <li><?= t('legal_s3_p2'); ?></li>
        <li><?= t('legal_s3_p3'); ?></li>
      </ol>

      <h2 class="h4 mt-4"><?= t('legal_s4_title'); ?></h2>
      <ol class="ol-tight" start="8">
        <li><?= t('legal_s4_p1'); ?></li>
        <li><?= t('legal_s4_p2'); ?></li>
      </ol>

      <h2 class="h4 mt-4"><?= t('legal_s5_title'); ?></h2>
      <ol class="ol-tight" start="10">
        <li><?= t('legal_s5_p1'); ?></li>
        <li><?= t('legal_s5_p2'); ?></li>
      </ol>

      <h2 class="h4 mt-4"><?= t('legal_s6_title'); ?></h2>
      <ol class="ol-tight" start="12">
        <li><?= t('legal_s6_p1'); ?></li>
        <li><?= t('legal_s6_p2'); ?></li>
        <li><?= t('legal_s6_p3'); ?></li>
      </ol>

      <h2 class="h4 mt-4"><?= t('legal_s7_title'); ?></h2>
      <ol class="ol-tight" start="15">
        <li><?= t('legal_s7_p1'); ?></li>
        <li><?= t('legal_s7_p2'); ?></li>
        <li><?= t('legal_s7_p3'); ?></li>
      </ol>

      <h2 class="h4 mt-4"><?= t('legal_s8_title'); ?></h2>
      <ol class="ol-tight" start="18">
        <li><?= t('legal_s8_p1'); ?></li>
      </ol>

      <h2 class="h4 mt-4"><?= t('legal_s9_title'); ?></h2>
      <ol class="ol-tight" start="19">
        <li><?= t('legal_s9_p1'); ?></li>
      </ol>

      <h2 class="h4 mt-4"><?= t('legal_s10_title'); ?></h2>
      <ol class="ol-tight" start="20">
        <li><?= t('legal_s10_p1'); ?></li>
      </ol>

      <div class="mt-4">
        <a href="<?= $terminos_url; ?>" class="btn btn-primary">
          <?= t('legal_download_terms'); ?>
        </a>
      </div>

    </div>
  </div>

  <!-- CONFIDENCIALIDAD -->
  <div class="card section-card mb-5">
    <div class="card-body">

      <h2 class="h4"><?= t('legal_conf_title'); ?></h2>
      <p><?= t('legal_conf_intro'); ?></p>

      <h3 class="h5 mt-3"><?= t('legal_conf_s1'); ?></h3>
      <p><?= t('legal_conf_s1_p'); ?></p>

      <h3 class="h5 mt-3"><?= t('legal_conf_s2'); ?></h3>
      <p><?= t('legal_conf_s2_p'); ?></p>

      <h3 class="h5 mt-3"><?= t('legal_conf_s3'); ?></h3>
      <p><?= t('legal_conf_s3_p'); ?></p>

      <h3 class="h5 mt-3"><?= t('legal_conf_s4'); ?></h3>
      <p><?= t('legal_conf_s4_p'); ?></p>

      <h3 class="h5 mt-3"><?= t('legal_conf_s5'); ?></h3>
      <p><?= t('legal_conf_s5_p'); ?></p>

      <h3 class="h5 mt-3"><?= t('legal_conf_s6'); ?></h3>
      <p><?= t('legal_conf_s6_p'); ?></p>

      <h3 class="h5 mt-3"><?= t('legal_conf_s7'); ?></h3>
      <p><?= t('legal_conf_s7_p'); ?></p>

      <div class="mt-4">
        <a href="<?= $confidencialidad_url; ?>" class="btn btn-outline-primary">
          <?= t('legal_download_confidentiality'); ?>
        </a>
      </div>

    </div>
  </div>

  <footer class="text-center muted">
    &copy; <?= date('Y'); ?> — <?= t('legal_footer'); ?>
  </footer>

</div>
</body>
</html>
