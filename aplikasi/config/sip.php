<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['user_level'] = array (1 => 'mentor', 5 => 'pembinaan', 7 => 'administrator');
$config['default_user_level'] = 1;
$config['admin_view'] = "admin/";
$config['team_view'] = "bina/";
$config['fakultas'] = array(
                'fk' => 'Kedokteran',
                'fkg' => 'Kedokteran Gigi',
				'fmipa' => 'Matematika & Ilmu Pengetahuan Alam',
				'ft' => 'Teknik',
				'fh' => 'Hukum',
				'fe' => 'Ekonomi',
				'fib' => 'Ilmu Pengetahuan Budaya',
                'fpsi' => 'Psikologi',
				'fisip' => 'Ilmu Sosial & Ilmu Politik',
				'fkm' => 'Kesehatan Masyarakat',
				'fasilkom' => 'Ilmu Komputer',
				'fik' => 'Ilmu Keperawatan',
				'vok' => 'Vokasi'
           );

$config['public_view'] = 'wrapper';
/* End of file sip.php */
/* Location: ./aplikasi/config/sip.php */
?>
