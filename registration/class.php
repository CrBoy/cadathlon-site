<?php
class TeamData
{
	private $db;
	public function __construct()
	{
		$this->db = new PDO('sqlite:teams.db');
	}

	public function add_team($team)
	{
		$sql = 'INSERT INTO teams(team_name, record, paper) VALUES(:team_name, :record, :paper)';
		$values = $team->_;

		$statement = $this->db->prepare($sql);
		$statement->execute($values);
		$statement->closeCursor();

		return $this->db->lastInsertId();
	}

	public function add_student($tid, $student)
	{
		$sql = 'INSERT INTO students(stu_name, school, grade, phone, email, address, tid) VALUES(:stu_name, :school, :grade, :phone, :email, :address, :tid)';
		$values = $student->_;
		$values['tid'] = $tid;

		$statement = $this->db->prepare($sql);
		$statement->execute($values);
		$statement->closeCursor();

		return $this->db->lastInsertId();
	}

	public function add_advisor($tid, $advisor)
	{
		$aid = $this->get_advisor_id($advisor);
		if($aid===false)
			$aid = $this->add_new_advisor($advisor);
		$this->advise($tid, $aid);
	}

	private function add_new_advisor($advisor)
	{
		$sql = 'INSERT INTO advisors(advisor_name, school) VALUES(:advisor_name, :school)';
		$values = $advisor->_;

		$statement = $this->db->prepare($sql);
		$statement->execute($values);
		$statement->closeCursor();

		return $this->db->lastInsertId();
	}

	private function get_advisor_id($advisor)
	{
		$sql = 'SELECT aid FROM advisors WHERE advisor_name=:advisor_name AND school=:school';
		$values = $advisor->_;

		$statement = $this->db->prepare($sql);
		$aid = false;
		if( $statement->execute($values) && ($r = $statement->fetch()) ){
			$aid = $r['aid'];
		}
		$statement->closeCursor();

		return $aid;
	}

	private function advise($tid, $aid)
	{
		$sql = 'INSERT INTO advise(tid, aid) VALUES(:tid, :aid)';
		$values = array('tid'=>$tid, 'aid'=>$aid);

		$statement = $this->db->prepare($sql);
		$statement->execute($values);
		$statement->closeCursor();
	}

	public function get_form_data($tid)
	{
		$form_data = array();
		$form_data['tid'] = $tid;

		$tid = $this->db->quote($tid);
		//$form_data['advisor1_name']     = '';
		//$form_data['advisor1_school']   = '';
		//$form_data['advisor2_name']     = '';
		//$form_data['advisor2_school']   = '';
		$form_data['student1_name']     = ' ';
		$form_data['student1_school']   = ' ';
		$form_data['student1_grade']   = ' ';
		$form_data['student1_phone']    = ' ';
		$form_data['student1_email']    = ' ';
		$form_data['student1_address']  = ' ';
		$form_data['student2_name']     = ' ';
		$form_data['student2_school']   = ' ';
		$form_data['student2_grade']   = ' ';
		$form_data['student2_phone']    = ' ';
		$form_data['student2_email']    = ' ';
		$form_data['student2_address']  = ' ';
		$form_data['advisors'] = '';


		$sql = 'SELECT team_name, record, paper FROM teams WHERE tid=' . $tid;
		$team_data = $this->db->query($sql)->fetch();
		$form_data['team_name']         = $team_data['team_name'];
		$form_data['record']            = $team_data['record'];
		$form_data['paper']             = $team_data['paper'];

		$sql = 'SELECT s.stu_name, s.school, s.grade, s.phone, s.email, s.address FROM teams t, students s WHERE t.tid='.$tid.' AND t.tid=s.tid';
		$stu_data = $this->db->query($sql);
		foreach($stu_data as $key=>$value){
			$snum = $key+1;
			$form_data['student'.$snum.'_name']     = $value['stu_name'];
			$form_data['student'.$snum.'_school']   = $value['school'] . '-' . $value['grade'];
			//$form_data['student'.$snum.'_grade']    = $value['grade'];
			$form_data['student'.$snum.'_phone']    = $value['phone'];
			$form_data['student'.$snum.'_email']    = $value['email'];
			$form_data['student'.$snum.'_address']  = $value['address'];
		}

		$sql = 'SELECT a.advisor_name, a.school FROM teams t, advisors a, advise l WHERE t.tid='.$tid.' AND t.tid=l.tid and l.aid=a.aid';
		$advisor_data = $this->db->query($sql);
		foreach($advisor_data as $key=>$value){
			$anum = $key+1;
			if($key>0)
				$form_data['advisors'] .= '、';
			$form_data['advisors'] .= $value['advisor_name'] . "（" . $value['school'] . "）";
			//$form_data['advisor'.$snum.'_name']     = $value['advisor_name'];
			//$form_data['advisor'.$snum.'_school']   = $value['school'];
		}

		return $form_data;
	}
}

class Team
{
	public $_ = array();
	public function __construct($team_name, $record, $paper)
	{
		$this->_ = array('team_name'=>$team_name, 'record'=>$record, 'paper'=>$paper);
	}
}
class Student
{
	public $_ = array();
	public function __construct($stu_name, $school, $grade, $phone, $email, $address)
	{
		$this->_['stu_name'] = $stu_name;
		$this->_['school'] = $school;
		$this->_['grade'] = $grade;
		$this->_['phone'] = $phone;
		$this->_['email'] = $email;
		$this->_['address'] = $address;
	}
	public function exists()
	{
		return ($this->_['stu_name']!='');
	}
}

class Advisor
{
	public $_ = array();
	public function __construct($advisor_name, $school)
	{
		$this->_['advisor_name'] = $advisor_name;
		$this->_['school'] = $school;
	}
	public function exists()
	{
		return ($this->_['advisor_name']!='' && $this->_['school']!='');
	}
}
?>
