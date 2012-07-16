<?php
function html_template()
{
	return <<<EOF
<div id="content">
	<h1>2012 年國際 ACM SIGDA CADathlon at ICCAD 競賽培訓選拔報名表</h1>
	<table>
	<tr>
		<td class="nested_table">
		<table class="inner_table">
			<tr>
				<td width="30%">報名編號：{:tid}</td>
				<td>隊名：{:team_name}</td>
			</tr>
		</table>
		</td>
	<tr><td class="nested_table">
		<table class="inner_table">
			<!--<tr><th width="15%"></th><th width="20%"></th><th width="25%"></th><th></th></tr>-->
			<tr>
				<td rowspan="2" width="15%">學生一</td>
					<td width="20%">{:student1_name}</td><td width="30%">{:student1_school}</td><td>{:student1_email}</td>
				</tr>
				<tr>
						<td>{:student1_phone}</td><td colspan="2">{:student1_address}</td>
			</tr>
			<tr>
				<td rowspan="2" width="15%">學生二</td>
					<td width="20%">{:student2_name}</td><td width="30%">{:student2_school}</td><td>{:student2_email}</td>
				</tr>
				<tr>
						<td>{:student2_phone}</td><td colspan="2">{:student2_address}</td>
			</tr>
			<tr>
				<td>指導教授</td>
				<td colspan="3">{:advisors}</td>
			</tr>
		</table>
	</td></tr>
	<tr class="multi_line">
		<td>相關競賽紀錄：<br>{:record}</td>
	</tr>
	<tr class="multi_line">
		<td>論文著述：<br>{:paper}</td>
	</tr>
	<tr>
		<td>
			請將下列文件附加於本報名表並於截止日期前以限時掛號郵寄至報名地址。<br>
			<ul>
				<li>所有參賽學生之大學(含)以上在校相關修課成績單
				<li>所有參賽學生之學生證正反面影本
			</ul>
		</td>
	</tr>
	<tr class="sign">
		<td>學生簽名</td>
	</tr>
	<tr>
		<td class="nested_table">
			<table class="inner_table">
				<tr class="sign">
					<td width="60%">指導教授簽章</td>
					<td>系所主任簽章</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
</div>

EOF;
}

function gen_html($form_data)
{
	$html = html_template();
	foreach($form_data as $key=>$value){
		$html = str_replace('{:'.$key.'}', nl2br(htmlspecialchars($value)), $html);
	}
	return $html;
}
?>
