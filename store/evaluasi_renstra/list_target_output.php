<?php 

require '../../boot.php';
require '../../session.php';

if (! isset($session) || $session->auth == "") {
    Common::Error(401, 'json');
} 

$req = Common::obj(Request::all());

$result = [[
    "id" => '',
    "id_indikator" => '',
    "unit_eselon_id" => '',
    "tahun" => '',
    "target_triwulan_1" => '',
    "target_triwulan_2" => '',
    "target_triwulan_3" => '',
    "target_triwulan_4" => '',
    "realisasi_triwulan_1" => '',
    "realisasi_triwulan_2" => '',
    "realisasi_triwulan_3" => '',
    "realisasi_triwulan_4" => ''
]];

$q = "SELECT
        b.id,
        b.id_indikator,
        b.unit_eselon_id,
        b.tahun,
        b.target_triwulan_1,
        b.target_triwulan_2,
        b.target_triwulan_3,
        b.target_triwulan_4,
        b.realisasi_triwulan_1,
        b.realisasi_triwulan_2,
        b.realisasi_triwulan_3,
        b.realisasi_triwulan_4,
        c.unit_organisasi,
        c.person
    FROM
    indikator_output_kegiatan AS a
    INNER JOIN target_indikator_output AS b ON b.id_indikator = a.id
    INNER JOIN unit_eselon c ON c.id = b.unit_eselon_id
    WHERE a.id = {$req->id} 
            AND b.tahun = {$session->tahun}";
// exit($q);
$qry = DB::query($q);

$result_db = $qry->fetchAll();

if (empty($result_db)) {
    echo json_encode($result);
    exit;
}

echo json_encode($result_db);

exit;