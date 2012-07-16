<?php

require('class.php');

$data = new TeamData();
$team = new Team($_POST['team_name'], $_POST['record'], $_POST['paper']);
$student1 = new Student($_POST['student1_name'], $_POST['student1_school'], $_POST['student1_grade'], $_POST['student1_phone'], $_POST['student1_email'], $_POST['student1_address']);
$student2 = new Student($_POST['student2_name'], $_POST['student2_school'], $_POST['student2_grade'], $_POST['student2_phone'], $_POST['student2_email'], $_POST['student2_address']);
$advisor1 = new Advisor($_POST['advisor1_name'], $_POST['advisor1_school']);
$advisor2 = new Advisor($_POST['advisor2_name'], $_POST['advisor2_school']);

$tid = $data->add_team($team);
if($student1->exists())
	$data->add_student($tid, $student1);
if($student2->exists())
	$data->add_student($tid, $student2);
if($advisor1->exists())
	$data->add_advisor($tid, $advisor1);
if($advisor2->exists())
	$data->add_advisor($tid, $advisor2);

$form_data = $data->get_form_data($tid);

require('table.php');

echo <<<EOF
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title></title>
	<link href="reset.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="reset.css" media="print" rel="stylesheet" type="text/css" />
	<link href="form_print.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="form_print.css" media="print" rel="stylesheet" type="text/css" />
	<script type="text/javascript" charset="utf-8">
		function print_page(){ print(); }
	</script>
</head>
<body>

EOF;
echo gen_html($form_data);
echo <<<EOF
</body>
</html>

EOF;
?>
